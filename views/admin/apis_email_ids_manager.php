
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

		<div class="panel-body" id="tinyjpgApi">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_email_ids_manager" method="post" enctype="multipart/form-data">




<div class="  form-new-holder">
	<h1>From Email Id</h1>
	<input type="text" value="<?php if(!empty($apis_email_ids_manager['detail'])){ echo $apis_email_ids_manager['detail']->from_email; }?>" name="from_email" class="field"  placeholder="Enter Your From Email Id"  />
</div>

<div class="  form-new-holder">
	<h1>Reply To Email Id</h1>
	<input type="text" value="<?php if(!empty($apis_email_ids_manager['detail'])){ echo $apis_email_ids_manager['detail']->replyto_email; }?>" name="replyto_email" class="field"  placeholder="Enter Your Reply To Email Id"  />
</div>

<div class="  form-new-holder">
	<h1>CC Email Id</h1>
	<input type="text" value="<?php if(!empty($apis_email_ids_manager['detail'])){ echo $apis_email_ids_manager['detail']->cc_email; }?>" name="cc_email" class="field"  placeholder="Enter Your CC Email Id"  />
</div>

</div>


<div class="form-white-holder  form-new-holder">

	<input type="submit" name="email_ids_manager_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>
