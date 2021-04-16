<?php
$this->output->set_header("HTTP/1.0 200 OK");
$this->output->set_header("HTTP/1.1 200 OK");
$this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', strtotime(date('Y-m-d H:i:s'))).' GMT');
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
$this->output->set_header("Cache-Control: post-check=0, pre-check=0");
$this->output->set_header("Pragma: no-cache");
$qry = $this->db->query("select * from `tblsite` where status=1") or die(mysqli_error($this->db->conn_id));
$site_info = $qry->row_array();
if($site_info['status'] == 0):
	redirect("maintenance");
endif;
define('THEME_NAME',(isset($site_info['theme']) ? $site_info['theme'] : 'global'));
$site_theme = $site_info['theme'];

$controller = 'home';
if($this->uri->segment(1))
	$controller = $this->uri->segments[1];

$page = empty($controller) ? 'home' : $controller;

$sql = "select * from tblmeta where LOWER(slug) = '".strtolower($controller)."'";
$query = $this->db->query($sql);

if($query->num_rows() > 0){
	$page_info = $query->row_array();
}else{
	$sql = "select * from tblmeta where LOWER(page) = '".strtolower($controller)."'";
	$query = $this->db->query($sql);
	$page_info = $query->row_array();
}
$meta_title = $site_info['title'];

$sitelogo = !empty($site_info['og_image']) ? 'upload/unique_logo/'.$site_info['og_image'] : $site_info['sitelogo'];

$meta_desc = '';
$meta_keywords = '';

// get meta variable values
$query = $this->db->query("select * from `tblmetavariable` where id=1") or die(mysqli_error($this->db->conn_id));

if($query->num_rows() > 0){
	
	$meta_variable_info = $query->row_array();
	
	$variable_values = array('school_name' => $meta_variable_info['meta_school_name'], 'city' => $meta_variable_info['meta_city'], 
								'state' => $meta_variable_info['meta_state'], 'city_state' => $meta_variable_info['meta_city_state'], 'nearby_location1' => $meta_variable_info['meta_nearbylocation1'], 
								'nearby_location2' => $meta_variable_info['meta_nearbylocation2'], 'county' => $meta_variable_info['meta_county'], 
								'main_martial_arts_style' => $meta_variable_info['meta_main_martial_arts_style'], 
								'martial_arts_style' => $meta_variable_info['meta_martial_arts_style']);
								
	if(isset($page_info['title']) && !empty($page_info['title'])){
		$meta_title = parse_globals($page_info['title'], $variable_values);
	}
	
	if(isset($page_info['desc'])){
		$meta_desc = parse_globals($page_info['desc'], $variable_values);	
	}
		
}
// override default meta data for special pages
$additional_meta = '';

