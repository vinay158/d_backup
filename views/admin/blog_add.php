<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<div class="gen-holder">
	<div class="gen-panel-holder">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Entry</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post">
<script language="javascript">
$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
})
</script>
<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="" name="title" id="main_title" class="field" placeholder="Enter your title here"/>
	<div style="margin-bottom:10px;">
		Title will appear in the URL as: <em id="sef_title"></em>
	</div>
</div>
<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Category</h1>
		<div>
		<select id="category_id" name="blog_category_id" style="width: 100%; background:#FFF; border: none; border-radius: 5px; padding: 5px;">
			<option value="null" disabled="disabled">Your Categories</option>
			<?php if(isset($cat)): ?>
				<?php foreach($cat as $cat_item): ?>
					<option value="<?=$cat_item->cat_id;?>" 
					<?php if($this->uri->segment('4') != NULL){ 
					if($this->uri->segment('4') == $cat_item->cat_id) echo "selected='selected'"; }?>><?=$cat_item->cat_name;?></option>
				<?php endforeach;?>
			<?php endif;?>
		</select>
		</div>
</div>
<div class="form-light-holder" style="padding-bottom:30px;">
	<!--<textarea name="text" class="textarea" id="frm-text"></textarea>
	--><textarea name="text" class="ckeditor" id="frm-text"></textarea>
</div>
<div class="form-light-holder">
	<h1>Short Description</h1>
	<input type="text" name="short_description" value="" class="field">
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

	<a id="allow_comments" class="checkbox check-on"></a>
	<h1 class="inline">Commenting</h1>
	<input type="hidden" value="1" name="allow_comments" class="hidden_cb" />
</div>
<div class="form-light-holder">
	<a id="shared" class="checkbox check-on"></a>
	<h1 class="inline">Share This</h1>
	<input type="hidden" value="1" name="shared" class="hidden_cb" />
</div>
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

























	<div class="sidebar">
	<div class="gen-panel" id="mediabrowser-panel" style="">
		<div class="panel-title">

			<div class="panel-title-name">Media Browser</div>
			<div class="panel-title-options">
				<div>
					<a href="" id="mediabrowser-upload">Upload</a>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="panel-body-holder" style="float:none;">
				<div class="media-holders" id="the-media">
					<div class="select-gen full">
						<select id="media_gal_select">
							<option value="">Select a Gallery</option>
							<option value="">--------------</option>
						</select>
						<span id="media-select-update">Select a Gallery</span>
						<input type="hidden" id="gallery_id_upload" value="null" />
					</div>
					
					<div id="media-list-update">
						<div class="media-list-blank"></div>
					</div>
				</div>
			</div>		
		</div>
	</div>
	
<?php $this->load->view("admin/include/tag");?>
	</div></div></div>
<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
