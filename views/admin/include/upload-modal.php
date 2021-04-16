<script language="javascript" type="text/javascript">

		function testUrlForMedia() {
			var success = false;
			var media   = {};	
			pastedData= $('#embed').val();

			var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/;				
			
			if (pastedData.match(regExp)) {
				
			    if (pastedData.match('embed')) { youtube_id = pastedData.split(/embed\//)[1].split('"')[0]; }
			    else { youtube_id = pastedData.split(/v\/|v=|youtu\.be\//)[1].split(/[?&]/)[0]; }
			    media.type  = "youtube";
			    media.id    = youtube_id;
				$('#video_type').val(media.type);
				$('#video_id').val(media.id);	
			    
			    success = true;
			}
			else if (pastedData.match('http://(player.)?vimeo\.com')) {
				
			    vimeo_id = pastedData.split(/video\/|http:\/\/vimeo\.com\//)[1].split(/[?&]/)[0];
			    media.type  = "vimeo";
			    media.id    = vimeo_id;
			    $('#video_type').val(media.type);
				$('#video_id').val(media.id);
			    
			    success = true;
			}
			/*else if (pastedData.match('http://player\.soundcloud\.com')) {
				alert(pastedData+'S');
			    soundcloud_url = unescape(pastedData.split(/value="/)[1].split(/["]/)[0]);
			    soundcloud_id = soundcloud_url.split(/tracks\//)[1].split(/[&"]/)[0];
			    media.type  = "soundcloud";
			    media.id    = soundcloud_id;
			    $('#video_type').val(media.type);
				$('#video_id').val(media.id);
			    success = true;
			}*/
			
			if (success) { return media; }
			else { alert("No valid media id detected"); }
				return false;
			}

			/*
			$(document).ready(function(){
			$(".dd-upload-btn").click(function(){
			$(".descrip").text("Description");
			$(this).addClass("active");
			$(".dd-embed-btn").removeClass("active");
			$("#upload-type").val(1);
			$("#embed-code").hide();
			$("#image-upload").show();			
			});
			$(".dd-embed-btn").click(function(){
			$(this).addClass("active");
			$(".dd-upload-btn").removeClass("active");
			$(".descrip").text("Video ID");
			$("#embed-code").show();
			$("#upload-type").val(2);
			$("#image-upload").hide();
			});
			});
			*/
			
			</script>



<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/dropdown.css" />
<!-----
<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/login-style.css" />
----->

<div id="dropdown-holder" style="display: none">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;" class="drop-add-title">Add Media Items</div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>

		<div class="dropdown-body">
		    <form action="admin/<?=$link_type?>/uploadMedia" method="post" id="operateform" enctype="multipart/form-data" onSubmit="return testUrlForMedia();">
			<div class="form-item">
				<h1>Choose Gallery to upload with:</h1>
				<select name="upload_album" id="upload_album" style="width: 100%;">
				<?php foreach($album as $album): ?>
				<option <?php if($album->id == $this->uri->segment(4)) echo "selected='selected'"; ?>value="<?=$album->id?>"><?=$album->album?></option>
				<?php endforeach;?>
				</select>
			</div>
						
			<?php
			
			
			$val='';			
			if($category =='Photos'):
				$val=1;				
			elseif($category =='Videos'): 
				$val=2;
			 endif; ?>	
			<input type="hidden" name="upload-type" value="<?=$val?>" id="upload-type" />
			<input type="hidden" name="referer"  value="<?=$_SERVER['REDIRECT_QUERY_STRING']?>" id="upload-type" />
			<input type='hidden' name='video_type' id ='video_type' value=''/>
			<input type='hidden' name='video_id' id ='video_id' value=''/>			
			
			
			<div class="dropdown-tabbar">
			<?php if($category =='Photos'): ?>
				<a id="dd-upload" class="dd-upload-btn active">Upload</a>
			<?php elseif($category =='Videos'): ?>
				<a id="dd-embed" class="dd-embed-btn">Add Embed Code</a>
			<?php endif; ?>	
			</div>
			<?php if($category =='Photos'): ?>
			<div id="image-upload">
			<div class="form-item">
			<input type="file" name="userfile" id="userfile" accept="image/x-png, image/gif, image/jpeg" multiple="multiple"/>
			</div>
			<div class="form-item">			
					<h1>Upload Images. </h1>
					Supported File Formats: jpg, gif, png only.
			</div>			
			<hr />
			<div  class="form-item">
			<h1 class="descrip">Photo caption</h1>
			<input type="text" name="description" id="description" />
			</div>
			
			</div>
			<?php elseif($category =='Videos'): ?>
			<div id="embed-code" >
				<div class="form-item">
				<h1>Video URL</h1>
				<textarea name="embed" rows="2" id="embed"></textarea>
				<span>Example: You can place url like - www.youtube.com/watch?v=27oySKIS6Xo<br/>
					 You can add video url of youtube.com and vimeo.com.	</span>
				</div>
				
				
			</div>
			<hr />
			<div  class="form-item">
			<h1 class="descrip">Video caption</h1>
			<input type="text" name="description" id="description" />
			</div>
			<?php endif; ?>
			
		</div>
		<div class="dropdown-bottom">
			<input type="submit" name="submit" value="Save" class="btn-save" style="float:left;" onClick="javascript: testUrlForMedia();">
		    </form>
		</div>
	</div>
</div>