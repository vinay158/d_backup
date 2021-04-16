<?php $this->load->view('includes/header'); ?>

<?php
		$pageURL = 'http://';
		if (isset($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN))
			$pageURL .= 'https://';
			
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }		 
	?>
<body class="inside_page two_column left_sidebar">

<?php $this->load->view('includes/header/masthead'); ?>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
		<li class="sidebar_nav">	
			<?php $this->load->view('includes/sidebar/recent_news'); ?>		
		</li>
		<!-- END .sidebar_nav -->
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top" style="min-height: 300px;">
		<?php 
		if(!empty($current) ): ?>
		
			<h1><?=$current->title?></h1>
			<div class="posted_on" style="margin-bottom: 20px; "><span><?php echo $this->query_model->getStaticTextTranslation('posted'); ?>:</span> <?=date_format(date_create($current->timestamp), "F dS, Y");?></div>
			<!-- share this icons -->
            <?php
				$st_image = '';
				if(!empty($current->image) && fopen($current->image, 'r')){
					$st_image = "st_image='".base_url().$current->image."'";
				}
			?>
		<span class='st_facebook_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$current->title?>" <?=$st_image?> displayText='Facebook' ></span>
		<span class='st_googleplus_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$current->title?>" <?=$st_image?> displayText='Google +' ></span>
		<span class='st_twitter_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$current->title?>" <?=$st_image?>  displayText='Tweet'></span>
		<span class='st_tumblr_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$current->title?>" <?=$st_image?> displayText='Tumblr' ></span>
		<span class='st_stumbleupon_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$current->title?>" <?=$st_image?> displayText='StumbleUpon' ></span>
		<!--<span class='st_linkedin_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$current->title?>" <?=$st_image?> displayText='LinkedIn' ></span>-->
		<span class='st_email_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$current->title?>" <?=$st_image?> displayText='Email'></span>
			<!-- End -->
			<div style="margin-top: 20px; ">
				<?php if(!empty($current->image)): ?>
					<img src="<?=$current->image?>" alt="<?=$current->image_alt?>" style="max-width: 600px; min-width: 140px; float:left; margin-right: 20px; vertical-align:text-top;" />
				<?php endif; ?>
				<span class="page_content"><?=html_entity_decode($current->content);?></span>
			</div>
	<?php else: ?>
		<h1></h1>
			<div class="posted_on"><span><?php echo $this->query_model->getStaticTextTranslation('no_news'); ?></span> </div>
	<?php endif;?>
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
