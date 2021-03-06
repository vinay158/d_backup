<?php $this->load->view("admin/include/header"); ?>


<!-- end head contents -->

<!--wysiwyg editor script -->

<!--<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>-->

<!--<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script> -->

  <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />

    <script src="http://code.jquery.com/jquery-1.8.2.js"></script>

    <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>    

  <!--  <link rel="stylesheet" href="/resources/demos/style.css" /> -->
	
	<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'mini_editor', 
									{ customConfig : 'mini_config.js' }
							);
							
		
		 CKEDITOR.replace(  'seo_text', 
									{ customConfig : 'mini_config.js' }
							);
	
	
	});
</script>

<script>
	$(window).load(function(){
	
	$.each( $( ".image_video" ), function() {
		if($(this).attr('checked') == 'checked'){
			var radio_button_value = $(this).val();
	
			if(radio_button_value == "regular_link"){
				$('.welcome_video').hide();
				$('.contact_form_2').attr('required',false);
				$('.contact_form_1').attr('required',true);
				/*$.each( $( ".contact_form_2" ), function() {
					$(this).attr('required',false);
				});*/
				
			}
			if(radio_button_value == "external_link"){
				$('.welcome_image').hide();
				$('.contact_form_1').attr('required',false);
				$('.contact_form_2').attr('required',true);
				/*$.each( $( ".contact_form_1" ), function() {
					$(this).attr('required',false);
				});*/
					
			}
		}
	});
	

	var contact_location_type = $('.contact_location_type').val();
		if(contact_location_type == "International"){
			$('.stateDropdown').hide();
			$('.stateTextbox').show();
		}else{
			$('.stateDropdown').show();
			$('.stateTextbox').hide();
		}
	
	});
</script>

<script language="javascript">


$(document).ready(function(){
	$("#main_title").keyup(function(){
		$("#sef_title").html($(this).val());
	});
	
$('.image_video').click(function(){
	var radio_button_value = $(this).val();
	
	if(radio_button_value == "regular_link"){
		$('.welcome_video').hide();
		$('.welcome_image').show();
		$('.welcome_video_image').hide();
		$('.contact_form_2').attr('required',false);
		$('.contact_form_1').attr('required',true);
		
		if($('.multi_api_box').length == 0){
			$('#MultiApis').hide();
			$('.tab_multi_api').hide();
		}else{
			$('#MultiApis').show();
			$('.tab_multi_api').show();
		}
		
		
	}
	if(radio_button_value == "external_link"){
		$('.welcome_image').hide();
		$('.welcome_video').show();
		$('.contact_form_1').attr('required',false);
		$('.contact_form_2').attr('required',true);
		
		$('#MultiApis').hide();
		$('.tab_multi_api').hide();
		
	}
});

$('.contact_location_type').change(function(){
	var contact_location_type = $(this).val();
	if(contact_location_type == "International"){
		$('.stateDropdown').hide();
		$('.stateTextbox').show();
	}else{
		$('.stateDropdown').show();
		$('.stateTextbox').hide();
	}
})
	
})
</script>

<?php 

$sociallink_class = '';
if($multiLoc[11]->field_value == 0){
	if($multiLoc[8]->field_value == 0){
		$sociallink_class = 'display_class';
	}
}

?>


<div class="az-content-body-left advanced_page" >

       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 program-cat-page program-detail-page">
				<div class="container">
	  
	  
        
    <div class="az-content az-content-app az-content-contacts pd-b-0">
      <div class="container">
        <div class="az-content-left az-content-left-contacts">


         <div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">LOCATION</h4>
			   
				  
            </div>
            <div>
			
			
			</div>
          </div>
		
		<?php $page_url = ''; ?>
          <div id="azContactList" class="az-contacts-list">
			
			<a href="<?php echo $page_url; ?>#ContactInfo" class="az-contact-item">
              <div class="az-contact-body">
                <h6>Contact info</h6>
              </div>
            </a>
		
		
			<a href="<?php echo $page_url; ?>#SocialLinks" class="az-contact-item welcome_image <?php echo $sociallink_class; ?>">
              <div class="az-contact-body">
                <h6>Social Links</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#OperationHours" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Hours of Operation</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#MultiApis" class="az-contact-item welcome_image tab_multi_api">
              <div class="az-contact-body">
                <h6>Multi API's</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#MapSetting" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>Map Setting</h6>
              </div>
            </a>
			
			<a href="<?php echo $page_url; ?>#SeoMeta" class="az-contact-item welcome_image">
              <div class="az-contact-body">
                <h6>SEO/Meta Details</h6>
              </div>
            </a>
			
			
			
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
        <div class="az-content-body az-content-body-contacts">
			
				<div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">EDIT LOCATION</h4>
            </div>
            
          </div>
				
				<div class=" edit-form edit_form_box">
				<form id="blog_form" action="" method="post" enctype="multipart/form-data">
<div class="gen-holder"  style="display:flex !important">

	<div class="gen-panel-holder" style="width: 100%">

	<div class="gen-panel">

		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">





<script language="javascript">

