<?php

namespace backend\controllers;
require_once 'includes/mailsender.php';

use Yii;

use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

use common\models\UserSetup;
use common\models\Employees;
use common\models\Resources;
use common\models\Profiles;
use common\models\User;
use common\models\Lecturerunits;
use common\models\Examregistration;




/**
 * ProfilesController implements the CRUD actions for Profiles model.
 */
class ProfilesController extends Controller
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
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'activate') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Lists all Profiles models.
     * @return mixed
     */
    public function actionResources() {
      $employees = Employees::find()
        ->all();

      foreach ($employees as &$employee) {
        $email = $employee['Company E-Mail'];
        $user = UserSetup::find()
          ->where(['E-Mail' => $email])
          ->asArray()->one();
        $userID = $user['User ID'];
        $resource = Resources::find()
          ->where(['[Time Sheet Owner User ID]' => $userID])
          ->asArray()->one();
        $employee['Resource No_'] = $resource['No_'];
        if($resource['No_'])
          $employee->save();
      }
      Yii::$app->getSession()
        ->setFlash('msg', 'Employees Resources Have Been updated');
      return $this->redirect(Yii::$app->request->referrer);
      // print_r($employees); exit;
        // return $this->render('index', [
        //     'dataProvider' => $dataProvider,
        // ]);
    }

    /**
     * Lists all Profiles models.
     * @return mixed
     */
    public function actionSwap($to)
    {
		// 4 is lecturer
		// 5 is hod
        //print_r('on it'); exit;
		$identity = Yii::$app->user->identity; 					
		$identity->AccountTypeID = intval($to); 
		if ($identity->save()) { 
			$msg = 'you are now logged in as lecturer'; 
		} else {
			$msg = 'Failed to update account';
		}
		Yii::$app->getSession()
				->setFlash('msg', $msg);
			  return $this->goHome();
    }
	
    /**
     * Lists all Profiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Profiles::find()
				->select(['*','Employee No'=>'CustomerID','names'=>'[FirstName]'.'+'.'Space(1)'.'+'.'Space(1)'.'+'.'[MiddleName]'.'+'.'Space(1)'.'+'.'[LastName]'])->asArray(),
        ]);
        $q = Profiles::find()->select(['*','Employee No'=>'CustomerID','names'=>'[FirstName]'.'+'.'Space(1)'.'+'.'Space(1)'.'+'.'[MiddleName]'.'+'.'Space(1)'.'+'.'[LastName]'])->where(['AccountTypeID'=>4])->asArray()->all();
       //print_r(($q)); exit;
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'dataSet' => $q
        ]);
    }

    /**
     * Displays a single Profiles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model=Profiles::find()
            ->select(['*','names'=>'[FirstName]'.'+'.'Space(1)'.'+'.'Space(1)'.'+'.'[MiddleName]'.'+'.'Space(1)'.'+'.'[LastName]'])
            ->where(['ProfileID'=>$id])
            ->asArray()
            ->one();
			//print_r($model);exit;
		$model2=Lecturerunits::find()
		       ->select (['*'])
			   ->where(['Lecturer'=>$model['CustomerID']])
			   ->asArray()
			   ->all();
			   
                		

        // print_r($model);
        // exit;

        return $this->render('view', [
            'model' => $model,
			'model2' => $model2
        ]);
    }

    /**
      * Creates a new Profiles model.
      * If creation is successful, the browser will be redirected to the 'view' page.
      * @return mixed
      */
      public function actionCreate()
      {
		// echo "we are here";exit;

        $params = Yii::$app->request->post();

        $model = new Profiles();
		
        $approverid='';

        //$approvers=User::find()->asArray()->orderBy('User Name')->all();

       
		 $Employees = ArrayHelper::map(Employees::find() ->all(), 'No_',
            /*->where("[No_] not in (SELECT [CustomerID]
				FROM [CUEA\$Profiles]) ")*/
           

			

                function($model, $names) {
                        return $model['First Name'].' '.$model['Middle Name'].' '.$model['Last Name'];
                }
            );
			
      if(!empty($params))
      {
		
        //print_r($params );exit;
        if ( !isset($params['AccountTypeID']) || !isset($params['Email']) || !isset($params['No_'])  ) {
          Yii::$app->getSession()
            ->setFlash('msg', 'All Inputs are required');
          return $this->redirect(Yii::$app->request->referrer);
        }

        $empDetail=(array) json_decode($this->actionEmployee($params['No_']));

        $firstname = $empDetail['First Name'];
        $middlename = $empDetail['Middle Name'];
        $lastname = $empDetail['Last Name'];
        $fullname = $empDetail['First Name'].' '.$empDetail['Middle Name'].' '.$empDetail['Last Name'];
        $user_name = strtolower($empDetail['First Name'].'.'.$empDetail['Middle Name'].'.'.$empDetail['Last Name']);

        // print_r($user_name);
        // exit;
          $Campus= $params['Campus_Code']; 
		  //print_r($Campus);exit; 
        $UserSecirityID=Profiles::findBySql("select newid() as ID")->asArray()->one()['ID'];


        $types = $model->getTableSchema()->columns;

        foreach ($model AS $key => $value)
        {
          if ($types["$key"]->autoIncrement == '1') {

          }else
          {
            $key1 = str_replace(" ", "_", $key);
            if (array_key_exists($key1, $params))
            {
              $model[$key] = $params[$key1];

            }  else
            {
              if ($types["$key"]->type == 'string') {
                $model[$key] = ' ';
              } else if (($types["$key"]->type == 'integer') OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal')) {
                $key = str_replace("?", "\?", $key);
                $model[$key] = '0';
              } else if ($types["$key"]->type == 'datetime') {
                $model[$key] = '1753-01-01 00:00:00.000';
              }
            }

            // $Password = $params['Password'];
            // $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            // $Password = hash('sha512', $Password . $random_salt);
            // $model->Password = $Password;
            // $model->Salt = $random_salt;


            $model['CustomerID']=$params['No_'];
            $model['EmployeeID']=$params['No_'];
            $model['FirstName']=$firstname;
            $model['MiddleName']=$middlename;
            $model['LastName']=$lastname;
            $model['UserName']=$params['No_'];
			//$model['Campus_Code']=$params['Campus_Code'];
			
			//Exam Registration model
			
							
			
						
          }
        }
		
		foreach(array_unique($params['ProgrammeCourses']) as $key => $course) {
			//lecturer units model
			$lecturerunitsmodel= new Lecturerunits();
			$lecturerunitsmodel['Programme']=$params['ProgrammeCode'];
			$lecturerunitsmodel['Stage']='';
			$lecturerunitsmodel['Lecturer']=$params['No_'];
			$lecturerunitsmodel['Campus Code']=$Campus;
			$lecturerunitsmodel['Semester']='';
			$lecturerunitsmodel['Remarks']='';
			$lecturerunitsmodel['No_ Of Hours Contracted']='2';
			$lecturerunitsmodel['Available From']='2017-01-12 00:00:00.000';
			$lecturerunitsmodel['Available To']='2017-01-12 00:00:00.000';
			$lecturerunitsmodel['Minimum Contracted']='0.00000000000000000000';
			$lecturerunitsmodel['Class']='R12';
			$lecturerunitsmodel['Unit Class']='R12';
			$lecturerunitsmodel['Full Time_Part Time']='1';
			$lecturerunitsmodel['Unit'] = $course;
			
			//print_r($lecturerunitsmodel);exit;
			
			try {
				$lecturerunitsmodel->save();
			}
			catch (\Exception $e) {
				//print_r($e); EXIT;
				Yii::$app->getSession()
					->setFlash('msg', 'Records already exists');
				return $this->redirect(Yii::$app->request->referrer);
				
			}
		}
		/* $exam_reg = new Examregistration();
		$exam_reg['Campus Code'] = $params['Campus_Code'];
		$exam_reg->save(); */
		/*
		$exam_reg = new Examregistration();
		$exam_reg['Programme ID'] = $params['ProgrammeCode'];
		$exam_reg['Term ID'] = '';
		$exam_reg['Stage ID'] = '';
		$exam_reg['Academic Year'] = '2016/2017';
		$exam_reg['Student ID'] = '';
		$exam_reg['Exam Type ID'] = 'CAT';
		$exam_reg['Exam Component ID'] = '';
		$exam_reg['ProgrammeCourseID'] = $params['ProgrammeCourses'];
		$exam_reg['Exam SubComponent ID'] = '';
		$exam_reg['Session'] = '';
		$exam_reg['Class ID'] = '';
		$exam_reg['Remarks'] = '';
		$exam_reg['Actual Mark'] = '0';
		$exam_reg['Final Exam Contribution Mark'] = '0';
		$exam_reg['Student Name'] = '';
		$exam_reg['Attended'] = '1';
		$exam_reg['CandidateType'] = '1';
		$exam_reg['Exam Setup Code'] = '';
		$exam_reg['Current Exam Contribution Mark'] = '0';
		$exam_reg['Irregularity Code'] = '';
		$exam_reg['Penalty code'] = '';
		$exam_reg['Registration Date'] ='2017-01-12 00:00:00.000';
		$exam_reg['Submitted'] = '1';
		$exam_reg['Edited'] = '1';
		$exam_reg['Passed'] = '1';
		$exam_reg['Qualifys for Scholarship'] = '0';
		$exam_reg['Exam Registration No'] = '';
		$exam_reg['Reg_ Transacton ID'] = '';
		$exam_reg['ExternalExaminer'] = 'comments';
		$exam_reg['InternalExaminer'] = 'comments';
		
		$exam_reg->save();
		
		
		$exam_reg1 = new Examregistration();
		$exam_reg1['Programme ID'] = $params['ProgrammeCode'];
		$exam_reg1['Term ID'] = '';
		$exam_reg1['Stage ID'] = '';
		$exam_reg1['Academic Year'] = '2016/2017';
		$exam_reg1['Student ID'] = '';
		$exam_reg1['Exam Type ID'] = 'FINAL EXAM';
		$exam_reg1['Exam Component ID'] = '';
		$exam_reg1['ProgrammeCourseID'] = $params['ProgrammeCourses'];
		$exam_reg1['Exam SubComponent ID'] = '';
		$exam_reg1['Session'] = '';
		$exam_reg1['Class ID'] = '';
		$exam_reg1['Remarks'] = '';
		$exam_reg1['Actual Mark'] = '0';
		$exam_reg1['Final Exam Contribution Mark'] = '0';
		$exam_reg1['ExternalExaminer'] = 'comments';
		$exam_reg1['InternalExaminer'] = 'comments';
		$exam_reg1['Student Name'] = '';
		$exam_reg1['Attended'] = '1';
		$exam_reg1['CandidateType'] = '1';
		$exam_reg1['Exam Setup Code'] = '';
		$exam_reg1['Current Exam Contribution Mark'] = '0';
		$exam_reg1['Irregularity Code'] = '';
		$exam_reg1['Penalty code'] = '';
		$exam_reg1['Registration Date'] ='2017-01-12 00:00:00.000';
		$exam_reg1['Submitted'] = '1';
		$exam_reg1['Edited'] = '1';
		$exam_reg1['Passed'] = '1';
		$exam_reg1['Qualifys for Scholarship'] = '0';
		$exam_reg1['Exam Registration No'] = '';
		$exam_reg1['Reg_ Transacton ID'] = '';
		
		$exam_reg1->save();
		
	/* 	$exam_reg2 = new Examregistration();
		$exam_reg2['Programme ID'] = $params['ProgrammeCode'];
		$exam_reg2['Term ID'] = '';
		$exam_reg2['Stage ID'] = '';
		$exam_reg2['Academic Year'] = '2016/2017';
		$exam_reg2['Student ID'] = '';
		$exam_reg2['Exam Type ID'] = 'Internal Examiner';
		$exam_reg2['Exam Component ID'] = '';
		$exam_reg2['ProgrammeCourseID'] = $params['ProgrammeCourses'];
		$exam_reg2['Exam SubComponent ID'] = '';
		$exam_reg2['Session'] = '';
		$exam_reg2['Class ID'] = '';
		$exam_reg2['Remarks'] = '';
		$exam_reg2['Actual Mark'] = '0';
		$exam_reg2['Final Exam Contribution Mark'] = '0';
		$exam_reg2['Student Name'] = '';
		$exam_reg2['Attended'] = '1';
		$exam_reg2['CandidateType'] = '1';
		$exam_reg2['Exam Setup Code'] = '';
		$exam_reg2['Current Exam Contribution Mark'] = '0';
		$exam_reg2['Irregularity Code'] = '';
		$exam_reg2['Penalty code'] = '';
		$exam_reg2['Registration Date'] ='2017-01-12 00:00:00.000';
		$exam_reg2['Submitted'] = '1';
		$exam_reg2['Edited'] = '1';
		$exam_reg2['Passed'] = '1';
		$exam_reg2['Qualifys for Scholarship'] = '0';
		$exam_reg2['Exam Registration No'] = '';
		$exam_reg2['Reg_ Transacton ID'] = '';
		
		$exam_reg2->save(); */
		

        // TODO:  $userModel = new User();
        // $userModel = new User();
        //
        // $types = $userModel->getTableSchema()->columns;
        //
        // foreach ($userModel AS $key => $value)
        // {
        //   if ($types["$key"]->autoIncrement == '1') {
        //
        //   }else
        //   {
        //     $key1 = str_replace(" ", "_", $key);
        //     if (array_key_exists($key1, $params))
        //     {
        //       $userModel[$key] = $params[$key1];
        //
        //     }  else
        //     {
        //       if ($types["$key"]->type == 'string') {
        //         $userModel[$key] = ' ';
        //       } else if (($types["$key"]->type == 'integer') OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal')) {
        //         $key = str_replace("?", "\?", $key);
        //         $userModel[$key] = '0';
        //       } else if ($types["$key"]->type == 'datetime') {
        //         $userModel[$key] = '1753-01-01 00:00:00.000';
        //       }
        //     }
        //
        //     // $userModel['User Name']=$user_name;
        //     $userModel['User Name']=$params['No_'];
        //     $userModel['Full Name']=$fullname;
        //     $userModel['User Security ID']=$UserSecirityID;
        //
        //
        //   }
        // }

        // $userSetupModel = new UserSetup();
        //
        // $types = $userSetupModel->getTableSchema()->columns;
        //
        // foreach ($userSetupModel AS $key => $value)
        // {
        //   if ($types["$key"]->autoIncrement == '1') {
        //
        //   }else
        //   {
        //     $key1 = str_replace(" ", "_", $key);
        //     if (array_key_exists($key1, $params))
        //     {
        //       $userSetupModel[$key] = $params[$key1];
        //
        //     }  else
        //     {
        //       if ($types["$key"]->type == 'string') {
        //         $userSetupModel[$key] = ' ';
        //       } else if (($types["$key"]->type == 'integer') OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal')) {
        //         $key = str_replace("?", "\?", $key);
        //         $userSetupModel[$key] = '0';
        //       } else if ($types["$key"]->type == 'datetime') {
        //         $userSetupModel[$key] = '1753-01-01 00:00:00.000';
        //       }
        //     }
        //
        //     // print_r(Yii::$app->user->identity); exit;
        //     $userSetupModel['User ID']=$user_name;
        //     // $userSetupModel['Approver ID']=$params['ApproverID'];
        //     $userSetupModel['Employee No_']=$params['No_'];
        //   }
        // }

        $userSetupModel = UserSetup::find()
          ->where([ 'Employee No_' => $params['No_'] ])
          ->one();
		  
		  //print_r($userSetupModel);exit;

        if (empty($userSetupModel)) {
          Yii::$app->getSession()
            ->setFlash('msg', 'Could not retrieve User Setup Record');
          return $this->redirect(Yii::$app->request->referrer);
        }

        $company = Yii::$app->params['tablePrefix'];
        $sql = "SELECT * FROM [".$company."Employee] WHERE [No_]='".$params['No_']."'";
        $employee  = Employees::findBySql($sql)->asArray()->one();

        $model->Salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        // print_r($model); exit;

        $transaction = Yii::$app->db->beginTransaction();

        if ($model->save())
        {
          // if($userModel->save()){
          if(1){

            if($userSetupModel->save()){
				$identity = Yii::$app->user->identity;
				//print_r($identity);exit;
				//print_r($identity->EmployeeID == $params['EmpNo'] ? 'yep' : 'nop'); exit;
				$identity = Yii::$app->user->identity;
				if ( $identity->EmployeeID == $params['EmpNo'] 
						&& $identity->AccountTypeID == 5 ) {
					
					$identity->AssignedUnits = intval(1); 
					if ($identity->save()) {
						//$link = Yii::$app->request->baseUrl . '/profiles/swap';
						$profile_swap_url = '/profiles/swap?to=4';
						$msg = 'Successfully assigned the units to yourself';
						$msg .= "To login as a lecture click <a href='$profile_swap_url' > here <a>";
						//print_r(Yii::$app->request->baseUrl . '+++++' . '/profiles/swap'); exit;
					} else {
						$msg = 'Failed to update accountS';
					}
					Yii::$app->getSession()
							->setFlash('msg', $msg);
						  return $this->redirect(Yii::$app->request->referrer);
				} else {

				  $transaction->commit();

				  if (isset($params['Email'])) {
					// $link = "<a href='". Url::to(['profiles/activate', 'token' => $model->Salt], true) . "'> link </a>";
					$link = "<a href='". "staff.cuea.edu/profiles/activate?token=" . $model->Salt . "'> link </a>";
					$message = "
					  <p> <b> Hello $fullname </b>  </p>
					  <p> Your online account has been set up. </p>
					  <p> Your Account username is : $model->EmployeeID </p>
					  <p> Follow this $link to complete setting up your account </p>
					";

					/*
					Yii::$app->mailer->compose()
					  ->setSubject('CUEA Account Activation')
					  ->setFrom(Yii::$app->params['adminEmail'])
					  ->setTo($params['Email'])
					  ->setHtmlBody($message)
					  ->send();
					  */
					  SendMail(array(array('Name' => $fullname, 'Email' => $model['Email'])),'CUEA Account Activation',$message);
			//echo "hey";exit;
				  }


				  Yii::$app->getSession()->setFlash('msg', 'An Email has been sent to the user with further instructions');
				  return $this->redirect(['view',
					'id' => $model->ProfileID]);
					
				}
              }

          }
        }

        $transaction->rollBack();


      }else
      {
        return $this->render('create', [
          'model' => $model,
          //'approvers'=>$approvers,
          'employees'=>$Employees,
          'approverid'=>$approverid,
        ]);
      }
    }

    /**
     * Updates an existing Profiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = Profiles::find()
          ->where(['CustomerID' => $id])
          ->one();

        if (empty($model)) {
          Yii::$app->getSession()->setFlash('msg', 'No user with the provided id!');
          return $this->redirect(Yii::$app->request->referrer);
        }

        $params = Yii::$app->request->post();

        if (!empty($params)) {
          // print_r($params); exit;
          $model->Email = $params['Email'];
          $model->AccountTypeID = $params[' ID'];
          if ($model->save())
            return $this->redirect(Yii::$app->request->referrer);
        }

        return $this->render('update', [
            'model' => $model,
			
        ]);
    }

    /**
     * Deletes an existing Profiles model.
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
     */
    public function actionMail($id) {

      $model = Profiles::find()
        ->where(['CustomerID' => $id])
        ->one();

      if (empty($model)) {
        Yii::$app->getSession()->setFlash('msg', 'No user with the provided id!');
        return $this->redirect(Yii::$app->request->referrer);
      }

      // $link = "<a href='". Url::to(['profiles/activate', 'token' => $model->Salt], true) . "'> link </a>";
      $link = "<a href='". "staff.cuea.edu/profiles/activate?token=" . $model->Salt . "'> link </a>";
      $fullname = $model['FirstName'].' '.$model['MiddleName'].' '.$model['LastName'];
      $message = "
        <p> <b> Hello $fullname </b>  </p>
        <p> Your online account has been set up. </p>
        <p> Your Account username is : $model->EmployeeID </p>
        <p> Follow this $link to complete setting up your account </p>
      ";

      /*Yii::$app->mailer->compose()
        ->setSubject('CUEA Account Activation')
        ->setFrom(Yii::$app->params['adminEmail'])
        ->setTo($model['Email'])
        ->setHtmlBody($message)
        ->send();?*/
		
		SendMail(array('Name' => $fullname, 'Email' => $model['Email']),'CUEA Account Activation',$message);
		//echo "hey";exit;

      Yii::$app->getSession()->setFlash('msg', 'An Email has been sent to the user with further instructions');
      // return $this->redirect(['view','id' => $model->ProfileID]);
      return $this->redirect(Yii::$app->request->referrer);

    }

    /**
     * Finds the Profiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEmployee ($empno)
    {
        $description = Employees::find()
            ->select(['*','names'=>'[First Name] '.'+'.'SPACE(1)'.'+'.'[Middle Name]'.'+'.'SPACE(1)'.'+'.'[Last Name]','department'=>'[Global Dimension 1 Code]','email'=>'E-Mail','idno'=>'[ID Number]'])
            ->where(['No_'=>$empno])
            ->asArray()
            ->one();

        return \yii\helpers\Json::encode($description);

    }


  /**
  * Displays a single Profiles model.
  * @param integer $id
  * @return mixed
  */
  public function actionActivate($token = null) {

    if (isset($token)) {

      $model = Profiles::find()
        ->where(['Salt' => $token])
        ->one();

      if ($model) {
        //Yii::$app->getSession()->setFlash('message', 'Token Invalid or Account Already activated');
        return $this->render('activate', [ 'model' => $model ]);
      } else {
        Yii::$app->getSession()->setFlash('message', 'Validation Token Invalid or Account Already Activated');
        return $this->goHome();
      }


    } else {

      $params = Yii::$app->request->post();
      if (empty($params)) {
        Yii::$app->getSession()->setFlash('message', 'Password is Required');
        return $this->goHome();
      }
      else {
		//  print_r($params); exit;
        $token = $params['token'];
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
        //$Password = hash('sha512', $params['NewPassword'] . $random_salt);
        $Password = hash('sha512', $params['np'] . $random_salt);

        $model = Profiles::find()
          ->where(['Salt' => $token])
          ->one();

        if ($model) {
          $model->Password = $Password;
          $model->Salt = $random_salt;
          $model->Status = intval(1);
          if ($model->save()) {
            Yii::$app->getSession()->setFlash('message', 'Account Password set Successfully');
            return $this->goHome();
          }
        } else {
          Yii::$app->getSession()->setFlash('message', 'Account Not Found');
          return $this->goHome();
        }

      }

    }

  }

}
