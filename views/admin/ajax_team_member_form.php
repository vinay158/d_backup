<div class="modal-body edit-form">
<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">




<div class=" form_error_msg" style="display:none">Please fill required fields and save again..</div>


<div class="form-light-holder">
	<h1>Name</h1>
	<input type="text" value="<?php echo !empty($detail) ? $this->query_model->getStrReplaceAdmin($detail->name) : ''; ?>" name="name" id="name" class="field required_field" placeholder="Enter your name here"/>
</div>
<div class="form-light-holder">
	<h1>Designation</h1>
	<input type="text" name="designation" value="<?php echo !empty($detail) ? $this->query_model->getStrReplaceAdmin($detail->designation) : ''; ?>" class="field required_field">
</div>

<div class="form-new-holder required_mapping_fields">
		<a id="status" class="required_mapping_fields_checkbox  <?php if(!empty($detail) && $detail->published == 1) echo "check-on"; else echo "check-off"; ?>" checkbox_value="<?php echo !empty($detail) ? $detail->published : 0; ?>"></a>
		<h1 class="inline"> Publish?</h1>
		<input type="hidden" value="<?php echo !empty($detail) ? $detail->published : 0; ?>" name="published" class="required_mapping_fields_hidden_cb" />
</div>


<input type="hidden" name="update" value="Save" class="" />
<?php if($action_type == "edit" && !empty($item_id)){ ?>
	<input type="hidden" name="item_id" value="<?php echo $item_id; ?>" class="" />
<?php } ?>
<input type="hidden" name="table_name" value="<?php echo $table_name; ?>" class="" />
<input type="hidden" name="location_id" value="<?php echo $location_id; ?>" class="" />
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

