<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>

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

<!--<div class="form-light-holder">
	<h1>Subject</h1>
	<input type="text" value="<?php echo !empty($details) ? $this->query_model->getStrReplaceAdmin($details->subject) : ''; ?>" name="subject" required="true" id="subject" class="field full_width_input" placeholder="Enter your email subject" style="" />
</div>-->


<div class="form-light-holder" style="overflow:auto;">
		<div class="adsUrl">
			<h1 style="padding-bottom: 5px;">Template Type</h1>
			<select class="field template_type" name="template_type" required="true" >
				<option value="">-Select Template Type-</option>
				<?php foreach($template_types as $key => $template_type){ ?>
					<option value="<?php echo $key; ?>" <?php echo (!empty($details) && $details->template_type == $key) ? 'selected=selected' : ''; ?>><?php echo $template_type; ?></option>
				<?php } ?>
			</select>
			</div>
		<div class="linkTarget send_sms_time_box"  style="display:none">
			<h1 style="padding-bottom: 5px;">Time</h1>
			<select class="field send_sms_time" name="send_sms_time">
				<option value="">-Select Time-</option>
				 <?php foreach($times as $key => $time){ ?>
					<option value="<?php echo $key; ?>" <?php echo ($details->send_sms_time == $key) ? 'selected=selected' : ''; ?>><?php echo $time; ?> </option>
				  <?php } ?>
			</select>
		</div>
</div>



<div class="form-light-holder" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Template</h1>
			<textarea type="text"  name="msg_template" class="text field full_width_input"  rows="10"><?php echo !empty($details) ? $details->msg_template : ''; ?></textarea>
		
</div>

<div class="form-light-holder  row row-xs align-items-center  email_varibles" style="overflow:auto;">
			<div class="col-md-12"><h1 style="padding-bottom: 5px;">Variables:</h1></div>
			<div class="col-md-12"><em>Please use variables in auto responder textarea</em></div>
			
<?php 
	$variablesArr = array(	
						'Common' => array('FIRSTNAME','EMAIL','PHONE','LOCATION','PROGRAM','MESSAGE'),
						'School and Contact'=> array('SITE_TITLE','SCHOOL_OWNER_NAME','CONTACT_NAME','CONTACT_ADDRESS','CONTACT_SUITE','CONTACT_CITY','CONTACT_STATE','CONTACT_ZIP','CONTACT_PHONE','VIEW_MESSAGE_LINK')
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
<input type="hidden" value="<?php echo !empty($details) ? $details->sms_flow_id : 0; ?>" name="sms_flow_id" id="sms_flow_id" class="field"/>
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
	var template_type = $('.template_type').val();
	$('.send_sms_time_box').hide();
	$('.send_sms_time').removeAttr('required');
	if(template_type != "day_1" && template_type != "paid_trial_template" && template_type != "admin_sms_template"){
		$('.send_sms_time_box').show();
		$('.send_sms_time').prop('required',true);
	}
})
	$(document).ready(function(){
		$('.template_type').change(function(){
			var template_type = $(this).val();
			
			$('.send_sms_time_box').hide();
			$('.send_sms_time').removeAttr('required');
			if(template_type != "day_1" && template_type != "paid_trial_template" && template_type != "admin_sms_template"){
				$('.send_sms_time_box').show();
				$('.send_sms_time').prop('required',true);
			}
			
		})
	})
</script>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
