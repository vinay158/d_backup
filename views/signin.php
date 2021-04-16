<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar">

<?php $this->load->view('includes/header/masthead'); ?>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php  $this->load->view('includes/sidebar/feature_boxes'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
		<h1>Title here</h1><br>
		<span class="page_content">Small blurb goes here - Donec placerat. Nullam nibh dolor, blandit sed, fermentum id, imperdiet sit amet, neque. Nam mollis ultrices justo. Sed tempor. Sed vitae tellus. Etiam sem arcu, eleifend sit amet, gravida eget, porta at, wisi. Nam non lacus vitae ipsum viverra pretium.</span><br><br>
	
<form action="starttrial/send" class="trial_form content_trial_form" method="post">
					
			<div class="message">
				<div id="alert"></div>
			</div>
			<!-- END .message -->
			
			<ul class="form_fields">
			
				<li class="clearfix">
					<label class="form_name_2">Username</label>
					<input type="text" name="name" id="form_name_2" />
				</li>
				
				<li class="clearfix">
					<label class="form_email_2">Password</label>
					<input type="text" name="form_email_2" id="form_email_2" />
				</li>
				
				<li class="clearfix paynow">
				<input type="submit" class="submit button" name="submit" value="Submit">
				</li>
							</ul>
			<!-- END .form_fields -->
			
		</form>
		<!-- END #contact_form -->

	</div>
	<!-- END .main_content -->
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
