<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini_header_title', 
									{ customConfig : 'config.js' }
							);
		
	});
</script>
<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo isset($title) ? $title : ''; ?></h2>
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
<div class="mb-3 main-content-label page_main_heading"><?php echo isset($title) ? $title : ''; ?></div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="<?php echo !empty($details) ? $this->query_model->getStrReplaceAdmin($details->title) : ''; ?>" name="title" required="true" id="name" class="field full_width_input" placeholder="Enter your title"  style=""/>
</div>

<div class="form-light-holder">
	<h1>Subject</h1>
	<input type="text" value="<?php echo !empty($details) ? $this->query_model->getStrReplaceAdmin($details->subject) : ''; ?>" name="subject" required="true" id="subject" class="field full_width_input" placeholder="Enter your email subject"  style=""/>
</div>




<div class="form-light-holder" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Text</h1>
			<textarea type="text" id="ckeditor_mini_header_title" name="description" class="field  full_width_input"><?php echo !empty($details) ? $details->description : ''; ?></textarea>
		<div>
		</div>
</div>
<div class="form-light-holder  row row-xs align-items-center  email_varibles" style="overflow:auto;">
			<div class="col-md-12"><h1 style="padding-bottom: 5px;">Variables:</h1></div>
			<div class="col-md-12"><em>Please use variables in auto responder textarea</em></div>
		
<?php 
	$variablesArr = array(	
						'User' => array('FIRSTNAME','LASTNAME','EMAIL','PASSWORD','LOCATION'),
						'User ATTENDANCE'=> array(	'GENERATE_PASSWORD_LINK','ATTENDANCE_REPORT_TYPE','ATTENDANCE_REPORT_DATE'),
						'School' => array('SITE_TITLE','CONTACT_NAME','CONTACT_ADDRESS','CONTACT_SUITE','CONTACT_CITY','CONTACT_STATE','CONTACT_ZIP','CONTACT_PHONE')
						);
	?>
	<div class="col-md-12 row row-xs">
	<?php foreach($variablesArr as $key => $variables){ //echo '<pre>key'; print_R($key); die; ?>
		<div class="col-md-4">
		<div class="col-md-12"> <h1><u><?php echo $key ?> Variables</u></h1></div>
		<?php  foreach($variables as $variable){ ?>
				<div class="col-md-12">#<?php echo $variable; ?></div>
		<?php } ?>
		</div>
	<?php } ?>
	</div>
	
			<div>
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
