<?php if(!empty($user)){ ?>
<form action="<?=base_url();?>admin/onlinedojo_users/updateOnlinedojoUser" method="post" enctype="multipart/form-data">
<div class="modal-body edit-form">
   <div class="row row-xs align-items-center">
		<div class="col-md-6 mg-t-5 mg-md-t-0">
			<h1>First Name</h1>
			<input type="text" name="firstname" value="<?php echo $user[0]->firstname; ?>" required>
		</div>
		<div class="col-md-6 mg-t-5 mg-md-t-0">
			<h1>Last Name</h1>
			<input type="text" name="lastname" value="<?php echo $user[0]->lastname; ?>" >
		</div>
		<div class="col-md-6 mg-t-5 mg-md-t-0">
			<h1>Email</h1>
			<input type="text" name="" value="<?php echo $user[0]->email; ?>" readonly >
		</div>
		
		<div class="col-md-6 mg-t-5 mg-md-t-0">
			<h1>Phone</h1>
			<input type="text" name="phone" value="<?php echo $user[0]->phone; ?>"  >
		</div>
		
		<?php if($multiLocation[0]->field_value == 1){ ?>
		<div class="col-md-12 mg-t-5 mg-md-t-0">
			<h1>Location</h1>
			<select  name="location_id" id='location_sort' class="field" required>
						<option value="">- Select -</option>
						<?php foreach($allLocations as $location){ ?>
						<option value="<?php echo $location->id ?>" <?php echo (!empty($user[0]->location_id) && $user[0]->location_id == $location->id) ? "selected=selected" : ''; ?>><?php echo $location->name; ?></option>
						<?php } ?>
						<option value="virtual_student_only" <?php echo (!empty($user[0]->location_id) && $user[0]->location_id == "virtual_student_only") ? "selected=selected" : ''; ?>>Virtual student only</option>
					</select>
				
		</div>
		<?php } ?>
		
		
</div>
</div>

<input type="hidden" name="user_id" value="<?php echo $user[0]->id; ?>" >
<div class="modal-footer">
<input type="submit" name="update" value="Save" class="btn-save">
</div>
</form>
<?php } ?>
