<?php

class AuthenController extends Controller
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
				'actions'=>array('create','update',"getGroup",'delete'),
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
		$model=new Authen;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Authen']))
		{
			$model->attributes=$_POST['Authen'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionUpdate()
	{
		$model=new Authen("search");

		

		if(isset($_POST['user_group']) && !empty($_POST['user_group']))
		{
		
		  $transaction=Yii::app()->db->beginTransaction();
		  try {	
				//case 1 : check exist user_group
				$model_group = UserGroup::model()->findAll('name=:group', array(':group' =>$_POST['user_group'] )); 
				
					if(!empty($model_group))
					{
							Yii::app()->db->createCommand('DELETE FROM authen WHERE user_group_id='.$model_group[0]->id)->execute();
							$group_id = $model_group[0]->id;

                          $menus  = Menu::model()->findAll();
							foreach ($menus as $key => $menu) {
								$var = "authen_rule_".$menu->id;
								if(isset($_POST[$var]))
								{
									//header('Content-type: text/plain');
                           		    
									$m_rule = new Authen("search");
									$m_rule->name = $menu->title;
									$m_rule->status = 1;
									$m_rule->user_group_id = $group_id;
									$m_rule->menu_id = $menu->id;
									$m_rule->access = $_POST[$var];
								

									$m_rule->save();

									//print_r($m_rule);                    
                             	    //exit;

								}	
							}	
					}	
					else
					{
						$model_group = new UserGroup("search");
						$model_group->name = $_POST['user_group'];
						if($model_group->save())
						{
							$menus  = Menu::model()->findAll();
							foreach ($menus as $key => $menu) {
								$var = "authen_rule_".$menu->id;
								if(isset($_POST[$var]))
								{
									// header('Content-type: text/plain');
         //                   		    echo $var.":".$_POST[$var];                    
         //                     	    exit;
									$m_rule = new Authen("search");
									$m_rule->name = $menu->title;
									$m_rule->status = 1;

									$m_rule->user_group_id = $model_group->id;
									$m_rule->menu_id = $menu->id;
									$m_rule->access = $_POST[$var];
								

									$m_rule->save();

								}	
							}	
						}
					}
				
					
					
				


				$transaction->commit();
			    $this->redirect(array('index'));
		  }
		  catch(Exception $e)
	 	  {
	 				$transaction->rollBack();	
	 				$model->addError('Authen', 'Error occured while saving data.');
	 				Yii::trace(CVarDumper::dumpAsString($e->getMessage()));
	 	        	//you should do sth with this exception (at least log it or show on page)
	 	        	Yii::log( 'Exception when saving data: ' . $e->getMessage(), CLogger::LEVEL_ERROR );
	 
	 	  }    	
			
		}
		else if(isset($_POST["user_group"]) && empty($_POST["user_group"])){
			$model->addError('Authen', 'กรุณากรอกชื่อกลุ่มผู้ใช้งาน');
		}

		$this->render('_form',array(
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
			Yii::app()->db->createCommand('DELETE FROM user_group WHERE id='.$id)->execute();

			Yii::app()->db->createCommand('DELETE FROM authen WHERE user_group_id='.$id)->execute();

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
		$model=new UserGroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UserGroup']))
			$model->attributes=$_GET['UserGroup'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Authen('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Authen']))
			$model->attributes=$_GET['Authen'];

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
		$model=Authen::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='authen-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionGetGroup(){
            $request=trim($_GET['term']);
                    
            $models=UserGroup::model()->findAll(array("condition"=>"name like '%$request%'"));
            $data=array();
            foreach($models as $model){
                //$data[]["label"]=$get->v_name;
                //$data[]["id"]=$get->v_id;

            	$rules = Yii::app()->db->createCommand()
                                                ->select('menu_id,access')
                                                ->from('authen')
                                                ->where('user_group_id=:id', array(':id'=>$model['id']))
                                                ->queryAll();
                $data[] = array(
                        'id'=>$model['id'],
                        'label'=>$model['name'],
                        'rules'=>$rules,
                      
                );

            }
            $this->layout='empty';
            echo json_encode($data);
        
    }
}
