<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<!--<script>
	$(document).ready(function(){
		 
		CKEDITOR.replace(  'ckeditor_full',
									{  customConfig : 'config.js' }
						);
		
	});
</script>-->

<script>
	$(document).ready(function(){
		
		// Create a classic editor using inline configuration
			var uploadUrl = '<?php echo base_url(); ?>js/ckfinder/core/connector/php/connector.php?command=QuickUpload';

			var config = {
				 
				customConfig : '',
				// Add the required plugin
			   
				language: 'eg',
				uiColor: '#FAFAFA',
				height : 300,
				autoGrow_onStartup : true,
				extraPlugins : 'simpleuploads,oembed,lineheight',
				line_height : "8px;9px;10px;11px;12px;14px;16px;18px;20px;22px;24px;26px;28px;36px;48px;72px;",
				allowedContent : true,
				// Required config to tell CKEditor what's the script that will process uploads
				filebrowserUploadUrl : uploadUrl + '&type=Files',
				filebrowserImageUploadUrl : uploadUrl + '&type=Images',
				toolbar :	// Sample toolbar
				[
					{ name: 'document',    items : [ 'Source' ] },
					{ name: 'clipboard',   items : [  'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'] },
					{ name: 'editing', items : [ 'Scayt' ] },
					{ name: 'links', items : [ 'Link', 'Unlink', 'Anchor' ] },
					'/',
					{ name: 'basicstyles', items : [ 'Bold', 'Italic', 'Underline',  '-', 'RemoveFormat'] },
					{ name: 'paragraph', items : ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'] },
					'/',
					{ name: 'styles', items : ['Styles', 'Format', 'Font', 'FontSize','lineheight'] },
					{ name: 'colors', items : [ 'TextColor', 'BGColor'] },
					{ name: 'insert',      items : [ 'Image','Link','oembed',  'addFile', 'addImage' ] },
					{ name: 'tools',       items : [ 'Maximize', 'ShowBlocks'  ] }
				],

				// Define the file extensions (whitelist) that are allowed to upload.
				// This is a client side check. You must do the same validation on your server.
				// By default CKEditor doesn't implement this kind of check, so users can waste time and bandwith uploading files only to get an error message later
				// So setting this correctly can help your users greatly
				simpleuploads_acceptedExtensions : '7z|avi|csv|doc|docx|flv|gif|gz|gzip|jpeg|jpg|mov|mp3|mp4|mpc|mpeg|mpg|ods|odt|pdf|png|ppt|pxd|rar|rtf|tar|tgz|txt|vsd|wav|wma|wmv|xls|xml|zip'
			};

			CKEDITOR.replace( 'ckeditor_full', config );
	
		/**CKEDITOR.replace(  'ckeditor_full',
									{  customConfig : 'config-custom.js' }
						); **/
		
	});
</script>
<div class="az-content-body-left  advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add: News Post</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">		
		<div class="form-holder">

<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<style>
.ErrorMessage{color:#FF0000}
</style>
<script language="javascript">
$(document).ready(function(){
	$('.btn-save').click(function(){
		
	var error = true;
		if($('#title').val() == ''){
			$('.ErrorMessage_title').html(' *News Title is Required');
			error = false;
		}
		
		 var publishType = $('.publish_type').val();
		if(publishType == "publish_later"){
			 if($('.hasDatepicker').val() == ''){
				$('.ErrorMessage_date').html(' *News Date is Required');
				error = false;
			}
		}
	return error;
	});
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
})

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}
</script>
<div class="mb-3 main-content-label page_main_heading">Add: News Post</div>
<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="" name="title" id="title" class="field full_width_input" placeholder="Title of News Entry" style=""/>	
	<div class="ErrorMessage ErrorMessage_title"></div>
</div>

<!--<div class="form-light-holder">
	<h1>URL Link</h1>
	<input type="text" value="" name="slug" id="slug" class="field"/>&nbsp;
    (if left blank, URL will automatically be generated)
</div>-->

<div class="form-light-holder" style="">
	<h1>News Story</h1>
	<textarea name="content" id="ckeditor_full"  class="ckeditor" placeholder="Enter a brief description of this entry for Search Engines."></textarea>
   <!-- <br />Enter a brief description of this entry for Search Engines.
    <br />
    <font size="1">(Maximum characters: 150)<br>You have <input readonly type="text" name="countdown" size="3" value="150" style="width: 30px;"> characters left.</font>-->
</div>

 

<div class="form-light-holder" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	
	<div class="custom-file half_width_custom_file">
			<input type="file" name="userfile" class="custom-file-input" id="customFile1"  accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	
</div>

<script>
	$(document).ready(function(){
		$('.publish_type').click(function(){
		
			var value = $(this).val();
			
			if(value == "publish_later"){
				$('.publishDateBox').show();
			}else{
				$('.publishDateBox').hide();
			}
			
		});
	});
</script>

<div class="form-light-holder">
<div class="row row-xs align-items-center">
	
	<div class="col-md-12  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-2">
		  <label class="rdiobox">
			<input type="radio" name="publish_type" class="publish_type" value="publish_now" checked="checked">
			<span>Publish Now</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" name="publish_type" class="publish_type" value="publish_later">
			<span>Publish at Later Date </span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>
</div>


 <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script>
    $(function() {
        $( "#date" ).datepicker({ dateFormat: "yy-mm-dd" });
		$( "#publish_date" ).datepicker({ dateFormat: "yy-mm-dd" });
    });
    </script>

<div class="form-light-holder publishDateBox" style="display:none">
	<h1>Publish Date</h1>
	<input type="text" value="" name="date" id="date" class="field" placeholder="mm/dd/yyyy" maxlength="10"/>	
	<div class="ErrorMessage ErrorMessage_date"></div>
</div>


<!--<div class="form-light-holder">
	<h1>Image Alt</h1>
	<input type="text" value="" name="image_alt" id="image_alt" class="field" placeholder="Image Alt tag"/>
</div>

<div class="form-light-holder" style="">
	<h1>Description text</h1>
	<textarea name="meta_desc" class="" id="frm-text"></textarea>
	<br />Enter a brief description of this entry for Search Engines.
    <br />
    <font size="1">(Maximum characters: 150)<br>You have <input readonly type="text" name="countdown" size="3" value="150" style="width: 30px;"> characters left.</font>
</div>-->

<script language="javascript">
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
})
</script>

<!--<div class="form-light-holder">
	<h1>Publish Date</h1>
	<input type="text" value="" name="publish_date" id="publish_date" class="field" placeholder="mm/dd/yyyy" maxlength="10"/>
</div>-->

<div class="form-light-holder publishedBox">
	<a id="published" class="checkbox check-on"></a>
	<h1 class="inline">Published?</h1>
	<input type="hidden" value="1" name="published" class="hidden_cb" />
	<br/>
    <span class="note_for_publish"> (Turn this off to make this article unpublished)</span>
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

</div>
</div>
</div>
</div>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
