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
<section id="download" class="section">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span> <?= $page_title; ?></span></h2>
            </div>
        </div> 
		<?php 
			if(!empty($download_category)):
				 foreach($download_category as $category):
				 	$this->db->order_by('pos asc, id desc');
					$this->db->where("published", 1);
				 	$downloads_posts = $this->query_model->getbySpecific('tbldownloads', 'category', $category->cat_id);
					
						if(!empty($downloads_posts)):
		?>
		
        	<div class="col-md-12">
          <h2><?= $category->cat_name?></h2>
          <div class=" text-center row">
		  	<?php foreach($downloads_posts as $downloads_post): ?>
				<div class="col-md-3 col-xs-12 col-sm-6 ">
				  <div class="download-box">
				  <?php if(!empty($downloads_post->photo)){ ?>
				  	<img src="<?php echo base_url().'upload/downloads/'.$downloads_post->photo; ?>">
				  <?php } ?>
				  <h2><?= $downloads_post->name ?></h2>
				  <p><?= $downloads_post->desc ?></p>
				  <p>
				  	<?php if(!empty($downloads_post->files)): ?>
				  		<a target="_blank" href="<?php echo base_url().'upload/downloads/'.$downloads_post->files; ?>"><?php echo $this->query_model->getStaticTextTranslation('download'); ?></a>
						<?php /*?><?php echo base_url().$student_section_slug->slug; ?>/download_file/<?php echo str_replace(' ','_',trim($downloads_post->files)); ?><?php */?>
					<?php endif; ?>
				  </p>
				  </div>
				</div>
			 <?php endforeach; ?>
          </div>
        </div>
			
		<?php 
						endif; 
				endforeach; 
			endif;
		?>
        
    </div><!-- row --> 
    </div>
  </div>
</section>

<?php $this->load->view('includes/footer'); ?> 

