
<div class="modal-body edit-form">
<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		
		<!--<div class="mb-3 main-content-label"><?php echo ucfirst($action_type); ?> Row</div> -->

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">


<div class=" form_error_msg" style="display:none">Please fill required fields..</div>

<div class="form-light-holder">

	<h1>Status Name</h1>

<input type="text" value="<?php echo !empty($detail) ? $detail->title : ''; ?>" name="title" id="" class="field  form_status_title required_field" placeholder="Enter status here"  style=""/>
	
</div>

<div class="form-light-holder">
	<h1 style="padding-top: 5px;">Color Code</h1>
	<input value="<?php echo !empty($detail) ? $detail->color_code : ''; ?>" name="color_code" id="" class="field form_color_code" placeholder="Enter color code here" type="text">
	</div>


 
<input type="hidden" name="update" value="Save" class="" />
<?php if($action_type == "edit" && !empty($item_id)){ ?>
	<input type="hidden" name="item_id" value="<?php echo $item_id; ?>" class="" />
<?php } ?>
<input type="hidden" name="table_name" value="<?php echo $table_name; ?>" class="" />
<input type="hidden" name="form_type" id="alt_row_form_type" value="<?php echo $form_type; ?>" class="" />
 </div>
          <div class="modal-footer">
            
			<a href="javascript:void(0)" class="btn btn-indigo save_full_row_add_btn">Save</a>
          </div>



		</div>

		</div>

		</div>

	</div>

	</div>

<br style="clear:both" /><br />




<!------------ recent items ----------------->
