<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>	-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'description', 
									{ customConfig : 'mini_half_configy.js' }
							);
	
	});
</script>
<style>
<!--
.manager-items .manager-item {
	min-height: 49px !important;
}
-->
</style>


<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add: Video Album</h2>
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

<div class="mb-3 main-content-label page_main_heading">Add: Video Album</div>

<form id="blog_form" action="" method="post">
<div class="form-light-holder">
	<h1>Album Title</h1>
	<input type="text" value="" name="title" id="main_title" class="field full_width_input"/>
</div>

<div class="form-light-holder">
	<h1>Category</h1>
	<select name="category" id="category" class="field">
	<?php foreach($cat as $cat): 
		if($cat->cat_id != 25){
	?>
	
	<option <?php if($this->uri->segment(4) == $cat->cat_id) echo "selected='selected'"; ?> value="<?=$cat->cat_id?>"><?=$cat->cat_name?></option>
		<?php } endforeach;?>
	</select>
</div>

<div class="form-light-holder" style="padding-bottom:30px;">
	<h1>Description</h1>
	<!--<textarea name="text" class="textarea" id="frm-text"></textarea>
	--><textarea name="text" class="ckeditor" id="description"></textarea>
	<br />
    <font size="2">(Maximum characters: 140)</font>
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
	<a id="published" class="checkbox check-on"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="1" name="published" class="hidden_cb" />
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
