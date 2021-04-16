<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini_header_title', 
									{ customConfig : 'config.js' }
							);
		
	});
</script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo isset($title) ? $title : ''; ?></h2>
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
<div class="mb-3 main-content-label page_main_heading"><?php echo isset($title) ? $title : ''; ?></div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="<?php echo !empty($details) ? $this->query_model->getStrReplaceAdmin($details->title) : ''; ?>" name="title" required="true" id="name" class="field full_width_input" placeholder="Enter your title"  style=""/>
</div>

<div class="form-light-holder">
	<h1>Subject</h1>
	<input type="text" value="<?php echo !empty($details) ? $this->query_model->getStrReplaceAdmin($details->subject) : ''; ?>" name="subject" required="true" id="subject" class="field full_width_input" placeholder="Enter your email subject"  style=""/>
</div>




<div class="form-light-holder" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Auto Responder</h1>
			<textarea type="text" id="ckeditor_mini_header_title" name="description" class="field full_width_input"><?php echo !empty($details) ? $details->description : ''; ?></textarea>
		<div>
		</div>
</div>
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
<?php if(!empty($form_instances)){ ?>
<div class="form-light-holder  row row-xs align-items-center form-module page-instance">
	<div class="col-md-12"><h1>Form Instances</h1></div>
	
	<?php if(!empty($form_instances)){ ?>
	
		<?php $i = 1;
		foreach($form_instances as $form_instance){ ?>
			<div class="col-md-4 form_instance  <?php echo (count($form_instances) >= 10) ? 'morethan10' : ''; ?>  <?php echo ($i >= 10) ? 'bigval' : 'smallval'; ?>"><span><?php echo $i; ?></span> <?php echo $form_instance->name; ?> </div>
		<?php $i++; } ?>
	<?php } ?>
</div>
<?php } ?>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
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
