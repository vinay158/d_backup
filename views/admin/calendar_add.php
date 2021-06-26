<?php
/* changelog v2 - major moficifation in this document regarding multi date, closed days - 14 June 2013 */
?>

<?php $this->load->view("admin/include/header"); ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>	

<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />



<!--
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
 -->

<!--
<script src="http://websitedojo.com/demo/dynamic_ele.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />
-->
<script>
var ccc = 2;
$(function() {
	
	$( "#date1" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd', altField:'#date_hidden1'});

});


<!-- DOJO -->
$(window).load(function(){
	if($('#category_id').val() == 52){
		$('.closed_days').hide();
	}	
});
</script>

<script><!--
	
	function date_validate(){
return true;
		var _date=$('#date_hidden1').val();
		
		if($('#allday1').attr('checked') && _date!='') {
			return true;
		}			
		
		if(_date=='' || _date==undefined){
			alert('Oops! Please Select date first');
			$('#date1').focus();
			return false;
		}
		/*
		var start_date = _date +' '+$("#start_hr").val()+':'+$("#start_min").val()+' '+$("#start_ampm").val();
		var end_date = _date +' '+$("#end_hr").val()+':'+$("#end_min").val()+' '+$("#end_ampm").val();
		
		//convert into starndard date
		var s = new Date(start_date);
		var e = new Date(end_date);		
		
		if( s.getTime() < e.getTime() )
		{
		    return true;
		}
		else
		{
		    alert('Oops! End time must be greater then Star time.');
		    return false;
		}
		*/		

	}
	



	$(document).ready(function(){
		
		$("#allday1").change(function(){
			
			if($('#allday1').attr('checked')) {
				
				$('.date_check1').each(function(){	$(this).attr("disabled", "disabled");
				$('#time_grp1').hide("slow");
				 });
			}
			else
			{
				$('.date_check1').each(function(){ $(this).removeAttr("disabled"); 
				$('#time_grp1').show("slow");
				});				
			}
			
		});
		
		$('#next_date_container').on('change', '.allday1', function(){
			if($(this).attr('checked')) {
				
				$(this).parent().find('.date_check1').each(function(){	$(this).attr("disabled", "disabled"); });
				$(this).parent().find('.time_grp1').hide("slow");
			}
			else
			{
				$(this).parent().find('.date_check1').each(function(){	$(this).removeAttr("disabled"); }); 
				$(this).parent().find('.time_grp1').show("slow");
			}
		})
		
		
		<!-- DOJO -->
		$("#category_id").change(function(){	
			
			var category_id = $(this).val();
			
			
			var redirect = 'view/'+category_id;
			//alert(redirect); 
			$('.redirect').val(redirect);
			if(category_id == 52){
				$('.closed_days').hide();
				$('.allday').val(1);
				//$('.show_even_on_closed_day_div').hide();
			}else{
				$('.closed_days').show();
				//$('.show_even_on_closed_day_div').show();
			}	
		})
		
		$('#addButton').on('click', function(){
			/*
			var html = $('#schedule1').html();
			
			var opening_str = '<div class="form-light-holder">';
			var closing_str = '</div>';
			
			$('#next_date_container').append(opening_str+html+closing_str);
			*/
			
			$('#schedule'+ccc).fadeIn();
			ccc++;
		})
	})

</script>
  

<div class="az-content-body-left advanced_page custom_full_page calendar_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add: Calendar Event</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
		
<div class="mb-3 main-content-label page_main_heading">Add: Calendar Event</div>

<?php //http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI] ?>
<form id="blog_form" action="" method="post" >
<style>
.ErrorMessage{color:#FF0000}
</style>
<script language="javascript">


$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
	
	$('body').on('click','.alldayCheckBox',function(){
		var number = $(this).attr('number');
		
		if($(this).is(':checked')){
			$('.alldayHideBox_'+number).hide();
		}else{
			$('.alldayHideBox_'+number).show();
		}
	});
	
	
	$('body').on('change','.event_repeat_type',function(){
		var number = $(this).attr('number');
		$('.calendar_end_date_'+number).hide();
		if($(this).val() == "Every week"){
			$('.calendar_end_date_'+number).show();
		}
	});
	
	
	
	<!-- DOJO -->
	$('.btn-save').click(function(){
	
	 var error = true;
			if($('#main_title').val() == ''){
				$('.ErrorMessage_title').html(' *Event title is Required');
				error = false;
			}
			
	$.each( $( ".multiple_dates" ), function() {
		 var number = $(this).attr('number');
		
		 if($(this).val() == ''){
			$(this).css({"border-color": "red", 
				 "border-width":"2px", 
				 "border-style":"solid"});
			$('.ErrorMessage_date').html(' *Date is Required');
			error = false;
		 }
		 
		 
	});
	return error;
		
		});
	
	
	$(document).on('change', '.start_hr', function() {
		var number = $(this).attr('number');
		if($(this).val() != 12){
			var end_time = parseInt($(this).val()) + parseInt(1);
			if(end_time < 10){
				end_time = '0' + end_time;
			}
		}else{
			end_time = '01';
		}
		$('.end_hr'+number+' option[value='+end_time+']').attr('selected','selected');
		
	});
	
	$(document).on('change', '.start_min', function() {
		var number = $(this).attr('number');
		$('.end_min'+number+' option[value='+$(this).val()+']').attr('selected','selected');
		
	});
	
	$(document).on('change', '.start_ampm', function() {
		var number = $(this).attr('number');
		$('.end_ampm'+number+' option[value='+$(this).val()+']').attr('selected','selected');
		
	});
	
	
	
})
</script>

