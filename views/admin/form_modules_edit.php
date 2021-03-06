<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>



<div class="az-content-body-left advanced_page custom_full_page form_modules_edit_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?> : <?php echo $details->name; ?></h2>
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
<div class="mb-3 main-content-label page_main_heading"><?php echo $title; ?> : <?php echo $details->name; ?></div>

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" name="name" class="field full_width_input" value="<?php echo !empty($details) ? $details->name : ''; ?>" required="true">
</div>

<div class="form-light-holder">
<h1>Use System Auto-Responders or use a connected API?</h1>

<div class="row row-xs align-items-center">
	
	<div class="col-md-12  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
	
		<?php
		$selectedConnectedApis = (!empty($details) && !empty($details->connected_type)) ? explode(', ',$details->connected_type) : '';

		 if(!empty($email_auto_responder_apis)){ ?>
			<?php foreach($email_auto_responder_apis as $email_auto_responder_api){
				$display_email_api = 1;
					if($email_auto_responder_api->value == "Active Campaign"){
						$display_email_api = (!empty($activecampaignResult) && ($activecampaignResult[0]->type == 1)) ? 1 : 0;
					}elseif($email_auto_responder_api->value == "MailChimp"){
						$display_email_api = (!empty($mailchimpResult) && ($mailchimpResult[0]->type == 1)) ? 1 : 0;
					}else{
						$display_email_api = 1;
					}
					
					if($display_email_api == 1){
				?>
			<div class="col-lg-12">
			  <label class="rdiobox">
					<input type="radio" class="connected_type" name="connected_type"  webhook_api="0" value="<?php echo $email_auto_responder_api->value; ?>" <?php echo (!empty($selectedConnectedApis) && in_array($email_auto_responder_api->value ,$selectedConnectedApis)) ? 'checked=checked' : '' ?>><span><?php echo $email_auto_responder_api->display_name ?></span>
			  </label>
			</div>
			<?php } ?>
		<?php } } ?>
		
	
	<?php 
			if(!empty($webhookApisResult)){
				foreach($webhookApisResult as $webhookApi){
					if($webhookApi->api_type == "Email Auto-Responders"){
		?>
		<div class="col-lg-12">
			  <label class="rdiobox">
			<input type="radio" class="connected_type" name="connected_type" webhook_api="1" value="<?php echo $webhookApi->api_name ?>" webhook_api_id="<?php echo $webhookApi->id ?>"  <?php echo (!empty($selectedConnectedApis) && in_array($webhookApi->api_name ,$selectedConnectedApis)) ? 'checked=checked' : '' ?>><span><?php echo $webhookApi->api_name ?></span>
			</label>
			</div>
			
	<?php } } } ?>



		</div>
		
		</div>
		
	</div>
</div>


</div>


