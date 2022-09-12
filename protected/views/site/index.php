
<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$theme = Yii::app()->theme;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile( $theme->getBaseUrl() . '/js/highcharts.js' );
//$cs->registerCssFile($theme->getBaseUrl() . '/css/ProgressTracker.css');

?>

<?php 



?>


<div class="hero-unit">
            <h2 style="color: #339966;">ขวดพลาสติกรีไซเคิล 100% ช่วยโลกเราได้</h2>
            <p>    รู้หรือไม่ว่า ขวดน้ำดื่ม ขวดน้ำอัดลมที่อยู่ในชีวิตประจำวันนั้น ล้วนทำจากพลาสติกแบบใส ที่เรียกว่า <span style="color: #339966;">“PET”</span> ซึ่งพลาสติกชนิดนี้สามารถนำกลับมาสู่กระบวนการ <span style="color: #339966;">“รีไซเคิล”</span> ได้แบบ 100% กลายเป็นผลิตภัณฑ์ชนิดใหม่ได้ไม่รู้จบ หากคุณอยากช่วยโลกลดปริมาณขยะและการใช้พลาสติกผลิตใหม่</p>
</div>
<center><h2 style="color: #339966;">กระบวนการรีไซเคิลขวดพลาสติก</h2></center>
<div class="row-fluid">
            <div class="card-wrap span4">
                  <div class="card-header one">
                    
                  </div>
                  <div class="card-content">
                   
                    <p class="card-text"></p>
                    <button class="card-btn one">คัดแยก</button>
                </div>
            </div><!--/span-->
            <div class="card-wrap span4">
                  <div class="card-header two">
                  
                  </div>
                  <div class="card-content">
                    <!-- <h1 class="card-title">&nbsp;</h1> -->
                    <p class="card-text"></p>
                    <button class="card-btn two">แกะฉลาก</button>
                </div>
            </div><!--/span-->
            <div class="card-wrap span4">
                  <div class="card-header three">
                   
                  </div>
                  <div class="card-content">
                    <!-- <h1 class="card-title">&nbsp;</h1> -->
                    <p class="card-text"></p>
                    <button class="card-btn three">บด</button>
                </div>
            </div><!--/span-->
</div><!--/row-->

<div id="modal-content" class="hide">
    <div id="modal-body">
<!-- put whatever you want to show up on bootbox here -->
    	<?php 
    	
   
              
    	?>
    </div>
</div>


