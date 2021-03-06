
<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>
<?php 
$blog_slug = $this->query_model->getbySpecific('tblmeta', 'id', 48);
	$blog_slug = $blog_slug[0];
	//$_SERVER['HTTP_REFERER'];
	$blog_path = base_url().$blog_slug->slug.'/'.$blog_detail[0]->slug;
	
	//echo $blog_path; die;
	$setting = $this->query_model->getbyTable('tblsite');
?>

<div class="mobile-contact">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> <span class="no"><?php echo $this->query_model->getStaticTextTranslation('blog'); ?></span>
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
<!-- blog list -->
<section id="postwrap" class="bloglist">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
	  	<?php if(!empty($blog_detail)): ?>
     	   <div class="post-list-container">
          <div class="post">
		  	<?php if(!empty($blog_detail[0]->image)): ?>
				<div class="post-image">
				  <img src="<?php echo base_url().$blog_detail[0]->image ?>" class="img-responsive" alt="<?php  $this->query_model->getDescReplace($blog_detail[0]->image_alt); ?>">
				</div>
			<?php endif; ?>
            <h2><?php  $this->query_model->getDescReplace(  $blog_detail[0]->title); ?></h2>
            <p class="date-posted"> <?php echo $this->query_model->getStaticTextTranslation('posted'); ?>: <?php echo date('F d, Y', strtotime($blog_detail[0]->timestamp)); ?></p>
            <p><?php $this->query_model->getDescReplace(  $blog_detail[0]->content); ?></p>
			
			<?php 
				$description = $this->query_model->getMetaDescReplace(  $blog_detail[0]->content); 
				$description = strip_tags($description);
				
				$image_url = base_url().$blog_detail[0]->image;
			?>
			<div class="row">
			<div class="col-md-8">
<link rel="stylesheet" href="lightbox/social_share/css/rrssb.css" />
<ul class="rrssb-buttons">

<li class="rrssb-email">
<!-- Replace subject with your message using URL Endocding: https://meyerweb.com/eric/tools/dencoder/ -->
<a href="mailto:<?= $setting[0]->email ?>?subject=<?= $blog_detail[0]->title ?>&amp;body=<?= $blog_path ?>" target="_blank">
  <span class="rrssb-icon">
	<svg xmlns="https://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"><path d="M20.11 26.147c-2.335 1.05-4.36 1.4-7.124 1.4C6.524 27.548.84 22.916.84 15.284.84 7.343 6.602.45 15.4.45c6.854 0 11.8 4.7 11.8 11.252 0 5.684-3.193 9.265-7.398 9.3-1.83 0-3.153-.934-3.347-2.997h-.077c-1.208 1.986-2.96 2.997-5.023 2.997-2.532 0-4.36-1.868-4.36-5.062 0-4.75 3.503-9.07 9.11-9.07 1.713 0 3.7.4 4.6.972l-1.17 7.203c-.387 2.298-.115 3.3 1 3.4 1.674 0 3.774-2.102 3.774-6.58 0-5.06-3.27-8.994-9.304-8.994C9.05 2.87 3.83 7.545 3.83 14.97c0 6.5 4.2 10.2 10 10.202 1.987 0 4.09-.43 5.647-1.245l.634 2.22zM16.647 10.1c-.31-.078-.7-.155-1.207-.155-2.572 0-4.596 2.53-4.596 5.53 0 1.5.7 2.4 1.9 2.4 1.44 0 2.96-1.83 3.31-4.088l.592-3.72z"/></svg>
  </span>
  <!--<span class="rrssb-text">email</span>-->
</a>
</li>

<li class="rrssb-facebook">
<!--  Replace with your URL. For best results, make sure you page has the proper FB Open Graph tags in header:
	  https://developers.facebook.com/docs/opengraph/howtos/maximizing-distribution-media-content/ -->
