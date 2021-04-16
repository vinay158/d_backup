<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/header/masthead'); ?>
<style type="text/css">
   #background-video{ background-size:cover !important;  background-position:center top !important; }	
</style>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 
   $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
   
  $multiSchoolOrLocation = $this->query_model->checkMultiSchoolOrLocationIsOn();
 
 /*** getting gdpr text **/
 $gdprCompliantText = $this->query_model->getGdprCompliantText();
 $gdpr_compliant_txt1 = (isset($gdprCompliantText['gdpr_compliant_txt1'])) ? $gdprCompliantText['gdpr_compliant_txt1'] : '';
 $gdpr_compliant_txt2 = (isset($gdprCompliantText['gdpr_compliant_txt2'])) ? $gdprCompliantText['gdpr_compliant_txt2'] : '';
 $gdpr_compliant_submit_btn_text = (isset($gdprCompliantText['gdpr_compliant_submit_btn_text'])) ? $gdprCompliantText['gdpr_compliant_submit_btn_text'] : '';

 ?>
<script src="js/v5/jquery.youtubebackground.js"></script>
<?php 
   $_URL = array();
   
   $query = $this->db->get( 'tblmeta' );
   
   $result = $query->result();
   
   foreach( $result as $row )
   
   {
   
   	if(!empty($row->slug) && !empty($row->page)) {
   
   		$_URL[trim($row->slug)] = trim($row->page);
   
   	}
   
   }
   
   
   
   $_SLUG = array('ourschool', 'ourfacility', 'ourstaff' , 'ourphilosophy', 'schoolrules', 'schoolrules', 'faq', 'events', 'news', 'videogallery','photogallery', 'ourprograms' , 'starttrial' , 'testimonials' , 'signin');
   
   
   foreach($_SLUG as $needle) {
   
   	$slug = array_search($needle, $_URL);
   
   	if($slug == false) { $$needle = $needle; } 
   
   	else { $$needle = $slug; } 
   
   }
   
   $settings = $this->query_model->getbyTable("tblsite");
   
   	if(!empty($settings)):
   
   		foreach($settings as $settings):
   
   			$twitter = $settings->twitter;
   
   			$fb = $settings->fb;
   
   			$logo = $settings->sitelogo;
   			
   			$gplus = $settings->gplus;
   			
   			$youtube = $settings->youtube;
   
   			$phone = $settings->phone;
   
   			$address = $settings->address.", ".$settings->city.", ".$settings->state.", ".$settings->zip;
   			
   			
   
   		endforeach; 
   	endif;
   ?>
<!-- Header Carousel -->
<?php 
   $site_settings = $this->query_model->getbyTable("tblsite");
   $mainLocation = $this->query_model->getMainLocation("tblcontact");
   ?>
<style type="text/css">
   .homePageSection {
   display: flex;
   flex-direction: column;
   width:100%;
   }
   <?php if(!empty($allHomepageSections)){
      foreach($allHomepageSections as $program_section){
      ?>
   .homePageSection > .<?php echo $program_section->section ?> {order: <?php echo $program_section->pos ?>; display: <?php echo ($program_section->published == 1) ? 'block' : 'none'; ?>; } 
   <?php 
      }
      } ?>
