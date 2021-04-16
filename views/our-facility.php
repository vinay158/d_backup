<?php $this->load->view('includes/header'); ?>

<body class="inside_page two_column left_sidebar">

<?php $this->load->view('includes/header/masthead'); ?>
<?php $pageURL = current_url(); ?>

<div class="main container clearfix">
	
	<ul class="sidebar vertical two_column clearfix">
	
		<?php  $this->load->view('includes/sidebar/feature_boxes'); ?>
		
	</ul>
	<!-- END .sidebar .vertical -->
	
	<div class="main_content two_column" id="top">
	
		<div class="fb-recommend-container">
			<div class="fb-like" data-href="<?php echo $pageURL;?>" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-action="recommend">
			</div>
		</div>
		<h1><?=$facility->title?></h1>
		<span class="page_content"><?=html_entity_decode($facility->content);?></span>
	
	
	<!-- Facility Photos -->
	<div class="facility_photo photo_gallery">
	<?php 		
	
	   $photo_data = $this->db->query("select * from tblaboutfacilityphoto where facility_id = ".$facility->id." order by pos ASC ")->result();
       
		if(!empty($photo_data)):
			foreach($photo_data as $photo):
	?>
		<div class="photo_list_disp">
			<a href="<?=$photo->photo;?>" title="<?=$photo->desc;?>" rel="gallery1">
				<img src="<?=$photo->link_thumbnail;?>" alt="<?=$photo->desc;?>" />
			</a>
		</div>
	<?php 	endforeach;
		endif;
	?>


	</div>
	<!-- END Facility Photos -->
	
	</div>
	<!-- END .main_content -->
</div>
<!-- .main .container -->

<?php $this->load->view('includes/footer'); ?>
