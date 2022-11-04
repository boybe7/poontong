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
				'actions'=>array('index','view','print'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','createItemDetailTemp','deleteDetailTemp','updateDetailTemp','createItemDetail','deleteDetail','updateDetail','delete'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
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
            $site = Yii::app()->user->isAdmin() ? 1 : Yii::app()->user->getSite();
            $sql = 'SELECT MAX(bill_no) as max_no FROM buy_material_input  WHERE site_id='.$site.' AND YEAR(buy_date)='.$year;
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

        //add first item for fix editable gridview
        $temp = BuyMaterialDetailTemp::model()->findAll("flag=1 AND user_id=".Yii::app()->user->ID);
        if(empty($temp))
        {
        	$temp = new BuyMaterialDetailTemp;
        	$temp->buy_id = 0;
        	$temp->user_id = Yii::app()->user->ID;
        	$temp->flag = 1;
        	$temp->amount = 0;
        	$temp->price_unit = 0;
        	$temp->price_net = 0;
        	$temp->material_id = 0;
        	$temp->weight_in = 0;
        	$temp->weight_out = 0;
        	$temp->weight_loss = 0;
        	$temp->save();
        }  

	        

        

		if(isset($_POST['BuyMaterialInput']))
		{

			//header('Content-type: text/plain');
			$model->attributes=$_POST['BuyMaterialInput'];
			$model->note = $_POST['BuyMaterialInput']['note'];
			
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
			//$model->customer = $modelCustomer->name;

			$model->update_by = Yii::app()->user->ID;
			$model->last_update =  (date("Y")).date("-m-d H:i:s");
			//$model->buy_date =  (date("Y")).date("-m-d");

			

			if($model->save())
			{
				$temp = BuyMaterialDetailTemp::model()->findAll("user_id=:user_id AND flag is NULL", [":user_id" =>Yii::app()->user->ID]);

				foreach ($temp as $key => $value) {
					$modelDetail = new BuyMaterialDetail;
					$modelDetail->material_id = $value->material_id;
					$modelDetail->price_unit = $value->price_unit;
					$modelDetail->amount = $value->amount;
					$modelDetail->weight_in = $value->weight_in;
					$modelDetail->weight_out = $value->weight_out;
					$modelDetail->weight_loss = $value->weight_loss;
					$modelDetail->price_net = $value->price_net;
					$modelDetail->percent_moisture = $value->percent_moisture;
					$modelDetail->buy_id = $model->id;
					if($modelDetail->save())
					{
						//echo "Saved";
						//add stock
						$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site AND type=0",[":material_id"=>$modelDetail->material_id,':site'=>Yii::app()->user->getSite()]);
						
						$modelStock =  new Stock;
						if(empty($stock))
						{


							$modelStock->material_id = $modelDetail->material_id;
							$modelStock->site_id = Yii::app()->user->getSite();
							$modelStock->type = 0;
							$modelStock->amount = $modelDetail->amount;
							$modelStock->user_id = Yii::app()->user->id;
							$modelStock->last_update = date("Y-m-d H:i:s");
							$modelStock->save();
						} 
						else
						{
							$modelStock =  $stock[0];

							$modelStock->amount += $modelDetail->amount;
							$modelStock->last_update = date("Y-m-d H:i:s");
							$modelStock->save();
						}

						//print_r($modelStock);


					}
					//print_r($modelDetail);
					
				}
        	
				$this->redirect(array('index'));
			}

			
			//exit;
		}
		else if (!Yii::app()->request->isAjaxRequest)
        {
        	//header('Content-type: text/plain'); 
        	BuyMaterialDetailTemp::model()->deleteAll("user_id=:user_id AND flag is NULL", [":user_id" =>Yii::app()->user->ID]);
        	
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
			header('Content-type: text/plain'); 
			$model->attributes=$_POST['BuyMaterialInput'];
			$model->note = $_POST['BuyMaterialInput']['note'];
			
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
			//$model->customer = $modelCustomer->name;

			$model->update_by = Yii::app()->user->ID;
			$model->last_update =  (date("Y")).date("-m-d H:i:s");
			

			if($model->save())
				$this->redirect(array('index'));

			print_r($model);
			exit;
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

			//BuyMaterialDetail::model()->deleteAll("buy_id=:buy_id", [":buy_id" =>$id]);
			$details = BuyMaterialDetail::model()->findAll("buy_id=:buy_id", [":buy_id" =>$id]);
			foreach ($details as $key => $value) {
				$this->actionDeleteDetail($value->id);
			}

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

	public function actionCreateItemDetailTemp()
	{

		$model = new BuyMaterialDetailTemp;
		$model->material_id = $_POST['material_id'];
		$model->price_unit = $_POST['price_unit'];
		$model->price_net = $_POST['price_net'];
		$model->amount = $_POST['amount'];
		$model->weight_in = $_POST['weight_in'];
		$model->weight_out = $_POST['weight_out'];
		$model->weight_loss = $_POST['weight_loss'];
		$model->percent_moisture = $_POST['percent_moisture'];
		
		$model->buy_id = 0;
		$model->user_id = Yii::app()->user->ID;

		if($model->save())
	        echo 'success';
	    else
	    	echo 'fail';
	}

	public function actionDeleteDetailTemp($id)
	{
		$model = BuyMaterialDetailTemp::model()->findByPk($id);
		$model->delete();

	}


	public function actionUpdateDetailTemp()
    {
	    $es = new EditableSaver('BuyMaterialDetailTemp');
	    try {
	    	
	    	$es->update();

	    	if($_POST['name']=='price_unit' || $_POST['name']=='amount')
	    	{
	    		$model = BuyMaterialDetailTemp::model()->findByPk($_POST['pk']);
	    		$_POST['name']='price_net';	
	    		$_POST['value'] = $model->price_unit*$model->amount;
	    		$es->update();
	    	}	

	    	if($_POST['name']=='weight_in' || $_POST['name']=='weight_out' || $_POST['name']=='weight_loss' || $_POST['name']=='percent_moisture')
	    	{
	    		$model = BuyMaterialDetailTemp::model()->findByPk($_POST['pk']);
	    		$_POST['name']='amount';
	    		$moisture = 0;
	    		if(!empty($model->percent_moisture))
	    		$moisture = ($model->weight_in - $model->weight_out)*($model->percent_moisture/100);	
	    		$amount = $model->weight_in - $model->weight_out - $model->weight_loss - $moisture;
	    		$_POST['value'] = $amount;
	    		$es->update();

	    		$_POST['name']='price_net';	
	    		$_POST['value'] = $model->price_unit*$amount;
	    		$es->update();
	    	}	

	    } catch(CException $e) {
	    	echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
	    	return;
	    }
	    echo CJSON::encode(array('success' => true));
    }

    public function actionCreateItemDetail($id)
	{

		$model = new BuyMaterialDetail;
		$model->material_id = $_POST['material_id'];
		$model->price_unit = $_POST['price_unit'];
		$model->price_net = $_POST['price_net'];
		$model->amount = $_POST['amount'];

		$model->weight_in = $_POST['weight_in'];
		$model->weight_out = $_POST['weight_out'];
		$model->weight_loss = $_POST['weight_loss'];
		$model->percent_moisture = $_POST['percent_moisture'];
		$model->buy_id = $id;

		if($model->save()){
	        echo 'success';

	        			$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site AND type=0",[":material_id"=>$model->material_id,':site'=>Yii::app()->user->getSite()]);
						
						$modelStock =  new Stock;
						if(empty($stock))
						{


							$modelStock->material_id = $model->material_id;
							$modelStock->site_id = Yii::app()->user->getSite();
							$modelStock->type = 0;
							$modelStock->amount = $model->amount;
							$modelStock->user_id = Yii::app()->user->id;
							$modelStock->last_update = date("Y-m-d H:i:s");
							$modelStock->save();
						} 
						else
						{
							$modelStock =  $stock[0];

							$modelStock->amount += $model->amount;
							$modelStock->last_update = date("Y-m-d H:i:s");
							$modelStock->save();
						}
		}
	    else
	    	echo 'fail';
	}

	public function actionDeleteDetail($id)
	{
		$model = BuyMaterialDetail::model()->findByPk($id);
		$material_id = $model->material_id;
		$old_amount = $model->amount;
		$model->delete();

		//update stock
		$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site AND type=0",[":material_id"=>$material_id,':site'=>Yii::app()->user->getSite()]);

		//echo "material_id=".$material_id." AND site_id=".Yii::app()->user->getSite()." AND type=0";

		if(!empty($stock))
		{
			$modelStock =  $stock[0];
			$modelStock->amount -= $old_amount;
			$modelStock->last_update = date("Y-m-d H:i:s");
			$modelStock->save();
		}

	}


	public function actionUpdateDetail()
    {
	    $es = new EditableSaver('BuyMaterialDetail');
	    try {
	    	$modelOld = BuyMaterialDetail::model()->findByPk($_POST['pk']);

	    	$es->update();

	    	if($_POST['name']=='price_unit' || $_POST['name']=='amount')
	    	{
	    		$model = BuyMaterialDetail::model()->findByPk($_POST['pk']);
	    		$_POST['name']='price_net';	
	    		$_POST['value'] = $model->price_unit*$model->amount;
	    		$es->update();
	    	}	

	    	if($_POST['name']=='weight_in' || $_POST['name']=='weight_out' || $_POST['name']=='weight_loss' || $_POST['name']=='percent_moisture')
	    	{
	    		$model = BuyMaterialDetail::model()->findByPk($_POST['pk']);
	    		$_POST['name']='amount';
	    		$moisture = 0;
	    		if(!empty($model->percent_moisture))
	    		$moisture = ($model->weight_in - $model->weight_out)*($model->percent_moisture/100);	
	    		
	    		$amount = $model->weight_in - $model->weight_out - $model->weight_loss - $moisture;
	    		$_POST['value'] = $amount;
	    		$es->update();

	    		$_POST['name']='price_net';	
	    		$_POST['value'] = $model->price_unit*$amount;
	    		$es->update();
	    	}	
	    	$modelNew = BuyMaterialDetail::model()->findByPk($_POST['pk']);


	    	//update stock
	    	$stock = Stock::model()->findAll("material_id=:material_id AND site_id=:site AND type=0",[":material_id"=>$modelOld->material_id,':site'=>Yii::app()->user->getSite()]);
			$modelStock =  $stock[0];
			$modelStock->amount -= $modelOld->amount;
			$modelStock->amount += $modelNew->amount;
			$modelStock->last_update = date("Y-m-d H:i:s");
			$modelStock->save();
						
	    } catch(CException $e) {
	    	echo CJSON::encode(array('success' => false, 'msg' => $e->getMessage()));
	    	return;
	    }
	    echo CJSON::encode(array('success' => true));
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
		           //if(chmod($path, 0777)){
						echo "chmod ok";
						if(unlink($file))
							echo $file;
				    //}else{
				    //    echo "chmod is fail";
				    //}	
		           
		        }

		    }


    	if(Yii::app()->request->isAjaxRequest)
		$this->render('_formPDF',array('filename' => $_GET['filename'],'id'=>$id,'model'=>$this->loadModel($id)));

	

	}
}