$(document).ready(function(){

	$("#main_title").keyup(function(){

		$("#sef_title").html($(this).val());

	});

$("#blog_form").submit(function(){

	/*var ent_1 = $("#name").val();

	var ent_2 = $("#address").val();

	var ent_3 = $("#city").val();

	var ent_4 = $("#zip").val();

	var ent_5 = $("#email").val();

	//var ent_6= $("#suite").val();

	//var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;

	//var suitefilter=/^[a-z0-9]+$/i;

	if(ent_1.length == 0 || ent_2.length == 0 || ent_3.length == 0 || ent_4.length == 0 || ent_5.length == 0){

	alert("Please Fill in the fields correctly.");

	//event.preventDefault();

	return false;

	}*/

	});
	
	
	$('.checkbox_status_identifier').click(function(){
		var number = $(this).attr('number');
		
		if($(this).is(':checked')){
			$( ".custom_check_"+number).prop( "checked", false );
			$('.closed_days_'+number).hide();
			$('.custom_text_'+number).hide();
			
		} else{
			
			$('.closed_days_'+number).show();
			
		}
	});
	
	$('.custom_text_checkbox').click(function(){
		var number = $(this).attr('number');
		if($(this).is(':checked')){
			$( ".close_check_"+number).prop( "checked", false );
			$('.closed_days_'+number).hide();
			$('.custom_text_'+number).show();
			
		} else{
			$('.closed_days_'+number).show();
			$('.custom_text_'+number).hide();
		}
	});
	
	
	$("#delete_img").click(function(){
		$('#img').hide();
		var location_id=$(this).attr('location_id');
		var image_path=$('#img').attr('src');
					
		//var mod_type = $("#contact_mod").val().toLowerCase();
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/contact/delete_contact_img',						
		data: { location_id : location_id,image_path:image_path }					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			$('#last-photo').val('');
			//setTimeout("window.location.href='admin/"+mod_type+"/edit/"+staff_id+"'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});

})

</script>

<?php if(!empty($details)):?>

<?php foreach($details as $details): ?>

<?php 
    $display_radio_class = '';
	if($user_level != 1){
		$display_radio_class = 'display_class';
	}
?>

<div class="form-light-holder radio_location_type  <?php echo $display_radio_class; ?> ">
<div class="az-content-header-right">
	<!--<h1>Regular Contact Location Or Link to an External Link</h1> -->
	<label class="rdiobox">
   	<input type="radio" class="image_video" name="location_type" value="regular_link" <?php if(!empty($details) && $details->location_type == 'regular_link'){ echo 'checked=checked'; } elseif(empty($details->location_type)){  echo 'checked=checked'; } ?>  /><span>Regular Contact Location</span>
				&nbsp;&nbsp;&nbsp;</label><b style="
    position: relative;
    margin-top: -8px;
	color:#000;
">OR</b></span>&nbsp;&nbsp;&nbsp;
	
	<label class="rdiobox">
	<input type="radio" class="image_video" name="location_type" value="external_link" <?php if(!empty($details) && $details->location_type == 'external_link'){ echo 'checked=checked'; }?> /> <span>Link to an External Link</span>
				</label>

</div>
</div>

<div class="welcome_video">
<div class="form-light-holder">

	<h1>External Dojo Name</h1>

	<input type="text"  value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->name); }?>" name="external_name" id="name" class="field contact_form_2" placeholder="Enter external dojo name" required="required" />

</div>

<div class="form-light-holder">

	<h1>External Email Address</h1>

	<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->email); }?>" name="external_email" id="email" class="field contact_form_2" placeholder="Enter external email address" required="required"/>

</div>
<div class="form-light-holder">

<h1>External URL</h1>

	<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->external_url); }?>" name="external_url" id="" class="field contact_form_2" placeholder="Enter external url" required="required"/>

</div>
</div>

<div class="welcome_image">
<div class="page-section" id="ContactInfo">


<div class="form-light-holder">

	<h1>Contact Location Type</h1>

	<select name="contact_location_type" class="field contact_location_type ">
		<option value="US" <?php echo ($details->contact_location_type == "US") ? 'selected=selected' : ''; ?>>US</option>
		<option value="International" <?php echo ($details->contact_location_type == "International") ? 'selected=selected' : ''; ?>>International</option>
	</select>

</div>

<?php if($multiSchool == 1){ ?>
<div class="form-light-holder">

	<h1>Location Type</h1>

	<select name="school_location_type" class="field school_location_type ">
		<option value="default" <?php echo ($details->school_location_type == "default") ? 'selected=selected' : ''; ?>>Default Location</option>
		<option value="nested" <?php echo ($details->school_location_type == "nested") ? 'selected=selected' : ''; ?>>Nested Location</option>
	</select>

</div>


<div class="form-light-holder turn_on_nested_location">

	<a id="published" class="checkbox2 <?php if($details->turn_on_nested_location ==1) echo "check-on"; else echo "check-off";?>"></a>

	<h1 class="inline">Turn Nested Main Location ON</h1>

	<input type="hidden" value="<?=$details->turn_on_nested_location?>" name="turn_on_nested_location" class="hidden_cb2" />

</div>

<?php $locations = $this->query_model->getAllNestedParentLocations($details->id);?>
<div class="form-light-holder parent_locations_dropdown">

	<h1>Locations</h1>
	<select name="parent_id" class="field parent_locations">
		<option value="">-Select Location-</option>
		<?php 
			if(!empty($locations)){
				foreach($locations as $location){ 
		?>
			<option value="<?php echo $location->id ?>" <?php echo ($details->parent_id ==  $location->id) ? "selected=selected" : '';?>><?php echo $location->name ?></option>
			<?php } } ?>
	</select>

</div>

<?php } ?>



<div class="form-light-holder">

	<h1>Dojo Name</h1>

	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->name)?>" name="name" id="name" class="field contact_form_1" placeholder="Enter dojo name" required="required" style="width:100% !important"/>

</div>


<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Street Address</h1>

	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->address)?>" name="address" id="address" class="field contactHalfDivInput contact_form_1 defaultRequired" placeholder="Enter street address" required="required"/>
	</div>
	
	
	<div class="linkTarget form-group">
		<h1>Suite</h1>

		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->suite)?>" name="suite" id="suite" class="field contactHalfDivInput " placeholder="Enter Suite"/>
	</div>
	
</div>


<div class="form-light-holder  d-md-flex  dual_input">
	<div class="opreationHoursDiv adsUrl form-group">
	<h1>City</h1>

	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->city)?>" name="city" id="city" class="field opreationHoursInput contact_form_1 defaultRequired" placeholder="Enter City" required="required"/>
	</div>
	<div class="opreationHoursDiv stateDropdown linkTarget form-group">
		<h1>State</h1>

