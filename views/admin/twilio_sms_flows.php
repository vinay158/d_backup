<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->


<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		<?php 
			/*if(!empty($sms_flows)){ 
				for($i = 1; $i <= count($sms_flows); $i++){
		?>
		CKEDITOR.replace(  'sms_template_<?php echo $i; ?>',
									{  customConfig : 'config.js' }
						);
	
	<?php } } */ ?>
	});
</script>

<div class="az-content-body-left  advanced_page custom_full_page twilio_smsflow_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?></h2>
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



<form id="blog_form" action="" method="post" enctype="multipart/form-data">




<?php 
	if(!empty($sms_flows)){
		$i = 1;
		foreach($sms_flows as $sms_flow){
?>
<div class="mb-3 main-content-label page_main_heading">SMS Flow #<?php echo $i; ?></div>

<div class="form-new-holder">
	<div class="row row-xs align-items-center">
		
		<div class="col-md-12  mg-t-5 mg-md-t-0">
		<div class="row mg-t-10">
		<div class="col-lg-12">
			<?php if($sms_flow->id == 1){ ?>
				<p class="heading">SMS #1 - <span>Sent immediately after opt-in if between</span> 
					<select name="data[<?php echo $sms_flow->id; ?>][start_time]"  class="field">
					  <?php foreach($times as $key => $time){ ?>
						<option value="<?php echo $key; ?>" <?php echo ($sms_flow->start_time == $key) ? 'selected=selected' : ''; ?>><?php echo $time; ?> </option>
					  <?php } ?>
					  </select>

				<span class="between_line">&#9596;</span> 
					<select name="data[<?php echo $sms_flow->id; ?>][end_time]"  class="field">
					  <?php foreach($times as $key => $time){ ?>
						<option value="<?php echo $key; ?>" <?php echo ($sms_flow->end_time == $key) ? 'selected=selected' : ''; ?>><?php echo $time; ?> </option>
					  <?php } ?>
					  </select>
				<span>or the next day in this range if after hours</span></p>
			<?php }else{ ?>
				<p class="heading">SMS #2 - <span>Sent </span> 
					 <select name="data[<?php echo $sms_flow->id; ?>][days]"  class="field">
					  <?php for($a= 1; $a <= 30; $a++){ ?>
						<option value="<?php echo $a; ?>" <?php echo ($sms_flow->days == $a) ? 'selected=selected' : ''; ?>><?php echo $a; ?> <?php echo ($a > 1) ? 'days' : 'day'; ?> </option>
					  <?php } ?>
					  </select>
				<span>after inital opt-in, at</span>
					 <select name="data[<?php echo $sms_flow->id; ?>][start_time]"  class="field">
					  <?php foreach($times as $key => $time){ ?>
						<option value="<?php echo $key; ?>" <?php echo ($sms_flow->start_time == $key) ? 'selected=selected' : ''; ?>><?php echo $time; ?> </option>
					  <?php } ?>
					  </select>
				</p>
			<?php } ?>
			
		</div>
		<input type="hidden" name="data[<?php echo $sms_flow->id; ?>][msg_type]" value="template_<?php echo $i; ?>">
		
		
			</div>
		</div>
	</div>
</div>

<div class="form-new-holder">
	<!--<h1>SMS #<?php echo $i; ?></h1> -->
	
	<textarea name="data[<?php echo $sms_flow->id; ?>][msg_template]"  class="text" rows="10"><?php echo $sms_flow->msg_template; ?></textarea>
</div>

<?php $i++; } } ?>


<div class="form-light-holder  row row-xs align-items-center  email_varibles" style="overflow:auto;">
			<div class="col-md-12"><h1 style="padding-bottom: 5px;">Variables:</h1></div>
			<div class="col-md-12"><em>Please use variables in auto responder textarea</em></div>
			
<?php 
	$variablesArr = array(	
						'Common' => array('FIRSTNAME','EMAIL','PHONE','LOCATION','PROGRAM','MESSAGE'),
						'School and Contact'=> array('SITE_TITLE','CONTACT_NAME','CONTACT_ADDRESS','CONTACT_SUITE','CONTACT_CITY','CONTACT_STATE','CONTACT_ZIP','CONTACT_PHONE')
					);
?>
			<div class="col-md-12 row row-xs">
			<?php 
			$i = 0;
			foreach($variablesArr as $key => $variables){
				
			?>
				<div class="col-md-4">
				<div class="col-md-12 <?php echo ($i == 0 || $i == 3) ? 'nopadding' : ''; ?>"> <h1 class="heading"><?php echo $key ?> Variables</h1></div>
				<?php  foreach($variables as $variable){ ?>
						<div class="col-md-12  <?php echo ($i == 0 || $i == 3) ? 'nopadding' : ''; ?>">#<?php echo $variable; ?></div>
				<?php } ?>
				</div>
			<?php $i++; } ?>
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
	
	</div>
</div>
</div>
</div>


<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

