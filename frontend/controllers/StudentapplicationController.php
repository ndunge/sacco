<?php

namespace frontend\controllers;

use Yii;
use common\models\Studentapplication;
use common\models\Studentstatus;
use common\models\Academiclines;
use common\models\Collegelines;
use common\models\Applicationprogrammes;
use common\models\SponsorDetailsApp;
use common\models\KinDetailsApp;
use common\models\Customers;
use common\models\Profiles;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentapplicationController implements the CRUD actions for Studentapplication model.
 */
class StudentapplicationController extends Controller
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
	
	public function beforeAction($action)  
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    } 

    /**
     * Lists all Studentapplication models.
     * @return mixed
     */
    public function actionIndex()
    {
        // echo "Good";exit;
		$baseUrl = Yii::$app->request->baseUrl;
		$identity = Yii::$app->user->identity;
		$ProfileID = $identity->ProfileID;
		$customerid=$identity->Userid;
		$sql = "SELECT *
                      FROM [KENCOM SACCO SOCIETY  LTD\$Customer]  
            
            WHERE No_ = '$customerid'";
		$result = Customers::findBySql($sql)->asArray()->all();
		
		// $ApprovalStatus = array('','Open','Approved','Pending Approval','Pending Prepayment','Rejected');

		$channel = array();
		foreach ($result AS $key => $row) 
		{
			//extract($row); 
			$channel[] = array(
								$row['No_'],
								$row['Name'],
								$row['Address'],
								// $ApprovalStatus[$row['ApprovalStatus']],
								 date("d/m/Y", strtotime($row['Date of Join'])),				
							);
		}  		
		$rss = $channel;
		$json = json_encode($rss);		
		
        return $this->render('index', ['json' => $json]);
    }

    /**
     * Displays a single Studentapplication model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$baseUrl = Yii::$app->request->baseUrl;
        $identity = Yii::$app->user->identity;
        $customerid=$identity->Userid;
    	$model2= Customers::findbysql('SELECT * from [TRAINED DB$Customer] where No_ = \''.$customerid.'\'')->one();
    	//print_r($model2);exit;
        return $this->render('view', [
            'model2' => $model2,
        ]);
    }

    /**
     * Creates a new Studentapplication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    	

		$identity = Yii::$app->user->identity;
		$ProfileID = $identity->ProfileID;
		$customerid=$identity->Userid;
		// print_r($customerid);exit;
		
        // $model = new Customers();
        $model2=Customers::findbysql('SELECT * from [TRAINED DB$Customer] 
        where No_ = \''.$customerid.'\'')->one();
        // print_r($customersmodel);exit;

		// $SponModel = SponsorDetailsApp::findone(['ApplicationNo' => $model->ApplicantNo]);
		// $KinModel = KinDetailsApp::findone(['ApplicationNo' => $model->ApplicantNo]);
		// $model->Name = $identity->FirstName.' '. $identity->LastName;
		// $model->Email  = $identity->Email;
        //$model2 = new Customers();
        $params = Yii::$app->request->post();      

		if (!empty($params))
		{
			print_r($params);exit;
			
			$types = $model->getTableSchema()->columns;
			$Studentstatus = Studentstatus::find()->where("[Default Status] = 1")->orderBy('Description')->one();
			foreach($model AS $key => $value)
			{
				$key1 = str_replace(" ","_",$key);
				if (array_key_exists($key1,$params))
				{
					$model[$key] = $params[$key1];		
				} else
				{					
					if ($types["$key"]->type == 'string') 
					{
						$model[$key] = '';	
					} else if (($types["$key"]->type == 'integer')  OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal'))
					{
						$model[$key] = '0';	
					} else if ($types["$key"]->type == 'datetime')
					{
						$model[$key] = '1753-01-01 00:00:00.000';	
					}
					
					//
				}	
			}
			
			$model['ApplicantNo'] = (string)time();
			$model['ApplicationDate'] = date('Y-m-d');
			$model['ProfileID'] = $ProfileID;
			$model['ApprovalStatus'] = 1;
			$model['ApplicationSubmitted'] = 1;
			$model['StudentStatus'] = $Studentstatus['StudentStatusID']=0;

            $params = Yii::$app->request->post();
			//print_r($params); exit;
			//print_r($model); exit;
			if ($model->save())
            {
				$school=$params['school'];

             

                 $college=$params['college'];

              
				 
			
				
			
				
				
				
				if (empty($KinModel))
				{
					$KinModel = new KinDetailsApp();
					$KinModel['ApplicationNo'] = $model->ApplicantNo;
				}
				
				$KinModel['Name'] = $params['kin']['Name'];
				$KinModel['Address'] = $params['kin']['Address'];
				$KinModel['Telephone'] = $params['kin']['Telephone'];
				$KinModel['Email'] = $params['kin']['Email'];
				$KinModel['Occupation'] ='';
				$KinModel['Address1'] = '';
				$KinModel['Office Tel No'] ='';
				$KinModel['Home Tel No'] = '';
				$KinModel['Remarks'] = '';
				$KinModel->save();	
				
				if ( count($_FILES) > 0 )  $this->upload($model->ApplicantNo);
                return $this->redirect(['index']);
			} else
			{
				$errors = $model->getErrors();
						$founderrors = '';
						foreach ($errors AS $key => $value)
						{
							foreach ($value AS $key1 => $avalue)
							{
					
								$founderrors .= $avalue;
							}
						 }
                print_r($errors);
            }
        } else {
			
            $model['DOB_'] = date('Y-m-d');
			
            return $this->render('create', [ 
				'model' => $model,
				'model2' => $model2,
				
		 ]);
        }
			


        }

    /**
     * Updates an existing Studentapplication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$identity = Yii::$app->user->identity;
		$ProfileID = $identity->ProfileID;
		$customerid=$identity->Userid;
       // $model = $this->findModel($id);
        $model2 = Customers::findone(['No_' => $customerid]);
        // print_r($model2);exit;
		// $pmodel = Applicationprogrammes::find()->where("ApplicationNo = '$id'")->asArray()->all();
		// $programmes = [];
		
		// foreach ($pmodel AS $key => $row)
		// {
		// 	extract($row);
		// 	$programmes[$OptionID] = $ProgrammeID;
		// }
		//print_r($programmes); exit;
		// $schoolmodel = Academiclines::find()->where("ApplicantNo = '$id'")->asArray()->all();
		
	
  //       $channel = array();

		// foreach ($schoolmodel AS $key => $row)
  //       {
		// 	extract($row);
                                                                   
  //           $channel[] = array(
  //                   '<input type="text" style="width:100%" id="school['.$Id.'][Name]" name="school['.$Id.'][Name]" value="'.$Description.'"></input>', 
  //                   '<input type="text" style="width:100%" id="school['.$Id.'][Address]" name="school['.$Id.'][Address]" value="'. $Address1.'"></input>',
  //                   '<input type="text" style="width:100%" id="school['.$Id.'][Month-Year1]" name="school['.$Id.'][Month-Year1]" value="'.$MonthYear1 .'"></input>',
  //                   '<input type="text" style="width:100%" id="school['.$Id.'][Month-Year2]" name="school['.$Id.'][Month-Year2]" value="'.$MonthYear2.'"></input>',                 
  //               );
  //       }     
       // for($i=0;$i<=5-count($schoolmodel);$i++)
       //  {                                                                  
       //      $channel[] = array(
			    //     '<input type="hidden" style="width:100%" id="school['.$i.'][New]" name="school['.$i.'][New]"></input>',
       //              '<input type="text" style="width:100%" id="school['.$i.'][Name]" name="school['.$i.'][Name]"></input>', 
       //              '<input type="text" style="width:100%" id="school['.$i.'][Address]" name="school['.$i.'][Address]"></input>',
       //              '<input type="text" style="width:100%" id="school['.$i.'][Month-Year1]" name="school['.$i.'][Month-Year1]"></input>',
       //              '<input type="text" style="width:100%" id="school['.$i.'][Month-Year2]" name="school['.$i.'][Month-Year2]"></input>',                 
       //          );
       //  }     		
        // $rss = $channel;
        // $json1 = json_encode($rss);
      
        // $channel2 = array();
		
        // for($j=0;$j<=5;$j++)
        // {
        //     $fieldnames = $j."_Descsriptionn";
                                                         
        //     $channel2[] = array(
        //             '<input type="text" width="100%" id="college['.$j.'][CollegeName]" style="width:100%" name="college['.$j.'][CollegeName]" ></input>', 
        //             '<input type="text" width="100%" id="college['.$j.'][FromYear]" style="width:100%" name="college['.$j.'][FromYear]" ></input>',
        //             '<input type="text" width="100%" id="college['.$j.'][ToYear]" style="width:100%" name="college['.$j.'][ToYear]" </input>',
        //             '<input type="text" width="100%" id="college['.$j.'][Award]" style="width:100%" name="college['.$j.'][Award]" ></input>', 
        //         );
        // }     
        // $rss2 = $channel2;
        // $json2 = json_encode($rss2);		
		
		// $SponModel = SponsorDetailsApp::findone(['ApplicationNo' => $id]);
		// $KinModel = KinDetailsApp::findone(['ApplicationNo' => $id]);
		//$Schoolmodel=Academiclines::findone(['ApplicationNo' => $id]);
		
		$params = Yii::$app->request->post();
		if (!empty($params))
		{
			// print_r($params);exit;
			$types = $model2->getTableSchema()->columns;
			foreach($model2 AS $key => $value)
			{
				$key1 = str_replace(" ","_",$key);
				if (($key=='No_') or ($key == 'ProfileID'))
				{
				}
				else if (array_key_exists($key1,$params))
				{
					$model2[$key] = $params[$key1];		
				} else
				{					
					if ($types["$key"]->type == 'string') 
					{
						$model2[$key] = '';	
					} else if (($types["$key"]->type == 'integer')  OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal'))
					{
						$model2[$key] = '0';	
					} else if ($types["$key"]->type == 'datetime')
					{
						$model2[$key] = '1753-01-01 00:00:00.000';	
					}
					
					//
				}	
			}
			
			if ($model2->save())
			{
				
				
				
				// if (empty($SponModel))
				// {
				// 	$SponModel = new SponsorDetailsApp();
				// 	$SponModel['ApplicationNo'] = $id;
				// }			
				//print_r($params); exit;
				// $SponModel['Names'] = $params['sponsor']['Name'];
				// $SponModel['Address'] = $params['sponsor']['Address'];
				// $SponModel['Telephone'] = $params['sponsor']['Telephone'];
				// $SponModel['Email'] = $params['sponsor']['Email'];
				// $SponModel['Contact Person'] ='';
				// $SponModel['Remarks'] = '';
				// $SponModel->save();
				
				// if (empty($KinModel))
				// {
				// 	$KinModel = new KinDetailsApp();
				// 	$KinModel['ApplicationNo'] = $id;
				// }				
				// $KinModel['Name'] = $params['kin']['Name'];
				// $KinModel['Address'] = $params['kin']['Address'];
				// $KinModel['Telephone'] = $params['kin']['Telephone'];
				// $KinModel['Email'] = $params['kin']['Email'];
				// $KinModel['Occupation'] ='';
				// $KinModel['Address1'] = '';
				// $KinModel['Office Tel No'] ='';
				// $KinModel['Home Tel No'] = '';
				// $KinModel['Remarks'] = '';
				// $KinModel->save();				
				
				return $this->redirect(['index']);	
			} else
			{
				print_r($model->getErrors());exit;

			}            
        } else {
			return $this->render('update', [ 'model2' => $model2,]);
        }
    }

    /**
     * Deletes an existing Studentapplication model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

     public function actionDashbord()
    {
        return $this->render('dashboard');
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Studentapplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Studentapplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Studentapplication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionAcceptoffer($id)
    {
        $model = $this->findModel($id);
		$model['Offer Accepted'] = 1;
		$model['StudentStatus'] = 'DEFAULT';
		if ($model->save())
		{
			return $this->redirect(['view', 'id' => $id]);
			//return $this->render('view', [ 'model' => $this->findModel($id),]);
		} else
		{
			print_r($model->getErrors()); exit;
		}            
    }

        
    
	
	public function actionDeferoffer($id)
    {
        $model = $this->findModel($id);
		$model['Offer Defered'] = 1;
		if ($model->save())
		{
			return $this->render('view', [ 'model' => $this->findModel($id),]);
		} else
		{
			print_r($model->getErrors()); exit;
		}            
    }

     public function upload($pk)
     {

     	$model = new Studentapplication();
     	$params = Yii::$app->request->post();
        $identity = Yii::$app->user->identity;
		$ProfileID = $identity->ProfileID;
		$file =  UploadedFile::getInstanceByName('myfile');
		$file2 =  UploadedFile::getInstanceByName('thefile');
        $Filename = $file->name;
        $Filesize = $file->size;

        $Filename2 = $file2->name;
        $Filesize2 = $file2->size;
        // $Filename = basename($_FILES["myfile"]["name"]);

        

        // print_r($Filename); exit;
        // $AppNo = $_POST['ApplicantNo'];
        // $Description = $_POST['Description'];
       // $model['Description'] = $params['myfile'];
        
        // $AssignmentSubmissionID = $_REQUEST['AssignmentSubmissionID'];
        
        $target_dir = Yii::$app->params['documentpath']; 

        $MaxFileSize = Yii::$app->params['MAX_FILE_SIZE'];
        $target_file = $target_dir . $Filename;
        $target_file = $target_dir . $Filename2;

        
        //$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if ($Filesize > $MaxFileSize) 
        {
            echo "Sorry, the file is too large.";	 
        } else
        {

            if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $target_file)) 
            {
                echo "The file ". basename( $_FILES["myfile"]["name"]). " has been uploaded.";
                $model = Studentapplication::find()->where("ApplicantNo = $pk")->one();
                // print_r($model); exit();
                // $model['ApplicantNo'] = $params['ApplicantNo'];
                // $model->Description = $Description;
                // $model->Description = $Description;
                $model->FileName =  $Filename;
                // $model->ApplicantNo = $AppNo;
                // $model->ApplicantNo = $App;
                // $model->CreatedDate = date('Y-m-d h:i:s');
                $model->save();
            } else 
            {
                echo "Sorry, there was an error uploading your file.";
            }
        }

         if ($Filesize2 > $MaxFileSize) 
        {
            echo "Sorry, the file is too large.";	 
        } else
        {

            if (move_uploaded_file($_FILES["thefile"]["tmp_name"], $target_file)) 
            {
                echo "The file ". basename( $_FILES["thefile"]["name"]). " has been uploaded.";
                $model = Studentapplication::find()->where("ApplicantNo = $pk")->one();
                // print_r($model); exit();
                // $model['ApplicantNo'] = $params['ApplicantNo'];
                // $model->Description = $Description;
                // $model->Description = $Description;
                $model->Description =  $Filename2;
                // $model->ApplicantNo = $AppNo;
                // $model->ApplicantNo = $App;
                // $model->CreatedDate = date('Y-m-d h:i:s');
                $model->save();
            } else 
            {
                echo "Sorry, there was an error uploading your file.";

            }
        }
        return $this->redirect(['view', 'id' => $pk]);
    }

    public function Download_docs($pk)
    {
        header("Content-Type: application/octet-stream");
        $baseUrl = Yii::$app->request->baseUrl;
        $filename = $_REQUEST['$filename'];
        $documentpath = Yii::$app->params['documentpath'];
        $myfilename = $documentpath.''.$filename;

        ini_set('max_execution_time', 5*60);
        if (file_exists($myfilename)) {
            Yii::$app->response->sendFile($myfilename);
        } else
        {
            echo "File not found ".$filename;
        }        
    }
	
    public function actionExisting()
    {
		$params = Yii::$app->request->post();
		$identity = Yii::$app->user->identity;
		
		$msg = 'Please enter Your activation details below';
		
		if ((!empty($params)) and ($params['StudentNo']!= '') and ($params['ActivationCode']!=''))
		{
			$StudentNo 		= isset($params['StudentNo']) ? $params['StudentNo'] : '';
			$ActivationCode = isset($params['ActivationCode']) ? $params['ActivationCode'] : '';
			
			$model = Customers::findone(['No_' =>$StudentNo, 'Activation Code' => $ActivationCode ]);
			
			if (!empty($model))
			{
				if ($model['Activated']==1)
				{
					$model->Activated = 1;
					$model->save();
				} else
				{
					$Profiles = Profiles::findone(['ProfileID' => $identity->ProfileID]);
					$Profiles->CustomerID = $model['No_'];
					$Profiles->AccountTypeID = 2;
					$Profiles->save();
					return $this->redirect(['student/update', 'id' => $model['No_']]);
				}
				return $this->render('_formexisting', ['model' => $params, 'msg' => 'The account you selected has already been activated']);				
			} else
			{
				return $this->render('_formexisting', ['model' => $params, 'msg' => 'The Details you entered are not valid']);
			}
		} else
		{
			$model = [];
			$model['StudentNo'] ='';
			$model['ActivationCode'] ='';
			return $this->render('_formexisting', ['model' => $model, 'msg' => $msg]); 
		}
    }	
}
