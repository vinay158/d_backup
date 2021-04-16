
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#mailchimp  .hidden_cb').val() == 0){
		$('#mailchimp .template_box').hide();
	}else{
		$('#mailchimp .template_box').show();
	}
});
$(document).ready(function(){
$("#mailchimp .form-light-holder-mailchimp .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#mailchimp .form-light-holder-mailchimp").children("#mailchimp .hidden_cb").val("0");
		$('#mailchimp .template_box').hide();
		$('#mailchimp .api_key').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#mailchimp .form-light-holder-mailchimp").children("#mailchimp .hidden_cb").val("1");
		$('#mailchimp .template_box').show();
		$('#mailchimp .api_key').attr('required',true);
	}
})

$('#mailchimp .btn-save').click(function(){
		if($('#mailchimp .hidden_cb').val() == 0){
			$('#mailchimp .api_key').attr('required',false);
		} else{
			$('#mailchimp .api_key').attr('required',true);
		}
});

})
</script>



		<div class="panel-body" id="mailchimp">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_mailchimp" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	if(!empty($apis_mailchimp['detail'])){
		if($apis_mailchimp['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
	}
	
	
?>
<div class="form-light-holder-mailchimp form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Mailchimp</h1>
	<input type="hidden" value="<?php if(!empty($apis_mailchimp['detail'])){ echo $apis_mailchimp['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>



<div class="template_box form-new-holder" style="display:none">
		<h1>Email</h1>
		<input type="text" value="<?php if(!empty($apis_mailchimp['detail'])){ echo $apis_mailchimp['detail']->email; }?>" name="email" class="api_key" />
</div>

<div class="template_box form-new-holder" style="display:none">
		<h1>FirstName</h1>
		<input type="text" value="<?php if(!empty($apis_mailchimp['detail'])){ echo $apis_mailchimp['detail']->first_name; }?>" name="first_name" class="api_key" />
</div>

<div class="template_box form-new-holder" style="display:none">
		<h1>Api Key</h1>
		<input type="text" value="<?php if(!empty($apis_mailchimp['detail'])){ echo $apis_mailchimp['detail']->api_key; }?>" name="api_key" class="api_key" />
</div>

<?php if(!empty($template_lists)){ ?>
	<div class="template_box form-new-holder" style="display:none">
			<h1>Email Provider List</h1>
			<select name="template_id" id="" class="field " >
				<option value="">-Select-</option>
				<?php foreach($template_lists as $template){ ?>
				<option value="<?= $template['id']; ?>"  <?php if(!empty($apis_mailchimp['detail'])){ if($apis_mailchimp['detail']->template_id == $template['id']){ echo 'selected=selected'; } } ?>><?= $template['name']; ?></option>
				<?php } ?>
			</select>
	</div>
<?php } ?>







<div class="form-white-holder form-new-holder">

	<input type="submit" name="mailchimp_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>

<!--<div style="clear:both"></div>	-->

<!------------ recent items ----------------->


