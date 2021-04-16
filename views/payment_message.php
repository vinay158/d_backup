<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>


<?php  $this->load->view('includes/header/masthead'); ?>


<script>
function goBack() {
    window.history.back();
}
</script>
<div class="main container clearfix">
	<nav id="navigation" class="navbar navbar-inverse  main-nav" >
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            
            <div class="user-mobile-control">
			    <div class="logo">
                   <img src="<?php echo $this->config->item('dojo_site').$site_setting[0]->sitelogo; ?>"  alt="<?php echo $this->query_model->getDescReplace($site_setting[0]->logo_alt); ?>">
               </div> 
			
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
			 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			 
			
               
                 <!-- right user menu -->
			 
                <div class="btn-trial">
					<a class="btn btn-theme" onclick="goBack()" > Back </a>
				</div>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
	
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
	<style>
	.payment_result{ text-align:center; color:#000000;}
	</style> 
	<?php if(!empty($message)): ?>
		<h1 class="payment_result"><?php echo $message; ?></h1>
		
		
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