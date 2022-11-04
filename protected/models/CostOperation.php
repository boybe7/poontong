<?php

/**
 * This is the model class for table "cost_operation".
 *
 * The followings are the available columns in table 'cost_operation':
 * @property integer $id
 * @property integer $group_id
 * @property string $create_date
 * @property integer $site_id
 * @property string $cost
 */
class CostOperation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cost_operation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, create_date, site_id, cost', 'required'),
			array('group_id, site_id', 'numerical', 'integerOnly'=>true),
			array('cost', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, group_id, create_date, site_id, cost', 'safe', 'on'=>'search'),
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
			'group_id' => 'ประเภทค่าใช้จ่าย',
			'create_date' => 'วันที่',
			'site_id' => 'Site',
			'cost' => 'จำนวนเงิน (บาท)',
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
		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('site_id',Yii::app()->user->getSite());
		$criteria->compare('cost',$this->cost,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CostOperation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
    {
      
    	$this->cost = str_replace(",", "", $this->cost); 
        $str_date = explode("/", $this->create_date);
        if(count($str_date)>1)
        	$this->create_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];     
        
        return parent::beforeSave();
   }

	protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->create_date);
            if(count($str_date)>1)
            	$this->create_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
      
    }

	public function beforeFind()
    {
          

        $str_date = explode("/", $this->create_date);
        if(count($str_date)>1)
        	$this->create_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];
       

        return parent::beforeSave();
   }

	protected function afterFind(){
            parent::afterFind();
    

            $str_date = explode("-", $this->create_date);
            if($this->create_date=='0000-00-00')
            	$this->create_date = '';
            else if(count($str_date)>1)
            	$this->create_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);
          
           
     }
}
