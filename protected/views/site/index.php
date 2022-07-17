
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
            <h1>Hello, world!</h1>
            <p>This is a template for a simple marketing or informational website. It includes a large callout called the hero unit and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
            <p><a href="#" class="btn btn-primary btn-large">Learn more &raquo;</a></p>
</div>
<div class="row-fluid">
            <div class="card-wrap span4">
                  <div class="card-header one">
                    
                  </div>
                  <div class="card-content">
                   
                    <p class="card-text"></p>
                    <button class="card-btn one">Line ปอก</button>
                </div>
            </div><!--/span-->
            <div class="card-wrap span4">
                  <div class="card-header two">
                  
                  </div>
                  <div class="card-content">
                    <!-- <h1 class="card-title">&nbsp;</h1> -->
                    <p class="card-text"></p>
                    <button class="card-btn two">Line แกะ</button>
                </div>
            </div><!--/span-->
            <div class="card-wrap span4">
                  <div class="card-header three">
                   
                  </div>
                  <div class="card-content">
                    <!-- <h1 class="card-title">&nbsp;</h1> -->
                    <p class="card-text"></p>
                    <button class="card-btn three">Line บด</button>
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


