<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>	-->
<script src="js/ckeditor_full/ckeditor.js"></script>
<!-- <script>
	$(document).ready(function(){
		
		CKEDITOR.replace(  'ckeditor_full',
									{  customConfig : 'config.js' }
						);
		
	});
</script> -->
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
					{ name: 'insert',      items : [ 'Link','oembed',  'addFile', 'addImage' ] },
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
<script language="javascript" type="text/javascript">

jQuery(document).ready(function(){
    $('#title').keyup(function(e){
            var max = 67;
            var len = $(this).val().length;
            if (len >= max) {
            	e.preventDefault();
                $('#charNum').text(' you have reached the limit');                
                $("#title").attr('maxlength',max);                            	          
            }else {
                var char = max - len;
                $('#charNum').text( char + ' characters left');
            }
	});
});

</script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Blog</h2>
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
	});

	$("#delete_img").click(function(){
				
		var news_id=$('#news_id').val();
		//alert(news_id); return false;
		var image_path=$('#img').attr('src');
					
		var mod_type = 'blogs';
		//alert(mod_type); return false;
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/delete',						
		data: { news_id : news_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			setTimeout("window.location.href='admin/blogs/edit/"+news_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

	
})

function limitText(limitField, limitCount, limitNum) {
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
		limitCount.value = limitNum - limitField.value.length;
	}
}

</script>
<div class="mb-3 main-content-label page_main_heading">Edit: Blog</div>
<?php if(!empty($details)): ?>
<?php foreach($details as $details) :?>
<div class="form-light-holder">
	<h1>Title</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->title);?>" name="title" id="title" class="field full_width_input" placeholder="Title of Blog Entry"/>
	<span id='charNum'></span>	
	<div class="ErrorMessage ErrorMessage_title"></div>
</div>

<div class="form-light-holder">
	<h1>URL Link</h1>
	<input type="text" value="<?=$details->slug?>" name="slug" id="slug" class="field full_width_input"/>
	<span> <em>(if left blank, URL will automatically be generated) </em> </span>
</div>



<div class="form-light-holder" style="">
	<h1>Blog Description</h1>
	<textarea name="content" id="ckeditor_full" class="ckeditor" placeholder="Enter a brief description of this entry for Search Engines."><?=$details->content;?></textarea>
	
	<!--<br />Enter a brief description of this entry for Search Engines.<br />
    <font size="1">(Maximum characters: 150)<br>You have <input readonly type="text" name="countdown" size="3" value="150" style="width: 30px;"> characters left.</font>-->
</div>



<div class="form-light-holder" style="overflow:auto;">
<h1 style="padding-bottom: 5px;">Choose a Photo</h1>
	<div class="custom-file half_width_custom_file">
			<input type="file" name="userfile" class="custom-file-input" id="customFile1"  accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<div>
	<?php if(!empty($details->image)) { echo "<img id='img' src='".$details->image."' width='120' >";
	}
	?>
	<input type="hidden" name="old-image" id="old-image" value="<?=$details->image?>" />
	
		</div>
	
	<?php if($details->image){ 
			echo "<a href='javascript:void(0);' class='delete_image_btn_new'  id='delete_img'>Delete image</a>";
			}
	?>	
	
</div>

<div class="form-light-holder">
	<h1>Image Alt</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->image_alt);?>" name="image_alt" id="image_alt" class="field full_width_input" placeholder="Image Alt tag"/>
</div>


<div class="form-light-holder" style="">
<h1>Meta Title</h1>
	<textarea name="meta_title" id="frm-text"><?=$details->meta_title?></textarea>
	
</div>

<!--<div class="form-light-holder" style="">
<h1>Meta Keyword</h1>
	<textarea name="meta_keyword" id="frm-text"><?=$details->meta_keyword?></textarea>
	
</div>-->


<div class="form-light-holder" style="">
<h1>Meta Description</h1>
	<textarea name="meta_desc" id="frm-text"><?=$details->meta_desc?></textarea>
	<br />Enter a brief description of this entry for Search Engines.
    
</div>



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
	<input type="text" value="<?=$details->publish_date?>" name="publish_date" id="publish_date" class="field" placeholder="mm/dd/yyyy" maxlength="10"/>	
</div>-->
<script>

	$(document).ready(function(){
		$('.publish_type').click(function(){
			var data = CKEDITOR.instances.ckeditor_full.getData();
			 data = data.replace("select", "tceles");
			CKEDITOR.instances.ckeditor_full.setData(data);
			
			////////////
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
			<input type="radio" name="publish_type" class="publish_type" value="publish_now" <?php if($details->publish_type == "publish_now"){ echo "checked=checked" ; } ?>>
			<span>Publish Now</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-9 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" name="publish_type" class="publish_type" value="publish_later" <?php if($details->publish_type == "publish_later"){ echo "checked=checked" ; } ?>>
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

<div class="form-light-holder publishDateBox"  style="<?php if($details->publish_type == "publish_now"){ echo 'display:none'; }else{ echo 'display:block'; } ?>">
	<h1>Publish Date</h1>
	<input type="text" value="<?=$details->timestamp?>" name="date" id="date" class="field" placeholder="mm/dd/yyyy" maxlength="10"/>	
	<div class="ErrorMessage ErrorMessage_date"></div>
</div>

<div class="form-light-holder">
	<h1>Body Id</h1>
	<input type="text" name="body_id" class="field" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->body_id); }?>">
</div>

<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($details->published == 1) echo "check-on"; else echo "check-off"; ?>"></a>
	<h1 class="inline">Published?</h1>
	<input type="hidden" value="<?=$details->published?>" name="published" class="hidden_cb" />
	<br/>
    <span class="note_for_publish">(Turn this off to make this article unpublished)</span>
</div>


<div class="form-light-holder">
	<a id="published" class="checkbox <?php if($details->hide_from_public_blog == 1) echo "check-on"; else echo "check-off"; ?>"></a>
	<h1 class="inline">Hide From Public Blog?</h1>
	<input type="hidden" value="<?=$details->hide_from_public_blog?>" name="hide_from_public_blog" class="hidden_cb" />
	<br/>
    <span class="note_for_publish">(Turn this off to make this article unpublished)</span>
</div>


<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>
<?php endforeach; ?>
<?php endif;?>
<input type="hidden" value="<?=$news_id?>" name="news_id" id="news_id" >	
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
