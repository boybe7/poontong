<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - Login';

?>
<style type="text/css">
  body{
    
     background: #dfdfdf ;  
     width:100%;
     min-height:340px;
     position: relative;
     /* background: url(../images/bg.jpg) no-repeat center center; */
     background-size: cover;
     font: 16px/1.6em 'Boon400',sans-serif;
     font-weight: normal;
   }  

   #login-box{
      /*opacity: 0.6;
      filter: alpha(opacity=60);*/
      background-color: #fff;
      box-shadow: 0 19px 38px rgba(0,0,0,0.30), 0 15px 12px rgba(0,0,0,0.22);
   }

   #login-box div{
     font-weight: bold;
     color: #000000;
   }
</style>

<center>
<div class="container-fluid well" id="login-box" style="width:350px;margin-top:120px;">

 <div class="row-fluid">



          <!-- <div class="span4" ><img src="../dist/img/logo.png" ></div> -->
          
          <div class="span12" >
              <div class="row-fluid">
              <?php /** @var BootActiveForm $form */
                    // echo  CHtml::image(Yii::app()->getBaseUrl() . '../images/avatar.png', 'Logo', array('width' => '120', 'height' => '120','border-radius'=> '100%'));
                    echo "<div><h2>ลงชื่อเข้าใช้งาน</h2></div>";
                    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
                        'id'=>'verticalForm',
                        'htmlOptions'=>array('align'=>'left'),
                    )); ?>

                    <?php 
                    echo "<span style='display: block;margin-bottom: 5px;text-align:left'><i class='icon-user'></i>  ชื่อผู้ใช้งาน</span>";
                    echo $form->textFieldRow($model, 'username', array('class'=>'span12','labelOptions' => array('label' => false))); ?>
                    <?php 
                    echo "<span style='display: block;margin-bottom: 5px;text-align:left'><i class='icon-lock'></i>  รหัสผ่าน</span>";
                    echo $form->passwordFieldRow($model, 'password', array('class'=>'span12','labelOptions' => array('label' => false))); ?>

                    <?php $this->widget('bootstrap.widgets.TbButton', array('htmlOptions'=>array('class'=>'pull-right'),'buttonType'=>'submit','type'=>'primary', 'label'=>'เข้าสู่ระบบ')); ?>

                    <?php $this->endWidget(); ?>
              </div>    
          </div>
        </div>

</div>


        <?php /** @var BootActiveForm $form */
                    // echo  CHtml::link(CHtml::image(Yii::app()->getBaseUrl() . '/images/user-manual.png', 'Logo', array('width' => '40', 'height' => '40','border-radius'=> '100%')),'../user_manual.pdf',array('title' => 'คู่มือการใช้งาน','target'=>'_blank') );

                    // echo "&nbsp;&nbsp;&nbsp;";

                    //   echo  CHtml::link(CHtml::image(Yii::app()->getBaseUrl() . '/images/template.png', 'Logo', array('width' => '40', 'height' => '40','border-radius'=> '100%')),'../template_boq_form1.xls',array('title' => 'ตัวอย่างแบบฟอร์ม boq (ค่าอุปกรณ์ ค่าขนส่ง และค่าติดตั้ง)','target'=>'_blank') );

                    //   echo "&nbsp;&nbsp;&nbsp;";

                    //   echo  CHtml::link(CHtml::image(Yii::app()->getBaseUrl() . '/images/template2.png', 'Logo', array('width' => '40', 'height' => '40','border-radius'=> '100%')),'../template_boq_form2.xls',array('title' => 'ตัวอย่างแบบฟอร์ม boq (ค่าของ และค่าแรง)','target'=>'_blank') );

        ?>
</center>