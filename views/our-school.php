<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar">

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
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php  $this->load->view('includes/sidebar/feature_boxes'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
	<?php foreach($page as $page): ?>
		<div class="fb-recommend-container">
			<div class="fb-like" data-href="<?php echo $pageURL;?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-action="recommend">
			</div>
		</div>
		<h1><?=$page->title?></h1>
		<span class="page_content"><?=html_entity_decode($page->content);?></span>
	<?php endforeach; ?>	
	
	<!-- Facility Photos -->
	<div class="facility_photo photo_gallery">
	<?php 
		if($page->slug == "our_facility"){
				//$photo_data = $this->db->get("tblmedia")->result();			 					
			   $photo_data = $this->db->query("select * from tblaboutfacilityphoto order by pos ASC ")->result(); ?>				
				<?php if(!empty($photo_data)): ?>
				<?php foreach($photo_data as $photo):?>
				<div class="photo_list_disp">
					<a href="<?=$photo->photo;?>" title="<?=$photo->desc;?>" rel="gallery1">
						<img src="<?=$photo->link_thumbnail;?>" alt="<?=$photo->desc;?>" />
					</a>
				</div>
				<?php endforeach;endif;?>

	<?php } ?>
	</div>
	<!-- END Facility Photos -->
	
	</div>
	<!-- END .main_content -->
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
