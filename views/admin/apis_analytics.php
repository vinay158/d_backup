
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#googleAnalytics  .hidden_cb').val() == 0){
		$('#googleAnalytics .template_box').hide();
	}else{
		$('#googleAnalytics .template_box').show();
	}
});
$(document).ready(function(){
$("#googleAnalytics .form-light-holder-mailchimp .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#googleAnalytics .form-light-holder-mailchimp").children("#googleAnalytics .hidden_cb").val("0");
		$('#googleAnalytics .template_box').hide();
		$('#googleAnalytics .api_key').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#googleAnalytics .form-light-holder-mailchimp").children("#googleAnalytics .hidden_cb").val("1");
		$('#googleAnalytics .template_box').show();
		$('#googleAnalytics .api_key').attr('required',true);
	}
})

$('#googleAnalytics .btn-save').click(function(){
		if($('#googleAnalytics .hidden_cb').val() == 0){
			$('#googleAnalytics .api_key').attr('required',false);
		} else{
			$('#googleAnalytics .api_key').attr('required',true);
		}
});

})
</script>



		<div class="panel-body" id="googleAnalytics">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_analytics" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	if(!empty($apis_analytics['detail'])){
		if($apis_analytics['detail']->analytics_report_type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
	}
	
	
?>
<div class="form-light-holder-mailchimp   form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Google Analytics Report</h1>
	<input type="hidden" value="<?php if(!empty($apis_analytics['detail'])){ echo $apis_analytics['detail']->analytics_report_type; } else{ echo 0; }?>" name="analytics_report_type" class="hidden_cb" />
</div>



<div class="template_box   form-new-holder" style="display:none">
		<h1>Google Analytics View ID</h1>
		<input type="text" value="<?php if(!empty($apis_analytics['detail'])){ echo $apis_analytics['detail']->client_id; }?>" name="client_id" class="api_key" />
</div>

<div class="template_box  form-new-holder" style="display:none">
		<h1>Google Application Credentials File Path</h1>
		<input type="text" value="<?php if(!empty($apis_analytics['detail'])){ echo $apis_analytics['detail']->client_secret; }?>" name="client_secret" class="api_key" />
		<br/><em>For eg: "/home/{username}/public_html/{json filename}"</em>
</div>








<div class="form-white-holder  form-new-holder">

	<input type="submit" name="analytics_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>

	

<!------------ recent items ----------------->


