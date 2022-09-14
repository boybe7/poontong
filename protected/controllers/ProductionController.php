<?php

class ProductionController extends Controller
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
				'actions'=>array('create','update','updateAjax'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('@'),
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
		$model=new Production;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Production']))
		{
			$model->attributes=$_POST['Production'];
			$model->flag_delete = 0;
			$model->last_update = date("Y-m-d H:i:s");
			$model->user_id = Yii::app()->user->ID;
			$model->site_id = Yii::app()->user->getSite();

			if($model->save())
			{
						//update stock
						$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site ",[":material_id"=>$model->material_id,':site'=>Yii::app()->user->getSite()]);
						$modelStock = !empty($stock) ? $stock[0] : new Stock;

						if(empty($stock))
						{
							$modelStock->material_id = $model->material_id;
							$modelStock->site_id =Yii::app()->user->getSite();
							$modelStock->type = 0;
							$modelStock->user_id = Yii::app()->user->ID;
							$modelStock->amount = 0;
						}	

						if($model->in_out==0)
						   $modelStock->amount -= $model->amount;
						else if($model->in_out==1)
						   $modelStock->amount += $model->amount;
						$modelStock->last_update = date("Y-m-d H:i:s");
						$modelStock->save();

						//update stock daily
						$str_date = explode("/", $model->production_date);
        				if(count($str_date)>1)
        					$model->production_date= ($str_date[2])."-".$str_date[1]."-".$str_date[0];
						$stock = StockDaily::model()->findAll("material_id=:material_id AND site_id=:site AND stock_date=:date",[":material_id"=>$model->material_id,':site'=>Yii::app()->user->getSite(),':date'=>$model->production_date]);
						$modelStock = !empty($stock) ? $stock[0] : new StockDaily;

						if(empty($stock))
						{
							$modelStock->material_id = $model->material_id;
							$modelStock->site_id =Yii::app()->user->getSite();
							$modelStock->type = 0;
							$modelStock->user_id = Yii::app()->user->ID;
							$modelStock->amount = 0;
							$modelStock->stock_date = $model->production_date;
						}													
						if($model->in_out==0)
						   $modelStock->amount -= $model->amount;
						else if($model->in_out==1)
						   $modelStock->amount += $model->amount;
						$modelStock->last_update = date("Y-m-d H:i:s");
						$modelStock->save();


				$this->redirect(array('index'));
			}
		}

		//$this->render('create',array(
		//	'model'=>$model,
		//));
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

		if(isset($_POST['Production']))
		{
			$model->attributes=$_POST['Production'];
			if($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionUpdateAjax()
	{
		$es = new EditableSaver('Production');
	    try {
	    
	    		$model = Production::model()->findByPk($_POST['pk']);
	    		$stock = Stock::model()->findAll('material_id='.$model->material_id);


	    		if($_POST['name']=='amount' )
	    		{
	    			if(!empty($stock))
		    		{
		    			$old_amount = $model->amount;
		    			$es->update();

		    			//update stock
						$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site ",[":material_id"=>$model->material_id,':site'=>Yii::app()->user->getSite()]);
						$modelStock = !empty($stock) ? $stock[0] : new Stock;

						if(empty($stock))
						{
							$modelStock->material_id = $model->material_id;
							$modelStock->site_id =Yii::app()->user->getSite();
							$modelStock->type = 0;
							$modelStock->user_id = Yii::app()->user->ID;
							$modelStock->amount = 0;
						}	

						if($model->in_out==0)
						   $modelStock->amount = $modelStock->amount + $old_amount - $_POST['value'] ;
						else if($model->in_out==1)
						   $modelStock->amount = $modelStock->amount - $old_amount + $_POST['value']  ;
						$modelStock->last_update = date("Y-m-d H:i:s");
						$modelStock->save();

						//update stock daily
						$str_date = explode("/", $model->production_date);
        				if(count($str_date)>1)
        					$model->production_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
						$stock = StockDaily::model()->findAll("material_id=:material_id AND site_id=:site AND stock_date=:date",[":material_id"=>$model->material_id,':site'=>Yii::app()->user->getSite(),':date'=>$model->production_date]);
						$modelStock = !empty($stock) ? $stock[0] : new StockDaily;

						if(empty($stock))
						{
							$modelStock->material_id = $model->material_id;
							$modelStock->site_id =Yii::app()->user->getSite();
							$modelStock->type = 0;
							$modelStock->user_id = Yii::app()->user->ID;
							$modelStock->amount = 0;
							$modelStock->stock_date = $model->production_date;
						}													
						if($model->in_out==0)
						   $modelStock->amount = $modelStock->amount + $old_amount - $_POST['value'] ;
						else if($model->in_out==1)
						   $modelStock->amount = $modelStock->amount - $old_amount + $_POST['value']  ;
						$modelStock->last_update = date("Y-m-d H:i:s");
						$modelStock->save();
		    		}	
		    		
	    		}

	    		



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
			$model = $this->loadModel($id);
			

			$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site ",[":material_id"=>$model->material_id,':site'=>Yii::app()->user->getSite()]);
						$modelStock = !empty($stock) ? $stock[0] : new Stock;

						if(empty($stock))
						{
							$modelStock->material_id = $model->material_id;
							$modelStock->site_id =Yii::app()->user->getSite();
							$modelStock->type = 0;
							$modelStock->user_id = Yii::app()->user->ID;
							$modelStock->amount = 0;
						}	

						if($model->in_out==0)
						   $modelStock->amount += $model->amount;
						else if($model->in_out==1)
						   $modelStock->amount -= $model->amount;
						$modelStock->last_update = date("Y-m-d H:i:s");
						$modelStock->save();

						//update stock daily
						$str_date = explode("/", $model->production_date);
        				if(count($str_date)>1)
        					$model->production_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
						$stock = StockDaily::model()->findAll("material_id=:material_id AND site_id=:site AND stock_date=:date",[":material_id"=>$model->material_id,':site'=>Yii::app()->user->getSite(),':date'=>$model->production_date]);
						$modelStock = !empty($stock) ? $stock[0] : new StockDaily;

						if(empty($stock))
						{
							$modelStock->material_id = $model->material_id;
							$modelStock->site_id =Yii::app()->user->getSite();
							$modelStock->type = 0;
							$modelStock->user_id = Yii::app()->user->ID;
							$modelStock->amount = 0;
							$modelStock->stock_date = $model->$production_date;
						}													
						if($model->in_out==0)
						   $modelStock->amount += $model->amount;
						else if($model->in_out==1)
						   $modelStock->amount -= $model->amount;
						$modelStock->last_update = date("Y-m-d H:i:s");
						$modelStock->save();

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
		$model=new Production('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Production']))
			$model->attributes=$_GET['Production'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Production('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Production']))
			$model->attributes=$_GET['Production'];

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
		$model=Production::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='production-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
