
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#stripePayment .authorize_hidden_cb').val() == 0){
		$('#stripePayment .AuthorizeDetailBox').hide();
		$('#stripePayment .authorize').removeAttr('required');
	}else{
		$('#stripePayment .AuthorizeDetailBox').show();
		$('#stripePayment .authorize').attr('required', 'required');
		
		
		if($('#stripePayment .milti_authorize_hidden_cb').val() == 1){
			$('#stripePayment .AuthorizeDetailBoxDetail').hide();
			$('#stripePayment .authorize').removeAttr('required');
		}
		
	}
	
	
	
	
});
$(document).ready(function(){
$("#stripePayment .form-light-holder1 .authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.authorize').removeAttr('required');
		$(this).parents("#stripePayment .form-light-holder1").children("#stripePayment .authorize_hidden_cb").val("0");
		$('#stripePayment .AuthorizeDetailBox').hide();
		$('#stripePayment .AuthorizeDetailBoxDetail').hide();
		$('#stripePayment .milti_authorizecheckbox').removeClass("check-on");
		$('#stripePayment .milti_authorizecheckbox').addClass("check-off");
		$('#stripePayment .milti_authorize_hidden_cb').val(0);
		$('#stripePayment .sca_stripe_hidden_cb').val(0);
		$('#stripePayment .sca_stripe_checkbox').removeClass("check-on");
		$('#stripePayment .sca_stripe_checkbox').addClass("check-off");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#stripePayment .authorize').attr('required', 'required');
		
		$(this).parents(".form-light-holder1").children("#stripePayment .authorize_hidden_cb").val("1");
		$('#stripePayment .AuthorizeDetailBox').show();
		$('#stripePayment .AuthorizeDetailBoxDetail').show();
		$('#stripePayment .milti_authorizecheckbox').removeClass("check-on");
		$('#stripePayment .milti_authorizecheckbox').addClass("check-off");
		
		$('#stripePayment .sca_stripe_checkbox').removeClass("check-on");
		$('#stripePayment .sca_stripe_checkbox').addClass("check-off");
		
		
	}
})

$("#stripePayment .form-light-holder1 .sca_stripe_checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#stripePayment .form-light-holder1").children("#stripePayment .sca_stripe_hidden_cb").val("0");
		
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder1").children("#stripePayment .sca_stripe_hidden_cb").val("1");
		
		
	}
})


$("#stripePayment .form-light-holder2 .milti_authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('#stripePayment .authorize').attr('required', true);
		$(this).parents("#stripePayment .form-light-holder2").children("#stripePayment .milti_authorize_hidden_cb").val("0");
		
		$('#stripePayment .AuthorizeDetailBoxDetail').show();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('#stripePayment .authorize').attr('required', false);
		
		$(this).parents(".form-light-holder2").children("#stripePayment .milti_authorize_hidden_cb").val("1");
		$('#stripePayment .AuthorizeDetailBoxDetail').hide();
		
		
	}
})



})
</script>



		<div class="panel-body" id="stripePayment">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_stripe_payment_gateway" method="post" enctype="multipart/form-data">



<?php

	$authorize_checkbox_check = 'check-off';
	$sca_checkbox_check = 'check-off';
	$multi_stripe_check = 'check-off';
	if(!empty($apis_stripe_payment_gateway['detail'])){
		if($apis_stripe_payment_gateway['detail']->stripe_payment == 1){
			$authorize_checkbox_check = 'check-on';
		}else{
			$authorize_checkbox_check = 'check-off';
		}
		
			if($apis_stripe_payment_gateway['detail']->multi_stripe_check == 1){
				$multi_stripe_check = 'check-on';
			}else{
				$multi_stripe_check = 'check-off';
			}
			
		if($apis_stripe_payment_gateway['detail']->stripe_sca_payment == 1){
			$sca_checkbox_check = 'check-on';
		}else{
			$sca_checkbox_check = 'check-off';
		}
		
		
	}
	
	
?>
<div class="form-light-holder1  form-new-holder">
	<a id="published" class="authorizecheckbox <?php echo $authorize_checkbox_check; ?> " ></a>
	<h1 class="inline">Stripe Payment</h1>
	<input type="hidden" value="<?php if(!empty($apis_stripe_payment_gateway['detail'])){ echo $apis_stripe_payment_gateway['detail']->stripe_payment; } else{ echo 0; }?>" name="stripe_payment" class="authorize_hidden_cb" />
</div>

<?php if($multi_location[0]->field_value == 1){ ?>

<div class="form-light-holder2  form-new-holder">
<a id="published" class="milti_authorizecheckbox <?php echo $multi_stripe_check; ?> " ></a>
	<h1 class="inline">Stripe Payment for each location?</h1>
	<input type="hidden" value="<?php if(!empty($apis_stripe_payment_gateway['detail'])){ echo $apis_stripe_payment_gateway['detail']->multi_stripe_check; } else{ echo 0; }?>" name="multi_stripe_check" class="milti_authorize_hidden_cb" />
</div>
<?php } ?>

<div  class="AuthorizeDetailBox">
<div class="  form-new-holder">
	<h1>Payment Mode</h1>
	<label class="rdiobox">
	<input type="radio" value="sandbox" name="stripe_payment_mode" class="braintree" <?php echo (empty($apis_stripe_payment_gateway['detail']->stripe_payment_mode) || $detail->stripe_payment_mode == "sandbox") ? 'checked=checked' : ''; ?> /><span>Sandbox</span></label>
	
	<label class="rdiobox">
	<input type="radio" value="production" name="stripe_payment_mode" class="braintree"  <?php echo ($apis_stripe_payment_gateway['detail']->stripe_payment_mode == "production") ? 'checked=checked' : ''; ?> /><span>Production</span></label>
</div>
<div class="form-light-holder1  form-new-holder">
	<a id="published" class="sca_stripe_checkbox <?php echo $sca_checkbox_check; ?> " ></a>
	<h1 class="inline">Stripe SCA?</h1>
	<input type="hidden" value="<?php if(!empty($apis_stripe_payment_gateway['detail'])){ echo $apis_stripe_payment_gateway['detail']->stripe_sca_payment; } else{ echo 0; }?>" name="stripe_sca_payment" class="sca_stripe_hidden_cb" />
</div>

<div  class="AuthorizeDetailBoxDetail">
<div class="  form-new-holder">
	<h1>Secret Key</h1>
	<input type="text" value="<?php if(!empty($apis_stripe_payment_gateway['detail'])){ echo $apis_stripe_payment_gateway['detail']->stripe_secret_key; }?>" name="stripe_secret_key" class="field authorize" placeholder="Enter Your Secret Key"  />
</div>
<div class="  form-new-holder">
	<h1>Publishable Key</h1>
	<input type="text" value="<?php if(!empty($apis_stripe_payment_gateway['detail'])){ echo $apis_stripe_payment_gateway['detail']->stripe_publishable_key; }?>" name="stripe_publishable_key" class="field authorize"  placeholder="Enter Your Publishable Key"  />
</div>
</div>
</div>


</div>


<div class="form-white-holder  form-new-holder" >

	<input type="submit" name="stripePaymentUpdate" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>
