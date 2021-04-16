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
		<h1 class="center"><?=$title;?></h1>
		
		<ul class="list_style_content gallery">
			<?php if(!empty($album)): ?>
			<?php foreach($album as $album):			
			
			?>

			<li class="list_section">
				
				<dl class="content">
				<?php  if(!empty($album->cover)){  ?>
					<dt class="section_img">					
					<img src="<?=$album->cover?>" alt="Title cover" width="155" height="116" />
					</dt>
					<?php } else { ?>
					<!--<dt class="section_img">
					<img src="<?=THEMEPATH;?>themes/global/images/gallery_list_img.jpg" alt="" />					
					</dt>
					-->
				<?php  }  ?>	
					<dd class="name"><p><span><?=$album->album?></span></p></dd>
					<dd class="blurb"><span class="page_content" style="line-height:1.80 !important"><?=html_entity_decode($album->desc)?></span></dd>					
					<dd>
					
				<?php  $base=basename($_SERVER['REQUEST_URI']); ?>
					<a href=<?=$base;?>/<?=$link_type?>/<?=$album->id?> class="button">View Gallery</a>

				
				</dl>
				
				<!-- END .content -->
			
			</li>
			<!-- END .list_section -->
		<?php  endforeach; ?>
		<?php endif;?>
		
		</ul>
		<!-- END .list_style_content .staff -->
	
	</div>
	<!-- END .main_content -->
	
</div>

<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
