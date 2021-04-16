
<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
	$(document).ready(function(){
		$('.blogToggle').click(function(){
			
			$('.fa').removeClass('fa-caret-down newdownarrow');
			$('.fa').addClass('fa-caret-right');
			
			if($(this).attr('aria-expanded') == 'false'){
				$(this).children('.fa').removeClass('fa-caret-right');
				$(this).children('.fa').addClass('fa-caret-down newdownarrow');
			}else{
				$(this).children('.fa').removeClass('fa-caret-down newdownarrow');
				$(this).children('.fa').addClass('fa-caret-right');
			}
		});
	});
</script>

<div class="mobile-contact">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> <span class="no"><?= $page_title ?></span>
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
<section id="postwrap">
  <div class="container">
    <div class="row">
	
    <div class="col-md-8">
		<?php if(!empty($blogs)): ?>
        <div class="post-list-container">
         <?php
			$sr_blog=0;  
				if(!empty($blogs)):
			 		foreach($blogs as $blog):
			 	$sr_blog++;
		?>
		  <div class="post">
            <h2><?php  $this->query_model->getDescReplace( $blog->title); ?></h2>
            <p class="date-posted"> <?php echo $this->query_model->getStaticTextTranslation('posted'); ?>: <?php echo date('F d, Y', strtotime($blog->timestamp)); ?></p>
            <p><?php 
					$description = $this->query_model->getMetaDescReplace( $blog->short_desc); 
					$description = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $description);
					if(!empty($description)){
						$string = explode("\n", $description);
						 array_splice($string, 5);
						 echo implode("\n", $string);
					}
					 
				?>  </p>
				<?php 
					$slug = ($blog->hide_from_public_blog == 0) ? $blogs_slug->slug : $pages_slug->slug;
				?>
            <p><a href="<?= $slug;?>/<?php echo $blog->slug; ?>"> <button class="btn btn-theme"> <?php echo $this->query_model->getStaticTextTranslation('continue_reading'); ?></button></a></p>
          </div>
          <hr>
         <?php endforeach; endif; ?>
        </div>
        <div class="clearfix"></div>
        <div class="button-post paginationButtons clearfix">
		   <?php echo $paginglinks;?>
        </div>
	 <?php endif; ?>
      </div>
      <div class="col-md-4">
	  <?php if(!empty($recents_blogs)): ?>
     	 <div class="recent-post">
			<h3><?php echo $this->query_model->getStaticTextTranslation('recent_posts'); ?></h3>
			<ul class="post-list">
			 <?php foreach($recents_blogs as $recents_blog): ?>
			  <li><a href="<?php echo $blogs_slug->slug.'/'.$recents_blog->slug; ?>"><?php $this->query_model->getDescReplace($recents_blog->title); ?></a></li>
			 <?php endforeach; ?>
			</ul>
     	 </div>
	  <?php endif; ?>
      <div class="archive">
        <h3><?php echo $this->query_model->getStaticTextTranslation('archive'); ?></h3>
        <div id="accordion" role="tablist" aria-multiselectable="true">
		<?php 
			$j = 0;
			for ($i = 0; $i <= 12; $i++) {
					$months = date("M Y", strtotime( date( 'Y-m-01' )." -$i months"));
					
					$months_list = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
					$getBlogs = $this->query_model->getThisMonthBlogs($months_list);
					if(!empty($getBlogs)){
						$j++;
					
					
		?>
			<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo<?= $i ?>">
					  <p class="panel-title">
						<a class="collapsed blogToggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?= $i ?>" aria-expanded="false" aria-controls="collapseTwo<?= $i ?>">
						  <i class="fa fa-caret-right"></i><?php echo $months; ?>
						</a>
					  </p>
					</div>
					<div id="collapseTwo<?= $i ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?= $i ?>">
					  <ul class="archive-list">
					  <?php foreach($getBlogs as $getArchiveNews): ?>
               			<li class="archive_news_list"><a href="<?php echo $blogs_slug->slug.'/'.$getArchiveNews->slug; ?>"><?php  $this->query_model->getDescReplace( $getArchiveNews->title); ?> </a></li>
					 <?php endforeach; ?>
					 </ul>
					</div>
				  </div>
				
			<?php } } ?>  
		
        </div>
      </div>
      </div>
 
      
 
    </div>
  </div>
</section>
<!-- blog list ends here -->

<?php $this->load->view('includes/footer'); ?> 

