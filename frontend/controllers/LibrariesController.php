<?php

namespace frontend\controllers;

use Yii;
use common\models\Libraries;
use common\models\FAClasses;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LibrariesController implements the CRUD actions for Libraries model.
 */
class LibrariesController extends Controller
{
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
     * Lists all Libraries models.
     * @return mixed
     */
    public function actionIndex()
     {
        $dataProvider = new ActiveDataProvider([
            'query' => Libraries::find()->where("[FA Class Code] = 'LIB'")
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Libraries model.
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
     * Creates a new Libraries model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Libraries();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->No_]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

     public function actiongetlibrary()
    {
        $lib='LIB';
        $sql=Yii::app()->db->createCommand('SELECT * FROM [CUEA$FA Class ] WHERE Code='.$lib)->queryall();
                
                $dataProvider=new CSqlDataProvider($sql);
                
                return $dataProvider->getData(); /*will return a list of arrays.*/
    }

    /**
     * Updates an existing Libraries model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->No_]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Libraries model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Libraries model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Libraries the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Libraries::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
