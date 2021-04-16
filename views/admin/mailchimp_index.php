<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('.hidden_cb').val() == 0){
		$('.template_box').hide();
	}else{
		$('.template_box').show();
	}
});
$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
		$('.template_box').hide();
		$('.api_key').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
		$('.template_box').show();
		$('.api_key').attr('required',true);
	}
})

$('.btn-save').click(function(){
		if($('.hidden_cb').val() == 0){
			$('.api_key').attr('required',false);
		} else{
			$('.api_key').attr('required',true);
		}
});

})
</script>



<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		<div class="panel-title">

			<div class="panel-title-name">Mailchimp</div>

		</div>

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	if(!empty($detail)){
		if($detail->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
	}
	
	
?>
<div class="form-light-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Mailchimp</h1>
	<input type="hidden" value="<?php if(!empty($detail)){ echo $detail->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>



<div class="form-light-holder template_box" style="display:none">
		<h1>Email</h1>
		<input type="text" value="<?php if(!empty($detail)){ echo $detail->email; }?>" name="email" class="api_key" />
</div>

<div class="form-light-holder template_box" style="display:none">
		<h1>FirstName</h1>
		<input type="text" value="<?php if(!empty($detail)){ echo $detail->first_name; }?>" name="first_name" class="api_key" />
</div>

<div class="form-light-holder template_box" style="display:none">
		<h1>Api Key</h1>
		<input type="text" value="<?php if(!empty($detail)){ echo $detail->api_key; }?>" name="api_key" class="api_key" />
</div>

<?php if(!empty($template_lists)){ ?>
	<div class="form-light-holder template_box" style="display:none">
			<h1>Email Provider List</h1>
			<select name="template_id" id="" class="field " >
				<?php foreach($template_lists as $template){ ?>
				<option value="<?= $template['id']; ?>"  <?php if(!empty($detail)){ if($detail->template_id == $template['id']){ echo 'selected=selected'; } } ?>><?= $template['name']; ?></option>
				<?php } ?>
			</select>
	</div>
<?php } ?>







<div class="form-white-holder" style="padding-bottom:20px;">

	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />

</div>

</form>

		</div>

		</div>

		</div>

	</div>

	</div>

<br style="clear:both" /><br />

<!------------ recent items ----------------->

<?php $this->load->view("admin/include/footer");?>

