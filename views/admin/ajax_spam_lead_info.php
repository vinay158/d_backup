

<div class="row ajax_trial_lead_info">
<?php if(isset($spam_lead) && !empty($spam_lead)){ 
	$spam_lead = $spam_lead[0];
?>
<div class="col-sm-12 col-xl-12 main_lead">
	<div class="col-sm-6 float-left heading" >
		<div><b>Name:</b> <?php echo $spam_lead->name; ?></div>
	</div>
	
	<div class="col-sm-6  float-left heading">
		<div><b>Email:</b> <a href="mailto:<?=$spam_lead->email?>"><?=$spam_lead->email?></a></div>
	</div>
	
	<div class="col-sm-6 float-left heading" >
		<div><b>Phone:</b> <a href="tel:<?=$spam_lead->phone?>"><?=$spam_lead->phone?></a></div>
	</div>
	
	<div class="col-sm-6 float-left heading" >
		<div><b>School:</b> <?php  echo $spam_lead->school ; ?></div>
	</div>
	
	<?php if(!empty($spam_lead->trial_name)){ ?>
	<div class="col-sm-6  float-left heading">
		<div><b>Trial Offer:</b> <?php echo $spam_lead->trial_name; ?></div>
	</div>
	<?php } ?>
	
	<div class="col-sm-6 float-left heading" >
		<div><b>Spam Country Name:</b> <?php echo $spam_lead->spam_api_country_name; ?></div>
	</div>
	
	<div class="col-sm-6  float-left heading">
		<div><b>Network Type:</b> <?php  echo $spam_lead->ip_network_type ; ?></div>
	</div>
	
	
	<div class="col-sm-6 float-left heading" >
		<div><b>Program:</b> <?php echo $spam_lead->program; ?></div>
	</div>
	
	<div class="col-sm-6  float-left heading">
		<div><b>Date:</b> <?php echo date('M d, Y ', strtotime($spam_lead->created_at)); ?></div>
	</div>
	
	
	<div class="col-sm-6 float-left heading" >
		<div><b>Page Url:</b> <?php echo $spam_lead->page_url; ?></div>
	</div>
	
	<div class="col-sm-6  float-left heading">
		<div><b>Message:</b> <?php echo $spam_lead->message; ?></div>
	</div>
	
	
	<div class="col-sm-6 float-left heading" >
		<div><b>Client IP Address:</b> <?php echo $spam_lead->ip_address; ?></div>
	</div>
	
	<div class="col-sm-6  float-left heading">
		<div><b>Client Country:</b> <?php echo $spam_lead->country_name; ?></div>
	</div>
	
	
</div>
<?php } ?>
</div>
