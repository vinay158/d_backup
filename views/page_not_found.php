<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
	  
	
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<HR>
<section id="">
  <div class="container">
    <div class="row">
      <link href="http://allfont.net/allfont.css?fonts=agency-fb" rel="stylesheet" type="text/css" />
      <div class="col-md-12 col-xs-12 col-sm-6">
			<div class="page_not_found">
				<h2> 404</h2>
				<h3> <?php echo $this->query_model->getStaticTextTranslation('page_not_found'); ?></h3>
				<p> <?php echo $this->query_model->getStaticTextTranslation('we_are_sorry_page_not_found'); ?></p>
			</div>
      </div>
       </div>
  </div>
</section>




<?php $this->load->view('includes/footer'); ?> 

