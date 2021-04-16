<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>lightbox/video_lightbox/css/lightbox.min.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>lightbox/video_lightbox/js/lightbox.js"></script>
<?php
$siteData = $this->query_model->getbyTable("tblsite");
if(is_array($siteData) && $siteData[0]->is_mailing_required){
	$this->db->limit(3);	
}else {
	$this->db->limit(4);
}
?>
<?php 
	function getThumbnailImage($v_id){
			if($v_id){
				$url="http://vimeo.com/api/v2/video/".$v_id.".php";						
				$data=file_get_contents($url);						
				$data=unserialize($data);
				return ($data[0]['thumbnail_large']);
			}else{
				return 0;
			}	
	}
?>
<?php if(!empty($feature_box)) :?>
<?php foreach($feature_box as $feat_box) :?>
		<?php 
			$target = '';
			if(isset($feat_box->url) && !empty($feat_box->url)){
				$target=(!empty($feat_box->target)) ? 'target="'.$feat_box->target.'"' : 'target="_blank"';
			}
		?>	
		
		<?php 
			
			//if(!empty($feat_box->summary)){
			//if(isset($feat_box->url) && !empty($feat_box->url)){ 
				$http = substr($feat_box->url, 0, 4);
				if($http!='http'){
					$url = 'http://'.$feat_box->url;
				}else{
					$url = $feat_box->url;
				}
				
				$url = $feat_box->url;
				
				
				$video_type = '';
				$video_class = '';
				$video_class_image = '';
				if($feat_box->image_video == 'video') { 
							if($feat_box->video_type == 'youtube_video'){
								$img_src = "http://i.ytimg.com/vi/".$feat_box->video_id."/0.jpg";
								$video_type = 'youtube';
								$video_class = 'youtubeVideoOnAds';
								$video_class_image = 'youtubeVideoOnAdsimage';
								$img_src = $this->query_model->changeVideoImgPathHttp($img_src);
									
							}
							
							elseif($feat_box->video_type == 'vimeo_video'){
								//$img_src=getThumbnailImage($feat_box->video_id);
								$img_src=$this->query_model->getViemoVideoImage($feat_box->video_id);
								//getThumbnailImage($feat_box->video_id);
								$video_type = 'vimeo';
								$video_class = 'vimeoVideoOnAds';
								$video_class_image = 'youtubeVideoOnAdsimage';
								$img_src = $this->query_model->changeVideoImgPathHttp($img_src);
							}
							
				 }
				
		?>	
		<?php if($feat_box->image_video == 'image'){  ?>
		
		<div class="col-md-4">
               <figure class="effect-ming">
                   <a href="<?=$url?>" <?=$target?>>
					<img src="<?=($feat_box->photo_thumb)?$feat_box->photo_thumb:$feat_box->photo;?>" class="img-responsive featuredImg" alt="<?php $this->query_model->getStrReplace($feat_box->image_alt); ?>">
				   </a>
                  <figcaption>
                     <h2><?= $this->query_model->getStrReplace($feat_box->title); ?></h2>
                     <h3><?= $this->query_model->getStrReplace($feat_box->summary); ?></h3>
					  <?php //$this->query_model->getStrReplace($feat_box->summary); ?>
                     <p> <a  href="<?=$url?>" <?=$target?>><?php echo $this->query_model->getStaticTextTranslation('learn_more'); ?></a></p>
                     
                  </figcaption>        
               </figure>
               </div>
		
		<?php } else{ ?>
		
		<?php //if($feat_box->image_video == 'video'){  ?>
		<div class="col-md-4">
               <figure class="effect-ming cap-bot col-xs-12 videosLightbox <?= $video_class; ?>">
                 
				 <div class="video-box_ads video-box-min_ads  videosLightbox">
					<a href="#" class="slvj-link-lightbox 1" data-videoid="<?= $feat_box->video_id ?>" data-videosite="<?= $video_type ?>">
						<img src="<?=$img_src?>" class="img-responsive featuredImg <?= $video_class_image ?>">
					</a>
				</div>
				
                  <figcaption>
                     <h2><?= $this->query_model->getStrReplace($feat_box->title); ?></h2>
					  <h3><?= $this->query_model->getStrReplace($feat_box->summary); ?></h3>
					  <?php //$this->query_model->getStrReplace($feat_box->summary); ?>
                     <p>
					<a href="#" class="slvj-link-lightbox " data-videoid="<?= $feat_box->video_id ?>" data-videosite="<?= $video_type ?>">
						<?php echo $this->query_model->getStaticTextTranslation('learn_more'); ?>
					  </a> 
					 </p>
                  </figcaption>        
               </figure>
        </div>
		
		<?php } ?>
		<!-- END .box -->
	<?php endforeach;?>
	<?php endif; ?>
	
<script type="text/javascript">
	
	$('.videosLightbox a').simpleLightboxVideo();	
		
</script>