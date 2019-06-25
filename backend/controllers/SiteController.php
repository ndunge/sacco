<?php
namespace backend\controllers;

use common\models\Profiles;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
require_once 'includes/mailsender.php';
use yii\filters\VerbFilter;
use yii\web\HttpException;

/**
* Site controller 
*<div class="g-recaptcha" data-sitekey="6LfArxAUAAAAANVD7zs3q0ysIB9BaGRSKHmeuS2D"></div>
*/
class SiteController extends Controller
{
	/**
	* @inheritdoc
	*/
	private $userDepartment;
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['login', 'error', 'StudentClearance','about','support','profile','changepassword','forgotpassword','reset'],
					],
					[
						'actions' => ['logout', 'index', 'StudentClearance'],
						'allow' => true,
						'roles' => ['@'],
					],

				],
				'denyCallback' => function ($rule, $action) {
					if (\Yii::$app->user->isGuest) {
						return $this->redirect(['site/login']);
					} else {
						throw new HttpException('403', 'You are not allowed to access this page');
					}
				}
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout1' => ['post'],
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
	* @inheritdoc
	*/
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                //'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
		];
	}

	public function actionIndex()
	{
		
		return $this->render('index');


	}
	
	public function actionChangepassword()
    {
        $params = Yii::$app->request->post();
        if (!empty($params)) {
            $identity = Yii::$app->user->identity;
            $ProfileID = $identity->ProfileID;
            $model = Profiles::findOne($ProfileID);
            $OldPassword = $params['op'];
            $NewPassword = $params['np'];
            $ConfirmPassword = $params['cp'];

            $OldPassword = hash('sha512', $OldPassword . $model->Salt);
            if ($OldPassword != $model->Password) {
                $msg = "Invalid Password";
            } else {
                $NewPassword = hash('sha512', $NewPassword . $model->Salt);
                $model->Password = $NewPassword;
                if ($model->save()) {
                    $msg = "Your password has been changed sucessfully";
                } else {
                    $msg = "An error occured and we were not able to complete your request";

                    // print_r($msg);exit();
                    //print_r($model->getErrors()); exit;
                }
            }
            return $this->render('changepassword', ['msg' => $msg]);

        } else {
            return $this->render('changepassword');
        }
    }
	
	public function actionProfile()
    {
        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $model = Profiles::findOne($ProfileID);

        $params = Yii::$app->request->post();
        if (!empty($params)) {
            foreach ($model AS $key => $value) {
                if (array_key_exists($key, $params)) {
                    $model[$key] = $params[$key];
                }
            }
            if ($model->save()) {
                return $this->render('profile', ['model' => $model, 'error' => 'Saved Successfully']);
            } else {
                return $this->render('profile', ['model' => $model, 'error' => 'Faild to Save']);
                //print_r($model->getErrors()); exit;
            }
        } else {
            return $this->render('profile', ['model' => $model]);
        }
    }

	public function actionLogin1()
	{
		if (!\Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		} else {
			return $this->render('login', [
				'model' => $model,
			]);
		}
	}

	public function actionRegister()
	{
		return $this->render('index');
	}
	
	public function actionAbout()
	{
		return $this->render('about');
	}
	
	public function actionSupport()
	{
		return $this->render('support');
	}

	public function actionStudentclearance()
	{
		print_r($_SESSION);
	}



	/**
	* @return string|\yii\web\Response
	*/
	public function actionLogin()
	{
		$params = Yii::$app->request->post();
		if (!empty($params)) {
			$UserName = $params['UserName'];
			$password = $params['p'];
			$identity = Profiles::findOne(['Email' => $UserName,'AccountTypeID'=>4]);
			if(empty($identity))
			$identity = Profiles::findOne(['Email' => $UserName,'AccountTypeID'=>5 ]);
		    
		    
			//print_r($identity);exit;
			//$IPAddress = get_client_ip();	

			if (!empty($identity)) {			
				$Salt = $identity->Salt;
				$db_password = $identity->Password;
				$Password = hash('sha512', $password . $Salt);
					
				//echo "$db_password, $Password"; exit;
				//if ($db_password == $Password ) {echo 'swallalla'; exit;}
				//print_r( $db_password == $Password ? 'yep' : 'nop');exit;			
				if ($db_password == $Password && 
					($identity->AccountTypeID == 4 || $identity->AccountTypeID == 5 ) ) {
					// Logged in User
				//echo "Hey";exit;
					Yii::$app->user->login($identity);
					$baseUrl = Yii::$app->request->baseUrl;

                    // print_r($baseUrl);exit;
					//return $this->goBack();
					return $this->redirect(['site/index']);
					//					Yii::$app->getResponse()->redirect($baseUrl . '/studentapplication');
				} else {
					//print_r($identity); exit;
					return $this->render('login', ['error' => 'Incorrect Username or Password']);
				}
			} else {
				// Log Failed Login
				return $this->render('login', ['error' => 'Invalid Username or Password']);
			}
		} else {
			// Yii::$app->user->login($identity);
			// $baseUrl = Yii::$app->request->baseUrl;
			// return $this->goBack();
			return $this->render('login');
			//redirect('staff');
		}
	}
	
	public function actionForgotpassword()
	{
		$msg = "";
		$params = Yii::$app->request->post();
		if ((!empty($params)) and ($params['Email']!=''))
		{
			$model = Profiles::findone(['Email'=>$params['Email']]);
			if (empty($model))
			{
				return $this->render('forgotpassword',['msg' => 'The email address provided is invalid']);
			} else
			{
				$Key = Yii::$app->params['Key'];
				
				$EncProfileID = $this->my_number_encrypt($model->ProfileID,$Key);
				$EncProfileID = urlencode($EncProfileID);
				
				$message = $this->ForgotPasswordMessage();
				$message = str_replace("#FIRSTNAME#", $model->FirstName, $message);
				$message = str_replace("#ID#", $EncProfileID, $message);
				
				$subject = "Password reset link";
				
				$EmailArray[] = array('Email' => $model->Email, 'Name' => $model->LastName);

				if (count($EmailArray) != 0) {
					$sent = SendMail($EmailArray, $subject, $message);
					if ($sent == 1) 
					{
						$msg = "An email with reset instruction has been sent to your Email.";
					} else 
					{
						$msg = "The system failed to send a reset Email.  Please try again";
					}
				} else 
				{
					$msg = "The email address provided is invalid";
				}
				return $this->render('forgotpassword',['msg' => $msg]);
			}
		} else
		{
			if ((isset($params['Email'])) and ($params['Email']==''))
			{
				$msg = "The email address provided is invalid";
			}
			return $this->render('forgotpassword',['msg' => $msg]);
		}
	}

    public function actionReset($id)
	{
		$msg = "";
		$params = Yii::$app->request->post();
		if ((!empty($params)) and ($id!=''))
		{
			$Key = Yii::$app->params['Key'];
			
			$decpRrofileID = $this->my_number_decrypt($id, $Key);
			
			$model = Profiles::findOne(['ProfileID' => $decpRrofileID]);			
            if (!empty($model)) 
			{
                $Salt = $model->Salt;
				$NewPassword = $params['np'];
				$ConfirmPassword = $params['cp'];
                if ($NewPassword == $ConfirmPassword) 
				{
					$model->Password = hash('sha512', $NewPassword . $Salt);
					$model->save();	
					return $this->render('login',['error' => 'Your password has been reset sucessfully']);					
				} else
				{
					return $this->render('resetPassword',['id' => $id, 'msg' => 'Your passwords do not match']);
				}
			} else
			{
				return $this->render('resetPassword',['id' => $id, 'msg' => 'Unable to reset your password']);
			}
		} else
		{
			return $this->render('resetPassword',['id' => $id]);
		}
	}	
	
	public static function my_number_encrypt($data, $key, $base64_safe=true, $shrink=true) 
	{
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

		if ($shrink) $data = base_convert($data, 10, 36);
		//$data = @mcrypt_encrypt(MCRYPT_ARCFOUR, $key, $data, MCRYPT_MODE_STREAM);
		$data = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv);
		if ($base64_safe) $data = str_replace('=', '', base64_encode($data));
		return $data;
	}

	public static function my_number_decrypt($data, $key, $base64_safe=true, $expand=true) 
	{
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		if ($base64_safe) $data = base64_decode($data.'==');
		$data = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $data, MCRYPT_MODE_ECB, $iv);
		//$data = @mcrypt_encrypt(MCRYPT_ARCFOUR, $key, $data, MCRYPT_MODE_STREAM);
		if ($expand) $data = base_convert($data, 36, 10);
		return $data;
	}
	
	public static function ForgotPasswordMessage()
    {
		return '<p>Dear #FIRSTNAME#,</p>
		<p>We received a request to reset your  password. Click the link below to choose a new one:</p>
		<p><a href="http://staff.cuea.edu/site/reset?id=#ID#" target="_blank">Reset Your Password</a></p>';
	}


	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}
}
