<?php

/**
 * This is the model class for table "sell_material_detail".
 *
 * The followings are the available columns in table 'sell_material_detail':
 * @property integer $id
 * @property integer $material_id
 * @property string $amount
 * @property string $price_unit
 * @property string $price_net
 * @property integer $sell_id
 * @property string $weight_in
 * @property string $weight_out
 */
class SellMaterialDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sell_material_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('material_id, amount, price_unit, price_net, sell_id', 'required'),
			array('material_id, sell_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>11),
			array('price_unit', 'length', 'max'=>10),
			array('price_net, weight_in, weight_out', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, material_id, amount, price_unit, price_net, sell_id, weight_in, weight_out', 'safe', 'on'=>'search'),
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
			'material_id' => 'ผลผลิต',
			'amount' => 'น้ำหนักสุทธิ',
			'price_unit' => 'ราคา/หน่วย',
			'price_net' => 'ราคารวม',
			'sell_id' => 'Buy',
			'weight_in' => 'น้ำหนักเข้า',
			'weight_out' => 'น้ำหนักออก',
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
		$criteria->compare('price_unit',$this->price_unit,true);
		$criteria->compare('price_net',$this->price_net,true);
		$criteria->compare('sell_id',$this->sell_id);
		$criteria->compare('weight_in',$this->weight_in,true);
		$criteria->compare('weight_out',$this->weight_out,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByID($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('price_unit',$this->price_unit,true);
		$criteria->compare('price_net',$this->price_net,true);
		$criteria->compare('sell_id',$id);
		$criteria->compare('weight_in',$this->weight_in,true);
		$criteria->compare('weight_out',$this->weight_out,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SellMaterialDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
    {
        
		$this->amount = str_replace(",", "", $this->amount); 
		$this->price_unit = str_replace(",", "", $this->price_unit); 
		$this->price_net = str_replace(",", "", $this->price_net); 
		$this->weight_in = str_replace(",", "", $this->weight_in); 
		$this->weight_out = str_replace(",", "", $this->weight_out);	

		 
		return parent::beforeSave();  
	}

	public static function getTotals($provider)
	{
		$total=0;

	    foreach($provider->data as $item)

	        $total+=$item->price_net;

	    return $total;
	}
}
