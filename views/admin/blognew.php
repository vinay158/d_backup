<?php $this->load->view("admin/include/headernew"); ?>
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<?php if(!empty($blogdetails)) :?>		
<?php foreach($blogdetails as $blogitem):?>
<div class="gen-holder">
	<div class="gen-panel-holder">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name"><?=$blogitem->title;?></div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post">
<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="<?=$blogitem->title;?>" name="title" id="main_title" class="field"/>
	<div style="margin-bottom:10px;">
		Title will appear in the URL as: <em id="sef_title"><?=base_url()."blog/viewblog/".$blogitem->id;?></em>
	</div>
</div>
<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Category</h1>
		<select id="category_id" name="blog_category_id" style="width: 60%;">
			<option value="null">Your Categories</option>
			<?php if(isset($cat)): ?>
				<?php foreach($cat as $cat_item): ?>
					<option value="<?=$cat_item->cat_id;?>" <?php if($blogitem->category == $cat_item->cat_id) echo "selected='selected'"; ?>><?=$cat_item->cat_name;?></option>
				<?php endforeach;?>
			<?php endif;?>
		</select>
</div>
<div class="form-light-holder" style="padding-bottom:30px;">
	<!--<textarea name="text" class="textarea" id="frm-text"><?=html_entity_decode($blogitem->content);?></textarea>
	--><textarea name="text" class="ckeditor" id="frm-text"><?=$blogitem->content;?></textarea>
</div>

<?=$this->load->view("admin/include/buttons");?>
<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>



		</div>
		</div>
		</div>
	</div>
	</div>
	<?php endforeach;?>
<?php endif;?>

























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
<div id="media-list-holder" style="display: none;">

	<div id="media_picture_holder" style="display: none;">
		<div class="sidebar-cover"><a href="" class="sb-item" title=""></a></div>
		<div class="media-item-image">
			<img src="" alt="" />
		</div>
		<div class="btn-addthis"><a href=""></a></div>
	</div>
	<div id="media_video_holder" style="display: none;">
		<div class="sidebar-cover"><a href="" class="sb-movie" title=""></a></div>
		<div class="media-item-image">
			<div class="media-item-movie"></div>
			<img src="" alt="" />		
		</div>
		<div class="btn-addthis"><a href=""></a></div>
	</div>
</div>	

<div id="upload_hidden_holder" style="display:none;">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;">Add Media Items</div>
      <div class="btn-close"><a class="close-btn" href="#"></a></div>
    </div>
		<form>
		<div class="dropdown-body">
			<div class="form-item" style="overflow:auto;">
				<h1>Choose a Gallery to Upload to:</h1>
				<div class="select-gen inline">
					<select name="your">
						<option value="null">Your Galleries</option>
						<option value="null">------------</option>
					</select>
					<span class="your-select-update">Your Galleries</span>
				</div>
				<span style="float:left;margin: 10px 10px 0 12px;">OR</span>
				<div class="select-gen inline">
					<select name="shared">
						<option value="null">Shared Galleries</option>
						<option value="null">--------------</option>
					</select>
					<span class="shared-select-update">Shared Galleries</span>
				</div>
			</div>
			<div class="dropdown-tabbar">
				<a href="" class="dd-upload-btn active">Upload</a>
				<a href="" class="dd-embed-btn">Add Embed Code</a>
			</div>
			<div class="dd-upload-tab">
				<div class="form-item">
					<h1>Upload Multiple Images &amp; Video</h1>
					Supported File Formats: jpg, gif, png, mov, mpg, wmv, avi
				</div>		
			</div>
			<div class="dd-embed-tab" style="display:none;">
				<div class="form-item">
					<h1>Add a Flash Video EMBED Code</h1>
					<textarea name="embed"></textarea>
					Embed Code - A snippet of code from a Youtube, Vimeo, Myspace, etc. video.
				</div>
				<br /><br />	
				<div class="form-item">
					<h1>EMBED Code Title</h1>
					<input type="text" name="embed_title" />
				</div>			
			</div>
		</div>
		<div class="dropdown-bottom">
			<div class="dd-upload-submit">
				<div style="padding:16px 0 0 16px;"><span class="spanButtonPlaceholder"></span></div>
			</div>
			<div class="dd-embed-submit" style="display:none;">
				<input type="button" value="Add" class="btn-add"/>
			</div>
		</div>
		</form>
	</div>
</div>

		<div class="gen-panel" id="tags_gen_panel">
		<div class="panel-title">
			<div class="panel-title-name">Tags</div>
			<div class="panel-title-options">
				<div>
					<a id="tag_btn" href="">My Tags</a>
				</div>
			</div>
		</div>
		<div class="panel-body">
			<div class="panel-body-holder" id="tag_manager">
				<div class="tag-item" id="the-tags" style="display: none;">
					Tag this using Your existing Tags:<br />
					<div class="gen-tags" style="display:none;width:241px;">
						<a href="" class="gen-tag check-off">
							<div style="float:left"></div><div class="gen-tag-right"></div>
						</a>
					</div>
					<br />
				</div>
				<div id="frm-add-new-tag">
					<form id="frm-new-tag" action="">
					<div class="sidebar-item tag-item" id="add-new-tag">
						<h1>Add New Tags</h1>
						<input type="text" name="newtags" class="field" />
						Seperate Tags with <i>Commas</i>.
					</div>
					<input type="submit" class="btn-add" style="margin-top:10px;" value="Add" />
					</form>
				</div>
			</div>
		</div>
	</div></div></div>
<br style="clear:both"		 /><br />

</body>
</html>