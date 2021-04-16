<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>


<?php  $this->load->view('includes/header/payment_masthead'); ?>

<?php 
$site_setting_service = $this->query_model->getSiteSetting();
$site_url =  base_url();
$location_detail_service = $this->query_model->getSchoolDetail(); 

?>

<!-- Browser back button redirect to base url -->
<script type="text/javascript">
history.pushState(null, null, '<?php echo $_SERVER["REQUEST_URI"]; ?>');
window.addEventListener('popstate', function(event) {
    window.location.assign("<?php echo base_url(); ?>");
});
</script>
<!-- Browser back button redirect to base url End -->

<script>
function goBack() {
    window.history.back();
}
</script>



<div class="main container clearfix messageboxsize">
	<section id="payment-block">

  <div class="container">

    <div class="row">

    <div class="col-md-6 col-xs-12 col-sm-6">

      <div class="theme-logo">

	    <img src="<?php echo $site_url.$site_setting_service[0]->sitelogo; ?>"  alt="<?php echo $this->query_model->getDescReplace($site_setting_service[0]->logo_alt); ?>">

      </div> 

      <div class="secure">

        <h2>TRY FITNESS & MARTIAL ARTS!<br> SECURE CHECK OUT</h2>

      </div>

      

    </div>

	  <div class="col-md-6 col-xs-12 col-sm-6">

        <div class="address-info">
		<?php if(!empty($location_detail_service)){ ?>
          <h4><?php echo $location_detail_service[0]->address; ?></h4>

          <h4><?php echo $location_detail_service[0]->city.', '.$location_detail_service[0]->state.' '.$location_detail_service[0]->zip; ?></h4>

          <p><a href="#"><?php echo $location_detail_service[0]->email; ?></a></p>
		<?php } ?>
        </div>

        <div class="clearfix"></div>

		

      </div>

    </div>

  </div>

</section>
	<nav id="navigation" class="navbarHeight">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            
            <!--<div class="user-mobile-control">
			    <div class="logo">
                   <img class="logoImg" src="<?php echo $site_url.$site_setting_service[0]->sitelogo; ?>"  alt="<?php echo $this->query_model->getDescReplace($site_setting_service[0]->logo_alt); ?>">
               </div> 
			
            </div>-->
            <!-- Collect the nav links, forms, and other content for toggling -->
			 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			 
			
               
                 <!-- right user menu -->
			 
               
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column messagebox" id="top">
	<style>
	.payment_result{ text-align:center; color:#000000;}
	</style> 
	
	<?php if(!empty($error_message)): ?>
		<h1 class="payment_result"><?php echo $error_message; ?></h1>
		
		  <div class="container">

    <div class="row">

      <div class="col-sm-12 text-center"> <span class="no"></span>

        <div class="row">

         <!--<a class=" btn btn-difalt btn btn-theme backbutton" onclick="goBack()" > <?php echo $this->query_model->getStaticTextTranslation('back_to_homepage'); ?>  </a>-->
		<a href="<?php echo $this->query_model->getBaseUrl(); ?>" class="btn btn-danger backbutton"><?php echo $this->query_model->getStaticTextTranslation('back_to_homepage'); ?></a>

        </div>

      </div>

      <div class="clearfix"></div>

    </div>

  </div>
		
		
		<script language="javascript">
		function numbersonly(evnt)
		{
		var unicode=evnt.charCode? evnt.charCode : evnt.keyCode
		if (unicode<=46||unicode>57 || unicode==47){	
		if(unicode == 8 || unicode == 9)
		return true;
		else
		return false;
		}	
		}
		$(document).ready(function(){
		var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;
		$(".content_contact_form").submit(function(){
		if($("#form_name_2").val().length == 0 || $("#form_email_2").val().length == 0 || emailfilter.test($("#form_email_2").val()) == false || $("#form_school_2").val() == 0 || $("#form_message_2").val().length == 0 ){
		$(".message #alert").html("Please fill in the contact form correctly.");
		$(".message").fadeIn(300);
		event.preventDefault();
		}
		});
		});
		</script>
		
	<?php endif;?>
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>