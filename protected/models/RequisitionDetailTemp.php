<?php

/**
 * This is the model class for table "requisition_detail_temp".
 *
 * The followings are the available columns in table 'requisition_detail_temp':
 * @property integer $id
 * @property integer $material_id
 * @property string $amount
 * @property integer $sack
 * @property integer $bigbag
 * @property integer $requisition_id
 * @property integer $user_id
 * @property integer $flag
 */
class RequisitionDetailTemp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'requisition_detail_temp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('material_id, amount, requisition_id, user_id, flag', 'required'),
			array('material_id, sack, bigbag, requisition_id, user_id, flag', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, material_id, amount, sack, bigbag, requisition_id, user_id, flag', 'safe', 'on'=>'search'),
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
			'material_id' => 'วัตถุดิบ',
			'amount' => 'จำนวน กก.',
			'sack' => 'จำนวนกระสอบ',
			'bigbag' => 'จำนวน bigbag',
			'requisition_id' => 'Requisition',
			'user_id' => 'User',
			'flag' => 'Flag',
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
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('sack',$this->sack);
		$criteria->compare('bigbag',$this->bigbag);
		$criteria->compare('requisition_id',$this->requisition_id);
		$criteria->compare('user_id',,Yii::app()->user->ID);
		$criteria->compare('flag',$this->flag);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return RequisitionDetailTemp the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
    {
        
		$this->amount = str_replace(",", "", $this->amount); 
		$this->sack = str_replace(",", "", $this->sack); 
		$this->bigbag = str_replace(",", "", $this->bigbag);
		 
		return parent::beforeSave();  
	}
}
