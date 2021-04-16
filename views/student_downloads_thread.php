<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/student_header/masthead'); ?>


<!-- blog list -->
<section id="download" class="section">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span> <?= $page_title; ?></span></h2>
            </div>
        </div> 
			
			
		<?php if(!empty($type) && $type =="inner_page"){ ?>
			
			<?php if(!empty($downloads['categoryDetail'])){ ?>
				<!--- sub categories --->
					<div class="col-md-12">
					  <h2 class="inlineblock"><?= ucfirst($downloads['categoryDetail'][0]->cat_name)?></h2>
					  <ol class="breadcrumb new">
						
						 <?php echo !empty($brandcrumb) ? $brandcrumb : ''; ?>
						  <li><a href="<?php echo base_url().$student_section_slug->slug.'/downloads'; ?>"><?php echo $this->query_model->getStaticTextTranslation('downloads'); ?></a></li>
						</ol>
					  
					  <div class=" text-center row">
					  
						<?php 
							if(!empty($downloads['sub_categories'])){
								foreach($downloads['sub_categories'] as $sub_cat){ 
						?>
								<div class="col-md-3 col-xs-12 col-sm-6 ">
									<a class="downloadTitle" href="<?php echo base_url().$student_section_slug->slug.'/downloads/'.$sub_cat->cat_id; ?>">
										<div class="download-box">
											<h2><?= ucfirst($sub_cat->cat_name) ?></h2>
										</div>
									</a>
								</div>
							<?php } } ?>
					  </div>
					</div>
					
					<div class="col-md-12">
					   <div class=" row text-center  grid">
					   <div class="grid-sizer"></div>
					  <!--  download files -->
						<?php 
							if(!empty($downloads['downloadFiles'])){
								foreach($downloads['downloadFiles'] as $downloadFile){ 
								if(!empty($downloadFile)){ 
						?>
						
								<div class="col-md-3 col-xs-12 col-sm-6 grid-item ">
									  <div class="download-box">
									  <?php if(!empty($downloadFile->photo)){ ?>
										<img src="<?php echo base_url().'upload/downloads/'.$downloadFile->photo; ?>">
									  <?php } ?>
									  <h2><?= ucfirst($downloadFile->name) ?></h2>
									  <p><?= $downloadFile->desc ?></p>
									  <p>
										<?php if(!empty($downloadFile->files)): ?>
											<a target="_blank" href="<?php echo base_url().'upload/downloads/'.$downloadFile->files; ?>"><?php echo $this->query_model->getStaticTextTranslation('download'); ?></a>
											<?php /*?><?php echo base_url().$student_section_slug->slug; ?>/download_file/<?php echo str_replace(' ','_',trim($downloads_post->files)); ?><?php */?>
										<?php endif; ?>
									  </p>
									  </div>
									</div>
									
									
							<?php } } } ?>
					  </div>
					</div>
			<?php } ?>
			
		<?php }else{ ?>
			
			<?php if(!empty($downloads)){ 
						foreach($downloads as $download){
							if(!empty($download['sub_categories'])){
			?>
					<div class="col-md-12">
					  <h2  class="inlineblock"><?= ucfirst($download['categories']->cat_name)?></h2>
					  <div class=" text-center row">
						<?php foreach($download['sub_categories'] as $sub_cat): ?>
							<div class="col-md-3 col-xs-12 col-sm-6 ">
								<a class="downloadTitle" href="<?php echo base_url().$student_section_slug->slug.'/downloads/'.$sub_cat->cat_id; ?>">
									<div class="download-box">
										<h2><?= ucfirst($sub_cat->cat_name) ?></h2>
									</div>
								</a>
							</div>
						 <?php endforeach; ?>
					  </div>
					</div>
			<?php } } } ?>
		
		<?php } ?>
        
    </div><!-- row --> 
    </div>
  </div>
</section>
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