<!--<a href="https://www.facebook.com/sharer/sharer.php?u=<?= $blog_path ?>" class="popup" target="_blank"> -->
<a href="https://www.facebook.com/sharer/sharer.php?title=<?php echo $this->query_model->getMetaDescReplace(  $blog_detail[0]->title); ?>&description=<?php echo $description; ?>&picture=<?php echo $image_url; ?>&u=<?= $blog_path ?>" class="popup" target="_blank">
  <span class="rrssb-icon">
	<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 29 29"><path d="M26.4 0H2.6C1.714 0 0 1.715 0 2.6v23.8c0 .884 1.715 2.6 2.6 2.6h12.393V17.988h-3.996v-3.98h3.997v-3.062c0-3.746 2.835-5.97 6.177-5.97 1.6 0 2.444.173 2.845.226v3.792H21.18c-1.817 0-2.156.9-2.156 2.168v2.847h5.045l-.66 3.978h-4.386V29H26.4c.884 0 2.6-1.716 2.6-2.6V2.6c0-.885-1.716-2.6-2.6-2.6z"/></svg>
  </span>
  <span class="rrssb-text">facebook</span>
</a>
</li>



<li class="rrssb-tumblr">
<a href="https://tumblr.com/share/link?url=<?= $blog_path ?>&name=<?php echo $blog_detail[0]->title; ?>&description=<?php echo $blog_detail[0]->title; ?>" target="_blank">
  <span class="rrssb-icon">
	<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M18.02 21.842c-2.03.052-2.422-1.396-2.44-2.446v-7.294h4.73V7.874H15.6V1.592h-3.714s-.167.053-.182.186c-.218 1.935-1.144 5.33-4.988 6.688v3.637h2.927v7.677c0 2.8 1.7 6.7 7.3 6.6 1.863-.03 3.934-.795 4.392-1.453l-1.22-3.54c-.52.213-1.415.413-2.115.455z"/></svg>
  </span>
  <span class="rrssb-text">tumblr</span>
</a>
</li>

<li class="rrssb-linkedin">
<!-- Replace href with your meta and URL information -->
<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?= $blog_path ?>&amp;title=<?= $blog_detail[0]->title ?>" class="popup" target="_blank">
  <span class="rrssb-icon">
	<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M25.424 15.887v8.447h-4.896v-7.882c0-1.98-.71-3.33-2.48-3.33-1.354 0-2.158.91-2.514 1.802-.13.315-.162.753-.162 1.194v8.216h-4.9s.067-13.35 0-14.73h4.9v2.087c-.01.017-.023.033-.033.05h.032v-.05c.65-1.002 1.812-2.435 4.414-2.435 3.222 0 5.638 2.106 5.638 6.632zM5.348 2.5c-1.676 0-2.772 1.093-2.772 2.54 0 1.42 1.066 2.538 2.717 2.546h.032c1.71 0 2.77-1.132 2.77-2.546C8.056 3.593 7.02 2.5 5.344 2.5h.005zm-2.48 21.834h4.896V9.604H2.867v14.73z"/></svg>
  </span>
  <span class="rrssb-text">linkedin</span>
</a>
</li>
<li class="rrssb-twitter">
<!-- Replace href with your Meta and URL information  -->
<a href="https://twitter.com/intent/tweet?text=<?= $blog_detail[0]->title ?>%20<?= $blog_path ?>" class="popup" target="_blank">
  <span class="rrssb-icon">
	<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M24.253 8.756C24.69 17.08 18.297 24.182 9.97 24.62a15.093 15.093 0 0 1-8.86-2.32c2.702.18 5.375-.648 7.507-2.32a5.417 5.417 0 0 1-4.49-3.64c.802.13 1.62.077 2.4-.154a5.416 5.416 0 0 1-4.412-5.11 5.43 5.43 0 0 0 2.168.387A5.416 5.416 0 0 1 2.89 4.498a15.09 15.09 0 0 0 10.913 5.573 5.185 5.185 0 0 1 3.434-6.48 5.18 5.18 0 0 1 5.546 1.682 9.076 9.076 0 0 0 3.33-1.317 5.038 5.038 0 0 1-2.4 2.942 9.068 9.068 0 0 0 3.02-.85 5.05 5.05 0 0 1-2.48 2.71z"/></svg>
  </span>
  <span class="rrssb-text">twitter</span>
</a>
</li>

<li class="rrssb-googleplus">
<a href="https://plus.google.com/share?url=<?= $blog_path ?>%20<?= $blog_detail[0]->title ?>" class="popup" target="_blank">
  <span class="rrssb-icon">
	<svg xmlns="https://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 8.29h-1.95v2.6h-2.6v1.82h2.6v2.6H21v-2.6h2.6v-1.885H21V8.29zM7.614 10.306v2.925h3.9c-.26 1.69-1.755 2.925-3.9 2.925-2.34 0-4.29-2.016-4.29-4.354s1.885-4.353 4.29-4.353c1.104 0 2.014.326 2.794 1.105l2.08-2.08c-1.3-1.17-2.924-1.883-4.874-1.883C3.65 4.586.4 7.835.4 11.8s3.25 7.212 7.214 7.212c4.224 0 6.953-2.988 6.953-7.082 0-.52-.065-1.104-.13-1.624H7.614z"/></svg>            </span>
  <span class="rrssb-text">google+</span>
