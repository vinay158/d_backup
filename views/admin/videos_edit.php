
<?php $this->load->view("admin/include/header");  ?>
<?php if(!empty($details)){?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: Video</h2>
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
<div class="mb-3 main-content-label page_main_heading">Edit: Video</div>

<form action="" method="post"  id="uploadform" enctype="multipart/form-data" onSubmit="javascript: return testUrlForMedia(this);">
<div class="form-light-holder" style="">
<h1>Category</h1>
<select name="category" id="category" class="field" >
<?php echo $this->query_model->getCategoryDropdownOptions('videos',0, 0,$details[0]->category); ?>
</select>
</div>


<!-- <div class="form-light-holder" style="">
<h1>Category</h1>
<select name="category" id="category" style="width: 100%; background:#FFF; border: none; border-radius: 5px; padding: 5px" >
<?php
if(!empty($cat)):
foreach($cat as $cat):
?>
<option value="<?=$cat->cat_id?>" <?php if($this->uri->segment(4) == $cat->cat_id) echo "selected='selected'";?>><?=$cat->cat_name?></option>
<?php
endforeach;
endif;
?>
</select>
</div> --->
<div  class="form-light-holder">
			<h1 class="descrip">Video caption</h1>
			<input type="text" name="description" value="<?php echo $details[0]->desc ?>" id="description" class="field full_width_input" />
			</div>
			
<div class="form-light-holder">
	<h1>Video URL</h1>
	<input type="text" name="embed" id="embed" class="field full_width_input" value="<?php echo $details[0]->link ?>" placeholder="Enter your video url" style=""/>
	<span><em>
	Youtube Example: - http://www.youtube.com/watch?v=27oySKIS6Xo<br/>
Vimeo Example: - https://vimeo.com/37865623 
	</em></span>
</div>



<div  class="form-light-holder">
<div class="row row-xs align-items-center">
	<div class="col-md-3">
		<label class="form-label mg-b-0"><h1>Upload Video Image</h1></label>
	</div>
	<div class="col-md-9  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-6">
		  <label class="rdiobox">
			<input type="radio" class="video_img_type" name="video_img_type" value="automatically" <?php if(!empty($details) && $details[0]->video_img_type == 'automatically'){ echo 'checked=checked'; } elseif(empty($details[0]->video_img_type)){  echo 'checked=checked'; } ?>    /> 
			<span> Automatically pull from youtube/vimeo</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-6 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="video_img_type" name="video_img_type" value="upload_image" <?php if(!empty($details) && $details[0]->video_img_type == 'upload_image'){ echo 'checked=checked'; }?> />
			<span>Upload custom image</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
	
</div>
</div>

<div class="form-light-holder welcome_video_image" style="overflow:auto;">
	<h1 style="padding-bottom: 5px;">Upload Video Thumbnail Image</h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="custom_video_thumbnail" class="custom-file-input" id="customFile4" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php 
		if(isset($details[0]->custom_video_thumbnail) && !empty($details[0]->custom_video_thumbnail)){
	?>
		<input name="old_custom_thumbnail_img" value="<?php echo $details[0]->custom_video_thumbnail; ?>" type="hidden" />
			<div id="img_left">
				<img style="width: 100px; clear:both;" src="<?=base_url().'upload/class_schedule/'.$details[0]->custom_video_thumbnail;?>" class="">
				<br/>
				<a href='javascript:void(0);' class='delete_image_btn_new' id='delete_img_left' number="<?php echo $details[0]->id; ?>">Delete image</a>
			</div>
				
	<?php 
		}
	?>
</div>
<script>
$(window).load(function(){
	$.each( $( ".video_img_type" ), function() {
		if($(this).attr('checked') == 'checked'){
			var video_imgradio_button_value = $(this).val();
				
			if(video_imgradio_button_value == "upload_image"){
				$('.welcome_video_image').show();
			}else{
				$('.welcome_video_image').hide();
			}
		}
	});
})
	$(document).ready(function(){
		
		$("#delete_img_left").click(function(){

			$('#img_left').remove();
			
			var image_path=$('#img_left').find('img').attr('src');
			var number=$(this).attr('number');
			
			$.ajax({ 					
			type: 'POST',						
			url: 'admin/albums/deleteVideoCustomImage',						
			data: {image_path:image_path,number:number}					
			}).done(function(msg){ 
			if(eval(msg) == 1){
				
			}
			});

		});
		
		$('.video_img_type').click(function(){
			var radio_button_value = $(this).val();
			
			if(radio_button_value == "automatically"){
				$('.welcome_video_image').hide();
			}
			if(radio_button_value == "upload_image"){
				$('.welcome_video_image').show();
						
				
			}
		});
	})
</script>

			


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
<div class="form-light-holder">
	<a id="published" class="checkbox <?php echo !empty($details[0]->published == 1) ? 'check-on ' : 'check-off'; ?>"></a>
	<h1 class="inline">Publish This</h1>
	<input type="hidden" value="<?php echo $details[0]->published ?>" name="published" id="publishedCheckbox" class="hidden_cb" />
</div>
	
			<input type='hidden' name='video_type' id ='video_type' value='<?php echo $details[0]->video_type ?>'/>
			<input type='hidden' name='video_id' id ='video_id' value='<?php echo $details[0]->video_id ?>'/>
			<input type="hidden" name="upload-type" value="2" id="upload-type" />
			<input type="hidden" name="id" value="<?php echo $details[0]->id; ?>" />
<script language="javascript" type="text/javascript">		
		
		function testUrlForMedia(form) {
			
			var pastedData; 			
			if(form.id=='operateform'){
				pastedData=$('#embed_edit').val();			
			}else{
				pastedData= $('#embed').val();
			}
			
			var success = false;
			var media   = {};	
			
			var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/;				
			
			if (pastedData.match(regExp)) {
				
			    if (pastedData.match('embed')) { youtube_id = pastedData.split(/embed\//)[1].split('"')[0]; }
			    else { youtube_id = pastedData.split(/v\/|v=|youtu\.be\//)[1].split(/[?&]/)[0]; }
			    media.type  = "youtube";
			    media.id    = youtube_id;
			    success = true;
			}
			else if (pastedData.match('https://(player.)?vimeo\.com') || pastedData.match('http://(player.)?vimeo\.com')) {
				
					if(pastedData.match('https://(player.)?vimeo\.com')){
			    		vimeo_id = pastedData.split(/video\/|https:\/\/vimeo\.com\//)[1].split(/[?&]/)[0];
					}
					
			    	if(pastedData.match('http://(player.)?vimeo\.com')){
			    		vimeo_id = pastedData.split(/video\/|http:\/\/vimeo\.com\//)[1].split(/[?&]/)[0];
			    	}
			    
			    media.type  = "vimeo";
			    media.id    = vimeo_id;			    
			    success = true;
			}
			else if (pastedData.match('http://player\.soundcloud\.com')) {
				
			    soundcloud_url = unescape(pastedData.split(/value="/)[1].split(/["]/)[0]);
			    soundcloud_id = soundcloud_url.split(/tracks\//)[1].split(/[&"]/)[0];
			    media.type  = "soundcloud";
			    media.id    = soundcloud_id;			    
			    success = true;
			}
			
			if (success){				 
				if(form.id=='operateform'){
									
					$('#video_type_edit').val(media.type);
					$('#video_id_edit').val(media.id);
					var src;
					if(media.type=='youtube'){
						src="http://img.youtube.com/vi/"+media.id+"/0.jpg";
						$('#cover_link').val(src);	
					}					
					
				}else{					
					$('#video_type').val(media.type);
					$('#video_id').val(media.id);
				}	
				return media; 
			}
			else { alert("No valid media id detected");
				return false;
			 }
				
			}		
		</script>


<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="hidden" value="<?='view/'.$this->uri->segment(4);?>" name="redirect" id="redirect" class="hidden_cb" />
	<input type="submit" name="submit" value="Save" class="btn-save" style="float:left;" />
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

<?php } ?>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
