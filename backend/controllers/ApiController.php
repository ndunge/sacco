<?php
namespace backend\controllers;

use common\models\Profiles;
use common\models\ProgrammeCourses;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;

use yii\filters\VerbFilter;
use yii\web\HttpException;

/**
* Site controller 
*<div class="g-recaptcha" data-sitekey="6LfArxAUAAAAANVD7zs3q0ysIB9BaGRSKHmeuS2D"></div>
*/
class ApiController extends Controller
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
						'actions' => ['stages'],
					],
					[
						'actions' => [],
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

	public function actionStages($prog)
	{
		
		$data = ProgrammeCourses::find()
			->select(['[Programme Stage]', 'ProgrammeID','CourseCode','Description' ])
			->distinct()
			->where([ 'ProgrammeID' => $prog ])
			//->orderBy(
			->asArray()->all();
		$res = json_encode($data);
		echo $res;


	}

	public function actionSemesters($stage)
	{
		$stage = trim($stage);
		$data = ProgrammeCourses::find()
			->select(['[CourseCode]', 'ProgrammeID', 'Description' ]) 
			->distinct()
			->where("[Programme Stage] = '$stage' ") 
			->asArray()->all();
		$res = json_encode($data);
		echo $res; 


	}


	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}
}
