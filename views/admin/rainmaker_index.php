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
		$('.DetailBox').hide();
	}
	
	if($('.multi_rainmaker_hidden_cb').val() == 1){
		$('.DetailBox').hide();
	}
});
$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
		$('.DetailBox').hide();
		$('.multi_rainmaker_hidden_cb').val(0);
		$('.multi_rainmaker_checkbox').removeClass("check-on");
		$('.multi_rainmaker_checkbox').addClass("check-off");
		$('.rainmakerFeild').attr('required',false);
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
		$('.DetailBox').show();
		$('.rainmakerFeild').attr('required',true);
	}
	
	
})


$(".multi_rainmaker .multi_rainmaker_checkbox").click(function(){
	var rainmaker = $('.hidden_cb').val();
	if(rainmaker == 1){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents(".multi_rainmaker").children(".multi_rainmaker_hidden_cb").val("0");
				$('.DetailBox').show();
				$('.rainmakerFeild').attr('required',true);
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents(".multi_rainmaker").children(".multi_rainmaker_hidden_cb").val("1");
				$('.DetailBox').hide();
				$('.rainmakerFeild').attr('required',false);
			}
		}
})

})
</script>



<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		<div class="panel-title">

			<div class="panel-title-name"><?= $title ?></div>

		</div>

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">



<form id="blog_form" action="" method="post" enctype="multipart/form-data">



<?php
	$checkbox_check = 'check-off';
	
	$multi_rainmaker_check = 'check-off';
	
	if(!empty($detail)){
		if($detail->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
		
			if($detail->multi_rainmaker_check == 1){
				$multi_rainmaker_check = 'check-on';
			}else{
				$multi_rainmaker_check = 'check-off';
			}
		
		
	}
	
	
?>


<div class="form-light-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline"><?= $title ?></h1>
	<input type="hidden" value="<?php if(!empty($detail)){ echo $detail->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>

<?php if($multi_location[0]->field_value == 1){ ?>
<div class="form-light-holder multi_rainmaker">
	<a id="published" class="multi_rainmaker_checkbox <?php echo $multi_rainmaker_check; ?> " ></a>
	<h1 class="inline">Rainmaker accounts for each location?</h1>
	<input type="hidden" value="<?php if(!empty($detail)){ echo $detail->multi_rainmaker_check; } else{ echo 0; }?>" name="multi_rainmaker_check" class="multi_rainmaker_hidden_cb" />
</div>
<?php } ?>

<div  class="DetailBox">
<div class="form-light-holder">
	<h1>School ID</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->s_id; }?>" name="s_id" class="rainmakerFeild field" placeholder="Enter Your School Id"  />
</div>
<div class="form-light-holder">
	<h1>API Key</h1>
	<input type="text" value="<?php if(!empty($detail)){ echo $detail->api_key; }?>" name="api_key" class="rainmakerFeild field"  placeholder="Enter Your RainMaker API Key"  />
</div>
</div>


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

