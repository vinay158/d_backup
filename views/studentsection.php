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

<section id="postwrap">
  <div class="container">
    <div class="row">
    <div class="col-md-8">
		<?php if($site_setting[0]->homepage_referral_box == 1): ?>
        <div class="rewards text-center">
            <h2><?php  $this->query_model->getDescReplace($site_setting[0]->homepage_referral_title); ?> </h2>
            <p><?php  $this->query_model->getDescReplace($site_setting[0]->homepage_referral_desc); ?> </p>
        </div>
		<?php endif; ?>
		
		<?php if(!empty($student_news)): ?>
        <div class="title-main">
          <h2><span> <?php  $this->query_model->getDescReplace( $page_titles ); ?> </span></h2>
        </div>
        <div class="post-list-container">
         <?php
			$sr_news=0;  
				
			 		foreach($student_news as $news):
			 	$sr_news++;
		?>
		  <div class="post">
            <h2><?php  $this->query_model->getDescReplace( $news->title); ?></h2>
            <p class="date-posted"> <?php echo $this->query_model->getStaticTextTranslation('posted'); ?>: <?php echo date('F d, Y', strtotime($news->timestamp)); ?></p>
            <p>
				<?php  $this->query_model->getShortDescReplace( $news->short_desc, 510); ?>
			</p>
            <p> <a href="<?= $student_section_slug->slug;?>/news_detail/<?=  $news->slug; ?>"><button class="btn btn-theme"> <?php echo $this->query_model->getStaticTextTranslation('continue_reading'); ?></button></a></p>
          </div>
          <hr>
         <?php endforeach;?>
        </div>
		
        <div class="clearfix"></div>
        <div class="button-post paginationButtons clearfix">
        <!-- <a href="#" class="prev-post"><i class="fa fa-angle-double-left"></i> Older Post </a>
          <a href="#" class="next-post">Newer Post <i class="fa fa-angle-double-right"></i></a>-->
		  <?php echo $paginglinks;?>
        </div>
		<?php  endif;  ?>
      </div>
      <div class="col-md-4">
	  <?php
	  if($site_setting[0]->show_home_recent_event == 1){

	  if(!empty($special_events)){ ?>
      	<div class="recent-post">
        <h3><?php echo $this->query_model->getStaticTextTranslation('upcoming_events'); ?></h3>
        <ul class="post-list event-list">
         	<?php foreach($special_events as $special_event): 
						$mydate = date('Y/m/d',strtotime($special_event->mydate));
					
			?>
			
		 	 <li><a href="<?php echo base_url().$events_slug->slug.'/requested/'.$mydate; ?>"><?= $special_event->title ?></a><br />
         		 <span class="event-date"><?php echo date('F dS Y', strtotime($special_event->mydate)); ?></span>
          	 </li>
			 <?php endforeach; ?>
        </ul>
        <div class="view-all">
          <a href="<?php echo base_url(); ?>martial-arts-events"><?php echo $this->query_model->getStaticTextTranslation('view_all'); ?></a>
        </div>
      </div>
	  <?php } } ?>
	  
	  <?php 
	  if($site_setting[0]->show_home_recent_upload == 1){
	  if(!empty($latest_downloads)){ ?>
       <div class="recent-post">
        <h3><?php echo $this->query_model->getStaticTextTranslation('recent_uploads'); ?></h3>
        <ul class="post-list event-list recent">
         <?php foreach($latest_downloads as $latest_download): ?> 
		 	 <li><!--<a href="<?php echo base_url().$student_section_slug->slug; ?>/download_file/<?php echo str_replace(' ','_',trim($latest_download->files)); ?>"><?= $latest_download->name ?></a>-->
			 <a href="<?php echo base_url().'upload/downloads/'.$latest_download->files; ?>" target="_blank"><?= $latest_download->name ?></a>
         		 <!--<span class="event-date">January 4th, 2015</span>-->
         	 </li>
         <?php endforeach; ?>
        </ul>
        <div class="view-all">
          <a href="<?php echo base_url().$student_section_slug->slug; ?>/downloads"><?php echo $this->query_model->getStaticTextTranslation('view_all'); ?></a>
        </div>
      </div>
	<?php } } ?>
      <!--<div class="archive">
        <h3> Archive</h3>
        <div id="accordion" role="tablist" aria-multiselectable="true">
		<?php 
			$j = 0;
			for ($i = 0; $i <= 12; $i++) {
					$months = date("M Y", strtotime( date( 'Y-m-01' )." -$i months"));
					
					$months_list = date("Y-m", strtotime( date( 'Y-m-01' )." -$i months"));
					$getNews = $this->query_model->getThisMonthNews($months_list);
					if(!empty($getNews)){
						$j++;
					
					if($j == 1){
		?>
			<div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <p class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  <i class="fa fa-caret-right"></i><?php echo $months; ?>
                </a>
              </p>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
             <ul class="archive-list">
			 	<?php foreach($getNews as $getArchiveNews): ?>
               		<li class="archive_news_list"><a href="<?php echo $student_section_slug->slug.'/news_detail/'.$getArchiveNews->id ?>">• <?php  $this->query_model->getDescReplace( $getArchiveNews->title); ?> </a></li>
			   <?php endforeach; ?>
             </ul>
            </div>
          </div>
				<?php } else { ?>
         		 <div class="panel panel-default">
					<div class="panel-heading" role="tab" id="headingTwo<?= $i ?>">
					  <p class="panel-title">
						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo<?= $i ?>" aria-expanded="false" aria-controls="collapseTwo<?= $i ?>">
						  <i class="fa fa-caret-right"></i><?php echo $months; ?>
						</a>
					  </p>
					</div>
					<div id="collapseTwo<?= $i ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?= $i ?>">
					  <ul class="archive-list">
					  <?php foreach($getNews as $getArchiveNews): ?>
               			<li class="archive_news_list"><a href="<?php echo $student_section_slug->slug.'/news_detail/'.$getArchiveNews->id ?>">• <?php  $this->query_model->getDescReplace( $getArchiveNews->title); ?> </a></li>
					 <?php endforeach; ?>
					 </ul>
					</div>
				  </div>	
		 		 <?php } ?>
			<?php } } ?>  
		
        </div>
      </div>-->
	  
	<?php 
	 if($site_setting[0]->show_home_recent_post == 1){
	  if(!empty($recents_news)){ ?>
     	 <div class="recent-post">
			<h3><?php echo $this->query_model->getStaticTextTranslation('recent_posts'); ?></h3>
			<ul class="post-list">
			 <?php foreach($recents_news as $news): ?>
			  <li><a href="<?php echo $student_section_slug->slug.'/news_detail/'.$news->slug; ?>"><?php $this->query_model->getDescReplace($news->title); ?></a></li>
			 <?php endforeach; ?>
			</ul>
     	 </div>
	  <?php } } ?>
	
      </div>
 
      
 
    </div>
  </div>
</section>

<?php $this->load->view('includes/footer'); ?> 

