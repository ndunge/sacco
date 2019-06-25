<?php

namespace frontend\controllers;

use common\models\Custledgerentry;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AccountstatementController implements the CRUD actions for Custledgerentry model.
 */
class AccountstatementController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Custledgerentry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $CustomerID = Yii::$app->user->identity->CustomerID;
        // $CustomerID = '2008/0036';

        $sql = "SELECT CONVERT(char(10), Details.[Posting Date],126) Date, Details.[Document No_], Entry1.[Document Type], Entry1.[Description], Details.Amount
                FROM [CUEA\$Detailed Cust_ Ledg_ Entry] Details
                JOIN [CUEA\$Cust_ Ledger Entry] Entry1 ON Entry1.[Entry No_] = Details.[Cust_ Ledger Entry No_]
                WHERE Entry1.[Customer No_] = '$CustomerID'";

        $query = Custledgerentry::findBySql($sql)->asArray()->all();
		
		//print_r($query);exit;
		
 
        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
            'sort' => false,
			'pagination' => ['pageSize' => sizeof($query)]
        ]);
		
		

        return $this->render('index', [
            'dataProvider' => $dataProvider,
			
        ]);
    }

    /**
     * Displays a single Custledgerentry model.
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
     * Finds the Custledgerentry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Custledgerentry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Custledgerentry::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
