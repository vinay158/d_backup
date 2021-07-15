

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
<style type="text/css">
.video-box-min{ height:auto; overflow:hidden; }
.video-box-min img {display: inline-block;margin-top: 0;max-height: 200px;}
.videolist .video-box{ border:1px solid #ccc; width:100%; padding:10px; text-align:center;}
.img-responsive{ display:inline-block;}
.videoBoxBottomMargin{margin-bottom: 10px;}
.download-box .videoAlbum{width: 255px;}
</style>
<div class="mobile-contact">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> <span class="no"><?php echo $this->query_model->getStaticTextTranslation('student_section'); ?></span>
        <div class="row">
          <div class="col-xs-6 row-btn"> <a class="btn btn-theme"> <?php echo $this->query_model->getStaticTextTranslation('free_trial_class'); ?> </a> </div>
          <div class="col-xs-6 row-btn"> <a class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?> </a> </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
<!-- blog list -->
<section id="video" class="section">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span> <?= $page_title; ?></span></h2>
            </div>
        </div> 
			
			
		<?php if(!empty($type) && $type =="inner_page"){  ?>
			
			<?php if(!empty($album['categoryDetail'])){ ?>
				<!--- sub categories --->
					<div class="col-md-12">
					  <h2 class="inlineblock"><?= ucfirst($album['categoryDetail'][0]->cat_name)?></h2>
					  
					  <ol class="breadcrumb new">
						
						 <?php echo !empty($brandcrumb) ? $brandcrumb : ''; ?>
						  <li><a href="<?php echo base_url().$student_section_slug->slug.'/videos_albums'; ?>"><?php echo $this->query_model->getStaticTextTranslation('video_gallery'); ?></a></li>
						</ol>
						<div class="video-gallery">
						<div class="album">
					<?php 
						/*if(!empty($album['categoryDetail'][0]->cover)){
							$video_type = explode('/',$album['categoryDetail'][0]->cover);
							
							if($video_type[2] == 'img.youtube.com'){
								$cover_image = str_replace('0.jpg','mqdefault.jpg',$album['categoryDetail'][0]->cover);
							}else{
								$cover_image = str_replace('200x150.jpg','960x720.jpg',$album['categoryDetail'][0]->cover);
							}
							
							$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);
						}	
							$cover_image = !empty($album['categoryDetail'][0]->cover) ? $cover_image : base_url().'images/no_image_available.jpg';*/
							
							$this->db->limit(1);
							$this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
							 $this->db->where('is_cover_image',1);
							 $this->db->where('published',1);
							 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'category',$album['categoryDetail'][0]->cat_id);
							 
							 if(empty($coverVideo)){
								 $this->db->limit(1);
								 $this->db->order_by('pos asc, id desc');
								 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
								 $this->db->where('published',1);
								 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'category',$album['categoryDetail'][0]->cat_id); 
							 }
							 
							 
							 $cover_image = base_url().'images/no_image_available.jpg';
							 
							 if(!empty($coverVideo)){
								
								$videoData = array('video_type'=>$coverVideo[0]->video_type,'video_id'=>trim($coverVideo[0]->video_id), 'video_img_type' => $coverVideo[0]->video_img_type,'custom_video_thumbnail'=>$coverVideo[0]->custom_video_thumbnail);
								
								$cover_image = $this->query_model->getVideoThumbnilImage($videoData);
								
							 }
							 
							$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);
					?>
					  <div class="video-box 1">
						 <img src="<?= $cover_image; ?>" class="img-responsive videoAlbum">
					  </div>
					  
					  <div class="video-desc">
					  <h3><?php echo $album['categoryDetail'][0]->cat_name; ?></h3>
					  <p><?php echo $album['categoryDetail'][0]->description; ?></p>
					  
					  </div></div>
