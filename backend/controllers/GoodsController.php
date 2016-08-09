<?php

namespace backend\controllers;

use backend\models\Attribute;
use backend\models\Category;
use backend\models\GoodsAttr;
use backend\models\GoodsNumber;
use backend\models\GoodsPics;
use backend\models\MemberLevel;
use backend\models\MemberPrice;
use backend\models\Type;
use Yii;
use backend\models\Goods;
use backend\models\GoodsSearch;
use yii\caching\DbDependency;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{

    public $enableCsrfValidation = false;
    public $layout = 'shop';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();

        $params = Yii::$app->request->queryParams;

        $params['GoodsSearch']['promote_start_time'] = isset($params['GoodsSearch']['promote_start_time'])?$params['GoodsSearch']['promote_start_time']:'';

        $params['GoodsSearch']['promote_end_time'] = isset($params['GoodsSearch']['promote_end_time'])?$params['GoodsSearch']['promote_end_time']:'';

        if($params['GoodsSearch']['promote_start_time']){
            $params['GoodsSearch']['promote_start_time'] = strtotime($params['GoodsSearch']['promote_start_time']);
        }
        if($params['GoodsSearch']['promote_end_time']){
            $params['GoodsSearch']['promote_end_time'] = strtotime($params['GoodsSearch']['promote_end_time']);
        }
        $dataProvider = $searchModel->search($params);

        $count = $dataProvider->getCount();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();

        $member_model = new MemberLevel();

        $member_price_model = new MemberPrice();

        $goods_pic_model = new GoodsPics();
        //取出所有的分类数据
        $cateData = (new Category())->getTree();

        //取出所有的会员数据
        $member_data = $member_model->find()->asArray()->all();

        //取出所有的类型数据
        $typeData = Type::find()->asArray()->all();
        if (Yii::$app->request->isPost) {

            $model->attributes = $_POST['Goods'];
            if(isset($_POST['Goods']['promote_start_time']) && isset($_POST['Goods']['promote_end_time'])){
                $model->promote_start_time = strtotime($_POST['Goods']['promote_start_time']);
                $model->promote_end_time = strtotime($_POST['Goods']['promote_end_time']);
            }

            $model->addtime = time();

            $file = \yii\web\UploadedFile::getInstance($model, 'logo');

            $image = uploadFile($model, [[120, 120]], $file);

            $model->logo = $image[0];

            $model->sm_logo = $image[1];

            //接收多张图片
            $files = UploadedFile::getInstances($goods_pic_model, 'pic');

//            if($model->validate()){

               if($model->save()){
                   //进行其它表的操作
                   /************操作会员表***********/
                   $member_price_model->add_member_price($_POST['member_price'], $model->id);

                   /***********操作商品属性表*********/
                   $goods_attr_data = $_POST['ga'];

                   $goods_attr_price = $_POST['gp'];

                   (new GoodsAttr())->add_goods_attr($goods_attr_data, $goods_attr_price, $model->id);

                   /***********操作商品图片表***********/
                   (new GoodsPics())->add_goods_pic($files, $goods_pic_model, $model->id);


               }else{
                   Yii::$app->getSession()->setFlash('error', '插入商品表失败');
                   return $this->redirect(['goods/create']);
               }

//
//            }else{
//                dd($model->errors);
//            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'member_model' => $member_model,
                'goods_pic_model' => $goods_pic_model,
                'cateData' => $cateData,
                'member_data' => $member_data,
                'typeData' => $typeData
            ]);
        }
    }

    /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        $logo = $model->logo;

        $sm_logo = $model->sm_logo;


        $goods_pic_model = new GoodsPics();

        $goods_attr_model = new GoodsAttr();

        $member_model = new MemberLevel();
        //取出所有的分类数据
        $cateData = (new Category())->getTree();

        //取出所有的会员数据
        $member_data = $member_model->find()->asArray()->all();

        //取出所有的类型数据
        $typeData = Type::find()->asArray()->all();

        //取出会员价格信息
        //@return array
        $member_price = (new MemberPrice())->get_member_price($id);

        //取出商品属性及其价格
        $goods_attr_data = $goods_attr_model->get_goods_attr($id);

        $old_goods_attr_ids = array_keys($goods_attr_data);


        //取出商品对应的类型所对应的属性数据
        $attributeData = (new Type())->getTypeAttributeData($model->type_id);

        //判断是否有新增的属性,获取所有的属性数据（id）
        $goods_attr_ids = Attribute::find()->select('id')->where(['=', 'type_id', $model->type_id])->asArray()->all();


        $new_goods_attr_ids = [];

        foreach($goods_attr_ids as $k=>$v){

            $new_goods_attr_ids[] = $v['id'];
        }

        //如果有数据则代表新增加了属性，将新属性在更新页面也展示出来
        $add_goods_attr_ids = array_diff($new_goods_attr_ids, $old_goods_attr_ids);


        //取出对应的数据
        if($add_goods_attr_ids){
            $add_goods_attr_data = (new Attribute())->findAddGoodsAttrData($add_goods_attr_ids);
        }




        //取出商品图片和略缩图
        $goods_pics = (new GoodsPics())->get_goods_pics($id);

        if (Yii::$app->request->isPost) {
            //将商品基本信息的数据赋值给goods模型
            $model->attributes = $_POST['Goods'];

             //判断用户是否更新了logo,如果更新了的话就将原来的logo删掉
            $file = \yii\web\UploadedFile::getInstance($model, 'logo');

            //如果不为空则表示用户修改了logo
            if(!is_null($file)){
                //将原来的logo删掉
                deleteImage([$logo, $sm_logo]);

                $image = uploadFile($model, [[120, 120]], $file);

                $model->logo = $image[0];

                $model->sm_logo = $image[1];
            }

            //判断用户是否将产品修改为促销,是的话将促销时间进行修改
            if(isset($_POST['Goods']['promote_start_time']) && isset($_POST['Goods']['promote_end_time'])){
                $model->promote_start_time = strtotime($_POST['Goods']['promote_start_time']);
                $model->promote_end_time = strtotime($_POST['Goods']['promote_end_time']);
            }

            $res = $model->save();
            if(!$res){
                dd('修改商品失败');
            }
            //商品属性的修改
            //判断是否有删除属性
            $old_attr_id = array_keys($_POST['old_ga']);

            $old_attr_ids = $goods_attr_model->getGoodsAttrIds($id);

            $ids = [];

            foreach($old_attr_ids as $k=>$v){
              $ids[] = $v['id'];
            }

            $delete_old_ids = array_diff($ids, $old_attr_id);

            if($delete_old_ids){
                $goods_attr_model->deleteGoodsAttrIds($delete_old_ids);
            }


            //如果有要修改的数据,就是以old开头的
            $old_gas = $_POST['old_ga'];
            $old_gps = $_POST['old_gp'];
            if($old_gas && $old_gps) {
                $goods_attr_model->updateGoodsAttr($old_gas, $old_gps, $id);
            }

            //如果有新增的数据,就将其存在数据库里
            $new_gas = isset($_POST['new_ga'])?$_POST['new_ga']:'';
            $new_gps = isset($_POST['new_gp'])?$_POST['new_gp']:'';
            if($new_gas && $new_gps){
               $goods_attr_model->add_goods_attr($new_gas, $new_gps, $id);
            }


            //判断是否有新添加的其它属性,然后将其放入数据库中
            $goods_attr_data = isset($_POST['ga'])?$_POST['ga']:'';

            $goods_attr_price = isset($_POST['gp'])?$_POST['gp']:'';

            if($goods_attr_data && $goods_attr_price) {
                (new GoodsAttr())->add_goods_attr($goods_attr_data, $goods_attr_price, $model->id);
            }
            //添加新的商品图片
            //接收多张图片
            $files = UploadedFile::getInstances($goods_pic_model, 'pic');
            if(!is_null($files)){
                (new GoodsPics())->add_goods_pic($files, $goods_pic_model, $id);
            }

             return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', compact('add_goods_attr_data','id', 'model', 'member_price', 'goods_attr_data', 'goods_pics', 'cateData', 'typeData', 'member_data', 'goods_pic_model', 'attributeData'));
        }
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        //删除掉商品的logo和sm_logo
        (new Goods())->deleteGoodsLogo($id);
        //删除掉商品图片的数据
        (new GoodsPics())->deleteGoodsPics($id);

        //删除掉商品属性数据
        (new GoodsAttr())->deleteGoodsAttrs($id);

        //删除商品的会员信息
        (new MemberPrice())->deleteGoodsMemberPirce($id);

        return $this->redirect(['index']);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAjaxGetTypeAttribute($type_id){
        //根据类型id取出所有的属性数据
        $query = new Query();
        $AttributeData = $query->select('*')->from('attribute')->where('type_id=:type_id',[':type_id'=>$type_id])->all();
        //dd($AttributeData);
        if($AttributeData){
            return json_encode([
                'status' => 1,
                'data' => $AttributeData
            ]);
        }
    }


    public function actionAjaxDeleteGoodsPics($id){
        //将商品的该图片从硬盘中删掉

        $query = new Query();

        $images = $query->select('a.pic, a.sm_pic')->from('goods_pics a')->where('id=:id',[':id'=>$id])->one();

        deleteImage([$images['pic'], $images['sm_pic']]);
        //从数据库中将商品删除
        $imagemodel = GoodsPics::findOne($id);


        $con = Yii::$app->db;

        $sql = "DELETE FROM `goods_pics` WHERE id=$id";

        $res = $con->createCommand($sql)->execute();

        return json_encode(['status'=> 1]);
    }

    public function actionKucun($id){
        //取出该商品的可选属性
        $query = new Query();
        $attr_data = $query->select('a.id,a.attr_value value, a.attr_id, b.attr_name')->from('goods_attr a')->leftJoin('attribute b', 'a.attr_id=b.id')->where(['a.goods_id'=>$id, 'b.attr_type'=>'1'])->all();

        $data = [];
        foreach($attr_data as $k=>$v){
            $data[$v['attr_id']][] =$v;
        }

        //dd($data);
        if(Yii::$app->request->isPost){

            //先将原来的数据全部删除
            (new GoodsNumber())->deleteGoodsNumber($id);
            //判断是有几组
            $number = count($_POST['ga'])/count($_POST['goods_number']);
            static $k = 0;
            $goods_attrs = array();
            for($j=0; $j<count($_POST['goods_number']);$j++){
            for($i=0; $i<$number; $i++){

              $goods_attrs[$j][] = $_POST['ga'][$k];
                $k++;
            }
            }
            $goods_attr_ids = [];

           foreach($goods_attrs as $k=>$v){
               asort($v);
               $goods_attr_ids[] = implode(',', $v);
           }

            $con = Yii::$app->db;
            if($goods_attr_ids){
            foreach($goods_attr_ids as $k=>$v){
                if($v==',,'){
                    continue;
                }

                $sql = "INSERT INTO `goods_number` values(null, $id, '{$v}', '{$_POST['goods_number'][$k]}')";

                $con->createCommand($sql)->execute();
            }
            }

            return $this->redirect(['goods/index']);
        }
        //取出原有的商品库存数据
        $goods_number_data = GoodsNumber::find()->where('goods_id=:goods_id', [':goods_id'=>$id])->asArray()->all();



        return $this->render('kucun', compact('data', 'goods_number_data'));
    }
}
