<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<style>
.deleteCurrentRow img {
  margin-top: 11%;
}
</style>
<script language="javascript">

$(window).load(function(){
	if($('.required_mapping_fields_hidden_cb').val() == 1){
		$('.field_mapping_box').show();
	}else{
		$('.field_mapping_box').hide();
	}
})

$(document).on('click','.deleteCurrentRow',function(){
		$(this).parent().parent().remove();
	});
	
$(document).ready(function(){
	

$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
	}
});


$(".required_mapping_fields .required_mapping_fields_checkbox").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".required_mapping_fields_hidden_cb").val("0");
		$('.field_mapping_box').hide();
	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".required_mapping_fields_hidden_cb").val("1");
		$('.field_mapping_box').show();
	}

	});
	

})
</script>

<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name"><?php echo $title; ?></div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<div class="form-light-holder">
	<h1>Api Name</h1>
	<input type="text" value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->api_name : ''; ?>" name="api_name" required="true" id="webhook_title" class="" placeholder="Enter Api Name Here"  />
</div>
<div class="form-light-holder">
	<h1>Api Type</h1>
	<select name="type" class="field">
		<option value="unbounce" <?php echo ($webhook_api_detail->type == "unbounce") ? 'selected=selected' : '' ?>>Unbounce</option>
		<option value="zenplanner" <?php echo ($webhook_api_detail->type == "zenplanner") ? 'selected=selected' : '' ?>>Zenplanner</option>
	</select>
</div>

<div class="form-light-holder required_mapping_fields">
		<a id="status" class="required_mapping_fields_checkbox  <?php if($webhook_api_detail->required_mapping_fields == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<h1 class="inline">Required Mapping Fields?</h1>
		<input type="hidden" value="<?php echo $webhook_api_detail->required_mapping_fields; ?>" name="required_mapping_fields" class="required_mapping_fields_hidden_cb" />
</div>


 <div class="form-light-holder field_mapping_box">
        <h1><b>Field Name Mapping</b></h1>
		<div class="">
			<div class="adsUrl">
				<h1> Dojo field name </h1>
				<input value="first_name" class="field"  type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
			<h1> Api field name </h1>
				<input name="first_name" class="field" type="text" value="<?php echo $webhook_api_detail->name_key; ?>">
			</div>
			</div>
			
			
		<div class="">
			<div class="adsUrl">
				<input value="last_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->last_name_key; ?>" name="last_name" class="field" type="text">
			</div>
		</div>
		
		
			
		<div class="">
			<div class="adsUrl">
				<input value="email" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->email_key; ?>" name="email" class="field" type="text">
			</div>
		</div>
			
			
			
		<div class="">
			<div class="adsUrl">
				<input value="phone" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->phone_key; ?>" name="phone" class="field" type="text">
			</div>
		</div>
			
			
				
			
		<div class="">
			<div class="adsUrl">
				<input value="location" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->location_key; ?>" name="location" class="field" type="text">
			</div>
		</div>
			
			
			
				
			
		<div class="">
			<div class="adsUrl">
				<input value="message" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->message_key; ?>" name="message" class="field" type="text">
			</div>
		</div>
		
		<div class="">
			<div class="adsUrl">
				<input value="program" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->program_key; ?>" name="program" class="field" type="text">
				
			</div>
		</div>
		
		<div class="">
			<div class="adsUrl">
				<input value="ip_address" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->ip_address_key; ?>" name="ip_address" class="field" type="text">
			</div>
		</div>
		
		
		
		
		<div class="">
			<div class="adsUrl">
				<input value="page_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->page_name_key; ?>" name="page_name" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="page_id" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->page_id_key; ?>" name="page_id" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="page_url" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->page_url_key; ?>" name="page_url" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="variant" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->variant_key; ?>" name="variant" class="field" type="text">
			</div>
		</div>
		
		
		
		
		<div class="">
			<div class="adsUrl">
				<input value="school_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->school_name_key; ?>" name="school_name" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="school_url" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->school_url_key; ?>" name="school_url" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="inquiry_date" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->inquiry_date_key; ?>" name="inquiry_date" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="last_updated" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="<?php echo $webhook_api_detail->last_updated_key; ?>" name="last_updated" class="field" type="text">
				
				<p style="color:red;font-size:12px;"> Note: Please fill the API field name, if not filled <strong>Dojo field name</strong> will be considered.</p>
			</div>
		</div>
		
			
		
    </div>
	
	

	
<div class="form-light-holder">
	<a id="published" class="checkbox <?php echo (!empty($webhook_api_detail) && $webhook_api_detail->published == 1) ? 'check-on' : 'check-off'; ?>"></a>
	<h1 class="inline">Published?</h1>
	<input type="hidden" value="<?php echo !empty($webhook_api_detail) ? $webhook_api_detail->published :0; ?>" name="published" class="hidden_cb" />
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

<br style="clear:both"		 />
<input type="hidden" class="totalAddMoreFeatures" value="<?php echo !empty($webhook_api_detail_key_values) ? count($webhook_api_detail_key_values) : 1; ?>"  />
<script language="javascript" type="text/javascript">
 	
	$(document).ready(function(){
		
		
		
		$('.AddMoreButton').click(function(){
			var totalAddMoreFeatures = $('.totalAddMoreFeatures').val();
			var i = parseInt(totalAddMoreFeatures) + Number(1);
			$('.totalAddMoreFeatures').val(i);
			
				$('#AddMoreFeatures').append('<div class=""><div class="opreationHoursDiv"><h1> Key</h1><input value="" name="apiKeyValue['+i+'][key]" class="field" placeholder="Enter Key" type="text"></div><div class="opreationHoursDiv"><h1>Value</h1><input value="" name="apiKeyValue['+i+'][value]" class="field" placeholder="Enter Key Value" type="text"></div><div class="opreationHoursDiv"><a href="javascript:void(0)" class="deleteCurrentRow" ><img src="img/trash.png"></a></div><br style="clear:both"/></div>');
				
				
		});
	});	 
	
</script>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
