<?php

namespace frontend\controllers;

use Yii;
use common\models\LedgerEntry;
use common\models\Credits;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\db\query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Profiles;




/**
 * DashboardController implements the REST CRUD actions .
 */
class DashboardController extends Controller
{
     /**
     * List of allowed domains.
     * Note: Restriction works only for AJAX (using CORS, is not secure).
     *
     * @return array List of domains, that can access to this API
     */
    public static function allowedDomains() {
        return [
            // '*',                        // star allows all domains
            'https://localhost:3000',
            // 'http://test2.example.com',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors() { 
        return array_merge([

            // For cross-domain AJAX request
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors'  => [
                    // restrict access to domains:
                    'Origin'                           => static::allowedDomains(),
                    'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'DELETE'],
                    'Access-Control-Allow-Headers'     => 'Content-Type',
                    'Access-Control-Allow-Origin'      => static::allowedDomains()[0],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
                ],
            ]

        ], parent::behaviors()); 

    } 

    public function beforeAction($action)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST') {
                header('Access-Control-Allow-Origin: https://localhost:3000');
                header('Access-Control-Allow-Headers: X-Requested-With, content-type, access-control-allow-origin, access-control-allow-methods, access-control-allow-headers');
            }
            exit;
        }

        // header('Content-type: application/json');
        header('Access-Control-Allow-Origin: ' . static::allowedDomains()[0]);

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    

        

        // header('Content-type: application/json');
        header('Access-Control-Allow-Origin: ' . static::allowedDomains()[0]);

        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
     //* Lists all LedgerEntry models.
    // * @return mixed


    
    public function actionSummary()
    {

      
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; 

        $identity = Yii::$app->user->identity; 

        //print_r($identity);exit;

        if ($identity) {

          $company='Demo Database NAV (11-0)].[dbo].[COMMUNICATION SACCO SOCIETY$';
          $ProfileID = $identity->ProfileID;
          $customerid = $identity->userid;
          
          $response = [];

          // Employee Information
          /*

          $Employee_sql ="SELECT [No_] 
            FROM [".$company."Employee] where [No_]='$customerid' "; 
          $share_capital_res = Yii::$app->getDb()->createCommand($Employee_sql)->queryAll();
         // if (count($share_capital_res) > 0) { 
          //string number_format ( float $number , int $decimals = 0 , string $dec_point = "." , string $thousands_sep = "," )
          //echo money_format("The price is %i", $number);
      
            $response[] = [ 'label' => "Share Capital", //'type' => 10, 'amount' => number_format( $share_capital_res[0]['amount'] ,2,".",",") 
          ];
          
        }
        */
         

          $share_capital_sql ="SELECT [Customer No_], CONVERT(DECIMAL(10,2), ABS(SUM(Amount)))   AS amount  
            FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] = 10 
            AND [Customer No_]='$customerid' group by [Customer No_] "; 
          $share_capital_res = Yii::$app->getDb()->createCommand($share_capital_sql)->queryAll();
          if (count($share_capital_res) > 0) { 
          //string number_format ( float $number , int $decimals = 0 , string $dec_point = "." , string $thousands_sep = "," )
          //echo money_format("The price is %i", $number);
      
            $response[] = [ 'label' => "Share Capital", 'type' => 10, 'amount' =>  number_format( $share_capital_res[0]['amount']   ,2,".",",") ];
          }

          $deposit_sql = "SELECT [Customer No_],  CONVERT(DECIMAL(10,2), ABS(SUM(Amount))) AS amount
            FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] = 5 
            AND [Customer No_]='$customerid' group by [Customer No_] ";
          $deposit_res = Yii::$app->getDb()->createCommand($deposit_sql)->queryAll(); 
          if (count($deposit_res) > 0) {   
            $response[] = [ 'label' => "Deposits", 'type' => 5, 'amount' => number_format( $deposit_res[0]['amount'] ,2,".",",") ];
          }
          
          $school_fees_sql = "SELECT [Customer No_], CONVERT(DECIMAL(10,2), ABS(SUM(Amount))) AS amount
            FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] = 16 
            AND [Customer No_]='$customerid' group by [Customer No_] ";
          $school_fees_res = Yii::$app->getDb()->createCommand($school_fees_sql)->queryAll();
          if (count($school_fees_res) > 0) {
            $response[] = [ 'label' => "Special Savings", 'type' => 16, 'amount' => number_format( $school_fees_res[0]['amount'],2,".",",") ];
          }   
          /*
          $children_savings_sql = "SELECT [Customer No_], CONVERT(DECIMAL(10,2), ABS(SUM(Amount))) AS amount
            FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] = 13 
            AND [Customer No_]='$customerid' group by [Customer No_] ";
          $children_savings_res = Yii::$app->getDb()->createCommand($children_savings_sql)->queryAll();
          if (count($children_savings_res) > 0) {
            $response[] = [ 'label' => "Children Savings", 'type' => 13, 'amount' => number_format( $children_savings_res[0]['amount'],2,".",",") ];
          }   
          */
          $loan_balance_sql = "SELECT [Customer No_], CONVERT(DECIMAL(10,2), ABS(SUM(Amount))) AS amount
            FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
            AND [Customer No_]='$customerid' group by [Customer No_] ";
          $loan_balance_res = Yii::$app->getDb()->createCommand($loan_balance_sql)->queryAll();
          $loan_balance_amount = (count($loan_balance_res) > 0) ? $loan_balance_res[0]['amount'] : 0;
            // $response[] = [ 'label' => "Loan balances", 'amount' => $loan_balance_res[0]['amount']  ];

          $interest_balance_sql = "SELECT [Customer No_], CONVERT(DECIMAL(10,2), ABS(SUM(Amount))) AS amount
            FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
            AND [Customer No_]='$customerid' group by [Customer No_] ";
          $interest_balance_res = Yii::$app->getDb()->createCommand($interest_balance_sql)->queryAll();
          $interest_balance_amount = (count($interest_balance_res) > 0) ? $interest_balance_res[0]['amount'] : 0;
            // $response[] = [ 'label' => "Interest balances", 'amount' => $interest_balance_res[0]['amount']  ];

          $response[] = [ 
            'label' => "Outstanding Loan Balance",  'type' => 0,
            'amount' => number_format(($loan_balance_amount +  $interest_balance_amount) ,2,".",",")
          ];

          return $response;
        } 
      
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
    public function actionView($postingtype = 0)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $response = [];

        // echo "$postingtype"; exit;

        $postingtypeslookup = [
          0 => 'Aggregate',
          1 => 'Loan Debit',
          2 => 'Loan Credit',
          10 => 'Share Capital',
          5 => 'deposits',
          12 => 'School Fees',
          13 => 'children savings',
          16 => 'Special savings',
        ];

        // $model = $this->findModel($id);

        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->userid;
        $company='Demo Database NAV (11-0)].[dbo].[COMMUNICATION SACCO SOCIETY$';


        $whereClause = " WHERE [Customer No_]='$customerid' ";
        
        $whereClause .= ($postingtype == 0)  
          ? " AND [Posting Type] IN ( 5,10,16) "  
          : " AND [Posting Type] = $postingtype ";

          

        
        $ledger_sql = "SELECT timestamp, [Customer No_], [Document No_], [Posting Date], [Posting Type],
            [Product Code], CONVERT(DECIMAL(10,2),[Debit Amount]) AS Debit_Amount ,CONVERT(DECIMAL(10,2),[Credit Amount]) As Credit_Amount , CONVERT(DECIMAL(10,2), Amount) AS  Amount,
         SUM(Amount) OVER(partition by [Posting Type]ORDER BY [Entry No_]  ROWS UNBOUNDED PRECEDING) AS Balance
          FROM [".$company."Detailed Cust_ Ledg_ Entry]  $whereClause  ";
          

       
          // echo "$ledger_sql"; exit;
        $ledger_res = Yii::$app->getDb()->createCommand($ledger_sql)->queryAll();

        // print_r($ledger_res);exit;

        foreach ($ledger_res as $key => $value) {
          $response [ $value['Posting Type'] ] [] = array_merge([ 
            'Posting Description' => isset($postingtypeslookup[ $value['Posting Type'] ]) 
              ? $postingtypeslookup[ $value['Posting Type'] ] : 'Unspecified Posting Type'
          ], $value);
        }
        
        if ($postingtype == 0) {

         //         $query = "SELECT DCL.[Customer No_], DCL.[Document No_], DCL.[Posting Date],DCL.[Posting Type],
         //    DCL.[Product Code], CONVERT(DECIMAL(10,2),[Debit Amount]) AS Debit_Amount ,CONVERT(DECIMAL(10,2),[Credit Amount]) As Credit_Amount , CONVERT(DECIMAL(10,2), Amount) AS  Amount,
         // SUM(Amount) OVER(ORDER BY DCL.[Product Code] ROWS UNBOUNDED PRECEDING) AS Balance
         //  FROM [".$company."Detailed Cust_ Ledg_ Entry]DCL  
         //  JOIN [".$company."Credits]C ON DCL.[Customer No_]=C.[Client Code] AND DCL.[Product Code]=C.[Loan Number]

         //  $whereClause 
         //  GROUP BY  DCL.[Product Code],DCL.[Customer No_], DCL.[Document No_], DCL.[Posting Date],DCL.[Debit Amount],DCL.[Credit Amount],DCL.Amount,DCL.[Posting Type]
         //  ORDER BY DCL.[Product Code] ASC,DCL.[Posting Date] ASC ";
         //  $loans = Yii::$app->getDb()->createCommand($query)->queryAll();
         
         // print_r($loans);exit;
         
          $loans = LedgerEntry::find()
            ->select(" [Customer No_], [Document No_], [Posting Date], [Posting Type], [Product Code], 
              [Debit Amount] AS Debit_Amount, [Credit Amount] AS Credit_Amount , Amount,
         SUM(Amount) OVER(partition by [Product Code]ORDER BY [Product Code] ROWS UNBOUNDED PRECEDING) AS Balance")
            
            
            ->where("[Customer No_] = '$customerid'")
            ->andwhere("[Posting Type] BETWEEN 1 AND 2")
            ->orderby("[Posting Date] ASC")
            // ->groupBy(['Customer No_', 'Document No_', 'Posting Date', 'Posting Type', 'Product Code','Amount'])
            ->asArray()
            ->all();
           
          
        // print_r($loans); exit;
            
          
          foreach ($loans as $key => $value) {
            $response [ preg_replace('/:/i', '', $value['Product Code'])  ] [] = array_merge($value, [ 
              
              // 'Amount' => number_format($value['Amount'], 2),
              // 'Debit_Amount' => number_format($value['Debit Amount'] ,2),
              // 'Credit_Amount' => number_format($value['Credit Amount'],2),
              
              'Product Code' => preg_replace('/:/i', '', $value['Product Code']),
              'Posting Description' => isset($postingtypeslookup[ $value['Posting Type'] ]) 
                ? $postingtypeslookup[ $value['Posting Type'] ] : 'Unspecified Posting Type'
            ]);
          }
          
          
        }

        // $deposit = LedgerEntry::find()->where("[Customer No_] = '$customerid'")->andwhere("[Posting Type] = 5");
        // $fees = LedgerEntry::find()->where("[Customer No_] = '$customerid'")->andwhere("[Posting Type] = 12");
        // $children = LedgerEntry::find()->where("[Customer No_] = '$customerid'")->andwhere("[Posting Type] = 13");


        // $loan_balance_sql = "SELECT [Customer No_], CONVERT(DECIMAL(10,2), ABS(SUM(Amount))) AS amount
        //   FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 1 and 2 
        //   AND [Customer No_]='$customerid' group by [Customer No_] ";
        // $loan_balance_res = Yii::$app->getDb()->createCommand($loan_balance_sql)->queryAll();
        // $loan_balance_amount = (count($loan_balance_res) > 0) ? $loan_balance_res[0]['amount'] : 0;
        //   // $response[] = [ 'label' => "Loan balances", 'amount' => $loan_balance_res[0]['amount']  ];

        // $interest_balance_sql = "SELECT [Customer No_], CONVERT(DECIMAL(10,2), ABS(SUM(Amount))) AS amount
        //   FROM [".$company."Detailed Cust_ Ledg_ Entry] where [Posting Type] between 3 and 4 
        //   AND [Customer No_]='$customerid' group by [Customer No_] ";
        // $interest_balance_res = Yii::$app->getDb()->createCommand($interest_balance_sql)->queryAll();
        // $interest_balance_amount = (count($interest_balance_res) > 0) ? $interest_balance_res[0]['amount'] : 0;
        //   // $response[] = [ 'label' => "Interest balances", 'amount' => $interest_balance_res[0]['amount']  ];
        // print(json_encode($response));
        return $response;
      
        // return $this->render('view', [
        //     'dataProvider1' =>$dataProvidercapital,
        //     'dataProvider2' =>$dataProviderdeposit,
        //     'dataProvider3' =>$dataProviderfees,
        //     'dataProvider4' =>$dataProviderchildren,
        //     'summary'=>$summary,
        //     'summary2'=>$summary2,            

        // ]);
    }

    /**
     * Displays a single LedgerEntry model.
     * @param integer $id
     * @return mixed
     */
    public function actionLoansposted()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;       
        $response = [];
        $response2 = [];

        $loantypeslookup = [
          3 => 'Approved', 
        ];

        $defaultedlookup = [
          2=> 'Approved', 
        ];


        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->userid;
        $company ='Demo Database NAV (11-0)].[dbo].[COMMUNICATION SACCO SOCIETY$'; 

        $loansposted_sql = " SELECT B.[Loan Number], B.[Client Code], B.[Product Name], 
          B.[Loan Application Date], B.[Loan Approval Date],CONVERT(DECIMAL(10,2),B.[Approved Amount]) AS Approved_Amount, B.[Loans Status],B.[Defaulted Status],B.[Monthly Repayment], CONVERT(DECIMAL(10,2),sum(A.Amount)) AS Amount,
          
      ( select   sum(CL.Amount) as outstanding_balance
                            FROM [".$company."Detailed Cust_ Ledg_ Entry] CL
                            join [".$company."Credits]BC    on BC.[Loan Number]=CL.[Product Code] 

                            where CL.[Posting Type] BETWEEN 1 AND 2 AND  CL.[Customer No_]='$customerid'
                            
                            
                            ) as Balance,
        ( select   sum(CL.Amount) as outstanding_interest
                            FROM [".$company."Detailed Cust_ Ledg_ Entry] CL
                            join [".$company."Credits]BC    on BC.[Loan Number]=CL.[Product Code] 

                            where CL.[Posting Type] BETWEEN 3 AND 4 AND  CL.[Customer No_]='$customerid'
                            
                            
                            ) as Interest                    
          FROM [".$company."Detailed Cust_ Ledg_ Entry] A
          join [".$company."Credits] B on B.[Loan Number]=A.[Product Code] 
          where A.[Posting Type] between 1 and 2  AND A.[Customer No_]='$customerid'                      
          group by B.[Loan Number],B.[Client Code],B.[Product Name],B.[Approved Amount],B.[Loan Application Date],B.[Loan Approval Date],B.[Loans Status],B.[Defaulted Status],B.[Monthly Repayment], A.[Product Code]";
        $loansposted_res = Yii::$app->getDb()->createCommand($loansposted_sql)->queryAll(); 
         // $loansposted_res2=$loansposted_res;
       // print_r($loansposted_res);exit;

        foreach ($loansposted_res as $key => $value) {
          $response [] = array_merge([ 'LoansStatus' => $loantypeslookup[ $value['Loans Status'] ]  ], $value);
        }

        // foreach ($loansposted_res as $key => $value2) {
        //   $response2 [] = array_merge([ 'DefaultedStatus' => $defaultedlookup[ $value2['Defaulted Status'] ]  ], $value2);
        // }

        return $response; 
        // return $response2; 
    }

    /**
     * Displays a single LedgerEntry model.
     * @param integer $id
     * @return mixed
     */
    public function actionLoanstatement($productcode)
    {
    //print_r($productcode);exit;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;       
        $response = [];

        $postingtypeslookup = [
          0 => 'Loan Credit', 
          1 => 'Loan Debit', 
        ];


        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->userid;
        $company ='Demo Database NAV (11-0)].[dbo].[COMMUNICATION SACCO SOCIETY$'; 

        $loanstatement_sql =  "SELECT M.[Loan No_], M.[Security No_],M.[Name],M.[Amount Committed],C.[Approved Amount],M.[Avalable Shares]FROM  [".$company."MC Loan Securities]M join [".$company."Credits]C ON M.[Loan No_]=C.[Loan Number]   WHERE 
                               M.[Loan No_]='$productcode'";
        $loanstatement_res = Yii::$app->getDb()->createCommand($loanstatement_sql)->queryAll();  

        //foreach ($loanstatement_res as $key => $value) {
         // $response [] = array_merge([ 'PostingType' => $postingtypeslookup[ $value['Posting Type'] ]  ], $value);
        //}

        return $loanstatement_res; 
    }

    /**
     * Displays a single LedgerEntry model.
     * @param integer $id
     * @return mixed
     */
    public function actionLoansguaranteed()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;    

        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->userid;
        $company ='Demo Database NAV (11-0)].[dbo].[COMMUNICATION SACCO SOCIETY$'; 

        $loansguaranteed_sql =  " SELECT MC.[Loan No_],MC.[Security No_],MC.Name,MC.[Amount Committed],MC.[Loan Balance],
                  ( SELECT   sum(C.Amount)  as loan_balance
                FROM [".$company."Detailed Cust_ Ledg_ Entry] C
                 WHERE  C.[Product Code]=MC.[Loan No_]
                AND C.[Posting Type] BETWEEN 1 AND 2 and C.[Customer No_]='$customerid'                                           
              ) as oustanding_balance
             FROM [".$company."MC Loan Securities] MC WHERE MC.[Security No_]='$customerid'";

        $loansguaranteed_res = Yii::$app->getDb()->createCommand($loansguaranteed_sql)->queryAll();   

        return $loansguaranteed_res; 
    }

     public function actionLoansguarantors()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;    

        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
    //print_r($customerid);exit;
        $company ='kencom].[dbo].[KENCOM SACCO SOCIETY  LTD$'; 
    
    

        $loansguarantors_sql =  " SELECT B.[Client Code],B.[Client Name],B.[Loan Application Date],B.[Loan Approval Date],
                             AA.[Security No_],AA.[Name],B.[Loan Number],
