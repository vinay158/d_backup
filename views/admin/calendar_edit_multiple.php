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
---------- -->

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
		//$('.show_even_on_closed_day_div').hide();
		
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
		
		$("#category_id").change(function(){
		
			var category_id = $(this).val();
			
			
			var redirect = 'edit/<?=$this->uri->segment(4).'/view/';?>'+category_id;
			//alert(redirect); 
			$('.redirect').val(redirect);
			if(category_id == 52){
				$('.closed_days').hide();
				//$('.show_even_on_closed_day_div').hide();
				$('.allday').val(1);
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
<!-- DOJO -->
<style>
.ErrorMessage{color:#FF0000}
</style>
<script language="javascript">
	
	$(document).ready(function(){
	
	<!-- DOJO -->
	
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
				 "border-width":"3px", 
				 "border-style":"solid"});
				 
			$('.ErrorMessage_date').html(' *Date is Required');
			console.log($(this));
			error = false;
		 }
		 
		 
	});
	return error;
		
		});
	
})
</script> 


<div class="az-content-body-left advanced_page custom_full_page calendar_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Calendar Event</h2>
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
<div class="mb-3 main-content-label page_main_heading">Edit: Calendar Event</div>

<form id="blog_form" action="" method="post" onSubmit="javascript:return date_validate();">
<input type="hidden" value="1" name="is_multiple" />
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
})
</script>


<?php
$hrs = array("01","02","03","04","05","06","07","08","09","10","11","12");
$mins = array("00", "05", "10", "15", "20", "25", "30", "35", "40", "45","50", "55");
$category_id = $this->uri->segment('4');

?>
<?php if(isset($location) && count($location) > 1 && $multi_calendar == 1): ?>
<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Location</h1>
		<div>
		<select name="location_id" class="field">
			<option value="null" disabled="disabled">Your Location</option>
				<?php foreach($location as $location_item): ?>
					<option value="<?=$location_item->id;?>" 
					<?php echo ($location_item->id == $details['location_id'])?'selected':'';?>
					><?=$location_item->name;?></option>
				<?php endforeach;?>
		</select>
		</div>
</div>
<?php endif; ?>
<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Category</h1>
		<div>
		<select id="category_id" name="blog_category_id" class="field">
			<option value="null" disabled="disabled">Your Categories</option>
			<?php if(isset($cat)): ?>
				<?php foreach($cat as $cat_item): ?>
					<option value="<?=$cat_item->cat_id;?>"
					<?php echo ($cat_item->cat_id == $details['category'])?'selected':'';?>
					 ><?=$cat_item->cat_name;?></option>
				<?php endforeach;?>
			<?php endif;?>
		</select>
		</div>
</div>
<div class="form-light-holder">
	<h1>Event Title</h1>
	<input type="text" value="<?php echo $details['title'];?>" name="title" id="main_title" class="field full_width_input" placeholder="Enter your event title here"/>
	<div class="ErrorMessage ErrorMessage_title"></div>
</div>

<div class="form-light-holder show_even_on_closed_day_div closed_days">
	<label class="ckbox">
		<input name="show_even_on_closed_days"  class="allday1_schedule1 checkbox_show_even_on_closed_days" value="1" type="checkbox" <?php if($details['show_even_on_closed_days'] == 1){ echo "checked=checked";} ?>> 
		<span>Show Even on Closed Days</span>
            </label>
</div>


<!-- MIRROR IN HERE -->
<div class="form-group" id="deploy_mirror" style="display:none;" >
	<div class="form-group deployment_info_node">
			
		<div class="form-light-holder exitevents" id="schedule2" >
			<div style="float:left;">
				<h1>Date</h1>
				<input type="text" value="" name="date1[]"  class="field "  placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
				
				<input type="hidden" value="" name="" id="date_hidden2" class="myhiddenvalue" maxlength="10"/>
			</div>
	<input type="text" value="" name="end_date1[]"  class="field "  placeholder="mm/dd/yyyy" maxlength="10" style="width: 200px; margin: 0;"/>
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
			
					<select type="text" class="date_check1" name="start_hr1[]" id="start_hr1"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">
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
					<select type="text" class="date_check1" name="end_hr1[]" id="end_hr1"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
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
			
			<div style="float:left; margin-left: 10px;" >
				<a href="javascript:void(0);" class="remove_node"><i class="fa fa-remove"></i></a>
			</div>
	
			<div style="clear:both"></div>
			<label class="ckbox"><input type="checkbox" id="allday1" class="allday1 checkbox_status_identifier alldayCheckBox" number="1" value="1" />ALL DAY</span>
            </label>
			<input type="hidden" name="allday1[]" value="0" /> 
	
			<div style="clear:both"></div>
		</div>
		
	</div>