</div>				
				<?php if(!empty($album['sub_categories'])){ ?>
					<h2><?php echo $this->query_model->getStaticTextTranslation('sub_categories'); ?></h2>
				<?php } ?>
					<div class=" text-center row grid">
					 <div class="grid-sizer"></div>
					 
						<?php 
							if(!empty($album['sub_categories'])){
								
								foreach($album['sub_categories'] as $sub_cat){ 
						?>
						
								<div class="col-md-3 col-xs-12 col-sm-6 grid-item ">
									<a class="downloadTitle" href="<?php echo base_url().$student_section_slug->slug.'/videos_albums/'.$sub_cat->cat_id; ?>">
										<div class="download-box">
										<?php 
											/*if(!empty($sub_cat->cover)):
												$video_type = explode('/',$sub_cat->cover);
												
												if($video_type[2] == 'img.youtube.com'){
													$cover_image = str_replace('0.jpg','mqdefault.jpg',$sub_cat->cover);
												}else{
													$cover_image = str_replace('200x150.jpg','960x720.jpg',$sub_cat->cover);
												}
												
												$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);
												
											endif; 
												//echo 'cover_image=>'.$sub_cat->cover;
												$cover_image = !empty($sub_cat->cover) ? $cover_image : base_url().'images/no_image_available.jpg';*/
												
												$this->db->limit(1);
												$this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
												 $this->db->where('is_cover_image',1);
												 $this->db->where('published',1);
												 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'category',$sub_cat->cat_id);
												//echo '<pre>coverVideo'; print_r($coverVideo); die;
												 
												 if(empty($coverVideo)){
													 $this->db->limit(1);
													 $this->db->order_by('pos asc, id desc');
													 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
													 $this->db->where('published',1);
													 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'category',$sub_cat->cat_id); 
												 }
												 
												 $cover_image = base_url().'images/no_image_available.jpg';
												 
												 if(!empty($coverVideo)){
													
													$videoData = array('video_type'=>$coverVideo[0]->video_type,'video_id'=>trim($coverVideo[0]->video_id), 'video_img_type' => $coverVideo[0]->video_img_type,'custom_video_thumbnail'=>$coverVideo[0]->custom_video_thumbnail);
													
													$cover_image = $this->query_model->getVideoThumbnilImage($videoData);
													
												 }
												$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);
										?>
										  <div class="video-box 2">
											 <img src="<?= $cover_image; ?>" class="img-responsive videoAlbum">
										  </div>
										  <?php ?>
											<h2><?= ucfirst($sub_cat->cat_name) ?></h2>
										</div>
									</a>
								</div>
							<?php } } ?>
					  </div>
					</div>
					<hr>
					<?php if(!empty($album['videos'])){ ?>
					<h2><?php echo $this->query_model->getStaticTextTranslation('videos'); ?></h2>
					<?php } ?>
					<div class="col-md-12 album-list videolist">
					   <div class=" text-center row grid">
					   <div class="grid-sizer"></div>
					  <!--  download files -->
						<?php 
							if(!empty($album['videos'])){
								foreach($album['videos'] as $video){ 
								if(!empty($video)){ 
								
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
								//	$src=$this->query_model->getViemoVideoImage($v_id);
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
								<div class="col-md-4 col-sm-4 col-xs-12 videoBoxBottomMargin grid-item ">
									
									  <div class="video-box 3 <?= $video_class; ?> videosLightbox">
											<a href="#" class="slvj-link-lightbox 1" data-videoid="<?= $video_id ?>" data-videosite="<?= $video_type ?>"><img src="<?=$cover_image?>" class="img-responsive videoBox"  data-toggle="modal" data-target=".bs-example-modal-lg" url="<?php echo $video->link; ?>?modestbranding=1&autohide=1&showinfo=0&controls=1"></a>
										
										
										<p><?php  $this->query_model->getDescReplace( $video->desc); ?></p>
									  </div>
									</div>
							<?php } } } ?>
					  </div>
					</div>
			<?php } ?>
			
		<?php }else{ ?>
			
			<?php if(!empty($albums)){ 
						foreach($albums as $album){
			?>
					<div class="col-md-12">
					  <h2  class="inlineblock"><?= ucfirst($album['categories']->cat_name)?></h2>
					  <div class=" text-center row grid">
					  <div class="grid-sizer"></div>
						<?php 
						if(!empty($album['sub_categories'])){
						foreach($album['sub_categories'] as $sub_cat):   ?>
							<div class="col-md-3 col-xs-12 col-sm-6  grid-item ">
								<a class="downloadTitle" href="<?php echo base_url().$student_section_slug->slug.'/videos_albums/'.$sub_cat->cat_id; ?>">
									<div class="download-box">
									<?php 
									$this->db->limit(1);
									 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
									 $this->db->where('is_cover_image',1);
									 $this->db->where('published',1);
									 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'category',$sub_cat->cat_id);
									//  echo '<pre>coverVideo'; print_r($coverVideo); die;
									 
									 if(empty($coverVideo)){
										 $this->db->limit(1);
										 $this->db->order_by('pos asc, id desc');
										 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
										 $this->db->where('published',1);
										 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'category',$sub_cat->cat_id); 
									 }
									 
									 $cover_image = base_url().'images/no_image_available.jpg';
									 
									 if(!empty($coverVideo)){
										
										$videoData = array('video_type'=>$coverVideo[0]->video_type,'video_id'=>trim($coverVideo[0]->video_id), 'video_img_type' => $coverVideo[0]->video_img_type,'custom_video_thumbnail'=>$coverVideo[0]->custom_video_thumbnail);
										
										$cover_image = $this->query_model->getVideoThumbnilImage($videoData);
										
									 }
										
									
									$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);
											
											/*if(!empty($sub_cat->cover)):
												$video_type = explode('/',$sub_cat->cover);
												
												if($video_type[2] == 'img.youtube.com'){
													$cover_image = str_replace('0.jpg','mqdefault.jpg',$sub_cat->cover);
												}else{
													$cover_image = str_replace('200x150.jpg','960x720.jpg',$sub_cat->cover);
												}
												
												$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);
											
											endif;
											
												$cover_image = !empty($sub_cat->cover) ? $cover_image : base_url().'images/no_image_available.jpg';*/
										?>
										  <div class="video-box 4">
											 <img src="<?= $cover_image; ?>" class="img-responsive videoAlbum" style="min-width:253px">
										  </div>
										  <?php  ?>
										  <div class="video-desc">
                <h3><?= ucfirst($sub_cat->cat_name) ?> </h3>
                
                
              </div>
										
									</div>
								</a>
							</div>
						<?php endforeach; } ?>
					  </div>
					</div>
					
					
					<?php if(!empty($album['videos'])){ ?>
					<div class="col-md-12">
					<h4><?php echo $this->query_model->getStaticTextTranslation('videos_of'); ?> <?= ucfirst($album['categories']->cat_name)?></h4>
					</div>
					<?php } ?>
					<div class="col-md-12 album-list videolist">
					   <div class=" text-center row grid">
					    <div class="grid-sizer"></div>
					  <!--  download files -->
						<?php 
							if(!empty($album['videos'])){
								foreach($album['videos'] as $video){ 
								if(!empty($video)){ 
								
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
								<div class="col-md-4 col-sm-4 col-xs-12 videoBoxBottomMargin  grid-item ">
									
									  <div class="video-box 5 <?= $video_class; ?> videosLightbox">
											<a href="#" class="slvj-link-lightbox 1" data-videoid="<?= $video_id ?>" data-videosite="<?= $video_type ?>">
											<img src="<?=$cover_image?>" class="img-responsive videoBox"  data-toggle="modal" data-target=".bs-example-modal-lg" url="<?php echo $video->link; ?>?modestbranding=1&autohide=1&showinfo=0&controls=1" style="<?php echo strstr($cover_image,'/video_album_cover') ? 'padding-bottom: 20px;' : '';?>">
											</a>
										
										
										<p><?php  $this->query_model->getDescReplace( $video->desc); ?></p>
									  </div>
									</div>
							<?php } } } ?>
					  </div>
					</div>
			<?php }  } ?>
		
		<?php } ?>
        
    </div><!-- row --> 
    </div>
  </div>
</section>

<script type="text/javascript">
	
	$('.videosLightbox a').simpleLightboxVideo();
	
	
	/*$(document).ready(function(){
		$('.videoBox').hover(function(){
			$('#buffer-extension-hover-button').css('display','block');
		});
	}); */
		
</script>

<script src="<?php echo base_url(); ?>js/new_jit/masonry.pkgd.min.js"></script>
<style type="text/css">


  .grid-sizer {
    width: 25%;
  }

  

</style>
<script>
var msnry = new Masonry( '.grid', {
  columnWidth: '.grid-sizer',
  percentPosition: false
});
</script>


<?php $this->load->view('includes/footer'); ?> 