</style>
<section class="slide-wrapper">
   <div class="container">
   <div id="myCarousel" class="carousel slide carousel_slider"  data-ride="carousel_slider"> 
   <!-- Wrapper for slides -->
   <div class="carousel-inner container">
      <?php 
         $s = 1;
         foreach($sliders as $slider){
         ?>
      <?php if($slider->slide_template == 'center_condensed' && $slider->image_video == 'image'){ ?>
      <div class="item <?php if($s == 1){ echo 'active'; } ?> sliders slide slider-center-condensed " style="background-image:url('<?php echo $slider->photo; ?>');">
	  <span class="overlay" style="<?php echo !empty($slider->photo_background_color) ? 'background:'.$slider->photo_background_color.' !important' : ''; ?>"></span>
         <div class="carousel-caption-top">
            <div class="col-sm-12 col-md-8 col-xs-12">
               <div class="slide-text">
                 
                  <h2><?php $this->query_model->getDescReplace($slider->slide_text);?></h2>
                  <div class="row">
                     <div class="col-md-3"> </div>
                  </div>
                  <div class="action-btn">
                     <?php if($slider->buttons == '2_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        
                        $linkurl_1 = $this->query_model->getChangeUrl($slider->button1_page_link);
                        
                        } else{
                        $linkurl_1 = $slider->button1_link;
                        }
                        
                        if($slider->link_button2 == 'link_to_page'){
                        $linkurl_2 = $this->query_model->getChangeUrl($slider->button2_page_link);
                        } else{
                        $linkurl_2 = $slider->button2_link;
                        }
                        ?>
                     <a href="<?php echo $linkurl_1; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php //echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <a href="<?php echo $linkurl_2; ?>"  target="<?php echo $slider->button2_link_target; ?>" class="<?php //echo $slider->button2_button_class; ?> right  action-control-right"><?php echo $slider->button2_text; ?> <i class="fa  fa-angle-right"></i></a>
                     <?php } ?>
                     <?php if($slider->buttons == '1_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        		$linkurl_single = $slider->button1_page_link;
                        	} else{
                        		$linkurl_single = $slider->button1_link;
                        	}
                        ?>
                     <a href="<?php echo $linkurl_single; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <?php } ?>
                  </div>
               </div>
            </div>
            <div class=" col-md-4 hidden-sm mobile-hidden">
               <div class="adult-image">
                   <?php if(!empty($slider->video_img)){ ?>
                  <img src="<?php echo base_url().'upload/slider_video/'.$slider->video_img ?>" alt="<?php $this->query_model->getDescReplace($slider->video_img_alt_text); ?>" class="img-responsive">
			   <?php } ?>
               </div>
            </div>
         </div>
         <!-- caption --> 
      </div>
      <?php } ?>
      <?php if($slider->slide_template == 'center_condensed' && $slider->image_video == 'video' && $slider->video_type == 'youtube_video'){ ?>
	  
	   <div class="item <?php if($s == 1){ echo 'active'; } ?> sliders slide slider-center-condensed ">
         <div class="overlay hidden-xs hidden-sm" style="background-image: url('images/bgtexture.png')!important;opacity: 0.3;"></div>

         	<div class="video-wrap-outer" style="background:url('<?php echo  $this->query_model->getSliderImageWithVideo($slider->id); ?>') no-repeat;">
         <div class="carousel-caption-top">

            <div class="col-sm-12 col-md-8 col-xs-12">
               <div class="slide-text">
                  
                  <h2><?php $this->query_model->getDescReplace($slider->slide_text);?></h2>
                  <div class="row">
                     <div class="col-md-3"> </div>
                  </div>
                  <div class="action-btn">
                     <?php if($slider->buttons == '2_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        
                        $linkurl_1 = $this->query_model->getChangeUrl($slider->button1_page_link);
                        
                        } else{
                        $linkurl_1 = $slider->button1_link;
                        }
                        
                        if($slider->link_button2 == 'link_to_page'){
                        $linkurl_2 = $this->query_model->getChangeUrl($slider->button2_page_link);
                        } else{
                        $linkurl_2 = $slider->button2_link;
                        }
                        ?>
                     <a href="<?php echo $linkurl_1; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php //echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <a href="<?php echo $linkurl_2; ?>"  target="<?php echo $slider->button2_link_target; ?>" class="<?php //echo $slider->button2_button_class; ?> right  action-control-right"><?php echo $slider->button2_text; ?> <i class="fa  fa-angle-right"></i></a>
                     <?php } ?>
                     <?php if($slider->buttons == '1_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        		$linkurl_single = $slider->button1_page_link;
                        	} else{
                        		$linkurl_single = $slider->button1_link;
                        	}
                        ?>
                     <a href="<?php echo $linkurl_single; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <?php } ?>
                  </div>
               </div>
            </div>
            <div class=" col-md-4 hidden-sm mobile-hidden">
               <div class="adult-image">
                   <?php if(!empty($slider->video_img)){ ?>
                  <img src="<?php echo base_url().'upload/slider_video/'.$slider->video_img ?>" class="img-responsive" alt="<?php $this->query_model->getDescReplace($slider->video_img_alt_text); ?>" >
			   <?php } ?>
               </div>
            </div>
            </div>
         </div>
		   <script>
               if ($(window).width() < 900) {
               /*do nothing static image is visible s8Sz7iOh0hU*/
               }
               else {   jQuery(function($) {
               //var v_id = '<?php //echo $s; ?>';
                   $('.bg-yt-video').YTPlayer({
                     fitToBackground: true,
                     videoId: '<?php echo $slider->video_id; ?>',
                     pauseOnScroll: true,
                     callback: function() {
                       videoCallbackEvents();
                     }
                   });
                   
                   var videoCallbackEvents = function() {
                     var player = $('#background-video').data('ytPlayer').player;
                   
                     player.addEventListener('onStateChange', function(event){
                         console.log("Player State Change", event);
               
                         // OnStateChange Data
                         if (event.data === 0) {          
                             console.log('video ended');
                         }
                         else if (event.data === 2) {          
                           console.log('paused');
                         }
                     });
                   }
                 });
               
               }
            </script> 
         <section  id="video-bg" class="home-page-video">
            <div class="video" id="vimeo-player">
               <div class="hidden-xs">
                  <div id="background-video" class="bg-yt-video" style="background:url('<?php echo  $this->query_model->getSliderImageWithVideo($slider->id); ?>') no-repeat; background-position:center;">
                  </div>
                  <div class="overlay 1 <?php // if($slider->background_overlay == 'hide'){ echo $slider->background_overlay; } ?>"  style="<?php echo !empty($slider->video_overlay_color) ? 'background:'.$slider->video_overlay_color.' !important' : ''; ?>"></div>
               </div>
              
               <!-- <div class="video-text">
                  
                       <h2><?php $this->query_model->getDescReplace($slider->slide_text);?></h2>
                        <div class="action-btn">
                         <?php if($slider->buttons == '2_button'){ 
                     if($slider->link_button1 == 'link_to_page'){
                     
                     $linkurl_1 = $this->query_model->getChangeUrl($slider->button1_page_link);
                     
                     } else{
                     $linkurl_1 = $slider->button1_link;
                     }
                     
                     if($slider->link_button2 == 'link_to_page'){
                     $linkurl_2 = $this->query_model->getChangeUrl($slider->button2_page_link);
                     } else{
                     $linkurl_2 = $slider->button2_link;
                     }
                     ?>
                  	 <a href="<?php echo $linkurl_1; ?>"  target="<?php echo $slider->button1_link_target; ?>" class=" <?php //echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                  	 <a href="<?php echo $linkurl_2; ?>"  target="<?php echo $slider->button2_link_target; ?>" class="<?php //echo $slider->button2_button_class; ?> right  action-control-right"><?php echo $slider->button2_text; ?> <i class="fa  fa-angle-right"></i></a>
                  	 	<?php } ?>
                  <?php if($slider->buttons == '1_button'){ 
                     if($slider->link_button1 == 'link_to_page'){
                     		$linkurl_single = $slider->button1_page_link;
                     	} else{
                     		$linkurl_single = $slider->button1_link;
                     	}
                     ?>
                  <a href="<?php echo $linkurl_single; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php //echo $slider->button1_button_class; ?> right  action-control-right"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                  <?php } ?>
                  </div>
                  
                  </div> -->
               <!-- ADD Jquery Video Background -->
         </section>
	
      <?php } ?>
      <?php if($slider->slide_template == 'center_condensed' && $slider->image_video == 'video' && $slider->video_type == 'vimeo_video'){ ?>
      <div class="item <?php if($s == 1){ echo 'active'; } ?> sliders slide slider-center-condensed ">
         <div class="overlay hidden-xs hidden-sm" style="background-image: url('images/bgtexture.png')!important;opacity: 0.3;"></div>

         	<div class="video-wrap-outer" style="background:url('<?php echo  $this->query_model->getSliderImageWithVideo($slider->id); ?>') no-repeat;">
         <div class="carousel-caption-top">

            <div class="col-sm-12 col-md-8 col-xs-12">
               <div class="slide-text">
                 
                  <h2><?php $this->query_model->getDescReplace($slider->slide_text);?></h2>
                  <div class="row">
                     <div class="col-md-3"> </div>
                  </div>
                  <div class="action-btn">
                     <?php if($slider->buttons == '2_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        
                        $linkurl_1 = $this->query_model->getChangeUrl($slider->button1_page_link);
                        
                        } else{
                        $linkurl_1 = $slider->button1_link;
                        }
                        
                        if($slider->link_button2 == 'link_to_page'){
                        $linkurl_2 = $this->query_model->getChangeUrl($slider->button2_page_link);
                        } else{
                        $linkurl_2 = $slider->button2_link;
                        }
                        ?>
                     <a href="<?php echo $linkurl_1; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php //echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <a href="<?php echo $linkurl_2; ?>"  target="<?php echo $slider->button2_link_target; ?>" class="<?php //echo $slider->button2_button_class; ?> right  action-control-right"><?php echo $slider->button2_text; ?> <i class="fa  fa-angle-right"></i></a>
                     <?php } ?>
                     <?php if($slider->buttons == '1_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        		$linkurl_single = $slider->button1_page_link;
                        	} else{
                        		$linkurl_single = $slider->button1_link;
                        	}
                        ?>
                     <a href="<?php echo $linkurl_single; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <?php } ?>
                  </div>
               </div>
            </div>
            <div class=" col-md-4 hidden-sm mobile-hidden">
               <div class="adult-image">
                   <?php if(!empty($slider->video_img)){ ?>
                  <img src="<?php echo base_url().'upload/slider_video/'.$slider->video_img ?>" class="img-responsive" alt="<?php $this->query_model->getDescReplace($slider->video_img_alt_text); ?>" >
			   <?php } ?>
               </div>
            </div>
            </div>
         </div>
         <section  id="video-bg" class="home-page-video">
            <div class="video" id="vimeo-player">
               <div class="hidden-xs">
                  <iframe
                     src="//player.vimeo.com/video/<?php echo $slider->video_id; ?>?background=1&autoplay=1&loop=1" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>  
                  <div id="background-video" style="background:url('<?php echo  $this->query_model->getSliderImageWithVideo($slider->id); ?>') no-repeat; background-position:center;">
                  </div>
                  <div class="overlay 1 <?php // if($slider->background_overlay == 'hide'){ echo $slider->background_overlay; } ?>"  style="<?php echo !empty($slider->video_overlay_color) ? 'background:'.$slider->video_overlay_color.' !important' : ''; ?>"></div>
               </div>
              
               <!-- ADD Jquery Video Background -->
         </section>
         </div>
         <?php } ?>
         <!-- Remote Video Section Start -->
        <?php if($slider->slide_template == 'center_condensed' && $slider->image_video == 'video' && $slider->video_type == 'remote_video'){ ?>
      <div class="item <?php if($s == 1){ echo 'active'; } ?> sliders slide slider-center-condensed ">
         <div class="overlay hidden-xs hidden-sm" style="background-image: url('images/bgtexture.png')!important;opacity: 0.3;"></div>

         	<div class="video-wrap-outer" style="background:url('<?php echo  $this->query_model->getSliderImageWithVideo($slider->id); ?>') no-repeat;">
         <div class="carousel-caption-top">

            <div class="col-sm-12 col-md-8 col-xs-12">
               <div class="slide-text">
                 
                  <h2><?php $this->query_model->getDescReplace($slider->slide_text);?></h2>
                  <div class="row">
                     <div class="col-md-3"> </div>
                  </div>
                  <div class="action-btn">
                     <?php if($slider->buttons == '2_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        
                        $linkurl_1 = $this->query_model->getChangeUrl($slider->button1_page_link);
                        
                        } else{
                        $linkurl_1 = $slider->button1_link;
                        }
                        
                        if($slider->link_button2 == 'link_to_page'){
                        $linkurl_2 = $this->query_model->getChangeUrl($slider->button2_page_link);
                        } else{
                        $linkurl_2 = $slider->button2_link;
                        }
                        ?>
                     <a href="<?php echo $linkurl_1; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php //echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <a href="<?php echo $linkurl_2; ?>"  target="<?php echo $slider->button2_link_target; ?>" class="<?php //echo $slider->button2_button_class; ?> right  action-control-right"><?php echo $slider->button2_text; ?> <i class="fa  fa-angle-right"></i></a>
                     <?php } ?>
                     <?php if($slider->buttons == '1_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        		$linkurl_single = $slider->button1_page_link;
                        	} else{
                        		$linkurl_single = $slider->button1_link;
                        	}
                        ?>
                     <a href="<?php echo $linkurl_single; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <?php } ?>
                  </div>
               </div>
            </div>
            <div class=" col-md-4 hidden-sm mobile-hidden">
               <div class="adult-image">
                   <?php if(!empty($slider->video_img)){ ?>
                  <img src="<?php echo base_url().'upload/slider_video/'.$slider->video_img ?>" class="img-responsive"  alt="<?php $this->query_model->getDescReplace($slider->video_img_alt_text); ?>" >
			   <?php } ?>
               </div>
            </div>
            </div>
         </div>
         <section  id="video-bg" class="home-page-video">
            <div class="video" id="vimeo-player">
               <div class="hidden-xs">

                  <video width="500" height="281" autoplay>
				  <source src="<?php echo $slider->remote_video; ?>" type="video/mp4">
					
					
                  </video>
                  <div id="background-video" style="background:url('<?php echo  $this->query_model->getSliderImageWithVideo($slider->id); ?>') no-repeat; background-position:center;">
                  </div>
                  <div class="overlay 1 <?php // if($slider->background_overlay == 'hide'){ echo $slider->background_overlay; } ?>"  style="<?php echo !empty($slider->video_overlay_color) ? 'background:'.$slider->video_overlay_color.' ' : ''; ?>"></div>
               </div>
               
               <!-- ADD Jquery Video Background -->
         </section>
         </div>
         <?php } ?>
			
			
			
			<?php if($slider->slide_template == 'center_condensed' && $slider->image_video == 'video' && $slider->video_type == 'local_video'){ ?>
      <div class="item <?php if($s == 1){ echo 'active'; } ?> sliders slide slider-center-condensed ">
         <div class="overlay hidden-xs hidden-sm" style="background-image: url('images/bgtexture.png')!important;opacity: 0.3;"></div>

         	<div class="video-wrap-outer" style="background:url('<?php echo  $this->query_model->getSliderImageWithVideo($slider->id); ?>') no-repeat;">
         <div class="carousel-caption-top">

            <div class="col-sm-12 col-md-8 col-xs-12">
               <div class="slide-text">
                 
                  <h2><?php $this->query_model->getDescReplace($slider->slide_text);?></h2>
                  <div class="row">
                     <div class="col-md-3"> </div>
                  </div>
                  <div class="action-btn">
                     <?php if($slider->buttons == '2_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        
                        $linkurl_1 = $this->query_model->getChangeUrl($slider->button1_page_link);
                        
                        } else{
                        $linkurl_1 = $slider->button1_link;
                        }
                        
                        if($slider->link_button2 == 'link_to_page'){
                        $linkurl_2 = $this->query_model->getChangeUrl($slider->button2_page_link);
                        } else{
                        $linkurl_2 = $slider->button2_link;
                        }
                        ?>
                     <a href="<?php echo $linkurl_1; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php //echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <a href="<?php echo $linkurl_2; ?>"  target="<?php echo $slider->button2_link_target; ?>" class="<?php //echo $slider->button2_button_class; ?> right  action-control-right"><?php echo $slider->button2_text; ?> <i class="fa  fa-angle-right"></i></a>
                     <?php } ?>
                     <?php if($slider->buttons == '1_button'){ 
                        if($slider->link_button1 == 'link_to_page'){
                        		$linkurl_single = $slider->button1_page_link;
                        	} else{
                        		$linkurl_single = $slider->button1_link;
                        	}
                        ?>
                     <a href="<?php echo $linkurl_single; ?>"  target="<?php echo $slider->button1_link_target; ?>" class="<?php echo $slider->button1_button_class; ?> left  action-control"><?php echo $slider->button1_text; ?> <i class="fa  fa-angle-right"></i></a> 
                     <?php } ?>
                  </div>
               </div>
            </div>
            <div class=" col-md-4 hidden-sm mobile-hidden">
               <div class="adult-image">
                   <?php if(!empty($slider->video_img)){ ?>
                  <img src="<?php echo base_url().'upload/slider_video/'.$slider->video_img ?>" class="img-responsive" alt="<?php $this->query_model->getDescReplace($slider->video_img_alt_text); ?>" >
			   <?php } ?>
               </div>
            </div>
            </div>
         </div>
         <section  id="video-bg" class="home-page-video">
            <div class="video" id="vimeo-player">
               <div class="hidden-xs">

                  <video width="500" height="281" autoplay>
				  <source src="<?php echo base_url().'upload/local_videos/'.$slider->local_video_mp4; ?>" type="video/mp4">
					
					<!-- WebM for Firefox 4 and Opera -->					
					 <source src="<?php echo base_url().'upload/local_videos/'.$slider->local_video_webm; ?>" type="video/webm">
					
					<!-- OGG for Firefox 3 -->
					<!--<source type="video/ogg" src="images/video/video.ogv" /> -->
					
                  </video>
                  <div id="background-video" style="background:url('<?php echo  $this->query_model->getSliderImageWithVideo($slider->id); ?>') no-repeat; background-position:center;">
                  </div>
                  <div class="overlay 1 <?php // if($slider->background_overlay == 'hide'){ echo $slider->background_overlay; } ?>"  style="<?php echo !empty($slider->video_overlay_color) ? 'background:'.$slider->video_overlay_color.' ' : ''; ?>"></div>
               </div>
               
               <!-- ADD Jquery Video Background -->
         </section>
         </div>
         <?php } ?>
            <?php $s++;  } ?>
         </div>
         <!-- Controls -->
         <?php if(count($sliders) > 1){ ?>
         <a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span ><i class="fa fa-chevron-left"></i></span> </a> <a class="right carousel-control" href="#myCarousel" data-slide="next"> <span ><i class="fa fa-chevron-right"></i></span> </a> 
         <?php } ?>
      </div>
   </div>
