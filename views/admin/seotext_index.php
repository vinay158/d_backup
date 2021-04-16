<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>





<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		<div class="panel-title">

			<div class="panel-title-name">Seo Text Edit</div>

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
	<h1  style="padding-bottom: 5px;">Seo Text</h1>
	<!-- DOJO 30/11 --->
	<textarea name="seo_text"  id="frm-text" class="ckeditor"><?= $content[0]->seo_text; ?></textarea>

	<span id='charNumtblurb'></span>

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

<br style="clear:both" /><br />

<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

