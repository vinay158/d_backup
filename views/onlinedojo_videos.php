<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>lightbox/video_lightbox/css/lightbox.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lightbox/video_lightbox/js/lightbox.js"></script>
<!-- unpkg : use the latest version of Video.js -->
<link href="https://unpkg.com/video.js/dist/video-js.min.css" rel="stylesheet">
<script src="https://unpkg.com/video.js/dist/video.min.js"></script>
	
<?php $this->load->view('includes/header'); ?>
<?php 
	if($this->session->userdata('student_session_login') == 1){ 
		 $this->load->view('includes/student_header/masthead'); 
	}else{
		 $this->load->view('includes/header/masthead'); 
	}
 ?>

<script type="text/javascript">
	$(document).ready(function(){
		$('.videoPopup').click(function(){
			 var video_path = $(this).attr('url');
			 $('.videoIframe').attr('src',video_path); 
		});
	});		
</script>


<?php 
	function getThumbnailImage($v_id){
			if($v_id){
				$url="http://vimeo.com/api/v2/video/".$v_id.".php";						
				$data=file_get_contents($url);						
				$data=unserialize($data);
			//	echo '<pre>'; print_r($data); die;					
				return ($data[0]['thumbnail_large']);
			}else{
				return 0;
			}	
	} ?>
<style type="text/css">

.video-box-min{ height:201px; overflow:hidden; }
.video-box-min img{ margin-top:-34px;}

/* New Updated css for online dojo*/

.onlinedojo_video .video_list_box h4{font-size:18px !important}
.onlinedojo_video .video-box img{width:360px; height:220px}
.onlinedojo_video .video_list_box{background:#f5f5f0; padding-top:15px; border:5px solid #fff}
#videoPlayerPopup #video_title{color:#fff; font-size:25px; font-weight:bold; padding-top:20px}
#videoPlayerPopup #video_description p{color:#fff;}
#videoPlayerPopup{background:rgb(0, 0, 0, 0.8)}
#videoPlayerPopup .modal-content{background:rgb(0, 0, 0, 0.1)}
#videoPlayerPopup .modal-dialog{max-width:100%; width:1000px}
#videoPlayerPopup .close{color: #fff;}
.onlinedojo_video_login .login_box{margin-top:50px;background:#fafafa;padding:50px}
.onlinedojo_video_login {margin-bottom:100px;}
.onlinedojo_video .user_detail_box{margin-bottom: 20px;}
.onlinedojo_video .video_col_box{margin-bottom: 100px;}
.onlinedojo_video .video_list_box{margin-bottom: 0px !important;}
.onlinedojo_video_login .title-main {
    border: none;
    margin-top: 40px;
    margin-bottom: 0px!important;
}
.onlinedojo_video_login .title-main h2 {
    line-height: inherit!important;
}
</style>
<div class="mobile-contact">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> <span class="no"><?php echo $this->query_model->getStaticTextTranslation('student_section'); ?></span>
        <div class="row">
          <?php if($site_settings[0]->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings[0]->url_call_to_action); ?>" target="<?php if($site_settings[0]->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings[0]->call_to_action); ?></a> 
			</div>
			<?php endif; ?> <div class="col-xs-6 row-btn"> 
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
				<a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"> </i><?php echo ' '.count($allLocations).' '.$this->query_model->getStaticTextTranslation('locations'); ?></a>
			<?php } else{ ?>
			<a class="btn btn-theme" href="<?php echo  $this->query_model->getFindUs($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?> </a>
			<?php } ?>
			 </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<!-- blog list -->
<?php 
if($this->session->userdata('student_session_login') == 1){ 
	$userDetail = $this->session->userdata('onlinedojo_user_detail');
	
?>

<?php if(!empty($videos)): ?>
<section id="video-album" class="section onlinedojo_video">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span><?php echo $page_title; ?> </span></h2>
            </div>
           <!-- <p><a href="<?php echo base_url().$page_slug; ?>/videos_albums" class="back-to-gallery"><i class="fa fa-angle-left"></i> <?php echo $this->query_model->getStaticTextTranslation('back_to_video_gallery'); ?> </a></p> -->
        </div> 
		
		<div class="col-md-12 col-xs-12 user_detail_box">
           <!-- <div  class="col-md-6 col-xs-8">Welcome <?php echo !empty($userDetail->firstname) ? ucfirst($userDetail->firstname).' '.ucfirst($userDetail->lastname) : $userDetail->email; ?></div>
            <div  class="col-md-1 col-md-offset-5 col-xs-4"><a class="btn btn-danger" href="<?php echo base_url().'onlinedojo/logout' ?>">Logout</a></div> -->
        </div> 
		<div class="col-md-12 col-xs-12 video_col_box">
        <div class="album-list">
         <?php 
		 	
				foreach($videos as $video): 
				$video_id = '';
				$video_link = '';
				$video_class = '';
				$poster_img = '';
				if($video->video_type == "local_video"){
					$img_src = base_url().'upload/slider_video/thumb/'.$video->video_img;
					$poster_img = base_url().'upload/slider_video/'.$video->video_img;
					$video_type = 'local';
				
				}elseif($video->video_type == "embed_video"){
					$img_src = base_url().'upload/slider_video/thumb/'.$video->video_img;
					$video_type = 'embed';
				
				}elseif($video->video_type == "youtube_video"){
					$img_src = base_url().'upload/slider_video/'.$video->videoimage;
					$video_type = 'youtube';
					$video_link = $video->youtube_video;
					$video_class = 'video-box-min ';
					
					if(!empty($video_link)){
						preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video_link, $matches);
		 
						$video_id = isset($matches[1]) ? $matches[1] : '';
					
					}
					
				
				}elseif($video->video_type == "vimeo_video"){
					$img_src = base_url().'upload/slider_video/'.$video->videoimage;
					$video_type = 'vimeo';
					$video_link = $video->vimeo_video;
					
					if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $video_link, $output_array)) {
						$video_id = isset($output_array[5]) ? $output_array[5] : '';
					}
				}
			
			$title = ucfirst($video->video_title);
			if(strlen($title) > 40){
				$title = substr($title,0,38).'..';
			}
			
			$video_format_type = $video->video_format;
			$local_video_url = '';
			if($video->video_type == "local_video"){
				if($video->video_format == "mp4"){
					$local_video_url = base_url().'upload/local_videos/'.$video->local_video_mp4;
					
				}elseif($video->video_format == "webm"){
					$local_video_url = base_url().'upload/local_videos/'.$video->local_video_webm;
					
				}elseif($video->video_format == "mov"){
					$local_video_url = base_url().'upload/local_videos/'.$video->local_video_mov;
					$video_format_type = 'mp4';
				}elseif($video->video_format == "mkv"){
					$local_video_url = base_url().'upload/local_videos/'.$video->local_video_mkv;
					$video_format_type = 'mp4';
				}
			}
			
			
		?>
		
		 	 <div class="col-md-4 col-sm-4 col-xs-12 video_list_box">
				<div class="video-box">
					<a href="javascript:void(0)" class="onlineDojoPlayVideo" video_id="<?php echo trim($video_id); ?>" video_type="<?php echo $video_type; ?>"  local_video_url="<?php echo $local_video_url; ?>" video_format_type="<?php echo $video_format_type; ?>" poster_img="<?php echo $poster_img; ?>"  title='<?php  $this->query_model->getDescReplace( $video->video_title); ?>' description='<?php  $this->query_model->getDescReplace( $video->slide_text); ?>' embed_video_text='<?php  $this->query_model->getDescReplace( $video->embed_video_text); ?>'><img src="<?php echo $img_src ?>" class="img-responsive"></a> 
				</div>
				<h4>
				
				<?php  $this->query_model->getDescReplace( $title); ?></h4>
				<!--<p><?php  $this->query_model->getDescReplace( $video->slide_text); ?></p>-->
         	</div>
         <?php endforeach;?>
        </div> 
        </div> 
              
        </div> 
    </div>
  </div>
