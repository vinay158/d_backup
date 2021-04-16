<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('.authorize_hidden_cb').val() == 0){
		$('.AuthorizeDetailBox').hide();
		$('.authorize').removeAttr('required');
	}else{
		$('.AuthorizeDetailBox').show();
		$('.authorize').attr('required', 'required');
	}
	
	if($('.braintree_hidden_cb').val() == 0){
		$('.BraintreeDetailBox').hide();
		$('.braintree').removeAttr('required');
	}else{
		$('.BraintreeDetailBox').show();
		$('.braintree').attr('required', 'required');
	}
});
$(document).ready(function(){
$(".form-light-holder .authorizecheckbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.authorize').removeAttr('required');
		$(this).parents(".form-light-holder").children(".authorize_hidden_cb").val("0");
		$('.AuthorizeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('.authorize').attr('required', 'required');
		
		$(this).parents(".form-light-holder").children(".authorize_hidden_cb").val("1");
		$('.AuthorizeDetailBox').show();
		$('.BraintreeDetailBox').hide();
		$('.braintree_checkbox').removeClass('check-on');
		$('.braintree_checkbox').addClass('check-off');
		$('.braintree_hidden_cb').val('0');
		
	}
})


$(".form-light-holder .braintree_checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$('.braintree').removeAttr('required');
		$(this).parents(".form-light-holder").children(".braintree_hidden_cb").val("0");
		$('.BraintreeDetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$('.braintree').attr('required', 'required');
		$(this).parents(".form-light-holder").children(".braintree_hidden_cb").val("1");
		$('.BraintreeDetailBox').show();
		$('.AuthorizeDetailBox').hide();
		$('.authorizecheckbox').removeClass('check-on');
		$('.authorizecheckbox').addClass('check-off');
		$('.authorize_hidden_cb').val('0');
	}
})
})
</script>



<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		<div class="panel-title">

			<div class="panel-title-name"><?= $title ?></div>

		</div>

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="" method="post" enctype="multipart/form-data">



<?php
	$authorize_checkbox_check = 'check-off';
	if(!empty($detail)){
		if($detail->authorize_net_payment == 1){
			$authorize_checkbox_check = 'check-on';
		}else{
			$authorize_checkbox_check = 'check-off';
		}
	}
	
	
?>
<div class="form-light-holder">
	<a id="published" class="authorizecheckbox <?php echo $authorize_checkbox_check; ?> " ></a>
	<h1 class="inline">Authorize Net Payment</h1>
	<input type="hidden" value="<?php if(!empty($detail)){ echo $detail->authorize_net_payment; } else{ echo 0; }?>" name="authorize_net_payment" class="authorize_hidden_cb" />
</div>

<div  class="AuthorizeDetailBox">
<div class="form-light-holder">
	<h1>Login Key</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->authorize_loginkey; }?>" name="authorize_loginkey" class="field authorize" placeholder="Enter Your Login Key"  />
</div>
<div class="form-light-holder">
	<h1>Transaction Key</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->authorize_transkey; }?>" name="authorize_transkey" class="field authorize"  placeholder="Enter Your Transaction Key"  />
</div>
</div>



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
<div class="form-light-holder">
	<a id="published" class="braintree_checkbox <?php echo $braintree_checkbox_check; ?> " ></a>
	<h1 class="inline">BrainTree Payment</h1>
	<input type="hidden" value="<?php if(!empty($detail)){ echo $detail->braintree_payment; } else{ echo 0; }?>" name="braintree_payment" class="braintree_hidden_cb" />
</div>

<div  class="BraintreeDetailBox">
<div class="form-light-holder">
	<h1>Braintree Merchant Id</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->braintree_merchant_id; }?>" name="braintree_merchant_id" class="field braintree" placeholder="Enter Your Merchant Id"  />
</div>
<div class="form-light-holder">
	<h1>Braintree Public Key</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->braintree_public_key; }?>" name="braintree_public_key" class="field braintree"  placeholder="Enter Your Public Key"  />
</div>
<div class="form-light-holder">
	<h1>Braintree Private Key</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->braintree_private_key; }?>" name="braintree_private_key" class="field braintree"  placeholder="Enter Your Private Key"  />
</div>
</div>


<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />

</div>

</form>

		</div>

		</div>

		</div>

	</div>

	</div>

<br style="clear:both" /><br />

<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