<?php  if(!empty($webhook_apis_tags)){ ?>
	<div class="form-light-holder emailWebhookApiTags" style="display:none">
		<h1>Choose Webhook Outgoing API's Tags</h1>
		<div class="row row-xs align-items-center">
		<?php 
			$selected_email_webhook_api_tags = !empty($details->email_webhook_api_tags) ? unserialize($details->email_webhook_api_tags) : '';
		?>
		
		<?php 
			foreach($webhook_apis_tags as $tag){
				
				$webhook_apis_connected = !empty($tag->webhook_apis) ? unserialize($tag->webhook_apis) : '';
				$webhook_apis_class= '';
				if(!empty($webhook_apis_connected)){
					foreach($webhook_apis_connected as $webhook_apis_connect){
						//$webhook_apis_class .= 'email_webhook_api_'.$webhook_apis_connect.' ';
						$webhook_apis_connect_id = $webhook_apis_connect;
						if($multi_webhook == 1){
							$this->db->select(array('id','api_name','parent_id'));
							$webhookDetail = $this->query_model->getBySpecific('tbl_webhook_apis','id',$webhook_apis_connect);
							if(!empty($webhookDetail)){
								$webhook_apis_connect_id = ($webhookDetail[0]->parent_id == 0) ? $webhook_apis_connect : $webhookDetail[0]->parent_id;
							}
						}
						
						$webhook_apis_class .= 'email_webhook_api_'.$webhook_apis_connect_id.' ';
					}
				}
		?>
		<div class="col-md-4 tag_box email_webhook_api_tags <?php echo $webhook_apis_class ?>">
			<label class="ckbox">
			<input type="checkbox" name="email_webhook_api_tags[]"  value="<?php echo $tag->id; ?>" <?php echo (in_array($tag->id, $selected_email_webhook_api_tags)) ? 'checked=checked' : '' ?>><span> <?php echo $tag->tag; ?> </span>
			</label>
		</div>
		<?php } ?>
	</div>
</div>
<?php }  ?>




	<!--<input type="radio" class="connected_type" name="connected_type" value="local" <?php echo ($details->connected_type == "local") ? "checked=checked" : ''; ?>>Local <br/>
	
	<?php if(!empty($activecampaignResult) && $activecampaignResult[0]->type == 1){ ?>
		<input type="radio" class="connected_type" name="connected_type" value="Active Campaign" <?php echo ($details->connected_type == "Active Campaign") ? "checked=checked" : ''; ?>>Active Campaign <br/>
	<?php } ?>
	
	<?php if(!empty($mailchimpResult) && $mailchimpResult[0]->type == 1){ ?>
		<input type="radio" class="connected_type" name="connected_type" value="MailChimp" <?php echo ($details->connected_type == "MailChimp") ? "checked=checked" : ''; ?>>MailChimp <br/>
	<?php } ?>
	
	<?php if(!empty($kicksiteResult) && $kicksiteResult[0]->type == 1){ ?>
		<input type="radio" class="connected_type" name="connected_type" value="Kicksite" <?php echo ($details->connected_type == "Kicksite") ? "checked=checked" : ''; ?>>Kicksite <br/>
	<?php } ?>
	
	<?php if(!empty($rainmakerResult) && $rainmakerResult[0]->type == 1){ ?>
		<input type="radio" class="connected_type" name="connected_type" value="Rainmaker" <?php echo ($details->connected_type == "Rainmaker") ? "checked=checked" : ''; ?>>Rainmaker <br/>
	<?php } ?>
	
	<?php 
		if(!empty($webhookApisResult)){
			foreach($webhookApisResult as $webhookApi){
	?>
		<input type="radio" class="connected_type" name="connected_type" value="<?php echo $webhookApi->api_name ?>" <?php echo ($details->connected_type == $webhookApi->api_name) ? "checked=checked" : ''; ?>><?php echo $webhookApi->api_name ?><br/>
		<?php } } ?>
	
	<input type="radio" class="connected_type" name="connected_type" value="No AutoResponders" <?php echo ($details->connected_type == "No AutoResponders") ? "checked=checked" : ''; ?>>No Auto-Responders <br/> -->





<div class="activeCampaignBox">
<?php /* if(!empty($active_campagin_automation_list)){ ?>
	<div class="form-light-holder " style="">
			<h1>Automation Lists</h1>
			<select name="active_campaign_automation_id" id="" class="field " >
				<option value="0">-select Automation -</option>
				<?php foreach($active_campagin_automation_list as $automation_list){ ?>
				<option value="<?= $automation_list['id']; ?>"  <?php if(!empty($details)){ if($details->active_campaign_automation_id == $automation_list['id']){ echo 'selected=selected'; } } ?>><?= $automation_list['name']; ?></option>
				<?php } ?>
			</select>
	</div>
<?php } */ ?>

<?php /*if(!empty($active_campagin_lists_list)){ ?>
	<div class="form-light-holder " style="">
			<h1>Lists</h1>
			<select name="active_campaign_list_id" id="" class="field " >
				<?php foreach($active_campagin_lists_list as $list){ ?>
				<option value="<?= $list['id']; ?>"  <?php if(!empty($details)){ if($details->active_campaign_list_id == $list['id']){ echo 'selected=selected'; } } ?>><?= $list['name']; ?></option>
				<?php } ?>
			</select>
	</div>
<?php } */ ?>
</div>
</div>



