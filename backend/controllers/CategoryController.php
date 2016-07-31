<?php

namespace backend\controllers;

use Yii;
use backend\models\Category;
use backend\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{

    public $layout = 'shop';

    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();

        $cateData = (new Category())->getTree();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
        return $this->render('index1',compact('cateData'));
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Category();

        $cateData = $model->getTree();

        if( Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $model->attributes = Yii::$app->request->post();

           if($model->validate()){
               if($model->save()){

                   return $this->redirect(['view','id'=>$model->id]);
               }
           }else{
               dd($model->errors);
           }
        }else {
            return $this->render('create', [
                'model' => $model,
                'cateData' => $cateData
            ]);
        }
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $ids = $model->findChildren($id);


        $cateData = $model->getTree();

        $model->setScenario(Category::SCENARIOS_UPDATE);

        if (Yii::$app->request->isPost) {
            $model->attributes = Yii::$app->request->post();
            if(in_array($model->p_id, $ids)){
                Yii::$app->getSession()->setFlash('error','不能将将自己设为自己或自己子类的子类');
                return $this->redirect(['category/update', 'id'=>$id]);
            }


            if($model->save()){
                Yii::$app->getSession()->setFlash('success', '更新成功');
                 return $this->redirect(['view', 'id' => $model->id]);
            }else{
                Yii::$app->getSession()->setFlash('error', '更新失败');
                return $this->redirect(['category/update', 'id'=>$id]);
            }
        }
        else {
            return $this->render('update', [
                'model' => $model,
                'cateData' => $cateData
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
