<div id="dropdown-holder" style="display: none">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;" class="drop-add-title">Add Photos For Faciity</div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>

		<div class="dropdown-body">
		    <form action="admin/page/uploadPhoto" method="post" id="operateform" enctype="multipart/form-data">
			<script>
			$(document).ready(function(){
			$(".dd-upload-btn").click(function(){
			$(this).addClass("active");
			$("#upload-type").val(1);
			$("#embed-code").hide();
			$("#image-upload").show();			
			});
			
			});
			</script>
			<input type="hidden" name="upload-type" value="1" id="upload-type" />
			<div class="dropdown-tabbar">
				<a id="dd-upload" class="dd-upload-btn active">Upload</a>
			</div>
			<div id="image-upload">
			<div class="form-item">
			<input type="file" name="userfile" id="userfile" accept="image/x-png, image/gif, image/jpeg" multiple="multiple"/>
			</div>
			<div class="form-item">
					<h1>Upload Multiple Images</h1>
					Supported File Formats: jpg, gif, png only.
			</div>
			</div>
			
		</div>
		<div class="dropdown-bottom">
			<input type="submit" name="submit" value="Save" class="btn-save" style="float:left;">
		    </form>
		</div>
	</div>
</div>

