<?php

namespace backend\controllers;

use backend\models\AuthAssignment;
use backend\models\AuthItem;
use backend\models\SignupForm;
use Yii;
use backend\models\Admin;
use backend\models\AdminSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = 'shop';
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
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
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
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//        if(Yii::$app->user->can('[admin/create]')) {

            $model = new \backend\models\SignupForm();

            //展示创建表单时列出所有的角色供选择

            $auth = Yii::$app->authManager;

            $roles = AuthItem::find()->where(['type' => 1])->all();

            $role = [];

            foreach ($roles as $v) {
                $role[$v['name']] = $v['name'];
            }
            if ($model->load(Yii::$app->request->post())) {

                if ($user = $model->signup()) {
                    //判断是否又给这个管理员添加角色
                    //dd($user);
                    if ($user->role) {
                        $auth = Yii::$app->authManager;

                        $Role = $auth->getRole($model->role);

                        $auth->assign($Role, $user->id);
                    }
                    return $this->redirect(['view', 'id' => $user->id]);
                } else {

                    dd($model->errors);
                }

            } else {
                return $this->render('create', [
                    'model' => $model,
                    'role' => $role
                ]);
            }
//        }
//else{
//            throw new ForbiddenHttpException('对不起，您现在还没获此操作的权限');
//        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //取出所有的角色
        $roles = AuthItem::find()->where(['type' => 1])->all();

        $role = [];

        foreach ($roles as $v) {
            $role[$v['name']] = $v['name'];
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->password) {
                if ($model->password == $model->confirm_password) {
                    $model->setPassword($model->password);
                    $model->generateAuthKey();
                    //更新用户角色表
                    if(!$model->role){
                        AuthAssignment::where(['user_id'=>$model->id, 'item_name'=>$model->role])->delete();
                    }else{
                        //先删掉所有的记录，然后添加上
                        $assign = AuthAssignment::find()->where(['user_id'=>$model->id])->one();
                        $assign->delete();
                        $auth = Yii::$app->authManager;
                        $Role = $auth->getRole($model->role);
                        $auth->assign($Role, $model->id);
                    }
                    if($model->save()){


                        Yii::$app->getSession()->setFlash('success', '更新管理员成功');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }else{
                    Yii::$app->getSession()->setFlash('error', '更新管理员失败');
                    return $this->redirect(['site/update', 'id'=>$model->id]);
                }

            } else{
                //更新用户角色表
                //如果提交的role为空值，则需要将auth_assignment中对应的记录删掉
                if(!$model->role){
                  AuthAssignment::where(['user_id'=>$model->id, 'item_name'=>$model->role])->delete();
                }else{
                    //先删掉所有的记录，然后添加上
                    $assign = AuthAssignment::find()->where(['user_id'=>$model->id])->one();
                    $assign->delete();
                    $auth = Yii::$app->authManager;
                    $Role = $auth->getRole($model->role);
                    $auth->assign($Role, $model->id);
                }
                if($model->save()){
                    Yii::$app->getSession()->setFlash('success', '更新管理员成功');
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    Yii::$app->getSession()->setFlash('error', '更新管理员失败');
                    return $this->redirect(['site/update', 'id'=>$model->id]);
                }

            }
        }else {
                return $this->render('update', [
                    'model' => $model,
                    'role' => $role
                ]);
            }
    }
    /**
     * Deletes an existing Admin model.
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
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
