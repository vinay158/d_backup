<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Tag</div>
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">

<div class="form-light-holder">
	<h1>Tag Name</h1>
	<input type="text" value="" name="tag" required="true" id="name" class="field" placeholder="Enter your tag here" />
</div>


<script>
<?php if(!empty($webhook_outgoing_apis)){ ?>
$(window).load(function(){
		var tag_types = $('.tag_types').val();
		$('.webhook_apis_box').hide();
		$('.webhook_apis').attr('required',false);
		if(tag_types == "webhook_outgoing_apis"){
			$('.webhook_apis_box').show();
			$('.webhook_apis').attr('required',true);
		}
	})
	
	$(document).ready(function(){
		$('.tag_types').change(function(){
			var tag_types = $(this).val();
			//alert(tag_types);
			$('.webhook_apis_box').hide();
			$('.webhook_apis').attr('required',false);
			if(tag_types == "webhook_outgoing_apis"){
				$('.webhook_apis_box').show();
				$('.webhook_apis').attr('required',true);
			}
		})
	})
<?php } ?>
</script>

<div class="form-light-holder" style="overflow:auto;">
			<h1 style="padding-bottom: 5px;">Tag Type</h1>
			<select class="field tag_types" name="tag_type">
				<?php foreach($tag_types as $key => $val){ ?>
				<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
				<?php } ?>
			</select>
		<div>
		</div>
</div>

<?php if(!empty($webhook_outgoing_apis)){ ?>
<div class="form-light-holder webhook_apis_box" style="overflow:auto; display:none">
			<h1 style="padding-bottom: 5px;">Webhook Outgoing Api's</h1>
			<?php foreach($webhook_outgoing_apis as $key => $webhook_api){ ?>
			<input type="checkbox" name="webhook_apis[]" value="<?php echo $webhook_api->id; ?>"><?php echo $webhook_api->api_name; ?> <br/>
			<?php } ?>
		<div>
		</div>
</div>
<?php } ?>


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
