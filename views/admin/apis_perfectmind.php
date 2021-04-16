
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#perfectmind .hidden_cb').val() == 0){
		$('#perfectmind .DetailBox').hide();
	}
	
	if($('#perfectmind .multi_rainmaker_hidden_cb').val() == 1){
		$('#perfectmind .DetailBox').hide();
	}
});
$(document).ready(function(){
$("#perfectmind .form-light-holder1 .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#perfectmind .form-light-holder1").children("#perfectmind .hidden_cb").val("0");
		$('#perfectmind .DetailBox').hide();
		$('#perfectmind .multi_rainmaker_hidden_cb').val(0);
		$('#perfectmind .multi_rainmaker_checkbox').removeClass("check-on");
		$('#perfectmind .multi_rainmaker_checkbox').addClass("check-off");
		$('#perfectmind .rainmakerFeild').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#perfectmind .form-light-holder1").children("#perfectmind .hidden_cb").val("1");
		$('.DetailBox').show();
		$('#perfectmind .rainmakerFeild').attr('required',true);
	}
	
	
})


$("#perfectmind .multi_rainmaker .multi_rainmaker_checkbox").click(function(){
	var rainmaker = $('#perfectmind .hidden_cb').val();
	if(rainmaker == 1){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents("#perfectmind .multi_rainmaker").children("#perfectmind .multi_rainmaker_hidden_cb").val("0");
				$('#perfectmind .DetailBox').show();
				$('#perfectmind .rainmakerFeild').attr('required',true);
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents("#perfectmind .multi_rainmaker").children("#perfectmind .multi_rainmaker_hidden_cb").val("1");
				$('#perfectmind .DetailBox').hide();
				$('#perfectmind .rainmakerFeild').attr('required',false);
			}
		}
})

})
</script>



		<div class="panel-body" id="perfectmind">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_perfectmind" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	
	$multi_perfectmind_check = 'check-off';
	
	if(!empty($apis_perfectmind['detail'])){
		if($apis_perfectmind['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
			if($apis_perfectmind['detail']->multi_perfectmind_check == 1){
				$multi_perfectmind_check = 'check-on';
			}else{
				$multi_perfectmind_check = 'check-off';
			}
		
		
	}
	
	
?>


<div class="form-light-holder1  form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Perfectmind</h1>
	<input type="hidden" value="<?php if(!empty($apis_perfectmind['detail'])){ echo $apis_perfectmind['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>

<?php if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder2 multi_rainmaker   form-new-holder">
	<a id="published" class="multi_rainmaker_checkbox <?php echo $multi_perfectmind_check; ?> " ></a>
	<h1 class="inline">Perfectmind accounts for each location?</h1>
	<input type="hidden" value="<?php if(!empty($apis_perfectmind['detail'])){ echo $apis_perfectmind['detail']->multi_perfectmind_check; } else{ echo 0; }?>" name="multi_perfectmind_check" class="multi_rainmaker_hidden_cb" />
</div>
<?php } ?>
<div class="  form-new-holder">
	<h1>Subdomain</h1>
	<input type="text" value="<?php if(!empty($apis_perfectmind['detail'])){ echo $apis_perfectmind['detail']->subdomain; }?>" name="subdomain" class="field rainmakerFeild" placeholder="Enter Your Subdomain"  />
</div>

<div  class="DetailBox">
<div class="  form-new-holder">
	<h1>Access Key</h1>
	<input type="text" value="<?php if(!empty($apis_perfectmind['detail'])){ echo $apis_perfectmind['detail']->perfectmind_access_key; }?>" name="perfectmind_access_key" class="field rainmakerFeild" placeholder="Enter Your Access Key"  />
</div>
<div class="  form-new-holder">
	<h1>Client Number</h1>
	<input type="text" value="<?php if(!empty($apis_perfectmind['detail'])){ echo $apis_perfectmind['detail']->perfectmind_client_number; }?>" name="perfectmind_client_number" class="field rainmakerFeild"  placeholder="Enter Your Client Number"  />
</div>
</div>


<div class="form-white-holder  form-new-holder" >

	<input type="submit" name="perfectmind_update" value="Save" class="btn-save" />

</div>

</form>

		</div>

		</div>

		</div>
 

<!------------ recent items ----------------->