<?php 

 $state_list = array ('alabama'=>"AL", 'Alaska'=>"AK", 'Arizona'=>"AZ", 'Arkansas'=>"AR", 'California'=>"CA", 'Colorado'=>"CO", 'Connecticut'=>"CT", 'Delaware'=>"DE", 'District Of Columbia'=>"DC", 'Florida'=>"FL", 'Georgia'=>"GA", 'Hawaii'=>"HI", 'Idaho'=>"ID", 'Illinois'=>"IL", 'Indiana'=>"IN", 'Iowa'=>"IA", 'Kansas'=>"KS", 'Kentucky'=>"KY", 'Louisiana'=>"LA", 'Maine'=>"ME", 'Maryland'=>"MD", 'Massachusetts'=>"MA", 'Michigan'=>"MI", 'Minnesota'=>"MN", 'Mississippi'=>"MS", 'Missouri'=>"MO", 'Montana'=>"MT", 'Nebraska'=>"NE", 'Nevada'=>"NV", 'New Hampshire'=>"NH", 'New Jersey'=>"NJ", 'New Mexico'=>"NM", 'New York'=>"NY", 'North Carolina'=>"NC", 'North Dakota'=>"ND", 'Ohio'=>"OH", 'Oklahoma'=>"OK", 'Oregon'=>"OR", 'Pennsylvania'=>"PA", 'Rhode Island'=>"RI", 'South Carolina'=>"SC", 'South Dakota'=>"SD", 'Tennessee'=>"TN", 'Texas'=>"TX", 'Utah'=>"UT", 'Vermont'=>"VT", 'Virginia'=>"VA", 'Washington'=>"WA", 'West Virginia'=>"WV", 'Wisconsin'=>"WI", 'Wyoming'=>"WY");

?>

<?php if($setting[0]->international_phone_fields == 1){ ?>
      <input type="text" value="<?=$details->state?>" name="state" class="field opreationHoursInput" placeholder="Enter State"/>          
<?php }else{ ?>
<select name="state" id="state" class="field ">

<?php foreach($state_list as $row => $key):?>

<option value="<?=$key?>" <?php if($details->state == $key) echo "selected='selected'"; ?>><?=$row?></option>

<?php endforeach;?>
<?php } ?>
</select>

</div>



</div>
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="opreationHoursDiv adsUrl form-group">
		<h1>Zip Code</h1>

		<input type="text" value="<?=$details->zip?>" name="zip" id="zip" class="field opreationHoursInput contact_form_1 defaultRequired" placeholder="Zip code" maxlength="10" required="required"/>
	</div>
	
	<div class="opreationHoursDiv stateTextbox linkTarget form-group" style="display:none">
	<h1>State</h1>
		<input type="text" value="<?=$details->state?>" name="state_text" class="field opreationHoursInput" placeholder="Enter State"/>        
	</div>
</div>

<div class="form-light-holder   d-md-flex  dual_input">
	<div class="opreationHoursDiv">
	<h1>Phone</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->phone)?>" name="phone" id="phone" class="field opreationHoursInput" placeholder="phone number" maxlength="20"/>
	</div>
</div>


	<?php	if($multi_location == 1){ ?>
		<div class="form-light-holder   d-md-flex  dual_input">
			<div class="opreationHoursDiv adsUrl form-group">
			<h1>Email</h1>
			<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->email)?>" name="email" id="email" class="field opreationHoursInput contact_form_1 defaultRequired" placeholder="email address" required="required"/>
			</div>
			
			<div class="opreationHoursDiv linkTarget form-group">
			<h1>Text Address</h1>
			<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->text_address)?>" name="text_address" id="phone" class="field opreationHoursInput" placeholder="Text Address">
			</div>
		</div>
	<?php } ?>

</div>
<?php 

$social_class = '';
if($multiLoc[11]->field_value == 0){
	if($multiLoc[8]->field_value == 0){
		$social_class = 'display_class';
	}
}

?>
<div class="<?php echo $social_class; ?> defaultType">
<div class="page-section" id="SocialLinks">
<div class="mb-3 main-content-label">Social Links</div>
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
		<h1>Facebook URL</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->fb)?>" name="fb" id="fb" class="field" placeholder="Facebook"/>
	</div>
	<div class="linkTarget form-group">
		<h1>Twitter URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->twitter)?>" name="twitter" id="twitter" class="field" placeholder="twitter"/>
	</div>	
	
</div>

<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Instagram URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->instagram)?>" name="instagram" id="instagram" class="field" placeholder="Instagram"/>
	
	</div>
	<div class="linkTarget form-group">
	<!--<h1>Google Plus URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->gplus)?>" name="gplus" id="gplus" class="field" placeholder="Google Plus"/>-->
	
	<h1>LinkedIn URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->linkedIn)?>" name="linkedIn" id="linkedIn" class="field" placeholder="LinkedIn"/>
	
	</div>	
	
</div>

<!-- DOJO 17/11 -->
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Youtube URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->youtube)?>" name="youtube" id="youtube" class="field" placeholder="Youtube"/>
	</div>
	<div class="linkTarget form-group">
	<h1>Vimeo URL</h1>
		<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->vimeo)?>" name="vimeo" id="vimeo" class="field" placeholder="Vimeo"/>
	
	</div>
	
</div>

<div class="form-light-holder">
	<h1>Yelp URL</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->yelp)?>" name="yelp" id="yelp" class="field" placeholder="Yelp"/>
	
</div>

<div class="form-light-holder   d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Google Reviews</h1>
	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->google_reviews)?>" name="google_reviews" id="google_reviews" class="field" placeholder="Google Reviews"/>
	<br/><em>Only Add Google Place Id</em>
	</div>
	<div class="linkTarget form-group">
	<h1>Facebook Reviews</h1>
		<input type="text" value="<?=$details->facebook_reviews?>" name="facebook_reviews" id="facebook_reviews" class="field" placeholder="Facebook Reviews"/>
	<br/><em>Only Add Facebook Page Url</em>
	</div>
	
