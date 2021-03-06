<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>-->
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>lightbox/video_lightbox/css/lightbox.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lightbox/video_lightbox/js/lightbox.js"></script>
	
<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/student_header/masthead'); ?>
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
<section id="video-album" class="section">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span><?php  $this->query_model->getDescReplace( $album_detail[0]->album); ?> </span></h2>
            </div>
            <p><a href="<?php echo base_url().$student_section_slug->slug; ?>/<?php echo (isset($back_link) && !empty($back_link)) ? $back_link : 'videos_albums'; ?>" class="back-to-gallery"><i class="fa fa-angle-left"></i> <?php echo $this->query_model->getStaticTextTranslation('back_to_video_gallery'); ?> </a></p>
        </div> 
        <div class="album-list">
         <?php 
		 	if(!empty($videos)):
				foreach($videos as $video):
				//echo '<pre>video'; print_r($video); die;
					$v_id=trim($video->video_id);
					$video_class = '';
					if($video->video_type=='youtube'){
						//$src="http://i.ytimg.com/vi/".$v_id."/0.jpg";
						
						$video_id = $v_id;
						$video_type = 'youtube';
						
						$video_class = 'video-box-min ';
					}
					
					
					if($video->video_type=='vimeo'){
						//http://vimeo.com/api/v2/video/17631561.php
						//$src=getThumbnailImage($v_id);
						//$src=$this->query_model->getViemoVideoImage($v_id);
						$video_id = $v_id;
						$video_type = 'vimeo';
					}
					
					if($video->video_img_type=='upload_image' && !empty($video->custom_video_thumbnail)){
						$video_class = 'video-box-min ';
					}
					
					$videoData = array('video_type'=>$video->video_type,'video_id'=>trim($video->video_id), 'video_img_type' => $video->video_img_type,'custom_video_thumbnail'=>$video->custom_video_thumbnail);
				
					$cover_image = $this->query_model->getVideoThumbnilImage($videoData);
					
					$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);
					
					
		?>
		
		 	 <div class="col-md-4 col-sm-4 col-xs-12">
				<div class="video-box <?= $video_class; ?> videosLightbox">
					<a href="#" class="slvj-link-lightbox 1" data-videoid="<?= $video_id ?>" data-videosite="<?= $video_type ?>"><img src="<?=$cover_image?>" class="img-responsive"  data-toggle="modal" data-target=".bs-example-modal-lg" url="<?php echo $video->link; ?>?modestbranding=1&autohide=1&showinfo=0&controls=1"></a>
				</div>
				<p><?php  $this->query_model->getDescReplace( $video->desc); ?></p>
         	</div>
         <?php endforeach; endif; ?>
        </div> 
              
        </div> 
    </div>
  </div>
</section>
<!-- Large modal -->

<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg videolightbox">
    <div class="">
		
     	<iframe width="100%" height="550px" class="videoIframe"  ></iframe>
    </div>
  </div>
</div>




<!--<div class="examples1">
		<a href="#" class="slvj-link-lightbox 1" data-videoid="17054419" data-videosite="vimeo">
			Link example 1
		</a><br>
		<a href="#" class="slvj-link-lightbox 1" data-videoid="TLEfnQ1nbSY" data-videosite="youtube">
			Link example 1
		</a>
		
		<a href="#" class="slvj-link-lightbox 1" data-videoid="etdchFN9S6g" data-videosite="youtube">
			Link example 1
		</a>
		
		<a href="#" class="slvj-link-lightbox 1" data-videoid="jMp6zeIrBAk" data-videosite="youtube">
			Link example 1
		</a>
		
		<a href="#" class="slvj-link-lightbox 1" data-videoid="jMp6zeIrBAk" data-videosite="youtube">
			Link example 1
		</a>
	</div>-->
	
	<script type="text/javascript">
	
	$('.videosLightbox a').simpleLightboxVideo();	
		
</script>

<?php $this->load->view('includes/footer'); ?> 

