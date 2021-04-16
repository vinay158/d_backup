<!-- end head contents -->

<!---wysiwyg editor script -->

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#mystudio .hidden_cb').val() == 0){
		$('#mystudio .DetailBox').hide();
	}
	
	if($('#mystudio .multi_kicksite_hidden_cb').val() == 1){
		$('#mystudio .DetailBox').hide();
	}
});
$(document).ready(function(){
$("#mystudio .form-light-holder1 .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#mystudio .form-light-holder1").children("#mystudio .hidden_cb").val("0");
		$('#mystudio .DetailBox').hide();
		$('#mystudio .multi_kicksite_hidden_cb').val(0);
		$('#mystudio .multi_kicksite_checkbox').removeClass("check-on");
		$('#mystudio .multi_kicksite_checkbox').addClass("check-off");
		$('#mystudio .kicksiteFields').attr('required',false);
		
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#mystudio .form-light-holder1").children("#mystudio .hidden_cb").val("1");
		$('#mystudio .DetailBox').show();
		$('#mystudio .kicksiteFields').attr('required',true);
	}
	
	
})


$("#mystudio .multi_kicksite .multi_kicksite_checkbox").click(function(){
	var kicksite = $('#mystudio .hidden_cb').val();
	if(kicksite == 1){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents("#mystudio .multi_kicksite").children("#mystudio .multi_kicksite_hidden_cb").val("0");
				$('#mystudio .DetailBox').show();
				$('#mystudio .kicksiteFields').attr('required',true);
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents("#mystudio .multi_kicksite").children("#mystudio .multi_kicksite_hidden_cb").val("1");
				$('#mystudio .DetailBox').hide();
				$('#mystudio .kicksiteFields').attr('required',false);
			}
		}
})

})
</script>


		<div class="panel-body" id="mystudio">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_mystudio" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	
	$multi_mystudio_check = 'check-off';
	
	if(!empty($apis_mystudio['detail'])){
		if($apis_mystudio['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
		
			if($apis_mystudio['detail']->multi_mystudio_check == 1){
				$multi_mystudio_check = 'check-on';
			}else{
				$multi_mystudio_check = 'check-off';
			}
		
		
	}
	
	
?>


<div class="form-light-holder1  form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">MyStudio</h1>
	<input type="hidden" value="<?php if(!empty($apis_mystudio['detail'])){ echo $apis_mystudio['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>

<?php if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder1 multi_kicksite  form-new-holder">
	<a id="published" class="multi_kicksite_checkbox <?php echo $multi_mystudio_check; ?> " ></a>
	<h1 class="inline">MyStudio accounts for each location?</h1>
	<input type="hidden" value="<?php if(!empty($apis_mystudio['detail'])){ echo $apis_mystudio['detail']->multi_mystudio_check; } else{ echo 0; }?>" name="multi_mystudio_check" class="multi_kicksite_hidden_cb" />
</div>
<?php } ?>

<div  class="DetailBox">
<div class="  form-new-holder">
	<h1>MyStudio URL</h1>
	<input type="text" value="<?php if(!empty($apis_mystudio['detail'])){ echo $apis_mystudio['detail']->ms_url; }?>" name="ms_url" class="field kicksiteFields" placeholder="Enter Your URL"  />
	
</div>

</div>


<div class="form-white-holder  form-new-holder" >

	<input type="submit" name="mystudio_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>
