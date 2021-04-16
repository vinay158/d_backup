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



$('#parent_id').change(function(){
	var parent_api_name = $("#parent_id option:selected").text();
	var location_name = $("#location_id option:selected").text();
	
	var parent_id = $(this).val();
	var location_id = $("#location_id").val();
	
	$("#location_id").attr('required',false);
	if(parent_id != "" && location_id != ""){
		$('#webhook_title').val(parent_api_name + ' - '+location_name);
	}else if(parent_id != "" && location_id == ""){
		$('#webhook_title').val(parent_api_name);
		$("#location_id").attr('required',true);
	}
	
})

$('#location_id').change(function(){
	var parent_api_name = $("#parent_id option:selected").text();
	var location_name = $("#location_id option:selected").text();
	
	var parent_id = $("#parent_id").val();
	var location_id = $(this).val();
	
	if(parent_id != "" && location_id != ""){
		$('#webhook_title').val(parent_api_name + ' - '+location_name);
	}else if(parent_id != "" && location_id == ""){
		$('#webhook_title').val(parent_api_name);
	}
	
})

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

<?php if($multiWebhook == 1){?>
<div class="form-light-holder">
	<h1>Parent Webhook</h1>
	<select class="field" name="parent_id" id="parent_id">
		<option value="">-Select Webhook-</option>
		<?php foreach($allWebhooks as $webhook){ ?>
		<option value="<?php echo $webhook->id; ?>"><?php echo $webhook->api_name; ?></option>
		<?php } ?>
	</select>
</div>


<div class="form-light-holder">
	<h1>Location</h1>
	<select class="field" name="location_id" id="location_id">
		<option value="">-Select Location-</option>
		<?php foreach($allLocations as $location){ ?>
		<option value="<?php echo $location->id; ?>"><?php echo $location->name; ?></option>
		<?php } ?>
	</select>
</div>

<?php } ?>


<div class="form-light-holder">
	<h1>Api Name</h1>
	<input type="text" value="" name="api_name" required="true" id="webhook_title" class="" placeholder="Enter Api Name Here" />
</div>

<div class="form-light-holder">
	<h1>Api URL For Post</h1>
	<input type="text" value="" name="api_url" required="true" id="" class="" placeholder="Enter Api URL For Post Here" />
</div>


<div class="form-light-holder">
	<h1>Api Method</h1>
	<select name="api_method" class="field" required="true">
		<option value="POST">POST</option>
		<option value="GET">GET</option>
	</select>
</div>
<div class="form-light-holder">
	<h1>Api Type</h1>
	<select name="api_type" class="field" required="true">
		<option value="Email Auto-Responders" >Email Auto-Responders</option>
		<option value="CRM">CRM</option>
	</select>
</div>



 <div class="form-light-holder">
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
				<input value="trial_name" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="trial_name" class="field" type="text">
				
			</div>
		</div>
		
		<div class="">
			<div class="adsUrl">
				<input value="trial_type" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="trial_type" class="field" type="text">
				
			</div>
		</div>
		
		<div class="">
			<div class="adsUrl">
				<input value="total_amount" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="total_amount" class="field" type="text">
				
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
				<input value="tag" class="field" type="text" readonly="readonly">
			</div>
			<div class="linkTarget">
				<input value="" name="tag" class="field" type="text">
				<p style="color:red;font-size:12px;"> Note: Please fill the API field name, if not filled <strong>Dojo field name</strong> will be considered.</p>
			</div>
		</div> 
		
			
		
		
    </div>
	
	


 <div class="form-light-holder">
        <h1>Api key and value</h1>
		<div id="AddMoreFeatures">
			<div class=""><h3><a href="javascript:void(0);" class="AddMoreButton">Add More</a></h3></div>
			<div class="">
				<div class="opreationHoursDiv">
				<h1>Key</h1>
				<input value="" name="apiKeyValue[1][key]" class="field" placeholder="Enter Key" type="text">
			</div>
			<div class="opreationHoursDiv">
				<h1>Value</h1>
				<input value="" name="apiKeyValue[1][value]" class="field" placeholder="Enter Value" type="text">
			</div>
			<div class="opreationHoursDiv">
				<a href="javascript:void(0)" class="deleteCurrentRow" ><img src="img/trash.png"></a>
			</div>
			<br style="clear:both"/>
				</div>
			
		</div>
    </div>
	
	<!--<div class="form-light-holder">
	<h1>Api Tags</h1>
	<input type="text" value="" name="tag_values" id="" class="" placeholder="Enter Api Tags" />
</div>	 -->

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
<input type="hidden" class="totalAddMoreFeatures" value="1"  />
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
