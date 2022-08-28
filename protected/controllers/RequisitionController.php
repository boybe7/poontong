<?php

class RequisitionController extends Controller
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
				'actions'=>array('create','update','update2'),
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
		$model=new Requisition;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Requisition']))
		{
			$model->attributes=$_POST['Requisition'];
			
			if($model->save()){

				//update stock
				$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site ",[":material_id"=>$model->material_id,':site'=>Yii::app()->user->getSite()]);
				$modelStock =  $stock[0];
				$modelStock->amount -= $model->amount;
				$modelStock->sack -= $model->sack;
				$modelStock->bigbag -= $model->bigbag;
				$modelStock->last_update = date("Y-m-d H:i:s");
				$modelStock->save();

				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Requisition']))
		{
			$modelOld = $this->loadModel($id);
			$model->attributes=$_POST['Requisition'];

			if($model->save())
			{
				//header('Content-type: text/plain');
				//update stock
		    	$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site ",[":material_id"=>$modelOld->material_id,':site'=>Yii::app()->user->getSite()]);
				$modelStock =  $stock[0];
				$modelStock->amount += $modelOld->amount;
				$modelStock->sack += $modelOld->sack;
				$modelStock->bigbag += $modelOld->bigbag;
				$modelStock->last_update = date("Y-m-d H:i:s");
				$modelStock->save();
				

				$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site ",[":material_id"=>$model->material_id,':site'=>Yii::app()->user->getSite()]);
				$modelStock =  $stock[0];
				$modelStock->amount -= $model->amount;
				$modelStock->sack -= $model->sack;
				$modelStock->bigbag -= $model->bigbag;
				$modelStock->last_update = date("Y-m-d H:i:s");
				$modelStock->save();
				//print_r($modelStock);
				//exit;

				$this->redirect(array('index'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate2()
	{
		$es = new EditableSaver('Requisition');
	    try {
	    	$modelOld = Requisition::model()->findByPk($_POST['pk']);

	    	$es->update();
   		
	    	$modelNew = Requisition::model()->findByPk($_POST['pk']);
	    	//update stock
	    	$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site ",[":material_id"=>$modelOld->material_id,':site'=>Yii::app()->user->getSite()]);
			$modelStock =  $stock[0];
			$modelStock->amount += $modelOld->amount;
			$modelStock->amount -= $modelNew->amount;
			$modelStock->sack += $modelOld->sack;
			$modelStock->sack -= $modelNew->sack;
			$modelStock->bigbag += $modelOld->bigbag;
			$modelStock->bigbag -= $modelNew->bigbag;
			$modelStock->last_update = date("Y-m-d H:i:s");
			$modelStock->save();
						
	    } catch(CException $e) {
	    	echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
	    	return;
	    }
	    echo CJSON::encode(array('success' => true));
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
		$model=new Requisition('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Requisition']))
			$model->attributes=$_GET['Requisition'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Requisition('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Requisition']))
			$model->attributes=$_GET['Requisition'];

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
		$model=Requisition::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='requisition-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionPrint($id){

    	//delete old file
    	$path = $_SERVER['DOCUMENT_ROOT'].'/poontong/report/temp/';
		foreach (glob($path."*") as $file) {
		        $filelastmodified = filemtime($file);
		        //echo $file."<br>";
		        //echo (time() - $filelastmodified);
		        //24 hours in a day * 3600 seconds per hour
		        if((time() - $filelastmodified) > 12*3600)
		        {
		           if(chmod($path, 0777)){
						echo "chmod ok";
						if(unlink($file))
							echo $file;
				    }else{
				        echo "chmod is fail";
				    }	
		           
		        }

		    }


    	if(Yii::app()->request->isAjaxRequest)
		$this->render('_formPDF',array('filename' => $_GET['filename'],'id'=>$id,'model'=>$this->loadModel($id)));

	

	}
}
