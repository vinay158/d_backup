
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	//if($('#twilioChatApi .authorize_hidden_cb').val() == 0 || $('#twilioChatApi .multi_twilio_hidden_cb').val() == 1){
	if($('#twilioChatApi .authorize_hidden_cb').val() == 0){
		$('#twilioChatApi .AuthorizeDetailBox').hide();
		$('#twilioChatApi .authorize').removeAttr('required');
	}else{
		
		$('#twilioChatApi .AuthorizeDetailBox').show();
		$('#twilioChatApi .authorize').attr('required', 'required');
	}
	
	
});
$(document).ready(function(){
$("#twilioChatApi .form-light-holder1 .authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.authorize').removeAttr('required');
		$(this).parents("#twilioChatApi .form-light-holder1").children("#twilioChatApi .authorize_hidden_cb").val("0");
		$('#twilioChatApi .AuthorizeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#twilioChatApi .authorize').attr('required', 'required');
		
		$(this).parents(".form-light-holder1").children("#twilioChatApi .authorize_hidden_cb").val("1");
		$('#twilioChatApi .AuthorizeDetailBox').show();
		
		
	}
})


/*$("#twilioChatApi .multi_twilio .multi_twilio_checkbox").click(function(){
	var twilioApi = $('#twilioChatApi .authorize_hidden_cb').val();
	if(twilioApi == 1){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents("#twilioChatApi .multi_twilio").children("#twilioChatApi .multi_twilio_hidden_cb").val("0");
				$('#twilioChatApi .AuthorizeDetailBox').show();
				$('#twilioChatApi .authorize').attr('required',true);
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents("#twilioChatApi .multi_twilio").children("#twilioChatApi .multi_twilio_hidden_cb").val("1");
				$('#twilioChatApi .AuthorizeDetailBox').hide();
				$('#twilioChatApi .authorize').attr('required',false);
			}
		}
})*/

})
</script>



		<div class="panel-body" id="twilioChatApi">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_twilio_chat" method="post" enctype="multipart/form-data">



<?php

	$chargify_checkbox_check = 'check-off';
	//$multi_twilio_check = 'check-off';
	if(!empty($apis_twilio_chat['detail'])){
		if($apis_twilio_chat['detail']->type == 1){
			$chargify_checkbox_check = 'check-on';
		}else{
			$chargify_checkbox_check = 'check-off';
		}
		
		/*if($apis_twilio_chat['detail']->multi_twilio_check == 1){
				$multi_twilio_check = 'check-on';
			}else{
				$multi_twilio_check = 'check-off';
			}*/
	}
	
	
?>
 <div class="form-light-holder1   form-new-holder">
	<a id="published" class="authorizecheckbox <?php echo $chargify_checkbox_check; ?> " ></a>
	<h1 class="inline">Twilio Chat Api</h1>
	<input type="hidden" value="<?php if(!empty($apis_twilio_chat['detail'])){ echo $apis_twilio_chat['detail']->type; } else{ echo 0; }?>" name="type" class="authorize_hidden_cb" />
</div>

<?php /*if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder2 multi_twilio  form-new-holder">
	<a id="published" class="multi_twilio_checkbox <?php echo $multi_twilio_check; ?> " ></a>
	<h1 class="inline">Twilio for each location?</h1>
	<input type="hidden" value="<?php if(!empty($apis_twilio_chat['detail'])){ echo $apis_twilio_chat['detail']->multi_twilio_check; } else{ echo 0; }?>" name="multi_twilio_check" class="multi_twilio_hidden_cb" />
</div>
<?php }*/ ?> 

<div  class="AuthorizeDetailBox">
<div class="">
	<h1>Twilio SID</h1>
	<input type="text" value="<?php if(!empty($apis_twilio_chat['detail'])){ echo $apis_twilio_chat['detail']->sid; }?>" name="sid" class="field authorize" placeholder="Enter Your Twilio SID"  />
</div>
<div class="  form-new-holder">
	<h1>Twilio Token</h1>
	<input type="text" value="<?php if(!empty($apis_twilio_chat['detail'])){ echo $apis_twilio_chat['detail']->token; }?>" name="token" class="field authorize" placeholder="Enter Your Twilio Token"  />
</div>
<div class="  form-new-holder">
	<h1>Twilio Phone Number</h1>
	<input type="text" value="<?php if(!empty($apis_twilio_chat['detail'])){ echo $apis_twilio_chat['detail']->from_phone_number; }?>" name="from_phone_number" class="field authorize" placeholder="Enter Your Twilio Phone Number"  />
</div>
<div class="  form-new-holder">
	<h1>Country Phone Code</h1>
	<input type="text" value="<?php if(!empty($apis_twilio_chat['detail'])){ echo $apis_twilio_chat['detail']->country_phone_code; }?>" name="country_phone_code" class="field authorize" placeholder="Enter Your Country Phone Code"  />
</div>
<?php 
	$timezones = array('America/Denver','America/New_York'); 
	$timezones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
?>
<div class=" form-new-holder" style="">
		<h1>Timezones</h1>
		<select name="timezone" id="" class="field ">
			<option value="">-Select-</option>
			<?php foreach($timezones as $timezone){ ?>
			<option value="<?php echo $timezone; ?>" <?php echo (isset($apis_twilio_chat['detail']->timezone) && $apis_twilio_chat['detail']->timezone == $timezone) ? 'selected=selected' : ''; ?>><?php echo $timezone; ?></option>
			<?php } ?>
		</select>
</div>
	
<!--<div class="  form-new-holder">
	<h1>Checkbox Text</h1>
	<input type="text" value="<?php //if(!empty($apis_twilio_chat['detail'])){ echo $apis_twilio_chat['detail']->checkbox_text; }?>" name="checkbox_text" class="field authorize" placeholder="Enter Your Twilio Checkbox Text"  />
</div>--->

<!--<div class="">
	<h1>Active Campaign Tag</h1>
	<input type="text" value="<?php //if(!empty($apis_twilio_chat['detail'])){ echo $apis_twilio_chat['detail']->ac_tag_name; }?>" name="ac_tag_name" class="field authorize" placeholder="Enter Your Twilio Active Campaign Tag"  />
</div> -->




</div>

<!-- <div class="  form-new-holder">
	<h1>Twilio Cell Number (Default)</h1>
	<input type="text" value="<?php // if(!empty($apis_twilio_chat['detail'])){ echo $apis_twilio_chat['detail']->twilio_cell_number; }?>" name="twilio_cell_number" class="field" placeholder="Enter Your Twilio Cell Number"  />
</div> --->


</div>


<div class="form-white-holder  form-new-holder">

	<input type="submit" name="twilio_chat_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>
