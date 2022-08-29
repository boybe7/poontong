<?php

/**
 * This is the model class for table "requisition".
 *
 * The followings are the available columns in table 'requisition':
 * @property integer $id
 * @property integer $material_id
 * @property string $amount
 * @property integer $sack
 * @property integer $bigbag
 * @property integer $process
 * @property integer $user_id
 * @property string $create_date
 */
class Requisition extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'requisition';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('process, username, create_date', 'required'),
			array('process', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, process, username, create_date', 'safe', 'on'=>'search'),
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
			
			'process' => 'ไลน์ผลิต',
			'username' => 'ชื่อผู้เบิก',
			'create_date' => 'วันที่เบิก',
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
		
		$criteria->compare('process',$this->process);
		$criteria->compare('username',$this->username);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Requisition the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function beforeSave()
    {
        
        $str_date = explode("/", $this->create_date);
        if(count($str_date)>1)
        	$this->create_date= ($str_date[2]-543)."-".$str_date[1]."-".$str_date[0];

     
        
        return parent::beforeSave();
   }
     protected function afterSave(){
            parent::afterSave();
            $str_date = explode("-", $this->create_date);
            if(count($str_date)>1)
            	$this->create_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);

         
               
    }
    protected function afterFind(){
            parent::afterFind();
            $str_date = explode("-", $this->create_date);
            if($this->create_date == "0000-00-00")
                $this->create_date = '';
            else if(count($str_date)>1)
            	$this->create_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]+543);


                            
    }

    public function getItem($id)
    {
    	$sql= 'SELECT * FROM requisition_detail LEFT JOIN material ON material_id=material.id WHERE requisition_id='.$id;
    	$model = Yii::app()->db->createCommand($sql)->queryAll();
    	$str = "";
    	foreach ($model as $key => $value) {
    		$str .= $value['name'].' จำนวน '.number_format($value['amount'],2).' กก. ( '.number_format($value['sack']).' กระสอบ / '.number_format($value['bigbag']).' bagbag )<br>'; 
    	}
    	return $str;
    }
}
