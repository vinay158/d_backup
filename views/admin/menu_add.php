<?php //echo '<pre>'; print_r($test); die;

?>

<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'mini_editor', 
									{ customConfig : 'config.js' }
							);
	
	 
	});
</script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add Menu</h2>
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
		<div class="mb-3 main-content-label page_main_heading">Add: Menu</div>
<script type="text/javascript">
	function validateForm() {
    var title = document.forms["myForm"]["title"].value;
    if (title == null || title == "") {
        alert("Page Title must be filled out");
        return false;
    }
	
	
}
</script>

<form id="menu_form" action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" name="myForm">
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
})
</script>



<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="" name="title" id="name" class="field full_width_input" placeholder="Enter your title here"/>
</div>


<div class="form-light-holder" style="padding-bottom:30px;">
	<h1>Description</h1>
	<!--<textarea name="text" class="textarea" id="frm-text"></textarea>
	--><textarea name="content" class="ckeditor" id="mini_editor"></textarea>
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

</div>
</div>
</div>
</div>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
