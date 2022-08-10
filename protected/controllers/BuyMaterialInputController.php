<?php

class BuyMaterialInputController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new BuyMaterialInput;

		//running invoice_no
            $year = date('Y');
            $sql = 'SELECT MAX(bill_no) as max_no FROM buy_material_input  WHERE site_id="'.Yii::app()->user->getSite().'" AND YEAR(buy_date)='.$year;
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $max_no = $result[0]['max_no']+1;
            $year_th = $year+543;
            $no_str = $max_no;
            if($max_no<10)
            {
                $no_str = "00".$max_no;
            }
            else if($max_no<100)
            {
                $no_str = "0".$max_no;
            }

        $model->bill_no = $no_str;   

        

		if(isset($_POST['BuyMaterialInput']))
		{

			header('Content-type: text/plain'); 
			$model->attributes=$_POST['BuyMaterialInput'];
			
			//--if customer not exist then add new customer----//
			$modelCustomer = Customer::model()->findByPk($model->customer_id);
			if(empty($modelCustomer))
			{
				
				//print_r($_POST['BuyMaterialInput']);
				$modelCustomer = new Customer;
				$modelCustomer->name = $_POST["customer_id"];
				$group_id = empty($_POST["group_id"]) ? 0 : $_POST["group_id"];
				$modelCustomer->group_id = $group_id;
				$modelCustomer->address = $_POST["address"];
				$modelCustomer->phone = $_POST["phone"];
				$modelCustomer->type = "S";
				$modelCustomer->site_id = $model->site_id;
				$modelCustomer->save();	
				

			}

			$model->customer_id = $modelCustomer->id;
			$model->customer = $modelCustomer->name;

			$model->update_by = Yii::app()->user->ID;
			$model->last_update =  (date("Y")).date("-m-d H:i:s");
			$model->buy_date =  (date("Y")).date("-m-d");

			

			if($model->save())
				$this->redirect(array('index'));

			print_r($model);
			exit;
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BuyMaterialInput']))
		{
			$model->attributes=$_POST['BuyMaterialInput'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new BuyMaterialInput('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BuyMaterialInput']))
			$model->attributes=$_GET['BuyMaterialInput'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new BuyMaterialInput('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BuyMaterialInput']))
			$model->attributes=$_GET['BuyMaterialInput'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=BuyMaterialInput::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='buy-material-input-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
