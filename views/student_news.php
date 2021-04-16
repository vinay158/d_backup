<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/student_header/masthead'); ?>
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
      <div class="col-sm-12 text-center"> <span class="no"><?php echo $this->query_model->getStaticTextTranslation('student_section'); ?></span>
        <div class="row">
          <?php if($site_settings[0]->hide_window != 'hide'): ?>
            <div class="col-xs-6 row-btn"> 
			<a class="btn btn-theme"  href="<?php echo $this->query_model->getTrialOfferUrl($site_settings[0]->url_call_to_action); ?>" target="<?php if($site_settings[0]->window == 'new'): echo '_blank'; endif; ?>"> 
			<?php $this->query_model->getStrReplace($site_settings[0]->call_to_action); ?></a> 
			</div>
			<?php endif; ?><div class="col-xs-6 row-btn"> 
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

<section id="postwrap">
  <div class="container">
    <div class="row">
    <div class="col-md-8">
        <div class="title-main">
          <h2><span> <?= $page_title; ?>  </span></h2>
        </div>
        <div class="post-list-container">
         <?php
			$sr_news=0;  
				if(!empty($student_news)):
			 		foreach($student_news as $news):
			 	$sr_news++;
		?>
		  <div class="post">
            <h2><?php  $this->query_model->getDescReplace( $news->title); ?></h2>
            <p class="date-posted"> <?php echo $this->query_model->getStaticTextTranslation('posted'); ?>: <?php echo date('F d, Y', strtotime($news->timestamp)); ?></p>
            <p><?php  $this->query_model->getShortDescReplace( $news->short_desc, 510); ?></p>
            <p> <a href="<?= $student_section_slug->slug;?>/news_detail/<?=  $news->slug; ?>"> <button class="btn btn-theme"> <?php echo $this->query_model->getStaticTextTranslation('continue_reading'); ?></button></a></p>
          </div>
          <hr>
         <?php endforeach; endif; ?>
        </div>
        <div class="clearfix"></div>
        <div class="button-post paginationButtons clearfix">
         <!-- <a href="#" class="prev-post"><i class="fa fa-angle-double-left"></i> Older Post </a>
          <a href="#" class="next-post">Newer Post <i class="fa fa-angle-double-right"></i></a>-->
		   <?php echo $paginglinks;?>
        </div>
      </div>
    <div class="col-md-4">
     

      <div class="archive">
        <h3> <?php echo $this->query_model->getStaticTextTranslation('archive'); ?></h3>
        <div id="accordion" role="tablist" aria-multiselectable="true">
		<?php 
			$j = 0;
			for ($i = 0; $i <= 12; $i++) {
					$months = date("M Y", strtotime( date( 'Y-m-01' )." -$i months"));
					
					$months_list = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
					$getNews = $this->query_model->getThisMonthNews($months_list);
					if(!empty($getNews)){
						$j++;
					
					
		?>
		
				<div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo<?= $j ?>">
					  <p class="panel-title">
						<a class="collapsed blogToggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?= $j ?>" aria-expanded="false" aria-controls="collapseTwo<?= $i ?>">
						  <i class="fa fa-caret-right"></i><?php echo $months; ?>
						</a>
					  </p>
					</div>
					<div id="collapseTwo<?= $j ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?= $j ?>">
					  <ul class="archive-list">
					 <?php foreach($getNews as $getArchiveNews): ?>
               		<li class="archive_news_list"><a href="<?php echo $student_section_slug->slug.'/news_detail/'.$getArchiveNews->slug ?>"><?php $this->query_model->getDescReplace($getArchiveNews->title); ?> </a></li>
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

<?php $this->load->view('includes/footer'); ?> 