</div>
			

<div id="deploy_holder">
	
	<?php 
	$i = 1;
	foreach($multiple_dates as $mdate):?>
	
		<div class="form-light-holder schedule exitevents schedule_edit_<?php echo $i; ?>" id="schedule1">
		<div style="float:left;">
			<h1>Start Date</h1>
			<input type="text"  value="<?php echo date('Y/m/d',strtotime($mdate['date']));?>"  name="date1[]" class="form-control multiple_dates" placeholder="mm/dd/yyyy" maxlength="10" style="width: 100px; margin: 0; "/>
			<input type="hidden" value="" name="" id="date_hidden1" class="myhiddenvalue" maxlength="10"/>
		</div>
		
		
		<?php
			/* if it is closed day category, do not require start/end date and repeat, only singular entry - email 6/11/13 Dojo prj details*/
			// allow repeat - email 30/10/14 Calender/Multi Calender issue
			//if($category_id != 52){
		?>
<span class="closed_days">
		
		<div style="float:left; margin-left: 20px;">
			<h1>Repeat</h1>
			<select name="repeat1[]" id="repeat1" class="calendar_event_dropdown event_repeat_type" number="<?php echo $i; ?>">
			<option value="never" <?php echo ($mdate['repeat'] == 'never')?'selected':'';?>>Never</option>
			<option value="Every week" <?php echo ($mdate['repeat'] == 'Every week')?'selected':'';?>>Every week</option>
			<option value="Every year" <?php echo ($mdate['repeat'] == 'Every year')?'selected':'';?>>Every year</option>
			</select>
		</div>
		
