<?php

/**
 * This is the model class for table "buy_spare_part".
 *
 * The followings are the available columns in table 'buy_spare_part':
 * @property integer $id
 * @property string $price
 * @property string $buy_date
 * @property string $volume
 * @property string $supplier
 * @property integer $user_id
 * @property integer $site_id
 * @property string $item_name
 * @property string $note
 */
class BuySparePart extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'buy_spare_part';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price, buy_date, volume, supplier, user_id, site_id, item_name', 'required'),
			array('user_id, site_id', 'numerical', 'integerOnly'=>true),
			array('price, volume', 'length', 'max'=>10),
			array('supplier, item_name, note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, price, buy_date, volume, supplier, user_id, site_id, item_name, note', 'safe', 'on'=>'search'),
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
			'price' => 'ราคา',
			'buy_date' => 'วันที่ซื้อ',
			'volume' => 'จำนวน',
			'supplier' => 'ชื่อผู้ขาย',
			'user_id' => 'User',
			'site_id' => 'Site',
			'item_name' => 'อะไหล่',
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
		$criteria->compare('price',$this->price,true);
		$criteria->compare('buy_date',$this->buy_date,true);
		$criteria->compare('volume',$this->volume,true);
		$criteria->compare('supplier',$this->supplier,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('item_name',$this->item_name,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BuySparePart the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
    {
      

        $str_date = explode("/", $this->buy_date);
        if(count($str_date)>1)
        	$this->buy_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];     
        
        return parent::beforeSave();
   }

	protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->buy_date);
            if(count($str_date)>1)
            	$this->buy_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
      
    }

	public function beforeFind()
    {
          

        $str_date = explode("/", $this->buy_date);
        if(count($str_date)>1)
        	$this->buy_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
       

        return parent::beforeSave();
   }

	protected function afterFind(){
            parent::afterFind();
    

            $str_date = explode("-", $this->buy_date);
            if($this->buy_date=='0000-00-00')
            	$this->buy_date = '';
            else if(count($str_date)>1)
            	$this->buy_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
          
           
     }
}
