<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $telephone
 * @property integer $status
 * @property integer $site_id
 * @property integer $user_group_id
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, name, status, site_id, user_group_id', 'required'),
			array('status, site_id, user_group_id', 'numerical', 'integerOnly'=>true),
			array('username, password, name', 'length', 'max'=>255),
			array('telephone', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, name, telephone, status, site_id, user_group_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'name' => 'Name',
			'telephone' => 'Telephone',
			'status' => '0=inactive, 1=active',
			'site_id' => 'Site',
			'user_group_id' => 'User Group',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		if(!Yii::app()->user->isAdmin() )
		{
			//$criteria->compare('username',$this->username,true);
			$criteria->addNotInCondition('username', array('admin'));
		}	
		else
			$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('telephone',$this->telephone,true);
		$criteria->compare('status',$this->status);
		//if(Yii::app()->user->isAdmin())
		//  $criteria->compare('site_id',$this->site_id);
		//else
		  $criteria->compare('site_id',Yii::app()->user->getSite());	
		$criteria->compare('user_group_id',$this->user_group_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getGroupName($gid)
    {
        switch ($gid) {
        	case 1:
        		$name = "admin";
        		break;
        	case 2:
        		$name = "superuser";
        		break;
        	case 3:
        		$name = "user";
        		break;
        	case 4:
        		$name = "executive";
        		break;		
        	default:
        		$name = "";
        		break;
        }
        return $name;
    }
	public function validatePassword($form_password)
    {
       
    	return CPasswordHelper::verifyPassword($form_password,$this->password);
     
    }
    
    public function beforeSave()
    {
        
            $this->password= CPasswordHelper::hashPassword($this->password);
             
            return parent::beforeSave();
    }
}