</div>

</div>
</div>




<!--<div class="form-light-holder">
	<div class="adsUrl form-group">
	<h1>City Meta Tags  {current_city}</h1>

	<input type="text" value="<?=$details->current_city?>" name="current_city" id="city_meta_tag" class="field contactHalfDivInput" placeholder="Enter street address"/>
	</div>
	
	
	<div class="linkTarget form-group">
		<h1>Current Location Meta Tags {current_location}</h1>

		<input type="text" value="<?=$details->current_location?>" name="current_location" id="current_locaction_meta_tag" class="field contactHalfDivInput" placeholder="Enter Suite"/>
	</div>
	
</div>-->



<!--<div class="form-light-holder">

	<h1>FAX</h1>

	<input type="text" value="<?=$details->fax?>" name="fax" id="fax" class="field" placeholder="fax number" maxlength="13"/>

</div>-->






<?php /*?><?php if($multi_location == 1){ ?>
<div class="form-light-holder">
	<h1>Map Zoom Level</h1>
	<input type="text" value="<?=$details->map_zoom_level?>" name="map_zoom_level" id="map_zoom_level" class="field" placeholder="Enter Map Zoom Level"/>
</div>
<?php 
	} else {
		if($details->main_location == 1){
?>
	<div class="form-light-holder">
	<h1>Map Zoom small map</h1>
	<input type="text" value="<?=$details->map_zoom_level?>" name="map_zoom_level" id="map_zoom_level" class="field" placeholder="Enter Map Zoom Level"/>
	</div>
	<div class="form-light-holder">
		<h1>Map Zoom Level : Single Location</h1>
		<input type="text" value="<?php if($details->single_map_zoom_level != 0){ echo $details->single_map_zoom_level; } else{ echo 14; }?>" name="single_map_zoom_level" id="single_map_zoom_level" class="field" placeholder="Map Zoom Level For Single Location"/>
	</div>
	
<?php } else { ?>
<div class="form-light-holder">
	<h1>Map Zoom Level</h1>
	<input type="text" value="<?=$details->map_zoom_level?>" name="map_zoom_level" id="map_zoom_level" class="field" placeholder="Enter Map Zoom Level"/>
</div>
<?php } } ?><?php */?>


<!--<div class="form-light-holder">
<p class="opreationHoursP">Hours of Operation</p>
	<div class="opreationHoursDiv">
		<h1>Mon-Fri</h1>
	
		<input type="text" value="<?=$details->mon_to_fri?>" name="mon_to_fri" id="" class="opreationHoursInput" placeholder="Enter Hours of Operation from Mon to Fri"/>
	</div>
	<div style="" class="opreationHoursDiv">
		<h1>Saturday</h1>
	
		<input type="text" value="<?=$details->saturday?>" name="saturday" id="" class="opreationHoursInput" placeholder="Enter Hours of Operation on Saturday"/>
	</div>
	<div class="opreationHoursDiv">
		<h1>Sunday</h1>
	
		<input type="text" value="<?=$details->sunday?>" name="sunday" id="" class="opreationHoursInput" placeholder="Enter Hours of Operation on Sunday"/>
	</div>
	
</div>-->
<?php
$hrs = array("01","02","03","04","05","06","07","08","09","10","11","12");
$mins = array("00", "05", "10", "15", "20", "25", "30", "35", "40", "45","50", "55");

$weeksArr = array('monday','tuesday','wednesday','thursday','friday','saturday','sunday'); 
?>
<div class="page-section" id="OperationHours">
<div class="mb-3 main-content-label">Hours of Operation</div>



