<!-- Force latest IE rendering engine or ChromeFrame if installed -->
<!-- Bootstrap CSS Toolkit styles -->
<link rel="stylesheet" href="<?=THEMEPATH;?>themes/global/css/uploader/bootstrap.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="<?=THEMEPATH;?>themes/global/css/uploader/jquery.fileupload-ui.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript><link rel="stylesheet" href="<?=THEMEPATH;?>themes/global/css/uploader/jquery.fileupload-ui-noscript.css"></noscript>
<!-- Generic page styles -->
<link rel="stylesheet" href="<?=THEMEPATH;?>themes/global/css/uploader/style.css">

<script language="javascript" type="text/javascript">

	$(document).ready(function(){
		
		/*$('#pix_submit').click(function(){			
			$('#btn-primary-start').trigger('click');		
		});
		$('#pix_refresh').click(function(){		
			window.location.reload()
		});
		*/


	$('#pix_refresh').click(function(){
		$('#btn-primary-start').trigger('click');
		//window.location.reload();
		//setTimeout("window.location.reload()",1000);		
	});	 
			
	});
     var album_id='';
	 var page ='facility';
			
</script>

<div id="dropdown-holder" style="display: none">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;" class="drop-add-title">Add Media Items</div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>

			
	<!-- uploader code start -->	
			
	
	<div class="dropdown-body">
	
	<div class="form-item">
		<h1>Choose Gallery to upload with:</h1>
		<!--<select name="upload_album" id="upload_album" style="width: 100%;">
		<?php // foreach($album as $album): ?>
		<option <?php if($album->id == $this->uri->segment(4)) echo "selected='selected'"; ?>value="<?=$album->id?>"><?=$album->album?></option>
		<?php // endforeach;?>
		</select>
	--></div>
	
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
                    <i class="icon-plus icon-white"></i>
                    <span>Add files...</span>
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
    <span style="margin-left:50px">Please click the button below to add your photos</span>
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
            <button class="btn btn-warning_">
                <!--<i class="icon-ban-circle icon-white"></i>-->
                <span>Remove</span>
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
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->

<script src="<?=THEMEPATH;?>themes/global/js/uploader/vendor/jquery.ui.widget.js"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="<?=THEMEPATH;?>themes/global/js/uploader/tmpl.min.js"></script>
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
	<input type="button" name="submit" value="Upload" id='pix_submit'   style='margin-left:5px;margin-top: 5px' class="btn-sav" style="float:left; display:none" >
	<input type="button" name="refresh" value="Save & Close" id='pix_refresh' style='margin-left:5px;margin-top: 5px' class="btn-sav"  style="float:left;" >		
</div>		
				
<!-- uploader code end -->		
	
</div>
</div>
