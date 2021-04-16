<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar sidebar_wide">

<?php  $this->load->view('includes/header/masthead'); ?>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php $this->load->view('includes/sidebar/sidebar_contact'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
	<?php if(!empty($msg)): ?>
		<?php if($msg = 1) : ?>
		<h1 style="text-align:center;">Thank You!</h1>
		<p style="text-align:center;margin-top:10px;">Your message was sent!</p>
		<?php else: ?>
		<p>Email sending Failed. Please try again. <a href="birthdayparties">go back.</a></p>
		<?php endif; ?>
	<?php else: ?>
		<?php if(!empty($content)): ?>
		<?php foreach($content as $content) :?>	
		<h1><?=$content->title?></h1>
		<span class="page_content"><?	$_msg= html_entity_decode($content->content);
			$_msg=str_replace('(Your School Name)',$site_title, $_msg);		
			echo $_msg;?>	
		</span>	
		<?php endforeach;?>
		<?php endif;?>
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