if($controller == 'martial-arts-news'){
	
	if(isset($this->uri->segments[2])){
		$slug = $this->uri->segments[2];

		$query = $this->db->get_where('tblnews', array('slug' => $slug, 'published' => 1));
		$news_data = $query->row_object();
		
	}else{
		$sql = "Select * From tblnews where published = 1 and publish_date <= now() order by timestamp desc";
		$query = $this->db->query($sql);
		$news_data = $query->row_object();	
	}
	
	if($news_data){

		$meta_title = $news_data->title;	
		
		
		
		$meta_desc = $news_data->meta_desc;
		
		$additional_meta .= '<meta property="og:image" content="'.base_url().$news_data->image.'">';
			
	}
	

	
}elseif(isset($page_info['page']) && $page_info['page'] == 'starttrial'){
	
	if(isset($this->uri->segments[2])){
		$slug = $this->uri->segments[2];
		$tbl_onlinespecial_categories = $this->query_model->getTrialOffersCategoryTableName();
		$this->db->select(array('id','name','meta_title','meta_desc'));
		$query = $this->db->get_where("$tbl_onlinespecial_categories", array('slug' => $slug, 'published' => 1));
		$news_data = $query->row_object();
		
	}else{
		$sql = "Select id,meta_title,meta_desc From tbl_onlinespecial_header where id = 1";
		$query = $this->db->query($sql);
		$news_data = $query->row_object();	
	}
	
	if($news_data){

		$meta_title = $this->query_model->getMetaDescReplace($news_data->meta_title);	
		$meta_desc = $this->query_model->getMetaDescReplace($news_data->meta_desc);
		
			
	}
	

	
}elseif(isset($page_info['page']) && $page_info['page'] == 'contactus'){
	if(isset($this->uri->segments[3]) && !empty($this->uri->segments[3])){
		$location = isset($this->uri->segments[3]) && !empty($this->uri->segments[3]) ? urldecode($this->uri->segments[3]) : '';
	}else{
		$location = isset($this->uri->segments[2]) && !empty($this->uri->segments[2]) ? urldecode($this->uri->segments[2]) : '';
	}
	
	
	
		if(isset($location) && !empty($location)){
			if($location != 'student_send_contact'){
				$_contact_data = $this->db->query("select * from `tblcontact`  where  published='1'  and slug='".addslashes($location)."' order by pos ASC") or die(mysqli_error($this->db->conn_id));
				$res = $_contact_data->row_array();
				if($res['meta_title']){
					$meta_title = parse_globals($res['meta_title'], $variable_values);	
				}
				
				if($res['meta_desc']){
					$meta_desc = parse_globals($res['meta_desc'], $variable_values);	
				}
		}	
	}
}elseif(isset($page_info['page']) && ($page_info['page'] == 'blogs' || $page_info['page'] == 'pages')){
	$blog_slug = isset($this->uri->segments[2]) && !empty($this->uri->segments[2]) ? urldecode($this->uri->segments[2]) : '';
	
	
		if(isset($blog_slug) && !empty($blog_slug)){
			
			$query = $this->db->get_where('tblblogs', array('slug' => $blog_slug, 'published' => 1));
			$blog_data = $query->row_object();
			if(!empty($blog_data)){
				if($blog_data->meta_title){
				//$meta_title = parse_globals($blog_data->meta_title, $variable_values);
			
				$meta_title = $this->query_model->getMetaDescReplace($blog_data->meta_title);
			}
			
			
				if($blog_data->meta_desc){
					$meta_desc = parse_globals($blog_data->meta_desc, $variable_values);	
				}
			}
			
		
		}
}elseif(isset($page_info['page']) && $page_info['page'] == 'ourprograms'){
	
	$programDetil = $this->query_model->getbySpecific('tblprogram', 'program_slug', $this->uri->rsegment(4));
	
	$mesta_detail  = $this->query_model->getbySpecific('tblcategory', 'cat_slug', $this->uri->rsegment(3));
	
		if(!empty($programDetil[0]->meta_title) && !empty($this->uri->rsegment(4))){
			
			$meta_title = $this->query_model->getMetaDescReplace($programDetil[0]->meta_title);
			$meta_desc = $this->query_model->getMetaDescReplace($programDetil[0]->meta_desc);
		}else{
			
			$meta_title = !empty($mesta_detail) ? parse_globals($mesta_detail[0]->meta_title, $variable_values) : '';
			$meta_desc = parse_globals($mesta_detail[0]->meta_desc, $variable_values);
		}
			
	
	/*$cat_slug = $this->uri->rsegment(3);
	echo $cat_slug; die;
	$prog_id = $this->uri->rsegment(3);	
	if($prog_id){	
		$this->db->select('meta_desc, meta_title');
		$this->db->from('tblcategory c');
		$this->db->join('tblprogram p', 'p.category = c.cat_id', 'left');
		$this->db->where('p.id', $prog_id);		
		$query = $this->db->get();
		$row = $query->row_array();
		//echo '<br>'.$row['meta_desc'];
		if($row['meta_title']){
			$meta_title = parse_globals($row['meta_title'], $variable_values);	
			//echo '<br>'.$meta_desc;
		}
		if($row['meta_desc']){
			$meta_desc = parse_globals($row['meta_desc'], $variable_values);	
			//echo '<br>'.$meta_desc;
		}		
	}*/
}elseif(isset($page_info['page']) && $page_info['page'] == 'ourfacility'){
	
	$this->load->model("facility_model");
	$IsAllowMultiFacility = $this->facility_model->IsAllowMultiFacility();
	
	if($IsAllowMultiFacility){
		//$facility_slug = $this->uri->segments[2];
		if(isset($this->uri->segments[2]) && $this->uri->segments[2] != ''){
			$facility_slug = $this->uri->segments[2];
			$facility = $this->facility_model->getFacilityBySlug($facility_slug);
		}else{
			$facility = $this->facility_model->getSingleFacility();
		}
	}else{
		
		$facility = new stdClass();
		
		$facility->meta_title = $page_info['title'];
		$facility->meta_desc = $page_info['desc'];
		
	}
	
	if($facility->meta_title){
		$meta_title = parse_globals($facility->meta_title, $variable_values);	
	}
	
	if($facility->meta_desc){
		$meta_desc = parse_globals($facility->meta_desc, $variable_values);	
	}
	
}elseif(isset($page_info['page']) && $page_info['page'] == 'ourstaff'){
	$this->load->model("staff_model");
	$IsAllowMultiStaff = $this->staff_model->IsAllowMultiStaff();
		
	if($IsAllowMultiStaff){
		
		if(isset($this->uri->segments[2]) && $this->uri->segments[2] != ''){
			$location_slug = $this->uri->segments[2];
			$query = $this->db->get_where('tblcontact', array('slug' => $location_slug));
			$result = $query->result();
			if(!empty($result)){
				
				if($result[0]->meta_desc_staff){
					$meta_desc = parse_globals($result[0]->meta_desc_staff, $variable_values);	
				}
				if($result[0]->meta_title_staff){
					$meta_title = parse_globals($result[0]->meta_title_staff, $variable_values);	
				}
			}
			
		}		
	}		
}

