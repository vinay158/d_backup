<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Tag</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<div class="form-light-holder">
	<h1>Tag Name</h1>
	<input type="text" value="<?php echo !empty($details)? $this->query_model->getStrReplaceAdmin($details->tag) : ''; ?>" name="tag" required="true" id="name" class="field" placeholder="Enter your tag here" />
</div>




<script>
<?php if(!empty($webhook_outgoing_apis)){ ?>
$(window).load(function(){
		var tag_types = $('.tag_types').val();
		$('.webhook_apis_box').hide();
		$('.webhook_apis').attr('required',false);
		if(tag_types == "webhook_outgoing_apis"){
			$('.webhook_apis_box').show();
			$('.webhook_apis').attr('required',true);
		}
	})
	
	$(document).ready(function(){
		$('.tag_types').change(function(){
			var tag_types = $(this).val();
			//alert(tag_types);
			$('.webhook_apis_box').hide();
			$('.webhook_apis').attr('required',false);
			if(tag_types == "webhook_outgoing_apis"){
				$('.webhook_apis_box').show();
				$('.webhook_apis').attr('required',true);
			}
		})
	})
<?php } ?>
</script>

<div class="form-light-holder" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Tag Type</h1>
			<select class="field tag_types" name="tag_type">
				<?php foreach($tag_types as $key => $val){ ?>
				<option value="<?php echo $key; ?>" <?php echo (!empty($details) && $details->tag_type == $key)? 'selected=select' : ''; ?>><?php echo $val; ?></option>
				<?php } ?>
			</select>
		<div>
		</div>
</div>

<?php 
if(!empty($webhook_outgoing_apis)){
	$selected_webhook_apis = !empty($details->webhook_apis) ? unserialize($details->webhook_apis) : '';
	
?>
<div class="form-light-holder webhook_apis_box" style="overflow:auto; display:none">
			<h1 style="padding-bottom: 5px;">Webhook Outgoing Api's</h1>
			<?php foreach($webhook_outgoing_apis as $key => $webhook_api){ ?>
			<input type="checkbox" name="webhook_apis[]" value="<?php echo $webhook_api->id; ?>" <?php echo (!empty($selected_webhook_apis) && in_array($webhook_api->id,$selected_webhook_apis)) ? 'checked=checked' : ''; ?>><?php echo $webhook_api->api_name; ?> <br/>
			<?php } ?>
		<div>
		</div>
</div>
<?php } ?>


<?php $form_instances = $this->query_model->getFormIntancesForTags($details->id, $details->tag_type); 
		
		if(!empty($form_instances)){ 
?>
<div class="form-light-holder  form-module  page-instance">
	<h1>Form Instances:</h1>
	<ul>
	<?php if(!empty($form_instances)){ ?>
	
		<?php foreach($form_instances as $form_instance){ ?>
			<li><?php echo $form_instance->name; ?></li>
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

<br style="clear:both"		 />


<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
