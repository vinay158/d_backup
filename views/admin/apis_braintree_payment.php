<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	
	if($('#braintreePayment .braintree_hidden_cb').val() == 0){
		$('#braintreePayment .BraintreeDetailBox').hide();
		$('#braintreePayment .braintree').removeAttr('required');
	}else{
		$('#braintreePayment .BraintreeDetailBox').show();
		$('#braintreePayment .braintree').attr('required', 'required');
	}
});
$(document).ready(function(){

$("#braintreePayment .form-light-holder1 .braintree_checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('#braintreePayment .braintree').removeAttr('required');
		$(this).parents("#braintreePayment .form-light-holder1").children("#braintreePayment .braintree_hidden_cb").val("0");
		$('#braintreePayment .BraintreeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#braintreePayment .braintree').attr('required', 'required');
		$(this).parents("#braintreePayment .form-light-holder1").children("#braintreePayment .braintree_hidden_cb").val("1");
		$('#braintreePayment .BraintreeDetailBox').show();
		
	}
})
})
</script>



		<div class="panel-body" id="braintreePayment">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_braintree_payment" method="post" enctype="multipart/form-data">



<?php
	$braintree_checkbox_check = 'check-off';
	if(!empty($detail)){
		if($detail->braintree_payment == 1){
			$braintree_checkbox_check = 'check-on';
		}else{
			$braintree_checkbox_check = 'check-off';
		}
	}
	
	
?>
<div class="form-light-holder1  form-new-holder">
	<a id="published" class="braintree_checkbox <?php echo $braintree_checkbox_check; ?> " ></a>
	<h1 class="inline">BrainTree Payment</h1>
	<input type="hidden" value="<?php if(!empty($detail)){ echo $detail->braintree_payment; } else{ echo 0; }?>" name="braintree_payment" class="braintree_hidden_cb" />
</div>

<div  class="BraintreeDetailBox">
<div class="  form-new-holder">
	<h1>Payment Mode</h1>
	<label class="rdiobox">
	<input type="radio" value="sandbox" name="braintree_payment_mode" class="braintree" <?php echo (empty($detail->braintree_payment_mode) || $detail->braintree_payment_mode == "sandbox") ? 'checked=checked' : ''; ?> /><span>Sandbox</span></label>
	
	<label class="rdiobox">
	<input type="radio" value="production" name="braintree_payment_mode" class="braintree"  <?php echo ($detail->braintree_payment_mode == "production") ? 'checked=checked' : ''; ?> /><span>Production</span></label>
</div>
<div class="  form-new-holder">
	<h1>Braintree Merchant Id</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->braintree_merchant_id; }?>" name="braintree_merchant_id" class="field braintree" placeholder="Enter Your Merchant Id"  />
</div>
<div class="  form-new-holder">
	<h1>Braintree Public Key</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->braintree_public_key; }?>" name="braintree_public_key" class="field braintree"  placeholder="Enter Your Public Key"  />
</div>
<div class="  form-new-holder">
	<h1>Braintree Private Key</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->braintree_private_key; }?>" name="braintree_private_key" class="field braintree"  placeholder="Enter Your Private Key"  />
</div>
</div>


<div class="form-white-holder  form-new-holder" >

	<input type="submit" name="braintreePaymentUpdate" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>
