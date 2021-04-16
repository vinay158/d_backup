
<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>

-->

<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<script language="javascript">
$(window).load(function(){
	if($('#active_campaign .hidden_cb').val() == 0){
		$('#active_campaign .DetailBox').hide();
	}
	
	/*if($('#active_campaign .multi_rainmaker_hidden_cb').val() == 1){
		$('#active_campaign .DetailBox').hide();
	} */
});
$(document).ready(function(){
$("#active_campaign .form-light-holder1 .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#active_campaign .form-light-holder1").children("#active_campaign .hidden_cb").val("0");
		$('#active_campaign .DetailBox').hide();
		$('#active_campaign .multi_rainmaker_hidden_cb').val(0);
		$('#active_campaign .multi_rainmaker_checkbox').removeClass("check-on");
		$('#active_campaign .multi_rainmaker_checkbox').addClass("check-off");
		$('#active_campaign .rainmakerFeild').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#active_campaign .form-light-holder1").children("#active_campaign .hidden_cb").val("1");
		$('.DetailBox').show();
		$('#active_campaign .rainmakerFeild').attr('required',true);
	}
	
	
})

/*
$("#active_campaign .multi_rainmaker .multi_rainmaker_checkbox").click(function(){
	var rainmaker = $('#active_campaign .hidden_cb').val();
	if(rainmaker == 1){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents("#active_campaign .multi_rainmaker").children("#active_campaign .multi_rainmaker_hidden_cb").val("0");
				$('#active_campaign .DetailBox').show();
				$('#active_campaign .rainmakerFeild').attr('required',true);
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents("#active_campaign .multi_rainmaker").children("#active_campaign .multi_rainmaker_hidden_cb").val("1");
				$('#active_campaign .DetailBox').hide();
				$('#active_campaign .rainmakerFeild').attr('required',false);
			}
		}
}) */

})
</script>



		<div class="panel-body" id="active_campaign">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="<?php echo base_url(); ?>admin/apis_manager/apis_active_campaign" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	
	//$multi_active_campaign_check = 'check-off';
	
	if(!empty($apis_active_campaign['detail'])){
		if($apis_active_campaign['detail']->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
			/*if($apis_active_campaign['detail']->multi_active_campaign_check == 1){
				$multi_active_campaign_check = 'check-on';
			}else{
				$multi_active_campaign_check = 'check-off';
			} */
		
		
	}
	
	
?>


<div class="form-light-holder1  form-new-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">Active Campaign</h1>
	<input type="hidden" value="<?php if(!empty($apis_active_campaign['detail'])){ echo $apis_active_campaign['detail']->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>

<?php /*if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder2 multi_rainmaker">
	<a id="published" class="multi_rainmaker_checkbox <?php echo $multi_active_campaign_check; ?> " ></a>
	<h1 class="inline">Active Campaign for each location?</h1>
	<input type="hidden" value="<?php if(!empty($apis_active_campaign['detail'])){ echo $apis_active_campaign['detail']->multi_active_campaign_check; } else{ echo 0; }?>" name="multi_active_campaign_check" class="multi_rainmaker_hidden_cb" />
</div>
<?php } */ ?>

<div  class="DetailBox">
<div class=" form-new-holder">
	<h1>Account Name</h1>
	<input type="text" value="<?php if(!empty($apis_active_campaign['detail'])){ echo $apis_active_campaign['detail']->account_name; }?>" name="account_name" class="field rainmakerFeild"  placeholder="Enter Your Active Campaign Account Name"  />
</div>
<div class=" form-new-holder">
	<h1>API Key</h1>
	<input type="text" value="<?php if(!empty($apis_active_campaign['detail'])){ echo $apis_active_campaign['detail']->api_key; }?>" name="api_key" class="field rainmakerFeild"  placeholder="Enter Your Active Campaign API Key"  />
</div>

<div class=" form-new-holder">
	<h1>User Name</h1>
	<input type="text" value="<?php if(!empty($apis_active_campaign['detail'])){ echo $apis_active_campaign['detail']->user_name; }?>" name="user_name" class="field rainmakerFeild"  placeholder="Enter Your Active Campaign User Name"  />
</div>

<?php /* if(!empty($apis_active_campaign['active_campagin_lists_list'])){ ?>
	<div class="" style="">
			<h1>Automation Lists</h1>
			<select name="automation_id" id="" class="field " >
				<option >-select Automation -</option>
				<?php foreach($apis_active_campaign['active_campagin_automation_list'] as $automation_list){ ?>
				<option value="<?= $automation_list['id']; ?>"  <?php if(!empty($apis_active_campaign['detail'])){ if($apis_active_campaign['detail']->automation_id == $automation_list['id']){ echo 'selected=selected'; } } ?>><?= $automation_list['name']; ?></option>
				<?php } ?>
			</select>
	</div>
<?php } */ ?>

<?php if(!empty($apis_active_campaign['active_campagin_lists_list'])){ ?>
	<div class=" form-new-holder" style="">
			<h1>Lists</h1>
			<select name="list_id" id="" class="field " >
				<option value="">-Select-</option>
				<?php foreach($apis_active_campaign['active_campagin_lists_list'] as $list){ ?>
				<option value="<?= $list['id']; ?>"  <?php if(!empty($apis_active_campaign['detail'])){ if($apis_active_campaign['detail']->list_id == $list['id']){ echo 'selected=selected'; } } ?>><?= $list['name']; ?></option>
				<?php } ?>
			</select>
	</div>
<?php } ?>
</div>


<div class="form-white-holder  form-new-holder">

	<input type="submit" name="active_campaign_update" value="Save" class="btn-save" />

</div>

</form>

		</div>

		</div>

		</div>
 
<!--<div style="clear:both"></div>	-->
<!------------ recent items ----------------->


