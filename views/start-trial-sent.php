<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>


<?php  $this->load->view('includes/header/masthead'); ?>

<!-- Browser back button redirect to base url -->
<script type="text/javascript">
history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
window.addEventListener('popstate', function(event) {
    window.location.assign("<?php echo base_url(); ?>");
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
	
	<?php $status = isset($_GET['status']) ? $_GET['status'] : "can";?>
	<div class="main_content two_column" id="top" style="padding:20px 0 400px;">
		<h1>Thank you for your submission</h1>
        
        <p>Please check your email for additional info</p>
	    <p><a class="btn btn-readmore read-small" href="">Back to Homepage</a></p>
        
	</div>
	<!-- END .main_content -->
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
