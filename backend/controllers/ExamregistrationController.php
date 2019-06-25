<?php

namespace backend\controllers;

use Yii;
use common\models\Examregistration;
use common\models\Studentunits;
use common\models\Lecturerunits;
use common\models\AcademicYear;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Dimensionvalue;
use common\models\Stream;
use common\models\Courses;
use yii\web\HttpException;

/**
* CourseregistrationController implements the CRUD actions for Courseregistration model.
*/
class ExamregistrationController extends Controller
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
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@']
					]
				],
				'denyCallback' => function ($rule, $action) {
					if (\Yii::$app->user->isGuest) {
						return $this->redirect(['site/login']);
					} else {
						throw new HttpException('403', 'You are not allowed to access this page');
					}
				}
			]
		];
	}

	public function beforeAction($action)
	{
		$this->enableCsrfValidation = false;
		return parent::beforeAction($action);
	}

	/**
	* Lists all Courseregistration models.
	* @return mixed
	*/
	public function actionIndex()
	{
		$baseUrl = Yii::$app->request->baseUrl;
		$identity = Yii::$app->user->identity;
		//print_r($identity);exit;
		$ProfileID = $identity->ProfileID;
        $CustomerID = $identity->EmployeeID;
		//get lecturer units
		//print_r($CustomerID);exit;
		$unitsSQL = "select un.Programme,un.Lecturer, un.Semester, un.Unit, 
			un.Stage, d.Name, us.Desription from [CUEA\$Lecturers Qualified Units] as un 
			inner join [CUEA\$Dimension Value] as d on un.Programme = d.Code 
			inner join CUEA\$Units_Subjects as us on ltrim(us.Code) = ltrim(un.Unit) 
			where d.[Dimension Code] = 'PROGRAMME' and Lecturer = '$CustomerID'";
        
		$result = Examregistration::findBySql($unitsSQL)->asArray()->all();
		//print_r($result);exit;
		
		
		$rss = array();
		foreach ($result as $key => $row) {
			$rss[] = array(
				$row['Programme'],
				$row['Semester'],
				$row['Unit'],
				//$row['Lecturer'],
				$row['Desription'],
				$row['Name'],
				

				);
		}
		$json = json_encode($rss);
		//print_r($json);exit;
		return $this->render('index', ['json' => $json]);
	}

	/**
	* Displays a single Courseregistration model.
	* @param string $id
	* @return mixed
	*/
	public function actionView()
	{
		
		$gparams = Yii::$app->request->get();
		//print_r($gparams);exit;	
		//echo phpinfo();exit;
		$params = Yii::$app->request->post();
		//print_r($params);exit;		

		$yearModel = AcademicYear::find()->where(["Current" => 1])->one();
		if (empty($yearModel)) {
			print_r('Missing setup for Current Academic Year'); exit;
		}
		$year = $yearModel->Code; 
		$model = Examregistration::find()->asArray()
		//print_r($model);exit;
				->where("[Programme ID] = '".trim($gparams['ProgrammeID']).
							//"' AND [Term ID] = '".$gparams['TermID']. 
							//"' AND [Stage ID] = '".$gparams['StageID'].							
							"' AND [Academic Year]='".$year.
							//"' AND [Exam Type ID] ='".$gparams['ExamTypeID'].
							"' AND ltrim(rtrim([ProgrammeCourseID])) ='".trim($gparams['ProgrammeCourseID']).
							"'" )->all(); 
							//print_r($model); exit;
						//var_dump($model[0]['Term ID'] );exit;

				//print_r($model  ); exit;
		//var_dump($model->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql); exit; 
		
	
		if (!empty($params)) 
		{
			//print_r($params);exit;
			
				
			$entries = array();
			foreach ($params AS $key => $value) 
			{
				//$results = explode('|',$key);
				$parts = explode('_',$key);
				//print_r($parts); echo "</br>";
				if ( count($parts) == 2 ) {
					$entries[ $parts[1] ] [ $parts[0] ] = $params[$key];
				}
				if ( count($parts) == 3 ) {
					if ( empty($parts[1]) ) { 
						$entries[ $parts[2] ] [ ($parts[0]  ) ] = $params[$key];
					} else {
						$entries[ $parts[2] ] [ ( $parts[0] . ' ' . $parts[1]  ) ] = $params[$key];
					}
				}	
				if ( count($parts) == 4 ) {
					$entries[ $parts[3] ] [ ( $parts[0] . $parts[1]  ) ] = $params[$key];
				}	 	
			}
			
			foreach ($entries AS $key => $entry) 
			{  
				if ( !empty($entry['StudentID']) ) {
					$assessments = Examregistration::find()
						->where([ 'Programme ID' => $gparams['ProgrammeID'] ])
						->andWhere([ 'Student ID' => $entry['StudentID'] ]) 
						->andWhere([ 'Academic Year' => $gparams['AcademicYear'] ])
						->andWhere([ 'ProgrammeCourseID' => trim($gparams['ProgrammeCourseID']) ])
						//->andWhere([ 'Term ID' => $gparams['TermID'] ])
						//->andWhere([ 'Stage ID' => $gparams['StageID'] ])
						//->andWhere([ 'Exam Type ID' => $gparams['ExamTypeID'] ]) 
						->all(); 
						 
					//print_r($params[ $key ]);
					
				
					if( count( $assessments ) == 2 ) {
						//print_r('here');exit;
						foreach ($assessments AS $key => $test) {
							if ( !empty($entry[ $test['Exam Type ID'] ]) ) {
								$test['Actual Mark'] = $entry[ $test['Exam Type ID'] ]; 
								//$test['InternalExaminer'] = $entry[ 'InternalExaminer' ]; 
								$test['InternalExaminer'] = $entry[ 'Moderated Mark' ]; 
								$test['ExternalExaminer'] = 0; 
								$test->save();
								
								//print_r($test->save() ? 'done' : 'failed');
							} 
						} 						
					} else {
						print_r('Examregistration record not found');
					}
				}
			}	
			//print_r($entries); exit;
			
			/* $model = Examregistration::find()->asArray()
				->where("[Programme ID] = '".$gparams['ProgrammeID'].
							"' AND [Term ID] = '".$gparams['TermID']. 
							"' AND [Stage ID] = '".$gparams['StageID'].
							"' AND [Academic Year]='".$year.
							//"' AND [Exam Type ID] ='".$gparams['ExamTypeID'].
							"' AND [ProgrammeCourseID] ='".$gparams['ProgrammeCourseID'].
							"'" )->all();
					//print_r( $model ); exit; */
			//return $this->render('view', [ 'model' => $model]);
			return $this->redirect(Yii::$app->request->referrer);
						
				
		} else
		{
			return $this->render('view', [ 'model' => $model]);
		}
		
	}

		/**
		* Creates a new Courseregistration model.
		* If creation is successful, the browser will be redirected to the 'view' page.
		* @return mixed
		*/
		public function actionCreate()
		{
			$model = new Courseregistration();
			$identity = Yii::$app->user->identity;
			$ProfileID = $identity->ProfileID;
			$CustomerID = $identity->CustomerID;
			$params = Yii::$app->request->post();
			if (!empty($params))
			{
				//exit;
				$types = $model->getTableSchema()->columns;

				foreach($model AS $key => $value)
				{

					$key1 = str_replace(" ","_",$key);
					if (array_key_exists($key1,$params))
					{
						if ($key == 'Entry No_')
						{

						} else
						{
							$model[$key] = $params[$key1];
						}
					} else if ($key == 'Entry No_')
					{

					} else
					{
						if ($types["$key"]->type == 'string')
						{
							$model[$key] = '.';
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
				$model['Reg_ Transacton ID'] = (string)time();
				$model['Registration Date'] = date('Y-m-d');
				$model['Student No_'] = $CustomerID;
				$model['Student Status'] = 1;
				$model['Student Type'] = '1';

				if ($model->save())
				{
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
				return $this->render('create', [ 'model' => $model ]);
			}
		}

		/**
		* Updates an existing Courseregistration model.
		* If update is successful, the browser will be redirected to the 'view' page.
		* @param string $id
		* @return mixed
		*/
		public function actionUpdate($id)
		{
			$model = $this->findModel($id);

			$params = Yii::$app->request->post();

			//print_r($params); exit;
			if (!empty($params))
			{
				foreach($model AS $key => $value)
				{
					$key1 = str_replace(" ","_",$key);
					if (array_key_exists("$key1",$params))
					{
						$model["$key"] = $params["$key1"];
					}
				}
				$model['Academic Year'] = $params["Academic_Year"];
				if ($model->save())
				{
					return $this->redirect(['index']);
				} else
				{
					print_r($model->getErrors()); exit;
				}
			} else {
				return $this->render('update', [ 'model' => $model ]);
			}
		}

		/**
		* Deletes an existing Courseregistration model.
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
		* Finds the Courseregistration model based on its primary key value.
		* If the model is not found, a 404 HTTP exception will be thrown.
		* @param string $id
		* @return Courseregistration the loaded model
		* @throws NotFoundHttpException if the model cannot be found
		*/
		protected function findModel($id)
		{
			if (($model = Examregistration::findOne($id)) !== null) {
				return $model;
			} else {
				throw new NotFoundHttpException('The requested page does not exist.');
			}
		}

		public function actionGetsemester()
		{
			$channel = array();
			$params = Yii::$app->request->get();

			$Programme = $params['Programme'];
			$result = Dimensionvalue::find()->asArray()->where("[Student Term] = 1 AND [Programme Code] = '$Programme'")->orderBy('Name')->all();
			$channel[] = array(
				"name" => "Successful",
				"message" => "Successful Transaction.",
				"code" => "00",
				"status" => 200,
			);
			foreach ($result AS $key => $row)
			{
				extract($row);
				$channel[] = array(
					"sID" => $Code,
					"sName" => $Name
				);
			}
			$json = json_encode($channel);
			echo $json;
		}

		public function actionGetstage()
		{
			$channel = array();
			$params = Yii::$app->request->get();

			$Programme = $params['Programme'];
			$result = Dimensionvalue::find()->asArray()->where("[Student Programme Stage] = 1 AND [Programme Code] = '$Programme'")->orderBy('Name')->all();
			$channel[] = array(
				"name" => "Successful",
				"message" => "Successful Transaction.",
				"code" => "00",
				"status" => 200,
			);
			foreach ($result AS $key => $row)
			{
				extract($row);
				$channel[] = array(
					"sID" => $Code,
					"sName" => $Name
				);
			}
			$json = json_encode($channel);
			echo $json;
		}

		public function actionGetstream()
		{
			$channel = array();
			$params = Yii::$app->request->get();

			$Programme = $params['Programme'];
			$Stage = $params['Stage'];
			$Semester = $params['Semester'];
			$AcademicYear = $params['AcademicYear'];

			$result = Stream::find()->where("[Programme ID] = '$Programme' AND [Stage ID] = '$Stage' AND [Term ID] = '$Semester' AND [Academic YearID] = '$AcademicYear'")->asArray()->orderBy('Stream Name')->all();
			$channel[] = array(
				"name" => "Successful",
				"message" => "Successful Transaction.",
				"code" => "00",
				"status" => 200,
			);
			foreach ($result AS $key => $row)
			{
				//extract($row);
				$channel[] = array(
					"sID" => $row['Stream Code'],
					"sName" => $row['Stream Name'],
				);
			}
			$json = json_encode($channel);
			echo $json;
		}
	}
