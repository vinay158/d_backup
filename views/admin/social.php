<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Entry</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
})
</script>
<?php if(!empty($social)): ?>
<?php foreach($social as $social) : ?>
<div  class="form-light-holder">
<textarea name="embed" id="embed" rows="15"><?=$social->embed;?></textarea>
<!-- <textarea id="embed" name="embed" class="ckeditor" ><?=$social->embed;?></textarea>-->
</div>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<?php endforeach; ?>
<?php endif; ?>
</form>
		</div>
		</div>
		</div>
	</div>
	</div>

























<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