// Meta title and Meta description for dojocart
elseif(isset($page_info['page']) && $page_info['page'] == 'promo'){
	$promo = isset($this->uri->segments[2]) && !empty($this->uri->segments[2]) ? urldecode($this->uri->segments[2]) : '';
	
	
		if(isset($promo) && !empty($promo)){
			
			$query = $this->db->get_where('tbl_dojocarts', array('slug' => $promo, 'published' => 1));
			$promo_data = $query->row_object();
			if(!empty($promo_data)){
				if($promo_data->meta_title){
				$meta_title = parse_globals($promo_data->meta_title, $variable_values);	
			}
			
			
			if(!empty($promo_data->meta_desc)){
				$meta_desc = parse_globals($promo_data->meta_desc, $variable_values);	
			}
			}
			
		
		}
}elseif(isset($page_info['page']) && $page_info['page'] == 'about'){
	
	//$this->uri->segments[2]
	$aboutUsMetaDetails = $this->query_model->getMetaTitleForAboutUs($this->uri->segments[2]);
	
	if(!empty($aboutUsMetaDetails)){
		$meta_title = $this->query_model->getMetaDescReplace($aboutUsMetaDetails[0]->meta_title);
	}else{
		$meta_title = $meta_title;
	}
}else{
	
	if(isset($this->uri->segments[1]) && !empty($this->uri->segments[1])){
		$this->db->select(array('meta_title','meta_desc'));
		$pageDetail = $this->query_model->getBySpecific('tbl_static_pages', 'slug',$this->uri->segments[1]);
		if(!empty($pageDetail)){
			$meta_title = !empty($pageDetail[0]->meta_title) ?  parse_globals($pageDetail[0]->meta_title, $variable_values) : '';	
			$meta_desc = !empty($pageDetail[0]->meta_desc) ? parse_globals($pageDetail[0]->meta_desc, $variable_values) : '';
		}
	}
	
}

/* 
| Redirection to http/https Start
| it checks https value from table "tblsite", if it is 1 then
| page will redirect to https and 
| if 0 than redirect to http 
*/

$query = $this->db->get_where('tblsite', array( 'id' => 1));
		$site_settings = $query->row_array();
		$check_http = $site_settings['https'];

$redirect_page = '';
$folder = $_SERVER['CONTEXT_PREFIX'];

$_SERVER['REQUEST_URI'] = str_replace($folder,'',$_SERVER['REQUEST_URI']);
$siteUrl = $this->query_model->getSiteUrl();

$scriptUrl = (isset($_SERVER['SCRIPT_URI']) && !empty($_SERVER['SCRIPT_URI'])) ? parse_url($_SERVER['SCRIPT_URI']) : '';
$scriptUrl = isset($scriptUrl['host']) ? $scriptUrl['host'] : '';

