<?php
	$settings = $this->query_model->getbyTable("tblsite");

	if(!empty($settings)):

		foreach($settings as $settings):

			
			$logo = $settings->sitelogo;
			
			
		endforeach; 

	endif;
	
?>
<footer class="footer">
    <div class="container">
        <div class="row">
			<?php front_menu(0, 4, '', ''); ?>
			<div class="col-md-3  col-sm-3 text- hidden-sm">
				
				
				
				 <?php 
					if($settings->override_logo == 1){
						if($settings->override_footer_logo != 1){
						
						$footer_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $settings->override_footer_logo);
						
							if(!empty($footer_logo)){
				?>
				<img src="<?php echo base_url().'upload/override_logos/'.$footer_logo[0]->logos; ?>" class="img-responsive hidden-xs footerLogoImg" alt="<?php $this->query_model->getStrReplace($footer_logo[0]->logo_alt); ?>"> 
				<?php 
						} else{ ?>
					<img src="<?php echo $logo; ?>" class="img-responsive hidden-xs footerLogoImg" alt="<?php $this->query_model->getStrReplace($settings->logo_alt); ?>"> 	
						
				<?php		}
				
						
					} else{
						
				?>
				 <img src="<?php echo $logo; ?>" class="img-responsive hidden-xs footerLogoImg" alt="<?php $this->query_model->getStrReplace($settings->logo_alt); ?>"> 
				<?php } } else{ ?>
					 <img src="<?php echo $logo; ?>" class="img-responsive hidden-xs footerLogoImg" alt="<?php $this->query_model->getStrReplace($settings->logo_alt); ?>"> 
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


$folder_name = $_SERVER['CONTEXT_PREFIX'];
$slug = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);



	
	//$folder_name = $_SERVER['CONTEXT_PREFIX'];
	//$slug = str_replace($folder_name,'',$_SERVER['REQUEST_URI']);
	if(!empty($slug)){
		
		if($pageurl == $student_section_slug->slug && $action_url == 'videos'){
			$video_slug = '/'.$student_section_slug->slug.'/videos';
			$addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$video_slug);
		}else{
			$addCodeForCurrentPage = $this->query_model->getbySpecific('tbladdcode','page_slug',$slug);
		}
	
		$override_code_above_body = array();
		if(!empty($addCodeForCurrentPage)){
			foreach($addCodeForCurrentPage as $addCodeForCurrent){
				if($addCodeForCurrent->code_checked == 1){
					$override_code_footer[] = $addCodeForCurrent->id;
				}
				$this->query_model->getStrReplace($addCodeForCurrent->footer_code);
				//echo '<br>';
			 }
		}
	}

if(empty($override_code_footer)){	
	$page_slug_type = 'ALL';
	if($pageurl == $student_section_slug->slug || $pageurl == $events_slug->slug){
		$page_slug_type = 'ALL_Student_Section';
	}

		$addCodeAllPages = $this->query_model->getbySpecific('tbladdcode','page_slug',$page_slug_type);
		 foreach($addCodeAllPages as $addCodeAllPage){
			$this->query_model->getStrReplace($addCodeAllPage->footer_code);
			//echo '<br>';
		 }
}
?>
			
			</div>
			
    	</div>
    </div>
</footer>


