<?php

namespace frontend\controllers;

use Yii;
use common\models\Credits;
use common\models\LedgerEntry;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



/**
 * LedgerentryController implements the CRUD actions for LedgerEntry model.
 */
class LoanspostedController extends Controller
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
        //print_r($customerid);exit;

       
        $company='kencom].[dbo].[KENCOM SACCO SOCIETY  LTD$';



        
//----------------------------------------/----------------------------------------------------------
                
                $sql=" SELECT B.[Loan Number],
B.[Client Code],
B.[Product Name],

B.[Loan Application Date],
B.[Loan Approval Date],
B.[Loans Status],

sum(A.Amount) Amount 
        ,
                 ( select   sum(C.Amount)  as outstanding_Interest
                            FROM [".$company."Detailed Cust_ Ledg_ Entry] C
                            join [".$company."Credits]BB    on BB.[Loan Number]=C.[Product Code] 

                            where C.[Posting Type] between 3 and 4 AND  C.[Customer No_]=B.[Client Code]
                            
                            group by BB.[Loan Number],BB.[Client Code],BB.[Product Name],BB.[Interest Rate],BB.[Loan Application Date],BB.[Loan Approval Date],BB.[Loans Status],C.[Product Code]
                            ) as INTEREST,
							
							( select   sum(CL.Amount) as outstanding_balance
                            FROM [".$company."Detailed Cust_ Ledg_ Entry] CL
                            join [".$company."Credits]BC    on BC.[Loan Number]=CL.[Product Code] 

                            where CL.[Posting Type] IN(1,2,3) AND  CL.[Customer No_]=BC.[Client Code]
                            
                            group by BC.[Loan Number],BC.[Client Code],BC.[Product Name],BC.[Interest Rate],BC.[Loan Application Date],BC.[Loan Approval Date],BC.[Loans Status],CL.[Product Code]
                            ) as Balance
 FROM [".$company."Detailed Cust_ Ledg_ Entry] A
 join [".$company."Credits] B on B.[Loan Number]=A.[Product Code] 
  where A.[Posting Type] between 1 and 2 
  AND A.[Customer No_]='$customerid'

                      
 group by B.[Loan Number],B.[Client Code],B.[Product Name],B.[Interest Rate],B.[Loan Application Date],B.[Loan Approval Date],B.[Loans Status], A.[Product Code]";

$sql2="
SELECT B.[Loan Number],B.[Loan Application Date],B.[Loan Approval Date],B.[Approved Amount],
B.[Client Code],B.[Client Name],B.[Product Name],

(SELECT SUM(DCL.Amount) FROM [".$company."Detailed Cust_ Ledg_ Entry]DCL
JOIN [".$company."Credits]BB ON DCL.[Product Code]=BB.[Loan Number]
WHERE DCL.[Posting Type] IN (1,2,3) AND DCL.[Customer No_]=BB.[Client Code]) AS Outstanding_Balance,

(SELECT SUM(DL.Amount) FROM [".$company."Detailed Cust_ Ledg_ Entry]DL
JOIN [".$company."Credits]BC ON DL.[Product Code]=BC.[Loan Number]
WHERE DL.[Posting Type] BETWEEN 3 AND 4 AND DL.[Customer No_]=BB.[Client Code]) AS Outstanding_Interest

FROM [dbo].[KENCOM SACCO SOCIETY  LTD$Credits]B WHERE B.[Loan Number]='A:000001:10:2015'"

            //$les=DetailedVendorLedgerEntry::findBySql($sql)->asArray();


            $connection = Yii::$app->getDb();
            //print_r($connection);exit;

            $command = $connection->createCommand($sql);

            $result = $command->queryAll();
            //print_r($result );exit;
            
            $summary = new SqlDataProvider([
                'sql' =>$sql, 
                'pagination' => [
                    'pageSize' => 100
                ],
            ]);
            
           // print_r($summary);exit;



        $dataProvider = new ActiveDataProvider([
            'query' => Credits::find()->where("[Client Code] = '$customerid'"),
            //->andwhere("[Posting Type] = 10"),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,'summary'=>$summary,
        ]);
    }



     public function actionVieww($id)
    {
        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $model= LedgerEntry::findbysql('SELECT [Product Code] from [KENCOM SACCO SOCIETY  LTD$Detailed Cust_ Ledg_ Entry] 
        where [Customer No_] = \''.$customerid.'\'')->one();
       //print_r($model);exit;
        $productcode=$model['Product Code'];
        //print_r($productcode);exit;
        
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
     
        
        $dataProviderloan = new ActiveDataProvider([
            'query' => LedgerEntry::find()
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] between 1 and 2"),


        ]);

        
       $balance=0;   
          
     
     $sql="SELECT [Posting Date],[Document No_],[Posting Type],[Product Code], [Debit Amount],[Credit Amount],Amount, 
           SUM(Amount) OVER(ORDER BY [Entry No_] ROWS UNBOUNDED PRECEDING) AS Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
          AND [Customer No_]='$customerid' AND [Product Code]= '$productcode'";

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

   

      
        return $this->render('vieww', [
            'dataProvider1' => $dataProvidercapital,
            'dataProvider2' =>$dataProviderdeposit,
            'dataProvider3' =>$dataProviderfees,
            'dataProvider4' =>$dataProviderchildren,
            'dataProvider5'=>$dataProviderloan,
            'summary'=>$summary,
            
            'model' =>$model,

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


      
        return $this->render('vieww', [
            'dataProvider1' => $dataProvidercapital,
            'dataProvider2' =>$dataProviderdeposit,
            'dataProvider3' =>$dataProviderfees,
            'dataProvider4' =>$dataProviderchildren,
            'summary'=>$summary,
            'summary2'=>$summary2,

        ]);
    }

    /**
     * Displays a single LedgerEntry model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {


         $sql="SELECT [Customer No_],  Amount 
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
        return $this->render('vieww', [
            'model' => $model,
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

        if (($model = LedgerEntry::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
