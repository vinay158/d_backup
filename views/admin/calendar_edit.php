<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>	
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script>
    $(function() {
        $( "#date" ).datepicker({ dateFormat: "yy-mm-dd",altFormat: 'yy/mm/dd',altField:'#date_hidden'});

    });
    </script>
	<style>
.ErrorMessage{color:#FF0000}
</style>
<script language="javascript">
	$(document).ready(function(){
	
	<!-- DOJO -->
	$('.btn-save').click(function(){
		var textarea_value = CKEDITOR.instances['frm-text'].getData();
		if($('#main_title').val() == ''){
			$('.ErrorMessage_title').html('Please fill required field *');
			return false;
		}else if(textarea_value == ''){
			$('.ErrorMessage_textarea').html('Please fill required field *');
			return false;
		}else{
			return true;
		}
	});
	
})
</script>
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name">Edit Entry</div>
			</div>
			<div class="panel-body">
				<div class="panel-body-holder">
					<div class="form-holder">

						<form id="blog_form" action="" method="post" onSubmit="javascript:return date_validate();">
							<?php if(!empty($details)):?>
								<?php foreach($details as $details): 
										if(isset($location) && count($location) > 1 && $multi_calendar == 1): 
								?>
										<div class="form-light-holder" style="overflow:auto;">
											<h1 style="padding-bottom: 5px;">Choose a Location</h1>
											<div>
												<select id="location_id" name="location_id" style="width: 100%; background:#FFF; border: none; border-radius: 5px; padding: 5px;">
													<option value="null" disabled="disabled">Your Location</option>
													<?php if(isset($location)):
													 ?>
														<?php
														
														 foreach($location as $location_item): ?>
															<option value="<?=$location_item->id;?>" 
															<?php 
															if($details->location_id == $location_item->id) echo "selected='selected'";?> ><?=$location_item->name;?></option>
														<?php endforeach;?>
													<?php endif;?>
												</select>
											</div>
										</div>
									<?php endif;?>
									<div class="form-light-holder" style="overflow:auto;">
										<h1 style="padding-bottom: 5px;">Choose a Category</h1>
										<div>
											<select id="category_id" name="blog_category_id" style="width: 100%; background:#FFF; border: none; border-radius: 5px; padding: 5px;">
												<option value="null" disabled="disabled">Your Categories</option>
												<?php if(isset($cat)): ?>
													<?php foreach($cat as $cat_item): ?>
														<option value="<?=$cat_item->cat_id;?>" 
														<?php if($details->category == $cat_item->cat_id) echo "selected='selected'"; ?>><?=$cat_item->cat_name;?></option>
													<?php endforeach;?>
												<?php endif;?>
											</select>
										</div>
									</div>
									<div class="form-light-holder">
										<h1>Event Title</h1>
										<input type="text" value="<?=$details->title;?>" name="title" id="main_title" class="field" placeholder="Enter your event title here" />
										<div class="ErrorMessage ErrorMessage_title"></div>
									</div>
									<div class="form-light-holder">
										<h1>Date</h1>
										<input type="text" value="<?=$details->mydate?>" name="date" id="date" class="field" placeholder="mm/dd/yyyy" maxlength="10"/>
										<input type="hidden" value="<?=($details->mydate)?str_replace('-','/',$details->mydate):'';?>" name="date_hidden" id="date_hidden"   maxlength="10"/>
										<div>
											<input type="checkbox" <?php if($details->isWhole) echo "checked='checked'";?> name="allday" id="allday" /> All day
										</div>
									</div>

									<div class="form-light-holder" style="" id="date_area">
										<div style="float: left; width: 300px">
											<h1>Start</h1>
										
											<select type="text" name="start_hr" id="start_hr" class="date_check"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
												<option disabled="disabled">select hour</option>
												<?php
												$time = array("01","02","03","04","05","06","07","08","09","10","11","12");
												$details->start=str_replace(':',' ',$details->start);
												$details->start=explode(' ',$details->start);	
												foreach($time as $time){
													
													if($details->isWhole == 0 && $details->start[0] == $time){
														echo "<option value='".$time."' selected='selected'>".$time."</option>";
													}else{
														echo "<option value='".$time."'>".$time."</option>";
													}
												}
												?>
											</select>
											
											<select type="text" name="start_min" id="start_min" class="date_check"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
												<option disabled="disabled">select min</option>
												<?php
												$time = array("00", "05", "10", "15", "20", "25", "30", "35", "40", "45", "50", "55");
												
												foreach($time as $time){
													if($details->isWhole == 0 && $details->start[1] == $time){
														echo "<option value='".$time."' selected='selected'>".$time."</option>";
													}else{
														echo "<option value='".$time."'>".$time."</option>";
													}
												}
												?>
											</select>
											
											<select type="text" name="start_ampm" id="start_ampm" class="date_check"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">	
												<?php
												$time = array("AM","PM");	 
												foreach($time as $time){
													if($details->isWhole == 0 && $details->start[2] == $time){
														echo "<option value='".$time."' selected='selected'>".$time."</option>";
													}else{
														echo "<option value='".$time."'>".$time."</option>";
													}
												}
												?>
											</select>
										
										</div>
										<div  style="float: left; margin-left: 50px;  width: 300px">
											<h1>End</h1>
											<select type="text" name="end_hr" id="end_hr" class="date_check"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
												<option disabled="disabled">select hour</option>
												<?php
												$time = array("01","02","03","04","05","06","07","08","09","10","11","12");
												
												$details->end=str_replace(':',' ',$details->end);
												$details->end=explode(' ',$details->end);
												
												foreach($time as $time){
													if($details->isWhole == 0 && $details->end[0] == $time){
														echo "<option value='".$time."' selected='selected'>".$time."</option>";
													}else{
														echo "<option value='".$time."'>".$time."</option>";
													}
												}
												?>
											</select>
											
											<select type="text" name="end_min" id="end_min" class="date_check"  style="background:#FFF; border: none; border-radius: 5px; padding: 5px;">
												<option disabled="disabled">select min</option>
												<?php
												$time = array("00", "05", "10", "15", "20", "25", "30", "35", "40", "45", "50", "55");
												
												foreach($time as $time){
													if($details->isWhole == 0 && $details->end[1] == $time){
														echo "<option value='".$time."' selected='selected'>".$time."</option>";
													}else{
														echo "<option value='".$time."'>".$time."</option>";
													}
												}
												?>
											</select>	
											
											<select type="text" name="end_ampm" id="end_ampm" class="date_check"  style=" background:#FFF; border: none; border-radius: 5px; padding: 5px;">	
												<?php
												$time = array("AM","PM");	 
												foreach($time as $time){		
													if($details->isWhole == 0 && $details->end[2] == $time){
														echo "<option value='".$time."' selected='selected'>".$time."</option>";
													}else{
														echo "<option value='".$time."'>".$time."</option>";
													}
												}
												?>
											</select>
										</div>
										<br style="clear:both" />
									</div>
									<div class="form-light-holder">
										<h1>Repeat</h1>
										<select name="repeat" id="repeat"   style="width: 100%; background:#FFF; border: none; border-radius: 5px; padding: 5px;">
										<?php
										//$rep = array("never", "Every day", "Every week", "Every month", "Every year");
										$rep = array("never", "Every week", "Every year"); // changelog v2 no need of monthly repeat
										foreach($rep as $rep){
											if($details->repeat == $rep)
											echo "<option value='".$rep."' selected='selected'>".ucwords($rep)."</option>";
											else
											echo "<option value='".$rep."'>".ucwords($rep)."</option>";
										}
										?>
										</select>
									</div>
										<div class="form-light-holder" style="">
											<!--<textarea name="text" class="textarea" id="frm-text"><?=html_entity_decode($details->content);?></textarea>
											--><textarea name="text" class="" id="frm-text" rows="10"><?=$details->content;?></textarea>
											<div class="ErrorMessage ErrorMessage_textarea"></div>
										</div>

										<div class="form-white-holder" style="padding-bottom:20px;">
											<input type="hidden" value="<?=$this->uri->segment(5).'/'.$this->uri->segment(6);?>" name="redirect" class="" />
											<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
										</div>
								<?php endforeach;?>
							<?php endif;?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<br style="clear:both" /><br />

<script>
$(document).ready(function(){	
	<?php if($details->isWhole){ ?>
			$("#allday").change();
		<?php } ?>

});
</script>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>

