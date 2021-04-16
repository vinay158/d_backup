<?php
$this->load->helper('url');	
$_URL = array();
$query = $this->db->get( 'tblmeta' );
$result = $query->result();
foreach( $result as $row )
{
	if(!empty($row->slug) && !empty($row->page)) {
		$_URL[trim($row->slug)] = trim($row->page);
	}
}
$multilocation = $this->query_model->getbyTable("tblconfigcalendar");
$multilocation = $multilocation[0];
$multilocation = $multilocation->field_value;
$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_location'));
$result = $query->result();
$multi_location = $result[0]->field_value;
$_SLUG = array('ourschool', 'ourfacility', 'ourstaff' , 'ourphilosophy', 'schoolrules', 'schoolrules', 'faq', 'events', 'news', 'videogallery','photogallery', 'ourprograms' , 'starttrial' , 'testimonials', 'contactus');
foreach($_SLUG as $needle) {
	$slug = array_search($needle, $_URL);
	if($slug == false) { 
		if($needle=='events'){
			$events_url=$needle;
		}else{
			$$needle = $needle;
		}	
	} 
	else { 
		if($needle=='events'){
			$events_url=$slug;
		}else{		
			$$needle = $slug;
		 }
	} 
}
$settings = $this->query_model->getbyTable("tblsite");

	if(!empty($settings)):

		foreach($settings as $settings):

			$twitter = $settings->twitter;

			$fb = $settings->fb;

			$logo = $settings->sitelogo;
			
			$gplus = $settings->gplus;
			
			$youtube = $settings->youtube;

			$phone = $settings->phone;

			$address = $settings->address.", ".$settings->city.", ".$settings->state.", ".$settings->zip;
			
			

		endforeach; 

	endif;

$mainLocation = $this->query_model->getMainLocation("tblcontact");

$multi_student_section = $this->query_model->getbySpecific("tblconfigcalendar", 'id',8);

?>
<?php 
 	$pageurl = '';
 	if(isset($_SERVER['REQUEST_URI'])){
		$pageurl = explode('/',$_SERVER['REQUEST_URI']);
		if(isset($pageurl[1])){
			$pageurl = $pageurl[1];
		}
	}
 ?>
 
<header class="main-header   <?php if($pageurl == 'programs' || $pageurl == 'ourprograms'){ echo ' dark-header'; }?>">
	
        <span class="fixed-text mobile-visible"><a href="#">Try a free class</a> </span>
         <div class="container-fluid">
            <div class="row">
               <div class="col-md-8 col-sm-12 col-lg-8">
                  <h1 class="title-h"><a href="<?php echo base_url(); ?>"><?= $settings->title; ?></a>
                    <span class="title-sub hidden-xs"><?php $this->query_model->getStrReplace($settings->h1_tag); ?>
                    </span>
                  </h1>
               </div>
               <div class="col-md-4 col-sm-6 col-lg-4  hidden-xs hidden-sm">
                  <h2 class="contact-top">
				    <?php if($this->session->userdata('student_session_login') == 1){ ?>
								<a href="<?php echo base_url().'studentsection' ?>" class="login-top"> 
								<i class="fa fa-user"></i><?php echo $settings->ss_login_text; ?></a>
						<?php } else { ?>
							<?php if($settings->st_sec_external_link == 1){ ?>
								<a href="<?php echo $settings->st_sec_button_url; ?>"  class="student_section_login_btn login-top"> <i class="fa fa-user"></i> <?php echo $settings->st_sec_button_text; ?></a> 
							<?php } else{ ?>

					<?php if($settings->login_check_fields == 0){
						$student_session_login = array('student_session_login' => 1);
						$this->session->set_userdata($student_session_login);

					 ?>
					<a href="<?php echo base_url().'studentsection' ?>" class="login-top"> <i class="fa fa-user"></i> <?php echo $settings->ss_login_text; ?></a>
					<?php }else{ ?>

								<a href="javascript:void('0')" data-toggle="modal" data-target="#loginmodal" data-whatever="@mdo" class="student_section_login_btn login-top"> <i class="fa fa-user"></i> <?php echo $settings->ss_login_text; ?></a> 
							<?php }} ?>
						<?php } ?>	
			 
				
                    	<?php if($multilocation == 1){ ?>
						<?php $this->query_model->getStrReplace($settings->top_bar_text); ?>
					<?php } else{  ?>
						<i class="fa fa-phone"></i>
						<span class="consult"><?php $this->query_model->getStrReplace($settings->phone_number_text); ?></span> 
						<span class="phone-top"><?= $mainLocation[0]->phone; ?></span>
					<?php } ?>
                  </h2>
               </div>
            </div>
         </div>
      </header>
	  
	  
		
<?php include_once('main_nav.php'); ?>