if(isset($_SERVER['REQUEST_URI'])){

	$prefix = $_SERVER['REQUEST_URI'];
	$sitePrefix = explode('/', $prefix);
	
	if(!empty($sitePrefix) && isset($sitePrefix[1])){
		
		$redirect_page = $sitePrefix[1];
		

		if ( $_SERVER['REQUEST_SCHEME'] == 'http' && $check_http == 1) {
			$redirectUrl = 'https://'.$siteUrl.$_SERVER['REQUEST_URI'];
			//header("location: ". $redirectUrl);
			redirect($redirectUrl,'location',301);
		}
		
		

		if($_SERVER['REQUEST_SCHEME'] == 'https' && $check_http == 0){
			
			//header("location: http://dojodigitalmedia.com".$_SERVER['REQUEST_URI']);
			redirect("http://".$siteUrl.$_SERVER['REQUEST_URI'],'location',301);
		}
	
		$mainSiteUrl = str_replace($folder,'',$siteUrl);
		$scriptUrl = strtolower($scriptUrl);
		$mainSiteUrl = strtolower($mainSiteUrl);
		if($scriptUrl != $mainSiteUrl){
			//die('dsafads');
			if( $_SERVER['REQUEST_SCHEME'] == 'https' && $check_http == 1){
				$redirectUrl = 'https://'.$siteUrl.$_SERVER['REQUEST_URI'];
				
				redirect($redirectUrl,'location',301);
			}
		}
		
	}
} 

// Redirection http/https End

/*
| Fetch Record for OG Meta Tag
| ON dojocart promo page by slug
*/