<?php if(!empty($mailchimp_templates)){ ?>
	<div class="form-light-holder mailchimpBox">
			<h1>Email Provider List</h1>
			<select name="mailchimp_template_id" id="" class="field " >
				<option value="">-Select-</option>
				<?php foreach($mailchimp_templates as $template){ ?>
				<option value="<?= $template['id']; ?>"  <?php if(!empty($details)){ if($details->mailchimp_template_id == $template['id']){ echo 'selected=selected'; } } ?>><?= $template['name']; ?></option>
				<?php } ?>
			</select>
	</div>
<?php } ?>

<?php if(!empty($active_campaign_tags)){ ?>
<div class="form-light-holder active_campaign_tags">
	<h1>Choose Active Campaign Tags</h1>
	<div class="row row-xs align-items-center">
	<?php $selected_active_campaign_tags = !empty($details->active_campaign_tags) ? unserialize($details->active_campaign_tags) : '' ?>
	<?php foreach($active_campaign_tags as $tag){ ?>
		<div class="col-md-4 tag_box">
			<label class="ckbox">
				<input type="checkbox" name="active_campaign_tags[]" value="<?php echo $tag->id; ?>" <?php echo (in_array($tag->id, $selected_active_campaign_tags)) ? 'checked=checked' : '' ?>><span><?php echo $tag->tag; ?> </span>
			</label>
		</div>
	<?php } ?>
	</div>
</div>
<?php } ?>

<?php if(!empty($sparkpost_mail_flows)){ ?>
<div class="form-light-holder sparkpost_mail_flows">
	<h1>Choose Sparkpost Email Flow</h1>
	<div class="row row-xs align-items-center">
	<?php $selected_sparkpost_mail_flow_id = !empty($details->sparkpost_mail_flow_id) ? $details->sparkpost_mail_flow_id : '' ?>
	<?php foreach($sparkpost_mail_flows as $sparkpost_mail_flow){ ?>
		<div class="col-md-4 tag_box">
			<label class="rdiobox">
				<input type="radio" name="sparkpost_mail_flow_id" value="<?php echo $sparkpost_mail_flow->id; ?>" <?php echo ($sparkpost_mail_flow->id == $selected_sparkpost_mail_flow_id) ? 'checked=checked' : '' ?>><span><?php echo $sparkpost_mail_flow->title; ?> </span>
			</label>
		</div>
	<?php } ?>
	</div>
</div>
<?php } ?>


<div class="form-light-holder form2checkbox userEmailOptionCheckbox">

	<a id="published" class="checkbox2 <?php echo (!empty($details) && $details->user_email_option == 1) ? 'check-on' : 'check-off'; ?>"></a>
<h1 class="inline">Send System Lead Auto Responder Email?</h1>
	

	<input type="hidden" value="<?php echo (!empty($details) && $details->user_email_option == 1) ? 1 : 0; ?>" name="user_email_option" class="hidden_cb2" />
	<br><em style="font-size:11px">Note: If this is off, no email will be sent from our system to the lead. If this is on, you can choose which lead auto responder to send below in the dropdown.</em>

</div>

<div class="form-light-holder adminAutoRespondersBox"  style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Choose Admin Auto-Responders</h1>
			<select class="field" name="admin_auto_responder_id" required>
				<option value="">-- Select --</option>
				<?php foreach($admin_auto_responders as $auto_responders){  ?>
				<option value="<?php echo $auto_responders->id; ?>" <?php echo ($details->admin_auto_responder_id == $auto_responders->id) ? "selected=selected" : ''; ?>><?php echo $auto_responders->title; ?></option>
				<?php } ?>
			</select>
		<div>
		</div>
