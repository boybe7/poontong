<?php

/**
 * This is the model class for table "blade".
 *
 * The followings are the available columns in table 'blade':
 * @property integer $id
 * @property integer $lenght
 * @property integer $width
 * @property integer $amount
 * @property string $last_update
 * @property integer $site_id
 */
class Blade extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'blade';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lenght, width, amount, last_update, site_id', 'required'),
			array('lenght, width, amount, site_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lenght, width, amount, last_update, site_id', 'safe', 'on'=>'search'),
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
			'lenght' => 'ความยาว (cm)',
			'width' => 'ความกว้าง (cm)',
			'amount' => 'จำนวน',
			'last_update' => 'วันที่อัพเดต',
			'site_id' => 'Site',
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
		$criteria->compare('lenght',$this->lenght);
		$criteria->compare('width',$this->width);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('site_id',Yii::app()->user->getSite());

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Blade the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
