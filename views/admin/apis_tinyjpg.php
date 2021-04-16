
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

		<div class="panel-body" id="tinyjpgApi">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_tinyjpg" method="post" enctype="multipart/form-data">




<div class="  form-new-holder">
	<h1>Tinyjpg Key</h1>
	<input type="text" value="<?php if(!empty($apis_chargify['detail'])){ echo $apis_chargify['detail']->tinyjpg_key; }?>" name="tinyjpg_key" class="field"  placeholder="Enter Your Tinyjpg Key"  />
</div>

</div>


<div class="form-white-holder  form-new-holder" >

	<input type="submit" name="tinyjpg_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>
