<?php

namespace frontend\controllers;

use Yii;
use common\models\Contact;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerelationshipController implements the CRUD actions for Customerelationship model.
 */
class ContactController extends Controller
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
        // print_r('ici'); exit; 
        $dataProvider = new ActiveDataProvider([
            'query' => Contact::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customerelationship model.
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
     * Creates a new Customerelationship model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
       
        $model = new Contact();
         $nexContactNo = str_pad(
            substr(
                implode("", 
                    Contact::find()->select(['TOP 1 [No_]'])->orderBy(['[No_]' => SORT_DESC ])->asArray()->one()
                ),
            3
            ) + 1,
            3, '0', STR_PAD_LEFT
        ); 
         print_r($nexContactNo);exit;
        $params = Yii::$app->request->post();
        $baseUrl = Yii::$app->request->baseUrl;
//         $identity = Yii::$app->user->identity;
//            if (empty($identity))
// {
//     Yii::$app->getResponse()->redirect($baseUrl.'/site/index');
// }
// $ProfileID = $identity->ProfileID;
// $customerid=$identity->Userid;

        if (!empty($params)) { 
        //print_r($params);exit;    
            $model['CustomerID'] = $params['CustomerID'];
            $model['CategoryID'] = $params['CategoryID'];
            $model['Title'] = $params['Title'];
            $model['Description'] = $params['Description'];
            $model['Suggestion'] = 'SUGGESTION';
            $model['Status'] = 'Open';

            if ($model->save()) return $this->redirect(['view', 'id' => $model->CaseID]);
        }

        else {
            $model['Status'] = 'Open';

        return $this->render('create', [ 'model' => $model ]);
    }
}

    /**
     * Updates an existing Customerelationship model.
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
     * Deletes an existing Customerelationship model.
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
     * Finds the Customerelationship model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Customerelationship the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        // print_r( $Customerelationship::findOne($id) ); exit;
        if (($model = Customerelationship::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