</section>
<?php  endif;  ?>
<?php 	if(!empty($video_albums)): ?>
<section id="video" class="section">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span> 
			  <?php echo empty($videos) ? $page_title : 'Video Albums'; ?>
			  

			  </span></h2>
            </div>
        </div> 
        <div class="video-gallery">
		<?php 
		
				foreach($video_albums as $album): //echo '<pre>'; print_r($album); 
		?>
          <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="album">
			 <?php 
			 	if(!empty($album->cover)):
					$video_type = explode('/',$album->cover);
					
					if($video_type[2] == 'img.youtube.com'){
						$cover_image = str_replace('0.jpg','mqdefault.jpg',$album->cover);
					}else{
						$cover_image = str_replace('200x150.jpg','960x720.jpg',$album->cover);
					}
					
					$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);
					
			?>
              <div class="video-box">
                 <img src="<?= $cover_image; ?>" class="img-responsive videoAlbum">
              </div>
			  <?php endif; ?>
              <div class="video-desc">
                <h3><?php  $this->query_model->getDescReplace( $album->album); ?></h3>
                <p><?php  $this->query_model->getDescReplace( $album->desc); ?></p>
                <p><a href="<?php echo base_url().$student_section_slug->slug; ?>/onlinedojo_video_album/<?php echo $album->id; ?>" class="btn-view"><?php echo $this->query_model->getStaticTextTranslation('view_album'); ?></a> </p>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        <?php endforeach;?>  
        </div>  
    </div>
  </div>
</section>
<?php  endif;  ?>
		