<?php 
$i = 1;
foreach($weeksArr as $week_day){ ?>

<div class="row row-xs align-items-center mg-b-20  sepraterline defaultType" id="deploy_mirror">
   <div class="col-md-12 mg-t-5 mg-md-t-0">
      <div class="row">
         <div class="col-md-4 checkboxshowhide">
            <label class="ckbox">
            <input type="checkbox" name="ContactTime[<?php echo $week_day ?>][closed]" number="<?= $i ?>" class="close_check_<?= $i ?> checkbox_status_identifier" value="1" <?php if($contact_time[$week_day]->closed == '1'){ echo 'checked="checked"'; } ?>/> <span>Closed
		<input type="hidden" class="allday" name="allday1[]" value="<?=$contact_time[$week_day]->closed ?>" /></span>
            </label><label class="ckbox">
            <input type="checkbox" name="ContactTime[<?php echo $week_day ?>][custom_text_checkbox]" number="<?= $i ?>" class="custom_check_<?= $i ?> custom_text_checkbox" value="1" <?php if($contact_time[$week_day]->custom_text_checkbox == '1'){ echo 'checked="checked"'; } ?>/> <span>Custom</span>
            </label>
            <input type="text" class="form-control" value="<?php echo ucfirst($week_day); ?>" required="" placeholder="Day" style="width:90%">
         </div>
		 
		 <div class="col-md-4 date_box closed_days_<?= $i ?> <?php if($contact_time[$week_day]->closed == 1 || $contact_time[$week_day]->custom_text_checkbox == 1){ echo 'display_none'; } ?>">
            <label style="display:block">Start</label>
            <select type="text" class="date_check<?= $i ?> form-control" name="ContactTime[<?php echo $week_day ?>][start_hour]" >
               <option disabled="disabled">Select Hour </option>
               <?php                 
				 foreach($hrs as $time){
					if($time == $contact_time[$week_day]->start_hour){
						echo "<option value='".$time."' selected='selected'>".$time."</option>";
					} else {
						echo "<option value='".$time."'>".$time."</option>";
					}
				}
				?>
            </select>
            <select type="text" class="date_check<?= $i ?> form-control" name="ContactTime[<?php echo $week_day ?>][start_min]" >
               <option disabled="disabled">Select Min</option>
               <?php                		 
				 foreach($mins as $time){
					if($time == $contact_time[$week_day]->start_min){
						echo "<option value='".$time."' selected='selected'>".$time."</option>";
					} else {
						echo "<option value='".$time."'>".$time."</option>";
					}
				}
				?>
            </select>
            <select type="text" class="date_check<?= $i ?> form-control" name="ContactTime[<?php echo $week_day ?>][start_am_pm]" >
               <option value="AM" <?php echo ($contact_time[$week_day]->start_am_pm == 'AM')?'selected':'';?>>AM</option>
               <option value="PM" <?php echo ($contact_time[$week_day]->start_am_pm == 'PM')?'selected':'';?>>PM</option>
            </select>
         </div>
         <div class="col-md-4 date_box closed_days_<?= $i ?> <?php if($contact_time[$week_day]->closed == 1 || $contact_time[$week_day]->custom_text_checkbox == 1){ echo 'display_none'; } ?>">
            <label style="display:block">End</label>
            <select type="text" class="date_check<?= $i ?> form-control" name="ContactTime[<?php echo $week_day ?>][end_hour]" >
               <option disabled="disabled">Select Hour</option>
               <?php foreach($hrs as $time){
							if($time == $contact_time[$week_day]->end_hour){
								echo "<option value='".$time."' selected='selected'>".$time."</option>";
							} else {
								echo "<option value='".$time."'>".$time."</option>";
							}
				} ?>
            </select>
            <select type="text" class="date_check<?= $i ?> form-control" name="ContactTime[<?php echo $week_day ?>][end_min]" >
               <option disabled="disabled">Select Min</option>
               <?php foreach($mins as $time){
					if($time == $contact_time[$week_day]->end_min){
							echo "<option value='".$time."' selected='selected'>".$time."</option>";
						} else {
							echo "<option value='".$time."'>".$time."</option>";
						}
				} ?>
            </select>
            <select type="text" class="date_check<?= $i ?> form-control" name="ContactTime[<?php echo $week_day ?>][end_am_pm]" >
               <option value="AM" <?php echo ($contact_time[$week_day]->end_am_pm == 'AM')?'selected':'';?>>AM</option>
               <option value="PM" <?php echo ($contact_time[$week_day]->end_am_pm == 'PM')?'selected':'';?>>PM</option>
            </select>
         </div>
		  <div class="col-md-4  custom_text_<?= $i ?>"  style="display:<?php if($contact_time[$week_day]->custom_text_checkbox != '1'){ echo 'none'; } ?>">
			<label>Custom Text</label>
			<input type="text" value="<?php echo $contact_time[$week_day]->custom_text; ?>" name="ContactTime[<?php echo $week_day ?>][custom_text]" class="field form-control"/>
		 </div>
	  </div>
   </div>
</div>
<?php $i++; } ?>

</div>





<script language="javascript">
$(window).load(function(){
	if($('.hidden_cb').val() == 0){
		$('.DetailBox').hide();
	}else{
		$('.DetailBox').show();
	}
});
$(document).ready(function(){
$(".form-light-holder .checkbox").click(function(){
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("0");
		$('.DetailBox').hide();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents(".form-light-holder").children(".hidden_cb").val("1");
		$('.DetailBox').show();
	}
})
})
</script>

<?php
	/*$checkbox_check = 'check-off';
	if(!empty($details->type)){
		if($details->type == 1){
			$checkbox_check = 'check-on';
		}else{
			$checkbox_check = 'check-off';
		}
		
		
	}*/
	
	
?>
<!--<div class="form-light-holder">
	<a id="published" class="checkbox <?php echo $checkbox_check; ?> " ></a>
	<h1 class="inline">RainMaker</h1>
	<input type="hidden" value="<?php if(!empty($details)){ echo $details->type; } else{ echo 0; }?>" name="type" class="hidden_cb" />
</div>-->

<div class="page-section" id="MultiApis">
<div class="mb-3 main-content-label">Multi API's</div>
	
<?php if(!empty($rain_maker)){ ?>
<?php  if($rain_maker[0]->type == 1 && $rain_maker[0]->multi_rainmaker_check == 1){ ?>
	<div class="DetailBox defaultType multi_api_box">
	<div class="form-light-holder  d-md-flex  dual_input">
		<div class="adsUrl form-group">
		<h1>RainMaker School ID</h1>
		<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->s_id); }?>" name="s_id" class="field" placeholder="Enter Your School Id"  />
		</div>
		<div class="linkTarget form-group">
			<h1>RainMaker API Key</h1>
		<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->api_key); }?>" name="api_key" class="field"  placeholder="Enter Your RainMaker API Key"  />
		</div>
	</div>
	
	</div>
<?php } } ?>



<?php if(!empty($perfectmind_api)){ ?>
<?php  if($perfectmind_api[0]->type == 1 && $perfectmind_api[0]->multi_perfectmind_check == 1){ ?>

<div class="DetailBox defaultType multi_api_box">
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Perfectmind Api Access Key</h1>
	<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->perfectmind_access_key); }?>" name="perfectmind_access_key" class="field" placeholder="Enter Your Perfectmind Api Access Key"  />
	</div>
	<div class="linkTarget form-group">
		<h1>Perfectmind Api Client Number</h1>
	<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->perfectmind_client_number); }?>" name="perfectmind_client_number" class="field"  placeholder="Enter Your Perfectmind Api Client Number"  />
	</div>
</div>

</div>
<?php } } ?>


