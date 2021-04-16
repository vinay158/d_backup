
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#rainmaker .hidden_cb').val() == 0){
		$('#rainmaker .DetailBox').hide();
	}
	
	if($('#rainmaker .multi_rainmaker_hidden_cb').val() == 1){
		$('#rainmaker .DetailBox').hide();
	}
});
$(document).ready(function(){
$("#rainmaker .form-light-holder1 .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#rainmaker .form-light-holder1").children("#rainmaker .hidden_cb").val("0");
		$('#rainmaker .DetailBox').hide();
		$('#rainmaker .multi_rainmaker_hidden_cb').val(0);
		$('#rainmaker .multi_rainmaker_checkbox').removeClass("check-on");
		$('#rainmaker .multi_rainmaker_checkbox').addClass("check-off");
		$('#rainmaker .rainmakerFeild').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#rainmaker .form-light-holder1").children("#rainmaker .hidden_cb").val("1");
		$('.DetailBox').show();
		$('#rainmaker .rainmakerFeild').attr('required',true);
	}
	
	
})


$("#rainmaker .multi_rainmaker .multi_rainmaker_checkbox").click(function(){
	var rainmaker = $('#rainmaker .hidden_cb').val();
	if(rainmaker == 1){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents("#rainmaker .multi_rainmaker").children("#rainmaker .multi_rainmaker_hidden_cb").val("0");
				$('#rainmaker .DetailBox').show();
				$('#rainmaker .rainmakerFeild').attr('required',true);
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents("#rainmaker .multi_rainmaker").children("#rainmaker .multi_rainmaker_hidden_cb").val("1");
				$('#rainmaker .DetailBox').hide();
				$('#rainmaker .rainmakerFeild').attr('required',false);
			}
		}
})

})
</script>



		<div class="panel-body" id="rainmaker">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_rainmaker" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	
	$multi_rainmaker_check = 'check-off';
	
	if(!empty($apis_rainmaker['detail'])){
		if($apis_rainmaker['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
			if($apis_rainmaker['detail']->multi_rainmaker_check == 1){
				$multi_rainmaker_check = 'check-on';
			}else{
				$multi_rainmaker_check = 'check-off';
			}
		
		
	}
	
	
?>


<div class="form-light-holder1   form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">RainMaker</h1>
	<input type="hidden" value="<?php if(!empty($apis_rainmaker['detail'])){ echo $apis_rainmaker['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>

<?php if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder2 multi_rainmaker   form-new-holder">
	<a id="published" class="multi_rainmaker_checkbox <?php echo $multi_rainmaker_check; ?> " ></a>
	<h1 class="inline">Rainmaker accounts for each location?</h1>
	<input type="hidden" value="<?php if(!empty($apis_rainmaker['detail'])){ echo $apis_rainmaker['detail']->multi_rainmaker_check; } else{ echo 0; }?>" name="multi_rainmaker_check" class="multi_rainmaker_hidden_cb" />
</div>
<?php } ?>

<div  class="DetailBox">
<div class="  form-new-holder">
	<h1>School ID</h1>
	<input type="text" value="<?php if(!empty($apis_rainmaker['detail'])){ echo $apis_rainmaker['detail']->s_id; }?>" name="s_id" class="field rainmakerFeild" placeholder="Enter Your School Id"  />
</div>
<div class="  form-new-holder">
	<h1>API Key</h1>
	<input type="text" value="<?php if(!empty($apis_rainmaker['detail'])){ echo $apis_rainmaker['detail']->api_key; }?>" name="api_key" class="field rainmakerFeild"  placeholder="Enter Your RainMaker API Key"  />
</div>
</div>


<div class="form-white-holder   form-new-holder">

	<input type="submit" name="rainmaker_update" value="Save" class="btn-save"  />

</div>

</form>

		</div>

		</div>

		</div>
 

<!------------ recent items ----------------->


