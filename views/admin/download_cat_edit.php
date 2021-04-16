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
<script language="javascript">
$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
	}
})
})
</script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Category</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	});
})
</script>
<?php foreach($categories as $prog_cat): ?>
<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="<?=$prog_cat->cat_name; ?>" name="name" id="name" class="field" placeholder="Enter your name here"/>
	<input type="hidden" value="<?=$prog_cat->cat_id;?>" name="edit_id" id="cat_id" >
	
</div>

<div class="form-light-holder">
	<h1>Meta Title</h1>
	<input type="text" name="meta_title" value="<?=$prog_cat->meta_title ?>" class="field">
</div>

<div class="form-light-holder" style="">
	<h1>Meta Description</h1>
	<textarea name="meta_desc" class="ckeditor" id="frm-text"><?=$prog_cat->meta_desc?></textarea>
</div>
<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($prog_cat->published==1) echo "check-on"; else echo "check-off";?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?=$prog_cat->published?>" name="published" class="hidden_cb" />
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<?php endforeach; ?>
</form>

		</div>
		</div>
		</div>
	</div>
	</div>
<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