<?php
$hrs = array("01","02","03","04","05","06","07","08","09","10","11","12");
$mins = array("00", "05", "10", "15", "20", "25", "30", "35", "40", "45","50", "55");
$category_id = $this->uri->segment('4');

?>
<?php 
$location_display = '';
if(isset($location) && count($location) > 1 && $multi_calendar == 1){
	$location_display = '';
}else{
	$location_display = 'display:none;';
}

?>
<div class="form-light-holder" style="overflow:auto;<?php echo $location_display;?>">
	<h1 style="padding-bottom: 5px;">Choose a Location</h1>
		<div>
		<select id="location_id" name="location_id"  class="field">
			
			<?php foreach($location as $location_item): ?>
					<option value="<?=$location_item->id;?>" 
					<?php if($this->uri->segment('4') != NULL){ 
					if($this->uri->segment('4') == $location_item->id) echo "selected='selected'"; }?>><?=$location_item->name;?></option>
				<?php endforeach;?>
		</select>
		</div>
</div>

<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Category</h1>
		<div>
		<select id="category_id" name="blog_category_id"  class="field">
			<option value="null" disabled="disabled">Your Categories</option>
			<?php if(isset($cat)): ?>
				<?php foreach($cat as $cat_item): ?>
					<option value="<?=$cat_item->cat_id;?>" 
					<?php if($this->uri->segment('4') != NULL){ 
					if($this->uri->segment('4') == $cat_item->cat_id) echo "selected='selected'"; }?>><?=$cat_item->cat_name;?></option>
				<?php endforeach;?>
			<?php endif;?>
		</select>
		</div>
</div>
<div class="form-light-holder">
	<h1>Event Title</h1>
	<input type="text" value="" name="title" id="main_title" class="field full_width_input" placeholder="Enter your event title here"/>
	<div class="ErrorMessage ErrorMessage_title"></div>
</div>


<div class="form-light-holder show_even_on_closed_day_div closed_days">
	<span class=""> 
	<label class="ckbox">
		<input name="show_even_on_closed_days"  class="allday1_schedule1 checkbox_show_even_on_closed_days" value="1" type="checkbox"> 
		<span>Show Even on Closed Days</span>
            </label>
		
		</span>
