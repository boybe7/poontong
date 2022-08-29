<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<!-- <script type="text/javascript" src="dist/jquery.maskMoney.js"></script> -->

	<?php 
       /* Yii::app()->getClientScript()->reset(); 
        Yii::app()->bootstrap->register();   */

        echo '<link rel="shortcut icon" href="'.Yii::app()->baseUrl.'/favicon.ico">';

        echo '<script type="text/javascript" src="'.Yii::app()->theme->getBaseUrl().'/js/jquery.yiigridview.js"></script>';
        Yii::app()->bootstrap->init();
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile(Yii::app()->baseUrl.'/dist/js/jquery.maskMoney.js');
  ?>
</head>

<style>

.dropdown-menu {
   /*background-color: #f4f7f4;*/
   margin-top: 15px;
}
.navbar .nav > li > .dropdown-menu:after {
  /*border-bottom: 6px solid #f4f7f4;*/
}
.dropdown-menu > li > a {
  /*color: white;*/

}
.dropdown-menu > li > a:hover {
  background-color: white;
  
}

.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus,
.dropdown-submenu:hover > a,
.dropdown-submenu:focus > a {
  color: #000;
  text-decoration: none;
  background: #fcfcfc; /* Old browsers */
  background: -moz-linear-gradient(top, #fcfcfc 1%, #dbdbdb 32%, #dbdbdb 64%, #ffffff 100%); /* FF3.6-15 */
  background: -webkit-linear-gradient(top, #fcfcfc 1%,#dbdbdb 32%,#dbdbdb 64%,#ffffff 100%); /* Chrome10-25,Safari5.1-6 */
  background: linear-gradient(to bottom, #fcfcfc 1%,#dbdbdb 32%,#dbdbdb 64%,#ffffff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfcfc', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}

.dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover,
.dropdown-menu > .active > a:focus {
  color: #000;
  text-decoration: none;
  background: #fcfcfc; /* Old browsers */
background: -moz-linear-gradient(top, #fcfcfc 1%, #dbdbdb 32%, #dbdbdb 64%, #ffffff 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, #fcfcfc 1%,#dbdbdb 32%,#dbdbdb 64%,#ffffff 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, #fcfcfc 1%,#dbdbdb 32%,#dbdbdb 64%,#ffffff 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfcfc', endColorstr='#ffffff',GradientType=0 ); /* IE6-9 */
}

.navbar .brand {
display: block;
float: left;
padding: 10px 10px 10px;
/*margin-left: -20px;*/
font-size: 20px;
font-weight: 200;
color: #fff;
text-shadow: 0 0 0 #ffffff;
}        

        
.navbar .nav > li > a{
float: none;
padding: 30px 15px 10px;
color: #6a6969;
font-size: 18px;
text-decoration: none;
text-shadow: 0 0 0 #222222;
height: 35px;
}       

.navbar .nav > li > a >  i{
float: none;
/*margin-top: 5px;*/
}


.navbar .nav  > li > a:hover, .nav > li > a:focus {
    float: none;
    /*padding: 20px 15px 10px;*/
    color: #fff;
    text-decoration: none;
    font-weight: 600;
    text-shadow: 0 0 0 #222222;
    background-color: #789e78;
}

.navbar .nav li.dropdown.open > .dropdown-toggle, .navbar .nav li.dropdown.active > .dropdown-toggle, .navbar .nav li.dropdown.open.active > .dropdown-toggle {
    color: #fff;
    background-color: #789e78;
    /* border-color: #428bca; */
}

.navbar .nav  > .active > a, .navbar .nav > .active > a:hover, .navbar .nav > .active > a:focus {
    color: #fff;
    background-color: #789e78;
    -webkit-box-shadow: inset 0 3px 8px rgb(0 0 0 / 0%);
    -moz-box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0);
    box-shadow: inset 0 3px 8px rgb(0 0 0 / 0%);

}    

/*.nav-tabs a {
  background: #fffbfb ;
  border: 1px solid #000000;
  border-bottom-color: transparent;
}*/

.nav-tabs a {
    background: #b5b3c1;
    border: 1px solid #000000;
    border-bottom-color: transparent;
}

.nav-tabs > .active > a, .nav-tabs > .active > a:hover, .nav-tabs > .active > a:focus {
    color: #0088cc;
    cursor: default;
    background-color: #f5f5f5;
    border: 1px solid #ddd;
    border-bottom-color: transparent;
    
}

 .navbar-inner {
	  background-color:#789e78;
    color:#ffffff;

  	border-radius:4px;
}

.navbar-header {
    background-color: #602166;
  }

.custom-nav {
    -webkit-box-shadow: 0px 1px 10px #4c4d4c;
    -moz-box-shadow:    0px 1px 10px #4c4d4c;
    box-shadow:         0px 1px 10px #4c4d4c;
    z-index:999;
}
  
.navbar-inner .navbar-nav > li > a {
  	color:#fff;
  	padding-left:20px;
  	padding-right:20px;
}



.navbar-inner .navbar-nav > .active > a, .navbar-nav > .active > a:hover, .navbar-nav > .active > a:focus {
    color: #ffffff;
     background-color: #f4f7f4;
	background-color:transparent;
}
      
.navbar-inner .navbar-nav > li > a:hover, .nav > li > a:focus {
    text-decoration: none;
    background-color: #f4f7f4;
}
      
.navbar-inner .navbar-brand {
  	color:#eeeeee;
}
.navbar-inner .navbar-toggle {
  	background-color:#eeeeee;
}
.navbar-inner .icon-bar {
  	background-color:#f4f7f4;
}

.nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
	background-color: #f4f7f4;
	border-color: #428bca;
}

.navbar-inner {
    /*min-height: 0px;*/
}



nav .badge {
  background: #67c1ef;
  border-color: #30aae9;
  background-image: -webkit-linear-gradient(top, #acddf6, #67c1ef);
  background-image: -moz-linear-gradient(top, #acddf6, #67c1ef);
  background-image: -o-linear-gradient(top, #acddf6, #67c1ef);
  background-image: linear-gradient(to bottom, #acddf6, #67c1ef);
}

nav .badge.green {
  background: #77cc51;
  border-color: #59ad33;
  background-image: -webkit-linear-gradient(top, #a5dd8c, #77cc51);
  background-image: -moz-linear-gradient(top, #a5dd8c, #77cc51);
  background-image: -o-linear-gradient(top, #a5dd8c, #77cc51);
  background-image: linear-gradient(to bottom, #a5dd8c, #77cc51);
}

nav .badge.yellow {
  background: #faba3e;
  border-color: #f4a306;
  background-image: -webkit-linear-gradient(top, #fcd589, #faba3e);
  background-image: -moz-linear-gradient(top, #fcd589, #faba3e);
  background-image: -o-linear-gradient(top, #fcd589, #faba3e);
  background-image: linear-gradient(to bottom, #fcd589, #faba3e);
}

nav .badge.red {
  background: #fa623f;
  border-color: #fa5a35;
  background-image: -webkit-linear-gradient(top, #fc9f8a, #fa623f);
  background-image: -moz-linear-gradient(top, #fc9f8a, #fa623f);
  background-image: -o-linear-gradient(top, #fc9f8a, #fa623f);
  background-image: linear-gradient(to bottom, #fc9f8a, #fa623f);
}


@font-face {
    font-family: 'Boon400';
    src: url('<?=Yii::app()->baseUrl;?>/fonts/boon-400.eot') format('embedded-opentype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-400.woff') format('woff'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-400.ttf') format('truetype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-400.svg#Boon400') format('svg');
}

@font-face {
    font-family: 'Boon700';
    src: url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.eot');
    src: url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.eot') format('embedded-opentype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.woff') format('woff'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.ttf') format('truetype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.svg#Boon700') format('svg');
}

@font-face {
    font-family: 'THSarabunPSK';
    src: url('<?=Yii::app()->baseUrl;?>/fonts/thsarabunnew-webfont.eot');
    src: url('<?=Yii::app()->baseUrl;?>/fonts/thsarabunnew-webfont.eot') format('embedded-opentype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/thsarabunnew-webfont.woff') format('woff'),
         url('<?=Yii::app()->baseUrl;?>/fonts/thsarabunnew-webfont.ttf') format('truetype');
       
}

body{
    
    
     width:100%;
     min-height:340px;
     position: relative;
     /*background: url(../images/bg.jpg) no-repeat center center;*/
     background-color: #e4e4e4;
     background-size: cover;
     font: 14px/1.4em 'Boon400',sans-serif;
     font-weight: normal;
}

input, select, textarea {
font-family: 'Boon400', sans-serif;
}

h1,h2,h3,h4{
        font-family: 'Boon700',sans-serif;
        font-weight: normal;
}

table tr .tr_white {
  background-color: #ffffff;
}

select, input[type="file"] {
    height: 30px;
    line-height: 30px;
}

.well-yellow {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f8c10621;
    border: 1px solid #e3e3e3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
}

.well-blue {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #c5d7df;
    border: 1px solid #e3e3e3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
}
/*scrollable*/
 .ui-autocomplete {
            max-height: 200px;
            max-width: 800px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        } 

.app-name {
  color: #323034;
  text-decoration: none;
  text-shadow: 0 0 0 #222222;
  
  font: 20px/2.0em 'Boon700',sans-serif;
  font-weight: bold;
}  

.app-name-login {
  color: #323034;
  text-decoration: none;
  text-shadow: 0 0 0 #222222;
  
  font: 35px/3.5em 'Boon700',sans-serif;
  font-weight: bold;
}   

.well-tab {
  
    min-height: 20px;
    padding: 19px;
    margin-top: -20px;
    background-color: #f5f5f5;
    border-left: 1px solid #e3e3e3;
    border-right: 1px solid #e3e3e3;
    border-bottom: 1px solid #e3e3e3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    /* -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); */
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    /* box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05); */


}

.hero-unit{

  
   /*background-image: url('images/blue.jpg');*/
   background-repeat: no-repeat;
   background-size: 1250px 300px;
}

.custom-nav li {
 
  /* border-right: 1px solid #e8eaeb; */
}

.custom-nav li:first-child {
 
  /* border-left: 1px solid #e8eaeb; */
}

.btn-pea {
    color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    background-color: #6628ce;
     background-image: -moz-linear-gradient(top,  #6a2da0, #602166);
    /* background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#62c462), to(#51a351)); */
    background-image: -webkit-linear-gradient(top,  #6a2da0, #602166);
    background-image: -o-linear-gradient(top, #6a2da0, #602166);
    /* background-image: linear-gradient(to bottom, #62c462, #51a351); */
    background-repeat: repeat-x;
    border-color: #51a351 #51a351 #387038;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff62c462', endColorstr='#ff51a351', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
}

.btn-pea:hover,
.btn-pea:focus,
.btn-pea:active,
.btn-pea.active,
.btn-pea.disabled,
.btn-pea[disabled] {
  color: #ffffff;
  background-color: #602166;
  *background-color: #602166;
}
.btn-pea:active,
.btn-pea.active {
  background-color: #602166 \9;
}

.btn-group.open .btn-pea.dropdown-toggle {
  background-color: #602166;
}
table tr td {
    background:#ffffff;

}

@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap');
*{
  margin:0px;
  padding:0px;
  box-sizing: border-box;
}
:root{
  --color-text: #616161;
  --color-text-btn: #ffffff;
  --card1-gradient-color1: #f12711;
  --card1-gradient-color2: #f5af19;
  --card2-gradient-color1: #7F00FF;
  --card2-gradient-color2: #E100FF;
  --card3-gradient-color1: #3f2b96;
  --card3-gradient-color2: #a8c0ff;
  --card4-gradient-color1: #11998e;
  --card4-gradient-color2: #38ef7d;
}
/* body{
  font-family: 'Roboto', sans-serif;
  background: linear-gradient(to right, #8e9eab, #eef2f3); 
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  gap: 30px;
} */
.card-wrap{
  width: 220px;
  background: #fff;
  border-radius: 20px;
  border: 5px solid #fff;
  overflow: hidden;
  color: var(--color-text);
  box-shadow: rgba(0, 0, 0, 0.19) 0px 10px 20px,
              rgba(0, 0, 0, 0.23) 0px 6px 6px;
  cursor: pointer;
  transition: all .2s ease-in-out;
}
.card-wrap:hover{
  transform: scale(1.1);
}
.card-header{
  height: 200px;
  width: 100%;
  background: red;
  /* border-radius:100% 0% 100% 0% / 0% 50% 50% 100%; */
  display: grid;
  place-items: center;

}

.card-header:after {
    content: "";  // :before and :after both require content
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: linear-gradient(90deg, rgba(11,11,12,1) 0%, rgba(93,92,93,1) 100%);
    background-color: #333;
    /* border-radius:100% 0% 100% 0% / 0% 50% 50% 100%; */
    opacity: .4;
    // mix-blend-mode: color;
    // mix-blend-mode: hard-light;
    // mix-blend-mode: hue;
}

.card-header i{
  color: #fff;
  font-size: 72px;
}
.card-content{
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 60%;
  margin: 0 auto;
}
.card-title{
  text-align: center;
  text-transform: uppercase;
  font-size: 16px;
  margin-top: 10px;
  margin-bottom: 20px;
  
}
.card-text{
  text-align: center;
  font-size: 12px;
  margin-bottom: 20px;
}
.card-btn{
  border: none;
  border-radius: 100px;
  padding: 5px 30px;
  color: #fff;
  font-size: 20px;
  margin-bottom: 15px;
  text-transform: uppercase;
}
.card-header.one{
  /* background: linear-gradient(to bottom left, var(--card1-gradient-color1), var(--card1-gradient-color2)); */
  background-image: url('<?=Yii::app()->baseUrl;?>/images/line_process1.jpg');
  background-size: cover;

}
.card-header.two{
  /* background: linear-gradient(to bottom left, var(--card2-gradient-color1), var(--card2-gradient-color2)); */
  background-image: url('<?=Yii::app()->baseUrl;?>/images/line_process2.jpg');
  background-size: cover;
}
.card-header.three{
  /* background: linear-gradient(to bottom left, var(--card3-gradient-color1), var(--card3-gradient-color2)); */
  background-image: url('<?=Yii::app()->baseUrl;?>/images/line_process3.jpg');
  background-size: cover;
}
.card-header.four{
  background: linear-gradient(to bottom left, var(--card4-gradient-color1), var(--card4-gradient-color2));
}

.card-btn.one{
  background: linear-gradient(to left, var(--card1-gradient-color1), var(--card1-gradient-color2));
}
.card-btn.two{
  background: linear-gradient(to left, var(--card2-gradient-color1), var(--card2-gradient-color2));
}
.card-btn.three{
  background: linear-gradient(to left, var(--card3-gradient-color1), var(--card3-gradient-color2));
}
.card-btn.four{
  background: linear-gradient(to left, var(--card4-gradient-color1), var(--card4-gradient-color2));
}

.grid-view .filters input, .grid-view .filters select {
    margin-bottom: 0;
    height: auto;
    width: 100%;
}

.hidden {
    display: none
}

fieldset.scheduler-border {
  border: 1px solid #a5cfa5 !important;
  border-radius: 5px;
  padding: 0 1.4em 1.4em 1.4em !important;
  margin: 0 0 1.5em 0 !important;
  -webkit-box-shadow: 0px 0px 0px 0px #000;
  box-shadow: 0px 0px 0px 0px #000;
  /*margin-top: 30px !important;*/
}

legend.scheduler-border {
  font-size: 1.2em !important;
  font-weight: bold !important;
  text-align: left !important;
  width: auto;
  padding: 0 10px;
  border-bottom: none;
  margin-top: -15px;
  /*background-color: white;*/
  color: black;
}
.div-scheduler-border{
  margin-top: -15px;
}
input.number {
    text-align: right !important;
}

.input-append .add-on, .input-prepend .add-on {
  height: 30px;
  }

  .hidden_row{
    display: none;
  }
</style>     
     
<body class="body">

<?php 
 //echo Yii::app()->theme->getBaseUrl(); 
$class_profile = Yii::app()->user->id =="" ? "hidden" : "";

// if(Yii::app()->user->id =="")
//{
   

   $this->widget('bootstrap.widgets.TbNavbar',array(
    'fixed'=>'top',
    'collapse'=>true,    
    'htmlOptions'=>array('class'=>'noPrint custom-nav'),
    'brand' =>  CHtml::image(Yii::app()->getBaseUrl() . '/images/logo.png', 'Logo', array('width' => '60', 'height' => '25'))." <span class='app-name'>".Yii::app()->name."</span>",
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'encodeLabel'=>false,
            'items'=>array(
              
                array('label'=>'ซื้อ ','icon'=>'', 'url'=>array('/buymaterialinput/index'),'visible'=>Yii::app()->user->isAccess('/buymaterialinput/index')),
                array('label'=>'stock ','icon'=>'', 'url'=>array('#'),'visible'=>Yii::app()->user->isAccess('/stock/index'),'items'=>array(
                        array('label'=>'วัตถุดิบ', 'url'=>array('/stock/index/0'),'visible'=>Yii::app()->user->isAccess('/stock/index/0')),
                      )),
                array('label'=>'เบิก ','icon'=>'', 'url'=>array('/requisition/index'),'visible'=>Yii::app()->user->isAccess('/requisition/index')),
                array('label'=>'รายงาน ','icon'=>'', 'url'=>'#','visible'=>Yii::app()->user->isAccess('/report/index'),'items'=>array(
                     array('label'=>'ซื้อวัตถุดิบรายวัน', 'url'=>array('/report/buyraw'),'visible'=>Yii::app()->user->isAccess('/report/buyraw')),
                     array('label'=>'ซื้อวัตถุดิบเข้า', 'url'=>array('/report/buyrawSummary'),'visible'=>Yii::app()->user->isAccess('/report/buyrawSummary')),
                     
                    ),
                ),
                array('label'=>'ผู้ดูแลระบบ ','icon'=>'', 'url'=>'#','visible'=>Yii::app()->user->isAccess('/user/index'),'items'=>array(
                     array('label'=>'ข้อมูลวัตถุดิบ', 'url'=>array('/material/index'),'visible'=>Yii::app()->user->isAccess('/material/index')),
                     array('label'=>'ข้อมูลลูกค้า', 'url'=>array('/customer/index'),'visible'=>Yii::app()->user->isAccess('/customer/index')),
                     array('label'=>'ผู้ใช้งาน', 'url'=>array('/user/index'),'visible'=>Yii::app()->user->isAccess('/user/index')),
                     array('label'=>'ข้อมูลโรงงาน', 'url'=>array('/plantSite/index'),'visible'=>Yii::app()->user->isAccess('/plantSite/index')),
                     array('label'=>'กำหนดสิทธิผู้ใช้งาน', 'url'=>array('/authen/index'),'visible'=>Yii::app()->user->isAccess('/authen/index')),
                     
                    ),
                ),
            ),
        ),    
        array(
            'class'=>'bootstrap.widgets.TbButtonGroup',           
            'htmlOptions'=>array('class'=>'pull-right '.$class_profile,'style'=>'margin-top:25px'),
            'type'=>'', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'buttons'=>array(
                    array('label'=>Yii::app()->user->name,'icon'=>Yii::app()->user->usertype, 'url'=>'#'),
                    //array('label'=>Yii::app()->user->username,'icon'=>Yii::app()->user->usertype, 'url'=>'#'),
                    array('items'=>array(
                        array('label'=>'เปลี่ยนรหัสผ่าน','icon'=>'cog', 'url'=>array('/user/password/'.Yii::app()->user->ID), 'visible'=>!Yii::app()->user->isGuest),
                        '---',
                        array('label'=>'ออกจากระบบ','icon'=>'off', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    )),
                ),
            
        ),
        ),
    ));
// }
// else{
//     $this->widget('bootstrap.widgets.TbNavbar',array(
//     'fixed'=>'top',
//     'collapse'=>true,    
//     'htmlOptions'=>array('class'=>'noPrint custom-nav'),
//     'brand' =>  CHtml::image(Yii::app()->getBaseUrl() . '../images/logo.png', 'Logo', array('width' => '60', 'height' => '25'))."<span class='app-name-login'> ".Yii::app()->name." </span>",
//      'items'=>array(
//         array(
//             'class'=>'bootstrap.widgets.TbMenu',
//             'encodeLabel'=>false,
//             'items'=>array(
              
//                 array('label'=>'Home ','icon'=>'', 'url'=>'#'),
              
//             ),
//         ),
         
//     )      
//     ));
// }     
 
   ?>

    <div class="container" id="page" style="padding-top: 100px">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>


</div><!-- page -->

</body>
</html>
