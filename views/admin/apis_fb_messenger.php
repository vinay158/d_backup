
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#fbMessengerApi .authorize_hidden_cb').val() == 0){
		$('#fbMessengerApi .AuthorizeDetailBox').hide();
		$('#fbMessengerApi .authorize').removeAttr('required');
	}else{
		$('#fbMessengerApi .AuthorizeDetailBox').show();
		$('#fbMessengerApi .authorize').attr('required', 'required');
	}
	
	
});
$(document).ready(function(){
$("#fbMessengerApi .form-light-holder1 .authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.authorize').removeAttr('required');
		$(this).parents("#fbMessengerApi .form-light-holder1").children("#fbMessengerApi .authorize_hidden_cb").val("0");
		$('#fbMessengerApi .AuthorizeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#fbMessengerApi .authorize').attr('required', 'required');
		
		$(this).parents(".form-light-holder1").children("#fbMessengerApi .authorize_hidden_cb").val("1");
		$('#fbMessengerApi .AuthorizeDetailBox').show();
		
		
	}
})

})
</script>



		<div class="panel-body" id="fbMessengerApi">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_fb_messenger" method="post" enctype="multipart/form-data">



<?php

	$messenger_checkbox_check = 'check-off';
	if(!empty($apis_fb_messenger['detail'])){
		if($apis_fb_messenger['detail']->type == 1){
			$messenger_checkbox_check = 'check-on';
		}else{
			$messenger_checkbox_check = 'check-off';
		}
	}
	
	
?>
<div class="form-light-holder1  form-new-holder">
	<a id="published" class="authorizecheckbox <?php echo $messenger_checkbox_check; ?> " ></a>
	<h1 class="inline">Facebook Messenger</h1>
	<input type="hidden" value="<?php if(!empty($apis_fb_messenger['detail'])){ echo $apis_fb_messenger['detail']->type; } else{ echo 0; }?>" name="type" class="authorize_hidden_cb" />
</div>

<div  class="AuthorizeDetailBox">
<div class="  form-new-holder">
	<h1>Facebook App Id</h1>
	<input type="text" value="<?php if(!empty($apis_fb_messenger['detail'])){ echo $apis_fb_messenger['detail']->app_id; }?>" name="app_id" class="field authorize" placeholder="Enter Your Facebook App Id"  />
</div>


<div class="  form-new-holder">
	<h1>Facebook Page Id</h1>
	<input type="text" value="<?php if(!empty($apis_fb_messenger['detail'])){ echo $apis_fb_messenger['detail']->page_id; }?>" name="page_id" class="field authorize"  placeholder="Enter Your Facebook Page Id"  />
</div>



</div>


</div>


<div class="form-white-holder  form-new-holder">

	<input type="submit" name="fb_messenger_update" value="Save" class="btn-save" />

</div>

</form>

		</div>

		</div>
