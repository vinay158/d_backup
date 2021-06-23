<div class="modal-body edit-form">
<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">




<div class=" form_error_msg" style="display:none">Please fill required fields and save again..</div>

<?php if(!empty($link_type) && $link_type == 'albums'){ ?>


<div class="form-item">
<?php 
	$selected_category = !empty($detail) ? $detail->parent_id : 0;
	$selected_item_id = ($action_type == "edit" && !empty($item_id)) ?  $item_id : 0;
	
?>

	<h1>Category <?php echo $selected_item_id; ?></h1>
	<select id="parent_id" name="parent_id" class="field">
	<option value="0">-Select Category-</option>
	<?php echo $this->query_model->getCategoryDropdownOptions('videos',0, 0,$selected_category,$selected_item_id); ?>
	</select>
</div>
<?php } ?>

<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" name="name" id="cat_title" class="field  required_field" value="<?php echo !empty($detail) ? $detail->cat_name : ''; ?>">
</div>

<div class="form-light-holder">
	<h1>Description</h1>
	<textarea rows="4" cols="50" name="description" id="cat_description"><?php echo !empty($detail) ? $detail->description : ''; ?></textarea>
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
<input type="hidden" name="form_type" id="alt_row_form_type" value="<?php echo $form_type; ?>" class="" />
<input type="hidden" name="cat_type" value="videos" class="" />
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