</div>
<div class="form-light-holder customerAutoRespondersBox" style="overflow:auto;" >
			<h1 style="padding-bottom: 5px;">Choose Lead Auto-Responders</h1>
			<select class="field" name="customer_auto_responder_id" id="customer_auto_responder_id">
				<option value="">-- Select --</option>
				<?php foreach($customer_auto_responders as $auto_responders){  ?>
				<option value="<?php echo $auto_responders->id; ?>" <?php echo ($details->customer_auto_responder_id == $auto_responders->id) ? "selected=selected" : ''; ?>><?php echo $auto_responders->title; ?></option>
				<?php } ?>
			</select>
		<div>
		</div>
</div>
<div class="form-light-holder customerAutoRespondersBox" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Choose Email Signature</h1>
			<select class="field" name="email_signature_location_id">
			<option value="">-Select-</option>
				<?php foreach($email_sign_locations as $location){  ?>
				<option value="<?php echo $location->id; ?>" <?php echo ($details->email_signature_location_id == $location->id) ? "selected=selected" : ''; ?>><?php echo $location->name; ?></option>
				<?php } ?>
			</select>
		<div>
		</div>
</div>




<?php if(!empty($thankyou_pages)){ ?>
	<div class="form-light-holder">
			<h1>Thank you Pages</h1>
			<select name="thankyou_page_id" id="" class="field " >
				<option value="0">-Select-</option>
				<?php foreach($thankyou_pages as $thankyou_page){ ?>
				<option value="<?= $thankyou_page->id; ?>"  <?php if(!empty($details)){ if($details->thankyou_page_id == $thankyou_page->id){ echo 'selected=selected'; } } ?>><?= $thankyou_page->title; ?></option>
				<?php } ?>
			</select>
	</div>
<?php } ?>


<div class="form-light-holder">
<h1>CRM APIs</h1>
<div class="row row-xs align-items-center">
	
	<div class="col-md-12  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
	
	<div class="col-lg-12">
			  <label class="rdiobox">
	<input type="radio" class="connected_type_crm" name="connected_type_crm"  value="" <?php echo (!empty($selectedConnectedApis) && !isset($selectedConnectedApis[1])) ? 'checked=checked' : '' ?>><span> None 
	</span>
			</label>
			</div>
	
<?php if(!empty($crm_apis)){ ?>
	<?php foreach($crm_apis as $crm_api){ 
			$display_email_api = 1;
			if($crm_api->value == "Kicksite"){
				$display_email_api = (!empty($kicksiteResult) && ($kicksiteResult[0]->type == 1)) ? 1 : 0;
			}elseif($crm_api->value == "Rainmaker"){
				$display_email_api = (!empty($rainmakerResult) && ($rainmakerResult[0]->type == 1)) ? 1 : 0;
			}else{
				$display_email_api = 1;
			}
			
			if($display_email_api == 1){
	?>
	<div class="col-lg-12">
			  <label class="rdiobox">
		<input type="radio" class="connected_type_crm" name="connected_type_crm" webhook_api="0"   value="<?php echo $crm_api->value; ?>"   <?php echo (!empty($selectedConnectedApis) && in_array($crm_api->value ,$selectedConnectedApis)) ? 'checked=checked' : '' ?> > <span><?php echo $crm_api->display_name ?> </span>
			</label>
			</div>
	<?php } } ?>
<?php } ?>
<?php 
		if(!empty($webhookApisResult)){
			foreach($webhookApisResult as $webhookApi){
				if($webhookApi->api_type == "CRM"){
	?>
	<div class="col-lg-12">
		<label class="rdiobox">
		<input type="radio" class="connected_type_crm" name="connected_type_crm" value="<?php echo $webhookApi->api_name ?>" webhook_api="1" webhook_api_id="<?php echo $webhookApi->id ?>"  <?php echo (!empty($selectedConnectedApis) && in_array($webhookApi->api_name ,$selectedConnectedApis)) ? 'checked=checked' : '' ?>> <span><?php echo $webhookApi->api_name ?></span>
		</label>
	</div>
		
<?php } } } ?>

		</div>
		
		</div>
		
	</div>
