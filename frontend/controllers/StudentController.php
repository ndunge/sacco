<?php

namespace frontend\controllers;

use Yii;
use common\models\Studentapplication;
use common\models\Studentstatus;
use common\models\Academiclines;
use common\models\Collegelines;
use common\models\Applicationprogrammes;
use common\models\Contact;
use common\models\SponsorDetailsApp;
use common\models\KinDetailsApp;
use common\models\Customers;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentapplicationController implements the CRUD actions for Studentapplication model.
 */
class StudentController extends Controller
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
		$baseUrl = Yii::$app->request->baseUrl;
		$identity = Yii::$app->user->identity;
		$ProfileID = $identity->ProfileID;
		$customerid = $identity->Userid;
		$sql = "SELECT *
                      FROM [TRAINED DB\$Customer] 
                      WHERE No_ = '$customerid'";
		$result = Customers::findBySql($sql)->asArray()->all();
		//print_r($result);exit;
		
		$ApprovalStatus = array('','Open','Approved','Pending Approval','Pending Prepayment','Rejected');

		$channel = array();
		foreach ($result AS $key => $row) 
		{
			//extract($row); 
			$channel[] = array(
								$row['No_'],
								$row['Name'],
								$row['National ID'],
								date("d/m/Y", strtotime($row['Date of Join'])),
								// $ApprovalStatus[$row['ApprovalStatus']],
								//  date("d/m/Y", strtotime($row['ApplicationDate'])),				
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
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
    	$StudentID = $identity->Userid;
      $ID = $StudentID ;
      //print_r($ID);exit;

$model2= Customers::findbysql('SELECT * from [TRAINED DB$Customer] where No_ =  \''.$ID .'\'' )->one();
//print_r($model2);exit;
        
        // if (!empty($model2)){
        // 	echo "Hey";
        // }
        // else{
        // 	echo "Not working";
        // }
        
       //$model = $this->findModel($id);
		$params = Yii::$app->request->post();
		
		if (!empty($params))
		{
			
			$types = $model->getTableSchema()->columns;
			foreach($model AS $key => $value)
			{
				$key1 = str_replace(" ","_",$key);
				if (($key == 'No_') or ($key == 'Credit Limit (LCY)') or ($key == 'Name') or ($key == 'Activated') or ($key == 'Activation Code'))
				{
					
				} else if (($key=='Phone No_'))
				{
					$model[$key] = $params['Phone_No_'];
				} else if (array_key_exists($key1,$params))
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
				}	
			}
               $model['Activated'] = 1;	
			   //unset the semester and stage
			   /* unset($model->Semester);
			   unset($model->StageID); */
			   
//print_r($model);exit;			   
			if ($model->save())
			{
				return $this->render('update', [ 'model' => $model, 'msg' => 'Saved Successfully']);
			} else{
	                print_r($model->getErrors());
					return $this->render('update', [ 'model' => $model, 'error' => $model->getErrors()]);
            }			
        } else 
		{
			return $this->render('update', [ 'model2' => $model2]);
        }
    }

    /**
     * Deletes an existing Studentapplication model.
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
     * Finds the Studentapplication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Studentapplication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
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
}
