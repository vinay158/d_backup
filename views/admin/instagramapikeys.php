<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="/resources/demos/style.css" />
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>
--><script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Instragram API</h2>
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
<div class="mb-3 main-content-label">Edit: Instragram API</div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">



$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})	
})
</script>

<div class="form-light-holder">
	<span class="authTitle">Instragram</span>
	<h1>Instragram User ID</h1>
	<input type="text" value="<?php if(!empty($apiKey)){ echo  $apiKey->instragram_user_id;}  ?>" name="instragram_user_id" id="name" class="field full_width_input" />	
</div>

<div class="form-light-holder">
	<h1>Instragram Access Token</h1>
	<input type="text" value="<?php if(!empty($apiKey)){ echo $apiKey->instragram_access_token; } ?>" name="instragram_access_token" id="name" class="field full_width_input" />	
</div>

<input type="hidden" name="location_id" value="<?php if(!empty($location_id)){ echo $location_id; } ?>" />


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
