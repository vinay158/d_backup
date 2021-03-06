<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/student_header/masthead'); ?>

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
			<?php endif; ?><div class="col-xs-6 row-btn"> 
			<?php if($multiLocation[0]->field_value == 1 ){ ?>
				<a class="btn btn-theme" href="javascript:void(0);"  target="_blank"> <i class="fa fa-map-marker"></i> <?php echo ' '.count($allLocations).' '.$this->query_model->getStaticTextTranslation('locations'); ?></a>
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
<section id="video" class="section">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span> <?= $page_title; ?> </span></h2>
            </div>
        </div> 
        <div class="video-gallery">
		<?php 
			if(!empty($video_albums)):
				foreach($video_albums as $album): //echo '<pre>'; print_r($album); 
		?>
          <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="album">
			 <?php 
			 	/*if(!empty($album->cover)):
					$video_type = explode('/',$album->cover);
					
					if($video_type[2] == 'img.youtube.com'){
						$cover_image = str_replace('0.jpg','mqdefault.jpg',$album->cover);
					}else{
						$cover_image = str_replace('200x150.jpg','960x720.jpg',$album->cover);
					}
					
					$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);*/
					
					$this->db->limit(1);
					 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
					 $this->db->where('is_cover_image',1);
					 $this->db->where('published',1);
					 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'album',$album->id);
					 
					 if(empty($coverVideo)){
						 $this->db->limit(1);
						 $this->db->order_by('pos asc, id desc');
						 $this->db->select(array('id','video_id','video_type','is_cover_image','video_img_type','custom_video_thumbnail'));
						 $this->db->where('published',1);
						 $coverVideo = $this->query_model->getBySpecific('tblmedia', 'album',$album->id); 
					 }
					 
					 $cover_image = base_url().'assets_admin/img/no-image.png';
					 
					 if(!empty($coverVideo)){
						
						$videoData = array('video_type'=>$coverVideo[0]->video_type,'video_id'=>trim($coverVideo[0]->video_id), 'video_img_type' => $coverVideo[0]->video_img_type,'custom_video_thumbnail'=>$coverVideo[0]->custom_video_thumbnail);
						
						$cover_image = $this->query_model->getVideoThumbnilImage($videoData);
						
					 }
						
					
					$cover_image = $this->query_model->changeVideoImgPathHttp($cover_image);
					
			?>
              <div class="video-box">
                 <img src="<?= $cover_image; ?>" class="img-responsive videoAlbum">
              </div>
			  <?php //endif; ?>
              <div class="video-desc">
                <h3><?php  $this->query_model->getDescReplace( $album->album); ?></h3>
                <p><?php  $this->query_model->getDescReplace( $album->desc); ?></p>
                <p><a href="<?php echo base_url().$student_section_slug->slug; ?>/videos/<?php echo $album->id; ?>" class="btn-view"><?php echo $this->query_model->getStaticTextTranslation('view_album'); ?></a> </p>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        <?php endforeach; endif; ?>  
        </div>  
    </div>
  </div>
</section>

<?php $this->load->view('includes/footer'); ?> 

