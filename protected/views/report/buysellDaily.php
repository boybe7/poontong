<?php
$this->breadcrumbs=array(
	'รายงานสรุปซื้อ-ขาย (รายวัน)',
	
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


<h4>รายงานสรุปซื้อ-ขาย (รายวัน)</h4>

<div class="well">
  <div class="row-fluid">
	
	  <div class="span2">
            <?php

                        echo CHtml::label('วันที่เริ่มต้น','date_start');
                        echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
                            $this->widget('zii.widgets.jui.CJuiDatePicker',

                            array(
                                'name'=>'date_start',
                                'attribute'=>'date_start',

                                'options' => array(
                                                  'mode'=>'focus',
                                                  //'language' => 'th',
                                                  'format'=>'dd/mm/yyyy', //กำหนด date Format
                                                  'showAnim' => 'slideDown',
                                                  ),
                                'htmlOptions'=>array('class'=>'span12'),  // ใส่ค่าเดิม ในเหตุการ Update
                             )
                        );
                        echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

                ?>
      </div>

      <div class="span2 ">
            <?php

                        echo CHtml::label('วันที่สิ้นสุด','date_end');
                        echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
                            $this->widget('zii.widgets.jui.CJuiDatePicker',

                            array(
                                'name'=>'date_end',
                                'attribute'=>'date_end',

                                'options' => array(
                                                  'mode'=>'focus',
                                                  //'language' => 'th',
                                                  'format'=>'dd/mm/yyyy', //กำหนด date Format
                                                  'showAnim' => 'slideDown',
                                                  ),
                                'htmlOptions'=>array('class'=>'span12'),  // ใส่ค่าเดิม ในเหตุการ Update
                             )
                        );
                        echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

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
//data: {monthBegin:$("#monthBegin").val(),yearBegin:$("#yearBegin").val(),monthEnd:$("#monthEnd").val(),yearEnd:$("#yearEnd").val()
//              },
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('gentReport', '
$("#gentReport").click(function(e){
    e.preventDefault();

       
        $.ajax({
            url: "gentBuySellDaily",
            cache:false,
            data: {date_start:$("#date_start").val(), date_end:$("#date_end").val()
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
    filename = "buyselldaily_"+$.now()+".pdf";

    $.ajax({
        url: "printBuySellDaily",
         data: {date_start:$("#date_start").val(), date_end:$("#date_end").val(),filename : filename},
        success:function(response){
             window.open("../report/temp/"+filename, "_blank", "fullscreen=yes", "clearcache=yes");                  
            
        }

    });

});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('exportExcel', '
$("#exportExcel").click(function(e){
    e.preventDefault();
    window.location.href = "buySellDailyExcel?date_start="+$("#date_start").val()+"&date_end="+$("#date_end").val();
 

});
', CClientScript::POS_END);


?>