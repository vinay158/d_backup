
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#authorizePayment .authorize_hidden_cb').val() == 0){
		$('#authorizePayment .AuthorizeDetailBox').hide();
		$('#authorizePayment .authorize').removeAttr('required');
	}else{
		$('#authorizePayment .AuthorizeDetailBox').show();
		$('#authorizePayment .authorize').attr('required', 'required');
	}
	
	
});
$(document).ready(function(){
$("#authorizePayment .form-light-holder1 .authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.authorize').removeAttr('required');
		$(this).parents("#authorizePayment .form-light-holder1").children("#authorizePayment .authorize_hidden_cb").val("0");
		$('#authorizePayment .AuthorizeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#authorizePayment .authorize').attr('required', 'required');
		
		$(this).parents(".form-light-holder1").children("#authorizePayment .authorize_hidden_cb").val("1");
		$('#authorizePayment .AuthorizeDetailBox').show();
		
		
	}
})

})
</script>



		<div class="panel-body" id="authorizePayment">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_authorize_net_payment" method="post" enctype="multipart/form-data">



<?php

	$authorize_checkbox_check = 'check-off';
	if(!empty($apis_authorize_net_payment['detail'])){
		if($apis_authorize_net_payment['detail']->authorize_net_payment == 1){
			$authorize_checkbox_check = 'check-on';
		}else{
			$authorize_checkbox_check = 'check-off';
		}
	}
	
	
?>
<div class="form-light-holder1   form-new-holder">
	<a id="published" class="authorizecheckbox <?php echo $authorize_checkbox_check; ?> " ></a>
	<h1 class="inline">Authorize Net Payment</h1>
	<input type="hidden" value="<?php if(!empty($apis_authorize_net_payment['detail'])){ echo $apis_authorize_net_payment['detail']->authorize_net_payment; } else{ echo 0; }?>" name="authorize_net_payment" class="authorize_hidden_cb" />
</div>

<div  class="AuthorizeDetailBox">
<div class="  form-new-holder">
	

	<h1>Payment Mode</h1>
	<label class="rdiobox">
	<input type="radio" value="sandbox" name="authorize_payment_mode" class="braintree" <?php echo (empty($apis_authorize_net_payment['detail']->authorize_payment_mode) || $apis_authorize_net_payment['detail']->authorize_payment_mode == "sandbox") ? 'checked=checked' : ''; ?> /><span>Sandbox</span>
			  </label>
		<label class="rdiobox"><input type="radio" value="production" name="authorize_payment_mode" class="braintree"  <?php echo ($apis_authorize_net_payment['detail']->authorize_payment_mode == "production") ? 'checked=checked' : ''; ?> /><span>Production</span>
			  </label>
</div>
<div class="  form-new-holder">
	<h1>Login Key</h1>
	<input type="text" value="<?php if(!empty($apis_authorize_net_payment['detail'])){ echo $apis_authorize_net_payment['detail']->authorize_loginkey; }?>" name="authorize_loginkey" class="field authorize" placeholder="Enter Your Login Key"  />
</div>
<div class="  form-new-holder">
	<h1>Transaction Key</h1>
	<input type="text" value="<?php if(!empty($apis_authorize_net_payment['detail'])){ echo $apis_authorize_net_payment['detail']->authorize_transkey; }?>" name="authorize_transkey" class="field authorize"  placeholder="Enter Your Transaction Key"  />
</div>
</div>


</div>


<div class="form-white-holder  form-new-holder" >

	<input type="submit" name="authorizePaymentUpdate" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>
