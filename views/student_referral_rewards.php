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
<section id="referrals" class="section">
  <div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-12">
            <div class="title-main">
              <h2><span><?= $page_title ?></span></h2>
            </div>
        </div> 
        <div class="col-md-10 col-md-push-1">
          <div class="referral-list">
            <!--<p class="btn-print"><a onclick="window.print();">Print Coupon</a></p>-->
          <?php 
		  		if(!empty($referral_rewards)):
		  			foreach($referral_rewards as $referral_reward):
						if($referral_reward->expire >= date('Y-m-d')):
					
		  ?> 
            <div class="referral-detail clearfix">
              <?php if(!empty($referral_reward->photo)){ ?>
			 	 <img src="<?php echo base_url().$referral_reward->photo; ?>">
			  <?php } ?>
              <h2><?php  $this->query_model->getDescReplace( $referral_reward->name); ?></h2>
              <p><?php  $this->query_model->getDescReplace( $referral_reward->desc); ?></p>
              <div class="expire-date">
                <p><b><?php echo $this->query_model->getStaticTextTranslation('expires'); ?>:</b> <?php echo date('m/d/y', strtotime($referral_reward->expire)); ?></p>
              </div>
            </div>  
         <?php endif; endforeach; endif; ?>
		 
		  <?php /*?>
		  <?php 
		  		if(!empty($referral_rewards)):
		  			foreach($referral_rewards as $referral_reward):
						if($referral_reward->expire < date('Y-m-d')):
					
		  ?> 
            <div class="referral-detail clearfix">
              <?php if(!empty($referral_reward->photo)){ ?>
			 	 <img src="<?php echo base_url().$referral_reward->photo; ?>">
			  <?php } ?>
              <h2><?php  $this->query_model->getDescReplace( $referral_reward->name); ?></h2>
              <p><?php  $this->query_model->getDescReplace( $referral_reward->desc); ?></p>
              <div class="expire-date">
                <p><b><?php echo $this->query_model->getStaticTextTranslation('expires'); ?>:</b> <?php echo date('m/d/y', strtotime($referral_reward->expire)); ?></p>
              </div>
            </div>  
         <?php endif; endforeach; endif; ?>    <?php */?>
           
          </div>
        </div>
    </div><!-- row --> 
    </div>
  </div>
</section>
<!-- blog list ends here -->

<?php $this->load->view('includes/footer'); ?> 

