<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>

<!-- Browser back button redirect to base url -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
$(document).ready(function(){
			
		// disble browser go back button 	
		window.history.pushState(null, "", window.location.href);        
        window.onpopstate = function() {
			//setTimeout("window.location.href='<?php echo base_url().'starttrial/distoryTrialSession'; ?>'",500);
            window.history.pushState(null, "", window.location.href);
        };
		
		
});
</script>
<!-- Browser back button redirect to base url End -->

<section id="main-address">
  <div class="container">
    <div class="row">
      <div class="col-md-12	 col-xs-12 col-sm-6">
        
      </div>
      
    </div>
  </div>
</section>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php $this->load->view('includes/sidebar/feature_boxes'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<?php 
	$status = isset($_GET['status']) ? $_GET['status'] : "can";
	
	$url = $this->uri->segment(2);
	if ($url == 'buyspecial') {

	?>
	<div class="main_content two_column" id="top" style="padding:20px 0 400px;">
		<h1><?php echo $this->query_model->getStaticTextTranslation('thank_for_submission'); ?></h1>
        
        <p><?php echo $this->query_model->getStaticTextTranslation('check_email_for_additional_info'); ?></p>
	    <p><a class="btn btn-readmore read-small" href=""><?php echo $this->query_model->getStaticTextTranslation('back_to_homepage'); ?></a></p>
        
	</div>
	<?php } else{ ?>

		<div class="main_content two_column" id="top" style="padding:20px 0 400px;">
		
		<h1><?php echo $error_message; ?></h1>
        
        <p><?php echo $this->query_model->getStaticTextTranslation('check_email_for_additional_info'); ?></p>
	    <p><a class="btn btn-readmore read-small" href=""><?php echo $this->query_model->getStaticTextTranslation('back_to_homepage'); ?></a></p>
        
	</div>

		<?php } ?>
	<!-- END .main_content -->
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
