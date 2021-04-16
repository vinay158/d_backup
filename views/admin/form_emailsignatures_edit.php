<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		<?php if(!empty($locations)){
				foreach($locations as $location){
		?>
		 CKEDITOR.replace(  'ckeditor_mini_desc<?php echo $location->id;  ?>', 
									{ customConfig : 'mini_config.js' }
							);
		<?php } } ?>
	});
</script>

<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Email Signature</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<?php if(!empty($locations)){
		foreach($locations as $location){
?>
<div class="form-light-holder" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;"><?php echo $location->name; ?></h1>
			<textarea type="text" id="ckeditor_mini_desc<?php echo $location->id;  ?>" name="header_title" class="field full_width_input" style=""></textarea>
		<div>
		</div>
</div>
<?php } } ?>
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
