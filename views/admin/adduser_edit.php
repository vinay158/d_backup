<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
	<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>
    --><link rel="stylesheet" href="/resources/demos/style.css" />
    <link rel="stylesheet" href="/resources/demos/style.css" />
    <script>
    $(function() {
        $( "#start" ).datepicker({ dateFormat: "yy-mm-dd" });

    });
    $(function() {
        $( "#expire" ).datepicker({ dateFormat: "yy-mm-dd" });
        
    });
    </script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Edit: User</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
<div class="gen-holder">
	<div class="gen-panel-holder" style="width: 100%">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
<div class="mb-3 main-content-label page_main_heading">Edit: User</div>
<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<script language="javascript">
// DOJO 04/11
$(window).load(function(){
	$.each( $( ".UserType" ), function() {
		
		if ($(this).is(":checked"))
		{
		 	var userTypeValue = $(this).val();
			if(userTypeValue == 'FaceBookUser'){
				$('.FaceBookUserBox').show();
				$('.NoramlUserBox').hide();
			}
			
			if(userTypeValue == 'NoramlUser'){
				$('.NoramlUserBox').show();
				$('.FaceBookUserBox').hide();
			}
		}
		
		
	});
});

$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	})
	
	
	// DOJO 04/11
	
	
	/*$('.UserType').click(function(){
		if ($(this).is(":checked") && $(this).val() == 'facebookLogin')
		{
		 	$('.FaceBookUser').show();
		}else{
			if($(this).val() == 'facebookLogin'){
				$('.FaceBookEmail').hide();
			}
		}
	});*/
	
	$('.UserType').change(function(){
		var userTypeValue = $(this).val();
		if(userTypeValue == 'FaceBookUser'){
			$('.FaceBookUserBox').show();
			$('.NoramlUserBox').hide();
		}
		
		if(userTypeValue == 'NoramlUser'){
			$('.NoramlUserBox').show();
			$('.FaceBookUserBox').hide();
		}
		
	});
})
</script>

<?php if(!empty($details)): ?>

<?php foreach($details as $details):?>
<!---- DOJO 18/11 --->
<div class="form-light-holder">

<div class="row row-xs align-items-center">
	
	<div class="col-md-8  mg-t-5 mg-md-t-0">
	<div class="row mg-t-10">
		<div class="col-lg-3">
		  <label class="rdiobox">
			<input type="radio" class="UserType" name="user_type" value="FaceBookUser" <?php if($details->user_type == 'FaceBookUser'){ echo 'checked=checked'; } ?>  />
			<span>Facebook Login</span>
		  </label>
		</div><!-- col-3 -->
		<div class="col-lg-1 mg-t-20 mg-lg-t-0">
			<b style="color:#031b4e">OR</b>
		</div>
		<div class="col-lg-8 mg-t-20 mg-lg-t-0">
		  <label class="rdiobox">
			<input type="radio" class="UserType" name="user_type" value="NoramlUser" <?php if($details->user_type == 'NoramlUser'){ echo 'checked=checked'; } ?>   />
			<span>Custom Login</span>
		  </label>
		</div><!-- col-3 -->
		</div>
	</div>
</div>

</div>

<span class="NoramlUserBox">
<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>User Name</h1>
	<input type="text" value="<?=$details->user?>" name="username" id="username" class="field" placeholder="Enter user name here"/>
		</div>
	
	<div class="linkTarget form-group">
		<h1>Password</h1>
		<input type="password" value="" name="password" id="password" class="field" placeholder="Enter new password here"/>
	</div>
</div>

</span>

<!--- </code > --->

<div class="form-light-holder   d-md-flex  dual_input" style="">
	<div class="adsUrl form-group">
	<h1>First Name</h1>
	<input type="text" value="<?=$details->fname?>" name="firstname" id="firstname" class="field" placeholder="Enter first name here"/>
	</div>
	
	<div class="linkTarget form-group">
		<h1>Last Name</h1>
	<input type="text" value="<?=$details->lname?>" name="lastname" id="lastname" class="field" placeholder="Enter last name here"/>
	</div>
</div>
<div class="form-light-holder FaceBookUserBox" style="display:none">
	<h1>FaceBook Email Address</h1>
	<input type="text" value="<?=$details->facebook_email?>" name="facebook_email" id="facebook_email" class="field" placeholder="Enter Facebook email address here"/>
</div>

<div class="form-light-holder">
	<h1>Email Address</h1>
	<input type="text" value="<?=$details->email?>" name="email" id="email" class="field" placeholder="Enter email address here"/>
</div>

<!--- DOJO 04/11 --->



<?php 
	$pages_arr = config_item('pages');
	if(isset($links[0]->slug)) { $slug = $links[0]->slug; } else { $slug = ''; }
	
