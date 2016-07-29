<?php

namespace backend\controllers;

use backend\models\AuthItemChild;
use backend\models\AuthItemForm;
use Yii;
use backend\models\AuthItem;
use backend\models\AuthItemSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AuthItemController extends Controller
{

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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItemForm();

        $auth = Yii::$app->authManager;

        $model->setScenario(AuthItemForm:: SCENARIOS_CREATE);
        //先获取所有的权限
        $permisions = AuthItem::find()->where(['type'=>2])->asArray()->all();


        $permision = array();

        foreach($permisions as $v){
            $permision[$v['name']] = $v['name'];
        }
        if ($model->load(Yii::$app->request->post()) ) {
            if($model->type==1){
                if($model->validate()){
                  //先将角色添加到数据库
                    $model->addItem($model->name);

                    //从数据表中获取到这个角色，然后将对应的权限赋给这个角色
                    //然后添加到角色权限表中
                    $role = $auth->getRole($model->name);

                    //要先将表单中提交的权限通过这个方法获取到，不然获取到的方法是没有名字的

                    $Permissions = [];
                    foreach ($model->child as $value) {
                        //Returns the named permission.
                        $Permissions[] = $auth->getPermission($value);
                    }

                    foreach($Permissions as $k=>$v){
                        $auth->addChild($role, $v);
                    }
                    return $this->redirect(['view', 'id'=>$model->name]);
                }
            }else{
                //添加权限的时候不能有其他权限
              if($model->child==null){
                  //创建一个权限
                  $per = $auth->createPermission($model->name);

                  $per->description = $model->description?:'创建[' . $model->name . ']权限';

                  $auth->add($per);
                  return $this->redirect(['view', 'id' => $model->name]);
              } else{
                  throw new ForbiddenHttpException('权限下面不能勾选权限');
              }
            }

        }



        return $this->render('create', [
                'model' => $model,
                'permision' => $permision
            ]);

    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $auth = Yii::$app->authManager;

        $model =  new AuthItemForm();

        //根据id找到对应的基本信息
        $model =  $model->getItem($id);


        //先读取到全部的权限
        $permissions = $auth->getPermissions();

        $Permission = array();

        foreach($permissions as $k=>$v){
            $Permission[$v->name] = $v->name;
        }

        //取出该角色下面所有的权限
        //运用多表关联
        $all_permissions = AuthItem::find()->where(['name'=>$model->name])->one();

        $role_permissions = $all_permissions->hasMany(AuthItemChild::className(),['parent'=>'name'])->asArray()->all();

        $allPers = [];
        foreach($role_permissions as $v){
            $allPers[] = $v['child'];
        }
        $model->child = $allPers;


        $model->scenarios(AuthItemForm::SCENARIOS_UPDATE);
        if ($model->load(Yii::$app->request->post())) {

            $model->child = $_POST['AuthItemForm']['child'];

            if($model->validate()){
                //先将auth_item中的name更新掉
                $model->updateItem($id);


                if($model->type==1){
                    //新增的数据
                    $newPermision = array_diff($model->child, $allPers);

                    if($newPermision) {
                        //插入新的权限数据
                        foreach($newPermision as $v){
                          $role = $auth->getRole($model->name);
                          $perm = $auth->getPermission($v);
                            $auth->addChild($role, $perm);
                        }
                    }

                    //删除的数据
                    $delPermision = array_diff($allPers, $model->child);
                    foreach($delPermision as $v){
                       $role = $auth->getRole($model->name);
                        $perm = $auth->getPermission($v);
                        $auth->removeChild($role, $perm);
                    }

                    //如果原来的数据没有动就不用管了
                }
                return $this->redirect(['view', 'id' => $model->name]);
            }

        }
            return $this->render('update', [
                'model' => $model,
                'permision' => $Permission
            ]);

    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = new AuthItemForm();

        $model->setScenario(AuthItemForm::SCENARIOS_DELETE);

        $model->name = Yii::$app->request->get('id');

        $res = $model->removeItem();

        if(!$res){
         return json_encode(['status'=>false, 'msg'=>'删除失败']);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
