<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Edit Entry</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">				
		<div class="form-holder">
<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<div class="form-white-holder" style="padding-bottom:20px;">
		<div class="form-light-holder">
        	<h1>Title</h1>
            <input type="text" value="<?=$detail['title']?>" name="title" id="title" class="field" required="required"/>
        </div>
        
        <div class="form-light-holder">
        	<h1>Featured summary</h1>
        	<input type="text" value="<?=$detail['description']?>" name="description" id="description" class="field featured_summary" placeholder="Enter your summery here" maxlength="80" required="required" />
        	<p><i>The featured summary has a limit of 90 characters</i></p>
    	</div>
        
        <div class="form-light-holder" style="overflow:auto;">
            <h1 style="padding-bottom: 5px;">Choose a Photo</h1>            <br />
            <?php
				$base_url = base_url();
				
				if(!empty($detail['photo'])){
					echo '<img src="'.$base_url.'upload/advert/thumb/'.$detail['photo'].'" />';
				}
			?>
            <br />
            <input type="file" name="userfile" id="photo" accept="image/*" required="required" />	
		</div>


	<input type="hidden" name="advert_id" id="advert_id"  value="<?=$advert_id?>" />
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
</form>
		</div>
		</div>
		</div>
	</div>
	</div>

<br style="clear:both"		 />

<?php $this->load->view("admin/include/footer");?>