<div class="modal fade" id="videoPlayerPopup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      
      <div class="modal-body">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close" >
          <span aria-hidden="true">&times;</span>
        </button>
		
		 <div id="video_frame"></div>
		  <h5 id="video_title" class="modal-title"></h5>
		  <div id="video_description"></div>
          
      </div>
    </div>
  </div>
</div>


<script>

$(document).ready(function(){
	
	var baseUrl = '<?php echo base_url(); ?>';
	var isMobile = '<?php echo $is_mobile; ?>';
	// click on close button audio player will also close
	$('body').on('mouseup','#videoPlayerPopup',function(){
		var $frame = $('iframe#videoPlayer');

		// saves the current iframe source
		var vidsrc = $frame.attr('src');

		// sets the source to nothing, stopping the video
		$frame.attr('src',''); 
		// sets it back to the correct link so that it reloads immediately on the next window open
		$frame.attr('src', vidsrc);
		
		
		var video = jQuery("#localVideoPlayer").get(0);
		  video.currentTime = 0;
		  video.pause();
		  
	});
	$('body').on('click','.close',function(){
			
			
			var $frame = $('iframe#videoPlayer');

			// saves the current iframe source
			var vidsrc = $frame.attr('src');

			// sets the source to nothing, stopping the video
			$frame.attr('src',''); 
			// sets it back to the correct link so that it reloads immediately on the next window open
			$frame.attr('src', vidsrc);
			
			var video = jQuery("#localVideoPlayer").get(0);
			  video.currentTime = 0;
			  video.pause();

		})
		
	$('body').on('click','.onlineDojoPlayVideo', function(){
		
		var video_type = $(this).attr('video_type');
		var video_id = $(this).attr('video_id');
		var video_height = 550;
		var video_width = 970;
		
		//
		
		if(isMobile == 1){
			video_width = "100%";
			video_height = "auto";
		}
		
		var iframe_html = '';
		$('#videoPlayerPopup').modal();
		//$('#video_frame').css('margin-top','');
		if(video_type == "youtube"){
			//$('#videoPlayerPopup').modal({backdrop: 'static', keyboard: false}); 
			iframe_html = '<iframe scrolling="no" id="videoPlayer" src="https://www.youtube.com/embed/'+video_id+'" width="'+video_width+'" height="'+video_height+'" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}else if(video_type == "vimeo"){
			//$('#videoPlayerPopup').modal({backdrop: 'static', keyboard: false}); 
			iframe_html = '<iframe scrolling="no" id="videoPlayer" src="https://player.vimeo.com/video/'+video_id+'" width="'+video_width+'" height="'+video_height+'"  frameborder="0" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen"></iframe>';
		}else if(video_type == "local"){
			$('#videoPlayerPopup').modal();
			
			var margin_top = "620px";
			if(isMobile == 1){
				margin_top = "300px";
			}
			
			/*var local_video_mp4 = $(this).attr('local_video_mp4');
			var local_video_webm = $(this).attr('local_video_webm');
			var local_video_mov = $(this).attr('local_video_mov');
			var local_video_mkv = $(this).attr('local_video_mkv');
			iframe_html = '<div id="framebox" style="margin-top:'+margin_top+'"><video id="localVideoPlayer"  width="'+video_width+'" height="'+video_height+'"  preload="auto" controls="controls"><source src="'+local_video_mp4+'" type="video/mp4"><source src="'+local_video_webm+'" type="video/webm"><source src="'+local_video_mov+'" type="video/mov"><source src="'+local_video_mkv+'" type="video/mkv"></video></div>';*/
			
			var local_video_url = $(this).attr('local_video_url');
			var video_format_type = $(this).attr('video_format_type');
			var poster_img = $(this).attr('poster_img');
			
			//iframe_html = '<div id="framebox" style="margin-top:'+margin_top+'"><video id="localVideoPlayer"  width="'+video_width+'" height="'+video_height+'"  preload="auto" controls="controls"><source src="'+local_video_url+'" type="video/'+video_format_type+'"></video></div>';
			
			iframe_html = '<div id="framebox"><video  class="video-js" id="localVideoPlayer" width="'+video_width+'" height="'+video_height+'" style="width:'+video_width+';height:'+video_height+'" controls preload="auto" poster="'+poster_img+'" data-setup="{}"><source src="'+local_video_url+'" type="video/'+video_format_type+'"></source></video></div>';
			
			//$('#video_frame').css('margin-top','650px');
		}else if(video_type == "embed"){
			//$('#videoPlayerPopup').modal({backdrop: 'static', keyboard: false}); 
			iframe_html = $(this).attr('embed_video_text');
		}
		
		$('#video_title').html($(this).attr('title'));
		$('#video_description').html($(this).attr('description'));
			
		$('#video_frame').html(iframe_html);
		 
	})
	
	
});
</script>
<!-- Large modal -->


