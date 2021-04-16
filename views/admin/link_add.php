<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Entry</div>
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
<div class="form-light-holder">
	<h1>Name</h1>
	<input type="text" value="" name="name" id="name" class="field" placeholder="Enter link name here"/>
	
</div>

<div class="form-light-holder">
	<h1>URL</h1>
	<input type="text" value="" name="url" id="url" class="field" placeholder="Enter link url here"/>
	<h2>Please include the http:// before your URL</h2>
</div>
<div class="form-light-holder">
	<h1>Link Target</h1>
	<select name="target" id="target" class="field" >
	<option value="_blank">Blank</option>
	<option value="_self" >Self</option>

</select>
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
<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
