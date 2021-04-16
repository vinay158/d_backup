<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<?php if(!empty($pagedetails)) :?>		
<?php foreach($pagedetails as $blogitem):?>
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%;">
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
	<input type="text" value="<?=ucwords($blogitem->title);?>" name="title" id="main_title" class="field"/>
	<div style="margin-bottom:10px;">
		Title will appear in the URL as: <em id="sef_title"><?=base_url()."view/".$blogitem->id;?></em>
	</div>
</div>

<div class="form-light-holder" style="padding-bottom:30px;">
	<!--<textarea name="text" class="textarea" id="frm-text"><?=html_entity_decode($blogitem->content);?></textarea>
	-->
	<textarea name="text" class="ckeditor" id="frm-text"><?=$blogitem->content;?></textarea>
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
	<?php endforeach;?>
<?php endif;?>	</div></div></div>
<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>