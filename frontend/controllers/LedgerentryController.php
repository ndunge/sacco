<?php

namespace frontend\controllers;

use Yii;
use common\models\LedgerEntry;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



/**
 * LedgerentryController implements the CRUD actions for LedgerEntry model.
 */
class LedgerentryController extends Controller
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
     * Lists all LedgerEntry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company='kencom].[dbo].[KENCOM SACCO SOCIETY  LTD$';

        $sql3="SELECT [Customer No_],  sum(Amount) AS Share_capital
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] =10 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql3);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary3 = new SqlDataProvider([
                'sql' =>$sql3, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

          $sql4="SELECT [Customer No_],  sum(Amount) AS Deposit
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] =5 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql4);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary4 = new SqlDataProvider([
                'sql' =>$sql4, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

                 $sql4="SELECT [Customer No_],  sum(Amount) AS Deposit
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] =5 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql4);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary4 = new SqlDataProvider([
                'sql' =>$sql4, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

           $sql5="SELECT [Customer No_],  sum(Amount) AS school_fees
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] =12 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql5);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary5 = new SqlDataProvider([
                'sql' =>$sql5, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

        $sql6="SELECT [Customer No_],  sum(Amount) AS children
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] =13 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql6);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary6 = new SqlDataProvider([
                'sql' =>$sql6, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);
        
     
     $sql="SELECT [Customer No_],  sum(Amount) AS Loan_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary = new SqlDataProvider([
                'sql' =>$sql, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

       $sql2="SELECT [Customer No_],  sum(Amount) AS Interest_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql2);

            $result = $command->queryAll();
            //print_r($result );exit;
            
            $summary2 = new SqlDataProvider([
                'sql' =>$sql2, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);


      
        return $this->render('index', [
         
            'summary'=>$summary,
            'summary2'=>$summary2,
            'summary3'=>$summary3,
            'summary4'=>$summary4,
            'summary5'=>$summary5,
            'summary6'=>$summary6,

        ]);
    }

    /**
     * Displays a single LedgerEntry model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        // $model = $this->findModel($id);
        

         $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company='kencom].[dbo].[KENCOM SACCO SOCIETY  LTD$';
     
          $dataProvidercapital = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 10"),


        ]);

        $dataProviderdeposit  = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 5"),


        ]);
          $dataProviderfees  = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 12"),
        ]);
          $dataProviderchildren = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 13"),
        ]);
     
     $sql="SELECT [Customer No_],  sum(Amount) AS Loan_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary = new SqlDataProvider([
                'sql' =>$sql, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

       $sql2="SELECT [Customer No_],  sum(Amount) AS Interest_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql2);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary2 = new SqlDataProvider([
                'sql' =>$sql2, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);


      
        return $this->render('view', [
            'dataProvider1' =>$dataProvidercapital,
            'dataProvider2' =>$dataProviderdeposit,
            'dataProvider3' =>$dataProviderfees,
            'dataProvider4' =>$dataProviderchildren,
            'summary'=>$summary,
            'summary2'=>$summary2,
            

        ]);
    }

        public function actionChildren($id)
    {

        // $model = $this->findModel($id);
        

         $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company='kencom].[dbo].[KENCOM SACCO SOCIETY  LTD$';
     
          $dataProvidercapital = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 10"),


        ]);

        $dataProviderdeposit  = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 5"),


        ]);
          $dataProviderfees  = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 12"),
        ]);
          $dataProviderchildren = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 13"),
        ]);
     
     $sql="SELECT [Customer No_],  sum(Amount) AS Loan_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary = new SqlDataProvider([
                'sql' =>$sql, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

       $sql2="SELECT [Customer No_],  sum(Amount) AS Interest_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql2);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary2 = new SqlDataProvider([
                'sql' =>$sql2, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);


      
        return $this->render('children', [
            'dataProvider1' =>$dataProvidercapital,
            'dataProvider2' =>$dataProviderdeposit,
            'dataProvider3' =>$dataProviderfees,
            'dataProvider4' =>$dataProviderchildren,
            'summary'=>$summary,
            'summary2'=>$summary2,
            

        ]);
    }


      public function actionLoanbalance($id)
    {

        // $model = $this->findModel($id);
        

         $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company='kencom].[dbo].[KENCOM SACCO SOCIETY  LTD$';
        $dataProvidercapital = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 10"),


        ]);

        $dataProviderdeposit  = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 5"),


        ]);
          $dataProviderfees  = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 12"),
        ]);
          $dataProviderchildren = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 13"),
        ]);
        $dataProviderloans = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] between 1 and 2"),
        ]);
     
     $sql="SELECT [Customer No_],  sum(Amount) AS Loan_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary = new SqlDataProvider([
                'sql' =>$sql, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

       $sql2="SELECT [Customer No_],  sum(Amount) AS Interest_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql2);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary2 = new SqlDataProvider([
                'sql' =>$sql2, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);


      
        return $this->render('loans', [
            'dataProvider1' => $dataProvidercapital,
            'dataProvider2' =>$dataProviderdeposit,
            'dataProvider3' =>$dataProviderfees,
            'dataProvider4' =>$dataProviderchildren,
            'dataProvider5' =>$dataProviderloans,
            'summary'=>$summary,
            'summary2'=>$summary2,

        ]);
    }

     public function actionInterestbalance($id)
    {

        // $model = $this->findModel($id);
        

         $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company='kencom].[dbo].[KENCOM SACCO SOCIETY  LTD$';
        $dataProvidercapital = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 10"),


        ]);

        $dataProviderdeposit  = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 5"),


        ]);
          $dataProviderfees  = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 12"),
        ]);
          $dataProviderchildren = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 13"),
        ]);
        $dataProviderloans = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] between 1 and 2"),
        ]);
        $dataProviderinterests = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] between 3 and 4"),
        ]);
     
     
     $sql="SELECT [Customer No_],  sum(Amount) AS Loan_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary = new SqlDataProvider([
                'sql' =>$sql, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

       $sql2="SELECT [Customer No_],  sum(Amount) AS Interest_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql2);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary2 = new SqlDataProvider([
                'sql' =>$sql2, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);


      
        return $this->render('interests', [
            'dataProvider1' => $dataProvidercapital,
            'dataProvider2' =>$dataProviderdeposit,
            'dataProvider3' =>$dataProviderfees,
            'dataProvider4' =>$dataProviderchildren,
            'dataProvider5' =>$dataProviderloans,
            'dataProvider6' =>$dataProviderinterests,
            'summary'=>$summary,
            'summary2'=>$summary2,

        ]);
    }


        public function actionDeposit($id)
    {

        // $model = $this->findModel($id);
        

         $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company='Sacco].[dbo].[TRAINED DB$';
        $dataProvidercapital = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 10"),


        ]);

        $dataProviderdeposit  = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 5"),


        ]);
          $dataProviderfees  = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 12"),
        ]);
          $dataProviderchildren = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 13"),
        ]);
     
     $sql="SELECT [Customer No_],  sum(Amount) AS Loan_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary = new SqlDataProvider([
                'sql' =>$sql, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

       $sql2="SELECT [Customer No_],  sum(Amount) AS Interest_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql2);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary2 = new SqlDataProvider([
                'sql' =>$sql2, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);


      
        return $this->render('view1', [
            'dataProvider1' => $dataProvidercapital,
            'dataProvider2' =>$dataProviderdeposit,
            'dataProvider3' =>$dataProviderfees,
            'dataProvider4' =>$dataProviderchildren,
            'summary'=>$summary,
            'summary2'=>$summary2,

        ]);
    }

    public function actionFees($id)
    {

        // $model = $this->findModel($id);
        

         $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company='Sacco].[dbo].[TRAINED DB$';

        $dataProvidercapital = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 10"),


        ]);

         $dataProviderdeposit  = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 5"),


        ]);

            $dataProviderfees  = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 12"),
        ]);

        
         $dataProviderchildren = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 13"),
        ]);
     
        
        $dataProviderloan = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] between 1 and 2"),


        ]);

        
          
          
     
     $sql="SELECT [Customer No_],  sum(Amount) AS Loan_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary = new SqlDataProvider([
                'sql' =>$sql, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

       $sql2="SELECT [Customer No_],  sum(Amount) AS Interest_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql2);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary2 = new SqlDataProvider([
                'sql' =>$sql2, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);


      
        return $this->render('fees', [
            'dataProvider1' => $dataProvidercapital,
            'dataProvider2' =>$dataProviderdeposit,
            'dataProvider3' =>$dataProviderfees,
            'dataProvider4' =>$dataProviderchildren,
            'dataProvider5'=>$dataProviderloan,
            'summary2'=>$summary2,

        ]);
    }

     public function actionVieww($id)
    {

        // $model = $this->findModel($id);
        

         $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company='Sacco].[dbo].[TRAINED DB$';

        $dataProvidercapital = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 10"),


        ]);

         $dataProviderdeposit  = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 5"),


        ]);

            $dataProviderfees  = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 12"),
        ]);

        
         $dataProviderchildren = new ActiveDataProvider([
            'query' => LedgerEntry::find()->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] = 13"),
        ]);
     
        
        $dataProviderloan = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] between 1 and 2"),


        ]);

        
          
          
     
     $sql="SELECT [Customer No_],  sum(Amount) AS Loan_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary = new SqlDataProvider([
                'sql' =>$sql, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);

       $sql2="SELECT [Customer No_],  sum(Amount) AS Interest_Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
          AND [Customer No_]='$customerid' group by [Customer No_] ";

           $connection = Yii::$app->getDb();

            $command = $connection->createCommand($sql2);

            $result = $command->queryAll();
            // print_r($result );exit;
            
            $summary2 = new SqlDataProvider([
                'sql' =>$sql2, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);


      
        return $this->render('vieww', [
            'dataProvider1' => $dataProvidercapital,
            'dataProvider2' =>$dataProviderdeposit,
            'dataProvider3' =>$dataProviderfees,
            'dataProvider4' =>$dataProviderchildren,
            'dataProvider5'=>$dataProviderloan,
            'summary2'=>$summary2,

        ]);
    }

    /**
     * Creates a new LedgerEntry model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LedgerEntry();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model['Customer No_']]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LedgerEntry model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model['Customer No_']]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing LedgerEntry model.
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
     * Finds the LedgerEntry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LedgerEntry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
         $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;


        if ($model = LedgerEntry::find()->where("[Customer No_] = '$customerid'")) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
