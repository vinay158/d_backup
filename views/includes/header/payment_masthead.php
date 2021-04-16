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
                    <h1 class="title-h"><a href="<?php echo $this->query_model->getBaseUrl(); ?>"><?= $settings->title; ?></a>
                    <span class="title-sub hidden-xs"><?php $this->query_model->getStrReplace($settings->h1_tag); ?>
                    </span>
                    </h1>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4  hidden-xs hidden-sm">
                <h2 class="contact-top">
				
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
    <!-- Navigation -->


		
		
<?php //include_once('main_nav.php'); ?>