</span>
		<div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp">
			
		<span class="closed_days alldayHideBox_<?php echo $i; ?>" style="<?php echo ($mdate['isWhole'] == 1) ? 'display:none' : 'display:block'; ?>" style="margin-right: 20px;">				
			<div style="float: left; width: 275px;" class="timers" >
				<h1>Start</h1>
				<?php
					$start = explode(' ',$mdate['start']);
					
					$start_2 = explode(':',$start['0']);
					$start_hr = isset($start_2['0']) ? $start_2['0'] : '';
					$start_min = isset($start_2['1']) ? $start_2['1'] : '';
					 
				?>
				<select type="text" class="calendar_event_dropdown date_check start_hr" name="start_hr1[]" id="start_hr1" number="<?php echo $i; ?>">
					<option disabled="disabled">Select Hour</option>
					<?php              
					
					 foreach($hrs as $time){
					 
					 	$s1 = ($start_hr == $time)?'selected':'';
					 					 
						echo "<option value='".$time."' {$s1} >".$time."</option>";
					}
					?>
				</select>
		
				<select type="text" class="calendar_event_dropdown date_check start_min" name="start_min1[]" id="start_min1"  number="<?php echo $i; ?>" >
					<option disabled="disabled">Select Min</option>
					<?php                		 
					 foreach($mins as $time){
					 	
					 	$s2 = ($start_min == $time)?'selected':'';
					 
						echo "<option value='".$time."' {$s2}>".$time."</option>";
					}
					?>
				</select>
		
				<select type="text" class="calendar_event_dropdown date_check start_ampm" name="start_ampm1[]" id="start_ampm1"  number="<?php echo $i; ?>" >
					<option value="AM" <?php if (isset($start['1'] ) ){ echo ($start['1'] == 'AM')?'selected':''; } ?>>AM</option>
					<option value="PM" <?php if (isset($start['1'] ) ){ echo ($start['1'] == 'PM')?'selected':''; } ?>>PM</option>
				</select>
			</div>
		
			<div  style="float: left; margin-left: 20px;  width:275px" class="timers">
				<h1>End</h1>
				
				<?php
					$end = explode(' ',$mdate['end']);
					
					$end_2 = explode(':',$end['0']);
					$end_hr = isset($end_2['0']) ? $end_2['0'] : '';
					$end_min = isset($end_2['1']) ? $end_2['1'] : '';
					 
				?>
				
				<select type="text" class="calendar_event_dropdown date_check end_hr<?php echo $i; ?>" name="end_hr1[]" id="end_hr1">
					<option disabled="disabled">Select Hour</option>
					<?php                 
					 foreach($hrs as $time){
					 
						 $s3 = ($end_hr == $time)?'selected':'';
					 
						echo "<option value='".$time."' {$s3}>".$time."</option>";
					}
					?>
				</select>
		
				<select type="text" class="calendar_event_dropdown date_check end_min<?php echo $i; ?>" name="end_min1[]" id="end_min1" >
					<option disabled="disabled">Select Min</option>
					<?php
					 foreach($mins as $time){
					 
						 $s4 = ($end_min == $time)?'selected':'';
					 
						echo "<option value='".$time."' {$s4}>".$time."</option>";
					}
					?>
				</select>
		
				<select type="text"  class="calendar_event_dropdown date_check end_ampm<?php echo $i; ?>" name="end_ampm1[]" id="end_ampm1">
					<option value="AM" <?php if (isset($end['1'] ) ){ echo ($end['1'] == 'AM')?'selected':''; } ?>>AM</option>
					<option value="PM" <?php if (isset($end['1'] ) ){ echo ($end['1'] == 'PM')?'selected':''; } ?>>PM</option>
				</select>
		
			</div>
			
		</span>
		
			
		</div>
		
		<div class="closed_days calendar_end_date_<?php echo $i; ?>" style="float:left; margin-left: 20px;margin-right:0px;display:<?php echo ($mdate['repeat'] == 'Every week') ? 'show' : 'none'; ?>">
			<h1>End Date</h1>
			<input type="text"  value="<?php echo !empty($mdate['end_date']) ? date('Y/m/d',strtotime($mdate['end_date'])) : '';?>"  name="end_date1[]" class="form-control multiple_end_dates" placeholder="mm/dd/yyyy" maxlength="10" style="width: 100px; margin: 0; "/>
		</div>
		<?php if($i > 1){ ?>
			<div style="float:left; margin-left: 10px;margin-top:30px" class="removeEvent">
				<a class="remove_node" href="javascript:void(0);"><i class="fa fa-remove"></i></a>
			</div>
			<?php } ?>
		
		
		<div style="clear:both"></div>  
		
		<div class="closed_days all_day_close_btn"> 
		<label class="ckbox">
		<input type="checkbox" id="allday1" class="allday1_schedule1 checkbox_status_identifier alldayCheckBox" number="<?php echo $i; ?>" value="1" <?php if($mdate['isWhole'] == 1){ echo 'checked="checked"'; } ?>/> <span>ALL DAY</span></label>
		<input type="hidden" class="allday all_day_checbox_<?php echo $i; ?>" name="allday1[]" value="<?=$mdate['isWhole']?>" />
		</div>
		<div style="clear:both"></div>    
		
		</div>
	<?php $i++; endforeach; ?>
	
</div>
	