<?php }else{ ?>

<section id="video-album" class="section onlinedojo_video_login">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span><?php echo $site_settings[0]->ss_login_popup_text; ?> </span></h2>
            </div>
		  <div class="col-sm-6 col-sm-offset-3 text-center login_box">
			 <div class="login-form">
			 <?php if($password_setting[0]->password_protection_type == "multiple"){ ?>
				<form id="loginform" class="form-horizontal" role="form" method="post" action="<?php echo base_url().'students/onlineDojoUserLogin' ?>">
				<div class="col-sm-12">
				  <?php 
				    if($this->session->userdata('onlineuser_error_message') == 1){ 
				        $this->session->unset_userdata('onlineuser_error_message');    
				?> 
					<span class="ErrorMsgNotLogin">Email address or <?php echo $this->query_model->getStaticTextTranslation('incorrect_password') ?> </span>
				  <?php } ?>
				  
				  <?php 
				    if($this->session->userdata('onlineuser_forgot_password_success')){ 
				        $onlineuser_forgot_password_success = $this->session->userdata('onlineuser_forgot_password_success');  
				        $this->session->unset_userdata('onlineuser_forgot_password_success');   
				?> 
					<p class="success_forgot_password"><?php echo $onlineuser_forgot_password_success; ?> </p>
				  <?php } ?>
				  
				   <div class="input-group">
					  <span class="input-group-addon"><i class="fa fa-user"></i></span>
					  <input id="login-user" type="text" class="form-control" name="username" placeholder="Email address">
				   </div>
				 <div class="col-sm-12"><h2></h2></div>
				 </div><div class="col-sm-12">
				   <div class="input-group">
					  <span class="input-group-addon"><i class="fa fa-lock"></i></span>
					  <input id="login-password" type="password" class="form-control" name="password" placeholder="<?php echo $this->query_model->getStaticTextTranslation('password'); ?>">
				   </div>
				  </div>
				  <div class="col-sm-12">
				   <input type="submit" name="login" value="<?php echo $this->query_model->getStaticTextTranslation('login'); ?>" class="btn btn-readmore  btn-block submit button">
				  </div>
				  <div class="forgot_password_btn"><a href="<?php echo base_url().$student_section_slug->slug.'/forgot_password' ?>" >Forgot your password?</a></div>
				</form>
			 <?php }elseif($password_setting[0]->password_protection_type == "single"){ ?>
				 
				 
				<form id="loginform" class="form-horizontal" role="form" method="post" action="<?php echo base_url().'students/checkstudentloginToEnterKey' ?>">
		  				<span class="ErrorMsgNotLogin">
						<?php if($this->session->userdata('onlineuser_error_message') == 1){ 
							echo $this->query_model->getStaticTextTranslation('incorrect_password'); }	
						?>
						</span>
						
						 <?php
						 
						 $multiSchool = $this->query_model->getbyTable("tblconfigcalendar");
						 $multiSchool = isset($multiSchool[11]) ? $multiSchool[11]->field_value : 0;
		
							$this->db->where("location_type", 'regular_link');
							/*if($multiSchool == 1){
								$this->db->where("main_location", 0);
							}*/
							$this->db->where("published", 1);
							$this->db->order_by("state","asc");
							$form_allLocations = $this->query_model->getbyTable("tblcontact"); 
							
							
							$multi_student_password = $this->query_model->getbySpecific("tblconfigcalendar",'id',15);
							$multi_student_password = !empty($multi_student_password) ? $multi_student_password[0]->field_value : 0;
						?>
						<?php if($multi_student_password == 1){ ?>
							<div style="margin-bottom: 25px" >
				 
				 
								<select class="form-control" name="location_id"style="height:40px" id="school_location_id">
							   <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
									<?php foreach($form_allLocations as $location): ?>
										<option  value="<?=$location->id;?>" ><?php echo ucfirst($location->state.' - '.$location->name);?> </option>
									<?php endforeach;?>   
							  </select>
							</div>
						<?php }else{ ?>
							<input type="hidden" value="0" id="school_location_id">
						<?php } ?>
							
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="password" placeholder="<?php echo $this->query_model->getStaticTextTranslation('password'); ?>">
                                    </div>
                                    
                                    <div class="login-btn">
                                      <a id="btn-login" href="javascript:void(0)" class="btn btn-theme btn-lg btn-block loginButton"><?php echo $this->query_model->getStaticTextTranslation('login'); ?>  </a>
                                    </div>  
					<?php $this->session->unset_userdata('onlineuser_error_message'); ?>
          </form>
			<?php } ?>
				
			 </div>
		  </div>
	   </div>
	  
	</div>
 </section>      
      
<?php } ?>





<?php $this->load->view('includes/footer'); ?> 

