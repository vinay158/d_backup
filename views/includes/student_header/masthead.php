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
?>

<header class="main-header">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-sm-12 col-lg-8">
        <h1 class="title-h"><?= $settings->title; ?>&nbsp;<span class="sky-txt hidden-xs hidden-sm"><?php echo $this->query_model->getStaticTextTranslation('instructor_area'); ?></span> </h1>
      </div>
      <div class="col-md-4 col-sm-6 col-lg-4  hidden-xs hidden-sm">
        <ul class="student-menu">
			
		<?php 
			$this->db->select('password_protection_type');
			$isMultiUser = $this->query_model->getByTable('tbl_password_pro');
			if($isMultiUser[0]->password_protection_type == "multiple"){
				$userDetail = $this->session->userdata('onlinedojo_user_detail');
				$user_id = $userDetail->id;
				$user = $this->query_model->getbySpecific('tbl_onlinedojo_users', 'id', $user_id);
				if(!empty($user)){
		?>
		<li><span class="user_welcome_text">Welcome</span> <a href="<?php echo base_url().'students/edit_profile' ?>"><?php echo !empty($user[0]->firstname) ? ucfirst($user[0]->firstname).' '.ucfirst($user[0]->lastname) : $user[0]->email; ?></a></li>
			<?php } } ?>
          
          <li><a href="<?php echo base_url().'students/logout' ?>"><?php echo $this->query_model->getStaticTextTranslation('logout'); ?></a></li>
        </ul>
      </div>
    </div>
  </div>
</header>
		
<?php include_once('main_nav.php'); ?>
