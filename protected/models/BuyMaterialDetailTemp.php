<?php

/**
 * This is the model class for table "buy_material_detail_temp".
 *
 * The followings are the available columns in table 'buy_material_detail_temp':
 * @property integer $id
 * @property integer $material_id
 * @property string $price_unit
 * @property string $price_net
 * @property integer $buy_id
 * @property integer $user_id
 */
class BuyMaterialDetailTemp extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'buy_material_detail_temp';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('material_id, amount, price_unit, price_net, buy_id, user_id', 'required'),
			array('material_id, buy_id, user_id, percent_moisture', 'numerical', 'integerOnly'=>true),
			array('price_unit', 'length', 'max'=>10),
			array('price_net,weight_in, weight_out, weight_loss', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, material_id, amount, price_unit, price_net, buy_id, user_id,flag,weight_in, weight_out, weight_loss, percent_moisture', 'safe', 'on'=>'search'),
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
			'amount' => 'น้ำหนักสุทธิ',
			'price_unit' => 'ราคา/หน่วย',
			'price_net' => 'ราคารวม',
			'buy_id' => 'Buy',
			'user_id' => 'User',
			'flag' => 'flag',
			'weight_in' => 'น้ำหนักเข้า',
			'weight_out' => 'น้ำหนักออก',
			'weight_loss' => 'สิ่งเจือปน',
			'percent_moisture'=>'% ความชื้น',
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
		$criteria->compare('amount',$this->amount);
		$criteria->compare('price_unit',$this->price_unit,true);
		$criteria->compare('price_net',$this->price_net,true);
		$criteria->compare('buy_id',$this->buy_id);
		$criteria->compare('user_id',Yii::app()->user->ID);

		$criteria->compare('weight_in',$this->weight_in,true);
		$criteria->compare('weight_out',$this->weight_out,true);
		$criteria->compare('weight_loss',$this->weight_loss,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BuyMaterialDetailTemp the static model class
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
		$this->weight_loss = str_replace(",", "", $this->weight_loss);  

		$this->weight_loss = empty($this->weight_loss) ? NULL : $this->weight_loss ; 		
		 
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
