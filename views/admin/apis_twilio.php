
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#twilioApi .authorize_hidden_cb').val() == 0 || $('#twilioApi .multi_twilio_hidden_cb').val() == 1){
		$('#twilioApi .AuthorizeDetailBox').hide();
		$('#twilioApi .authorize').removeAttr('required');
	}else{
		
		$('#twilioApi .AuthorizeDetailBox').show();
		$('#twilioApi .authorize').attr('required', 'required');
	}
	
	
});
$(document).ready(function(){
$("#twilioApi .form-light-holder1 .authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.authorize').removeAttr('required');
		$(this).parents("#twilioApi .form-light-holder1").children("#twilioApi .authorize_hidden_cb").val("0");
		$('#twilioApi .AuthorizeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#twilioApi .authorize').attr('required', 'required');
		
		$(this).parents(".form-light-holder1").children("#twilioApi .authorize_hidden_cb").val("1");
		$('#twilioApi .AuthorizeDetailBox').show();
		
		
	}
})


$("#twilioApi .multi_twilio .multi_twilio_checkbox").click(function(){
	var twilioApi = $('#twilioApi .authorize_hidden_cb').val();
	if(twilioApi == 1){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents("#twilioApi .multi_twilio").children("#twilioApi .multi_twilio_hidden_cb").val("0");
				$('#twilioApi .AuthorizeDetailBox').show();
				$('#twilioApi .authorize').attr('required',true);
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents("#twilioApi .multi_twilio").children("#twilioApi .multi_twilio_hidden_cb").val("1");
				$('#twilioApi .AuthorizeDetailBox').hide();
				$('#twilioApi .authorize').attr('required',false);
			}
		}
})

})
</script>



		<div class="panel-body" id="twilioApi">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_twilio" method="post" enctype="multipart/form-data">



<?php

	$chargify_checkbox_check = 'check-on';
	$multi_twilio_check = 'check-off';
	if(!empty($apis_twilio['detail'])){
		if($apis_twilio['detail']->type == 1){
			$chargify_checkbox_check = 'check-on';
		}else{
			$chargify_checkbox_check = 'check-off';
		}
		
		if($apis_twilio['detail']->multi_twilio_check == 1){
				$multi_twilio_check = 'check-on';
			}else{
				$multi_twilio_check = 'check-off';
			}
	}
	
	
?>
 <div class="form-light-holder1   form-new-holder">
	<a id="published" class="authorizecheckbox <?php echo $chargify_checkbox_check; ?> " ></a>
	<h1 class="inline">Twilio Api</h1>
	<input type="hidden" value="<?php if(!empty($apis_twilio['detail'])){ echo $apis_twilio['detail']->type; } else{ echo 0; }?>" name="type" class="authorize_hidden_cb" />
</div>

<?php if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder2 multi_twilio  form-new-holder">
	<a id="published" class="multi_twilio_checkbox <?php echo $multi_twilio_check; ?> " ></a>
	<h1 class="inline">Twilio for each location?</h1>
	<input type="hidden" value="<?php if(!empty($apis_twilio['detail'])){ echo $apis_twilio['detail']->multi_twilio_check; } else{ echo 0; }?>" name="multi_twilio_check" class="multi_twilio_hidden_cb" />
</div>
<?php } ?> 

<div  class="AuthorizeDetailBox">
<div class="">
	<h1>Twilio SID</h1>
	<input type="text" value="<?php if(!empty($apis_twilio['detail'])){ echo $apis_twilio['detail']->sid; }?>" name="sid" class="field authorize" placeholder="Enter Your Twilio SID"  />
</div>
<div class="  form-new-holder">
	<h1>Twilio Token</h1>
	<input type="text" value="<?php if(!empty($apis_twilio['detail'])){ echo $apis_twilio['detail']->token; }?>" name="token" class="field authorize" placeholder="Enter Your Twilio Token"  />
</div>
<div class="  form-new-holder">
	<h1>Twilio Phone Number</h1>
	<input type="text" value="<?php if(!empty($apis_twilio['detail'])){ echo $apis_twilio['detail']->from_phone_number; }?>" name="from_phone_number" class="field authorize" placeholder="Enter Your Twilio Phone Number"  />
</div>
<div class="  form-new-holder">
	<h1>Checkbox Text</h1>
	<input type="text" value="<?php if(!empty($apis_twilio['detail'])){ echo $apis_twilio['detail']->checkbox_text; }?>" name="checkbox_text" class="field authorize" placeholder="Enter Your Twilio Checkbox Text"  />
</div>

<!--<div class="">
	<h1>Active Campaign Tag</h1>
	<input type="text" value="<?php if(!empty($apis_twilio['detail'])){ echo $apis_twilio['detail']->ac_tag_name; }?>" name="ac_tag_name" class="field authorize" placeholder="Enter Your Twilio Active Campaign Tag"  />
</div> -->




</div>

<div class="  form-new-holder">
	<h1>Twilio Cell Number (Default)</h1>
	<input type="text" value="<?php if(!empty($apis_twilio['detail'])){ echo $apis_twilio['detail']->twilio_cell_number; }?>" name="twilio_cell_number" class="field" placeholder="Enter Your Twilio Cell Number"  />
</div>


</div>


<div class="form-white-holder  form-new-holder">

	<input type="submit" name="twilio_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>
