<div class="modal-body edit-form">
<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">




<div class=" form_error_msg" style="display:none">Please fill required fields and save again..</div>


<div class="form-light-holder">
	<h1>Api Name</h1>
	<input type="text" value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->api_name : ''; ?>" name="api_name"  id="webhook_title" class="required_field" placeholder="Enter Api Name Here"  />
</div>
<div class="form-light-holder">
	<h1>Api Type</h1>
	<select name="type" class="field">
		<option value="unbounce" <?php echo (isset($webhook_api_detail->type) && $webhook_api_detail->type == "unbounce") ? 'selected=selected' : '' ?>>Unbounce</option>
		<option value="zenplanner" <?php echo (isset($webhook_api_detail->type) && $webhook_api_detail->type == "zenplanner") ? 'selected=selected' : '' ?>>Zenplanner</option>
	</select>
</div>

<div class="form-new-holder required_mapping_fields">
		<a id="status" class="required_mapping_fields_checkbox  <?php if(!empty($webhook_api_detail) && $webhook_api_detail->required_mapping_fields == 1) echo "check-on"; else echo "check-off"; ?>" checkbox_value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->required_mapping_fields : 0; ?>"></a>
		<h1 class="inline">Required Mapping Fields?</h1>
		<input type="hidden" value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->required_mapping_fields : 0; ?>" name="required_mapping_fields" class="required_mapping_fields_hidden_cb" />
</div>


 <div class="form-light-holder field_mapping_box">
        <h1><b>Field Name Mapping</b></h1>
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<h1> Dojo field name </h1>
				<input value="first_name" class="field"  type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
			<h1> Api field name </h1>
				<input name="first_name" class="field" type="text" value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->name_key : ''; ?>">
			</div>
			</div>
			
			
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="last_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->last_name_key : ''; ?>" name="last_name" class="field" type="text">
			</div>
		</div>
		
		
			
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="email" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->email_key : ''; ?>" name="email" class="field" type="text">
			</div>
		</div>
			
			
			
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="phone" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->phone_key : ''; ?>" name="phone" class="field" type="text">
			</div>
		</div>
			
			
				
			
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="location" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->location_key : ''; ?>" name="location" class="field" type="text">
			</div>
		</div>
			
			
			
				
			
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="message" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->message_key : ''; ?>" name="message" class="field" type="text">
			</div>
		</div>
		
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="program" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->program_key : ''; ?>" name="program" class="field" type="text">
				
			</div>
		</div>
		
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="ip_address" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->ip_address_key : ''; ?>" name="ip_address" class="field" type="text">
			</div>
		</div>
		
		
		
		
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="page_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->page_name_key : ''; ?>" name="page_name" class="field" type="text">
			</div>
		</div>
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="page_id" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->page_id_key : ''; ?>" name="page_id" class="field" type="text">
			</div>
		</div>
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="page_url" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->page_url_key : ''; ?>" name="page_url" class="field" type="text">
			</div>
		</div>
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="variant" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->variant_key : ''; ?>" name="variant" class="field" type="text">
			</div>
		</div>
		
		
		
		
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="school_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->school_name_key : ''; ?>" name="school_name" class="field" type="text">
			</div>
		</div>
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="school_url" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->school_url_key : '';; ?>" name="school_url" class="field" type="text">
			</div>
		</div>
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="inquiry_date" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->inquiry_date_key : ''; ?>" name="inquiry_date" class="field" type="text">
			</div>
		</div>
		<div class=" d-md-flex  dual_input">
			<div class="adsUrl form-group">
				<input value="last_updated" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget form-group">
				<input value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->last_updated_key : ''; ?>" name="last_updated" class="field" type="text">
				
				<p style="color:red;font-size:12px;"> Note: Please fill the API field name, if not filled <strong>Dojo field name</strong> will be considered.</p>
			</div>
		</div>
		
			
		
    </div>
	
	

<input type="hidden" name="update" value="Save" class="" />
<?php if($action_type == "edit" && !empty($item_id)){ ?>
	<input type="hidden" name="item_id" value="<?php echo $item_id; ?>" class="" />
<?php } ?>
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
<style>
.deleteCurrentRow img {
	margin-top: 40px !important;
}
</style>
<script language="javascript" type="text/javascript">
 	
	
	
$(document).ready(function(){

	if($('.required_mapping_fields_hidden_cb').val() == 1){
		$('.field_mapping_box').show();
	}else{
		$('.field_mapping_box').hide();
	}

	$("body").on('click','.deleteCurrentRow',function(){
		$(this).parent().parent().remove();
	});


$(".required_mapping_fields_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".required_mapping_fields_hidden_cb").val("0");
		
		$(this).attr('checkbox_value',0);
		$('.field_mapping_box').hide();
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".required_mapping_fields_hidden_cb").val("1");
		
		$(this).attr('checkbox_value',1);
		
		$('.field_mapping_box').show();
	}

	});
	

})
</script>