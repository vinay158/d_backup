<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name"><?php echo $title; ?> :- <?php echo $details->name; ?></div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" name="name" value="<?php echo !empty($details) ? $details->name : ''; ?>" required="true">
</div>

<div class="form-light-holder">
	<h1>Use System Auto-Responders or use a connected API?</h1>
	<input type="radio" class="connected_type" name="connected_type" value="local" <?php echo ($details->connected_type == "local") ? "checked=checked" : ''; ?>>Local <br/>
	
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
	
	<input type="radio" class="connected_type" name="connected_type" value="No AutoResponders" <?php echo ($details->connected_type == "No AutoResponders") ? "checked=checked" : ''; ?>>No Auto-Responders <br/>
</div>


<?php if(!empty($mailchimp_templates)){ ?>
	<div class="form-light-holder mailchimpBox">
			<h1>Email Provider List</h1>
			<select name="mailchimp_template_id" id="" class="field " >
				<?php foreach($mailchimp_templates as $template){ ?>
				<option value="<?= $template['id']; ?>"  <?php if(!empty($details)){ if($details->mailchimp_template_id == $template['id']){ echo 'selected=selected'; } } ?>><?= $template['name']; ?></option>
				<?php } ?>
			</select>
	</div>
<?php } ?>


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


<div class="form-light-holder form2checkbox userEmailOptionCheckbox">

	<h1 class="inline">Send System Lead Auto Responder Email?</h1>
	<a id="published" class="checkbox2 <?php echo (!empty($details) && $details->user_email_option == 1) ? 'check-on' : 'check-off'; ?>"></a>


	<input type="hidden" value="<?php echo (!empty($details) && $details->user_email_option == 1) ? 1 : 0; ?>" name="user_email_option" class="hidden_cb2" />
	<br><em style="font-size:11px">Note: If this is off, no email will be sent from our system to the lead. If this is on, you can choose which lead auto responder to send below in the dropdown.</em>

</div>

<div class="form-light-holder adminAutoRespondersBox"  style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Choose Admin Auto-Responders</h1>
			<select class="field" name="admin_auto_responder_id">
				<?php foreach($admin_auto_responders as $auto_responders){  ?>
				<option value="<?php echo $auto_responders->id; ?>" <?php echo ($details->admin_auto_responder_id == $auto_responders->id) ? "selected=selected" : ''; ?>><?php echo $auto_responders->title; ?></option>
				<?php } ?>
			</select>
		<div>
		</div>
</div>
<div class="form-light-holder customerAutoRespondersBox" style="overflow:auto;" >
			<h1 style="padding-bottom: 5px;">Choose Lead Auto-Responders</h1>
			<select class="field" name="customer_auto_responder_id">
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
				<?php foreach($email_sign_locations as $location){  ?>
				<option value="<?php echo $location->id; ?>" <?php echo ($details->email_signature_location_id == $location->id) ? "selected=selected" : ''; ?>><?php echo $location->name; ?></option>
				<?php } ?>
			</select>
		<div>
		</div>
</div>

<?php if(!empty($active_campaign_tags)){ ?>
<div class="form-light-holder active_campaign_tags">
	<h1>Choose Active Campaign Tags</h1>
	<?php $selected_active_campaign_tags = !empty($details->active_campaign_tags) ? unserialize($details->active_campaign_tags) : '' ?>
	<?php foreach($active_campaign_tags as $tag){ ?>
	<input type="checkbox" name="active_campaign_tags[]" value="<?php echo $tag->id; ?>" <?php echo (in_array($tag->id, $selected_active_campaign_tags)) ? 'checked=checked' : '' ?>><?php echo $tag->tag; ?> <br/>
	<?php } ?>
</div>
<?php } ?>


<?php if(!empty($active_rainmaker_tags)){ ?>
<div class="form-light-holder rainmaker_tags">
	<h1>Choose Rainmaker Tags</h1>
	<?php $selected_rainmaker_tags = !empty($details->active_rainmaker_tags) ? unserialize($details->active_rainmaker_tags) : '' ?>
	
	<?php foreach($active_rainmaker_tags as $tag){ ?>
	<input type="checkbox" name="active_rainmaker_tags[]" value="<?php echo $tag->id; ?>" <?php echo (in_array($tag->id, $selected_rainmaker_tags)) ? 'checked=checked' : '' ?>><?php echo $tag->tag; ?> <br/>
	<?php } ?>
</div>
<?php } ?>



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

<?php if(!empty($page_instances)){ ?>
<div class="form-light-holder  form-module page-instance">
	<h1>Page Instances:</h1>
	<ul>
	<?php if(!empty($page_instances)){ ?>
	
		<?php foreach($page_instances as $page_instance){ ?>
			<li><?php echo $page_instance->page_name; ?></li>
		<?php } ?>
	<?php } ?>
	</ul>
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

<br style="clear:both"/>


<script>
	$(window).load(function(){
		//var connected_type = $(".connected_type").val();
		//var connected_type = $('input[name=connected_type] :checked', '.connected_type').val();
		var connected_type= $('input[type="radio"]:checked').val();
		
		if(connected_type == "Active Campaign"){
				$('.activeCampaignBox').show();
				$('.mailchimpBox').hide();
				//$('.adminAutoRespondersBox').hide();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').show();
				$('.rainmaker_tags').hide();
			}else if(connected_type == "MailChimp"){
				$('.mailchimpBox').show();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
			}else if(connected_type == "Rainmaker"){
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
			}else if(connected_type == "No AutoResponders"){
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').hide();
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
			}else{
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').show();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
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
			
			if(connected_type == "Active Campaign"){
				$('.activeCampaignBox').show();
				$('.mailchimpBox').hide();
				//$('.adminAutoRespondersBox').hide();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').show();
				$('.rainmaker_tags').hide();
			}else if(connected_type == "MailChimp"){
				$('.mailchimpBox').show();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').show();
				$('.customerAutoRespondersBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
			}else if(connected_type == "Rainmaker"){
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
			}else if(connected_type == "No AutoResponders"){
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').hide();
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
			}else{
				$('.mailchimpBox').hide();
				$('.activeCampaignBox').hide();
				//$('.adminAutoRespondersBox').show();
				$('.userEmailOptionCheckbox').hide();
				$('.customerAutoRespondersBox').show();
				$('.active_campaign_tags').hide();
				$('.rainmaker_tags').hide();
			} 
			
			if(connected_type == "Active Campaign" || connected_type == "MailChimp" || connected_type == "Kicksite" || connected_type == "Rainmaker"){
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
			}

			else

			{

				$(this).removeClass("check-off");

				$(this).addClass("check-on");

				$(this).parents(".form2checkbox").children(".hidden_cb2").val("1");
				
				$('.customerAutoRespondersBox').show();
			}

		})

	});
</script>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
