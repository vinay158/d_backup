<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->

<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'description', 
									{ customConfig : 'mini_half_configy.js' }
							);
	
	});
</script>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
	var title_t = $("#main_title").val();
	var album_id = $("#album_id").val();
	$("#h1-title").html(title_t+'<a id="go-back" onclick="goBack()" class="panel-title-links button_class">Back to Categories</a><a id="Edit" class="panel-title-links button_class">Edit album info</a><a id="Upload" class="panel-title-links button_class">Add Videos</a>');
	$(".panel-title-name").html("Edit Album <span>" + title_t + " <em>ID #: " + album_id + "</em></span>");
	
	});
	</script>

<style>
<!--  You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.
.manager-items .manager-item {
	min-height: 49px !important;
}
-->
</style>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Video Album: <?php echo isset($details[0]->album) ? $details[0]->album : ''; ?></h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
				<div class="gen-holder">

					<div class="gen-panel-holder"  style="width: 100% !important;">
					
					
					
					<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label" >Video Album: <?php echo isset($details[0]->album) ? $details[0]->album : ''; ?></div>
				<div class="row row-xs align-items-center  mg-t-25 mg-b-5">
					<div class="col-md-12">
						<p>You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.</p>
					</div>
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5">Videos</h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($media) ? count($media) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="javascript:void(0)" onclick="goBack()"  class="button_class btn btn-indigo ">Back to video albums</a> &nbsp;  &nbsp; 
								 <a href="javascript:void(0)" class="button_class btn btn-indigo"   data-toggle="modal" data-target="#popupEditAlbumInfo" >Edit album info</a> &nbsp;  &nbsp;
								 <a href="javascript:void(0)" class="button_class btn btn-indigo "  data-toggle="modal" data-target="#popupAddVideoToAlbum">Add Video</a>
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tbl_onlinedojo_media" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($media)):
			 foreach($media as $row):
			 $sr_testimonials++;
			 
				$videoData = array('video_type'=>$row->video_type,'video_id'=>trim($row->video_id), 'video_img_type' => $row->video_img_type,'custom_video_thumbnail'=>$row->custom_video_thumbnail);
				
				$cover_image = $this->query_model->getVideoThumbnilImage($videoData);
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								
								<?php if($row->type == 1): ?>
									<img src="<?php echo !empty($row->link_thumbnail) ? $row->link_thumbnail : base_url().'assets_admin/img/no-image.png'?>" class="list_img">
								<?php else: ?>
									<img src="<?php echo !empty($cover_image) ? $cover_image : base_url().'assets_admin/img/no-image.png'?>" class="list_img">
								<?php endif;?>
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=strip_tags($row->desc);?> </a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 <?php 
								$coverImg='';
								if($row->is_cover_image){
									$coverImg=1;
								}
							?>
							
							
							<?php if($row->type == 1) : ?>
							<input type="hidden" name="media_link_<?=$row->id?>" class="<?=$row->desc?>" id="media_link_<?=$row->id?>" title='<?=$coverImg?>' value="<?=$row->link_thumbnail_2;?>" video_img_type="<?=$row->video_img_type?>" custom_video_thumbnail="<?=$row->custom_video_thumbnail?>" />
							<?php else: ?>
							<input type="hidden" name="media_link_<?=$row->id?>" class="<?=$row->desc?>" id="media_link_<?=$row->id?>" title='<?=$coverImg?>' value="<?=$row->link?>"  video_img_type="<?=$row->video_img_type?>" custom_video_thumbnail="<?=$row->custom_video_thumbnail?>" />
							<?php endif; ?>
							
							
							 <a href="javascript:void(0)"  move_video_type="album_to_album" video_id="<?=$row->id?>" class="badge badge-primary move_video_item">Move Video</a>
							
							  <a href="javascript:void(0)" class="badge badge-primary edit_video" media_id="<?=$row->id;?>">Edit</a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_onlinedojo_media" item_title="<?=$row->desc;?>" section_type="full_width">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tbl_onlinedojo_media"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($row->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($row->published == 1) ? 0 : 1;?>" class="publish_type" />
								</div></a>
						</nav>



							</div>
						</div>
					</li>
<?php endforeach;?>								

<?php else: ?>

<?php endif;?>
								</ul>

	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />		
			
						
						
				</div>
			</div>
		</div>
</div>

</div>	

	</div>			

		
</div>
</div>
</div>
</div>






<?php $this->load->view("admin/include/footer");?>

<script>
function goBack(){
	window.history.back()
}

$(document).ready(function(){
	
	$('body').on('keyup','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('change','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	
	$('body').on('click','.update_album_info_submit', function(){
		
		var published = $('.required_mapping_fields_checkbox').attr('checkbox_value');
		
		var full_desc = CKEDITOR.instances['description'].getData();
		
		$('.form_error_msg').hide();
		var error = 0;
		$.each($('.required_field'),function(){
			var check = $(this).val();
			if(check == '') {
				$(this).css('border','1px solid red');
				error = 1;
			}
		})
		
		if(error == 0){
			var formData = $('#editAlbumPopupForm').serialize();
			
			$.ajax({ 					
				type: 'POST',						
				url : 'admin/onlinedojo_video_albums/ajax_update_album_info',
				dataType : 'json',
				data: { formData : formData,full_desc:full_desc,published: published}					
				}).done(function(data){ 
				
				if(data.res == 1){
					
					$('#popupEditAlbumInfo').modal('hide');
						
					$('#responsePopup').find('.action_response_msg').html('Successfully updated!');
					
					$('#responsePopup').modal('show');
					setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
					
				}
			});
			
		}else{
			$('.form_error_msg').show();
		}
		
	})
	
	
	$('body').on('click','.edit_video', function(){
		
		$("#popupEditVideoToAlbum").modal('show');
		
		var media_id = $(this).attr('media_id');
		var loc = $("#media_link_"+media_id).val();
		var desc = $("#media_link_"+media_id).attr("class");
		var coverlink = $("#media_link_"+media_id).attr("title");
		var url = $("#media_link_"+media_id).val();	
		var video_img_type = $("#media_link_"+media_id).attr("video_img_type");	
		var custom_video_thumbnail = $("#media_link_"+media_id).attr("custom_video_thumbnail");	
		
		if(coverlink){
			$("#album-cover").addClass("check-on");
			$("#album-cover").removeClass("check-off");
			$("#album-cover-val").val(1);
		}else{
			$("#album-cover").addClass("check-off");
			$("#album-cover").removeClass("check-on");
			$("#album-cover-val").val(0);
		}
		
		$("#operation").val("edit");
		$("#edit_id").val(media_id);
		$("#media_desc").val(desc);
		$("#embed_edit").val(url);
		$("#cover_link").val(loc);
		
		
		$.each( $( ".video_img_type" ), function() {
			if($(this).val() == video_img_type){
				$(this).prop('checked', true);
				$(this).attr('checked', 'checked');
			}
		});
		
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
		
		
		if(video_img_type != "" && custom_video_thumbnail != ""){
			$('#img_left').show();
			$('#img_left').find('.old_custom_thumbnail_img').val(custom_video_thumbnail);
			$('#img_left').find('img').attr('src',"<?php echo base_url().'upload/class_schedule/' ?>"+custom_video_thumbnail);
			$('#img_left').find('a').attr('number',media_id);
		}
		
		
	})
	
	
	$("body").on('click','#delete_img_left',function(){

			$('#img_left').remove();
			
			var image_path=$('#img_left').find('img').attr('src');
			var number=$(this).attr('number');
			
			$.ajax({ 					
			type: 'POST',						
			url: 'admin/onlinedojo_video_albums/deleteVideoCustomImage',						
			data: {image_path:image_path,number:number}					
			}).done(function(msg){ 
			if(eval(msg) == 1){
				
			}
			});

		});
		
	$('body').on('click','.video_img_type',function(){
			var radio_button_value = $(this).val();
			
			if(radio_button_value == "automatically"){
				$('.welcome_video_image').hide();
			}
			if(radio_button_value == "upload_image"){
				$('.welcome_video_image').show();
						
				
			}
		});
		
	$("body").on('click',".publish_checkbox",function(){
		if($(this).hasClass("check-on")){
			$(this).removeClass("check-on");
			$(this).addClass("check-off");
			$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
			$(this).attr('checkbox_value',0);
		}
		else
		{
			$(this).removeClass("check-off");
			$(this).addClass("check-on");
			$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
			$(this).attr('checkbox_value',1);
		}
	})
})

</script>


<div id="popupEditAlbumInfo" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Edit Video Album</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="" method="post" id="editAlbumPopupForm">
		  <?php if(!empty($details)): ?>
			<?php foreach($details as $details):?>
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center">
				<div class="col-md-12 mg-t-5 mg-md-t-0"><div class=" form_error_msg" style="display:none">Please fill required fields..</div></div>
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Album Title</h1>
						<input type="text" name="title" id="dupcat_program_title" class="field full_width_input required_field" value="<?=$details->album?>">
						<input type="hidden" value="<?=$details->id?>" name="id_of_album" id="album_id" />
						<input type="hidden" value="<?=$details->cover?>" name="cover_of_album" id="album_cover" />
					</div>
					
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Category</h1>
						<select name="category" id="category" class="field">
						<?php foreach($cat as $cat):  	
						if($cat->cat_id != 25){ ?>
						<option <?php if($details->category == $cat->cat_id) echo "selected='selected'" ;?> value="<?=$cat->cat_id?>"><?=$cat->cat_name?></option>
						<?php } endforeach;?>
						</select>
					</div>
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Description</h1>
						<textarea name="text" class="ckeditor" id="description" ><?=$details->desc;?></textarea>
					</div>
					
					<h1>&nbsp;</h1>
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<a id="published" class="checkbox required_mapping_fields_checkbox publish_checkbox <?php if($details->published == 1) echo "check-on"; else echo "check-off";?>" checkbox_value="<?=$details->published;?>"></a>
						<h1 class="inline">Publish This</h1>
						<input type="hidden" value="<?=$details->published;?>" name="published" class="hidden_cb" />
					</div>
					
					
				</div>
				<input type="hidden" name="action" value="update_album_info">
				<input type="hidden" name="item_id" id="edit_album_id" value="">
				<input type="hidden" name="table_name" id="edit_album_table_name" value="">
          </div>
		  
		  <?php endforeach;?>
		<?php endif;?>
          <div class="modal-footer">
			<div class=" form_error_msg" style="display:none">Please fill required fields and save again..</div>
            <a href="javascript:void(0)" class="btn btn-indigo update_album_info_submit">Save</a>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	


<div id="popupAddVideoToAlbum" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Add Video</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		 <form action="admin/<?=$link_type?>/uploadMedia" method="post" id="uploadform" enctype="multipart/form-data" onSubmit="javascript: return testUrlForMedia(this);">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Choose Gallery to upload with:</h1>
							<select name="upload_album" id="upload_album" class="field">
							<?php 
							foreach($albums as $album):
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
					
					
					</div>
					
					<div class="col-md-12 mg-t-5 mg-md-t-0">					
						<?php if($category =='Photos'): ?>
							<a id="dd-upload" class="dd-upload-btn active">Upload</a>
						<?php elseif($category =='Videos'): ?>
							<a id="dd-embed" class="dd-embed-btn">Add Embed Code</a>
						<?php endif; ?>
					</div>
					
					<?php if($category =='Photos'): ?>
						
						<div class="col-md-12 mg-t-5 mg-md-t-0">	
							<input type="file" name="userfile" id="userfile" accept="image/x-png, image/gif, image/jpeg" multiple="multiple"/>
						</div>
						<div class="col-md-12 mg-t-5 mg-md-t-0">	
							<h1 class="descrip">Photo caption</h1>
							<input type="text" name="description" id="description" />
						</div>
					
					<?php elseif($category =='Videos'): ?>
						<div class="col-md-12 mg-t-5 mg-md-t-0">
							<h1 class="descrip">Video caption</h1>
							<input type="text" name="description" id="description" class="field full_width_input" />
						</div>
						<div class="col-md-12 mg-t-5 mg-md-t-0">
							<h1>Video URL</h1>
							<textarea name="embed" id="embed" rows="2" style='width:100%'></textarea>
							 <span>
							   Youtube Example:  - http://www.youtube.com/watch?v=27oySKIS6Xo<br/>
							   Vimeo Example:  - https://vimeo.com/37865623
							  </span>
						</div>
						
						
					<?php endif; ?>
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
			else { 
				alert("No valid media id detected");
				return false;
			 }
				
			}		
		</script>	
		
          </div>
          <div class="modal-footer">
			<input type="submit" name="submit" value="Save" class="btn btn-indigo btn-save">
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	<div id="popupEditVideoToAlbum" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Edit Video</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="admin/<?=$link_type?>/operateMedia" method="post" id="operateform"  enctype="multipart/form-data"  onSubmit="javascript:return testUrlForMedia(this);">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Album</h1>
							<select name="edit-album" id="edit-album" class="field">
							<?php 
								foreach($albums as $val): 
									$week_academy_title = '';
									if(isset($val->week_academy_id) && !empty($val->week_academy_id)){
										
										$this->db->select('title');
										$week_academy = $this->query_model->getBySpecific('tbl_8_week_academy','id',$val->week_academy_id);
										
										$week_academy_title = !empty($week_academy) ? '-'. $week_academy[0]->title : '';
									}
									
								?>
								<option <?php if($val->id == $this->uri->segment(4)) echo "selected='selected'"; ?> value='<?=$val->id?>'><?=$val->album?> <?php echo $week_academy_title; ?> </option>
								<?php endforeach;?>
								</select>
					
					</div>
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Caption</h1>
						
						<input type="text" name="media_desc" id="media_desc" class="field full_width_input edit_video_media_desc" value="">
						
						<input type="hidden" name="edit_id" id="edit_id" class="edit_video_id" value="0" />
						<input type="hidden" name="cover_link" id="cover_link" value="" />
						<input type="hidden" name="redirection" value="admin/<?=$link_type?>/edit/<?=$this->uri->segment(4)."/".$this->uri->segment(5);?>" />
						<input type='hidden' name='video_type' id ='video_type_edit' value=''/>
						<input type='hidden' name='video_id' id ='video_id_edit' value=''/>
					</div>
					<?php if($type==2){ ?>  
					<div class="col-md-12 mg-t-5 mg-md-t-0">					
						<h1>URL</h1>
						<input type="text" name="media_url" id="embed_edit" class="field full_width_input edit_video_media_url" value="">
					</div>
					<?php } ?>
					
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Upload Video Image</h1>
						<div class="row row-xs align-items-center">
							
							<div class="col-md-12  mg-t-5 mg-md-t-0">
							<div class="row mg-t-10">
								<div class="col-lg-6">
								  <label class="rdiobox">
									<input type="radio" class="video_img_type" name="video_img_type" value="automatically" /> 
									<span> Automatically pull from youtube/vimeo</span>
								  </label>
								</div><!-- col-3 -->
								<div class="col-lg-6 mg-t-20 mg-lg-t-0">
								  <label class="rdiobox">
									<input type="radio" class="video_img_type" name="video_img_type" value="upload_image" />
									<span>Upload custom image</span>
								  </label>
								</div><!-- col-3 -->
								</div>
							</div>
							
						</div>
					</div>
					<div class="col-md-12 mg-t-5 mg-md-t-0 welcome_video_image">
						<h1 >Upload Video Thumbnail Image</h1>
						<div class="custom-file half_width_custom_file">
							<input type="file" name="custom_video_thumbnail" class="custom-file-input" id="customFile4" accept="image/*" />
						<label class="custom-file-label" for="customFile">Choose file</label></div>
						
						<div id="img_left" style="display:none">
							<img style="width: 100px; clear:both;" src="" class="">
							<br/>
							<input name="old_custom_thumbnail_img" class="old_custom_thumbnail_img" value="" type="hidden" />
						
							<a href='javascript:void(0);' class='delete_image_btn_new' id='delete_img_left' number="">Delete image</a>
						</div>
					</div>
					
					
					<h1>&nbsp;</h1>
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<script language="javascript">
							$(document).ready(function(){
								$("#album-cover").click(function(){
									if($(this).hasClass("check-on"))
									{
										$(this).removeClass("check-on").addClass("check-off");
										$("#album-cover-val").val("0");
									}
									else
									{
										$(this).removeClass("check-off").addClass("check-on");
										$("#album-cover-val").val("1");
									}
								})
							})
							</script>
								<a id="album-cover" class="checkbox category check-off"></a>			
							<h1 class="inline">Album Cover</h1>
							<input type="hidden" name="operation" value="" id="operation" />
							<input type="hidden" value="1" name="album-cover-val" id="album-cover-val">
					</div>
					
				</div>
				
				
		
          </div>
          <div class="modal-footer">
			<input type="submit" name="submit" value="Save" class="btn btn-indigo btn-save">
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	<script>

$(document).ready(function(){
	
	$('body').on('keyup','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('change','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	
	
	$('body').on('click','.move_video_item', function(){
		
		$("#popupMoveVideoItem").modal('show');
		
		var move_video_type = $(this).attr('move_video_type');
		var video_id = $(this).attr('video_id');
		
		$('#move_video_type').val(move_video_type);
		$('.move_video_id').val(video_id);
	})
	
	
	$('body').on('click','.update_move_item', function(){
		
		$('.form_error_msg').hide();
		var error = 0;
		$.each($('.required_field'),function(){
			var check = $(this).val();
			if(check == '') {
				$(this).css('border','1px solid red');
				error = 1;
			}
		})
		
		if(error == 0){
			 $( "#moveVideoItemForm" ).submit();
		}else{
			$('.form_error_msg').show();
		}
	})	
})

</script>

<div id="popupMoveVideoItem" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Move Video</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		 <form action="admin/onlinedojo_video_albums/moveOnlineDojoVideos" method="post" id="moveVideoItemForm">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Video Albums</h1>
						<?php 
							$this->db->where("category", 26);
							$this->db->select(array('id','album'));
							$albums = $this->query_model->getbyTable("tbl_onlinedojo_galleryname");
						?>
						<?php if(!empty($albums)){ ?>
						<select class="field" name="album_id">
							<option value="">-Select video album-</option>
							<option value="free_floting_video">Free Floating Videos</option>
							<?php 
								foreach($albums as $album){  
									if($album->id != $this->uri->segment(4)){
							?>	
								<option value="<?php echo $album->id ?>"><?php echo $album->album ?></option>
								<?php } } ?>
						</select>
						<?php } ?>
						
						<input type="hidden" name="move_video_type" id="move_video_type"  value="video_to_album">
						<input type="hidden" name="video_id" class="move_video_id" id="video_id"  value="0">
					</div>
					
					
				</div>
				
				
		
          </div>
          <div class="modal-footer">
			<div class=" form_error_msg" style="display:none">Please select any video ablum..</div>
			<a href="javascript:void(0)" class="btn btn-indigo update_move_item">Save</a>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