</a>
</li>

<li class="rrssb-pinterest">
<!-- Replace href with your meta and URL information.  -->
<a href="https://pinterest.com/pin/create/button/?url=<?= $blog_path ?>&amp;media=<?php if(!empty($blog_detail[0]->image)){ echo base_url().$blog_detail[0]->image; } else{ echo base_url().$site_settings[0]->sitelogo;} ?>&amp;description=<?php echo $blog_detail[0]->title; ?>" target="_blank">
  <span class="rrssb-icon">
	<svg xmlns="https://www.w3.org/2000/svg" viewBox="0 0 28 28"><path d="M14.02 1.57c-7.06 0-12.784 5.723-12.784 12.785S6.96 27.14 14.02 27.14c7.062 0 12.786-5.725 12.786-12.785 0-7.06-5.724-12.785-12.785-12.785zm1.24 17.085c-1.16-.09-1.648-.666-2.558-1.22-.5 2.627-1.113 5.146-2.925 6.46-.56-3.972.822-6.952 1.462-10.117-1.094-1.84.13-5.545 2.437-4.632 2.837 1.123-2.458 6.842 1.1 7.557 3.71.744 5.226-6.44 2.924-8.775-3.324-3.374-9.677-.077-8.896 4.754.19 1.178 1.408 1.538.49 3.168-2.13-.472-2.764-2.15-2.683-4.388.132-3.662 3.292-6.227 6.46-6.582 4.008-.448 7.772 1.474 8.29 5.24.58 4.254-1.815 8.864-6.1 8.532v.003z"/></svg>
  </span>
  <span class="rrssb-text">pinterest</span>
</a>
</li>

<li class="rrssb-print">
<a href="javascript:window.print()">
  <span class="rrssb-icon">
	<svg height="24" viewBox="0 0 24 24" width="24" xmlns="https://www.w3.org/2000/svg"><path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/><path d="M0 0h24v24H0z" fill="none"/></svg>
  </span>
  <span class="rrssb-text">print</span>
</a>
</li>

</ul>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
window.jQuery || document.write('<script src="js/vendor/jquery.1.10.2.min.js"><\/script>')
</script>

<script src="lightbox/social_share/js/rrssb.min.js"></script>
</div></div>
          </div>
         
          <hr>
        </div>
		<?php endif; ?>
        <div class="clearfix"></div>
        <div class="button-post clearfix">
         <?php if(!empty($previos_blog[0]->id)): ?>
			<?php 
					$prev_slug = ($previos_blog[0]->hide_from_public_blog == 0) ? $blogs_slug->slug : $pages_slug->slug;
				?>
		 <a href="<?php echo $prev_slug.'/'.$previos_blog[0]->slug; ?>" class="prev-post"><i class="fa fa-angle-double-left"></i> <?php echo $this->query_model->getStaticTextTranslation('older_post'); ?> </a><?php endif; ?>
          <?php if(!empty($next_blog[0]->id)): ?>
		  <?php 
					$next_slug = ($next_blog[0]->hide_from_public_blog == 0) ? $blogs_slug->slug : $pages_slug->slug;
				?>
		  <a href="<?php echo $next_slug.'/'.$next_blog[0]->slug; ?>" class="next-post"><?php echo $this->query_model->getStaticTextTranslation('newer_post'); ?><i class="fa fa-angle-double-right"></i></a><?php endif; ?>
        </div>
      </div>
      <div class="col-md-4">
	  <?php if(!empty($recents_blogs)): ?>
     	 <div class="recent-post">
			<h3><?php echo $this->query_model->getStaticTextTranslation('recent_posts'); ?></h3>
			<ul class="post-list">
			 <?php foreach($recents_blogs as $recents_blog): ?>
			  <li><a href="<?php echo $blogs_slug->slug.'/'.$recents_blog->slug; ?>"><?php  $this->query_model->getDescReplace($recents_blog->title); ?></a></li>
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
<?php $this->load->view('includes/footer'); ?> 