</section>
<section class="trial-form <?php echo ($site_settings[0]->tilt_bg_class == 1) ? 'tilt-bg' : ''; ?>">
   <div class="container">
      <div class="row">
         <div class="col-md-12 text-center">
            <h2><?php $this->query_model->getDescReplace($homePageEmailOption[0]->title);  ?></h2>
            <p><?php $this->query_model->getDescReplace($homePageEmailOption[0]->text);  ?></p>
         </div>
      </div>
   </div>
</section>

<?php 
   $emailOnlyForm1 = 1;
   if(!empty($homePageEmailOption) && $homePageEmailOption[0]->show_full_form == 1){
   	$emailOnlyForm1 = 0;
   }
    ?>
<?php if($emailOnlyForm1 == 1){ ?>
<div class="about-trial-form about-alt-bg <?php if($this->query_model->showProgramsListOnFroms() == 1){
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
			?>lavel-2<?php } }  ?>  <?php if($this->query_model->get_gdpr_compliant() == 1){?> get_gdpr_compliant <?php } ?>
			<?php if($multiSchoolOrLocation == 1){ ?>
		
			<?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
			lavel-2
			 <?php } ?>
		<?php } ?>
		<?php if($multiSchoolOrLocation == 1 && $multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ echo 'buttonright'; } ?>
			">
    <div class="container">
      <div class="row">
   <span></span>
   <script>
      $(document).ready(function(){
      	
      	
      $('.contactFormSubmit_6').click(function(){
      
      			var err = 0
      			
      			
      			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
      			var email=$('#form_email_6').val();
      			if(email.length == 0 || emailfilter.test($("#form_email_6").val()) == false){
      				var err = 1;
      				$('#form_email_6').after('<div class="reds email_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
      			}
      			
				<?php if($multiSchoolOrLocation == 1 ){ ?>
					var school=$('#school_6').val();
					if(school == '' || school == null){
						var err = 1;
						$('#school_6').after('<div class="reds school_name_error6"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
					}
					<?php } ?>
				
				<?php /*if($this->query_model->get_gdpr_compliant() == 1){ ?>
					var gdpr_compliant_id= 'gdpr_compliant_6';
					var gdpr_compliant_error= 'gdpr_compliant_error6';
					if($('#'+gdpr_compliant_id).is(":checked")){
						$('.'+gdpr_compliant_error).hide();
					}else{
						var err = 1;
						$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
					}
				<?php }*/ ?>
      			
      			
      			if(err == 0){
      				$("#form_6").attr('action','<?=base_url()?>starttrial/saveLeadsByEmails');
      				return true;
      			} else{
      				$("#form_6").attr('action','#');
      				return false;
      			}
      	
      	});
      	
      	
      	$('#form_email_6').keyup(function(){
      			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
      			var email=$('#form_email_6').val();
      			if($(this).val().length > 0 || emailfilter.test($("#form_email_6").val()) == false){
      				$('.email_error6').hide();
      			} else{
      				$('#form_email_6').after('<div class="reds email_error6"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
      				
      			}
      	});
		
		<?php if($multiSchoolOrLocation == 1 ){ ?>
            	$('#school_6').change(function(){
            			if($(this).val() != ''){
            				$('.school_name_error6').hide();
            			} else{
            				$('.school_name_error6').show();
            				$('#school_6').after('<div class="reds school_name_error6"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
            				
            			}
            	});
        <?php } ?>
		
		
		<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
		var gdpr_compliant_id= 'gdpr_compliant_6';
		var gdpr_compliant_error= 'gdpr_compliant_error6';
		$('#'+gdpr_compliant_id).click(function(){
				if($(this).is(':checked')){
					$('.'+gdpr_compliant_error).hide();
				}else{
					$('.'+gdpr_compliant_error).show();
				}
			})
        <?php }*/ ?>   	
      	
      	
      });
      
   </script>
   <form action="#"  method="post" class="get_started_form mini_form small_mini_form" id="form_6">
		<?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
      <div class="search-box 
			
			<?php if($multiSchoolOrLocation == 1 && $multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ echo 'multi-search-box'; } ?>">
		
		
		 
		<?php if($multiSchoolOrLocation == 1){ ?>
		
			<?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
                <select class="form-control form_location_dropdown" name="school_interest" id="school_6" number="1">
                     <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
                     <?php foreach($form_allLocations as $location): ?>
                     <option  value="<?=$location->id;?>" <?php if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?>><?=$location->name;?> </option>
                     <?php endforeach;?>   
                  </select>
               <?php } ?>
		<?php } ?>
		 <?php if($this->query_model->showProgramsListOnFroms() == 1){
					$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
			?>
				<select class="form-control form_program_dropdown program_dropdown_1" name="program_id" id="">
                     <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
                     <?php foreach($programsArr as $program): ?>
                     <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
                     <?php endforeach;?>   
                  </select>
		 
		 <?php } }  ?>
		 
		 <input type="text"  name="last_name" class="optinlastname"   placeholder="Last Name" value="">
		 <input type="text" class="form-control" id="form_email_6" name="form_email_2" placeholder="<?php echo $this->query_model->getStaticTextTranslation('enter_your_email_address'); ?>">
		<input type="text" id="fax" name="fax" class="optinfax"  placeholder="Fax Number" value="">
          
		
		 
		 <?php if(!empty($twilioApi)){?>
		   <div class=" twilio_checkbox email_optin_twilio_checkbox" >
			  <input type="checkbox" class="form-control" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
		   </div>
		   <?php } ?>
		   
		   <?php if($this->query_model->get_gdpr_compliant() == 1){?>
			<div class="email_optin_gdpr_compliant_checkbox" >
				<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				
			  <input type="checkbox" class="form-control" id="gdpr_compliant_6" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt2; ?><br/><span><?php echo $gdpr_compliant_txt1; ?></span>
            
		   </div>
		 <?php } ?>
		 <input type="text" id="comment" name="comment" class="optincomment"  placeholder="Write your comment here..." value="">
		 <input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
		   
         <input type="hidden" name="page_url" value="/" />
         <input type="hidden" name="send_location" value="0" />
         <input type="hidden" name="miniform" value="true" />
		  <input type="text" id="website" name="website" class="optinwebsite" placeholder="Website" value="">
		<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>" placeholder="Serial Number"/>
         <button class="btn-red contactFormSubmit_6" name="submitEmail" value="submitEmail" type="submit" ><?php echo $gdpr_compliant_submit_btn_text; ?></button>
      </div>
   </form>
</div></div>
</div>
<?php } else { ?>
<div class="trial-form about-trial-form about-alt-bg normalform">
   <div class="container">
      <div class="row">
         <?php
		 /*$tblspecialoffer = $this->query_model->getTrialSpecialOffersTableName();
            $special_offer_data = $this->query_model->getbyTable("$tblspecialoffer");								
            $speical_offer_setting = $special_offer_data[0];*/
            ?>
         <script>
            $(document).ready(function(){
            		
            $('.contactFormSubmit').click(function(){
            
            			var err = 0
            			var name=$('#first_name').val();
            			//alert(name); return false;
            			if(name.length == 0){
            				var err = 1;
            				$('#first_name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
            			}else{
							if(! /\s/g.test(name)){
								var err = 1;
								$('#first_name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
							}
						}
            			
            			/*var last_name=$('#last_name').val();
            			if(last_name.length == 0){
            				var err = 1;
            				$('#last_name').after('<div class="reds last_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
            			}*/
            			
            			/*var telephone=$('#telephone').val();
            			<?php if($site_settings[0]->phone_required == 1){ ?>
                                                          <?php if($site_settings[0]->international_phone_fields != 1){ ?>
            			if(telephone.length <= 9 || telephone.length == 0){
            				var err = 1;
            				$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
            				
            			} 
                                                  <?php } } ?> */
            								
            			var telephoneId = 'telephone';
            			var phoneError = 'phone_error';
            			var telephone=$('#'+telephoneId).val();
            			<?php 
               if($site_settings[0]->international_phone_fields != 1){
               	if($site_settings[0]->phone_required == 1){ ?>
            				if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> || telephone.length == 0){
            					var err = 1;
            					$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
            					
            				} 
            				<?php //}
               }else{ ?>
            				
            					if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
            							$('#'+telephoneId).after('<div class="reds '+phoneError+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
            							var err = 1;
            						}else{
            							//var err = 0;
            							$('.'+phoneError).hide();
            						}
            			<?php 	} 
               }else{
               	if($site_settings[0]->phone_required == 1){
               ?>
            			
            			
            				var filter = /^[- +()]*[0-9][- +()0-9]*$/;
            				if (filter.test(telephone)) {
            					$('.'+phoneError).hide();
            				}
            				else {
            					$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
            					var err = 1;
            				}	
            			<?php }else{ ?>
            					if(telephone.length == 0){
            						$('.'+phoneError).hide();
            					}else{
            						var filter = /^[- +()]*[0-9][- +()0-9]*$/;
            						if (filter.test(telephone)) {
            							$('.'+phoneError).hide();
            						}
            						else {
            							$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
            							var err = 1;
            						}	
            					}	
            			<?php		}	?> 
            			
            			<?php }?>
            				
            				
            			
            			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
            			var email=$('#form_email').val();
            			if(email.length == 0 || emailfilter.test($("#form_email").val()) == false){
            				var err = 1;
            				$('#form_email').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
            			}
            			
            			
            			<?php if($multiLocation[0]->field_value == 1 ){ ?>
            			var school=$('#school').val();
            			if(school == '' || school == null){
            				var err = 1;
            				$('#school').after('<div class="reds school_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
            			}
            			<?php } ?>
            			
						<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
							var gdpr_compliant_id= 'gdpr_compliant';
							var gdpr_compliant_error= 'gdpr_compliant_error';
							if($('#'+gdpr_compliant_id).is(":checked")){
								$('.'+gdpr_compliant_error).hide();
							}else{
								var err = 1;
								$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
							}
						<?php }*/ ?>
            			
            			
            			//alert(err); return false;
            			if(err == 0){
            				return true;
            			} else{
            				return false;
            			}
            	
            	});
            	
            	
            	$('#first_name').keyup(function(){
            			if($(this).val().length > 0){
            				$('.name_error').hide();
            			} else{
            				$('#first_name').after('<div class="reds name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
            				
            			}
            	});
            	
            	$('#last_name').keyup(function(){
            			if($(this).val().length > 0){
            				$('.last_name_error').hide();
            			} else{
            				$('#last_name').after('<div class="reds last_name_error"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
            				
            			}
            	});
            	
            	$('#telephone').keyup(function(){
            			/*if($(this).val().length <= 11){
            				
            				<?php if($site_settings[0]->phone_required == 0){ ?>
            					if($(this).val().length == 0){
            						$('.phone_error').hide();
            					}else{
                                                                       <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                          $('.phone_error').hide();
                                                                      <?php  }else{ ?>
            						$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                                      <?php  } ?>
            					}
            				<?php }else{ ?>
                                                                       <?php if($site_settings[0]->international_phone_fields == 1){ ?>
                                                                          $('.phone_error').hide();
                                                                      <?php  }else{ ?>
            						$('#telephone').after('<div class="reds phone_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                                      <?php  } ?>
            				<?php } ?>
            				
            			} 
            			
            			if($(this).val().length == 12){
            				$('.phone_error').hide();
            				
            			} */
            			
            			$('.phone_error').hide();
            	});
            	
            	
            	$('#form_email').keyup(function(){
            			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
            			var email=$('#form_email').val();
            			if($(this).val().length > 0 || emailfilter.test($("#form_email").val()) == false){
            				$('.email_error').hide();
            			} else{
            				$('#form_email').after('<div class="reds email_error"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
            				
            			}
            	});
            	
            	<?php if($multiLocation[0]->field_value == 1 ){ ?>
            	$('#school').change(function(){
            			if($(this).val() != ''){
            				$('.school_name_error').hide();
            			} else{
            				$('.school_name_error').show();
            				$('#school').after('<div class="reds school_name_error"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
            				
            			}
            	});
            	<?php } ?>
				
				<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
					var gdpr_compliant_id= 'gdpr_compliant';
					var gdpr_compliant_error= 'gdpr_compliant_error';
					$('#'+gdpr_compliant_id).click(function(){
							if($(this).is(':checked')){
								$('.'+gdpr_compliant_error).hide();
							}else{
								$('.'+gdpr_compliant_error).show();
							}
						})
				<?php } */ ?>   	
						


            	
            	
            });
            
         </script>
         <!-- <div class="col-md-12 text-center">
            <h2><?php  $this->query_model->getStrReplace($site_settings[0]->mini_form_offer_title);?></h2>
             <p> <?php  $this->query_model->getDescReplace($site_settings[0]->mini_form_offer_desc);?></p>
            </div> -->
      </div>
      <div class="row">
         <div class="col-xs-12">
            <form action="<?=base_url().$trial_offer_slug->slug?>"  method="post" class="get_started_form mini_form" >
				<?php echo $this->query_model->getCaptchaInputFields('opt_in_form'); ?>
               <div class="inline_mid_form " >
                  <input type="text" id="first_name" name="name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onfocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
                  <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
               </div>
			   
               <div class="inline_mid_form optinlastname" >
                  <input type="text" name="last_name" id="last_name" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>"  onfocus="this.placeholder = ''" onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>"  >
                  <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
               </div>
               <div class="inline_mid_form " >
                  <input type="email" name="form_email_2" id="form_email" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onfocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'"  >
                  <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
               </div>
               <div class="inline_mid_form " >
                  <input type="text" name="phone" id="telephone" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onfocus="this.placeholder = ''" error_class="phone_error" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>"   >
                  <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
               </div>
			  <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">
			    
			 
               <?php if($multiLocation[0]->field_value == 1  && count($form_allLocations) >= 1){ ?>
               <div class="inline_mid_form " >
                  <select class="locationBox contact-form-line form_location_dropdown" name="school_interest" id="school" number="2">
                     <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
                     <?php foreach($form_allLocations as $location): ?>
                     <option  value="<?=$location->id;?>" <?php if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?>><?=$location->name;?> </option>
                     <?php endforeach;?>   
                  </select>
                  <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
               </div>
               <?php } ?>
			   
			   <?php if($this->query_model->showProgramsListOnFroms() == 1){
					
						$programsArr =  $this->query_model->programsListOnFromDropdowns(); 
							if(!empty($programsArr)){
					?>
					<div class="inline_mid_form " >
					<select class="contact-form-line form_program_dropdown program_dropdown_2" name="program_id" id="">
						 <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_program'); ?></option>
						 <?php foreach($programsArr as $program): ?>
						 <option  value="<?=$program->id;?>" ><?=$program->program;?> </option>
						 <?php endforeach;?>   
					  </select>
					</div>
				<?php } } ?>
			   
			   <?php if(!empty($twilioApi)){?>
			   <div class="inline_mid_form twilio_checkbox" >
                  <input type="checkbox" class="" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
               </div>
			   <?php } ?>
			   
			    <?php if($this->query_model->get_gdpr_compliant() == 1){?>
					<div class="inline_mid_form gdpr_compliant_checkbox" >
						<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
						
					  <input type="checkbox" class="form-control" name="gdpr_compliant_checkbox" id="gdpr_compliant" value="1"><?php echo $gdpr_compliant_txt2; ?><br/><span><?php echo $gdpr_compliant_txt1; ?></span>
                  
				   </div>
				 <?php } ?>
				 
				<input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
				<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">

			   
               <div class="<?php if($multiLocation[0]->field_value == 0){ echo 'inline_mid_form singleLocationFormButton'; }?> started-btn" >
                  <input type="hidden" name="miniform" value="true" />
                 <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
				<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
                  <input type="hidden" name="page_url" value="/" />
                  <input class="mini_formSubmit contactFormSubmit  submit <?php if($multiLocation[0]->field_value == 0){ echo 'getStartedMargin'; } else { echo 'getStartedMarginAuto'; } ?>" type="submit" class="" value="<?php echo $this->query_model->getStaticTextTranslation('submit'); ?>" />
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php } ?>
<div class="clearfix"></div>
<div class="homePageSection">
   <?php if(!empty($featuredprograms)): ?>
   <section class="ads feature-program clearfix tilt-bg featured_programs" id="feature-new">
      <div class="container">
         <div class="row">
            <div class="grid">
               <?php 
                  $i = 1;
                  foreach($featuredprograms as $featuredprogram){
                  	if($i <= 3){
                  		$base_url = base_url();
                  		$featured_pro_url = '';
						if($featuredprogram->custom_url_checkbox == 1){
							$featured_pro_url = $featuredprogram->custom_url;
						}else{
							if($featuredprogram->p_type == 'program'){	
								if($featuredprogram->program_id == 0)
									{
										$featured_pro_url = $featuredprogram->program_category_url;
									} else{
										$featured_pro_url = $featuredprogram->program_url;
									}
							} else{
								$featured_pro_url = $featuredprogram->url;
							}
						}
                  		
                  ?>
               <div class="col-md-4 col-sm-4">
                  <figure class="effect-sadie">
                     <img class="img-responsive" src="<?=base_url()?><?= str_replace(array('_thumb.jpg','thumb/'),array('.jpg',''),$featuredprogram->photo_thumb)?>" alt="<?php $this->query_model->getStrReplace($featuredprogram->image_alt); ?>">
                     <figcaption>
                        <h2><?php $this->query_model->getStrReplace($featuredprogram->program_title); ?></h2>
                        <h3><?php $this->query_model->getStrReplace($featuredprogram->program_description); ?></h3>
                        <?php if(!empty($featuredprogram->summary)){ ?>
                        <p class="f-text  mobile-hidden">
                           <?php 
                              $summary=str_ireplace('<p>','',$featuredprogram->summary);
                              $summary=str_ireplace('</p>','',$summary); 
                              $this->query_model->getDescReplace($summary);
                              ?>
                        </p>
                        <?php } ?>
                        <div class="btn-set-mobile ">
                           <a href="<?php echo $featured_pro_url; ?>" class="btn-theme"><?php echo $this->query_model->getStaticTextTranslation('learn_more'); ?></a>
                        </div>
                     </figcaption>
                  </figure>
               </div>
               <?php } $i++;  } ?>     
            </div>
         </div>
      </div>
   </section>
   <div class="clearfix"></div>
   <?php endif; ?>
   <!-- map area -->
   
   <?php if($multiSchool == 0){ ?>
   <div class="our_locations" id="our-locations">
      <?php if($multiLocation[0]->field_value == 1){ ?>
      <?php if(!empty($allLocations) && count($allLocations) > 1): ?> 
      <section class="location">
         <div class="container">
            <div class="row">
               <div class="text-center">
                  <h2><?php echo $this->query_model->getStaticTextTranslation('our_locations'); ?>:</h2>
               </div>
            </div>
         </div>
      </section>
      <section class="map-list mobile-map-list">
         <div class="container">
            <div class="row ">
               <!---- Map 2 --->
               <?php if(count($allLocations) == 2){ ?>
               <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <?php $address1 =  $this->query_model->getFullAddress($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>   		
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[0]->slug; ?>" class="contactMapTitle"><?= $allLocations[0]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address1; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"> <a href="tel:<?= $allLocations[0]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[0]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[0]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div1" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <?php $address2 =  $this->query_model->getFullAddress($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>   		   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[1]->slug; ?>" class="contactMapTitle"><?= $allLocations[1]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address2; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[1]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[1]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[1]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div2" class="map_manage  hidden-xs"></div>
               </div>
               <?php } ?> 
               <!---- Map 3 --->
               <?php if(count($allLocations) == 3){ //$allLocations[0]->name?>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address1  = $this->query_model->getFullAddress($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>   		
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[0]->slug; ?>" class="contactMapTitle"><?= $allLocations[0]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address1; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"> <a href="tel:<?= $allLocations[0]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[0]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[0]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div3" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address2 =  $this->query_model->getFullAddress($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>   		   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[1]->slug; ?>" class="contactMapTitle"><?= $allLocations[1]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address2; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[1]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[1]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[1]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div4" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address3 = $this->query_model->getFullAddress($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[2]->slug; ?>" class="contactMapTitle"><?= $allLocations[2]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address3; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[2]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[2]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[2]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div6" class="map_manage  hidden-xs"></div>
               </div>
               <?php } ?>
            </div>
            <!-- end row -->
            <!---- Map 4 ---> 
            <?php if(count($allLocations) == 4){ //$allLocations[0]->name?>
            <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address1  = $this->query_model->getFullAddress($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>   		
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[0]->slug; ?>" class="contactMapTitle"><?= $allLocations[0]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address1; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"> <a href="tel:<?= $allLocations[0]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[0]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[0]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div7" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address2 =  $this->query_model->getFullAddress($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>   		   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[1]->slug; ?>" class="contactMapTitle"><?= $allLocations[1]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address2; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[1]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[1]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[1]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div8" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address3 = $this->query_model->getFullAddress($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[2]->slug; ?>" class="contactMapTitle"><?= $allLocations[2]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address3; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[2]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[2]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[2]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div9" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address4 = $this->query_model->getFullAddress($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[3]->slug; ?>" class="contactMapTitle"><?= $allLocations[3]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address4; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[3]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[3]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[3]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div10" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <!-- row -->
            <?php } ?>
            <!-- row -->
            <!-- Map 5 -->
            <?php if(count($allLocations) == 5){ //$allLocations[0]->name?>
            <div class="row">
               <div class="col-md-13">
                  <?php $address1  = $this->query_model->getFullAddress($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>   		
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[0]->slug; ?>" class="contactMapTitle"><?= $allLocations[0]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address1; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"> <a href="tel:<?= $allLocations[0]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[0]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[0]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div5a" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address2 =  $this->query_model->getFullAddress($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>   		   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[1]->slug; ?>" class="contactMapTitle"><?= $allLocations[1]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address2; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[1]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[1]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[1]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div5b" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address3 = $this->query_model->getFullAddress($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[2]->slug; ?>" class="contactMapTitle"><?= $allLocations[2]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address3; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[2]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[2]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[2]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div5c" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address4 = $this->query_model->getFullAddress($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[3]->slug; ?>" class="contactMapTitle"><?= $allLocations[3]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address4; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[3]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[3]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[3]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div5d" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address5 = $this->query_model->getFullAddress($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[4]->slug; ?>" class="contactMapTitle"><?= $allLocations[4]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address5; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[4]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[4]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[4]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div5e" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <?php } ?>
            <!---- Map 6 ---> 
            <?php if(count($allLocations) == 6){ //$allLocations[0]->name?>
            <div class="row ">
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address1  = $this->query_model->getFullAddress($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>   		
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[0]->slug; ?>" class="contactMapTitle"><?= $allLocations[0]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address1; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"> <a href="tel:<?= $allLocations[0]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[0]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[0]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div15" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address2 =  $this->query_model->getFullAddress($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>   		   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[1]->slug; ?>" class="contactMapTitle"><?= $allLocations[1]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address2; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[1]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[1]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[1]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div16" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address3 = $this->query_model->getFullAddress($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[2]->slug; ?>" class="contactMapTitle"><?= $allLocations[2]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address3; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[2]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[2]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[2]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div17" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <div class="row ">
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address4 = $this->query_model->getFullAddress($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[3]->slug; ?>" class="contactMapTitle"><?= $allLocations[3]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address4; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[3]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[3]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[3]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div18" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address5 = $this->query_model->getFullAddress($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[4]->slug; ?>" class="contactMapTitle"><?= $allLocations[4]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address5; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[4]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[4]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[4]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div19" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address6 = $this->query_model->getFullAddress($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[5]->slug; ?>" class="contactMapTitle"><?= $allLocations[5]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address6; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[5]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[5]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[5]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div20" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <?php } ?>
            <!-- end row -->
            <?php if(count($allLocations) == 7){ //$allLocations[0]->name?>
            <div class="row">
               <!---- Map 7 --->
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address1  = $this->query_model->getFullAddress($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>   		
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[0]->slug; ?>" class="contactMapTitle"><?= $allLocations[0]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address1; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"> <a href="tel:<?= $allLocations[0]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[0]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[0]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div21" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address2 =  $this->query_model->getFullAddress($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>   		   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[1]->slug; ?>" class="contactMapTitle"><?= $allLocations[1]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address2; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[1]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[1]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[1]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div22" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address3 = $this->query_model->getFullAddress($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[2]->slug; ?>" class="contactMapTitle"><?= $allLocations[2]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address3; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[2]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[2]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[2]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div23" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address4 = $this->query_model->getFullAddress($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[3]->slug; ?>" class="contactMapTitle"><?= $allLocations[3]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address4; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[3]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[3]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[3]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div24" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <div class="row ">
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address5 = $this->query_model->getFullAddress($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[4]->slug; ?>" class="contactMapTitle"><?= $allLocations[4]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address5; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[4]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[4]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[4]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div25" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address6 = $this->query_model->getFullAddress($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[5]->slug; ?>" class="contactMapTitle"><?= $allLocations[5]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address6; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[5]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[5]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[5]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div26" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                  <?php $address7 = $this->query_model->getFullAddress($allLocations[6]->address,$allLocations[6]->suite,$allLocations[6]->city,$allLocations[6]->state,$allLocations[6]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[6]->slug; ?>" class="contactMapTitle"><?= $allLocations[6]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address7; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[6]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[6]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[6]->address,$allLocations[6]->suite,$allLocations[6]->city,$allLocations[6]->state,$allLocations[6]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[6]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div27" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <?php } ?>
            <?php if(count($allLocations) == 8){ //$allLocations[0]->name?>
            <div class="row">
               <!---- Map 8 ---> 
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address1  = $this->query_model->getFullAddress($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>   		
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[0]->slug; ?>" class="contactMapTitle"><?= $allLocations[0]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address1; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"> <a href="tel:<?= $allLocations[0]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[0]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[0]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div28" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address2 =  $this->query_model->getFullAddress($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>   		   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[1]->slug; ?>" class="contactMapTitle"><?= $allLocations[1]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address2; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[1]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[1]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[1]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div29" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address3 = $this->query_model->getFullAddress($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[2]->slug; ?>" class="contactMapTitle"><?= $allLocations[2]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address3; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[2]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[2]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[2]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div30" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address4 = $this->query_model->getFullAddress($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[3]->slug; ?>" class="contactMapTitle"><?= $allLocations[3]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address4; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[3]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[3]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[3]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div31" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address5 = $this->query_model->getFullAddress($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[4]->slug; ?>" class="contactMapTitle"><?= $allLocations[4]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address5; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[4]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[4]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[4]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div32" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address6 = $this->query_model->getFullAddress($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[5]->slug; ?>" class="contactMapTitle"><?= $allLocations[5]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address6; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[5]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[5]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[5]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div33" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address7 = $this->query_model->getFullAddress($allLocations[6]->address,$allLocations[6]->suite,$allLocations[6]->city,$allLocations[6]->state,$allLocations[6]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[6]->slug; ?>" class="contactMapTitle"><?= $allLocations[6]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address7; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[6]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[6]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[6]->address,$allLocations[6]->suite,$allLocations[6]->city,$allLocations[6]->state,$allLocations[6]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[6]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div34" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address8 = $this->query_model->getFullAddress($allLocations[7]->address,$allLocations[7]->suite,$allLocations[7]->city,$allLocations[7]->state,$allLocations[7]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[7]->slug; ?>" class="contactMapTitle"><?= $allLocations[7]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address8; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[7]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[7]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[7]->address,$allLocations[7]->suite,$allLocations[7]->city,$allLocations[7]->state,$allLocations[7]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[7]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div35" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <!-- row -->
            <?php } ?>
            <!-- Map 5 -->
            <?php if(count($allLocations) == 9){ //$allLocations[0]->name?>
            <div class="row">
               <div class="col-md-13">
                  <?php $address1  = $this->query_model->getFullAddress($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>   		
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[0]->slug; ?>" class="contactMapTitle"><?= $allLocations[0]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address1; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"> <a href="tel:<?= $allLocations[0]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[0]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[0]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div40" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address2 =  $this->query_model->getFullAddress($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>   		   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[1]->slug; ?>" class="contactMapTitle"><?= $allLocations[1]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address2; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[1]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[1]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[1]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div41" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address3 = $this->query_model->getFullAddress($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[2]->slug; ?>" class="contactMapTitle"><?= $allLocations[2]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address3; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[2]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[2]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[2]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div42" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address4 = $this->query_model->getFullAddress($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[3]->slug; ?>" class="contactMapTitle"><?= $allLocations[3]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address4; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[3]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[3]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[3]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div43" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address5 = $this->query_model->getFullAddress($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[4]->slug; ?>" class="contactMapTitle"><?= $allLocations[4]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address5; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[4]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[4]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[4]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div44" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address6 = $this->query_model->getFullAddress($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[5]->slug; ?>" class="contactMapTitle"><?= $allLocations[5]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address6; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[5]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[5]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[5]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div45" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address7 = $this->query_model->getFullAddress($allLocations[6]->address,$allLocations[6]->suite,$allLocations[6]->city,$allLocations[6]->state,$allLocations[6]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[6]->slug; ?>" class="contactMapTitle"><?= $allLocations[6]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address7; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[6]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[6]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[6]->address,$allLocations[6]->suite,$allLocations[6]->city,$allLocations[6]->state,$allLocations[6]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[6]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div46" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address8 = $this->query_model->getFullAddress($allLocations[7]->address,$allLocations[7]->suite,$allLocations[7]->city,$allLocations[7]->state,$allLocations[7]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[7]->slug; ?>" class="contactMapTitle"><?= $allLocations[7]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address8; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[7]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[7]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[7]->address,$allLocations[7]->suite,$allLocations[7]->city,$allLocations[7]->state,$allLocations[7]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[7]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div47" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                  <?php $address9 = $this->query_model->getFullAddress($allLocations[8]->address,$allLocations[8]->suite,$allLocations[8]->city,$allLocations[8]->state,$allLocations[8]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[8]->slug; ?>" class="contactMapTitle"><?= $allLocations[8]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address9; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[8]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[8]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[8]->address,$allLocations[8]->suite,$allLocations[8]->city,$allLocations[8]->state,$allLocations[8]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[8]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div48" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <?php } ?>
            <?php if(count($allLocations) == 10){ //$allLocations[0]->name?>
            <div class="row">
               <div class="col-md-13">
                  <?php $address1  = $this->query_model->getFullAddress($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>   		
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[0]->slug; ?>" class="contactMapTitle"><?= $allLocations[0]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address1; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"> <a href="tel:<?= $allLocations[0]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[0]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[0]->address,$allLocations[0]->suite,$allLocations[0]->city,$allLocations[0]->state,$allLocations[0]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[0]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div51" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address2 =  $this->query_model->getFullAddress($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>   		   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[1]->slug; ?>" class="contactMapTitle"><?= $allLocations[1]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address2; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[1]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[1]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[1]->address,$allLocations[1]->suite,$allLocations[1]->city,$allLocations[1]->state,$allLocations[1]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[1]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div52" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address3 = $this->query_model->getFullAddress($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[2]->slug; ?>" class="contactMapTitle"><?= $allLocations[2]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address3; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[2]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[2]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[2]->address,$allLocations[2]->suite,$allLocations[2]->city,$allLocations[2]->state,$allLocations[2]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[2]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div53" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address4 = $this->query_model->getFullAddress($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[3]->slug; ?>" class="contactMapTitle"><?= $allLocations[3]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address4; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[3]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[3]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[3]->address,$allLocations[3]->suite,$allLocations[3]->city,$allLocations[3]->state,$allLocations[3]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[3]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div54" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address5 = $this->query_model->getFullAddress($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[4]->slug; ?>" class="contactMapTitle"><?= $allLocations[4]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address5; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[4]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[4]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[4]->address,$allLocations[4]->suite,$allLocations[4]->city,$allLocations[4]->state,$allLocations[4]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[4]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div55" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-13">
                  <?php $address6 = $this->query_model->getFullAddress($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[5]->slug; ?>" class="contactMapTitle"><?= $allLocations[5]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address6; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[5]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[5]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[5]->address,$allLocations[5]->suite,$allLocations[5]->city,$allLocations[5]->state,$allLocations[5]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[5]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div56" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address7 = $this->query_model->getFullAddress($allLocations[6]->address,$allLocations[6]->suite,$allLocations[6]->city,$allLocations[6]->state,$allLocations[6]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[6]->slug; ?>" class="contactMapTitle"><?= $allLocations[6]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address7; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[6]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[6]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[6]->address,$allLocations[6]->suite,$allLocations[6]->city,$allLocations[6]->state,$allLocations[6]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[6]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div57" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address8 = $this->query_model->getFullAddress($allLocations[7]->address,$allLocations[7]->suite,$allLocations[7]->city,$allLocations[7]->state,$allLocations[7]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[7]->slug; ?>" class="contactMapTitle"><?= $allLocations[7]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address8; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[7]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[7]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[7]->address,$allLocations[7]->suite,$allLocations[7]->city,$allLocations[7]->state,$allLocations[7]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[7]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div58" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address9 = $this->query_model->getFullAddress($allLocations[8]->address,$allLocations[8]->suite,$allLocations[8]->city,$allLocations[8]->state,$allLocations[8]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[8]->slug; ?>" class="contactMapTitle"><?= $allLocations[8]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address9; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[8]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[8]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[8]->address,$allLocations[8]->suite,$allLocations[8]->city,$allLocations[8]->state,$allLocations[8]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[8]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div59" class="map_manage  hidden-xs"></div>
               </div>
               <div class="col-md-13">
                  <?php $address10 = $this->query_model->getFullAddress($allLocations[9]->address,$allLocations[9]->suite,$allLocations[9]->city,$allLocations[9]->state,$allLocations[9]->zip); ?>   	   
                  <h2><a href="<?= $contact_slug->slug.'/'.$allLocations[9]->slug; ?>" class="contactMapTitle"><?= $allLocations[9]->name; ?></a></h2>
                  <p class="normal_text"><?php echo  $address10; ?></p>
                  <div class="map-btn">
                     <button class="btn btn-theme"><a href="tel:<?= $allLocations[9]->phone ?>" class="callNow"><i class="fa fa-phone"> </i><?= $allLocations[9]->phone ?></a></button>
                     <a class="" href="<?php echo  $this->query_model->getFindUs($allLocations[9]->address,$allLocations[9]->suite,$allLocations[9]->city,$allLocations[9]->state,$allLocations[9]->zip); ?>"  target="_blank"> <button class="btn btn-theme"> <i class="fa fa-map-marker"></i> <?php echo $this->query_model->getStaticTextTranslation('find_us'); ?></button></a> 
                     <a href="<?php echo  $this->query_model->getMetaUrls(38).'/'.$allLocations[9]->slug; ?>"><button class="btn btn-theme"><?php echo $this->query_model->getStaticTextTranslation('contact_us'); ?></button> </a>
                  </div>
                  <div id="map_div60" class="map_manage  hidden-xs"></div>
               </div>
            </div>
            <?php } ?>
         </div>
      </section>
      <?php endif; ?>
      <?php } ?>
   </div>
   <?php } ?>
   
   <?php if(!empty($about_us)): ?>
   <div class="welcome_text">
      <section id="school-owner-home" class=""  style="background-image:url('<?php echo 'upload/welcome_text/'.$about_us['background_image']; ?>')  !important;">
         <span class="overlay"  style="<?php echo !empty($about_us['background_color']) ? 'background:'.$about_us['background_color'] : ''; ?>"></span>
         <div class="container">
            <div class="row">
               <div class="col-md-5 col-sm-6">
                  <div class="relative">
                     <?php 
                        if($about_us['image_video'] == 'image'){
                        if($about_us['photo'] != '' ){ ?>
                     <img src="upload/welcome_text/<?= $about_us['photo'] ?>" class="img-responsive" alt="<?= $this->query_model->getStrReplace($about_us['image_alt']); ?>" style="top:<?php echo !empty($about_us['img_top_spacing']) ? $about_us['img_top_spacing'] : 0; ?>px;">
                     <?php } } else { ?>
                     <?php if($about_us['video_type'] == 'youtube_video'){ ?>
                     <iframe width="100%" height="250px" src="<?php echo $this->query_model->changeVideoPathHttp($about_us['youtube_video']); ?>?modestbranding=1&autohide=1&showinfo=0&controls=0"></iframe>
                     <?php } else { ?>
                     <iframe src="<?php echo $this->query_model->changeVideoPathHttp($about_us['vimeo_video']); ?>?title=0&byline=0&portrait=0" width="100%" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                     <?php } ?>
                     <?php } ?>
                  </div>
               </div>
               <div class="col-md-7  col-sm-6 owner-info">
                  <h3><?= $this->query_model->getStrReplace($about_us['headline']); ?></h3>
                  <p><?php  $this->query_model->getDescReplace($about_us['content']);?></p>
                  <?php if($about_us['read_more_button'] == 1){ 
                     $locationSlug = $this->query_model->getContactMainLocationSlug();
                     ?>
                  <a class="btn-theme" href="<?php echo $about_page_url[0]->slug.'/'.$locationSlug ?>" ><?php echo $this->query_model->getStaticTextTranslation('learn_more'); ?></a>
                  <?php } ?>
               </div>
            </div>
         </div>
      </section>
      <section class="section tilt-bg white-bg spacer"></section>
   </div>
   <?php endif; ?>
   <section id="get-started" class="homepage tilt-bg getting_started">
      <div class="container">
         <div class="row">
            <h2><?= $this->query_model->getDescReplace($homePageGettingStarted->headline); ?></h2>
            <div class="col-sm-4">
               <?php if(!empty($homePageGettingStarted->image_1)){ ?>
			   <a href="<?=base_url().$trial_offer_slug->slug?>">
               <img src="<?php echo base_url(); ?>upload/welcome_text/<?= $homePageGettingStarted->image_1; ?>" class="" alt="<?= $this->query_model->getDescReplace($homePageGettingStarted->image_1_alt_text); ?>"> 
			   </a>
               <?php } ?>
               <h3><?= $this->query_model->getDescReplace($homePageGettingStarted->title_1); ?></h3>
               <p><?= $this->query_model->getDescReplace($homePageGettingStarted->desc_1); ?></p>
            </div>
            <div class="col-sm-4">
               <?php if(!empty($homePageGettingStarted->image_2)){ ?>
			    <a href="<?=base_url().$trial_offer_slug->slug?>">
               
               <img src="<?php echo base_url(); ?>upload/welcome_text/<?= $homePageGettingStarted->image_2; ?>" class=""  alt="<?= $this->query_model->getDescReplace($homePageGettingStarted->image_2_alt_text); ?>"> 
			   </a>
               <?php } ?>
               <h3><?= $this->query_model->getDescReplace($homePageGettingStarted->title_2); ?></h3>
               <p><?= $this->query_model->getDescReplace($homePageGettingStarted->desc_2); ?></p>
            </div>
            <div class="col-sm-4">
               <?php if(!empty($homePageGettingStarted->image_3)){ ?>
			    <a href="<?=base_url().$trial_offer_slug->slug?>">
               
               <img src="<?php echo base_url(); ?>upload/welcome_text/<?= $homePageGettingStarted->image_3; ?>" class=""  alt="<?= $this->query_model->getDescReplace($homePageGettingStarted->image_3_alt_text); ?>"> 
			   </a>
               <?php } ?>
               <h3><?= $this->query_model->getDescReplace($homePageGettingStarted->title_3); ?></h3>
               <p><?= $this->query_model->getDescReplace($homePageGettingStarted->desc_3); ?></p>
            </div>
         </div>
      </div>
   </section>
   <!-- feature section -->
   <?php
      $videoDisplay = 0;
      if(!empty($large_video)){
      	if($large_video[0]->video_type == "youtube_video"){
      		$videoDisplay = !empty($large_video[0]->youtube_video) ? 1 : 0;
      	}elseif($large_video[0]->video_type == "vimeo_video"){
      		$videoDisplay = !empty($large_video[0]->vimeo_video) ? 1 : 0;
      	}else{
      		$videoDisplay = 0;
      	}
      }
      ?>
   <?php if( $videoDisplay == 1){ ?>
   <div class="large_video">
      <section class="section " id="discover"   style="background-image:url('<?php // echo 'upload/largevideo/'.$large_video[0]->background_image; ?>') !important;">
         <span class="overlay" style="<?php echo !empty($large_video[0]->background_color) ? 'background:'.$large_video[0]->background_color : ''; ?>"></span>
         <div class="container">
            <div class="row">
               <div class="col-sm-4 col-md-4">
                  <div class="video-text">
                     <?= $this->query_model->getStrReplace($large_video[0]->headline); ?>
                     <?php if($large_video[0]->show_button == 1){ ?>
					 
					 <?php 
						$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");
						$multiLocationData = isset($multiLocationData[0]) ? $multiLocationData[0]->field_value : 0;
						
						$button_link = (!empty($large_video) && !empty($large_video[0]->button_link)) ? $large_video[0]->button_link : '';
						if($multiLocationData == 0){
							$main_location_data = $this->query_model->getMainLocation("tblcontact");
							$about_us_slug_data = $this->query_model->getbySpecific('tblmeta', 'id', 21);
							$about_us_slug_data = $about_us_slug_data[0]->slug;
							$button_link = base_url().$about_us_slug_data.'/'.strtolower(str_replace(' ','-',$main_location_data[0]->city));
						}
					?>
					
                     <a href="<?php echo $button_link ?>" target="<?php echo $large_video[0]->button_link_target ?>" class="btn-theme"><?= $this->query_model->getStrReplace($large_video[0]->button_text); ?></a>
                     <?php } ?>
                  </div>
               </div>
               <div class="col-md-8 col-sm-8">
                  <div class="video-inner">
                     <?php
                        if(!empty($large_video[0]->video_type) && $large_video[0]->video_type == 'youtube_video'){ ?>
                     <?php if(!empty($large_video[0]->youtube_video)){  ?>
                     <iframe  height="390" src="<?php echo $this->query_model->changeVideoImgPathHttp(trim($large_video[0]->youtube_video)); ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0" frameborder="0" allowfullscreen ></iframe>
                     <?php }  } else{?>
                     <?php if(!empty($large_video[0]->vimeo_video)){ ?>
                     <iframe src="<?php echo $this->query_model->changeVideoImgPathHttp(trim($large_video[0]->vimeo_video)); ?>?title=0&byline=0&portrait=0" width="100%" height="390" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
                     <?php } } ?>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <span class=" tilt-bg gray-overlay" style="<?php echo !empty($large_video[0]->background_color) ? 'background:'.$large_video[0]->background_color.' !important' : ''; ?>"></span>
   </div>
   <?php } ?>   
   <section id="ads-container" class="advertisements">
      <div class="grid">
         <?php  include_once('includes/sidebar/feature_boxes.php'); ?>
      </div>
   </section>
   <?php if(!empty($myTestimonials)){ ?>
   <section class="testimonial testimonial_section" id="testi-block"  style="background-image:url('<?php echo !empty($site_settings[0]->testimonial_background)?$site_settings[0]->testimonial_background:'';?>')">
      <span class="overlay"></span>
      <div class="container">
         <div class="container content">
            <div id="carousel-example-generic" class="carousel slide carousel_testi" data-ride="carousel_testi">
               <!-- Indicators --> 
               <ol class="carousel-indicators testimonial-indicator">
                  <?php 
                     $m = 0;
                     $totalTestimonials = count($myTestimonials);
                     if($totalTestimonials > 1):
                     foreach($myTestimonials as $testimonial):
                     
                     ?>
                  <li data-target="#carousel-example-generic" data-slide-to="<?= $m ?>" class="<?php if($m == 0){ echo 'active'; } ?>"></li>
                  <?php     $m++;
                     endforeach;
                     endif;
                     ?>  
               </ol>
               <!-- Wrapper for slides --> 
               <div class="carousel-inner">
                  <?php if(!empty($myTestimonials)): ?>
                  <?php 
                     $n = 1;
                     foreach($myTestimonials as $testimonial):
                     ?>
                  <div class="item  <?php if($n == 1){ echo 'active'; } ?>">
                     <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                           <div class="caption">
                              <div class="slide-text">
                                 <div class="quote"> 
                                    <?php if(!empty($testimonial->photo)){ ?>
                                    <img src="<?php echo $testimonial->photo; ?>">
                                    <?php }else{?>
                                    <i class="fa fa-quote-right fa-3x"></i>
                                    <?php } ?>
                                 </div>
                                 <div class="testimonial-desc">
                                    <div class="desc">
                                       <?php //$content = preg_replace('#\<p>[{\w},\s\d"]+\</p>#', "", $testimonial->content); ?> 
                                       <?= 
                                          $this->query_model->getStrReplace(strip_tags(html_entity_decode($testimonial->content))); 
                                          ?> 
                                    </div>
                                    <p class="f-name"><?= $this->query_model->getStrReplace($testimonial->name); ?></p>
                                    <p class="accent-txt d-txt"><?= $this->query_model->getStrReplace($testimonial->title); ?></p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php 
                     $n++; 
                     endforeach; ?>
                  <?php endif; ?>
               </div>
               <!-- Controls -->  
            </div>
         </div>
      </div>
   </section>
</div>
<?php } ?>

<?php if($multiSchool == 1){ ?>
<section id="find-location">
         <div class="container">
            <div class="row text-center">
               <div class="col-md-3">
                  <h2><?php echo $this->query_model->getStaticTextTranslation('find_location'); ?></h2>
				</div>
	
    <?php $formPageUrl = !empty($_SERVER['REDIRECT_QUERY_STRING']) ? ltrim($_SERVER['REDIRECT_QUERY_STRING'], '/') : ''; ?>
    <form method="get" class="inline-box" action="<?php echo base_url().$formPageUrl; ?>#map_div5">
	
	<div class="col-md-3">
               
    <div class="inline_mid_form ">
        <select id="dropdown-states" name="state" class="contact-form-line">
            <option><?php echo $this->query_model->getStaticTextTranslation('choose_state'); ?></option>
            <?php

            if(!empty($uniqueStatesList)){
            	$state = '';
            	 if(isset($_GET['state']) && !empty($_GET['state'])){
					    $state = $_GET['state'];

					  }
            	foreach ($uniqueStatesList as $states) {
            		?>
            		<option value="<?php echo $states->state ;?>"  <?php if($state == $states->state ){ echo 'selected=selected'; } ?>  ><?php echo $states->state ;?></option>
        <?php
            	}
            }
        ?>
          
        </select> 
    </div>
	</div>
	
    <div class="col-md-6">
               
      <div class=" inline-box ">

       <div id="ajax-dropdown-city"></div>
    </div>
	</div>
    </form> 
    
               </div>
            </div>
         </div>
      </section>
<?php } ?>

 <!--<div class="find-location trial-form">
 <div class="container">
    <div class="inline_mid_form w-inherit">
    <h2><?php echo $this->query_model->getStaticTextTranslation('find_location'); ?></h2>
    </div>

    <div class="inline_mid_form w-inherit">
    </div><div class="clearfix"></div>
 </div>
 </div>  -->
 
<section class="map-main">
   <div id="location-map">
      <div id="map_div5"></div>
   </div>
   <!-- form -->
   <!--  <section class="mobile-contact">
      <div class="container">
        <div class="row">
           <div class="col-sm-12 text-center"> 
      
      <a href="tel:<?= $mainLocation[0]->phone ?>" class="callNow"><span class="no"><?= $mainLocation[0]->phone ?></span></a>
          <p class="normal_text">
      <?php echo  $this->query_model->getFullAddress($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>
      </p>
      
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
        </div>
      </div>
      </section> -->
   <div class="outer-form">
      <script>
         $(document).ready(function(){
         		
         $('.contactFormSubmit1').click(function(){
         
         			var err = 0
         			var name=$('#first_name1').val();
         			//alert(name); return false;
         			if(name.length == 0){
         				var err = 1;
         				$('#first_name1').after('<div class="reds name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
         			}else{
						if(! /\s/g.test(name)){
							var err = 1;
							$('#first_name1').after('<div class="reds name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
						}
					}
         			
         			/*var last_name=$('#last_name1').val();
         			if(last_name.length == 0){
         				var err = 1;
         				$('#last_name1').after('<div class="reds last_name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
         			}*/
         			
         			/*var telephone=$('#telephone1').val();
         			<?php if($settings->phone_required == 1 ){ ?>
                                                       <?php if($settings->international_phone_fields != 1){ ?>
         				if(telephone.length <= 11 || telephone.length == 0){
         					var err = 1;
         					$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
         					
         				} 
                           <?php } } ?> */
         			var telephoneId = 'telephone1';
         			var phoneError = 'phone_error1';
         			var telephone=$('#'+telephoneId).val();
         			<?php 
            if($settings->international_phone_fields != 1){
            	if($settings->phone_required == 1){ ?>
         				if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> || telephone.length == 0){
         					var err = 1;
         					$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
         					
         				} 
         				<?php //}
            }else{ ?>
         				
         					if(telephone.length <= <?php echo $phoneNumberMaxLength - 1; ?> && telephone.length > 0){
         							$('#'+telephoneId).after('<div class="reds '+phoneError+' "><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
         							var err = 1;
         						}else{
         							//var err = 0;
         							$('.'+phoneError).hide();
         						}
         			<?php 	} 
            }else{
            	if($settings->phone_required == 1){
            ?>
         			
         			
         				var filter = /^[- +()]*[0-9][- +()0-9]*$/;
         				if (filter.test(telephone)) {
         					$('.'+phoneError).hide();
         				}
         				else {
         					$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
         					var err = 1;
         				}	
         			<?php }else{ ?>
         					if(telephone.length == 0){
         						$('.'+phoneError).hide();
         					}else{
         						var filter = /^[- +()]*[0-9][- +()0-9]*$/;
         						if (filter.test(telephone)) {
         							$('.'+phoneError).hide();
         						}
         						else {
         							$('#'+telephoneId).after('<div class="reds '+phoneError+'"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
         							var err = 1;
         						}	
         					}	
         			<?php		}	?> 
         			
         			<?php }?>
         				
         				
         			
         			var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
         			var email=$('#form_email1').val();
         			if(email.length == 0 || emailfilter.test($("#form_email1").val()) == false){
         				var err = 1;
         				$('#form_email1').after('<div class="reds email_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
         			}
         			//school1
         			
         			<?php if($multiLocation[0]->field_value == 1 ){ ?>
         			var school=$('#school1').val();
         			if(school == '' || school == null){
         				var err = 1;
         				$('#school1').after('<div class="reds school_name_error1"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
         			}
         			<?php } ?>
         			
         			var message=$('#message1').val();
         			//alert(name); return false;
         			if(message.length == 0){
         				var err = 1;
         				$('#message1').after('<div class="message_error message_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_message'); ?></div>');
         			}
					
					<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
						var gdpr_compliant_id= 'gdpr_compliant_1';
						var gdpr_compliant_error= 'gdpr_compliant_error1';
						if($('#'+gdpr_compliant_id).is(":checked")){
							$('.'+gdpr_compliant_error).hide();
						}else{
							var err = 1;
							$('#'+gdpr_compliant_id).after('<div class="reds '+gdpr_compliant_error+'"><?php echo $this->query_model->getStaticTextTranslation('receiving_information'); ?></div>');
						}
					<?php }*/ ?>
         			
         			
         			//alert(err); return false;
         			if(err == 0){
         				return true;
         			} else{
         				return false;
         			}
         	
         	});
         	
         	
         	$('#first_name1').keyup(function(){
         			if($(this).val().length > 0){
         				$('.name_error1').hide();
         			} else{
         				$('#first_name1').after('<div class="reds name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
         				
         			}
         	});
         	
         	$('#last_name1').keyup(function(){
         			if($(this).val().length > 0){
         				$('.last_name_error1').hide();
         			} else{
         				$('#last_name1').after('<div class="reds last_name_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?></div>');
         				
         			}
         	});
         	
         	
         
         	$('#telephone1').keyup(function(){
         			/*if($(this).val().length <= 11){
         				
         				<?php if($settings->phone_required == 0){ ?>
         					if($(this).val().length == 0){
         						$('.phone_error1').hide();
         					}else{
                                                                    <?php if($settings->international_phone_fields == 1){ ?>
                                                                       $('.phone_error1').hide();
                                                                   <?php  }else{ ?>
         						$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
                                                                   <?php  } ?>
         					}
         				<?php }else{ ?>
                                                                    <?php if($settings->international_phone_fields == 1){ ?>
                                                                       $('.phone_error1').hide();
                                                                   <?php  }else{ ?>
         						$('#telephone1').after('<div class="reds phone_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_phone_number'); ?></div>');
         				 <?php  } ?>
                                                       <?php } ?>
         				
         			}
         			
         			if($(this).val().length == 12){
         				$('.phone_error1').hide();
         				
         			} */
         			
         			$('.phone_error1').hide();
         	});
         	
         	
         	$('#form_email1').keyup(function(){
         			if($(this).val().length > 0){
         				$('.email_error1').hide();
         			} else{
         				$('#form_email1').after('<div class="reds email_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_valid_email_address'); ?></div>');
         				
         			}
         	});
         	
         	<?php if($multiLocation[0]->field_value == 1 ){ ?>
         	$('#school1').change(function(){
         			if($(this).val() != ''){
         				$('.school_name_error1').hide();
         			} else{
         				$('.school_name_error1').show();
         				$('#school1').after('<div class="reds school_name_error1"><?php echo $this->query_model->getStaticTextTranslation('select_your_location'); ?></div>');
         				
         			}
         	});
         	<?php } ?>
         	
         	$('#message1').keyup(function(){
         			if($(this).val().length > 0){
         				$('.message_error1').hide();
         			} else{
         				$('#message1').after('<div class="message_error message_error1"><?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?></div>');
         				
         			}
         	});
			
			<?php /*if($this->query_model->get_gdpr_compliant() == 1){?>
				var gdpr_compliant_id= 'gdpr_compliant_1';
				var gdpr_compliant_error= 'gdpr_compliant_error1';
				$('#'+gdpr_compliant_id).click(function(){
						if($(this).is(':checked')){
							$('.'+gdpr_compliant_error).hide();
						}else{
							$('.'+gdpr_compliant_error).show();
						}
					})
			<?php }*/ ?>  
         	
         	
         });
         
      </script>
      <form class="d-bg-c contact-form content_contact_form" action="contactus/send" method="post" >
		<?php echo $this->query_model->getCaptchaInputFields('contact_us_form'); ?>
         <input type="hidden" name="hid_location" value="<?= !empty($contactDetail) ? $contactDetail->id : '' ?>" />
         <div class="message">
            <div id="alert"></div>
         </div>
         <div style="position:relative;">
            <input type="text" name="name" id="first_name1"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('first_name'); ?>" onFocus="this.placeholder = ''"   onBlur="textAlphabatic(this)" maxlength="<?php echo $this->query_model->fullNameInputMaxLength(); ?>" error_class="name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_first_name'); ?>" >
            <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
         <div style="position:relative;" class="optinlastname">
            <input type="text" name="last_name" id="last_name1" class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('last_name'); ?>" onFocus="this.placeholder = ''"  onBlur="textAlphabatic(this)" maxlength="25" error_class="last_name_error1" error_msg="<?php echo $this->query_model->getStaticTextTranslation('enter_your_last_name'); ?>" >
            <span class="fa fa-user form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
         <div style="position:relative;">
            <input type="text" name="phone"id="telephone1" class="contact-form-line <?php echo $getPhoneNumberClass; ?>" placeholder="<?php echo $this->query_model->getStaticTextTranslation('phone'); ?>" onFocus="this.placeholder = ''"  error_class="phone_error1" onBlur="phoneValidation(this)" maxlength="<?php echo $phoneNumberMaxLength; ?>" >
            <span class="fa fa-phone form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
		 <input type="text" id="fax" name="fax" class="optinfax"   placeholder="Fax Number" value="">
         <div style="position:relative;">
            <input type="email"  name="form_email_2" id="form_email1"  class="contact-form-line" placeholder="<?php echo $this->query_model->getStaticTextTranslation('email'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('email'); ?>'">
            <span class="fa fa-envelope form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
         <div style="position:relative;">
            <?php if($multiLocation[0]->field_value == 1 ){ ?>
            <select class="locationBox contact-form-line getContactPageUrl" id="school1" name="school">
               <option value=""><?php echo $this->query_model->getStaticTextTranslation('choose_a_location'); ?></option>
               <?php foreach($form_allLocations as $location): ?>
               <option  value="<?=$location->name;?>" <?php //if($mainLocation[0]->id == $location->id){ echo 'selected=selected'; }?> slug="<?=$location->slug;?>"><?=$location->name;?> </option>
               <?php endforeach;?>   
            </select>
            <?php } ?>
            <span class="fa fa-map-marker form-control-feedback move_input_icon site_theme_text" aria-hidden="true"></span> 
         </div>
         <div style="position:relative;"> <span class="site_theme_text fa fa-comment form-control-feedback move_input_icon" aria-hidden="true"></span>
            <textarea  name="message" id="message1" class="contact-form-area" placeholder="<?php echo $this->query_model->getStaticTextTranslation('message'); ?>" onFocus="this.placeholder = ''" onBlur="this.placeholder = '<?php echo $this->query_model->getStaticTextTranslation('message'); ?>'"></textarea>
         </div>
		<input type="text" id="comment" name="comment" class="optincomment"   placeholder="Write your comment here..." value="">
<input type="checkbox" class="optincheck" name="contact_me_by_phone" value="1">
				
		 <?php if(!empty($twilioApi)){?>
		<div style="position:relative;"> 
		   <div class=" twilio_checkbox" >
			  <input type="checkbox" class="contact-form-line" name="twilio_checkbox" value="1"> <?php echo $twilioApi->checkbox_text ?>
		   </div>
		 </div>
		 <?php } ?>
		 
		  <?php if($this->query_model->get_gdpr_compliant() == 1){?>
		   <div style="position:relative;">
			<div class="email_optin_gdpr_compliant_checkbox" >
				<input type="hidden" name="ip_address" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="checkbox" class="form-control" id="gdpr_compliant_1" name="gdpr_compliant_checkbox" value="1"><?php echo $gdpr_compliant_txt1; ?>
		   </div>
		   </div>
		 <?php } ?>
		   
		   
         <input type="hidden" value="" name='email' id='email' class="submit button" style="display:none" />			
          <input type="text" id="website" name="website" class="optinwebsite"  placeholder="Website" value="">
<input type="text"  class="ywedobjeo" name="x2o3d_<?php echo $this->query_model->setAndGetUniqueNumberForCustomField(); ?>" value="<?php echo time(); ?>"  placeholder="Serial Number"/>
         <?php
            $contact_page_slug = $this->query_model->getConatctPageSlug();
            ?>
         <input type="hidden" class="conatct_page_url" name="page_url" value="<?php echo !empty($contact_page_slug) ? $contact_page_slug : '/'; ?>" />
         <input type="submit" value="<?php echo $this->query_model->getStaticTextTranslation('send_message'); ?>" class="btn btn-readmore  btn-block submit button contactFormSubmit1">
      </form>
      <div class="clearfix"></div>
   </div>
</section>

<?php 
	$city = '';
	 if(isset($_GET['city']) && !empty($_GET['city'])){
			$city = $_GET['city'];

	}
?>
<script>
$(window).load(function(){

		// get cities, on click dropdown states
			var stateName = $( "#dropdown-states option:selected" ).val();
			//alert(stateName);
			if(stateName != 'Choose State'){
					$.ajax({

						url : '<?php echo base_url("site/getCityData"); ?>',
						type : 'POST',
						data :{stateName:stateName, cityName:'<?php echo $city; ?>'},
						success:function(data){
	                    $('#ajax-dropdown-city').html(data);
	                	}

				});
			}
			
				

	});
$(document).ready(function(){
	// get cities, on click dropdown states
			$('#dropdown-states').change(function(){
				var stateName = $(this).val();
				//$('.map_div5').removeAttr('id');
				//$('.map_div5').attr('id', 'map_div5_new'); 
				//alert(newid);
				$.ajax({

						url : '<?php echo base_url("site/getCityData"); ?>',
						type : 'POST',
						data :{stateName:stateName},
						success:function(data){
	                    $('#ajax-dropdown-city').html(data);
	                	}

				});

			});
})
</script>
<?php $this->load->view('includes/footer'); ?>

<?php $forms = array('opt_in_form','contact_us_form');
echo $this->query_model->getGoogleCaptchaScript($forms); ?>