?>
<div class="mb-3 main-content-label page_main_heading">Set Permissions</div>
<div class="form-light-holder">
	
	<div class="row row-xs align-items-center align-items-baseline mg-b-20 add_user_permissions">
		<?php if(!empty($leads_tab)){ ?>
		<div class="col-md-4">
			<h1>Leads</h1>
			<?php foreach ($leads_tab as $key => $value): ?>
					<label class="ckbox"><input type="checkbox" name="leads[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><span><?=$value['title']?></span></label>
			<?php endforeach; ?>
		</div>
		<?php } ?>
		
		
		
		<?php if(!empty($school_info_tab)){ ?>
			<div class="col-md-4">
			<h1>School Info</h1>
			<?php foreach ($school_info_tab as $key => $value):
					
			?>
					<label class="ckbox"><input type="checkbox" name="school_info[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><span><?=$value['title']?></span></label>
				<?php  endforeach; ?>
		</div>
		<?php } ?>
		
		<?php if(!empty($home_tab)){ ?>
		<div class="col-md-4">
			<h1>Homepage</h1>
			<?php foreach ($home_tab as $key => $value): ?>
					<label class="ckbox"><input type="checkbox" name="home[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><span><?=$value['title']?></span></label>
			<?php endforeach; ?>
		</div>
		<?php } ?>
		
		
	</div>
	<div class="row row-xs align-items-center align-items-baseline mg-b-20 add_user_permissions">
		<!--<div style="float:left;padding-right: 40px;">
			Contact Us<br>
			<?php foreach ($contactus_tab as $key => $value): ?>
					<input type="checkbox" name="contact[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><?=$value['title']?><br>
			<?php endforeach; ?>
		</div>-->
		
		<?php if(!empty($aboutus_tab)){ ?>
		<div class="col-md-4">
			<h1>About</h1>
			<?php foreach ($aboutus_tab as $key => $value): ?>
					<label class="ckbox"><input type="checkbox" name="about[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><span><?=$value['title']?></span></label>
			<?php endforeach; ?>
		</div>
		<?php } ?>
		
		<?php if(!empty($trial_offer_tab)){ ?>
		<div class="col-md-4">
			<h1>Trial Offer</h1>
			<?php foreach ($trial_offer_tab as $key => $value): 
			?>	
					<label class="ckbox"><input type="checkbox" name="trial_offer[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><span><?=$value['title']?></span></label>
			<?php endforeach; ?>
		</div>
		<?php } ?>
		
		
		
		
	
		<?php if(!empty($others)){ ?>
		<div class="col-md-4">
			<h1>Other</h1>
			<?php foreach ($others as $key => $value):	?>
					<label class="ckbox"><input type="checkbox" class="otherLinks" name="other[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><span><?=$value['title']?></span></label>
			<?php endforeach; ?>
		</div>
		<?php } ?>
		</div>
	<div class="row row-xs align-items-center align-items-baseline mg-b-20 add_user_permissions">
	
		<?php if(!empty($student_section_tab)){ ?>
		<div class="col-md-3">
			<h1>Student Section</h1>
			<?php foreach ($student_section_tab as $key => $value): 
				$show = 1;
					$this->db->select('video_thread');
					$is_video_thread = $this->query_model->getByTable('tblsite');
					$is_video_thread = 	$is_video_thread[0]->video_thread;
					
						if($value['slug'] == "admin/gallery"){
							if($is_video_thread == 1){
								$show = 0;
							}
						}elseif($value['slug'] == "admin/albums/view"){
							if($is_video_thread == 0){
								$show = 0;
							}
						}
						
				if($show == 1){
			?>
					<label class="ckbox"><input type="checkbox" name="contact[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><span><?=$value['title']?></span></label>
				<?php } endforeach; ?>
		</div>
		<?php } ?>
		
		<?php if(!empty($settings_tab)){ ?>
		<div class="col-md-3">
			<h1>Settings</h1>
			<?php foreach ($settings_tab as $key => $value): 
			?>	
					<label class="ckbox"><input type="checkbox" name="setting[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><span><?=$value['title']?></span></label>
			<?php endforeach; ?>
		</div>
		<?php } ?>
		
		
	
		<?php if(!empty($school_tab)){ ?>
		<div class="col-md-3">
			<h1>Locations</h1>
			<?php 
			
				foreach ($school_tab as $key => $value):
					
			?>
					<label class="ckbox"><input type="checkbox" name="school[]" value="<?=$key?>" <?php echo (strstr($slug, $key)) ? 'checked="checked"' : ''; ?>><span><?=$value?></span></label>
			<?php endforeach; ?>
		</div>
		<?php } ?>
		
	<?php if(!empty($forms_tab)){ ?>
		<div class="col-md-3">
			<h1>Forms</h1>
			<?php foreach ($forms_tab as $key => $value): 
			?>	
					<label class="ckbox"><input type="checkbox" name="forms[]" value="<?=$value['slug']?>" <?php echo (strstr($slug, $value['slug'])) ? 'checked="checked"' : ''; ?>><span><?=$value['title']?></span></label>
			<?php endforeach; ?>
		</div>
	<?php } ?>
	
		
	</div>	
		
		
</div>



<div class="form-white-holder" style="padding-bottom:20px;">
	<input type="submit" name="update" value="Save" class="btn-save" style="float:left;" />
</div>

<?php endforeach;?>
<?php endif; ?>

</form>
		</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