</div>
<!-- MIRROR IN HERE -->
<div class="form-group" id="deploy_mirror" style="display:none;" >
	<div class="form-group deployment_info_node">
			
		<div class="form-light-holder event_set_time" id="schedule2 " >
			<div style="float:left;">
				<h1>Date</h1>
				<input type="text" value="" name="date1[]" class="field " placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
				<input type="hidden" value="" name="" id="date_hidden2" class="myhiddenvalue" maxlength="10"/>
			</div>
	<input type="text" value="" name="end_date1[]"  class="field "  placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
		<div class="closed_days">	
			<div style="float:left; margin-left: 20px;">
				<h1>Repeat</h1>
				<select name="repeat1[]" id="repeat1"   style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
				<option value="never">Never</option>
				<option value="Every week">Every week</option>
				<option value="Every year">Every year</option>
				</select>
			</div>
	
			<div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1 alldayHideBox_1">
	
				<div style="float: left; width: 275px;" time_grp1> 
					<h1>Start</h1>
			
					<select type="text" class="date_check1 start_hr2" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
						<option disabled="disabled">Select Hour</option>
						<?php                 
						 foreach($hrs as $time){
							echo "<option value='".$time."'>".$time."</option>";
						}
						?>
					</select>
			
					<select type="text" class="date_check1" name="start_min1[]" id="start_min1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
						<option disabled="disabled">Select Min</option>
						<?php                		 
						 foreach($mins as $time){
							echo "<option value='".$time."'>".$time."</option>";
						}
						?>
					</select>
			
					<select type="text" class="date_check1" name="start_ampm1[]" id="start_ampm1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
						<option value="AM">AM</option>
						<option value="PM">PM</option>
					</select>
				</div>
			
				<div  style="float: left; margin-left: 20px;  width:275px" class="timers">
					<h1>End</h1>
					<select type="text" class="date_check1 end_hr2" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
						<option disabled="disabled">Select Hour</option>
						<?php foreach($hrs as $time){
							echo "<option value='".$time."'>".$time."</option>";
						} ?>
					</select>
			
					<select type="text" class="date_check1" name="end_min1[]" id="end_min1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
						<option disabled="disabled">Select Min</option>
						<?php foreach($mins as $time){
								echo "<option value='".$time."'>".$time."</option>";
							} ?>
					</select>
			
					<select type="text"  class="date_check1" name="end_ampm1[]" id="end_ampm1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
						<option value="AM">AM</option>
						<option value="PM">PM</option>
					</select>
			
				</div>
			</div>
		</div>	
			<div style="float:left; margin-left: 10px;" >
				<a href="javascript:void(0);" class="remove_node"><i class="fa fa-remove"></i></a>
			</div>
	
			<div style="clear:both"></div>
			<span class="closed_days"> 
			<input type="checkbox" id="allday1" class="allday1 checkbox_status_identifier alldayCheckBox" number="1" value="1" /> All day
			<input type="hidden" class="allday" name="allday1[]" value="0" /> 
			</span>
			<div style="clear:both"></div>
		</div>
		
	</div>
</div>
			

