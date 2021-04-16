<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<link href="css/new/css_elements.css" rel="stylesheet">

<?php $this->load->view('includes/header'); ?>

<?php  $this->load->view('includes/header/masthead'); ?>
<div class="mobile-contact">
  <div class="container">
    <div class="row">
      <div class="col-sm-12 text-center"> <span class="no title-p">Trial Offer</span>
        <div class="row">
          <div class="col-xs-6 row-btn"> <a class="btn btn-theme" href="<?php echo  $this->query_model->getMetaUrls(40); ?>"> Free Trial Class </a> </div>
          <div class="col-xs-6 row-btn"> <a class="btn btn-theme" href="<?php echo  $this->query_model->getFindUs($mainLocation[0]->address,$mainLocation[0]->suite,$mainLocation[0]->city,$mainLocation[0]->state,$mainLocation[0]->zip); ?>"  target="_blank"> <i class="fa fa-map-marker"></i> Find Us </a> </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>


<div class="container">
    <div class="row">
       <div class="col-md-12">
		 <div class="rewards text-center">
            <h2>301 Redirect Error</h2>
            <p>Requsted page is not valid </p>
        </div>
		
		
		
      </div>
      
    </div>
  </div>

<?php $this->load->view('includes/footer'); ?> 