if(isset($this->uri->segments[2]) && $this->uri->segments[1] == 'promo'){
		
  		$slug = $this->uri->segments[2];
		$query = $this->db->get_where('tbl_dojocarts', array('slug' => $slug, 'published' => 1));
		$single_record = $query->row_array();
		
	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="ci_version" version="<?php echo CI_VERSION;?>">
    <meta name="php_version" version="<?php echo phpversion();?>">
	
	
	
	<!-- Code for PWA APP --->
	
<?php /*<meta name="mobile-web-app-capable" content="yes">
<meta name="application-name" content="PWA">
<link rel="icon" sizes="512x512" href="/images/icons/icon-512x512.png">

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="PWA">
<link rel="apple-touch-icon" href="/images/icons/icon-512x512.png"> */ ?>

<?php ////working code for PWA App 

/*<link rel="manifest" href="manifest.json">
<meta name="theme-color" content="#008000"/>
<link href="/images/icons/splash-640x1136.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-750x1334.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1242x2208.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1125x2436.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-828x1792.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1242x2688.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1536x2048.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1668x2224.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-1668x2388.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/images/icons/splash-2048x2732.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />

<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/images/icons/icon-512x512.png"> <?php */?>
	
	<!-- end code --->
	<meta name="google-site-verification" content="FkS1r3e9yxZiwNSmUkb94EwdXUWn-Lhe7t0Ro0iOEPI" />
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <base href="<?=base_url()?>" /> 
	<title><?=$meta_title?></title> 
	<meta name="description" content="<?=$meta_desc?>"/>
	
	<!-- additional meta for share this -->
	<?=$additional_meta?>

	<!-- OG Tag Here -->
	
	
	
	<?php
		$ogDefaultImgPath = isset($single_record['product_image']) ? base_url().'upload/dojocarts/thumb/'.$single_record['product_image'] : base_url().$sitelogo;
		$ogImgPath = $this->query_model->getOgImagePath($ogDefaultImgPath, $page_info);
		
		$ogDefaultTitle = isset($single_record['product_title']) ? $single_record['product_title']:$meta_title;
		$ogTitle = $this->query_model->getOgTitle($ogDefaultTitle, $page_info);
		
		$ogDefaultDesc = !empty($meta_desc) ? $meta_desc:'';
		$ogDesc = $this->query_model->getOgDesc($ogDefaultDesc, $page_info);
		
		$ogDefaultUrl = isset($single_record['slug']) ? base_url().'promo/'.$single_record['slug']:base_url();
		$ogUrl = $this->query_model->getOgUrl($ogDefaultUrl, $page_info);
	?>
	<meta property="og:image" content="<?php echo $ogImgPath;  ?>" />
	<meta property="og:title" content="<?php echo $ogTitle;  ?>" />
	<meta property="og:description" content="<?php echo $ogDesc; ?>" />
	<meta property="og:url" content="<?php echo $ogUrl;  ?>" />
	<!--<meta property="op:markup_url" content="<?php echo $ogUrl;  ?>" /> -->
	<?php 
		$favicon_icon_img = !empty($site_settings['favicon_icon_img']) ? base_url().'upload/unique_logo/'.$site_settings['favicon_icon_img'] : base_url().'images/blank_favicon.ico';
	?>
    <link rel="shortcut icon" type="images/blank_favicon.ico" href="<?= $favicon_icon_img; ?>" />
    <link href="css/v5/bootstrap.min.css" rel="stylesheet">
	
    <!-- Custom CSS -->
    <link href="css/v5/main.css" rel="stylesheet">
    <link href="css/v5/fonts.css" rel="stylesheet">
    <link href="css/v5/master.css" rel="stylesheet">
    
    <link href="css/v5/dojocart.css" rel="stylesheet" type="text/css">
    <link href="css/v5/development.css" rel="stylesheet" type="text/css">

	<?php 
		$this->db->where('main_theme',1);
		$active_theme = $this->query_model->getbyTable('tblthemes');
			if(!empty($active_theme)){
				echo '<link rel="stylesheet" href="'.base_url()."upload/themes/".$active_theme[0]->files.'" />';
			}
	?>

    <link href="custom.css" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
      
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/v5/jcarousel.responsive.css">
	
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<?php if($site_settings['small_large_logo'] == "large_logo"){ ?>
			<style>
			/*LARGE LOGO LEFT START*/
				@media (min-width: 991px) {
				.main-nav .navbar-brand img { max-height: 100px; margin-top: -44px; display: block; background: #ffffff; padding: 4px 10px; border-right: 1px solid #E5E5E5; }
				
				<?php 
				$large_logo_margin_left = !empty($site_settings['large_logo_margin_left']) ? $site_settings['large_logo_margin_left'] : 0;
				 ?>
				.title-h { margin-left: <?php echo $large_logo_margin_left; ?>px !important; padding-right: 12px; }
				.program-category .title-h, .program .title-h { margin-left: 0px; }
				.navbar-nav { margin-left: -16px; }
				.main-nav .navbar-brand { padding: 5px 15px 4px 0px; }
				.title-sub { margin-left: 8px; }
				}

				@media (max-width: 1159px) and (min-width: 991px) {
				.title-sub { font-size: inherit; }
				}
				/*LARGE LOGO LEFT END*/
			</style>
	<?php } ?>
<?php 


$folder_name = $_SERVER['CONTEXT_PREFIX'];
  		$_SERVER['REQUEST_URI'] = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
		$events_slug = $this->query_model->getbySpecific('tblmeta', 'id', 27);
		$events_slug = $events_slug[0];
                
        $student_section_slug = $this->query_model->getbySpecific('tblmeta', 'id', 47);
		$student_section_slug = $student_section_slug[0];
		
$pageurl = '';
$action_url = '';
 	if(isset($_SERVER['REQUEST_URI'])){
		$pageurl = explode('/',$_SERVER['REQUEST_URI']);
		$pageurl_2 = explode('/',$_SERVER['REQUEST_URI']);
		//echo '<pre>'; print_r($pageurl); die;
		if(isset($pageurl[1])){
			$pageurl = $pageurl[1];
		}
		if(isset($pageurl_2[2])){
			$action_url = $pageurl_2[2];
		}
	}


$folder_name = ($_SERVER['SERVER_NAME'] == "localhost") ? '/dojo_demov5' : $_SERVER['CONTEXT_PREFIX'];
$slug = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);


$override_code_header = array();
if(!empty($slug)){
	if($pageurl == $student_section_slug->slug && $action_url == 'videos'){
		$video_slug = '/'.$student_section_slug->slug.'/videos';
		$addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$video_slug);
	}else{
		$addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$slug);
	}
	
	if(!empty($addCodeForCurrentPage)){
		foreach($addCodeForCurrentPage as $addCodeForCurrent){
			
			if($addCodeForCurrent->header_code_placed == 'header'){
				if($addCodeForCurrent->code_checked == 1){
					$override_code_header[] = $addCodeForCurrent->id;
				}
					$this->query_model->getStrReplace($addCodeForCurrent->header_code);
			}
		 }
	}
}



