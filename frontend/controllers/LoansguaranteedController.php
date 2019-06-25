<?php

namespace frontend\controllers;

use Yii;
use common\models\Loanapplications;
use common\models\Credittype;
use yii\data\SqlDataProvider;
use common\models\Customers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;



/**
 * LoanapplicationsController implements the CRUD actions for Loanapplications model.
 */
class LoansguaranteedsController extends Controller
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
     * Lists all Loanapplications models.
     * @return mixed
     */
    public function actionIndex()
    {
        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
         $company='Sacco].[dbo].[TRAINED DB$';


        

                
                $company='Sacco].[dbo].[TRAINED DB$';


        

                
                $sql=" SELECT B.[Loan Number],
B.[Client Code],
B.[Product Name],
B.[Interest Rate],
B.[Loan Application Date],
B.[Loan Approval Date],
B.[Loans Status],

sum(A.Amount) Amount 
        ,
                 ( select   sum(C.Amount)  as outstanding_Interest
                            FROM [".$company."Detailed Cust_ Ledg_ Entry] C
                            join [".$company."Credits]BB    on BB.[Loan Number]=C.[Product Code] 

                            where C.[Posting Type] between 3 and 4 AND  C.[Customer No_]=B.[Client Code]
                            and C.[Product Code]=A.[Product Code]
                            group by BB.[Loan Number],BB.[Client Code],BB.[Product Name],BB.[Interest Rate],BB.[Loan Application Date],BB.[Loan Approval Date],BB.[Loans Status],C.[Product Code]
                            ) as INTEREST
 FROM [".$company."Detailed Cust_ Ledg_ Entry] A
 join [".$company."Credits] B on B.[Loan Number]=A.[Product Code] 
  where A.[Posting Type] between 1 and 2 
  AND A.[Customer No_]='$customerid'

                      
 group by B.[Loan Number],B.[Client Code],B.[Product Name],B.[Interest Rate],B.[Loan Application Date],B.[Loan Approval Date],B.[Loans Status], A.[Product Code]";




            //$les=DetailedVendorLedgerEntry::findBySql($sql)->asArray();


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
            
        $dataProvider = new ActiveDataProvider([
            'query' => Loanapplications::find()->where("[Client Code] = '$customerid'"),
        ]);
        

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'summary'=> $summary,
        ]);
    }

    /**
     * Displays a single Loanapplications model.
     * @param string $Loan No
     * @param string $Loan Product Type
     * @return mixed
     */
    public function actionView($LoanNo, $LoanProductType)
    {
        return $this->render('view', [
            'model' => $this->findModel($LoanNo, $LoanProductType),
        ]);
    }

    /**
     * Creates a new Loanapplications model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Loanapplications();
        $nextLoanNo =  str_pad(
            substr(
                implode("", 
                    Loanapplications::find()->select(['TOP 1 [Loan Number]'])->orderBy(['[Loan Number]' => SORT_DESC ])->asArray()->one()
                ),
            1
            ) + 1,
            5, '0', STR_PAD_LEFT
        );
        //print_r($nextLoanNo);exit;

         $Credittypes = ArrayHelper::map(Credittype::find()->all(), 'Credit Code', 'Credit Name'); 
         //print_r($Credittypes);exit;

         $customerDetails = Customers::find()->where(['E-Mail' => Yii::$app->user->identity->Email])->asArray()->one();
       

          $params = Yii::$app->request->post();

        if (!empty($params)) {


            $types = $model->getTableSchema()->columns;

            foreach ($model AS $key => $value) {

                $key1 = str_replace(" ", "_", $key);
                if (array_key_exists($key1, $params)) {
                    if ($key == 'Loan Number') {

                    } else {
                        $model[$key] = $params[$key1];
                    }
                } else if ($key == 'Loan Number') {

                } else {
                    if ($types["$key"]->type == 'string') {
                        $model[$key] = ' ';
                    } else if (($types["$key"]->type == 'integer') OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal')) {
                        $model[$key] = '0';
                    } else if ($types["$key"]->type == 'datetime') {
                        $model[$key] = '1753-01-01 00:00:00.000';
                    }
                }
            }
            $model['Client Name'] = Yii::$app->user->identity->LastName . ", "
                . Yii::$app->user->identity->FirstName . " " . Yii::$app->user->identity->MiddleName;
            $model['Loan Number'] =  'L' . str_pad(
                substr(    
            implode("", 
                    Loanapplications::find()->select(['TOP 1 [Loan Number]'])->orderBy(['[Loan Number]' => SORT_DESC ])->asArray()->one()
                ),
            1
            ) + 1,
            5, '0', STR_PAD_LEFT
            ); 

            // print_r($model['Loan Number']) ;exit; 

       if ($model->save()) {
                return $this->redirect(['view', 'id' => $model['Loan Number']]);
            } else {
               
            }
        }  else {
            return $this->render('create', [
                'model' => $model,
                'Credittypes' => $Credittypes,
                'customerDetails' => $customerDetails,
                'nextLoanNo' => $nextLoanNo,
            ]);
        }
    }

    /**
     * Updates an existing Loanapplications model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $Loan No
     * @param string $Loan Product Type
     * @return mixed
     */
    public function actionUpdate($LoanNo, $LoanProductType)
    {
        $model = $this->findModel($LoanNo, $LoanProductType);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'Loan No' => $model['Loan No'], 'Loan Product Type' => $model['Loan Product Type']]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Loanapplications model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $Loan No
     * @param string $Loan Product Type
     * @return mixed
     */
    public function actionDelete($LoanNo, $LoanProductType)
    {
        $this->findModel($LoanNo, $LoanProductType)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Loanapplications model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $Loan No
     * @param string $Loan Product Type
     * @return Loanapplications the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($LoanNo, $LoanProductType)
    {
        if (($model = Loanapplications::findOne(['Loan No' => $LoanNo, 'Loan Product Type' => $LoanProductType])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
