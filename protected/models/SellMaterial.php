<?php

/**
 * This is the model class for table "sell_material".
 *
 * The followings are the available columns in table 'sell_material':
 * @property integer $id
 * @property string $sell_date
 * @property integer $customer_id
 * @property string $bill_no
 * @property string $last_update
 * @property integer $update_by
 * @property integer $site_id
 * @property string $note
 */
class SellMaterial extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'sell_material';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sell_date, customer_id, bill_no, last_update, update_by, site_id', 'required'),
			array('customer_id, update_by, site_id', 'numerical', 'integerOnly'=>true),
			array('bill_no', 'length', 'max'=>45),
			array('note', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, sell_date, customer_id, bill_no, last_update, update_by, site_id, note', 'safe', 'on'=>'search'),
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
			'sell_date' => 'วันที่ขาย',
			'customer_id' => 'ชื่อลูกค้า',
			'bill_no' => 'เลขที่ใบเสร็จ',
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
		$criteria->compare('sell_date',$this->sell_date,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('bill_no',$this->bill_no,true);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('update_by',$this->update_by);
		$criteria->compare('site_id',Yii::app()->user->getSite());	
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SellMaterial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getItem($id)
    {
    	$sql= 'SELECT * FROM sell_material_detail LEFT JOIN material ON material_id=material.id WHERE sell_id='.$id;
    	$model = Yii::app()->db->createCommand($sql)->queryAll();
    	$str = "";
    	foreach ($model as $key => $value) {
    		$str .= $value['name'].' จำนวน '.number_format($value['amount'],2).'กก ('.number_format($value['price_net'],2).' บาท)<br>'; 
    	}
    	return $str;
    }

    public function getTotal($id)
    {
    	$sql= 'SELECT sum(price_net) as total FROM sell_material_detail LEFT JOIN material ON material_id=material.id WHERE sell_id='.$id;
    	$model = Yii::app()->db->createCommand($sql)->queryAll();
    	
    	return $model[0]['total'];
    }

    public function beforeSave()
    {
      

        $str_date = explode("/", $this->sell_date);
        if(count($str_date)>1)
        	$this->sell_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];     
        
        return parent::beforeSave();
   }

	protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->sell_date);
            if(count($str_date)>1)
            	$this->sell_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
      
    }

	public function beforeFind()
    {
          

        $str_date = explode("/", $this->sell_date);
        if(count($str_date)>1)
        	$this->sell_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
       

        return parent::beforeSave();
   }

	protected function afterFind(){
            parent::afterFind();
    

            $str_date = explode("-", $this->sell_date);
            if($this->sell_date=='0000-00-00')
            	$this->sell_date = '';
            else if(count($str_date)>1)
            	$this->sell_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
          
           
     }
}