if(empty($override_code_header)){
	$page_slug_type = 'ALL';
	if($pageurl == $student_section_slug->slug || $pageurl == $events_slug->slug){
		$page_slug_type = 'ALL_Student_Section';
	}
	$addCodeAllPages = $this->query_model->getbySpecific('tbladdcode','page_slug',$page_slug_type);
	 foreach($addCodeAllPages as $addCodeAllPage){
		if($addCodeAllPage->header_code_placed == 'header'){
			$this->query_model->getStrReplace($addCodeAllPage->header_code);
			//echo '<br>';
		}
		//
	 }
}
?>

<?php $google_anaytics = $this->query_model->getbySpecific('tblgoogleanaytics','id',1);
			if(!empty($google_anaytics)){
				$this->query_model->getStrReplace($google_anaytics[0]->googlecode);
			}
?>


</head>

<?php


$body_id = '';
$class_name = '';
$urlQueryString = '';
 	if(isset($_SERVER['REDIRECT_QUERY_STRING'])){
		
		$urlQueryString = explode('/',$_SERVER['REDIRECT_QUERY_STRING']);
		$controller_nam = $urlQueryString[1];
		
		
		$about_page_controller = $this->query_model->getbySpecific("tblmeta", "id", 21);
		$trial_offer_controller = $this->query_model->getbySpecific("tblmeta", "id", 40);
		$contact_controller = $this->query_model->getbySpecific("tblmeta", "id", 38);
		$ourprogram_controller = $this->query_model->getbySpecific("tblmeta", "id", 30);
		$dojoCart_controller = $this->query_model->getbySpecific("tblmeta", "id", 49);
		$blog_controller = $this->query_model->getbySpecific("tblmeta", "id", 48);
		$page_controller = $this->query_model->getbySpecific("tblmeta", "id", 52);
		$school_controller = $this->query_model->getbySpecific("tblmeta", "id", 51);
		$student_section_controller = $this->query_model->getbySpecific("tblmeta", "id", 47);
		$events_controller = $this->query_model->getbySpecific("tblmeta", "id", 27);
		
		
		if($controller_nam == $about_page_controller[0]->slug){
		
			$body_id = $this->query_model->getAboutUsBodyId($urlQueryString, 'about');
			
		}elseif($controller_nam == $trial_offer_controller[0]->slug){
		
			$body_id = $this->query_model->getTiralOfferBodyId($urlQueryString, 'trial-offer');
			$class_name = $this->query_model->getTiralOfferBodyClass($urlQueryString);
			
		}elseif($controller_nam == $contact_controller[0]->slug){
		
			$body_id = $this->query_model->getContactUsBodyId($urlQueryString, 'contact-us');
		
		}elseif($controller_nam == $dojoCart_controller[0]->slug){
		
			$body_id = $this->query_model->getDojocartBodyId($urlQueryString, 'dojocart');
			$class_name = $this->query_model->getDojocartBodyClass($urlQueryString);
		}elseif($controller_nam == $school_controller[0]->slug){
		
			$body_id = $this->query_model->getSchoolBodyId($urlQueryString, '');
			
		}elseif($controller_nam == $student_section_controller[0]->slug){
		
			$body_id = 'student-section';
			
			if($this->uri->segment(2) != "" && $this->uri->segment(2) == "virtualtraining"){
				$class_name = 'landing-page';
			}
			
			if($this->uri->segment(2) != "" && $this->uri->segment(2) == "onlinedojo"){
				if($this->session->userdata('student_session_login') == 1){ 
					
				}else{
					$body_id = '';
				}
			}
			
			if($this->uri->segment(2) != "" && $this->uri->segment(2) == "forgot_password"){
				$body_id = '';
			}
			
		}elseif($controller_nam == $events_controller[0]->slug){
		
			$body_id = 'student-section';
			
		}elseif($controller_nam == "virtual-training"){
		
			$class_name = 'landing-page';
			
			
		}elseif($controller_nam == $ourprogram_controller[0]->slug){
			
				if($this->uri->rsegment(2) == 'view'){
					$category_detail = $this->query_model->getbySpecific('tblcategory','cat_slug',$this->uri->rsegment(3));
						$body_id = (!empty($category_detail) && !empty($category_detail[0]->body_id)) ? $category_detail[0]->body_id : 'program-category';
						
						$class_name =	($category_detail[0]->page_template == "condensed") ? 'program-category program-category-condensed' : 'program-category ';
				}
				else{
					$program_detail = $this->query_model->getbySpecific('tblprogram','program_slug',$this->uri->rsegment(4));
					if(!empty($program_detail)){
						$body_id = (!empty($program_detail) && !empty($program_detail[0]->body_id)) ? $program_detail[0]->body_id : 'program';
						$class_name = (!empty($program_detail) && $program_detail[0]->header_image_video == "video") ? 'program video-page-header' : 'program';
					}
					
				}
				
			}elseif(($controller_nam == $blog_controller[0]->slug || $controller_nam == $blog_controller[0]->page) || ($controller_nam == $page_controller[0]->slug)){
				
				$body_id = $this->query_model->getBlogBodyId($urlQueryString, '');
				
			}else{
				if(isset($this->uri->segments[1]) && !empty($this->uri->segments[1])){
					$this->db->select(array('body_class'));
					$pageDetail = $this->query_model->getBySpecific('tbl_static_pages', 'slug',$this->uri->segments[1]);
					if(!empty($pageDetail)){
						$class_name = $pageDetail[0]->body_class;
					}
				}
			}
		
		
	}else{
		$body_id = 'homepage';
	}
	
	