<?php if(!empty($kicksite)){ ?>
<?php  if($kicksite[0]->type == 1 && $kicksite[0]->multi_kicksite_check == 1){ ?>

<div class="DetailBox defaultType multi_api_box">
<div class="form-light-holder  d-md-flex  dual_input">
	<div class="adsUrl form-group">
	<h1>Kicksite URL</h1>
	<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->ks_url); }?>" name="ks_url" class="field" placeholder="Enter Your URL"  /><br/>
	EX: "https://staging.kicksite.net/prospects/new_prospect"
	</div>
	<div class="linkTarget form-group">
		<h1>Kicksite Token</h1>
	<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->ks_token); }?>" name="ks_token" class="field"  placeholder="Enter Your Kicksite Token"  />
	</div>
</div>

</div>
<?php } } ?>

<?php if(!empty($mystudio)){ ?>
<?php  if($mystudio[0]->type == 1 && $mystudio[0]->multi_mystudio_check == 1){ ?>

<div class="DetailBox defaultType multi_api_box">
<div class="form-light-holder">
	<div class="">
	<h1>MyStudio URL</h1>
	<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->ms_url); }?>" name="ms_url" class="field full_width_input" placeholder="Enter Your URL"  /><br/>
	
	</div>
	
</div>

</div>
<?php } } ?>

<?php if(!empty($twilio) && $multi_location == 1){ ?>
<?php  if($twilio[0]->type == 1 && $twilio[0]->multi_twilio_check == 1){ ?>

<div class="DetailBox defaultType multi_api_box">
<div class="form-light-holder">
	<div class="">
	<h1>Twilio Cell Number</h1>
	<input type="text" name="twilio_cell_number" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->twilio_cell_number); }?>" class="field" placeholder="Enter Your Twilio Cell Number"  /><br/>
	
	</div>
	
</div>

</div>
<?php } } ?>

<?php 
	if(!empty($mat_api) && $multi_location == 1){ 
		if($mat_api[0]->type == 1 && $mat_api[0]->multi_mat_check == 1){ 
		
		
			if(!empty($mat_api[0]->url)){ 
			
?>

<script>

 var apiInfo = {                
                baseAddr: "<?php echo $mat_api[0]->url ?>",
                token: ""
            };

            $(function(){

                console.log("authentication");

                doLogin();

            });          

            function doLogin() {

                var loginData = {
                    grant_type: 'password',
                    username: '<?php echo $mat_api[0]->username ?>',
                    password: '<?php echo $mat_api[0]->password ?>'                    
                };

                $.ajax({
                    type: 'POST',
                    url: apiInfo.baseAddr + 'Token',
                    data: loginData
                }).done(function (e) {
                    console.dir(e);
					apiInfo.token = e.access_token;
				//	alert(apiInfo.token);
					// getting categories from map api
					var mat_categories = getCategories();
					 
                }).fail(function (x, s, e) {
                    console.log("error: " + e);
                });
            }
			
			
			function getCategories() {

                var headers = getHeaders();

                $.ajax({
					url: apiInfo.baseAddr + "api/Lookup/Categories?clubId=<?php echo $club_id ?>",
                    headers: headers,
                    type: 'get',
                    dataType: 'json'
					
                }).done(function (e) {
                    console.dir(e);
					$('.map_cat_text').show();
                   // default category
				    var $default_cat_id = $("#default_cat_id");
					var cat_contant = '';
					cat_contant += '<h1>Default Category ID</h1><select class="field" name="default_cat_id"><option value="">-Select MAT Category-</option>';
					var selected_default = "<?php echo (isset($details->default_cat_id)) ? $details->default_cat_id : ''; ?>"
						$.each(e, function(index,data) {
							if(data.id == selected_default){
								cat_contant += '<option value="'+data.id+'" selected="selected">'+data.displayText+'</option>';
							}else{
								cat_contant += '<option value="'+data.id+'">'+data.displayText+'</option>';
							}
						});
						cat_contant += '</select>';	
					$default_cat_id.append(cat_contant);
						
				   
				   // map categories
					var $mat_categories = $("#mat_categories");
					var map_contant = '';
					<?php 
					$selected_cats = (isset($details->map_categories) && !empty($details->map_categories)) ? unserialize($details->map_categories) : '';
					$selectedCatArr = array();
					if(!empty($selected_cats)){
						foreach($selected_cats as $cat){
							$selectedCatArr[$cat['dojo_cat_id']] = $cat['mat_cat_id'];
						}
					}
					
						/*$this->db->select(array('cat_id','cat_name'));
						$this->db->where('published',1);
						$dojo_cats = $this->query_model->getBySpecific('tblcategory','cat_type','programs');*/
						
						$dojo_programs = $this->query_model->getBySpecific('tblprogram','published',1);
						
						if(!empty($dojo_programs)){
							foreach($dojo_programs as $program){
								
								$selected_mat_cat = (isset($selectedCatArr[$program->id]) && !empty($selectedCatArr[$program->id])) ? $selectedCatArr[$program->id] : '';
					?>
					map_contant += "<div class='  d-md-flex  dual_input'><div class='adsUrl  form-group'><input value='<?php echo str_replace("'",'',$program->program); ?>' class='field' type='text'  readonly='readonly'><input value='<?php echo $program->id; ?>' name='mat_cats[<?php echo $program->id; ?>][dojo_cat_id]' class='field' type='hidden'></div>";
					
					
						map_contant += '<div class="linkTarget form-group"><select class="field" name="mat_cats[<?php echo $program->id; ?>][mat_cat_id]"><option value="">-Select MAT Category-</option>';
						$.each(e, function(index,data) {
							if(data.id == '<?php echo $selected_mat_cat ?>'){
								map_contant += '<option value="'+data.id+'" selected="selected">'+data.displayText+'</option>';
							}else{
								map_contant += '<option value="'+data.id+'">'+data.displayText+'</option>';
							}
						});
						map_contant += '</select></div></div>';	
						<?php } } ?>
						
						
						
						$mat_categories.append(map_contant);

                }).fail(function (x, s, e) {

                    console.log("error: " + e);
                });
            }

			
			function getHeaders() {
                
                var headers = {};
                if (apiInfo.token) {
                    headers.Authorization = 'Bearer ' + apiInfo.token;
                }
                return headers;
            }
</script>


<div class="DetailBox defaultType  multi_api_box">

<!--<div class="form-light-holder">
	<h1>Club ID</h1>
	<input type="text" value="<?php if(!empty($details)){ echo $details->club_id; }?>" name="club_id" class="field matFields" placeholder="Enter Your Club ID"  />
</div>-->

<div class="form-light-holder">
<div id="default_cat_id">

</div>	
</div>	
	
<div class="form-light-holder d-md-flex  dual_input">
<div class="map_cat_text 12" style="display:none">
	<div class="adsUrl form-group">
		<h1>Dojo Programs</h1>
		</div>
	<div class="linkTarget form-group">
		<h1>MAT Api Categories</h1>
	</div>
</div>
<div id="mat_categories">

</div>
</div>

</div>
<?php } } } ?>

