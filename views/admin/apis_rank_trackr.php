

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#rankTrackr  .hidden_cb').val() == 0){
		$('#rankTrackr .template_box').hide();
	}else{
		$('#rankTrackr .template_box').show();
	}
});
$(document).ready(function(){
$("#rankTrackr .form-light-holder-mailchimp .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#rankTrackr .form-light-holder-mailchimp").children("#rankTrackr .hidden_cb").val("0");
		$('#rankTrackr .template_box').hide();
		$('#rankTrackr .api_key').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#rankTrackr .form-light-holder-mailchimp").children("#rankTrackr .hidden_cb").val("1");
		$('#rankTrackr .template_box').show();
		$('#rankTrackr .api_key').attr('required',true);
	}
})

$('#rankTrackr .btn-save').click(function(){
		if($('#rankTrackr .hidden_cb').val() == 0){
			$('#rankTrackr .api_key').attr('required',false);
		} else{
			$('#rankTrackr .api_key').attr('required',true);
		}
});

})
</script>



		<div class="panel-body" id="rankTrackr">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_rank_trackr" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	if(!empty($apis_rank_trackr['detail'])){
		if($apis_rank_trackr['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
	}
	
	
?>
<div class="form-light-holder-mailchimp  form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Rank Trackr</h1>
	<input type="hidden" value="<?php if(!empty($apis_rank_trackr['detail'])){ echo $apis_rank_trackr['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>



<div class="template_box  form-new-holder" style="display:none">
		<h1>Email</h1>
		<input type="text" value="<?php if(!empty($apis_rank_trackr['detail'])){ echo $apis_rank_trackr['detail']->email; }?>" name="email" class="api_key" />
</div>

<div class="template_box  form-new-holder" style="display:none">
		<h1>Password</h1>
		<input type="text" value="<?php if(!empty($apis_rank_trackr['detail'])){ echo $apis_rank_trackr['detail']->password; }?>" name="password" class="api_key" />
</div>

<div class="template_box  form-new-holder" style="display:none">
		<h1>Url</h1>
		<input type="text" value="<?php if(!empty($apis_rank_trackr['detail'])){ echo $apis_rank_trackr['detail']->search_url; }?>" name="search_url" class="api_key" />
</div>







<div class="form-white-holder  form-new-holder">

	<input type="submit" name="rank_trackr_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>

	

<!------------ recent items ----------------->


