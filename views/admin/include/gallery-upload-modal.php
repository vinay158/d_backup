<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="<?=THEMEPATH;?>themes/global/css/uploader/bootstrap.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?=THEMEPATH;?>themes/global/css/uploader/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?=THEMEPATH;?>themes/global/css/uploader/jquery.fileupload-ui-noscript.css"></noscript>
<!-- Generic page styles -->
<link rel="stylesheet" href="<?=THEMEPATH;?>themes/global/css/uploader/style.css">
<!-- Shim to make HTML5 elements usable in older Internet Explorer versions -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->


<script language="javascript" type="text/javascript">
	var file_uploaded = false;

	$(document).ready(function(){		
		/*$('#pix_submit').click(function(){			
			$('#btn-primary-start').trigger('click');		
		});
		$('#pix_refresh').click(function(){		
			window.location.reload()
		});*/

		$('#pix_refresh').click(function(){						
			$('#btn-primary-start').trigger('click');
			//window.location.reload();
			//setTimeout("window.location.reload()",1000);		
		}); 
			
	});

	var _uploadLimit =undefined;
</script>
<!-----
<link rel="stylesheet" type="text/css" media="screen" href="../../css/admin/login-style.css" />
----->

<div id="dropdown-holder" style="display: none">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;" class="drop-add-title">Add Media Items</div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>

			
	<!-- uploader code start -->				
			
	<?php if($category =='Photos'){ ?>
	<div class="dropdown-body">	
	<div class="form-item">
				<h1>Choose Gallery to upload with:</h1>
				<select name="upload_album" id="upload_album" style="width: 100%;">
				<?php foreach($album as $album): ?>
				<option <?php if($album->id == $this->uri->segment(4)) echo 'selected="selected"'; ?> value="<?=$album->id?>"><?=$album->album?></option>
				<?php endforeach;?>
				</select>
			</div>
	
	<div id="fileupload_section" >
    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="" method="POST" enctype="multipart/form-data" >
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <!--<noscript><input type="hidden" name="redirect" value="http://blueimp.github.com/jQuery-File-Upload/"></noscript>
        --><!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn _btn-success fileinput-button">
                    <!-- <i class="icon-plus icon-white"></i>
                    <span>Add files...</span> -->
                    <input type="file"  name="files[]" multiple accept='image/*' />                    
                </span>
               <!--  <span>PLEASE CLICK ON "UPLOAD" TO ADD YOUR PHOTOS</span> -->
                <button type="submit" id='btn-primary-start' class="btn btn-primary start" style='display:none'>
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <!-- <button type="reset" class="btn btn-warning cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                -->
                <!-- <button type="button" class="btn btn-danger delete">
                    <i class="icon-trash icon-white"></i>
                    <span>Delete</span>
                </button>
                
                <input type="checkbox" class="toggle"> -->
            </div>
            <!-- The global progress information -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar" style="width:0%;"></div>
                </div>
                <!-- The extended global progress information -->
                <!--<div class="progress-extended">&nbsp;</div>
            --></div>
        </div>
        <!-- The loading indicator is shown during file processing -->
        <div class="fileupload-loading"></div>        
        <div style="overflow: auto; position: relative; cursor: default; max-height: 200px;">
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
        </div>
    </form>
    </div>
    <span style="margin-left:50px">Please click the button below to add your photos. This window will close automatically when upload complete.</span>
    <br>        


<!-- modal-gallery is the modal dialog used for the image gallery -->
<div id="modal-gallery" class="modal modal-gallery hide fade" data-filter=":odd" tabindex="-1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h3 class="modal-title"></h3>
    </div>
    <div class="modal-body"><div class="modal-image"></div></div>
    <div class="modal-footer">
        <a class="btn modal-download" target="_blank">
            <i class="icon-download"></i>
            <span>Download</span>
        </a>
        <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000">
            <i class="icon-play icon-white"></i>
            <span>Slideshow</span>
        </a>
        <a class="btn btn-info modal-prev">
            <i class="icon-arrow-left icon-white"></i>
            <span>Previous</span>
        </a>
        <a class="btn btn-primary modal-next">
            <span>Next</span>
            <i class="icon-arrow-right icon-white"></i>
        </a>
    </div>
</div>


<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview" colspan='2'><span class="fade"></span></td>
        <td class="name"><span>{%=file.name.substring(0,20)%}</span></td>
        <td class="size" style="display:none"><span >{%=o.formatFileSize(file.size)%}</span></td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td style="display:none">
                <div style='max-width:5px' class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start" style='display:none'>{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary" >
                    <i class="icon-upload icon-white"></i>
                    <span>Start</span>
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel" colspan='3'>{% if (!i) { %}
            <button class="btn btn-warning">
                <!--<i class="icon-ban-circle icon-white"></i>
                <span>Remove</span> -->
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">

{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade" >		
        {% if (file.error) { %}            
            <td class="name"><span>{%=file.name.substring(0,20)%}</span></td>
            <td class="size" style="display:none"><span >{%=o.formatFileSize(file.size)%}</span></td>
            <td class="error" colspan="2"><span class="label label-important">Error</span> {%=file.error%}</td>
        {% } else { %}
			
			<td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name.substring(0,20)%}" data-gallery="gallery" download="{%=file.name.substring(0,20)%}"><img height='80' width='100' src="{%=file.thumbnail_url%}"></a>
            {% } %}</td>
			
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name.substring(0,20)%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name.substring(0,20)%}">{%=file.name.substring(0,20)%}</a>
            </td>
            <td class="size" style='display:none'><span >{%=o.formatFileSize(file.size)%}</span></td>            
        {% } %}
        <!--<td class="delete">
            <button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span>Delete</span>
				<input type="checkbox" name="delete" value="1">
            </button>            
        </td>--> 
    </tr>
{% } %}

