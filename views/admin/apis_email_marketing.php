
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>


<script language="javascript">

$(document).ready(function(){
$("#emailMarketingApi .form-light-holder1 .email_marketing_checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#emailMarketingApi .form-light-holder1").children("#emailMarketingApi .email_marketing_hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder1").children("#emailMarketingApi .email_marketing_hidden_cb").val("1");
	}
})

})
</script>


		<div class="panel-body" id="emailMarketingApi">

		<div class="panel-body-holder">

		<div class="form-holder">

<?php

	$email_marketing_checkbox_check = 'check-off';
	if(!empty($apis_email_marketing['detail'])){
		if($apis_email_marketing['detail']->email_marketing == 1){
			$email_marketing_checkbox_check = 'check-on';
		}else{
			$email_marketing_checkbox_check = 'check-off';
		}
	}
	
	
?>

<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_email_marketing" method="post" enctype="multipart/form-data">




<div class="form-light-holder1 email_marketing  form-new-holder">
		<a id="status" class="email_marketing_checkbox  <?php echo $email_marketing_checkbox_check; ?>"></a>
		<h1 class="inline">Email Marketing</h1>
		<input type="hidden" value="<?php if(!empty($apis_email_marketing['detail'])){ echo $apis_email_marketing['detail']->email_marketing; } else{ echo 0; }?>" name="email_marketing" class="email_marketing_hidden_cb" />
</div>

</div>


<div class="form-white-holder  form-new-holder" >

	<input type="submit" name="email_marketing_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>