<div id="deploy_holder">
	
	<div class="form-light-holder schedule" id="schedule1">
    <div style="float:left;">
    	<h1>Date</h1>
		<input type="text" value="" name="date1[]" required class="form-control  multiple_dates" placeholder="mm/dd/yyyy" maxlength="10" style="width: 100px; margin: 0;"/>
		<input type="hidden" value="" name="" id="date_hidden1" class="myhiddenvalue" maxlength="10"/>
    </div>
	
    <?php
		/* if it is closed day category, do not require start/end date and repeat, only singular entry - email 6/11/13 Dojo prj details*/
		// allow repeat - email 30/10/14 Calender/Multi Calender issue
		//if($category_id != 52){
	?>
    <div class="closed_days">
    <div style="float:left; margin-left: 20px;">
        <h1>Repeat</h1>
        <select name="repeat1[]" id="repeat1" class="calendar_event_dropdown event_repeat_type" number="0">
        <option value="never">Never</option>
        <!-- <option value="Every day">Every day</option> --> <!-- changelog v2 no need of daily repeat -->
        <option value="Every week">Every week</option>
        <!-- <option value="Every month">Every month</option> --> <!-- changelog v2 no need of monthly repeat -->
        <option value="Every year">Every year</option>
        </select>
    </div>
    
    <div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1 alldayHideBox_1">
    
    	<div style="float: left; width: 275px;" class="timers event_set_time">
            <h1>Start</h1>
            
            <select type="text" class="calendar_event_dropdown date_check1 start_hr" number="0" name="start_hr1[]" id="start_hr1" >
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="calendar_event_dropdown date_check1 start_min" number="0" name="start_min1[]" id="start_min1" >
                <option disabled="disabled">Select Min</option>
                <?php                		 
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="calendar_event_dropdown date_check1 start_ampm" number="0" name="start_ampm1[]" id="start_ampm1" >
            	<option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
		</div>
            
		<div  style="float: left; margin-left: 20px;  width:275px" class="timers">
            <h1>End</h1>
            <select type="text" class="calendar_event_dropdown date_check1 end_hr0" number="0" name="end_hr1[]" id="end_hr1">
                <option disabled="disabled">Select Hour</option>
                <?php                 
                 foreach($hrs as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text" class="calendar_event_dropdown date_check1 end_min0" number="0" name="end_min1[]" id="end_min1">
                <option disabled="disabled">Select Min</option>
                <?php
                 foreach($mins as $time){
                    echo "<option value='".$time."'>".$time."</option>";
                }
                ?>
            </select>
            
            <select type="text"  class="calendar_event_dropdown date_check1 end_ampm0" number="0" name="end_ampm1[]" id="end_ampm1" >
                <option value="AM">AM</option>
            	<option value="PM">PM</option>
            </select>
            
		</div>
    </div>
	
	<div class="closed_days calendar_end_date_0" style="float:left; margin-left: 20px;margin-right:0px;display:none">
			<h1>End Date</h1>
			<input type="text"  value=""  name="end_date1[]" class="form-control multiple_end_dates" placeholder="mm/dd/yyyy" maxlength="10" style="width: 100px; margin: 0; "/>
		</div>
	</div>
    <div style="clear:both"></div>    
    <span class="closed_days"> 
	<label class="ckbox">
    <input type="checkbox" id="allday1" class="allday1_schedule1 checkbox_status_identifier alldayCheckBox" number="1" value="1" /><span>ALL DAY</span></label>
    <input type="hidden" class="allday  all_day_checbox_1"  name="allday1[]" value="0" /> 
	</span>
    <?php
		//}
	?>
    <div style="clear:both"></div>    
		
</div>
	
</div>
<div class="ErrorMessage ErrorMessage_date"></div>
<input type="hidden" id="totalmultiple_dates" value="1" >
<script type="text/javascript">

	$(document).ready(function(){
	
		$('#add_more_date').click(function(){
				
				//$('#deploy_mirror').clone().appendTo('#deploy_holder');
				//$('#deploy_holder').children().show();
			var schedule_event = $('.schedule').length;
			
			var schedule_event_length = schedule_event;
			
			var totalmultiple_dates = $('#totalmultiple_dates').val();
			var i = parseInt(totalmultiple_dates) + Number(1);
			$('#totalmultiple_dates').val(i);
			
		$('<div class="form-light-holder event_set_time schedule exitevents" id="schedule2"><div style="float:left;"><h1>Start Date</h1><input type="text" value="" name="date1[]"   class="form-control multiple_dates" placeholder="mm/dd/yyyy" maxlength="10" style="width: 100px; margin: 0;"/><input type="hidden" value="" name="" id="date_hidden2" class="myhiddenvalue" maxlength="10"/></div><div class="closed_days closed_days'+schedule_event_length+'"><div style="float:left; margin-left: 20px;"><h1>Repeat</h1><select class="calendar_event_dropdown event_repeat_type" name="repeat1[]" id="repeat1" number="'+i+'"><option value="never">Never</option><option value="Every week">Every week</option><option value="Every year">Every year</option></select></div><div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1  alldayHideBox_'+i+'"><div style="float: left; width: 280px;" time_grp1><h1>Start</h1><select type="text" class="calendar_event_dropdown extra_margin date_check1 start_hr"  number="'+schedule_event_length+'" name="start_hr1[]" id="start_hr1" ><option disabled="disabled">Select Hour</option><?php foreach($hrs as $time){ echo '<option value="'.$time.'">'.$time.'</option>';}?></select><select type="text" class="calendar_event_dropdown extra_margin date_check1 start_min"  number="'+schedule_event_length+'" name="start_min1[]" id="start_min1" ><option disabled="disabled">Select Min</option><?php foreach($mins as $time){ echo '<option value="'.$time.'">'.$time.'</option>';}?></select><select type="text" class="calendar_event_dropdown extra_margin date_check start_ampm" number="'+schedule_event_length+'" name="start_ampm1[]" id="start_ampm1" ><option value="AM">AM</option><option value="PM">PM</option></select></div><div  style="float: left; margin-left: 20px;  width:280px" class="timers"><h1>End</h1><select type="text" class="calendar_event_dropdown extra_margin date_check1 end_hr'+schedule_event_length+'" name="end_hr1[]" id="end_hr1" ><option disabled="disabled">Select Hour</option><?php foreach($hrs as $time){ echo '<option value="'.$time.'">'.$time.'</option>';} ?></select><select type="text" class="calendar_event_dropdown extra_margin date_check1  end_min'+schedule_event_length+'" name="end_min1[]" id="end_min1" ><option disabled="disabled">Select Min</option><?php foreach($mins as $time){ echo '<option value="'.$time.'">'.$time.'</option>';} ?></select><select type="text"  class="calendar_event_dropdown extra_margin date_check1 end_ampm'+schedule_event_length+'" name="end_ampm1[]" id="end_ampm1" ><option value="AM">AM</option><option value="PM">PM</option></select></div></div><div class="calendar_end_date_'+i+'" style="float:left; margin-left: 30px;margin-right: 0px;display:none"><h1>End Date</h1><input type="text" value="" name="end_date1[]" class="form-control multiple_end_dates" placeholder="mm/dd/yyyy" maxlength="10" style="width: 100px; margin: 0; " id=""></div></div><div style="float:left; margin-left: 10px;margin-top:30px" ><a href="javascript:void(0);" class="remove_node1"><i class="fa fa-remove"></i></a></div><div style="clear:both"></div><div class="closed_days all_day_close_btn closed_days'+schedule_event_length+'"><label class="ckbox"><input type="checkbox" id="allday1" class="allday1 checkbox_status_identifier  alldayCheckBox" number="'+i+'" value="1" /><span>ALL DAY</span></label><input type="hidden" name="allday1[]" class="allday all_day_checbox_'+i+'" value="0" /></div><div style="clear:both"></div></div>').appendTo('#deploy_holder');
				if($('#category_id').val() == 52){
				$('.closed_days'+schedule_event_length).hide();
			}
		});
		
		
		$(document).on('click','.allday1',function(){
		
			var c = $(this).is(':checked');
			
			if(c == true){
				$(this).prev().prev().prev().hide();
			}else{
				$(this).prev().prev().prev().show();
			}	
				
		});
			
		
		$(document).on('click','.allday1_schedule1',function(){
		
			var c = $(this).is(':checked');
		
			if(c == true){
				$(this).prev().prev().hide();
			}else{
				$(this).prev().prev().show();
			}	
				
		});
		
		$(document).on('click','.remove_node',function(){
			
			$(this).parent().parent().fadeOut();
		
		});
		
		
		$(document).on('click','.remove_node1',function(){
			var exitevents  = $('.exitevents').length;
			//alert(exitevents); return false;
			if(exitevents >= 1){
				$(this).parent().parent().remove();
				exitevents  = $('.exitevents').length;
			}
			
			if(exitevents <= 1){
				$('.removeEvent').css('display','none');
			}
		
		});
		
   
		$('body').on('focus','.multiple_dates, .multiple_end_dates',function(){
			$(this).datepicker({dateFormat: "yy/mm/dd",altFormat: 'yy/mm/dd'});
		});
		
		$('body').on('change','.multiple_dates',function(){
			if($(this).val() != ''){
				$(this).css({"border-color": "#EEEEEE", 
				 "border-width":"1px", 
				 "border-style":"solid"});
			}else{
				$(this).css({"border-color": "red", 
				 "border-width":"2px", 
				 "border-style":"solid"});
			}
		});
		
		

		$('#disable_me').on('click', function(){
			//$(this).hide();
			//$(this).parent().append('Submiting....');
			// $('#blog_form').submit();
		})
		
		$('#deploy_holder').on('change', '.checkbox_status_identifier', function(){
			var number = $(this).attr('number');
			if ($(this).prop('checked')){ 
				$('.all_day_checbox_'+number).val(1);
			}else{
				$('.all_day_checbox_'+number).val(0);
			}
		})
		
		
	});

</script>


<?php
// this thing will make it multiple
#$temp['hrs'] = $hrs;
#$temp['mins'] = $mins;
#$this->load->view("admin/include/more_callendars",$temp);
?>





<div id="next_date_container">
</div>



<?php
	/* if it is closed day category, no add more button - changelog v2 */
	//if($category_id != 52){
?>
<div style="clear:both;"></div>    
<div style="margin-top: 10px;"><h1><a id="add_more_date" class="btn btn-outline-light " />Add More Dates</a></h1></div>

<div style="clear:both"></div>    
    
<span id="dyn_content"></div>
<div style="clear:both"></div>    

<?php //} ?>
 
<div class="form-light-holder" style="">
	<!--<textarea name="text" class="textarea" id="frm-text"></textarea>
	--><textarea name="text" class="" id="frm-text" rows="10"></textarea>
	<div class="ErrorMessage ErrorMessage_textarea"></div>
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" name="counter" id="counter" value="1" />
	<input type="hidden" value="<?='view/'.$this->uri->segment(4);?>" name="redirect" class="redirect" />
	<input type="submit" name="update" value="Save" class="btn-save" id="disable_me" style="float:left;" />
</div>
</form>		
		</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
