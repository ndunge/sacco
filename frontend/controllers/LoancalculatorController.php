<?php

namespace frontend\controllers;

use Yii;
use common\models\Loancalculator;
use common\models\Credittype;
use yii\web\POWER;
use common\models\Employees;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\LeaveTypes;
use yii\helpers\VarDumper;
use yii\helpers\Json;

/**
 * LeaveapplicationController implements the CRUD actions for Leaveapplication model.
 */
class LoancalculatorController extends Controller
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
     * Lists all Leaveapplication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $baseUrl = Yii::$app->request->baseUrl;
        $identity = Yii::$app->user->identity;
        $dataProvider = new ActiveDataProvider([
            'query' => Loancalculator::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

        
    


    }

    /**
     * Displays a single Leaveapplication model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id,$repaymentmethod)
    { 
        $model = new Loancalculator();
        //print_r("I'm here!");exit;
         
         $Loan= \common\models\Credittype::find()
            ->where(['Credit Code' => 'NORM'])
            ->one();
            //print_r($Loan);exit;
            
           $LoanAmount = number_format($Loan['Maximum Amount'],2);
           $LoanAmount = $Loan['Maximum Amount'];
            $Installment = $Loan['Maximum Installment'];
           $monthlyrepayment=$LoanAmount /$Installment;
            $LoanAmount =$LoanAmount -$monthlyrepayment;
           $Interest= $Loan['Interest'];
           $monthlyinstallment= $Loan['Interest'];
           $Installment = $Loan['Maximum Installment'];
           $monthlyrepayment=$LoanAmount /$Installment;
           $repaymentmethod1 = $Loan['Repayment Method'];
           //print_r($repaymentmethod1);exit;
            if ($repaymentmethod1= $repaymentmethod ){

                 $MONTHLYREPAYMENT=ROUND(($LoanAmount/$Installment)==0.05);
                 $MONTHLYINTEREST=ROUND(($LoanAmount*($Interest/1200)==0.05));

            $totalmonthly=$MONTHLYREPAYMENT+$MONTHLYINTEREST;
            
            }

              
        $dataProvider = new ActiveDataProvider([
            'query' => Loancalculator::find()->where("[Installment] = '$Installment'"),
        ]);
         
        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Leaveapplication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Loancalculator();
        $nextLoanNo = str_pad(
            substr(
                implode("", 
                    Loancalculator::find()->select(['TOP 1 [Loan Number]'])->orderBy(['[Loan Number]' => SORT_DESC ])->asArray()->one()
                ),
            1
            ) + 1,
            5, '0', STR_PAD_LEFT
        );

        
      $Credittypes = ArrayHelper::map(Credittype::find()->all(), 'Credit Code', 'Credit Name');

      
      //print_r($nextLoanNo);exit;
        

     
        $params = Yii::$app->request->post();
        
        if (!empty($params)) {
       
        //print_r($params);exit;
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

            $code= $params['Credit_Code'];
            $repaymentmethod = $params['repaymentmethod'];



             $Loan= \common\models\Credittype::find()
            ->where(['Credit Code' => $code])
            ->andwhere(['Repayment Method ' => $repaymentmethod])
            ->one();

            


            $LoanAmount = number_format($Loan['Maximum Amount'],2);
            $LoanAmount = $Loan['Maximum Amount'];
            $Installment = $Loan['Maximum Installment'];

            $model['Payment Date'] = date('Y-m-d');
            $repaymentmethod =$Loan['Repayment Method'];

            
            $monthlyrepayment=$LoanAmount /$Installment;
           // $model['Loan Number'] = 'L001';
            $model['Loan Balance'] = $LoanAmount ;
            $monthlyinterest=$LoanAmount*($Loan['Minimum Interest Rate']/1200);
            $totalmonthly= $monthlyrepayment+ $monthlyinterest;

          
  

       

            
            $model['Installment'] = $Installment;
            $model['Loan Repayment'] = $totalmonthly;
            $model['Loan Monthly Repayment'] = $params['totalmonthly'];
            $model['Loan Interest Repayment'] = $monthlyinterest;
            $model['Reset Doc No_'] = 'DOC001';
            $model['Reset Schedule'] = 0;

            $model['Loan Number'] =  'L' . str_pad(
                substr(
                    implode("", 
                        Loancalculator::find()->select(['TOP 1 [Loan Number]'])->orderBy(['[Loan Number]' => SORT_DESC ])->asArray()->one()
                    ),
                1
                ) + 1,
                5, '0', STR_PAD_LEFT
            );
           // $LoanAmount =$LoanAmount -$monthlyrepayment;
           //  $loanbalance=$model['Loan Balance'];
         

        

            // echo '<pre>';
            // VarDumper::dump($model);
            // echo '</pre>';
            // exit;
           

            // if ($model->save()) {
            //     return $this->redirect(['create']);
            // } else {
               
            // }
        
      
  

        // echo '<pre>';
        // VarDumper::dump($nextLeaveNo);
        // echo '</pre>';
        // exit;      

       
   if ($model->save()) {
                return $this->redirect(['view', 'id' => $model['Installment'],
                    'repaymentmethod' => $Loan['Repayment Method'],
                    'creditcode' => $Loan['Credit Code']]);
            } else {
               
            }
       }  else {
           
            return $this->render('create', [
                'model'=> $model,
                'Credittypes' => $Credittypes,
                
            ]);
              
           

        }
        //echo "Hey";exit;


        

        

    }

    public function actionLeave($code)
    {
        // you may need to check whether the entered ID is valid or not
        //print_r($code);
        // exit;
        $Loan= \common\models\Credittype::find()
            ->where(['Credit Code' => $code])
            ->one();
       

        $LoanAmount = number_format($Loan['Maximum Amount'],2);
       $LoanAmount = $Loan['Maximum Amount'];
       $Installment = $Loan['Maximum Installment'];
       // $monthlyrepayment=$LoanAmount /$Installment;
       // print_r($monthlyrepayment);exit;

       

        //echo $Installment1;
 //print_r($Loan['Maximum Amount']); exit;
         //exit;
        // echo '<pre>';
        // VarDumper::dump($leaveEntitlement);
        // echo '</pre>';
        // exit;

        // \yii\helpers\Json::encode([$leaveEntitlement])

        return \yii\helpers\Json::encode($LoanAmount);
        
        
        
    }
        public function actionRepayment($code)
    {
        // you may need to check whether the entered ID is valid or not
        //print_r($code);
        // exit;
        $Loan= \common\models\Credittype::find()
            ->where(['Credit Code' => $code])
            ->one();
       

        $LoanAmount = number_format($Loan['Maximum Amount'],2);
        $LoanAmount = $Loan['Maximum Amount'];
        $Installment = $Loan['Maximum Installment'];
        $interestrate = $Loan['Minimum Interest Rate'];
        $Repayment = $Loan['Repayment Method'];
        $monthlyrepayment=$LoanAmount /$Installment;
        $monthlyinterest=$LoanAmount*($Loan['Minimum Interest Rate']/1200);
        //$totalmonthly= $monthlyrepayment+ $monthlyinterest;
        //echo $totalmonthly; exit;
        $totalmonthly = 0; 
        if($Repayment==2){
           
           $totalmonthly= $monthlyrepayment+ $monthlyinterest;
            //$totalmonthly=$LoanAmount /$Installment;

        }elseif($Repayment==1){
             
             $monthlyrepayment=$LoanAmount/$Installment;
             $monthlyinterest=$LoanAmount*($interestrate /1200);
             $totalmonthly=$monthlyrepayment+ $monthlyinterest;
             
        }elseif($Repayment==3){
             
              $principal = $LoanAmount;
              $rate = $interestrate/1200; 
              $denominator = POW((1+$rate),$Installment)-1;
              $numerator = ($rate) * POW((1+$rate),$Installment);

              //$totalmonthly = $principal * ($rate) * POW((1+$rate),$Installment);

              $totalmonthly = $principal * ($numerator/$denominator);

              //echo "Principal ".$principal." Rate ".$rate." period ".$Installment." Monthly repayment ".$monthlyrepayment; exit;
              //$totalmonthly = ($interestrate/1200)/(1-POW((1+($interestrate/1200))-$Installment ))*$LoanAmount;
              
              //$monthlyinterest=($LoanAmount*($interestrate/1200));
              //$monthlyrepayment= $totalmonthly-$monthlyinterest;
        }
       

        //echo $Installment1;
 //print_r($Loan['Maximum Amount']); exit;
         //exit;
        // echo '<pre>';
        // VarDumper::dump($leaveEntitlement);
        // echo '</pre>';
        // exit;

        // \yii\helpers\Json::encode([$leaveEntitlement])

        return \yii\helpers\Json::encode($totalmonthly);
        
        
        
    }

    public function actionLeavee($code)
    {
        // you may need to check whether the entered ID is valid or not
        //print_r($code);
        // exit;
        $Loan= \common\models\Credittype::find()
            ->where(['Credit Code' => $code])
            ->one();
       

       
       $Installment = $Loan['Maximum Installment'];
       

        //echo $Installment1;
 //print_r($Loan['Maximum Amount']); exit;
         //exit;
        // echo '<pre>';
        // VarDumper::dump($leaveEntitlement);
        // echo '</pre>';
        // exit;

        // \yii\helpers\Json::encode([$leaveEntitlement])

        return \yii\helpers\Json::encode($Installment);
        
        
        
    }
        public function actionLeav($code)
    {
        // you may need to check whether the entered ID is valid or not
        //print_r($code);
        // exit;
        $Loan= \common\models\Credittype::find()
            ->where(['Credit Code' => $code])
            ->one();
       

       
       $repaymentfreq = $Loan['Repayment Frequency'];
       

     //print_r($Loan['Repayment Frequency']); exit;

         //exit;
        // echo '<pre>';
        // VarDumper::dump($leaveEntitlement);
        // echo '</pre>';
        // exit;

        // \yii\helpers\Json::encode([$leaveEntitlement])

        return \yii\helpers\Json::encode($repaymentfreq);
        
        
        
    }

        public function actionLoan($code)
    {
        // you may need to check whether the entered ID is valid or not
        //print_r($code);
        // exit;
        $Loan= \common\models\Credittype::find()
            ->where(['Credit Code' => $code])
            ->one();
       

       
       $repaymentmethod = $Loan['Repayment Method'];
       

     //print_r($Loan['Repayment Frequency']); exit;

         //exit;
        // echo '<pre>';
        // VarDumper::dump($leaveEntitlement);
        // echo '</pre>';
        // exit;

        // \yii\helpers\Json::encode([$leaveEntitlement])

        return \yii\helpers\Json::encode($repaymentmethod);
        
        
        
    }

          public function actionInterest($code)
    {
        // you may need to check whether the entered ID is valid or not
        //print_r($code);
        // exit;
        $Loan= \common\models\Credittype::find()
            ->where(['Credit Code' => $code])
            ->one();
       

       
       $interestrate = $Loan['Minimum Interest Rate'];
       

     //print_r($Loan['Repayment Frequency']); exit;

         //exit;
        // echo '<pre>';
        // VarDumper::dump($leaveEntitlement);
        // echo '</pre>';
        // exit;

        // \yii\helpers\Json::encode([$leaveEntitlement])

        return \yii\helpers\Json::encode($interestrate);
        
        
        
    }


    public function actionLeavetypes($code)
    {
        
        $description = LeaveTypes::find()->select(["Description"])->where(['Code' => $code])->all();
        print_r($description);
        exit;

       // echo '<pre>';
       // VarDumper::dump(Json::encode([$description]));
       // echo '</pre>';
       // exit;
        return \yii\helpers\Json::encode($description);
    }

    /**
     * Updates an existing Leaveapplication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        $nextLeaveNo = str_pad(
            substr(
                implode("", 
                    Leaveapplication::find()->select(['TOP 1 [Application No]'])->orderBy(['[Application No]' => SORT_DESC ])->asArray()->one()
                ),
            5
            ) + 1,
            3, '0', STR_PAD_LEFT
        );

        $Leavetypes = ArrayHelper::map(LeaveTypes::find()->all(), 'Code', 'Description'); 


        $employeeDetails = Employees::find()->where(['E-Mail' => Yii::$app->user->identity->Email])->asArray()->one(); 
        
        $model = $this->findModel($id);



        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model['Application No']]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'Leavetypes' => $Leavetypes,
                'employeeDetails' => $employeeDetails,
                'nextLeaveNo' => $nextLeaveNo,
            ]);
        }
    }

    /**
     * Deletes an existing Leaveapplication model.
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
     * Finds the Leaveapplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Leaveapplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Loancalculator::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
