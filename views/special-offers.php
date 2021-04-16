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
	
		<?php $this->load->view('includes/sidebar/feature_boxes'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
	
		<div class="button_list"><a onClick="window.print()" class="button float_right">Print Coupons</a></div>
			
	<?php if(!empty($offers)): ?>
	<?php foreach($offers as $offers): ?>
			<!-- share this icons -->
             <?php
				$st_image = '';
				if(!empty($offers->photo) && fopen($offers->photo, 'r')){
					$st_image = "st_image='".base_url().$offers->photo."'";
				}
			?>
			<span class='st_facebook_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$offers->name?>" <?=$st_image?> displayText='Facebook' ></span>
			<span class='st_twitter_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$offers->name?>" <?=$st_image?>  displayText='Tweet'></span>
			<span class='st_email_hcount' st_url="<?php echo $pageURL;?>" st_title="<?=$offers->name?>" <?=$st_image?> displayText='Email'></span>
			<!-- End -->
		<div class="coupon">
		
			<div class="coupon_inner clearfix">
				<?php if(empty($offers->photo)): ?>
				<?php 
				$this->db->select("sitelogo");
				$logo_default = $this->query_model->getbyTable("tblsite");?>
				<?php foreach($logo_default as $def) : ?>
				<img src="<?=$def->sitelogo?>" alt="" width="153" />
				<?php endforeach;?>
				<?php else: ?>
				<img src="<?=$offers->photo?>" alt="" width="153" />
				<?php endif;?>
				<div class="coupon_title"><?=$offers->name?></div>
				<div class="coupon_details"><?=$offers->offers?></div>
				<!--<div class="coupon_secondary_details"><?//=$offers->details?></div>
				--><div class="coupon_blurb"><span class="page_content"><?=html_entity_decode($offers->desc);?></span></div>
				<div class="coupon_date"><strong>Expires:</strong> <?=date_format(date_create($offers->expire), "m/d/y");?></div>
			
			</div>
			<!-- END .coupon_inner -->
			
		</div>
		<!-- END .coupon -->
	<?php endforeach; ?>
	<?php endif; ?>
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
