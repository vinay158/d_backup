
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#chargifyApi .authorize_hidden_cb').val() == 0){
		$('#chargifyApi .AuthorizeDetailBox').hide();
		$('#chargifyApi .authorize').removeAttr('required');
	}else{
		$('#chargifyApi .AuthorizeDetailBox').show();
		$('#chargifyApi .authorize').attr('required', 'required');
	}
	
	
});
$(document).ready(function(){
$("#chargifyApi .form-light-holder1 .authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.authorize').removeAttr('required');
		$(this).parents("#chargifyApi .form-light-holder1").children("#chargifyApi .authorize_hidden_cb").val("0");
		$('#chargifyApi .AuthorizeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#chargifyApi .authorize').attr('required', 'required');
		
		$(this).parents(".form-light-holder1").children("#chargifyApi .authorize_hidden_cb").val("1");
		$('#chargifyApi .AuthorizeDetailBox').show();
		
		
	}
})

})
</script>



		<div class="panel-body" id="chargifyApi">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_chargify" method="post" enctype="multipart/form-data">



<?php

	$chargify_checkbox_check = 'check-off';
	if(!empty($apis_chargify['detail'])){
		if($apis_chargify['detail']->type == 1){
			$chargify_checkbox_check = 'check-on';
		}else{
			$chargify_checkbox_check = 'check-off';
		}
	}
	
	
?>
<div class="form-light-holder1  form-new-holder">
	<a id="published" class="authorizecheckbox <?php echo $chargify_checkbox_check; ?> " ></a>
	<h1 class="inline">Chargify Api</h1>
	<input type="hidden" value="<?php if(!empty($apis_chargify['detail'])){ echo $apis_chargify['detail']->type; } else{ echo 0; }?>" name="type" class="authorize_hidden_cb" />
</div>

<div  class="AuthorizeDetailBox">
<div class="  form-new-holder">
	<h1>Subdomain</h1>
	<input type="text" value="<?php if(!empty($apis_chargify['detail'])){ echo $apis_chargify['detail']->subdomain; }?>" name="subdomain" class="field authorize" placeholder="Enter Your Chargify Subdomain"  />
</div>


<div class="  form-new-holder">
	<h1>Shared Key</h1>
	<input type="text" value="<?php if(!empty($apis_chargify['detail'])){ echo $apis_chargify['detail']->shared_key; }?>" name="shared_key" class="field authorize"  placeholder="Enter Your  Chargify Shared Key"  />
</div>

<div class="  form-new-holder">
	<h1>Subscription ID</h1>
	<input type="text" value="<?php if(!empty($apis_chargify['detail'])){ echo $apis_chargify['detail']->subscription_id; }?>" name="subscription_id" class="field authorize"  placeholder="Enter Your  Chargify Subscription ID"  />
</div>


</div>


</div>


<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="submit" name="chargify_update" value="Save" class="btn-save" style="float:left;" />

</div>

</form>

		</div>

		</div>
