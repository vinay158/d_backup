<div class="modal-body edit-form ajax_form_tag_form">
<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">




<div class=" form_error_msg" style="display:none">Please fill required fields and save again..</div>


<div class="form-light-holder">
	<h1>Tag Name</h1>
	<input type="text" value="<?php echo !empty($detail) ? $this->query_model->getStrReplaceAdmin($detail->tag) : ''; ?>" name="tag" id="name" class="field required_field" placeholder="Enter your tag here"/>
</div>

<?php if($action_type == "edit"){ ?>
<div class="form-light-holder">
	<h1>Tag Type</h1>
	<select class="field tag_types" name="tag_type">
		<?php foreach($tag_types as $key => $val){ ?>
		<option value="<?php echo $key; ?>" <?php echo (!empty($detail) && $detail->tag_type == $key)? 'selected=select' : ''; ?>><?php echo $val; ?></option>
		<?php } ?>
	</select>
</div>
<?php }else{ ?>

<div class="form-light-holder">
	<h1>Tag Type</h1>
	<select class="field tag_types" name="tag_type">
		<?php foreach($tag_types as $key => $val){ ?>
		<option value="<?php echo $key; ?>" <?php echo ($form_type == $key)? 'selected=select' : ''; ?>><?php echo $val; ?></option>
		<?php } ?>
	</select>
</div>

<?php } ?>

<?php 
if(!empty($webhook_outgoing_apis)){
	$selected_webhook_apis = !empty($detail->webhook_apis) ? unserialize($detail->webhook_apis) : '';
	
?>
<div class="form-light-holder webhook_apis_box" style="overflow:auto; display:<?php echo ((!empty($detail) && $detail->tag_type == "webhook_outgoing_apis") || $form_type == "webhook_outgoing_apis") ? 'block' : 'none'; ?>">
			<h1 style="padding-bottom: 5px;">Webhook Outgoing Api's</h1>
			<div class="align-items-center">
				
			<?php foreach($webhook_outgoing_apis as $key => $webhook_api){ ?>
			<div class="col-md-10 tag_box">
			<label class="ckbox">
			<input type="checkbox" name="webhook_apis[]" value="<?php echo $webhook_api->id; ?>" <?php echo (!empty($selected_webhook_apis) && in_array($webhook_api->id,$selected_webhook_apis)) ? 'checked=checked' : ''; ?>><span><?php echo $webhook_api->api_name; ?> </span>
			</label>
			</div>
			<?php } ?>
		</div>
</div>
<?php } ?>


<?php if($action_type == "edit" && !empty($item_id)){ ?>
	<input type="hidden" name="item_id" value="<?php echo $item_id; ?>" class="" />

<?php 

	$form_instances = $this->query_model->getFormIntancesForTags($detail->id, $detail->tag_type); 
		
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
<?php } ?>


<input type="hidden" name="update" value="Save" class="" />

<input type="hidden" name="table_name" value="<?php echo $table_name; ?>" class="" />
<input type="hidden" name="form_type" id="alt_row_form_type" value="<?php echo $form_type; ?>" class="" />
 </div>
          <div class="modal-footer">
            <div class=" form_error_msg" style="display:none">Please fill required fields and save again..</div>
			<a href="javascript:void(0)" class="btn btn-indigo save_full_row_add_btn">Save</a>
          </div>



		</div>

		</div>

		</div>

	</div>

	</div>




<!------------ recent items ----------------->

<script language="javascript" type="text/javascript">
 	
	
	
$(document).ready(function(){

$(".required_mapping_fields_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".required_mapping_fields_hidden_cb").val("0");
		
		$(this).attr('checkbox_value',0);
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".required_mapping_fields_hidden_cb").val("1");
		
		$(this).attr('checkbox_value',1);
		
	}

	});
	

})
</script>
<script>
<?php if(!empty($webhook_outgoing_apis)){ ?>
	
	$(document).ready(function(){
		$('body').on('change','.tag_types',function(){
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

