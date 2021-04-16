
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#paypalPayment .authorize_hidden_cb').val() == 0){
		$('#paypalPayment .AuthorizeDetailBox').hide();
		$('#paypalPayment .paypal_require').removeAttr('required');
	}else{
		$('#paypalPayment .AuthorizeDetailBox').show();
		$('#paypalPayment .paypal_require').attr('required', 'required');
	}
	
	
});
$(document).ready(function(){
$("#paypalPayment .form-light-holder1 .authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.paypal_require').removeAttr('required');
		$(this).parents("#paypalPayment .form-light-holder1").children("#paypalPayment .authorize_hidden_cb").val("0");
		$('#paypalPayment .AuthorizeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#paypalPayment .paypal_require').attr('required', 'required');
		
		$(this).parents(".form-light-holder1").children("#paypalPayment .authorize_hidden_cb").val("1");
		$('#paypalPayment .AuthorizeDetailBox').show();
		
		
	}
})

})
</script>



		<div class="panel-body" id="paypalPayment">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_paypal_payment" method="post" enctype="multipart/form-data">



<?php

	$paypal_checkbox_check = 'check-off';
	if(!empty($apis_paypal_payment['detail'])){
		if($apis_paypal_payment['detail']->paypal_payment == 1){
			$paypal_checkbox_check = 'check-on';
		}else{
			$paypal_checkbox_check = 'check-off';
		}
	}
	
	
?>
<div class="form-light-holder1    form-new-holder">
	<a id="published" class="authorizecheckbox <?php echo $paypal_checkbox_check; ?> " ></a>
	<h1 class="inline">Paypal Payment</h1>
	<input type="hidden" value="<?php if(!empty($apis_paypal_payment['detail'])){ echo $apis_paypal_payment['detail']->paypal_payment; } else{ echo 0; }?>" name="paypal_payment" class="authorize_hidden_cb" />
</div>

<div  class="AuthorizeDetailBox">
<div class="">
	<h1>Payment Mode</h1>
	<label class="rdiobox"><input type="radio" value="sandbox" name="paypal_payment_mode" class="braintree" <?php echo (empty($apis_paypal_payment['detail']->paypal_payment_mode) || $apis_paypal_payment['detail']->paypal_payment_mode == "sandbox") ? 'checked=checked' : ''; ?> /><span>Sandbox</span>
			  </label>
	<label class="rdiobox"><input type="radio" value="live" name="paypal_payment_mode" class="braintree"  <?php echo ($apis_paypal_payment['detail']->paypal_payment_mode == "live") ? 'checked=checked' : ''; ?> /><span>Production</span>
			  </label>
</div>
<div class="">
	<h1>Client ID</h1>
	<input type="text" value="<?php if(!empty($apis_paypal_payment['detail'])){ echo $apis_paypal_payment['detail']->paypal_client_id; }?>" name="paypal_client_id" class="field paypal_require" placeholder="Enter Your Client ID"  />
</div>
<div class="">
	<h1>Secret Key</h1>
	<input type="text" value="<?php if(!empty($apis_paypal_payment['detail'])){ echo $apis_paypal_payment['detail']->paypal_secret_key; }?>" name="paypal_secret_key" class="field paypal_require"  placeholder="Enter Your Secret Key"  />
</div>
</div>


</div>


<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="submit" name="paypalPaymentUpdate" value="Save" class="btn-save" style="float:left;" />

</div>

</form>

		</div>

		</div>
