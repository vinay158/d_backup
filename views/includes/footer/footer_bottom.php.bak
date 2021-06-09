<?php 
	$settings = $this->query_model->getbyTable("tblsite");

	if(!empty($settings)):

		foreach($settings as $settings):

			$twitter = $settings->twitter;
			$fb = $settings->fb;
			$logo = $settings->sitelogo;		
			$gplus = $settings->gplus;
			$youtube = $settings->youtube;
			$instagram = $settings->instagram;
			$yelp = $settings->yelp;
			$linkedIn = $settings->linkedIn;
			$vimeo = $settings->vimeo;
			$phone = $settings->phone;
			$address = $settings->address.", ".$settings->city.", ".$settings->state.", ".$settings->zip;
			
			

		endforeach; 

	endif;
	
	
$social_icon_details = $this->query_model->getSocialIcons();
if(!empty($social_icon_details)){
		
			$social_twitter = $social_icon_details[0]->twitter;
			$social_fb = $social_icon_details[0]->fb;
		//	$social_logo = $social_icon_details[0]->sitelogo;		
			$social_gplus = $social_icon_details[0]->gplus;
			$social_youtube = $social_icon_details[0]->youtube;
			$social_instagram = $social_icon_details[0]->instagram;
			$social_yelp = $social_icon_details[0]->yelp;
			$social_linkedIn = $social_icon_details[0]->linkedIn;
			$social_vimeo = $social_icon_details[0]->vimeo;
}





?>
<div class="clearfix"></div>
<div class="footercopyright">
  <div class="container">
    <div class="row">

      <div class="col-md-3 col-xs-12  col-sm-12 col-md-push-9">
	 
        <div class="social-ul">
		
          <ul>
		  	
            <?php if(!empty($social_fb)): ?><li class="social-facebook"><a href="<?=$social_fb?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php endif; ?>
            <?php if(!empty($social_twitter)): ?> <li class="social-twitter"><a href="<?=$social_twitter?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php endif; ?>
            <?php if(!empty($social_gplus)): ?><li class="social-google"><a href="<?=$social_gplus?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php endif; ?>
            <?php if(!empty($social_youtube)): ?> <li class="social-youtube"><a href="<?=$social_youtube?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php endif; ?>
			<?php if(!empty($social_instagram)): ?><li class="social-instagram"><a href="<?=$social_instagram?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php endif; ?>
			<?php if(!empty($social_yelp)): ?><li class="social-yelp"><a href="<?=$social_yelp?>" target="_blank"><i class="fa fa-yelp"></i></a></li><?php endif; ?>
			<?php if(!empty($social_linkedIn)): ?><li class="social-linkedin"><a href="<?=$social_linkedIn?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php endif; ?>
			<?php if(!empty($social_vimeo)): ?><li class="social-vimeo"><a href="<?=$social_vimeo?>" target="_blank"><i class="fa fa-vimeo-square"></i></a></li><?php endif; ?>
           
          </ul>
        </div>
      </div>
      <div class="col-md-9 col-xs-12 col-sm-12 col-md-pull-3">
        <div class="copyright pull-left">
          <p> 	&#169; <?php  echo date('Y'); ?> <?php echo $_SERVER['SERVER_NAME']; ?> <?php echo $this->query_model->getStaticTextTranslation('all_rights_reserved'); ?> 
            <a href="http://websitedojo.com/" style="color:#FFF;" target="_blank">WebsiteDojo.com</a></p>
        </div>
		
		 <?php 
		 $this->db->where_in('id',array(1,2));
		 $static_pages = $this->query_model->getbyTable('tbl_static_pages'); ?>
		
		<?php if(!empty($static_pages)){ ?>
			<ul class="footer-staticpage text-right">
			<?php foreach($static_pages as $static_page){ 
			?>
				<li><a href="<?php base_url(); ?><?php echo  $static_page->slug; ?>"><?php $this->query_model->getDescReplace($static_page->title); ?></a></li>
			<?php } ?>
			</ul>
		<?php } ?>
		
      </div>
	  
	  
	  
    </div>
  </div>
</div><div class="clearfix"></div>