<?php

class MaterialController extends Controller
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
				'actions'=>array('index','view','GetMaterial','GetPrice'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
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
		$model=new Material;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Material']))
		{
			$model->attributes=$_POST['Material'];
		
			
			if(isset($_POST['Material']['price1']) && !empty($_POST['Material']['price1']))
				$model->price1 = str_replace(",","",$_POST['Material']['price1']);
			else
				$model->price1 =0;
					
			if(isset($_POST['Material']['price2']) && !empty($_POST['Material']['price2']))
				$model->price2 = str_replace(",","",$_POST['Material']['price2']);
			else
				$model->price2 = 0;

			if(isset($_POST['Material']['price3']) && !empty($_POST['Material']['price3']))
				$model->price3 = str_replace(",","",$_POST['Material']['price3']);
			else
				$model->price3 = 0;
			if(isset($_POST['Material']['price4']) && !empty($_POST['Material']['price4']))
				$model->price4 = str_replace(",","",$_POST['Material']['price4']);
			else
				$model->price4 = 0;
			if(isset($_POST['Material']['price5']) && !empty($_POST['Material']['price5']))
				$model->price5 = str_replace(",","",$_POST['Material']['price5']);
			else
				$model->price5 = 0;
			if(isset($_POST['Material']['price6']) && !empty($_POST['Material']['price6']))
				$model->price6 = str_replace(",","",$_POST['Material']['price6']);
			else
				$model->price6 = 0;
			
			$model->site_id = empty($model->site_id) || $model->site_id=='' ? Yii::app()->user->getSite() : $model->site_id; 
			if($model->save())
			{
				//create stock
				$modelStock = new Stock;
				$modelStock->material_id = $model->id;
				$modelStock->site_id =Yii::app()->user->getSite();
				$modelStock->type = 0;
				$modelStock->user_id = Yii::app()->user->ID;
				$modelStock->amount = 0;
				$modelStock->last_update = date("Y-m-d H:i:s");
				$modelStock->save();

				//header('Content-type: text/plain');
				//print_r($modelStock);
				//exit;
				$this->redirect(array('index'));
			}
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

		if(isset($_POST['Material']))
		{
			$model->attributes=$_POST['Material'];
			if(isset($_POST['Material']['price1']))
				$model->price1 = str_replace(",","",$_POST['Material']['price1']);
			if(isset($_POST['Material']['price2']))
				$model->price2 = str_replace(",","",$_POST['Material']['price2']);
			if(isset($_POST['Material']['price3']))
				$model->price3 = str_replace(",","",$_POST['Material']['price3']);
			if(isset($_POST['Material']['price4']))
				$model->price4 = str_replace(",","",$_POST['Material']['price4']);
			if(isset($_POST['Material']['price5']))
				$model->price5 = str_replace(",","",$_POST['Material']['price5']);
			if(isset($_POST['Material']['price6']))
				$model->price6 = str_replace(",","",$_POST['Material']['price6']);
			$model->site_id = empty($model->site_id) || $model->site_id=='' ? Yii::app()->user->getSite() : $model->site_id; 
			//$model->save();
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
		$model=new Material('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Material']))
			$model->attributes=$_GET['Material'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Material('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Material']))
			$model->attributes=$_GET['Material'];

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
		$model=Material::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='material-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetMaterial(){
            $request=trim($_GET['term']);
            $site_id = Yii::app()->user->isAdmin() ? " " : " AND site_id='".Yii::app()->user->getSite().'"' ; 
                    
            $models=Material::model()->findAll(array("condition"=>"name like '%$request%' ".$site_id));
            //echo "name like '%$request%' '$site_id' ";
            $data=array();
            foreach($models as $model){
               
                $data[] = array(
                        'id'=>$model['id'],
                        'label'=>$model['name'],
                        'site_id'=>$model['site_id'],
              
                );

            }



            $this->layout='empty';
            echo json_encode($data);
        
    }

    public function actionGetPrice(){
            $group_customer = $_GET['group_customer'];
            $material_id = $_GET['material_id'];
            
            $model=Material::model()->findByPk($material_id);
            
            $price = 0;
            if(!empty($model))
            {
            	if($group_customer==1)
            		$price = $model->price1;
            	elseif($group_customer==2)
            		$price = $model->price2;
            	elseif($group_customer==3)	
            		$price = $model->price3;
            	else
            		$price = $model->price2;
            }
            echo $price;
        
    }
}
