<?php

/**
 * This is the model class for table "material".
 *
 * The followings are the available columns in table 'material':
 * @property integer $id
 * @property string $name
 * @property string $unit
 * @property integer $is_compressed
 * @property integer $have_label
 */
class Material extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'material';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('is_compressed, have_label,material_group_id,site_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, is_compressed, have_label, material_group_id,price1,price2,price3,price4,price5,price6,site_id', 'safe', 'on'=>'search'),
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

		$groups = CustomerGroup::model()->findAll("site_id=".Yii::app()->user->getSite());
		$price1 = !empty($groups[0]) ? 'ราคา '.$groups[0]->name : 'ราคา 1';
		$price2 = !empty($groups[1]) ? 'ราคา '.$groups[1]->name : 'ราคา 2';
		$price3 = !empty($groups[2]) ? 'ราคา '.$groups[2]->name : 'ราคา 3';
		$price4 = !empty($groups[3]) ? 'ราคา '.$groups[3]->name : 'ราคา 4';
		$price5 = !empty($groups[4]) ? 'ราคา '.$groups[4]->name : 'ราคา 5';
		$price6 = !empty($groups[5]) ? 'ราคา '.$groups[5]->name : 'ราคา 6';
		

		return array(
			'id' => 'ID',
			'name' => 'วัตถุดิบ',
			'is_compressed' => 'Is Compressed',
			'have_label' => 'Have Label',
			'material_group_id' => 'ประเภท',
			'price1' => $price1,
			'price2' => $price2,
			'price3' => $price3,
			'price4' => $price4,
			'price5' => $price5,
			'price6' => $price6,
			'site_id' => 'โรงงาน',
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

		if(!Yii::app()->user->isAdmin())
			$this->site_id = Yii::app()->user->getSite();

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('is_compressed',$this->is_compressed);
		$criteria->compare('have_label',$this->have_label);
		$criteria->compare('material_group_id',$this->material_group_id);
		$criteria->compare('price1',$this->price1);
		$criteria->compare('price2',$this->price2);
		$criteria->compare('price3',$this->price3);
		$criteria->compare('site_id',Yii::app()->user->getSite());	
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Material the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getPrice($data)
    {
    	$material_id = $data->id;
		$site_id = 1;
    	$model = MaterialPrice::model()->findAll(array("condition"=>"material_id='$material_id' AND site_id='$site_id' ORDER BY date_end DESC"));
    	$str = "";
    	if(!empty($model))
    	{
    		$str = "รายใหญ่ : ".number_format($model[0]->price1,2)." บาท <br>"."รายย่อย : ".number_format($model[0]->price2,2)." บาท <br>"."ลูกค้าประจำ : ".number_format($model[0]->price3,2)." บาท <br>";
    	}
    	return $str;
    }

	public function getPriceType($data,$type)
    {
    	$material_id = $data->id;
		$site_id = 1;
    	$model = MaterialPrice::model()->findAll(array("condition"=>"material_id='$material_id' AND site_id='$site_id' ORDER BY date_end DESC"));
    	$str = "";
    	if(!empty($model))
    	{
    		switch ($type) {
    			case 1:
    				$str = number_format($model[0]->price1,2);
    				break;
    			case 2:
    				$str = number_format($model[0]->price2,2);
    				break;
    			case 3:
    				$str = number_format($model[0]->price3,2);
    				break;		
    			case 4:
    				$str = number_format($model[0]->price4,2);
    				break;
    			case 5:
    				$str = number_format($model[0]->price5,2);
    				break;
    			case 6:
    				$str = number_format($model[0]->price6,2);
    				break;		
    			default:
    				$str = 0;
    				break;
    		}

			

		}	
    	return $str;
    }

}
