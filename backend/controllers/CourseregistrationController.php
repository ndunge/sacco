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
				FROM [Ritman Test\$Course Registration -R] Courses
				LEFT JOIN [Ritman Test\$Customer] Customer ON Customer.No_ = Courses.[Student No_]
				LEFT JOIN [Ritman Test\$Dimension Value] Programme ON Programme.[Code] = Courses.Programme
				LEFT JOIN [Ritman Test\$Dimension Value] Stage ON Stage.[Code] = Courses.Stage
				LEFT JOIN [Ritman Test\$Academic Year] AcademicYear ON AcademicYear.Code = Courses.[Academic Year]
				WHERE [Student No_] = '$CustomerID' AND Courses.Status <> 4";
        $result = Courseregistration::findBySql($sql)->asArray()->all();

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
                $row['Registration Date'],
            );
        }
        $rss = $channel;
        $json = json_encode($rss);

        return $this->render('index', ['json' => $json]);
    }

    /**
     * Displays a single Courseregistration model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
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
        return $this->render('view', ['model' => $model, 'Selected' => $Selected]);
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
        if (!empty($params)) {
            //exit;
            $types = $model->getTableSchema()->columns;

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

            if ($model->save()) {
                return $this->redirect(['index']);
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
            return $this->render('create', ['model' => $model]);
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
        if (!empty($params)) {
            foreach ($model AS $key => $value) {
                $key1 = str_replace(" ", "_", $key);
                if (array_key_exists("$key1", $params)) {
                    $model["$key"] = $params["$key1"];
                }
            }
            $model['Academic Year'] = $params["Academic_Year"];
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
}
