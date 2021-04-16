<?php //echo '<pre>'; print_r($test); die;

?>

<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Entry</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
<script type="text/javascript">
	function validateForm() {
    var title = document.forms["myForm"]["title"].value;
    if (title == null || title == "") {
        alert("Page Title must be filled out");
        return false;
    }
	
	/*var sort_order = document.forms["myForm"]["sort_order"].value;
    if (!Number(sort_order)) {
        alert("Page Order must be filled out");
        return false;
    }*/
}
</script>

<form id="page_form" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" name="myForm">
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
})
</script>



<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="" name="title" id="name" class="field" placeholder="Enter your title here"/>
</div>

<div class="form-light-holder">
	<h1>Slug</h1>
	<input type="text" value="" name="slug" id="slug" class="field" placeholder="Enter your slug here"/>
</div>

<div class="form-light-holder">
	<h1>Page Order</h1>
	<input type="text" value="" name="sort_order" id="sort_order" class="field" placeholder="Enter your Page Order here"/>
</div>
<div class="form-light-holder" style="">
<h1>Page Type</h1>
<select name="type" id="category" style="width: 100%; background:#FFF; border: none; border-radius: 5px; padding: 5px" >
<?php
	$pageTemplates = array('0' => 'Normal', '1' => 'Blog' , '2' => 'Testimonials', '3' => 'Contact us');
	foreach($pageTemplates as $key => $templates){
?>
<option value="<?php echo $key; ?>"><?php echo $templates; ?></option>
<?php } ?>
</select>
</div>

<div class="form-light-holder" style="">
	<h1>Description</h1>
	<!--<textarea name="text" class="textarea" id="frm-text"></textarea>
	--><textarea name="content" class="ckeditor" id="frm-text"></textarea>
</div>
<div class="form-light-holder">
	<h1>Meta Title</h1>
	<input type="text" value="" name="meta_title" id="name" class="field" placeholder="Enter your Meta Title here"/>
</div>

<div class="form-light-holder">
	<h1>Meta Description</h1>
	<input type="text" value="" name="meta_description" id="name" class="field" placeholder="Enter your Meta Description here"/>
</div>


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

<div class="form-light-holder">
	<a id="free_trials" class="checkbox check-on"></a>
	<h1 class="inline">Show Start Trial button</h1>
	<input type="hidden" value="1" name="published" class="hidden_cb" />
</div>

<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" value="<?php echo 'view/'.$this->uri->segment(4);?>" name="redirect" id="redirect" class="hidden_cb" />
	<input type="submit" name="save" value="Save" class="btn-save" style="float:left;" />
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