</div>


<?php  if(!empty($webhook_apis_tags)){ ?>
	<div class="form-light-holder crmWebhookApiTags" style="display:none">
		<h1>Choose Webhook Outgoing API's Tags</h1>
		<div class="row row-xs align-items-center">
		<?php 
			$selected_crm_webhook_api_tags = !empty($details->crm_webhook_api_tags) ? unserialize($details->crm_webhook_api_tags) : '';
		?>
		
		<?php 
			foreach($webhook_apis_tags as $tag){
				
				$webhook_apis_connected = !empty($tag->webhook_apis) ? unserialize($tag->webhook_apis) : '';
				
				$webhook_apis_class= '';
				if(!empty($webhook_apis_connected)){
					foreach($webhook_apis_connected as $webhook_apis_connect){
						$webhook_apis_connect_id = $webhook_apis_connect;
						if($multi_webhook == 1){
							$this->db->select(array('id','api_name','parent_id'));
							$webhookDetail = $this->query_model->getBySpecific('tbl_webhook_apis','id',$webhook_apis_connect);
							if(!empty($webhookDetail)){
								$webhook_apis_connect_id = ($webhookDetail[0]->parent_id == 0) ? $webhook_apis_connect : $webhookDetail[0]->parent_id;
							}
						}
						
						$webhook_apis_class .= 'crm_webhook_api_'.$webhook_apis_connect_id.' ';
					}
				}
		?>
		<div class="col-md-4 tag_box crm_webhook_api_tags <?php echo $webhook_apis_class ?>">
			<label class="ckbox">
			
			<span class="crm_webhook_api_tags <?php echo $webhook_apis_class ?>"><input type="checkbox" name="crm_webhook_api_tags[]"  value="<?php echo $tag->id; ?>" <?php echo (in_array($tag->id, $selected_crm_webhook_api_tags)) ? 'checked=checked' : '' ?>><span><?php echo $tag->tag; ?> </span>
			</label>
		</div>
		<?php } ?>
	</div>
</div>
<?php }  ?>

	


<?php if(!empty($active_rainmaker_tags)){ ?>
<div class="form-light-holder rainmaker_tags">
	<h1>Choose Rainmaker Tags</h1>
	<div class="row row-xs align-items-center">
		<?php $selected_rainmaker_tags = !empty($details->active_rainmaker_tags) ? unserialize($details->active_rainmaker_tags) : '' ?>
		
		<?php foreach($active_rainmaker_tags as $tag){ ?>
		<div class="col-md-4 tag_box">
			<label class="ckbox">
		<input type="checkbox" name="active_rainmaker_tags[]" value="<?php echo $tag->id; ?>" <?php echo (in_array($tag->id, $selected_rainmaker_tags)) ? 'checked=checked' : '' ?>><span><?php echo $tag->tag; ?> </span>
			</label>
		</div>
		<?php } ?>
	</div>
</div>
<?php } ?>


