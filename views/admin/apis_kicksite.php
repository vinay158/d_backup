<!-- end head contents -->

<!---wysiwyg editor script -->

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#kicksite .hidden_cb').val() == 0){
		$('#kicksite .DetailBox').hide();
	}
	
	if($('#kicksite .multi_kicksite_hidden_cb').val() == 1){
		$('#kicksite .DetailBox').hide();
	}
});
$(document).ready(function(){
$("#kicksite .form-light-holder1 .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#kicksite .form-light-holder1").children("#kicksite .hidden_cb").val("0");
		$('#kicksite .DetailBox').hide();
		$('#kicksite .multi_kicksite_hidden_cb').val(0);
		$('#kicksite .multi_kicksite_checkbox').removeClass("check-on");
		$('#kicksite .multi_kicksite_checkbox').addClass("check-off");
		$('#kicksite .kicksiteFields').attr('required',false);
		
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#kicksite .form-light-holder1").children("#kicksite .hidden_cb").val("1");
		$('#kicksite .DetailBox').show();
		$('#kicksite .kicksiteFields').attr('required',true);
	}
	
	
})


$("#kicksite .multi_kicksite .multi_kicksite_checkbox").click(function(){
	var kicksite = $('#kicksite .hidden_cb').val();
	if(kicksite == 1){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents("#kicksite .multi_kicksite").children("#kicksite .multi_kicksite_hidden_cb").val("0");
				$('#kicksite .DetailBox').show();
				$('#kicksite .kicksiteFields').attr('required',true);
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents("#kicksite .multi_kicksite").children("#kicksite .multi_kicksite_hidden_cb").val("1");
				$('#kicksite .DetailBox').hide();
				$('#kicksite .kicksiteFields').attr('required',false);
			}
		}
})

})
</script>


		<div class="panel-body" id="kicksite">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_kicksite" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	
	$multi_kicksite_check = 'check-off';
	
	if(!empty($apis_kicksite['detail'])){
		if($apis_kicksite['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
		
			if($apis_kicksite['detail']->multi_kicksite_check == 1){
				$multi_kicksite_check = 'check-on';
			}else{
				$multi_kicksite_check = 'check-off';
			}
		
		
	}
	
	
?>


<div class="form-light-holder1   form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Kicksite</h1>
	<input type="hidden" value="<?php if(!empty($apis_kicksite['detail'])){ echo $apis_kicksite['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>

<?php if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder1 multi_kicksite   form-new-holder">
	<a id="published" class="multi_kicksite_checkbox <?php echo $multi_kicksite_check; ?> " ></a>
	<h1 class="inline">Kicksite accounts for each location?</h1>
	<input type="hidden" value="<?php if(!empty($apis_kicksite['detail'])){ echo $apis_kicksite['detail']->multi_kicksite_check; } else{ echo 0; }?>" name="multi_kicksite_check" class="multi_kicksite_hidden_cb" />
</div>
<?php } ?>

<div  class="DetailBox">
<div class="  form-new-holder">
	<h1>Kicksite URL</h1>
	<input type="text" value="<?php if(!empty($apis_kicksite['detail'])){ echo $apis_kicksite['detail']->ks_url; }?>" name="ks_url" class="field kicksiteFields" placeholder="Enter Your URL"  />
	EX: "https://staging.kicksite.net/prospects/new_prospect"
</div>
<div class="  form-new-holder">
	<h1>Kicksite Token</h1>
	<input type="text" value="<?php if(!empty($apis_kicksite['detail'])){ echo $apis_kicksite['detail']->ks_token; }?>" name="ks_token" class="field kicksiteFields"  placeholder="Enter Your Kicksite Token"  />
</div>
</div>


<div class="form-white-holder   form-new-holder">

	<input type="submit" name="kicksite_update" value="Save" class="btn-save" />

</div>

</form>

		</div>

		</div>

		</div>
