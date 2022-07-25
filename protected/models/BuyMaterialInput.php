<?php

/**
 * This is the model class for table "buy_material_input".
 *
 * The followings are the available columns in table 'buy_material_input':
 * @property integer $id
 * @property string $customer
 * @property string $buy_date
 * @property integer $customer_id
 * @property string $bill_no
 * @property string $car_no
 * @property string $weight_in
 * @property string $weight_out
 * @property string $weight_loss
 * @property string $weight_net
 * @property string $price_unit
 * @property integer $material_id
 * @property string $price_net
 * @property string $last_update
 * @property integer $update_by
 * @property integer $site_id
 * @property string $note
 */
class BuyMaterialInput extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'buy_material_input';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer, buy_date, customer_id, bill_no, weight_net, material_id, price_net, last_update, update_by, site_id', 'required'),
			array('customer_id, material_id, update_by, site_id', 'numerical', 'integerOnly'=>true),
			array('customer, note', 'length', 'max'=>255),
			array('bill_no', 'length', 'max'=>45),
			array('car_no', 'length', 'max'=>15),
			array('weight_in, weight_out, weight_loss, weight_net, price_unit, price_net', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customer, buy_date, customer_id, bill_no, car_no, weight_in, weight_out, weight_loss, weight_net, price_unit, material_id, price_net, last_update, update_by, site_id, note', 'safe', 'on'=>'search'),
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
			'customer' => 'ชื่อลูกค้า',
			'buy_date' => 'วันที่รับซื้อ',
			'customer_id' => 'ชื่อลูกค้า',
			'bill_no' => 'เลขที่ใบรับซื้อ',
			'car_no' => 'ทะเบียนรถ',
			'weight_in' => 'น้ำหนักเข้า',
			'weight_out' => 'น้ำหนักออก',
			'weight_loss' => 'ของเสีย',
			'weight_net' => 'น้ำหนักสุทธิ',
			'price_unit' => 'ราคา/หน่วย',
			'material_id' => 'วัตถุดิบ',
			'price_net' => 'ราคารวม',
			'last_update' => 'Last Update',
			'update_by' => 'Update By',
			'site_id' => 'Site',
			'note' => 'หมายเหตุ',
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
		$criteria->compare('customer',$this->customer,true);
		$criteria->compare('buy_date',$this->buy_date,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('bill_no',$this->bill_no,true);
		$criteria->compare('car_no',$this->car_no,true);
		$criteria->compare('weight_in',$this->weight_in,true);
		$criteria->compare('weight_out',$this->weight_out,true);
		$criteria->compare('weight_loss',$this->weight_loss,true);
		$criteria->compare('weight_net',$this->weight_net,true);
		$criteria->compare('price_unit',$this->price_unit,true);
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('price_net',$this->price_net,true);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BuyMaterialInput the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
