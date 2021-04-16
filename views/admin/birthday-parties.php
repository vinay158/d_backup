<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar sidebar_wide birthday">

<?php $this->load->view('includes/header/masthead'); ?>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php $this->load->view('includes/sidebar/bday_form'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
	
		<img src="featured-images/header/birthday.jpg" alt="" class="featured_bday" />
		<?php if(!empty($page)): ?>
		<?php foreach($page as $page): ?>
		<span class="page_content"><?=html_entity_decode($page->content)?></span>
		<?php endforeach; endif;?>
		<?php if(!empty($msg)): ?>
		<?php if($msg = 1) : ?>
		<h4 style="text-align:center;margin-top:10px;">Your message was sent!</h4>
		<?php else: ?>
		<h4>Email sending Failed. Please try again. <a href="birthdayparties">go back.</a></h4>
		<?php endif; ?>
		
		<?php endif;?>
		<img src="<?=THEMEPATH;?>themes/global/images/bday_gifts_content.png" alt="" class="gift_img" />
	
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>