<?php 
//$multiLocationData = $this->query_model->getbyTable("tblconfigcalendar");

if(!empty($payments) && $multi_location == 1){	?>
<?php  if($payments[0]->stripe_payment == 1 && $payments[0]->multi_stripe_check == 1){ ?>
	<div class="DetailBox defaultType multi_api_box">
	<div class="form-light-holder d-md-flex  dual_input">
		<div class="adsUrl form-group">
		<h1>Stripe Payment Secret Key</h1>
		<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->stripe_secret_key); }?>" name="stripe_secret_key" class="field" placeholder="Enter Your Stripe Payment Secret Key"  />
		</div>
		<div class="linkTarget form-group">
			<h1>Stripe Payment Publishable Key</h1>
		<input type="text" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->stripe_publishable_key); }?>" name="stripe_publishable_key" class="field"  placeholder="Enter Your Stripe Payment Publishable Key"   />
		</div>
	</div>
	
	</div>
<?php } } ?>
</div>

<?php /*if(!empty($active_campaign)){ ?>
<?php  if($active_campaign[0]->type == 1 && $active_campaign[0]->multi_active_campaign_check == 1){ ?>

<div class="DetailBox">
<div class="form-light-holder">
	
	<div class="linkTarget form-group">
		<h1>Active Campaign API Key</h1>
	<input type="text" value="<?php if(!empty($details)){ echo $details->active_campaign_api_key; }?>" name="active_campaign_api_key" class="field"  placeholder="Enter Your Active Campaign API Key"  />
	</div>
</div>

</div>
<?php } } */ ?>

<div class="page-section" id="MapSetting">
<div class="mb-3 main-content-label">Map Setting</div>
<div class="form-light-holder defaultType">
	<h1>Map Zoom Level: Small Map</h1>
	<input type="text" value="<?=$details->map_zoom_level?>" name="map_zoom_level" id="map_zoom_level" class="field" placeholder="Enter Map Zoom Level"/>
</div>
<div class="form-light-holder defaultType">
		<h1>Map Zoom Level : Main Map</h1>
		<input type="text" value="<?php if($details->single_map_zoom_level != 0){ echo $details->single_map_zoom_level; } else{ echo 14; }?>" name="single_map_zoom_level" id="single_map_zoom_level" class="field" placeholder="Map Zoom Level For Single Location"/>
	</div>
</div>

<div class="page-section" id="SeoMeta">
<div class="mb-3 main-content-label">Seo/Meta Details</div>
<div class="form-light-holder">

	<h1>Content</h1>

	<textarea name="content" class="ckeditor" id="mini_editor"><?=$details->content?></textarea>

</div>

<div class="form-light-holder">

	<h1>Meta Title</h1>

	<input type="text" value="<?php echo $this->query_model->getStrReplaceAdmin($details->meta_title)?>" name="meta_title" id="meta_title" class="field full_width_input" placeholder="Meta title" style=""/>

</div>

<div class="form-light-holder">

	<h1>Meta Description</h1>

	<textarea name="meta_desc" id="frm-text"><?php echo $this->query_model->getStrReplaceAdmin($details->meta_desc)?></textarea>

    <p>use following variable to replace relevent values<br />

        {school_name}, {city}, {state}, {city state}, {county}<br />

        {nearby_location1}, {nearby_location2}, <br />

        {main_martial_arts_style}, {martial_arts_style}

    </p>

</div>

<?php if($user_level == 1){ ?>
<div class="form-light-holder">
	<h1>Seo Text</h1>
	<textarea name="seo_text" id="seo_text" class="ckeditor"><?=$details->seo_text?></textarea>
</div>
<?php } ?>

<div class="form-light-holder">
	<h1>Body Id</h1>
	<input type="text" name="body_id" class="field" value="<?php if(!empty($details)){ echo $this->query_model->getStrReplaceAdmin($details->body_id); }?>" style="width:100%">
</div>	
<script language="javascript">

$(document).ready(function(){

$(".form-light-holder .checkbox1").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("0");

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".hidden_cb1").val("1");

	}

})



$(".form-light-holder .checkbox2").click(function(){

	if($(this).hasClass("check-on")){

		$(this).removeClass("check-on");

		$(this).addClass("check-off");

		$(this).parents(".form-light-holder").children(".hidden_cb2").val("0");
		
		$('.defaultType').show();
		$('.defaultRequired').attr('required',true);

	}

	else

	{

		$(this).removeClass("check-off");

		$(this).addClass("check-on");

		$(this).parents(".form-light-holder").children(".hidden_cb2").val("1");
		$('.defaultType').hide();
		$('.defaultRequired').attr('required',false);
	}

})

})

</script>

<?php 
	
	$this->db->select(array('id'));
	$this->db->where('main_location',1);
	$mainLocation = $this->query_model->getByTable('tblcontact');
		
 ?>
