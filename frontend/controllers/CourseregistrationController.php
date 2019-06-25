<?php

namespace frontend\controllers;

use Yii;
use common\models\Courseregistration;
use common\models\Studentunits;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Dimensionvalue;
use common\models\Stream; 
use common\models\Courses;
use common\models\Academicyearsessions;
use common\models\Customers;
use common\models\ModeOfStudy;
use common\models\Feestructure;
use common\models\GeneralJournal;
use common\models\Customerbalance;
use common\models\Custledgerentry;
use common\models\ProgrammeCourses;
use common\models\Academicyear;


/**
 * CourseregistrationController implements the CRUD actions for Courseregistration model.
 */
class CourseregistrationController extends Controller
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
     * Lists all Courseregistration models.
     * @return mixed
     */
    public function actionIndex()
    {
        $baseUrl = Yii::$app->request->baseUrl;
	
        $identity = Yii::$app->user->identity;
        //print_r($identity); exit;
        $ProfileID = $identity->ProfileID;
        $CustomerID = $identity->CustomerID;
        $sql = "SELECT Courses.*, Programme.Name As ProgrammeName, Stage.Name as StageName, AcademicYear.Description As AcademicYearName 
				FROM [CUEA\$Course Registration -R] Courses
				LEFT JOIN [CUEA\$Customer] Customer ON Customer.No_ = Courses.[Student No_]
				LEFT JOIN [CUEA\$Dimension Value] Programme ON Programme.[Code] = Courses.Programme
				LEFT JOIN [CUEA\$Dimension Value] Stage ON Stage.[Code] = Courses.Stage
				LEFT JOIN [CUEA\$Academic Year] AcademicYear ON AcademicYear.Code = Courses.[Academic Year]
				WHERE [Student No_] = '$CustomerID' AND Courses.Status <> 4 AND Programme.[Student Programme] = 1";
        $result = Courseregistration::findBySql($sql)->asArray()->all();
		//print_r($sql); exit;

        $channel = array();
        foreach ($result AS $key => $row) {
            //extract($row);
            $channel[] = array(
                $row['Reg_ Transacton ID'],
                $row['ProgrammeName'],
                $row['StageName'],
                $row['Semester'],
                $row['AcademicYearName'],
                $row['Student Stream'],
				
				
                date("d/m/Y", strtotime($row['Registration Date'])),  
            );
        }
		
        $rss = $channel;
		//get registration dates of the current session
		/*
		$sql = "select [Registration Start Date], [Registration End Date] from [CUEA\$Academic Year Sessions] where [Session Code] ='MAY-JULY17'  and GETDATE() between [Registration Start Date] and [Registration End Date]";
		$result = Academicyearsessions::findBySql($sql)->asArray()->all();
		//$currentsession=
		
		*/
		
		
		$sql2="select *,
(CASE
        WHEN GETDATE() between [Registration Start Date] and [Registration End Date] THEN 1
        ELSE 0
        END) AS Active 
from [CUEA\$Academic Year Sessions] ";
$result2 = Academicyearsessions::findBySql($sql2)->asArray()->all();
//print_r($result2);


        $displayButton = false;
		
		$balances= Customerbalance::findone([$CustomerID]);
		$Studentbalance= $balances['Balance'];
		$Balancezero =0;
		
		
		 $model3= Customerbalance::
		findbysql('SELECT * from [CUEA$CustomerBalances] 
		where  Balance <= \''.$Balancezero.'\'')->all(); 
		
		//print_r($model3);exit;
		
        if ( !empty($model3) ) {
		$displayButton = true;
		}
		
		/* if ($Studentbalance =-$Studentbalance )
		{
			$displayButton = true;
		}else{
			$displayButton = false;
		};exit; */
		//if ( explode("-", $Studentbalance)[0] == 'FULL' )  { 
		//print_r($balances);exit;
		
	
		$displayButton = false;
		$today = date('Y-m-d');
		
		$open_session = Academicyearsessions::find()
			->where("[Registration Start Date] < '$today'")
			->andWhere("[Registration End Date] > '$today'")
			->asArray()->one();
			//print_r($open_session);exit;
		if ( !empty($open_session) ) {
			$displayButton = true;
			foreach($result as $k => $v) {
				if( $v['Session Code'] == $open_session['Session Code'] ) {
					$displayButton = false;
				}
			}
		}
		//print_r($result);exit;
		//if(!empty($result2)){
		//$displayButton = true;
		//}
		//display info for the MAY-JULY Session
	    
		
		//if()$displayButton =true;
		
		if(sizeof($rss)> 1 ) $displayButton = false;
        $json = json_encode($rss);
		

        return $this->render('index', ['json' => $json, 'displayButton' => $displayButton]);
    }

    /**
     * Displays a single Courseregistration model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
		
		if ($model->Status == 0)
		{
			return $this->redirect(['units', 'id' => $id]);
		} else
		{
			$code = 0;
			if (isset($_REQUEST['code'])) {$code = $_REQUEST['code'];}
			$CustomerID = $model['Student No_']; 

			$balances = Customerbalance::findone($CustomerID);
				
			$balance = (empty($balances)) ? 0 : $balances->Balance*-1;
			
			$ProgrammeCode =  $model['Programme'];
			$AcademicYear = $model['Academic Year'];
			$SemesterCode = $model['Semester'];
			$StageCode = $model['Stage'];
			$ModeCode = $model['Settlement Type'];
			$Programme = Dimensionvalue::findone(['Student Programme' => 1, 'Code' => $ProgrammeCode]); 
			$Semester = Dimensionvalue::findone(['Student Term' => 1, 'Code' => $SemesterCode]); 
			$Semester = Dimensionvalue::findone(['Student Term' => 1, 'Code' => $SemesterCode]);
			$Stage = Dimensionvalue::findone(['Student Programme Stage' => 1, 'Code' => $StageCode]);
			$Mode = ModeOfStudy::findone(['Code'=>$ModeCode]); 
			
			$ProgrammeName = (!empty($Programme)) ? $Programme['Name'] : '';
			$SemesterName = (!empty($Semester)) ? $Semester['Name'] : '';
			$StageName = (!empty($Stage)) ? $Stage['Name'] : '';
			$ModeName = (!empty($Mode)) ? $Mode['Name'] : '';
			
			$Fees = Feestructure::find()->where(['Stage Code' => $StageCode,
												 'Student Type' => 0,
												 'Academic Year' => $AcademicYear,
												 'Student Status' => 2,
												 'Charge Type' => 2,
												 //'Mode of Study' => $ModeCode,
												 'Semester' => $SemesterCode
												 
												])->all();
			
			$params = Yii::$app->request->post();
			if (!empty($params)) {
				$Selected = Studentunits::find()->asArray()->where("[Reg_ Transacton ID] = '" . $id . "'")->orderBy('Description')->all();
				$CheckedArray = array();
				//print_r($Selected); exit;
				foreach ($params AS $key => $value) {
					if (substr($key, 0, 3) == 'CK_') {
						$newkey = substr($key, 3, 100);
						$newkey = str_replace("_", " ", $newkey);

						$CheckedArray[] = $newkey;
					}
				}
				//print_r($CheckedArray);
				foreach ($Selected AS $k => $v) {

					if (in_array($v['Unit'], $CheckedArray)) {
						$Taken = 1;
					} else {
						$Taken = 0;
					}

					$EntryNo = $v['Entry No_'];
					//echo $v['Unit']." == $EntryNo  </br>";
					$smodel = Studentunits::find()->where("[Entry No_] = '$EntryNo'")->one();
					$smodel->Taken = $Taken;
					$smodel->save();
				}
				//exit;
			}

			$Selected = Studentunits::find()->asArray()->where("[Reg_ Transacton ID] = '" . $id . "'")->orderBy('Description')->all();
			return $this->render('view', ['model' => $model, 'Selected' => $Selected
												,'ProgrammeName' => $ProgrammeName 
												,'SemesterName' => $SemesterName, 'StageName' => $StageName
												,'ModeName' => $ModeName, 'Fees' => $Fees, 'id' => $id
												,'code' => $code, 'balance' => $balance
											]);
		}
    }

    /**
     * Creates a new Courseregistration model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	 
	 //checking the current semester and stage
    public function actionCreate()
    {
        $model = new Courseregistration();
        //print_r($model );exit;		
		
        $identity = Yii::$app->user->identity;
        $ProfileID = $identity->ProfileID;
        $CustomerID = $identity->CustomerID;
		//echo $CustomerID;exit;	
		$Student = Customers::findOne($CustomerID);
		//print_r($Student);exit;
		
		$Campus= $Student['Campus Code'];
		$ModeCode = $Student['Mode of Study'];
		$ProgrammeCode =  $Student['Current Programme'];
		
		$SemesterCode =  $Student['Current Semester'];
         	
		$StageCode = $Student['Current Stage'];
		
		$sql = "SELECT Courses.*, Programme.Name As ProgrammeName, Stage.Name as StageName, AcademicYear.Description As AcademicYearName 
				FROM [CUEA\$Course Registration -R] Courses
				LEFT JOIN [CUEA\$Customer] Customer ON Customer.No_ = Courses.[Student No_]
				LEFT JOIN [CUEA\$Dimension Value] Programme ON Programme.[Code] = Courses.Programme
				LEFT JOIN [CUEA\$Dimension Value] Stage ON Stage.[Code] = Courses.Stage
				LEFT JOIN [CUEA\$Academic Year] AcademicYear ON AcademicYear.Code = Courses.[Academic Year]
				WHERE [Student No_] = '$CustomerID' AND Courses.Status <> 4";
        $result = Courseregistration::findBySql($sql)->asArray()->all();
		//print_r(Customers::find($identity->CustomerID)->one()); exit;
		
		if ( count($result) > 0 ) {
			
			//full time students	
			
			
			if ( explode("-", $ModeCode)[0] == 'FULL' )  { 
				/* $NextSem = explode(" ",$SemesterName)[1] == 2 ? 1 : 2;
				$NextSemester = explode(" ", $SemesterName)[0]  . ' ' . $NextSem; 
				
				$NextStg = explode(" ",$StageName)[1] < (  substr(explode("-", $ModeCode)[1], 0, 1) + 1) ? 
					(explode(" ",$StageName)[1] + 1) : explode("-", $ModeCode)[0];
				$NextStage = explode(" ", $StageName)[0]  . ' ' . $NextStg;  */
				//check if this is the first year and first sem
				
				$StageCode = $Student['Current Stage'];
				$Stage=explode("Y", $StageCode)[1];
				
				
				$SemesterCode =  $Student['Current Semester'];
				$Sem=explode("T", $SemesterCode)[1];
				//print_r($Sem);exit;
				if($Stage==1 && $Sem==1)
				{
					$Semester = explode("T", $SemesterCode)[1] == 1 ? 1 : 1;
				$NextSemesterCode = explode("T", $SemesterCode)[0] . "T" . $Semester;
				
				$Stage = explode("Y", $StageCode)[1] < (  substr(explode("-", $ModeCode)[1], 0, 1) + 1 ) ? 
					(explode("Y",$StageCode)[1] + ($Semester == 1 ? 1 : 0) ) : substr(explode("-", $ModeCode)[1], 0, 1);
				$NextStageCode = explode("Y", $StageCode)[0] . "Y" . $Stage; 
				}
				else{
				
				$Semester = explode("T", $SemesterCode)[1] == 2 ? 1 : 2;
				$NextSemesterCode = explode("T", $SemesterCode)[0] . "T" . $Semester;
				
				$Stage = explode("Y", $StageCode)[1] < (  substr(explode("-", $ModeCode)[1], 0, 1) + 1 ) ? 
					(explode("Y",$StageCode)[1] + ($Semester == 1 ? 1 : 0) ) : substr(explode("-", $ModeCode)[1], 0, 1);
				$NextStageCode = explode("Y", $StageCode)[0] . "Y" . $Stage; 
				
				//print_r( $NextStageCode );  exit;
				$SemesterCode =  $NextSemesterCode;		
				$StageCode = $NextStageCode;
				
				}
				
			}
		
		}
		
		
	
		$Programme = Dimensionvalue::findone(['Student Programme' => 1, 'Code' => $ProgrammeCode]);
        $Campus = Dimensionvalue::findone(['School Campus' => 1, 'Code' => $Campus]);		
		$Semester = Dimensionvalue::findone(['Student Term' => 1, 'Code' => $SemesterCode]); 
		$Semester = Dimensionvalue::findone(['Student Term' => 1, 'Code' => $SemesterCode]);
		$Stage = Dimensionvalue::findone(['Student Programme Stage' => 1, 'Code' => $StageCode]);
		$Mode = ModeOfStudy::findone(['Code'=>$ModeCode]); 
		
		$ProgrammeName = (!empty($Programme)) ? $Programme['Name'] : '';
		$SemesterName = (!empty($Semester)) ? $Semester['Name'] : '';
		$StageName = (!empty($Stage)) ? $Stage['Name'] : '';
		$CampusName = (!empty($Campus)) ? $Campus['Name'] : '';
		$ModeName = (!empty($Mode)) ? $Mode['Name'] : '';
		
		 
		
		
		
        $params = Yii::$app->request->post();
        if (!empty($params))  
		{
            //exit;
            $types = $model->getTableSchema()->columns;
			
			//print_r($params );exit;
			
            foreach ($model AS $key => $value) {

                $key1 = str_replace(" ", "_", $key);
                if (array_key_exists($key1, $params)) {
                    if ($key == 'Entry No_') {

                    } else {
                        $model[$key] = $params[$key1];
                    }
                } else if ($key == 'Entry No_') {

                } else {
                    if ($types["$key"]->type == 'string') {
                        $model[$key] = '.';
                    } else if (($types["$key"]->type == 'integer') OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal')) {
                        $model[$key] = '0';
                    } else if ($types["$key"]->type == 'datetime') {
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
			$model['Settlement Type'] = $Student['Mode of Study'];
			$model['Programme'] = $Student['Current Programme'];
			$model['Semester'] = $Student['Current Semester'];
			$model['Stage'] = $Student['Current Stage'];
			
			$model['Semester'] = $params['Semester'];
			$model['Stage'] = $params['Stage'];
			$model['Status'] = 0;
			
			$model['Academic Year'] = $params['Academic_Year'];
			$model['Academic Session'] = $params['Academic_Year_Sessions'];
			$model['Session Code'] = $params['Academic_Year_Sessions'];

            if ($model->save()) 
			{
                return $this->redirect(['view', 'id' => $model['Reg_ Transacton ID']]);
            } else {
                $errors = $model->getErrors();
                $founderrors = '';
                foreach ($errors AS $key => $value) {
                    foreach ($value AS $key1 => $avalue) {

                        $founderrors .= $avalue;
                    }
                }
                print_r($errors);
            }
			
        } else {
			$model['Programme'] = $Student['Current Programme'];
			$model['Semester'] = $Student['Current Semester'];
			$model['Stage'] = $Student['Current Stage'];
			$model['Settlement Type'] = $Student['Mode of Study'];
			$model['Student No_'] = $CustomerID;			
			
            return $this->render('create', [
				'SemesterCode' => $SemesterCode, 'StageCode' => $StageCode,
				'model' => $model, 'ProgrammeName' => $ProgrammeName, 
				'SemesterName' => $SemesterName, 'StageName' => $StageName,
				//'SemesterName' => $NextSemester, 'StageName' => $NextStage, 
				'ModeName' => $ModeName,'CampusName' =>$CampusName
			]);
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
		
		//print_r($model);exit;
		

        $params = Yii::$app->request->post();
		
		

        print_r($params); exit;
        if (!empty($params)) {
            foreach ($model AS $key => $value) {
                $key1 = str_replace(" ", "_", $key);
                if (array_key_exists("$key1", $params)) {
                    $model["$key"] = $params["$key1"];
                }
            }
            $model['Academic Year'] = $params["Academic_Year"];
			$model['Session Code'] = $params['Academic Session'];
			
            if ($model->save()) {
                return $this->redirect(['index']);
            } else {
                print_r($model->getErrors());
                exit;
            }
        } else {
            return $this->render('update', ['model' => $model]);
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
	
	public function actionStudentunits($id)
	{
		
		$model = $this->findModel($id);
		//print_r($model);exit;
		
		$CustomerID = $model['Student No_']; 
		$ProgrammeCode =  $model['Programme'];
		$AcademicYearCode = $model['Academic Year'];
		$SemesterCode = $model['Semester'];
		$StageCode = $model['Stage'];
		$CampusCode = $model['Campus'];
		$ModeCode = $model['Settlement Type'];
		
		$identity = Yii::$app->user->identity;
		$StudentID = $identity->CustomerID;
		$cust = Customers::findOne($StudentID);
		$CampusCode = $cust['Campus Code'];
		
		
		
		$DetailsArray = [];
		
		$programme = Dimensionvalue::findone(['Student Programme'=> 1, 'Code'=> $ProgrammeCode]);
		$Academicyear = Academicyear::findone(['Code'=> $AcademicYearCode]);
		$Semester = Dimensionvalue::findone(['Student Term' => 1, 'Code' => $SemesterCode]); 
		$Stage = Dimensionvalue::findone(['Student Programme Stage' => 1,'Code' => $StageCode]); 
		$balances= Customerbalance::findone([$CustomerID]);
		//print_r($balances);exit;
		$DetailsArray['programme'] = empty($programme) ? '' : $programme->Name;
		$DetailsArray['ProgrammeCode'] = empty($programme) ? '' : $programme->Code;
		$DetailsArray['Academicyear'] = empty($Academicyear) ? '' : $Academicyear->Description;
		$DetailsArray['Semester'] = empty($Semester) ? '' : $Semester->Name;
		$DetailsArray['Stage'] = empty($Stage) ? '' : $Stage->Name;
		$DetailsArray['Balance'] = empty($balances) ? '0' : $balances->Balance;
		$DetailsArray2['Balance'] = $DetailsArray['Balance']*-1;
		$DetailsArray['AcademicyearCode'] = empty($Academicyear) ? '' : $Academicyear->Code;
		$DetailsArray['ModeCode'] = $ModeCode;
		$DetailsArray['SemesterCode'] = $SemesterCode;
		$DetailsArray['StageCode'] = $StageCode;
		$DetailsArray['CampusCode'] = $CampusCode;
		$Studentunits = Studentunits::find()->asArray()->where("[Reg_ Transacton ID] = '" . $id . "'")->orderBy('Description')->all();
		
	$query="	select 
(CASE
        WHEN GETDATE() between [Registration Start Date] and [Registration End Date] THEN 1
        ELSE 0
        END) AS Active, [Session Code]
from [CUEA\$Academic Year Sessions]  ";

$resuult= Academicyearsessions::findBySql($query)->asArray()->all();
$sessions = array();
foreach($resuult as $key => $val) {
	$sessions[$val['Session Code']] = $val;
}

//print_r($model);exit;

$activated =0;

$sessions = array();
foreach ($resuult AS $key => $row)
{
	//$activated = $row['Active'];
	/* if($row['Active']==1) {
	$activated = 1;	
	} */
	//echo "key ".$key." value ".$row."<br>";
	$sessions [ $row['Session Code'] ] = $row;
}
/* 
if ($activated==1){
$displayButton2 = true;	
} */

$displayButton2 = (isset ( $sessions[ $model['Session Code'] ] ) 
	&& intval($sessions[ $model['Session Code'] ] ['Active'])  == 1) ? true : false;

//echo $displayButton2; exit;
//print_r( $sessions[ $model['Session Code'] ] == 1 ? 'y' : 'n' );exit;



//print_r($resuult);exit;
		
		return $this->render('studentunits', ['Studentunits' => $Studentunits, 
			'DetailsArray' => $DetailsArray,
				'DetailsArray2' => $DetailsArray2, 
				'model' => $model, 
				'resuult' => $resuult,
				'displayButton2' => $displayButton2]);
	}
	
	public function actionUnits($id)
    {
        //echo $id;exit;
        $model = $this->findModel($id);
		//print_r($model); exit;
		$CustomerID = $model['Student No_']; 
		$ProgrammeCode =  $model['Programme'];
		$AcademicYearCode = $model['Academic Year'];
		$SemesterCode = $model['Semester'];
		$StageCode = $model['Stage'];
		$ModeCode = $model['Settlement Type']; 
        $CampusCode = $model['Campus'];
		

		

		$DetailsArray = [];
	
		
		$programme = Dimensionvalue::findone(['Student Programme'=> 1, 'Code'=> $ProgrammeCode]);
		$Academicyear = Academicyear::findone(['Code'=> $AcademicYearCode]);
		$Semester = Dimensionvalue::findone(['Student Term' => 1, 'Code' => $SemesterCode]); 
		$Stage = Dimensionvalue::findone(['Student Programme Stage' => 1,'Code' => $StageCode]); 
		 
		$balances= Customerbalance::findone([$CustomerID]);
		
		$Session = Courseregistration::find()->where(['Stage' => $StageCode,
											 //'Student Type' => 0,
											 'Student No_'=> $CustomerID,
											 'Campus'=> $CampusCode,
											'Academic Year' => $AcademicYearCode,
											// 'Student Status' => 2,
											// 'Charge Type' => 2,
											'Settlement Type' => $ModeCode,
											 'Semester' => $SemesterCode,
											 
											])->one();
											
		//$result = Courseregistration::findBySql($sql)->asArray()->all();									
		//$Session = $Session[0];
		$Session['BillingStatus'] = 0;
		$Session->save();
		//print_r($StageCode);exit;	
		
		$DetailsArray['programme'] = empty($programme) ? '' : $programme->Name;
		$DetailsArray['Academicyear'] = empty($Academicyear) ? '' : $Academicyear->Description;
		//$DetailsArray['Semester'] = empty($Semester) ? '' : $Semester->Name;
		$DetailsArray['Semester'] = empty($SemesterCode) ? '' : $SemesterCode;
		//$DetailsArray['Stage'] = empty($Stage) ? '' : $Stage->Name;
		$DetailsArray['Stage'] = empty($StageCode) ? '' : $StageCode;
		$DetailsArray['Balance'] = empty($balances) ? '0' : $balances->Balance;
		$DetailsArray2['Balance']=$DetailsArray['Balance']*-1;
		//print_r($DetailsArray2['Balance']);exit;
		
        $params = Yii::$app->request->post();
		//print_r($params);exit;
		
		$identity = Yii::$app->user->identity; 
		$StudentID = $identity->CustomerID;
		$cust = Customers::findOne($StudentID);
		$CampusCode = $cust['Campus Code'];
		
		
		//print_r( );exit;
		
		
		$Units=ProgrammeCourses::find()->where(['ProgrammeID'=>$ProgrammeCode, 
												'Programme Stage'=>$StageCode, 
												//'ProgStageTermID'=>$SemesterCode, 
												'Campus'=> $CampusCode,
												'Mode of Study'=>$ModeCode
												])->all();
		
        //print_r($Units);exit;		
												
        if (!empty($params)) 
		{
			
			$Selected = Studentunits::find()->asArray()
				->where("[Reg_ Transacton ID] = '" . $id . "'")
				->orderBy('Description')->all();
			
			$SelectedArray = [];
			foreach ($Selected AS $key => $row)
			{ 
				$SelectedArray[$row['Unit']] = $row['Entry No_'];
				
				//Taken;
			}
			
			// Add Units selected
			if (isset($params['sunits']))
			{
				//print_r($params); exit;
				foreach ($params['sunits'] as $Unitkey => $details)
				{
					
					//print_r($details);
					//if ( count($details) > 1 ) {
					if ( isset($details["'include'"]) && $details["'included'"] === 'false' ) {
						//print_r($details);
						if (!isset($SelectedArray[$Unitkey]))
						{
							$unit = new Studentunits();	
							
							$types = $unit->getTableSchema()->columns;
							
							foreach ($unit AS $key => $value) 
							{
								if ($key == 'Entry No_')
								{
								} else if ($types["$key"]->type == 'string') 
								{
									$unit[$key] = '';
								} else if (($types["$key"]->type == 'integer') OR ($types["$key"]->type == 'smallint') OR ($types["$key"]->type == 'decimal')) {
									$unit[$key] = '0';
								} else if ($types["$key"]->type == 'datetime') {
									$unit[$key] = '1753-01-01 00:00:00.000';
								}				
							}				
							
							$unit['Programme'] = $ProgrammeCode;
							$unit['Stage'] = $StageCode;
							$unit['Unit'] = $Unitkey;
							$unit['Description'] = $details["'description'"];
							$unit['Semester'] = $SemesterCode;
							$unit['Reg_ Transacton ID'] = $id;
							$unit['Student No_'] = $CustomerID;
							$unit['Taken'] = 0;
							$unit['Status'] = 1;
							$unit['Amount'] = $details["'amount'"];
							
							$unit->save();
							
						} 
					} elseif( (isset($details["'included'"]) && $details["'included'"] === 'true') && !isset($details["'include'"]) ) {
						$_update_unit = Studentunits::find()
							->where("Unit = '$Unitkey'")
							->andWhere("[Reg_ Transacton ID] = '" . $id . "'")
							->one();
						//print_r(count($_update_unit));	
						$_update_unit->delete();
					}
				}
				//exit;
			}
			
			// Remove any unselected Unit
			foreach ($SelectedArray as $key => $value)
			{
				if (!isset($params['sunits'][$key]))
				{
					$DUnits = Studentunits::findOne(['Entry No_'=> $value]);
					
					if (!empty($DUnits))
					{
						if ($DUnits->Status!=2)
						{
							$DUnits->Delete();
						}
					}
				}				
			}
			
			//Redirect to Student Unit
			return $this->redirect(['units', 'id' => $id]);
			
			
			
        } else
		{
			$Selected = Studentunits::find()->asArray()->where("[Reg_ Transacton ID] = '" . $id . "'")->orderBy('Description')->all();
			$SelectedArray = [];
			$StatusArray = [];
			foreach ($Selected AS $key => $row)
			{ 
			//echo "button";exit;
				extract($row);
				$SelectedArray[$Unit] = $Taken;
				if ($Status==2)
				{
					$StatusArray[$Unit] = $Status;
				}
			}
			
			$balances= Customerbalance::findone([$CustomerID]);
			$balance=empty($balances)?0:$balances->Balance;
			$balance2=$balance*-1;
			
			//print_r($balance2);exit;
	
			 
			return $this->render('units', [
				'model' => $model, 
				'ProgrammeCode' => $ProgrammeCode,
				'ModeCode' => $ModeCode, 
				'Selected' => $SelectedArray,
				'balance2'=>$balance2,
				'Units'=>$Units, 
				'id'=>$id, 
				'StatusArray'=>$StatusArray, 
				'DetailsArray' => $DetailsArray,
				'DetailsArray2' => $DetailsArray2
			]);
		}
    }
	
	public function actionSubmitunits($id)
    {
        $Session = $this->findModel($id);
		//print_r($model);exit;
		
		$CustomerID = $Session['Student No_']; 
		$ProgrammeCode =  $Session['Programme'];
		$AcademicYear = $Session['Academic Year'];
		$SemesterCode = $Session['Semester'];
		$StageCode = $Session['Stage'];
		$ModeCode = $Session['Settlement Type'];  
        //print_r($model);exit;		
        //$Session['BillingStatus']=1;
         $Session->save();		
		$Selected = Studentunits::find()->asArray()->where("[Reg_ Transacton ID] = '" . $id . "'")->orderBy('Description')->all();
		
		if (!empty($Selected))
		{
			//print_r($Selected); exit;
			foreach ($Selected as $item => $row)
			{
				if ($row['Status'] == 1)
				{
					//echo "button";exit;
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
					//$rand = rand(5, 1000);
					$rand = time();
					$model['Journal Template Name'] = 'STUD FEES';
					$model['Journal Batch Name'] =  'UNITS';
					$model['Line No_'] = $rand;
					$model['Account Type'] = 1;
					$model['Account No_'] = $CustomerID;
					$model['Posting Date'] = date('Y-m-d');
					$model['Document Type'] = 1;
					$model['Document No_'] = (string)time();
					$model['UnitCode'] = $row['Unit'];
					$model['Description'] = $row['Description'];
					$model['VAT _'] = 0;
					$model['Amount'] = $row['Amount'];
					$model['Debit Amount'] = $row['Amount'];
					$model['Credit Amount'] = $row['Amount']*-1;
					$model['Amount_LCY'] = $row['Amount'];
					$model['Bill-to_Pay-to No_'] = $CustomerID;
					$model['Posting Group'] = 'STUDENTS';
					$model['Due Date'] = date('Y-m-d');
					$model['Document Date'] = date('Y-m-d');
					if ($model->save())
					{
						$EntryNo = $row['Entry No_'];
                        $Session['BillingStatus']=0;
						$Unit = Studentunits::findone(['Entry No_'=>$EntryNo]);
						$Unit->Status = 2;
						$Unit->save();
						//return $this->redirect(['registered']);
						//return $this->redirect(['units']);
						
					
					} else
					{
						/*
						$Selected = Studentunits::find()->asArray()->where("[Reg_ Transacton ID] = '" . $id . "'")->orderBy('Description')->all();
						$SelectedArray = [];
						foreach ($Selected AS $key => $row)
						{ 
							extract($row);
							$SelectedArray[$Unit] = $Taken;
						}
						
						$balances= Customerbalance::findone([$CustomerID]);
						$balance=empty($balances)?0:$balances->Balance;
						 
						return $this->render('units', ['model' => $model, 'Selected' => $SelectedArray,'balance'=>$balance,'Units'=>$Units, 'code'=>2, 'id'=>$id]);
						*/
					}
				}
			}
			$Fees = Feestructure::find()->where(['Stage Code' => $StageCode,
											 'Student Type' => 0,
											 'Academic Year' => $AcademicYear,
											 'Student Status' => 2,
											 'Charge Type' => 2,
											 'Mode of Study' => $ModeCode,
											 'Semester' => $SemesterCode
											])->all();
											
			//exit;
				foreach ($Fees as $item => $row)
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
				$model['Journal Batch Name'] =  'UNITS';
				$model['Line No_'] = $item;
				$model['Account Type'] = 1;
				$model['Account No_'] = $Session['Student No_'];
				$model['Posting Date'] = date('Y-m-d');
				$model['Document Type'] = 1;
				$model['Document No_'] = (string)time();
				$model['Description'] = $row['Description'];
				$model['VAT _'] = 0;
				$model['Amount'] = $row['Amount'];
				$model['Debit Amount'] = $row['Amount'];
				$model['Credit Amount'] = $row['Amount']*-1;
				$model['Amount_LCY'] = $row['Amount'];
				$model['Bill-to_Pay-to No_'] = $Session['Student No_'];
				$model['Posting Group'] = 'STUDENTS';
				$model['Due Date'] = date('Y-m-d');
				$model['Document Date'] = date('Y-m-d');
				$model['Bal_ Account No_'] = $row['Distribution Account'];
				if ($model->save())
				{
					$Session->Status = 1;
					$Session->save();
					return $this->redirect(['registered']);
				} else
				{
					return $this->redirect(['view', 'id' => $id, 'code' => 3]);
				}
			}
			return $this->redirect(['registered']);
		} else
		{
			$Selected = Studentunits::find()->asArray()->where("[Reg_ Transacton ID] = '" . $id . "'")->orderBy('Description')->all();
			$SelectedArray = [];
			foreach ($Selected AS $key => $row)
			{ 
				extract($row);
				$SelectedArray[$Unit] = $Taken;
				
			}
			
			$balances= Customerbalance::findone([$CustomerID]);
			$balance=empty($balances)?0:$balances->Balance*-1;
			
			 
			return $this->render('units', ['model' => $model, 'Selected' => $SelectedArray,'balance'=>$balance,'Units'=>$Units, 'code'=>1, 'id'=>$id]);
		}
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
        if (($model = Courseregistration::findOne($id)) !== null) {
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

       	$query = Dimensionvalue::find()->asArray()->where("[Student Term] = 1 AND [Programme Code] = '$Programme'")->orderBy('Name');
        $channel[] = array(
            "name" => "Successful",
            "message" => "Successful Transaction.",
            "code" => "00",
            "status" => 200,
            "query" => ($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql)
        );
        foreach ($result AS $key => $row) {
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
        foreach ($result AS $key => $row) {
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
        foreach ($result AS $key => $row) {
            //extract($row);
            $channel[] = array(
                "sID" => $row['Stream Code'],
                "sName" => $row['Stream Name'],
            );
        }
        $json = json_encode($channel);
        echo $json;
    }

    public function actionGetcourse()
    {
        $channel = array();
		
        $params = Yii::$app->request->get();

        $Programme = $params['Programme'];
        $Stage = $params['Stage'];
        $Semester = $params['Semester'];
        $AcademicYear = $params['AcademicYear'];

        $result = Courses::find()->asArray()->where("[ProgrammeID] = '" . $Programme . "' AND ProgStageTermID = '" . $Semester . "' AND [Programme Stage] = '" . $Stage . "'")->orderBy('Description')->all();
        $channel[] = array(
            "name" => "Successful",
            "message" => "Successful Transaction.",
            "code" => "00",
            "status" => 200,
        );
        foreach ($result AS $key => $row) {
            //extract($row);
            $channel[] = array(
                "sID" => $row['CourseCode'],
                "sName" => $row['Description'],
            );
        }
        $json = json_encode($channel);
        echo $json;
    }
	
	

    public function actionGetsession()
    {
        $channel = array();
        $params = Yii::$app->request->get();
        $AcademicYear = $params['AcademicYear'];

        $result = Academicyearsessions::find()->where("[AcademicYear] = '$AcademicYear'")->asArray()->orderBy('Mode of Study')->all();
        $channel[] = array(
            "name" => "Successful",
            "message" => "Successful Transaction.",
            "code" => "00",
            "status" => 200,
        );
        foreach ($result AS $key => $row) {
            //extract($row);
            $channel[] = array(
                "sID" => $row["Session Code"],
                "sName" => $row['Session Code'],
            );
        }
        $json = json_encode($channel);
        echo $json;
    }
	
	public function FeesTotal($Fees)
	{
		$total = 0;
		foreach ($Fees as $item => $row)
		{
			$total += $row['Amount']; 
		}
		return $total;
	}
	
	public function actionSubmit($id)
	{
		$Session = $this->findModel($id);
		//print_r($Session);exit;
		
		$CustomerID = $Session['Student No_']; 
		
		$ProgrammeCode =  $Session['Programme'];
		$AcademicYear = $Session['Academic Year'];
		$SemesterCode = $Session['Semester'];
		$StageCode = $Session['Stage'];
		$ModeCode = $Session['Settlement Type'];
		//print_r($Session);exit;
		
		
		$Fees = Feestructure::find()->where(['Stage Code' => $StageCode,
											 'Student Type' => 0,
											 'Academic Year' => $AcademicYear,
											 'Student Status' => 2,
											 'Charge Type' => 2,
											 'Mode of Study' => $ModeCode,
											 'Semester' => $SemesterCode
											])->all();
											
											
		$balance = Customerbalance::findone($CustomerID);
		
		$totalfees = $this->FeesTotal($Fees);
		if (empty($balance))
		{
			// return
			return $this->redirect(['view', 'id' => $id, 'code' => 1]);
		} else if (($balance['Balance']*-1) < $totalfees)
		{
			// return
			return $this->redirect(['view', 'id' => $id, 'code' => 2]);
		} else
		{

			foreach ($Fees as $item => $row)
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
				$model['Journal Batch Name'] =  'UNITS';
				$model['Line No_'] = $item;
				$model['Account Type'] = 1;
				$model['Account No_'] = $Session['Student No_'];
				$model['Posting Date'] = date('Y-m-d');
				$model['Document Type'] = 1;
				$model['Document No_'] = (string)time();
				$model['UnitCode'] = $row['Unit'];
				$model['Description'] = $row['Description'];
				$model['VAT _'] = 0;
				$model['Amount'] = $row['Amount'];
				$model['Debit Amount'] = $row['Amount'];
				$model['Credit Amount'] = $row['Amount']*-1;
				$model['Amount_LCY'] = $row['Amount'];
				$model['Bill-to_Pay-to No_'] = $Session['Student No_'];
				$model['Posting Group'] = 'STUDENTS';
				$model['Due Date'] = date('Y-m-d');
				$model['Document Date'] = date('Y-m-d');
				$model['Bal_ Account No_'] = $row['Distribution Account'];
				if ($model->save())
				{
					
					$Session->Status = 1;
					$Session->save();
					return $this->redirect(['registered']);
				} else
				{
					return $this->redirect(['view', 'id' => $id, 'code' => 3]);
				}
			}
		}
	}
	
	public function actionRegistered()
	{
		return $this->render('registered');
	}
	
	
	public function actionDropunit($id, $unit)
	{
		//GeneralJournal
		//print_r($id);exit;
		$Studentunit = Studentunits::find()
			->where("[Reg_ Transacton ID] = '" . $id . "'")
			->andWhere("[Unit] = '" . $unit . "'")
			->orderBy('Description')->one();
		if ( $Studentunit->delete() ) {
			Yii::$app->getSession()->setFlash('msg', 'student unit deleted');
			return $this->redirect(['studentunits', 'id' => $id, 'unit' => $unit]);
		}
		//print_r($Studentunit); exit;
	}
	
	
	public function actionUnitdetails($id, $unit = null)
	{	
		
		$model = $this->findModel($id);
		$CustomerID = $model['Student No_']; 
		$ProgrammeCode =  $model['Programme'];
		$AcademicYearCode = $model['Academic Year'];
		$SemesterCode = $model['Semester'];
		$StageCode = $model['Stage'];
		$ModeCode = $model['Settlement Type'];  

		$DetailsArray = [];
		
		$programme = Dimensionvalue::findone(['Student Programme'=> 1, 'Code'=> $ProgrammeCode]);
		$Academicyear = Academicyear::findone(['Code'=> $AcademicYearCode]);
		$Semester = Dimensionvalue::findone(['Student Term' => 1, 'Code' => $SemesterCode]); 
		$Stage = Dimensionvalue::findone(['Student Programme Stage' => 1,'Code' => $StageCode]); 
		$balances= Customerbalance::findone([$CustomerID]);
		
		
		$DetailsArray['programme'] = empty($programme) ? '' : $programme->Name;
		$DetailsArray['Academicyear'] = empty($Academicyear) ? '' : $Academicyear->Description;
		$DetailsArray['Semester'] = empty($Semester) ? '' : $Semester->Name;
		$DetailsArray['Stage'] = empty($Stage) ? '' : $Stage->Name;
		$DetailsArray['Balance'] = empty($balances) ? '0' : $balances->Balance;
		$DetailsArray2['Balance'] = $DetailsArray['Balance']*-1;
		//print_r($DetailsArray);exit;
		$model = $this->findModel($id);
		
		//print_r($unit); exit;
		if (isset($unit)) {
			$Studentunits = Studentunits::find()->asArray()
				->where("[Reg_ Transacton ID] = '" . $id . "'")
				->andWhere("[Unit] = '" . $unit . "'")
				->orderBy('Description')->all();		
		}
		/* 
		if ( empty( $Studentunits ) ) {
			print_r('could not retrieve course unit'); exit;
		} */
		
		
		return $this->render('unitdetails', [
			'model' => $model,
			'DetailsArray' => $DetailsArray, 
			'DetailsArray2' => $DetailsArray2,
			'Studentunits' => $Studentunits, 
			'id'=>$id 
		]);
	}
	
		public function actionGetyearunits()
	{
		//$identity = Yii::$app->user->identity;
		//$Session = Courseregistration::find()->where(['Student No_' => $identity->CustomerID])->asArray()->all();
		//print_r($Session);exit;
		$params = Yii::$app->request->post();
		$year = $params['year'];
		$channel = array();
		$ProgrammeCode =  $params['ProgrammeCode'];
		//$AcademicYear = $Session['Academic Year'];
		//$SemesterCode = $Session['Semester'];
		//$StageCode = $Session['Stage'];
		$ModeCode = $params['ModeCode'];
        $Units=ProgrammeCourses::find()->where(['ProgrammeID'=>$ProgrammeCode, 
												'Programme Stage'=>$ProgrammeCode.'Y'.$year, 
												//'ProgStageTermID'=>$SemesterCode, 
												//'Mode of Study'=>$ModeCode
												])->all();
		$html = '<thead>
			<tr>
				<th class="text-left" width="10%"></th>
				<th class="text-left" width="20%">Code</th>
				<th class="text-left">Description</th>
				<th class="text-right" width="20%"><div style="text-align:right">Unit Fee</div></th>
			</tr>
		</thead>
		<tbody>	';
		
		$TotalAmount = 0;
		$Selected = array();
		$StatusArray = array();
		foreach ($Units AS $key => $row)
		{
			$s_id = $row["CourseCode"];
			$Checked = '';
			$Checked = (isset($Selected[$s_id])) ? 'checked' : '';
			$Disabled = (isset($StatusArray[$s_id])) ? 'disabled' : '';
			if (isset($Selected[$s_id]))
			{
				$TotalAmount += $row["Amount"];
			}
			
			$html.= '<tr>		
				<td>
					<input id="sunits['.$s_id.']" class="units-selector" name="sunits['.$s_id.']" type="checkbox" value="'.$row["Amount"].'" '.$Checked.' '.$Disabled.'/>
				</td>
				<td>'.$row["CourseCode"].'</td>
				<td>'.$row["Description"].'</td>					
				<td><div style="text-align:right">'.number_format($row["Amount"],2).'</div></td>	
			</tr>';			
		} 
		$html.='</tbody>
		<tfoot>
			<tr>
				<th></th>
				<th class="text-left" colspan="2">Total</th>
				<th class="text-right"><div style="text-align:right">'.number_format($TotalAmount,2).'</div></th>
			</tr>
		</tfoot>';
		echo $html;
	}
}
