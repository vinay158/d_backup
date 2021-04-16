<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<?php $this->load->view('includes/header'); ?>

<?php 
if(isset($_SERVER['REDIRECT_QUERY_STRING'])){
		
		$urlQueryString = explode('/',$_SERVER['REDIRECT_QUERY_STRING']);
		$controller_nam = $urlQueryString[1];
		if($controller_nam == "virtual-training"){
			$this->load->view('includes/header/masthead');
		}else{
			$this->load->view('includes/student_header/masthead');
		}
}
?>
<?php $phoneNumberMaxLength = $this->query_model->phoneNumberMaxLength(); 

	  $getPhoneNumberClass = $this->query_model->getPhoneNumberClass(); 
?>
<?php $settings = $this->query_model->getbyTable("tblsite"); ?>

<section class="white_stripe_section program-top">
<div class="container">
<div class="row">
<div class="col-md-12 col-sm-12">
<h1><?= $this->query_model->getDescReplace($detail[0]->class_name); ?></h1>

<div class="agebox"><?php if(!empty($detail[0]->ages)){ ?><?= $this->query_model->getDescReplace($detail[0]->ages); ?><?php } ?></div>

<?php if($virtual_training[0]->show_zoom_logo == 1){ ?>
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

 <?php if($detail[0]->video_type == 'youtube_video'){ ?>
<?php if(!empty($detail[0]->youtube_video)){ ?>
	 
	 <iframe allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" frameborder="0" height="560" src="<?php echo $this->query_model->changeVideoPathHttp($detail[0]->youtube_video); ?>?rel=0&amp;controls=0&amp;showinfo=0&amp;autoplay=0" width="100%"></iframe>
  <?php } } elseif($detail[0]->video_type == 'vimeo_video'){ ?>
  <?php if(!empty($detail[0]->vimeo_video)){ ?>
   
   <iframe allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" frameborder="0" height="560" src="<?php echo $this->query_model->changeVideoPathHttp($detail[0]->vimeo_video); ?>?rel=0&amp;showinfo=0&amp;autoplay=0" width="100%"></iframe>
	 
  <?php } }elseif($detail[0]->video_type == 'embed_video'){ ?>
	<?= $this->query_model->getDescReplace($detail[0]->embed_video_text); ?>
  <?php } ?></div>
</div>
</div>
</section>

<section class="subheader">
<div class="container">
<div class="row">
<div class="col-md-12 col-sm-12 align-center">
<h2><?= $this->query_model->getDescReplace($detail[0]->instructions_title); ?></h2>

<p><?= $this->query_model->getDescReplace($detail[0]->instructions_description); ?></p>
</div>
</div>
</div>
</section>

<section class="addressbox-cont align-center">
<div class="container">
<div class="row">
<div class="col-sm-12">
<div class="datebox detailpage">
<?php 
$today_weekday = date('l'); 
	if(!empty($times)){ 
		foreach($times as $time){
			if($time->no_classes == 0){
?>
<a href="javascript:void(0)" class="<?php echo ($today_weekday == $time->weekday) ? 'active' : ''; ?>"><label><?php echo $time->weekday; ?> </label><span><?= $this->query_model->getDescReplace($time->time); ?></span></a>
	<?php } } } ?>
</div>
</div>

<div class="col-sm-12 embedbox">
	<h4>Click the button below to launch the LIVE class!</h4>
</div>
<div class="col-sm-12">
<div class="embeded-section"> 
<?php if(!empty($detail[0]->zoom_metting_id)){ ?>
<div class="hoverbox">
	<a class="zoomMetting" zoom_metting_id="<?php echo $detail[0]->zoom_metting_id; ?>"  href="https://zoom.us/j/<?php echo $detail[0]->zoom_metting_id; ?>" target="_blank"><img alt="" src="<?php echo base_url(); ?>images/zoomlog.png" /></a>
</div>
<?php } ?>

<?php // $this->query_model->getDescReplace($detail[0]->live_class_embed); ?>
</div></div>
</div>
</div>
</section>

<?php 
	$password_setting = $this->query_model->getbyTable("tbl_password_pro");
	
	if($password_setting[0]->password_protection_type == "multiple" && $this->session->userdata('student_session_login') == 1){
		
		$userDetail = $this->session->userdata('onlinedojo_user_detail');
		
		$user_id = $userDetail->id;
		$location = $userDetail->location;
		$location_id = $userDetail->location_id;
		$user_name = !empty($userDetail->firstname) ? ucfirst($userDetail->firstname).' '.ucfirst($userDetail->lastname) : $userDetail->email;
		$class_id = isset($detail[0]->id) ? $detail[0]->id : '';
		$class_name = isset($detail[0]->class_name) ? $detail[0]->class_name : '';
		
?>
<script>

	$(document).ready(function(){
		$('.zoomMetting').click(function(){
			var zoom_metting_id = $(this).attr('zoom_metting_id');
			var user_id = '<?php echo $user_id ?>';
			var user_name = '<?php echo $user_name ?>';
			var class_id = '<?php echo $class_id ?>';
			var class_name = '<?php echo $class_name ?>';
			var today_weekday = '<?php echo $today_weekday ?>';
			var location_id = '<?php echo $location_id ?>';
			var location = '<?php echo $location ?>';
			$.ajax({
			
					url: '<?=base_url().$student_section_slug->slug;?>/studentZoomAttendance',
					
					type: 'post',
					
					data: {zoom_metting_id: zoom_metting_id,user_id: user_id ,user_name: user_name ,class_id: class_id ,class_name: class_name, location_id : location_id ,today_weekday : today_weekday,location:location, action: 'zoom_record'},

					
					dataType: 'json',
					
					success: function(result) {
						
						
					}
				  
			});
		})
	})

</script>
	<?php } ?>


<?php $this->load->view('includes/footer'); ?> 

