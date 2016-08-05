<?php

namespace backend\controllers;

use backend\models\Category;
use backend\models\GoodsAttr;
use backend\models\GoodsPics;
use backend\models\MemberLevel;
use backend\models\MemberPrice;
use backend\models\Type;
use Yii;
use backend\models\Goods;
use backend\models\GoodsSearch;
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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

        $goods_pic_model = new GoodsPics();

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
        $goods_attr_data = (new GoodsAttr())->get_goods_attr($id);

        dd($goods_attr_data);
        //取出商品图片和略缩图
        $goods_pics = (new GoodsPics())->get_goods_pics($id);



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', compact('model', 'member_price', 'goods_attr_data', 'goods_pics', 'cateData', 'typeData', 'member_data', 'goods_pic_model'));
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
}
