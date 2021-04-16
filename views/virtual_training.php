<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>

<?php 
$access_without_login = 0;
if(isset($_SERVER['REDIRECT_QUERY_STRING'])){
		
		$urlQueryString = explode('/',$_SERVER['REDIRECT_QUERY_STRING']);
		$controller_nam = $urlQueryString[1];
		if($controller_nam == "virtual-training"){
			$access_without_login = 1;
			$this->load->view('includes/header/masthead');
		}else{
			$this->load->view('includes/student_header/masthead');
		}
}

$virtual_training_slug = $this->query_model->getbySpecific('tblmeta', 'id', 54);
$virtual_training_slug = $virtual_training_slug[0];
?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
?>
<?php $settings = $this->query_model->getbyTable("tblsite"); ?>


<section class="white_stripe_section program-top">
<div class="container">
<div class="row">
<div class="col-md-12 col-sm-12">
<h1><?= $this->query_model->getDescReplace($detail[0]->title); ?></h1>
<?php // $this->query_model->getDescReplace($detail[0]->sub_title); ?> 

<?php if($detail[0]->show_zoom_logo == 1){ ?>
<p> live classes powered by
<img alt="" src="<?php echo base_url(); ?>images/zoomimg.png" />
</p><?php } ?>
</div>
</div>
</div>
</section>

<section class="getting_started" id="get-started">
<div class="container">
<div class="row">
<div class="col-sm-12 align-center">



 <?php 
 if($detail[0]->image_video == 'video'){ 
 if($detail[0]->video_type == 'youtube_video'){ ?>
<?php if(!empty($detail[0]->youtube_video)){ ?>
	 
	 <iframe allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" frameborder="0" height="560" src="<?php echo $this->query_model->changeVideoPathHttp($detail[0]->youtube_video); ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0" width="80%"></iframe>
  <?php } } elseif($detail[0]->video_type == 'vimeo_video'){ ?>
  <?php if(!empty($detail[0]->vimeo_video)){ ?>
   
   <iframe allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" frameborder="0" height="560" src="<?php echo $this->query_model->changeVideoPathHttp($detail[0]->vimeo_video); ?>?rel=0&amp;showinfo=0&amp;autoplay=0" width="80%"></iframe>
	 
  <?php } }elseif($detail[0]->video_type == 'embed_video'){ ?>
	<?= $this->query_model->getDescReplace($detail[0]->embed_video_text); ?>
 <?php } }else{?>
 
	<?php 
		if(!empty($detail[0]->photo)){
			$thumb = '';
			$dir=pathinfo(BASEPATH);
			if(file_exists($dir['dirname'].'/upload/slider_video/thumb/'.$detail[0]->photo)){
				$thumb = 'thumb/';
			}
	?>
		<img class="" src="<?php echo base_url().'upload/slider_video/'.$thumb.$detail[0]->photo; ?>" style="width:80%" />
		<?php } ?>
 <?php } ?>
		  
</div>
</div>
</div>
</section>

<section class="subheader">
<div class="container">
<div class="row">
<div class="col-md-12 col-sm-12 align-center">
<h2><?= $this->query_model->getDescReplace($detail[0]->desc_title); ?></h2>

<p><?= $this->query_model->getDescReplace($detail[0]->desc_short); ?></p>
</div>
</div>
</div>
</section>
<?php if(!empty($virtual_training_rows)){ ?>
<section class="addressbox-cont align-center">
<div class="container">
<div class="row">
<?php 
	foreach($virtual_training_rows as $row){ 
		
		$this->db->where("rows_id", $row->id);
		$times = $this->query_model->getbyTable('tbl_virtual_training_rows_time');
	
?>
<div class="col-sm-4">
<div class="address-block">
<h3><?= $this->query_model->getDescReplace($row->class_name); ?></h3>

<?php if(!empty($row->ages)){ ?><p><?= $this->query_model->getDescReplace($row->ages); ?></p><?php } ?>
<div class="datebox">
<?php if(!empty($times)){ ?>
<ul>
	<?php 
	$today_weekday = date('l'); 
	foreach($times as $time){
			if($time->no_classes == 0){
	?>
	<li class="<?php echo ($today_weekday == $time->weekday) ? 'active' : ''; ?>"><label><?php echo $time->weekday; ?> </label><span> 
	<?= $this->query_model->getDescReplace($time->time); ?>
	</span></li>
	<?php } } ?>
</ul>
<?php } ?>
</div>
<?php if($access_without_login == 1){ ?>
	<a class="btn-theme" href="<?php echo base_url().$virtual_training_slug->slug.'/'.$row->slug; ?>">

<?php }else{ ?>
	<a class="btn-theme" href="<?php echo base_url().$student_section_slug->slug.'/virtualtraining/'.$row->slug; ?>">

<?php } ?>

Join Now</a></div>
</div>
<?php } ?>
</div>
</div>
</section>
<?php } ?>




<?php $this->load->view('includes/footer'); ?> 

