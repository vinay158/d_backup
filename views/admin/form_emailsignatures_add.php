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
									{ customConfig : 'config.js' }
							);
		<?php } } ?>
	});
</script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Email Signature</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
<div class="mb-3 main-content-label page_main_heading">Edit: Email Signature</div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<?php if(!empty($locations)){
		foreach($locations as $location){
?>
<div class="form-light-holder" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;"><?php echo $location->name; ?></h1>
			<textarea type="text" id="ckeditor_mini_desc<?php echo $location->id;  ?>" name="data[<?php echo $location->id;  ?>][signature_text]" class="field full_width_input" style=""><?php echo isset($detail[$location->id])? $detail[$location->id]->signature_text : ''; ?></textarea>
			
		<input type="hidden" name="data[<?php echo $location->id;  ?>][location_id]" value="<?php echo $location->id;  ?>">
		<!--<input type="hidden" name="data[<?php echo $location->id;  ?>][location_name]" value="<?php echo $location->name;  ?>"> -->
</div>
<?php } } ?>

<div class="form-light-holder  row row-xs align-items-center  email_varibles" style="overflow:auto;">
			<div class="col-md-12"><h1 style="padding-bottom: 5px;">Variables:</h1></div>
			<div class="col-md-12"><em>Please use variables in auto responder textarea</em></div>
			
<?php 
	$variablesArr = array(	
						'Common' => array('FIRSTNAME','EMAIL','PHONE','LOCATION','PROGRAM','MESSAGE'),
						'School and Contact'=> array('SITE_TITLE','CONTACT_NAME','CONTACT_ADDRESS','CONTACT_SUITE','CONTACT_CITY','CONTACT_STATE','CONTACT_ZIP','CONTACT_PHONE')
					);
?>
			<div class="col-md-12 row row-xs">
			<?php 
			$i = 0;
			foreach($variablesArr as $key => $variables){
				
			?>
				<div class="col-md-3">
				<div class="col-md-12 <?php echo ($i == 0) ? 'nopadding' : ''; ?>"> <h1 class="heading"><?php echo $key ?> Variables</h1></div>
				<?php  foreach($variables as $variable){ ?>
						<div class="col-md-12  <?php echo ($i == 0) ? 'nopadding' : ''; ?>">#<?php echo $variable; ?></div>
				<?php } ?>
				</div>
			<?php $i++; } ?>
			</div>
			
</div>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>


		</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>




<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
