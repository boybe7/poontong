<?php
$this->breadcrumbs=array(
	'รายงานซื้อวัตถุดิบรายวัน',
	
);


?>

<style>

.reportTable thead th {
	text-align: center;
	font-weight: bold;
	background-color: #eeeeee;
	vertical-align: middle;
	}

.reportTable td {
	
}

</style>
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/pdfobject.js"></script> -->
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/pdf.js"></script> -->
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/compatibility.js"></script> -->
<script type="text/javascript">

$(document).ready(function(){
 
  
  $('#fiscalyear').change(function() {
         //console.log($(this).val());
      if($(this).val()!="")
      {


         var yy =  parseInt($(this).val());
         
         yy1 = yy-2;
         yy2 = yy-1;
         yy3 = yy+1;
         yy4 = yy+2;
         
        var newOptions =  {yy1:yy1,yy2:yy2,yy:yy,yy3:yy3,yy4:yy4};
        var selectedOption = yy;

        var select = $('#yearBegin');
        if(select.prop) {
          var options = select.prop('options');
        }
        else {
          var options = select.attr('options');
        }
        $('option', select).remove();

        $.each(newOptions, function(val, text) {
            options[options.length] = new Option(text, text);
        });
        //console.log(selectedOption);
        select.val(selectedOption);
        //$('#monthBegin').val(10);

        var select = $('#yearEnd');
        if(select.prop) {
          var options = select.prop('options');
        }
        else {
          var options = select.attr('options');
        }
        $('option', select).remove();

        $.each(newOptions, function(val, text) {
            options[options.length] = new Option(text, text);
        });
        
        var d = new Date();
        select.val(d.getFullYear()+543);
        $('#monthEnd').val(d.getMonth()+1);        
      }  
  });
    
});   
</script>


<h4>รายงานซื้อวัตถุดิบรายวัน</h4>

<div class="well">
  <div class="row-fluid">
	
	  <div class="span2">
               
              <?php
                echo CHtml::label('ระหว่างเดือน','monthBegin');  
                $list = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");
                echo CHtml::dropDownList('monthBegin', '', 
                        $list,array('class'=>'span12'
                    ));
               

              ?>
    </div>
    <div class="span2">
            <?php
                
                echo CHtml::label('ปี','yearBegin');  
                $yy = date("Y")+543;
                $list = array($yy-2=>$yy-2,$yy-1=>$yy-1,$yy=>$yy,$yy+1=>$yy+1,$yy+2=>$yy+2);
                echo CHtml::dropDownList('yearBegin', '', 
                        $list,array('class'=>'span12','options' => array($yy=>array('selected'=>true))
                    ));

              ?>
    </div>

    <div class="span3">
            <label for="material_id">วัตถุดิบ</label>
            <?php 
                        
                    if(!Yii::app()->user->isAdmin())
                    {
                        $typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => Yii::app()->user->getSite())),'id','name');
                        echo CHtml::dropDownList('material_id', "",$typelist,array('class'=>'span12','empty' => '----เลือก----')); 
                    } 
                    else
                    {
                        $typelist = CHtml::listData(Material::model()->findAll('site_id=:id', array(':id' => 1)),'id','name');
                        echo CHtml::dropDownList('material_id', "",$typelist,array('class'=>'span12','empty' => '----เลือก----'));   
                    }

             ?>
    </div>
    
  
	<div class="span4">
      <?php
        $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'link',
              
              'type'=>'inverse',
              'label'=>'view',
              'icon'=>'list-alt white',
              
              'htmlOptions'=>array(
                'class'=>'span4',
                'style'=>'margin:25px 10px 0px 0px;',
                'id'=>'gentReport'
              ),
          ));
      ?>
    <!-- </div> -->
    <!-- <div class="span1"> -->
      <?php
        $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'link',
              
              'type'=>'success',
              'label'=>'Excel',
              'icon'=>'excel',
              
              'htmlOptions'=>array(
                'class'=>'span4',
                'style'=>'margin:25px 10px 0px 0px;padding-left:0px;padding-right:0px',
                'id'=>'exportExcel'
              ),
          ));

    $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'link',
              
              'type'=>'info',
              'label'=>'Print',
              'icon'=>'print white',
              
              'htmlOptions'=>array(
                'class'=>'span3',
                'style'=>'margin:25px 0px 0px 0px;',
                'id'=>'printReport'
              ),
          ));
      ?>
    </div>
  </div>

    
</div>


<div id="printcontent" style=""></div>


<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('gentReport', '
$("#gentReport").click(function(e){
    e.preventDefault();

       
        $.ajax({
            url: "gentBuyRaw",
            cache:false,
            data: {month:$("#monthBegin").val(),year:$("#yearBegin").val(),material_id:$("#material_id").val()
              },
            success:function(response){
               
               $("#printcontent").html(response);                 
            }

        });
    
});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('printReport', '
$("#printReport").click(function(e){
    e.preventDefault();

    $.ajax({
        url: "printStatement",
        data: {monthBegin:$("#monthBegin").val(),monthEnd:$("#monthEnd").val(),yearBegin:$("#yearBegin").val(),yearEnd:$("#yearEnd").val()
              },
        success:function(response){
            window.open("../tempReport.pdf", "_blank", "fullscreen=yes", "clearcache=yes");              
            
        }

    });

});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('exportExcel', '
$("#exportExcel").click(function(e){
    e.preventDefault();
    window.location.href = "genStatementExcel?monthBegin="+$("#monthBegin").val()+"&monthEnd="+$("#monthEnd").val()+"&yearBegin="+$("#yearBegin").val()+"&yearEnd="+$("#yearEnd").val();
              


});
', CClientScript::POS_END);


?>