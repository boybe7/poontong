<?php

/**
 * This is the model class for table "stock_daily".
 *
 * The followings are the available columns in table 'stock_daily':
 * @property integer $id
 * @property string $amount
 * @property integer $site_id
 * @property integer $user_id
 * @property string $last_update
 * @property integer $material_id
 * @property integer $type
 * @property integer $sack
 * @property integer $bigbag
 * @property string $stock_date
 */
class StockDaily extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'stock_daily';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('amount, site_id, user_id, last_update, material_id, type, stock_date', 'required'),
			array('site_id, user_id, material_id, type, sack, bigbag', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, amount, site_id, user_id, last_update, material_id, type, sack, bigbag, stock_date', 'safe', 'on'=>'search'),
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
			'amount' => 'Amount',
			'site_id' => 'Site',
			'user_id' => 'User',
			'last_update' => 'Last Update',
			'material_id' => 'Material',
			'type' => '0=material,1=chemical,2=blade',
			'sack' => 'Sack',
			'bigbag' => 'Bigbag',
			'stock_date' => 'Stock Date',
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
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('site_id',$this->site_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('sack',$this->sack);
		$criteria->compare('bigbag',$this->bigbag);
		$criteria->compare('stock_date',$this->stock_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
    {
        
        $str_date = explode("/", $this->stock_date);
        if(count($str_date)>1)
        	$this->stock_date= ($str_date[2])."-".$str_date[1]."-".$str_date[0];

             
        return parent::beforeSave();
   }
     protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->stock_date);
            if(count($str_date)>1)
            	$this->stock_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
               
    }
    protected function afterFind(){
            parent::afterFind();
            $str_date = explode("-", $this->stock_date);
            if($this->stock_date == "0000-00-00")
                $this->stock_date = '';
            else if(count($str_date)>1)
            	$this->stock_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                            
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StockDaily the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