</div>
<div class="ErrorMessage ErrorMessage_date"></div>
<input type="hidden" id="totalmultiple_dates" value="<?php echo !empty($multiple_dates) ? count($multiple_dates) : 1; ?>" >
<script type="text/javascript">

	$(document).ready(function(){
	
		$('#add_more_date').click(function(){
				
			var schedule_event = $('.schedule').length;
			
			var totalmultiple_dates = $('#totalmultiple_dates').val();
			var i = parseInt(totalmultiple_dates) + Number(1);
			$('#totalmultiple_dates').val(i);
			//alert(schedule_event);
			var schedule_event_length = schedule_event;
			//alert(schedule_event_length); 

			$('<div class="form-light-holder event_set_time schedule exitevents" id="schedule2"><div style="float:left;"><h1>Start Date</h1><input type="text" value="" name="date1[]"   class="form-control multiple_dates" placeholder="mm/dd/yyyy" maxlength="10" style="width: 100px; margin: 0;"/><input type="hidden" value="" name="" id="date_hidden2" class="myhiddenvalue" maxlength="10"/></div><div class="closed_days closed_days'+schedule_event_length+'"><div style="float:left; margin-left: 20px;"><h1>Repeat</h1><select class="calendar_event_dropdown event_repeat_type" name="repeat1[]" id="repeat1" number="'+i+'"><option value="never">Never</option><option value="Every week">Every week</option><option value="Every year">Every year</option></select></div><div style="float:left; margin-left: 20px;" id="time_grp1" class="time_grp1 alldayHideBox_'+i+'"><div style="float: left; width: 280px;" time_grp1><h1>Start</h1><select type="text" class="calendar_event_dropdown extra_margin date_check1 start_hr"  number="'+schedule_event_length+'" name="start_hr1[]" id="start_hr1" ><option disabled="disabled">Select Hour</option><?php foreach($hrs as $time){ echo '<option value="'.$time.'">'.$time.'</option>';}?></select><select type="text" class="calendar_event_dropdown extra_margin date_check1 start_min"  number="'+schedule_event_length+'" name="start_min1[]" id="start_min1" ><option disabled="disabled">Select Min</option><?php foreach($mins as $time){ echo '<option value="'.$time.'">'.$time.'</option>';}?></select><select type="text" class="calendar_event_dropdown extra_margin date_check start_ampm" number="'+schedule_event_length+'" name="start_ampm1[]" id="start_ampm1" ><option value="AM">AM</option><option value="PM">PM</option></select></div><div  style="float: left; margin-left: 20px;  width:280px" class="timers"><h1>End</h1><select type="text" class="calendar_event_dropdown extra_margin date_check1 end_hr'+schedule_event_length+'" name="end_hr1[]" id="end_hr1" ><option disabled="disabled">Select Hour</option><?php foreach($hrs as $time){ echo '<option value="'.$time.'">'.$time.'</option>';} ?></select><select type="text" class="calendar_event_dropdown extra_margin date_check1  end_min'+schedule_event_length+'" name="end_min1[]" id="end_min1" ><option disabled="disabled">Select Min</option><?php foreach($mins as $time){ echo '<option value="'.$time.'">'.$time.'</option>';} ?></select><select type="text"  class="calendar_event_dropdown extra_margin date_check1 end_ampm'+schedule_event_length+'" name="end_ampm1[]" id="end_ampm1" ><option value="AM">AM</option><option value="PM">PM</option></select></div></div><div class="calendar_end_date_'+i+'" style="float:left; margin-left: 30px;margin-right: 0px;display:none"><h1>End Date</h1><input type="text" value="" name="end_date1[]" class="form-control multiple_end_dates" placeholder="mm/dd/yyyy" maxlength="10" style="width: 100px; margin: 0; " id=""></div></div><div style="float:left; margin-left: 10px;margin-top:30px" ><a href="javascript:void(0);" class="remove_node1"><i class="fa fa-remove"></i></a></div><div style="clear:both"></div><div class="closed_days all_day_close_btn closed_days'+schedule_event_length+'"><label class="ckbox"><input type="checkbox" id="allday1" class="allday1 checkbox_status_identifier  alldayCheckBox" number="'+i+'" value="1" /><span>ALL DAY</span></label><input type="hidden" name="allday1[]" class="allday all_day_checbox_'+i+'" value="0" /></div><div style="clear:both"></div></div>').appendTo('#deploy_holder');
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
			var exitevents  = $('.exitevents').length;
			//alert(exitevents); return false;
			if(exitevents > 1){
				$(this).parent().parent().remove();
				exitevents  = $('.exitevents').length;
			}
			
			if(exitevents <= 1){
				$('.removeEvent').css('display','none');
			}
		
		});
		
		$(document).on('click','.remove_node1',function(){
			var exitevents  = $('.exitevents').length;
			//alert(exitevents); return false;
			if(exitevents > 1){
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
				 "border-width":"3px", 
				 "border-style":"solid"});
			}
		});
		
		
		
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

<div id="next_date_container">
</div>

<?php
	/* if it is closed day category, no add more button - changelog v2 */
	//if($category_id != 52){
?>
<div style="clear:both;"></div>    
<div style="margin-top: 10px;"><h1><a id="add_more_date" class="btn btn-outline-light " />Add More Dates</a></h1></div>

<div style="clear:both"></div>    
    
<span id="dyn_content"></span>

	<div class="form-light-holder" style="">
		<textarea name="text" class="" id="frm-text" rows="10"><?php echo $details['content'];?></textarea>
		<div class="ErrorMessage ErrorMessage_textarea"></div>
	</div>

	<div class="form-white-holder" style="padding-bottom:20px;">
		<input type="hidden" name="counter" id="counter" value="1" />
		
		
		<input type="hidden" value="edit/<?=$this->uri->segment(4).'/view/'.$this->uri->segment(6);?>" name="redirect" class="redirect" />
		<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
	</div>


</div>
<div style="clear:both"></div>    

<?php //} ?>
 
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
