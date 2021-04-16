<!-- end head contents -->

<!---wysiwyg editor script -->

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#velocify .hidden_cb').val() == 0){
		$('#velocify .DetailBox').hide();
	}
});
$(document).ready(function(){
$("#velocify .form-light-holder1 .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#velocify .form-light-holder1").children("#velocify .hidden_cb").val("0");
		$('#velocify .DetailBox').hide();
		$('#velocify .multi_kicksite_hidden_cb').val(0);
		$('#velocify .multi_kicksite_checkbox').removeClass("check-on");
		$('#velocify .multi_kicksite_checkbox').addClass("check-off");
		$('#velocify .kicksiteFields').attr('required',false);
		
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#velocify .form-light-holder1").children("#velocify .hidden_cb").val("1");
		$('#velocify .DetailBox').show();
		$('#velocify .kicksiteFields').attr('required',true);
	}
	
	
})


})
</script>


		<div class="panel-body" id="velocify">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_velocify" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	
	if(!empty($apis_velocify['detail'])){
		if($apis_velocify['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
	}
	
	
?>


<div class="form-light-holder1  form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Velocify</h1>
	<input type="hidden" value="<?php if(!empty($apis_velocify['detail'])){ echo $apis_velocify['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>


<div  class="DetailBox">
<div class="  form-new-holder">
	<h1>Velocify URL</h1>
	<input type="text" value="<?php if(!empty($apis_velocify['detail'])){ echo $apis_velocify['detail']->url; }?>" name="url" class="field kicksiteFields" placeholder="Enter Your URL"  />
</div>
</div>


<div class="form-white-holder  form-new-holder" >

	<input type="submit" name="velocify_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>