</script>
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script> -->
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->

<script src="<?=THEMEPATH;?>themes/global/js/uploader/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?=THEMEPATH;?>themes/global/js/uploader/tmpl.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?=THEMEPATH;?>themes/global/js/uploader/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?=THEMEPATH;?>themes/global/js/uploader/jquery.fileupload.js"></script>
<!-- The File Upload file processing plugin -->
<script src="<?=THEMEPATH;?>themes/global/js/uploader/jquery.fileupload-fp.js"></script>
<!-- The File Upload user interface plugin -->
<script src="<?=THEMEPATH;?>themes/global/js/uploader/jquery.fileupload-ui.js"></script>
<!-- The main application script -->
<script src="<?=THEMEPATH;?>themes/global/js/uploader/main.js"></script>
<!-- The XDomainRequest Transport is included for cross-domain file deletion for IE8+ -->
<!--[if gte IE 8]><script src="js/cors/jquery.xdr-transport.js"></script><![endif]-->				
				
</div>				
<div class="dropdown-bottom">
	<div style="padding:10px 20px">
	<!--<input type="button" name="submit" value="Upload" id='pix_submit'   style='margin-left:5px;margin-top: 5px' class="btn-sav" style="float:left;" >
	<input type="button" name="refresh" value="Save & Close" id='pix_refresh' style='margin-left:5px;margin-top: 5px' class="btn-sav"  style="float:left;" >
	-->
	<input type="button" name="submit" value="Upload" id='pix_submit' class="btn-upload" style="margin-left:5px;margin-top:5px;float:left;display:none" >	
	<!-- <img id='pix_refresh' src='<?=THEMEPATH;?>themes/global/img/admin/SaveandClose.png' style='margin:5px !important;'/> -->
    <img id='pix_refresh' src='<?=THEMEPATH;?>themes/global/img/admin/btn-upload.png' style='margin:5px !important;'/>
	</div>		
</div>		
	<!-- uploader code end -->
		
	<?php }elseif($category =='Videos'){ ?>
	<div class="dropdown-body">
			
	 <form action="admin/<?=$link_type?>/uploadMedia" method="post" id="uploadform" enctype="multipart/form-data" onSubmit="javascript: return testUrlForMedia(this);">
			<div class="form-item">
				<h1>Choose Gallery to upload with:</h1>
				<select name="upload_album" id="upload_album" style="width: 100%;">
				<?php 
				foreach($album as $album):
					$week_academy_title = '';
					if(isset($album->week_academy_id) && !empty($album->week_academy_id)){
						
						$this->db->select('title');
						$week_academy = $this->query_model->getBySpecific('tbl_8_week_academy','id',$album->week_academy_id);
						
						$week_academy_title = !empty($week_academy) ? '-'. $week_academy[0]->title : '';
					}
					
				?>
				<option <?php if($album->id == $this->uri->segment(4)) echo 'selected="selected"'; ?> value="<?=$album->id?>"><?=$album->album?> <?php echo $week_academy_title; ?> </option>
				<?php endforeach;?>
				</select>
			</div>
						
			<?php
			
			
			$val='';			
			if($category =='Photos'):
				$val=1;				
			elseif($category =='Videos'):			 
				$val=2;?>
			<input type='hidden' name='video_type' id ='video_type' value=''/>
			<input type='hidden' name='video_id' id ='video_id' value=''/>
			 <?php endif; ?>	
			<input type="hidden" name="upload-type" value="<?=$val?>" id="upload-type" />
			<input type="hidden" name="referer"  value="<?=$_SERVER['REDIRECT_QUERY_STRING']?>" id="upload-type" />
						
			
			
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
				<textarea name="embed" id="embed" rows="2" style='width:100%'></textarea>
				<br/>
				<!-- <span>Example: You can place url like - http://www.youtube.com/watch?v=27oySKIS6Xo<br/>
					 You can add video url of youtube.com and vimeo.com.	</span>-->
					 <span>
					   Youtube Example:  - http://www.youtube.com/watch?v=27oySKIS6Xo<br/>
        			   Vimeo Example:  - https://vimeo.com/37865623
        			  </span>
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
			<input type="submit" name="submit" value="Save" class="btn-save" style="float:left;" >
		    </form>
		   
		</div>
		
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
		
		<?php } ?>		
	
</div>
</div>
