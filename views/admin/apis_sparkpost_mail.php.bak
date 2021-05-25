
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#sparkPostApi .authorize_hidden_cb').val() == 0){
		$('#sparkPostApi .AuthorizeDetailBox').hide();
		$('#sparkPostApi .authorize').removeAttr('required');
	}else{
		$('#sparkPostApi .AuthorizeDetailBox').show();
		$('#sparkPostApi .authorize').attr('required', 'required');
	}
	
	
});
$(document).ready(function(){
$("#sparkPostApi .form-light-holder1 .authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.authorize').removeAttr('required');
		$(this).parents("#sparkPostApi .form-light-holder1").children("#sparkPostApi .authorize_hidden_cb").val("0");
		$('#sparkPostApi .AuthorizeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#sparkPostApi .authorize').attr('required', 'required');
		
		$(this).parents(".form-light-holder1").children("#sparkPostApi .authorize_hidden_cb").val("1");
		$('#sparkPostApi .AuthorizeDetailBox').show();
		
		
	}
})

})
</script>



		<div class="panel-body" id="sparkPostApi">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_sparkpost_mail" method="post" enctype="multipart/form-data">



<?php

	$chargify_checkbox_check = 'check-off';
	if(!empty($apis_sparkpost_mail['detail'])){
		if($apis_sparkpost_mail['detail']->type == 1){
			$chargify_checkbox_check = 'check-on';
		}else{
			$chargify_checkbox_check = 'check-off';
		}
	}
	
	
?>
<div class="form-light-holder1  form-new-holder">
	<a id="published" class="authorizecheckbox <?php echo $chargify_checkbox_check; ?> " ></a>
	<h1 class="inline">Sparkpost Api</h1>
	<input type="hidden" value="<?php if(!empty($apis_sparkpost_mail['detail'])){ echo $apis_sparkpost_mail['detail']->type; } else{ echo 0; }?>" name="type" class="authorize_hidden_cb" />
</div>

<div  class="AuthorizeDetailBox">
<div class="  form-new-holder">
	<h1>Api Key</h1>
	<input type="text" value="<?php if(!empty($apis_sparkpost_mail['detail'])){ echo $apis_sparkpost_mail['detail']->api_key; }?>" name="api_key" class="field authorize"  placeholder="Enter Your Sparkpost Key"  />
</div>

<div class="  form-new-holder">
	<h1>From Email Address</h1>
	<input type="text" value="<?php if(!empty($apis_sparkpost_mail['detail'])){ echo $apis_sparkpost_mail['detail']->from_email; }?>" name="from_email" class="field authorize"  placeholder="Enter Your From Email Address"  />
</div>


</div>


</div>


<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="submit" name="sparkpost_update" value="Save" class="btn-save" style="float:left;" />

</div>

</form>

		</div>

		</div>
