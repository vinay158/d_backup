<?php $this->load->view("admin/include/header"); ?>


<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->
<script src="js/new/jquery.maskMoney.js"></script>


<script language="javascript" type="text/javascript"></script>

<div class="az-content-body-left advanced_page custom_full_page text_msg_templates" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Text Message Templates</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">

<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

	

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">

<div class="mb-3 main-content-label page_main_heading">Text Message Setting</div>

<form id="blog_form" action="" method="post" enctype="multipart/form-data">




<script language="javascript">
$(window).load(function(){
	if($('.hidden_cb2').val() == 1){
		//$('.show_full_form_box').show();
	}else{
		//$('.show_full_form_box').hide();
	}
})
$(document).ready(function(){

$(".form-light-holder .checkbox1").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("0");

		
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("1");
	}

})

})

</script>





<div class="show_full_form_box">

<div class="form-light-holder ">
	<a id="published" class="checkbox1 <?php echo (!empty($pagedetails) && $pagedetails[0]->send_admin_text_msg == 1) ? 'check-on' : 'check-off'; ?>"></a>

	<h1 class="inline">Send Text Message To Admin </h1>

	<input type="hidden" value="<?php echo (!empty($pagedetails) && $pagedetails[0]->send_admin_text_msg == 1) ? 1 : 0; ?>" name="send_admin_text_msg" class="hidden_cb1" />

</div>
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update_twillio_api" value="Save" class="btn-save" style="float:left;" />

</div>


</form>

		</div>

		</div>

		</div>
	
	
	
		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">

<div class="mb-3 main-content-label page_main_heading">Text Message Templates</div>

<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<?php $formTypes = array('mini_and_full_form' => 'Mini/Full Form','birthday_program_form' => 'Birthday Program Form','summer_camp_program_form' => 'Summer Camp Program Form','free_trial' => 'Free trial', 'paid_trial'=>'Paid Trial','upsell_trial' => 'Trial Upsells','dojocart'=>'Dojocart','contact_us' => 'Contact Us'); ?>

<?php 
$i = 1;
foreach($formTypes as $key => $val){
	
?>
<?php if($i % 2 == 1){ ?>
<div class="form-light-holder   d-md-flex  dual_input">
	
	<div class="adsUrl form-group">
		<h1 class="label-text"><?php echo $val; ?></h1>
		<h1>Admin Text Message Template</h1>
	<textarea name="twillio_msg_template[<?php echo $key; ?>][admin_msg]"  rows="8"><?php echo isset($twillioMsgTemplates[$key]) ? $twillioMsgTemplates[$key]->admin_msg : ''; ?></textarea>
	</div>
	
<?php }else{ ?> 
	<div class="linkTarget form-group second_textarea_box">
		<h1 class="label-text"><?php echo $val; ?></h1>
		<h1>Admin Text Message Template</h1>
	<textarea name="twillio_msg_template[<?php echo $key; ?>][admin_msg]"  rows="8"><?php echo isset($twillioMsgTemplates[$key]) ? $twillioMsgTemplates[$key]->admin_msg : ''; ?></textarea>
	</div>
</div>
<?php } ?>
	
	

<?php $i++; } ?>


<div class="clearfix"></div>
<div class="form-light-holder  row row-xs align-items-center  email_varibles" style="overflow:auto;">
			<div class="col-md-12"><h1 style="padding-bottom: 5px;">Variables:</h1></div>
			<div class="col-md-12"><em>Please use variables in auto responder textarea</em></div>
			
<?php 
	$variablesArr = array(	
						'Common' => array('FIRSTNAME','EMAIL','PHONE','LOCATION','PROGRAM','MESSAGE','BIRTHDAY_PARTY_TITLE','BIRTHDAY_CALL_OR_SCHEDULE','SUMMER_CAMP_RESERVE_OR_SECHEDULE'),
						'School and Contact'=> array('SITE_TITLE','CONTACT_NAME','CONTACT_ADDRESS','CONTACT_SUITE','CONTACT_CITY','CONTACT_STATE','CONTACT_ZIP','CONTACT_PHONE'),
						'Dojocart'=> array('DOJOCART_TITLE','DOJOCART_UPSELLS_LIST','DOJOCART_MULTI_ITEMS_LIST','DOJOCART_AMOUNT','DOJOCART_QUANTITY','DOJOCART_COUPON_NAME','DOJOCART_COUPON_DISCOUNT','DOJOCART_CUSTOM_FIELDS','PRINT_PDF'),
						'Trial Offer and Upsell'=> array('TRIAL_NAME','TRIAL_TYPE','TRIAL_AMOUNT','TRIAL_UPSELL_NAME','TRIAL_UPSELL_AMOUNT','TRIAL_COUPON_NAME','TRIAL_COUPON_DISCOUNT','CHILD_NAME','CHILD_AGE','PAYMENT_RESULT')
					);
?>
			<div class="col-md-12 row row-xs">
			<?php 
			$i = 0;
			foreach($variablesArr as $key => $variables){
				
			?>
				<div class="col-md-3">
				<div class="col-md-12 <?php echo ($i == 0 || $i == 3) ? 'nopadding' : ''; ?>"> <h1 class="heading"><?php echo $key ?> Variables</h1></div>
				<?php  foreach($variables as $variable){ ?>
						<div class="col-md-12  <?php echo ($i == 0 || $i == 3) ? 'nopadding' : ''; ?>">#<?php echo $variable; ?></div>
				<?php } ?>
				</div>
			<?php $i++; } ?>
			</div>
			
</div>



<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update_twillio_msg_templates" value="Save" class="btn-save" style="float:left;" />

</div>
</form>

		</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>

<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

