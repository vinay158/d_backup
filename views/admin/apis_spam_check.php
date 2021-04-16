
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#spamcheck  .hidden_cb').val() == 0){
		$('#spamcheck .template_box').hide();
	}else{
		$('#spamcheck .template_box').show();
	}
});
$(document).ready(function(){
$("#spamcheck .form-light-holder-mailchimp .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#spamcheck .form-light-holder-mailchimp").children("#spamcheck .hidden_cb").val("0");
		$('#spamcheck .template_box').hide();
		$('#spamcheck .api_key').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#spamcheck .form-light-holder-mailchimp").children("#spamcheck .hidden_cb").val("1");
		$('#spamcheck .template_box').show();
		$('#spamcheck .api_key').attr('required',true);
	}
})

$('#spamcheck .btn-save').click(function(){
		if($('#spamcheck .hidden_cb').val() == 0){
			$('#spamcheck .api_key').attr('required',false);
		} else{
			$('#spamcheck .api_key').attr('required',true);
		}
});

})
</script>



		<div class="panel-body" id="spamcheck">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_spamcheck" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	if(!empty($apis_spamcheck['detail'])){
		if($apis_spamcheck['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
	}
	
	
?>
<div class="form-light-holder-mailchimp  form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Spam Check Api</h1>
	<input type="hidden" value="<?php if(!empty($apis_spamcheck['detail'])){ echo $apis_spamcheck['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>



<div class="template_box  form-new-holder" style="display:none">
		<h1>Api Key</h1>
		<input type="text" value="<?php if(!empty($apis_spamcheck['detail'])){ echo $apis_spamcheck['detail']->api_key; }?>" name="api_key" class="api_key" />
</div>








<div class="form-white-holder  form-new-holder">

	<input type="submit" name="spamcheck_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>

	

<!------------ recent items ----------------->


