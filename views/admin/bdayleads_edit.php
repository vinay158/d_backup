<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>    
    <link rel="stylesheet" href="/resources/demos/style.css" />
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Trial Lead</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="<?=base_url();?>admin/leads/updatebdayleads" method="post" enctype="multipart/form-data">
<script language="javascript">
$(document).ready(function(){


})


</script>

<div class="form-light-holder">
	<h1>Name</h1>
	<input type="text" value="<?=$record->name?>" name="name" id="name" class="field"/>
</div>
<div class="form-light-holder">
	<h1>Phone</h1>
    <?php
		$phone = explode('-', $record->phone);
	?>
	<input type="text" name="phone" value="<?=$record->phone?>" id="form_phone_2"/>
</div>
<div class="form-light-holder">
	<h1>Email</h1>
	<input type="text" value="<?=$record->email?>" name="email" id="email" class="field"/>
</div>
<div class="form-light-holder">
	<h1>Party Date</h1>
	<input type="text" value="<?=$record->party_date?>" name="party_date" id="party_date" class="field"/>
</div>
<div class="form-light-holder" style="">
	<h1>Guest</h1>

	<select name="guests" id="party_guests">
		<option value="1-5" <?php echo $record->guests == '1-5' ? 'selected="selected"' : ''; ?>>1-5</option>
		<option value="6-10" <?php echo $record->guests == '6-10' ? 'selected="selected"' : ''; ?>>6-10</option>
		<option value="more than 10" <?php echo $record->guests == 'more than 10' ? 'selected="selected"' : ''; ?>>10+</option>
	</select>
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" name="id" value="<?=$record->id?>" />
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>
		</div>
		</div>
		</div>
	</div>
	</div>
	</div></div></div>
<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
