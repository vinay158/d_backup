
<?php $this->load->view('includes/header'); ?>

<body class="inside_page full_width">

<?php $this->load->view('includes/header/masthead'); ?>
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
<div class="main container clearfix">
	
	<div class="main_content" id="top">
		<div class="fb-recommend-container">
			<div class="fb-like" data-href="<?php echo $pageURL?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-action="recommend">
			</div>
		</div>
		<h1 class="center">Photo - <?php foreach($album as $album): ?>
		<?=$album->album; ?>
		<?php endforeach;?></h1>
		
		<?php if(!empty($media)): ?>
		
		<ul class="gallery_thumbs photo_gallery">

			<?php foreach($media as $media):
				$desc=$media->desc;			
			?>
			<li class="thumb"><a href="<?=$media->link;?>" title="<?=$desc?>" rel="gallery1"><img width="166" height="116" src="<?=$media->link_thumbnail;?>" alt="<?=($desc)?$desc:'No image'?>" />
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<!-- END .photo_gallery -->
		<?php endif;?>
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
