<?php

/**
 * This is the model class for table "production".
 *
 * The followings are the available columns in table 'production':
 * @property integer $id
 * @property integer $process_id
 * @property integer $material_id
 * @property integer $in_out
 * @property string $amount
 * @property integer $site_id
 * @property string $production_date
 * @property integer $user_id
 * @property string $last_update
 * @property integer $flag_delete
 */
class Production extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'production';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('process_id, material_id, in_out, amount, site_id, production_date, user_id, last_update, flag_delete', 'required'),
			array('process_id, material_id, in_out, site_id, user_id, flag_delete', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, process_id, material_id, in_out, amount, site_id, production_date, user_id, last_update, flag_delete', 'safe', 'on'=>'search'),
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
			'process_id' => 'กระบวนการผลิต',
			'material_id' => 'วัตถุดิบ',
			'in_out' => 'ประเภท',
			'amount' => 'จำนวน กก.',
			'site_id' => 'Site',
			'production_date' => 'วันที่ผลิต',
			'user_id' => 'User',
			'last_update' => 'วันที่อัพเดต',
			'flag_delete' => 'Flag Delete',
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

		$date_search = $this->production_date;
		$str_date = explode("/", $this->production_date);
        if(count($str_date)>1)
        	$date_search= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];


		$criteria->compare('id',$this->id);
		$criteria->compare('process_id',$this->process_id);
		$criteria->compare('material_id',$this->material_id);
		$criteria->compare('in_out',$this->in_out);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('site_id',Yii::app()->user->getSite());
		$criteria->compare('production_date',$date_search,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('flag_delete',$this->flag_delete);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
    {
        
        $str_date = explode("/", $this->production_date);
        if(count($str_date)>1)
        	$this->production_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

     
        
        return parent::beforeSave();
   }
     protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->production_date);
            if(count($str_date)>1)
            	$this->production_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);

         
               
    }
    protected function afterFind(){
            parent::afterFind();
            $str_date = explode("-", $this->production_date);
            if($this->production_date == "0000-00-00")
                $this->production_date = '';
            else if(count($str_date)>1)
            	$this->production_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);


                            
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Production the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
