<?php

namespace backend\controllers;

use Yii;
use common\models\Trainingrequest;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Employees;
use common\models\RequestTraining;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use common\models\Customers;
use common\models\Customerbalance;
use common\models\GeneralJournal;

/**
 * TrainingrequestController implements the CRUD actions for Trainingrequest model.
 */
class RequestController extends Controller
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
	
	public function beforeAction($action)  
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    } 	

    /**
     * Lists all Trainingrequest models.
     * @return mixed
     */
    public function actionVerification()
    {
		$postdata = file_get_contents("php://input");
		if (get_magic_quotes_runtime())
		{
			$postdata = stripslashes($postdata);
		}
		$filename = 'log/'.(string)time().'request.log';
		$req_dump = print_r($postdata, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
		
		/*
        $postdata = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
				<soapenv:Body>
				<request>
				<billNumber>1000011</billNumber>
				<username>Eqbank</username>
				<password>sdfsg3^7Yddd</password>
				</request>
				</soapenv:Body>
				</soapenv:Envelope>';
		*/
		if ($postdata!='')
		{
			$xml = simplexml_load_string($postdata); //, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");

			// register your used namespace prefixes
			$xml->registerXPathNamespace('soap-env', 'http://schemas.xmlsoap.org/soap/envelope/');
			$nodes = $xml->xpath('/soapenv:Envelope/soapenv:Body/request');

			$billNumber = $nodes[0]->billNumber[0];
			$billDate = date('Y-m-d');
			
			$model = Customers::findone(['No_'=>$billNumber]);
			if (!empty($model))
			{
				$balances= Customerbalance::findone([$billNumber]);
				$balance=empty($balances)?0:$balances->Balance*-1;
				
				//set content type xml in response
				Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
				$headers = Yii::$app->response->headers;
				$headers->add('Content-Type', 'text/xml');
				$response = '<?xml version="1.0" encoding="UTF-8" ?>
							<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
								<soapenv:Body>
									<return>
										<amount>'.$balance.'</amount>
										<billName>'.$model->Name.'</billName>
										<billNumber>'.$billNumber.'</billNumber>
										<billerCode>'.$billNumber.'</billerCode>
										<createdOn>'.$billDate.'</createdOn>
										<currencyCode>KSHS</currencyCode>
										<customerName>'.$model->Name.'</customerName>
										<customerRefNumber>'.$model->No_.'</customerRefNumber>
										<description>'.$model->Name.'</description>
										<dueDate>'.$billDate.'</dueDate>
										<expiryDate>'.$billDate.'</expiryDate>
										<Remarks>Fees</Remarks>
										<type>1</type>
									</return>
								</soapenv:Body>
							</soapenv:Envelope>';
			}		
			
			echo $response;
		} else
		{
			//set content type xml in response
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			$headers = Yii::$app->response->headers;
			$headers->add('Content-Type', 'text/xml');
			$response = '<?xml version="1.0" encoding="UTF-8" ?>
						<soapenv:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/">
							<soapenv:Body>
								<return>
									<responseCode>Failed</responseCode>
									<responseMessage>Missing Data</responseMessage>
								</return>
							</soapenv:Body>
						</soapenv:Envelope>';
					
			
			echo $response;
		}
    }
	
    public function actionNotification() // Equity Bank
    {
		$postdata = file_get_contents("php://input");
		if (get_magic_quotes_runtime())
		{
			$postdata = stripslashes($postdata);
		}
		
		$filename = 'log/'.(string)time().'request.log';
		$req_dump = print_r($postdata, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
		/*
        $postdata = '<?xml version="1.0" encoding="UTF-8" ?>
					<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
					<soapenv:Body>
					<request>
					<billNumber>1000011</billNumber>
					<billAmount>100.00</billAmount>
					<customerRefNumber>JK2342-01</customerRefNumber>
					<bankreference>201501015423442-1</bankreference>
					<paymentMode>CASH</paymentMode>
					<transactionDate>01-02-2017</transactionDate>
					<phonenumber>0763785426</phonenumber>
					<debitaccount>1000011</debitaccount>
					<debitcustname>Osman Hared Ibrahim</debitcustname>
					<username>Eqbank</username>
					<password>sdfsg3^7Yddd</password>
					</request>
					</soapenv:Body>
					</soapenv:Envelope>';
		*/
		if ($postdata!='')
		{
			$xml = simplexml_load_string($postdata); //, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");

			// register your used namespace prefixes
			//$xml->registerXPathNamespace('soap-env', 'http://schemas.xmlsoap.org/soap/envelope/');
			//$nodes = $xml->xpath('/soapenv:Envelope/soapenv:Body/request');
			
			$xml->registerXPathNamespace('soap-env', 'http://schemas.xmlsoap.org/soap/envelope/');
			$nodes = $xml->xpath('/soap:Envelope/soap:Body/request');

			$billNumber = $nodes[0]->billNumber[0];
			$billAmount = $nodes[0]->billAmount[0];
			$transactionDate = $nodes[0]->transactionDate[0];
			$bankreference = $nodes[0]->bankreference[0];
			$billDate = date('Y-m-d');
			
			$Successfull = false;
			$Customers = Customers::findone(['No_'=>$billNumber]);
			if (!empty($Customers))
			{			
				// Post Charges to the General Journal
				$model = new GeneralJournal();	
				$types = $model->getTableSchema()->columns;
				foreach ($model AS $key => $value) 
				{
					if ($types["$key"]->type == 'string') 
					{
						$model[$key] = '';
					} else if (($types["$key"]->type == 'integer') OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal')) {
						$model[$key] = '0';
					} else if ($types["$key"]->type == 'datetime') {
						$model[$key] = '1753-01-01 00:00:00.000';
					}				
				}
				$model['Journal Template Name'] = 'STUD FEES';
				$model['Journal Batch Name'] =  'DEFAULT';
				$model['Line No_'] = rand(100,10000);
				$model['Account Type'] = 3;
				$model['Account No_'] = 46; // We should replace with the real bank code from Bank accounts Table
				$model['Posting Date'] = date('Y-m-d'); //$transactionDate
				$model['Document Type'] = 1;
				$model['Document No_'] = (string)time();
				$model['Description'] = $Customers->Name .' - '. $bankreference;
				$model['VAT _'] = 0;
				$model['Amount'] = $billAmount;
				$model['Debit Amount'] = $billAmount;
				$model['Credit Amount'] = 0;
				$model['Amount_LCY'] = $billAmount;
				$model['Bill-to_Pay-to No_'] = $billNumber;
				$model['Posting Group'] = 'STUDENTS';
				$model['Due Date'] = date('Y-m-d');
				$model['Document Date'] = date('Y-m-d'); //$transactionDate
				$model['Bal_ Account No_'] = $billNumber;
				$model['Bal_ Account Type'] = 1;
				if ($model->save())
				{
					$Successfull = true;
					$responseCode = 'OK';
					$responseMessage = 'SUCCESSFULL';
				} else
				{
					$Successfull = false;
					$responseCode = 'Failed';
					$responseMessage = 'Failed';
				}
				
			} else
			{
				$Successfull = false;
				$responseCode = 'Failed';
				$responseMessage = 'Failed';
			}

			//set content type xml in response
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			$headers = Yii::$app->response->headers;
			$headers->add('Content-Type', 'text/xml');
			$response = '<?xml version="1.0" encoding="UTF-8" ?>
						<soapenv:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/">
							<soapenv:Body>
								<return>
									<responseCode>'.$responseCode.'</responseCode>
									<responseMessage>'.$responseMessage.'</responseMessage>
								</return>
							</soapenv:Body>
						</soapenv:Envelope>';
					
			
			echo $response;
		} else
		{
			//set content type xml in response
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			$headers = Yii::$app->response->headers;
			$headers->add('Content-Type', 'text/xml');
			$response = '<?xml version="1.0" encoding="UTF-8" ?>
						<soapenv:Envelope xmlns:env="http://schemas.xmlsoap.org/soap/envelope/">
							<soapenv:Body>
								<return>
									<responseCode>Failed</responseCode>
									<responseMessage>Missing Data</responseMessage>
								</return>
							</soapenv:Body>
						</soapenv:Envelope>';
					
			
			echo $response;
		}
	}
	
	public function actionAlert()
	{
		$postdata = file_get_contents("php://input");
		if (get_magic_quotes_runtime())
		{
			$postdata = stripslashes($postdata);
		}
		
		$filename = 'log/'.(string)time().'request.log';
		$req_dump = print_r($postdata, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
		/*
		$postdata = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
		<soapenv:Header/>
		<soapenv:Body>
		<CBAPaymentNotificationRequest>
			<User>CBA35</User>
			<Password>Ug@l!Moto</Password>
			<HashVal>NWYwNGMwMjAxZjhiMWQ2MjE3YWQ1NDBkNDhhMWFjMTQ1MDFiNDBhZjM4MmVlZWUzNDRkOWNlOWViNTkxNmJlYg==</HashVal>
			<TransType>Pay Bill</TransType>
			<TransID>JK2NLJVA18</TransID>
			<TransTime>20151102200912</TransTime>
			<TransAmount>100.00</TransAmount>
			<AccountNr>880100</AccountNr>
			<Narrative>1000011</Narrative>
			<PhoneNr>254725629786</PhoneNr>
			<CustomerName>JOHN DOE</CustomerName>
			<Status>SUCCESS</Status>
		</CBAPaymentNotificationRequest>
		</soapenv:Body>
		</soapenv:Envelope>';
		*/
		if ($postdata!='')
		{
			$xml = simplexml_load_string($postdata);

			// register your used namespace prefixes
			$xml->registerXPathNamespace('soap-env', 'http://schemas.xmlsoap.org/soap/envelope/');
			$nodes = $xml->xpath('/soapenv:Envelope/soapenv:Body/CBAPaymentNotificationRequest');
			$SecretKey = Yii::$app->params['CBAKey'];
			//echo($nodes[0]->TransID); exit;
			$TransID = $nodes[0]->TransID;
			$TransTime = $nodes[0]->TransTime;
			$TransAmount = $nodes[0]->TransAmount;
			$billDate = date('Y-m-d');
			$billNumber = $nodes[0]->Narrative;
			$Narrative = $nodes[0]->Narrative;
			$TransType = $nodes[0]->TransType;
			$AccountNr = $nodes[0]->AccountNr;
			$CustomerName = $nodes[0]->CustomerName;
			$Status = $nodes[0]->Status;
			$PhoneNr = $nodes[0]->PhoneNr;
			$HashVal = $nodes[0]->HashVal;
			
			$keystring = $SecretKey.$TransType.$TransID.$TransTime.$TransAmount.$AccountNr.$Narrative.$PhoneNr.$CustomerName.$Status;
			
			$keystring = hash('sha256', $keystring);
			$keystring = base64_encode($keystring);
			//echo $keystring; exit;
			
			if ($HashVal == $keystring)
			{
				$Successfull = false;
				$Customers = Customers::findone(['No_'=>$billNumber]);
				if (!empty($Customers))
				{			
					// Post Charges to the General Journal
					$model = new GeneralJournal();	
					$types = $model->getTableSchema()->columns;
					foreach ($model AS $key => $value) 
					{
						if ($types["$key"]->type == 'string') 
						{
							$model[$key] = '';
						} else if (($types["$key"]->type == 'integer') OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal')) {
							$model[$key] = '0';
						} else if ($types["$key"]->type == 'datetime') {
							$model[$key] = '1753-01-01 00:00:00.000';
						}				
					}
					$model['Journal Template Name'] = 'STUD FEES';
					$model['Journal Batch Name'] =  'DEFAULT';
					$model['Line No_'] = rand(100,10000);
					$model['Account Type'] = 3;
					$model['Account No_'] = 46; // We should replace with the real bank code from Bank accounts Table
					$model['Posting Date'] = date('Y-m-d'); //$transactionDate
					$model['Document Type'] = 1;
					$model['Document No_'] = (string)time();
					$model['Description'] = $Customers->Name .' - '. $TransID;
					$model['VAT _'] = 0;
					$model['Amount'] = $TransAmount;
					$model['Debit Amount'] = $TransAmount;
					$model['Credit Amount'] = 0;
					$model['Amount_LCY'] = $TransAmount;
					$model['Bill-to_Pay-to No_'] = $billNumber;
					$model['Posting Group'] = 'STUDENTS';
					$model['Due Date'] = date('Y-m-d');
					$model['Document Date'] = date('Y-m-d'); //$transactionDate
					$model['Bal_ Account No_'] = $billNumber;
					$model['Bal_ Account Type'] = 1;
					if ($model->save())
					{
						$Successfull = true;
						$responseCode = 'OK';
						$responseMessage = 'SUCCESSFULL';
					} else
					{
						$Successfull = false;
						$responseCode = 'FAIL';
						$responseMessage = 'Failed';
					}
					
				} else
				{
					$Successfull = false;
					$responseCode = 'FAIL';
					$responseMessage = 'Failed';
				}
			} else
			{
				$Successfull = false;
				$responseCode = 'FAIL';
				$responseMessage = 'Failed';
			}

			//set content type xml in response
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			$headers = Yii::$app->response->headers;
			$headers->add('Content-Type', 'text/xml');
			$response = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
						<soapenv:Header/>
							<soapenv:Body>
								<CBAPaymentNotificationResult>
									<Result>'.$responseCode.'</Result>
								</CBAPaymentNotificationResult>
							</soapenv:Body>
						</soapenv:Envelope>';
					
			
			echo $response;
		} else
		{
			//set content type xml in response
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			$headers = Yii::$app->response->headers;
			$headers->add('Content-Type', 'text/xml');
			$response = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
						<soapenv:Header/>
							<soapenv:Body>
								<CBAPaymentNotificationResult>
									<Result>FAIL</Result>
								</CBAPaymentNotificationResult>
							</soapenv:Body>
						</soapenv:Envelope>';			
			echo $response;
		}
	}
	
	public function actionCoopverification()
    {
		$postdata = file_get_contents("php://input");
		if (get_magic_quotes_runtime())
		{
			$postdata = stripslashes($postdata);
		}
		$filename = 'log/'.(string)time().'request.log';
		$req_dump = print_r($postdata, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
		
		/*
        $postdata = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http:///www.co-opbank.co.ke/B2BStandardAPI/">
					<soapenv:Header>
					<b2b:HeaderRequest>
						<serviceName>test_service</serviceName>
						<messageID>eagwekwe12sa</messageID>
						<Connection>
							<connectionID>SOA</connectionID>
							<connectionPassword>SOA.123</connectionPassword>
						</Connection>
					</b2b:HeaderRequest>
					</soapenv:Header>
					<soapenv:Body>
						<b2b:getAccountValidationInput>
							<operationParameters>
							<TransactionReferenceCode>KRA-02-0281298</TransactionReferenceCode>
							<TransactionDate> 2016-12-06T00:00:00+03:00</TransactionDate>
							</operationParameters>
							<accountInfo>
							<AccountNumber>1000011</AccountNumber>
							</accountInfo>
							<institution>
							<InstitutionCode>C-00012</InstitutionCode>
							</institution>
						</b2b:getAccountValidationInput>
					</soapenv:Body>
					</soapenv:Envelope>';
		*/
		if ($postdata!='')
		{
			$xml = simplexml_load_string($postdata); //, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");

			// register your used namespace prefixes
			$xml->registerXPathNamespace('soap-env', 'http://schemas.xmlsoap.org/soap/envelope/');
			$nodes 	= $xml->xpath('/soapenv:Envelope/soapenv:Body/b2b:getAccountValidationInput');
			$header = $xml->xpath('/soapenv:Envelope/soapenv:Header/b2b:HeaderRequest');

			$billNumber = $nodes[0]->accountInfo[0]->AccountNumber[0];
			$TransCode 	= $nodes[0]->operationParameters[0]->TransactionReferenceCode[0];
			$TransDate 	= $nodes[0]->operationParameters[0]->TransactionDate[0];
			$InstitutionCode = $nodes[0]->institution[0]->InstitutionCode[0];
			$InstitutionName = '';//$nodes[0]->institution[0]->InstitutionName[0];
			
			$serviceName = $header[0]->serviceName[0];
			$messageID 	 = $header[0]->messageID[0];
			
			$billDate = date('Y-m-d');
			//print_r($nodes);
			//echo "hhh".$billNumber; exit;
			
			$model = Customers::findone(['No_'=>$billNumber]);
			if (!empty($model))
			{
				$balances= Customerbalance::findone([$billNumber]);
				$balance=empty($balances)?0:$balances->Balance*-1;
				
				//set content type xml in response
				Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
				$headers = Yii::$app->response->headers;
				$headers->add('Content-Type', 'text/xml');
				
				$response = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http:///www.co-opbank.co.ke/B2BStandardAPI/">
							<soapenv:Header>
								<b2b:HeaderReply>
									<messageID>'.$messageID.'</messageID>
									<statusCode>200</statusCode>
									<statusDescription>Success</statusDescription>
								</b2b:HeaderReply>
							</soapenv:Header>
							<soapenv:Body>
								<b2b:getAccountValidationOutput>
									<operationParameters>
										<TransactionReferenceCode>'.$TransCode.'</TransactionReferenceCode>
										<TransactionDate>'.$TransDate.'</TransactionDate>
										<TotalAmount>'.$balance.'</TotalAmount>
										<Currency>KES</Currency>
										<AdditionalInfo></AdditionalInfo>
									</operationParameters>
									<accountInfo>
										<AccountNumber>'.$billNumber.'</AccountNumber>
										<AccountName>'.$model->Name.'</AccountName>
									</accountInfo>
									<institution>
										<InstitutionCode>'.$InstitutionCode.'</InstitutionCode>
										<InstitutionName>'.$InstitutionName.'</InstitutionName>
									</institution>
								</b2b:getAccountValidationOutput>
							</soapenv:Body>
						</soapenv:Envelope>';
				echo $response;
			}			
		} else
		{
			//set content type xml in response
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			$headers = Yii::$app->response->headers;
			$headers->add('Content-Type', 'text/xml');
			$response = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http:///www.co-opbank.co.ke/B2BStandardAPI/">
							<soapenv:Header>
								<b2b:HeaderReply>
									<messageID></messageID>
									<statusCode>500</statusCode>
									<statusDescription>A severe problem has occurred.</statusDescription>
								</b2b:HeaderReply>
							</soapenv:Header>
						</soapenv:Envelope>';				
			
			echo $response;
		}
    }
	
	public function actionCoopnotification()
	{
		$postdata = file_get_contents("php://input");
		if (get_magic_quotes_runtime())
		{
			$postdata = stripslashes($postdata);
		}
		
		$filename = 'log/'.(string)time().'request.log';
		$req_dump = print_r($postdata, TRUE);
		$fp = fopen($filename, 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
		/*
		$postdata = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http:///www.co-opbank.co.ke/B2BStandardAPI/">
					<soapenv:Header>
						<b2b:HeaderRequest>
							<serviceName>test_service</serviceName>
							<messageID>bawdjprn32sa</messageID>
							<Connection>
								<connectionID>SOA</connectionID>
								<connectionPassword>SOA.123</connectionPassword>
							</Connection>
						</b2b:HeaderRequest>
					</soapenv:Header>
					<soapenv:Body>
						<b2b:getAccountValidationInput>
							<operationParameters>
								<TransactionReferenceCode>KRA-02-0281298</TransactionReferenceCode>
								<TransactionDate> 2016-12-06T00:00:00+03:00</TransactionDate>
								<TotalAmount>4,504.50</TotalAmount>
								<Currency>KES</Currency>
								<DocumentReferenceNumber>bfub-0128282</DocumentReferenceNumber>
								<BankCode>04</BankCode>
								<BranchCode>120</BranchCode>
								<PaymentDate>2016-12-06T00:00:00+03:00</PaymentDate>
								<PaymentReferenceCode>bfub-0128282</PaymentReferenceCode>
								<PaymentDetails>
									<PaymentCode>36</PaymentCode>
									<PaymentMode>CASH</PaymentMode>
									<PaymentAmount>4,504.50</PaymentAmount>
								</PaymentDetails>
								<AdditionalInfo>ACCRUALS- TAX</AdditionalInfo>
							</operationParameters>
							<account>
								<AccountNumber>1000011</AccountNumber>
							</account>
							<institution>
								<InstitutionCode>C-00012</InstitutionCode>
							</institution>
						</b2b:getAccountValidationInput>
					</soapenv:Body>
					</soapenv:Envelope>';
		*/
		if ($postdata!='')
		{
			$xml = simplexml_load_string($postdata);

			// register your used namespace prefixes
			$xml->registerXPathNamespace('soap-env', 'http://schemas.xmlsoap.org/soap/envelope/');
			$nodes 	= $xml->xpath('/soapenv:Envelope/soapenv:Body/b2b:getAccountValidationInput');
			$header = $xml->xpath('/soapenv:Envelope/soapenv:Header/b2b:HeaderRequest');
			
			$serviceName = $header[0]->serviceName[0];
			$messageID 	 = $header[0]->messageID[0];
			
			$connectionID = $header[0]->Connection[0]->connectionID[0];
			$connectionPassword = $header[0]->Connection[0]->connectionPassword[0];
			
			$SecretKey = Yii::$app->params['CBAKey'];
			
			$TransID = $nodes[0]->operationParameters[0]->TransactionReferenceCode;
			$TransTime = $nodes[0]->operationParameters[0]->TransactionDate;
			$TransAmount = $nodes[0]->operationParameters[0]->TotalAmount;
			$TransAmount = str_replace(',', '', $TransAmount);
			$billDate = date('Y-m-d');
			$billNumber = $nodes[0]->account[0]->AccountNumber;	
			$InstitutionCode = $nodes[0]->institution[0]->InstitutionCode[0];			
			
			$Successfull = false;
			$Customers = Customers::findone(['No_'=>$billNumber]);
			if (!empty($Customers))
			{		
				$CustomerName = $Customers->Name;
				// Post Charges to the General Journal
				$model = new GeneralJournal();	
				$types = $model->getTableSchema()->columns;
				foreach ($model AS $key => $value) 
				{
					if ($types["$key"]->type == 'string') 
					{
						$model[$key] = '';
					} else if (($types["$key"]->type == 'integer') OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal')) {
						$model[$key] = '0';
					} else if ($types["$key"]->type == 'datetime') {
						$model[$key] = '1753-01-01 00:00:00.000';
					}				
				}
				$model['Journal Template Name'] = 'STUD FEES';
				$model['Journal Batch Name'] =  'DEFAULT';
				$model['Line No_'] = rand(100,10000);
				$model['Account Type'] = 3;
				$model['Account No_'] = 46; // We should replace with the real bank code from Bank accounts Table
				$model['Posting Date'] = date('Y-m-d'); //$transactionDate
				$model['Document Type'] = 1;
				$model['Document No_'] = (string)time();
				$model['Description'] = $Customers->Name .' - '. $TransID;
				$model['VAT _'] = 0;
				$model['Amount'] = $TransAmount;
				$model['Debit Amount'] = $TransAmount;
				$model['Credit Amount'] = 0;
				$model['Amount_LCY'] = $TransAmount;
				$model['Bill-to_Pay-to No_'] = $billNumber;
				$model['Posting Group'] = 'STUDENTS';
				$model['Due Date'] = date('Y-m-d');
				$model['Document Date'] = date('Y-m-d'); //$transactionDate
				$model['Bal_ Account No_'] = $billNumber;
				$model['Bal_ Account Type'] = 1;
				if ($model->save())
				{
					$Successfull = true;
					$responseCode = 'OK';
					$responseMessage = 'SUCCESSFULL';
				} else
				{
					$Successfull = false;
					$responseCode = 'FAIL';
					$responseMessage = 'Failed';
				}
				
			} else
			{
				$Successfull = false;
				$responseCode = 'FAIL';
				$responseMessage = 'Failed';
			}
			

			//set content type xml in response
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			$headers = Yii::$app->response->headers;
			$headers->add('Content-Type', 'text/xml');
			$response = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http:///www.co-opbank.co.ke/B2BStandardAPI/">
							<soapenv:Header>
								<b2b:HeaderReply>
									<!--Optional:-->
									<messageID>'.$messageID.'</messageID>
									<statusCode>200</statusCode>
									<statusDescription>Success</statusDescription>
								</b2b:HeaderReply>
							</soapenv:Header>
							<soapenv:Body>
								<b2b:sendAccountPaymentAdviseResponse>
									<operationParameters>
										<TransactionReferenceCode>'.$TransID.'</TransactionReferenceCode>
										<TransactionDate>'.$TransTime.'</TransactionDate>
										<TransactionAmount>'.$TransAmount.'</TransactionAmount>
									</operationParameters>
									<account>
										<AccountNumber>'.$billNumber.'</AccountNumber>
										<!--Optional:-->
										<AccountName>'.$CustomerName.'</AccountName>
									</account>
									<institution>
										<InstitutionCode>'.$InstitutionCode.'</InstitutionCode>
										<!--Optional:-->
										<InstitutionName>CUEA</InstitutionName>
									</institution>
								</b2b:sendAccountPaymentAdviseResponse>
							</soapenv:Body>
						</soapenv:Envelope>';
						
			echo $response;
		} else
		{
			//set content type xml in response
			Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
			$headers = Yii::$app->response->headers;
			$headers->add('Content-Type', 'text/xml');
			$response = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http:///www.co-opbank.co.ke/B2BStandardAPI/">
							<soapenv:Header>
								<b2b:HeaderReply>
									<!--Optional:-->
									<messageID></messageID>
									<statusCode>500</statusCode>
									<statusDescription>A severe problem has occurred.</statusDescription>
								</b2b:HeaderReply>
							</soapenv:Header>
						</soapenv:Envelope>';			
			echo $response;
		}
	}	
}