(SELECT SUM(DCL.Amount)  FROM [".$company."Detailed Cust_ Ledg_ Entry]DCL
JOIN [".$company."Credits]BB ON DCL.[Product Code]=BB.[Loan Number] WHERE
DCL.[Posting Type] IN (1,2,3) AND DCL.[Customer No_]='00003433' ] ) AS Outstanding_Balance,

(SELECT SUM(CL.Amount) FROM [".$company."Detailed Cust_ Ledg_ Entry]CL
JOIN [".$company."Credits]BC ON CL.[Product Code]=BC.[Loan Number] WHERE
CL.[Posting Type] BETWEEN 3 AND 4 AND CL.[Customer No_]='00003433'  ) AS Outstanding_Interest

--(SELECT SUM(L.Amount) FROM  [".$company."Detailed Cust_ Ledg_ Entry]L
--0JOIN [".$company."MC Loan Securities]LS ON LS.[Security No_]='00003433'
--where L.[Posting Type]=5)AS Shares



FROM [".$company."Credits]B 
join [".$company."MC Loan Securities]AA ON AA.[Loan No_]=B.[Loan Number] 
WHERE B.[Client Code]='00003433' AND B.[Loan Number]='A:000001:10:2015' AND AA.[Substituted]=0
GROUP BY B.[Client Code],B.[Client Name],B.[Loan Application Date],B.[Loan Approval Date],
AA.[Security No_],AA.[Name],B.[Loan Number]
";
        $loansguarantors_res = Yii::$app->getDb()->createCommand($loansguarantors_sql)->queryAll();   

        return $loansguarantors_res; 
    }

        /**
     * Displays a single LedgerEntry model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateprofile()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;    

        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company ='kencom].[dbo].[KENCOM SACCO SOCIETY  LTD$'; 

        // echo "Good";exit;
        $baseUrl = Yii::$app->request->baseUrl;

        $member_statement_sql =  "SELECT * FROM [KENCOM SACCO SOCIETY  LTD\$Customer] WHERE No_ = '$customerid'";
        $member_statement_res = Yii::$app->getDb()->createCommand($member_statement_sql)->queryAll();  
    
    // $ApprovalStatus = array('','Open','Approved','Pending Approval','Pending Prepayment','Rejected');

        $channel = array();
        foreach ($member_statement_res AS $key => $row)  {
          //extract($row); 
            $channel[] = array(
              'number' =>  $row['No_'],
              'name' => $row['Name'],
              'address' => $row['Address'],
              // $ApprovalStatus[$row['ApprovalStatus']],
              'joined' => date("d/m/Y", strtotime($row['Date of Join'])),        
            );
        }

        return $channel[0]; 
    }


    /**
     * Displays a single LedgerEntry model.
     * @param integer $id
     * @return mixed
     */
    public function actionMemberstatement()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;    

        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->userid;
        $company ='Demo Database NAV (11-0)].[dbo].[COMMUNICATION SACCO SOCIETY$'; 

        // echo "Good";exit;
        $baseUrl = Yii::$app->request->baseUrl;

        $member_statement_sql =  "SELECT * FROM [COMMUNICATION SACCO SOCIETY\$Customer] WHERE No_ = '$customerid'";
        $member_statement_res = Yii::$app->getDb()->createCommand($member_statement_sql)->queryAll();  
    
    // $ApprovalStatus = array('','Open','Approved','Pending Approval','Pending Prepayment','Rejected');

        $channel = array();
        foreach ($member_statement_res AS $key => $row)  {
          //extract($row); 
            $channel[] = array(
              'number' =>  $row['No_'],
              'name' => $row['Name'],
              'email' => $row['E-Mail'],
              'phone' => $row['Phone No_'],
            //   'address' => $row['Address'],
            //   // $ApprovalStatus[$row['ApprovalStatus']],
            //   'joined' => date("d/m/Y", strtotime($row['Date of Join']

            // )),        
            );
        }

        return $channel[0]; 
    }

    public function actionLoancalculator()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;    

        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->userid;
        $company ='Demo Database NAV (11-0)].[dbo].[COMMUNICATION SACCO SOCIETY$'; 

        // echo "Good";exit;
        $baseUrl = Yii::$app->request->baseUrl;

        $member_statement_sql =  "SELECT [Credit Name] FROM [COMMUNICATION SACCO SOCIETY\$Credits Type] ";
        $member_statement_res = Yii::$app->getDb()->createCommand($member_statement_sql)->queryAll();  
    
        $data = array();
        foreach ($member_statement_res AS $key => $row)  {
          //extract($row); 
            $data[] = array(
              'id' =>  $row['Credit Code'],
              'names' => $row['Credit Name'],
              
            //   'address' => $row['Address'],
            //   // $ApprovalStatus[$row['ApprovalStatus']],
            //   'joined' => date("d/m/Y", strtotime($row['Date of Join']

            // )),        
            );
        }

        return $data[0];

        

        return $member_statement_res; 
    }

     public function actionMemberchange()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;    

        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $customerid=$identity->Userid;
        $company ='Demo Database NAV (11-0)].[dbo].[COMMUNICATION SACCO SOCIETY$'; 

        // echo "Good";exit;
        $baseUrl = Yii::$app->request->baseUrl;

        $member_change_sql =  "SELECT * FROM [COMMUNICATION SACCO SOCIETY\$Detailed Cust_ Ledg_ Entry] WHERE Customer No_ = '$customerid'";
        $member_change_res = Yii::$app->getDb()->createCommand($member_statement_sql)->queryAll();  
    
    // $ApprovalStatus = array('','Open','Approved','Pending Approval','Pending Prepayment','Rejected');

        $channel = array();
        foreach ($member_change_res AS $key => $row)  {
          //extract($row); 
            $channel[] = array(
              'postingType' =>  $row['Posting Type'],
              'loanNo' => $row['Product Code'],
              'OldAmount' => $row['Amount'],
              'NewAmount' => $row['Amount'],
            //   'address' => $row['Address'],
            //   // $ApprovalStatus[$row['ApprovalStatus']],
            //   'joined' => date("d/m/Y", strtotime($row['Date of Join']

            // )),        
            );
        }

        return $channel[0]; 
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
