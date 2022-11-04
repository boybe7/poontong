<?php

/**
 * This is the model class for table "stock".
 *
 * The followings are the available columns in table 'stock':
 * @property integer $id
 * @property integer $amount
 * @property integer $site_id
 * @property integer $user_id
 * @property string $last_update
 * @property integer $material_id
 * @property integer $type
 */
class Stock extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('amount, site_id, user_id, last_update, material_id, type', 'required'),
			array('site_id, user_id, material_id, type,sack,bigbag', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, amount, site_id, user_id, last_update, material_id, type,sack,bigbag', 'safe', 'on'=>'search'),
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
			'amount' => 'จำนวน กก.',
			'sack' => 'จำนวน กระสอบ',
			'bigbag' => 'จำนวน Bigbag',
			'site_id' => 'Site',
			'user_id' => 'ผู้บันทึก',
			'last_update' => 'ล่าสุด',
			'material_id' => 'วัตถุดิบ',
			'type' => '0=material,1=chemical,2=blade',
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
		$criteria->compare('amount',$this->amount);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('sack',$this->sack);
		$criteria->compare('bigbag',$this->bigbag);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByType($type)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('site_id',Yii::app()->user->getSite());
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('sack',$this->sack);
		$criteria->compare('bigbag',$this->bigbag);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('type',$type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Stock the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function beforeSave()
    {
        
		$this->amount = str_replace(",", "", $this->amount); 
		
		 
		return parent::beforeSave();  
	}
}
