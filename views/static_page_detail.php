<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>


<?php  $this->load->view('includes/header/masthead'); ?>


<div class="trial-form about-trial-form about-alt-bg">
  <div class="container">
    <div class="row">
		
      <div class="col-md-12 text-center">
         <h2><?php 
				if(!empty($pageDetail)){
					$this->query_model->getDescReplace($pageDetail[0]->title);
				}
			?>
		</h2>
      </div>
    </div>
   
  </div>
</div>


<div class="main clearfix">
	
	
	<!-- END .sidebar .vertical -->
	 <div class="container">
    <div class="row">
      <div class="col-md-12	 col-xs-12 col-sm-6">
			<h1></h1>
        
			<p>
			<?php 
				if(!empty($pageDetail)){
					$this->query_model->getDescReplace($pageDetail[0]->description);
				}
			?></p>
      </div>
      
    </div>
  </div>
	
	<!-- END .main_content -->
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
