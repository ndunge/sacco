<?php

namespace frontend\controllers;

use Yii;
use common\models\SupportCRM;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerelationshipController implements the CRUD actions for Customerelationship model.
 */
class SupportController extends Controller
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
     * Lists all Customerelationship models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SupportCRM::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SupportCRM model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionReview($id)
    {
        return $this->render('review', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SupportCRM model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
       
        $model = new SupportCRM(); 
        $params = Yii::$app->request->post();

        if (!empty($params)) {     
            $model['CustomerID'] = $params['CustomerID'];
            $model['CategoryID'] = $params['CategoryID'];
            $model['Description'] = $params['Description'];
            $model['Suggestion'] = $params['Suggestion'];
            $model['Status'] = 'Open';

            if ($model->save()) return $this->redirect(['view', 'id' => $model->CaseID]);
        }

        else {
            $model['Status'] = 'Open';

        return $this->render('create', [ 'model' => $model ]);
    }
}

    /**
     * Updates an existing SupportCRM model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        

        

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model['CaseID']]);
        } else {
            return $this->render('update', [
                'model' => $model,
                
            ]);
        }


}

    /**
     * Deletes an existing SupportCRM model.
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
     * Finds the SupportCRM model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SupportCRM the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        // print_r( $SupportCRM::findOne($id) ); exit;
        if (($model = SupportCRM::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
