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
})



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
	<input type="text" value="" name="api_name" required="true" id="webhook_title" class="" placeholder="Enter Api Name Here" />
</div>

<div class="form-light-holder">
	<h1>Api Type</h1>
	<select name="type" class="field">
		<option value="unbounce">Unbounce</option>
		<option value="zenplanner">Zenplanner</option>
	</select>
</div>

<div class="form-light-holder required_mapping_fields">
		<a id="status" class="required_mapping_fields_checkbox  check-off"></a>
		<h1 class="inline">Required Mapping Fields?</h1>
		<input type="hidden" value="0" name="required_mapping_fields" class="required_mapping_fields_hidden_cb" />
</div>

 <div class="form-light-holder field_mapping_box" style="display:none">
        <h1><b>Field Name Mapping</b></h1>
		<div class="">
			<div class="adsUrl">
				<h1> Dojo field name </h1>
				<input value="first_name" class="field"  type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
			<h1> Api field name </h1>
				<input value="" name="first_name" class="field" type="text">
			</div>
			</div>
			
			
		<div class="">
			<div class="adsUrl">
				<input value="last_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="last_name" class="field" type="text">
			</div>
		</div>
		
		
			
		<div class="">
			<div class="adsUrl">
				<input value="email" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="email" class="field" type="text">
			</div>
		</div>
			
			
			
		<div class="">
			<div class="adsUrl">
				<input value="phone" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="phone" class="field" type="text">
			</div>
		</div>
			
			
				
			
		<div class="">
			<div class="adsUrl">
				<input value="location" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="location" class="field" type="text">
			</div>
		</div>
			
			
			
				
			
		<div class="">
			<div class="adsUrl">
				<input value="message" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="message" class="field" type="text">
			</div>
		</div>
		
			
		<div class="">
			<div class="adsUrl">
				<input value="program" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="program" class="field" type="text">
			</div>
		</div>
		
		<div class="">
			<div class="adsUrl">
				<input value="ip_address" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="ip_address" class="field" type="text">
			</div>
		</div>
		
		
		
		
		<div class="">
			<div class="adsUrl">
				<input value="page_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="page_name" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="page_id" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="page_id" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="page_url" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="page_url" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="variant" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="variant" class="field" type="text">
			</div>
		</div>
		
		
		
		
		<div class="">
			<div class="adsUrl">
				<input value="school_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="school_name" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="school_url" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="school_url" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="inquiry_date" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="inquiry_date" class="field" type="text">
			</div>
		</div>
		<div class="">
			<div class="adsUrl">
				<input value="last_updated" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="last_updated" class="field" type="text">
				
				<p style="color:red;font-size:12px;"> Note: Please fill the API field name, if not filled <strong>Dojo field name</strong> will be considered.</p>
			</div>
		</div>
		
			
		
		
    </div>
	
	

<div class="form-light-holder">
	<a id="published" class="checkbox check-on"></a>
	<h1 class="inline">Published?</h1>
	<input type="hidden" value="1" name="published" class="hidden_cb" />
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

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