?>



<body id="<?= $body_id ?>" class="<?php echo $class_name; ?>">
	<!-- <div id="loader-wrapper">
		<div id="loader"></div>
	</div> -->

<?php 



$folder_name = $_SERVER['CONTEXT_PREFIX'];
$slug = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
if(!empty($slug)){
	
	if($pageurl == $student_section_slug->slug && $action_url == 'videos'){
		$video_slug = '/'.$student_section_slug->slug.'/videos';
		$addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$video_slug);
	}else{
		$addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$slug);
	}
	
	$override_code_below_body = array();
	if(!empty($addCodeForCurrentPage)){
		foreach($addCodeForCurrentPage as $addCodeForCurrent){
			
			if($addCodeForCurrent->header_code_placed == 'below_body_tag'){
				if($addCodeForCurrent->code_checked == 1){
					$override_code_below_body[] = $addCodeForCurrent->id;
				}
				$this->query_model->getStrReplace($addCodeForCurrent->header_code);
			 }
		 }
	}
}


if(empty($override_code_below_body)){
	$page_slug_type = 'ALL';
	if($pageurl == $student_section_slug->slug || $pageurl == $events_slug->slug){
		$page_slug_type = 'ALL_Student_Section';
	}
	$addCodeAllPages = $this->query_model->getbySpecific('tbladdcode','page_slug',$page_slug_type);
	 foreach($addCodeAllPages as $addCodeAllPage){
		if($addCodeAllPage->header_code_placed == 'below_body_tag'){
			$this->query_model->getStrReplace($addCodeAllPage->header_code);
		}
	 }
}
?>


<script>
	var secureHost = '';
	<?php if($check_http == 1){ ?>
		secureHost = 'https';		
	<?php  }else{ ?>
		secureHost = 'http';	
	<?php 	} ?>
</script>




<?php 


$fb_messenger = $this->query_model->getbyTable("tbl_fb_messenger");
if(!empty($fb_messenger)){
		if($fb_messenger[0]->type == 1){
?>

 <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId            : '<?php echo $fb_messenger[0]->app_id; ?>',
      autoLogAppEvents : true,
      xfbml            : true,
      version          : 'v2.11'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
    
	<div class="fb-customerchat"
 page_id="<?php echo $fb_messenger[0]->page_id; ?>"
 ref=""
 minimized="<true|false>">
 
</div>
<?php } } ?>

<script type="text/javascript">

    // Initialize the service worker
    if ('serviceWorker' in navigator) {
		
        navigator.serviceWorker.register('serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: ', err);
        });
    }
</script>
<?php $unique_id = $this->query_model->setUniqueNumberForForms();   ?>