<?php if(!empty($page_instances)){ ?>
<div class="clearfix"></div>
<div class="form-light-holder   row row-xs align-items-center form-module  page-instance">
	<div class="col-md-12"><h1>Page Instances</h1></div>
	<?php if(!empty($page_instances)){ ?>
	
		<?php 
			$i = 1;
			foreach($page_instances as $page_instance){ ?>
			<div class="col-md-4 form_instance  <?php echo (!empty($form_instances) && count($form_instances) >= 10) ? 'morethan10' : ''; ?>  <?php echo ($i >= 10) ? 'bigval' : 'smallval'; ?>"><span><?php echo $i; ?></span> <?php echo $page_instance->page_name; ?></div>
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


<script>
	$(window).load(function(){
		//var connected_type = $(".connected_type").val();
		//var connected_type = $('input[name=connected_type] :checked', '.connected_type').val();
		var connected_type= $('input[name="connected_type"]:checked').val();
		var webhook_api = $('input[name="connected_type"]:checked').attr('webhook_api');
		var webhook_api_id = $('input[name="connected_type"]:checked').attr('webhook_api_id');
		var connected_type_crm = $('input[name="connected_type_crm"]:checked').val();
		var crm_webhook_api = $('input[name="connected_type_crm"]:checked').attr('webhook_api');
		var crm_webhook_api_id = $('input[name="connected_type_crm"]:checked').attr('webhook_api_id');
		
		 $('.sparkpost_mail_flows').hide();
		// $('.emailWebhookApiTags').hide();
		 //$('.crmWebhookApiTags').hide();
			if(connected_type == "Active Campaign"){
				$('.activeCampaignBox').show();
				$('.mailchimpBox').hide();
				//$('.adminAutoRespondersBox').hide();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').show();
				//$('.rainmaker_tags').hide();
			}else if(connected_type == "Sparkpost Email"){
				$('.activeCampaignBox').hide();
				$('.mailchimpBox').hide();
				//$('.adminAutoRespondersBox').hide();
				$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				$('.sparkpost_mail_flows').show();
				//$('.rainmaker_tags').hide();
			}else if(connected_type == "MailChimp"){
				$('.mailchimpBox').show();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				//$('.rainmaker_tags').hide();
			}/*else if(connected_type == "Rainmaker"){
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').show();
			}else if(connected_type == "Kicksite"){
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
			}*/
			else if(connected_type == "No AutoResponders"){
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').hide();
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
			}else{
				
				if(webhook_api == 1){
					$('.mailchimpBox').hide();
					$('.activeCampaignBox').hide();
					//$('.adminAutoRespondersBox').show();
					$('.userEmailOptionCheckbox').show();
					$('.customerAutoRespondersBox').hide();
					$('.active_campaign_tags').hide();
					//$('.rainmaker_tags').hide();
					
					$('.emailWebhookApiTags').show();
					$('.email_webhook_api_tags').hide();
					$('.email_webhook_api_'+webhook_api_id).show();
					
					
				}else{
					$('.mailchimpBox').hide();
					$('.activeCampaignBox').hide();
					//$('.adminAutoRespondersBox').show();
					$('.userEmailOptionCheckbox').hide();
					$('.customerAutoRespondersBox').show();
					$('.active_campaign_tags').hide();
					$('.rainmaker_tags').hide();
					$('.emailWebhookApiTags').hide();
				}
				
			}


		 if(connected_type_crm == "Rainmaker"){
				//$('.adminAutoRespondersBox').show();
				/*$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();*/
				$('.rainmaker_tags').show();
			}else if(connected_type_crm == "Kicksite"){
				//$('.adminAutoRespondersBox').show();
				/*$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();*/
				$('.rainmaker_tags').hide();
			}else{
				
				//$('.adminAutoRespondersBox').show();
				/*$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').show();
				$('.active_campaign_tags').hide(); */
				$('.rainmaker_tags').hide();
				if(crm_webhook_api == 1){
					$('.crmWebhookApiTags').show();
					$('.crm_webhook_api_tags').hide();
					$('.crm_webhook_api_'+crm_webhook_api_id).show();
				}
			} 
			
			
	var send_user_email_option = $('.hidden_cb2').val();
	if(send_user_email_option == 1){
		$('.customerAutoRespondersBox').show();
	}else{
		$('.customerAutoRespondersBox').hide();
	}
			
	});
	$(document).ready(function(){
		$(".connected_type").click(function(){
			var connected_type = $(this).val();
			var webhook_api = $(this).attr('webhook_api');
			var webhook_api_id = $('input[name="connected_type"]:checked').attr('webhook_api_id');
			$('.emailWebhookApiTags').hide();
			$('.sparkpost_mail_flows').hide();
			
			if(connected_type == "Active Campaign"){
				$('.activeCampaignBox').show();
				$('.mailchimpBox').hide();
				//$('.adminAutoRespondersBox').hide();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').show();
				//$('.rainmaker_tags').hide();
			}else if(connected_type == "Sparkpost Email"){
				$('.activeCampaignBox').hide();
				$('.mailchimpBox').hide();
				//$('.adminAutoRespondersBox').hide();
				$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				$('.sparkpost_mail_flows').show();
				//$('.rainmaker_tags').hide();
			}else if(connected_type == "MailChimp"){
				$('.mailchimpBox').show();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				//$('.rainmaker_tags').hide();
			}/*else if(connected_type == "Rainmaker"){
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').show();
			}else if(connected_type == "Kicksite"){
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
			}*/
			else if(connected_type == "No AutoResponders"){
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').hide();
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
			}else{
				if(webhook_api == 1){
					$('.mailchimpBox').hide();
					$('.activeCampaignBox').hide();
					//$('.adminAutoRespondersBox').show();
					$('.userEmailOptionCheckbox').show();
					$('.customerAutoRespondersBox').hide();
					$('.active_campaign_tags').hide();
					//$('.rainmaker_tags').hide();
					$('.emailWebhookApiTags').show();
					$('.email_webhook_api_tags').hide();
					$('.email_webhook_api_'+webhook_api_id).show();
					
					
				}else{
					$('.mailchimpBox').hide();
					$('.activeCampaignBox').hide();
					//$('.adminAutoRespondersBox').show();
					$('.userEmailOptionCheckbox').hide();
					$('.customerAutoRespondersBox').show();
					$('.active_campaign_tags').hide();
					$('.rainmaker_tags').hide();
					$('.emailWebhookApiTags').hide();
				}
				
			} 
			
			if(connected_type == "Active Campaign" || connected_type == "MailChimp" || connected_type == "Sparkpost Email"){
				$('.checkbox2').addClass('check-off');
				$('.checkbox2').removeClass('check-on');
				$('.hidden_cb2').val(0);
			} 
			
		});
		
	// crm apis
	$(".connected_type_crm").click(function(){
			var connected_type = $(this).val();
			var crm_webhook_api = $(this).attr('webhook_api');
			var crm_webhook_api_id = $('input[name="connected_type_crm"]:checked').attr('webhook_api_id');
			 $('.crmWebhookApiTags').hide();
			
			 if(connected_type == "Rainmaker"){
				
				//$('.adminAutoRespondersBox').show();
				/*$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();*/
				$('.rainmaker_tags').show();
			}else if(connected_type == "Kicksite"){
				//$('.adminAutoRespondersBox').show();
				/*$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();*/
				$('.rainmaker_tags').hide();
			}else{
				
				//$('.adminAutoRespondersBox').show();
				/*$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').show();
				$('.active_campaign_tags').hide(); */
				$('.rainmaker_tags').hide();
				
				if(crm_webhook_api == 1){
					$('.crmWebhookApiTags').show();
					$('.crm_webhook_api_tags').hide();
					$('.crm_webhook_api_'+crm_webhook_api_id).show();
				}
			} 
			
			if(connected_type == "Kicksite" || connected_type == "Rainmaker"){
				$('.checkbox2').addClass('check-off');
				$('.checkbox2').removeClass('check-on');
				$('.hidden_cb2').val(0);
			} 
			
			
			
		});
		
		
		
		
		$(".form2checkbox .checkbox2").click(function(){

			if($(this).hasClass("check-on")){

				$(this).removeClass("check-on");

				$(this).addClass("check-off");

				$(this).parents(".form2checkbox").children(".hidden_cb2").val("0");

				$('.customerAutoRespondersBox').hide();
				$('#customer_auto_responder_id').attr('required',false);
			}

			else

			{

				$(this).removeClass("check-off");

				$(this).addClass("check-on");

				$(this).parents(".form2checkbox").children(".hidden_cb2").val("1");
				
				$('.customerAutoRespondersBox').show();
				$('#customer_auto_responder_id').attr('required',true);
			}

		})

	});
</script>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