<div class="form-light-holder" style="overflow:auto;">
	
	<?php  if($mainLocation[0]->id == $this->uri->segment(4)){ ?>

			<h1 style="padding-bottom: 5px;">Headquarter Picture</h1>
			<div class="custom-file">
	<input type="file" name="userfile" id="customFile1" class="custom-file-input" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($details->photo)): ?>
	<div><img id="img" src="<?=$details->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" id="last-photo" name="last-photo" value="<?=$details->photo;?>" />
	<?php endif;?>
	
		<?php $x = explode('/',$details->photo); ?>
	
<?php } 

else { ?>

	<h1 style="padding-bottom: 5px;">Location Picture</h1>
	<div class="custom-file">
	<input type="file" name="userfile" id="customFile2" class="custom-file-input" accept="image/*" />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	<?php if(!empty($details->photo)): ?>
	<div><img id="img" src="<?=$details->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$details->photo;?>" />
	<?php endif;?>
	
	
		<?php $x = explode('/',$details->photo); ?>
	
	<?php }?>
	
	<?php if(!empty($details->photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img' class='delete_image_btn_new'  location_id=".$details->id.">Delete image</a>";
			}
	?>	
		<div>
		</div>
</div>


<div class="form-light-holder defaultType" style="display:<?php echo ($user_level == 1) ? 'block' : 'none'; ?>">

	<h1>View Larger Map URL</h1>

	<input type="text" value="<?php echo !empty($details)  ? $details->large_map_url : '';?>" name="large_map_url" id="" class="field full_width_input" placeholder="Enter View Larger Map URL"/>

</div>

			</div>		
<div class="form-light-holder posswordBox defaultType" style="display:<?php echo ($multi_student_password['field_value'] == 1) ? 'block' : 'none'; ?>">

	<h1  style="padding-bottom: 5px;">Password</h1>
	<input type="password" class="password" name="password" value="<?php echo !empty($details)  ? $details->p_number : '';?>" />
	<br/>
	<input type="checkbox" class="showPassword">Show Password
</div>



</div>
<div class="form-light-holder">

	<a id="published" class="checkbox1 <?php if($details->published ==1) echo "check-on"; else echo "check-off";?>"></a>

	<h1 class="inline">Publish This</h1>

	<input type="hidden" value="<?=$details->published?>" name="published" class="hidden_cb1" />

</div>
</div>

<!--<div class="form-light-holder">

	<a id="featured" class="checkbox <?php if($details->featured ==1) echo "check-on"; else echo "check-off";?>"></a>

	<h1 class="inline">Feature This</h1>

	<input type="hidden" value="<?=$details->featured?>" name="featured" class="hidden_cb" />

</div>-->


<?php endforeach;?>

<?php endif;?>




		</div>

		</div>

		</div>

	</div>

	</div>

	<!--</div></div></div> -->
	
	<div class="tx-center pd-y-20 bg-gray-200" id="bottom"> 
				
				<input type="submit" name="update" value="Save" class=" save_program_form btn btn-az-primary saveProgramButton" />
				</div>
				</form>
				</div>
				</div>
				
				

			
			</div>
        </div><!-- az-content-body -->
      </div></div>
    </div><!-- az-content -->
</div>
				
			</div>
			
      	
			
     </div>

<br style="clear:both"		 /><br />
<script>
	$(window).load(function(){
		var multiSchool = $('#multiSchool').val();
		$('.school_location_type').hide();
		$('.turn_on_nested_location').hide();
		$('.parent_locations_dropdown').hide();
		$('.parent_locations').attr('required',false);
		if(multiSchool == 1){
			$('.school_location_type').show();
			$('.turn_on_nested_location').show();
			
			if($('.hidden_cb2').val() == 0){
				$('.defaultRequired').attr('required',true);
			}else{
				$('.defaultRequired').attr('required',false);
			}
			
			
			
			if($('.school_location_type').val() == "nested"){
				$('.turn_on_nested_location').hide();
				$('.parent_locations_dropdown').show();
				$('.hidden_cb2').val(0);
				$('.parent_locations').attr('required',true);
			}else if($('.school_location_type').val() == "default"){
				$('.turn_on_nested_location').show();
				$('.parent_locations_dropdown').hide();
			}
		}
		
		
		if($('.multi_api_box').length == 0){
			$('#MultiApis').hide();
			$('.tab_multi_api').hide();
		}
	
	})

	$(document).ready(function(){
		$('.showPassword').click(function(){
			if($(this).prop('checked')){
				$('.password').get(0).type = 'text';
			}else{
				$('.password').get(0).type = 'password';
			}
		})
		
		$('.school_location_type').change(function(){
			if($(this).val() == "nested"){
				$('.turn_on_nested_location').hide();
				$('.parent_locations_dropdown').show();
				$('.hidden_cb2').val(0);
				$('.parent_locations').attr('required',true);
			}else if($(this).val() == "default"){
				$('.turn_on_nested_location').show();
				$('.parent_locations_dropdown').hide();
				$('.parent_locations').attr('required',false);
			}
			
		});
	});
</script>

<!-- recent items -->
<input type="hidden" value="<?php echo $multiSchool ?>" id="multiSchool">
<?php $this->load->view("admin/include/footer");?>

<script>

	
	 new PerfectScrollbar('#azContactList', {
	  suppressScrollX: true
	});
		
		
	 var nav = $('.az-content-left-contacts');

    $(window).scroll(function () {
        if ($(this).scrollTop() > 125) {
            nav.addClass("f-nav");
        } else {
            nav.removeClass("f-nav");
        }
    });
	
	$('.az-contact-item').on('click touch', function() {
		$('body').addClass('az-content-body-show');
	}) 


	$('.az-contact-item').on('click touch', function() {
		var selected_href = $(this).attr('href');
		setTimeout(function() {
			
			$.each($('.az-contact-item'), function(){
				//alert(selected_href+'==>'+$(this).attr('href'));
				if($(this).attr('href') == selected_href){
					$(this).addClass('selected');
				}else{
					$(this).removeClass('selected');
				}
			})
		}, 1000);
	});
	

</script>

