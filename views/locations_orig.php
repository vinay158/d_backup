<?php $this->load->view('includes/header'); ?>

<?php

$_URL = array();
$query = $this->db->get( 'tblmeta' );
$result = $query->result();
foreach( $result as $row )
{
	if(!empty($row->slug) && !empty($row->page)) {
		$_URL[trim($row->slug)] = trim($row->page);
	}
}

$_SLUG = array('ourschool', 'ourfacility', 'ourstaff' , 'ourphilosophy', 'schoolrules', 'schoolrules', 'faq', 'events', 'news', 'videogallery','photogallery', 'ourprograms', 'birthdayparties', 'specialoffers', 'contactus', 'testimonials' , 'signin', 'locations');

foreach($_SLUG as $needle) {
	$slug = array_search($needle, $_URL);
	if($slug == false) { $$needle = $needle; } 
	else { $$needle = $slug; } 
}

?>

<body class="inside_page two_column left_sidebar sidebar_wide">



<?php  $this->load->view('includes/header/masthead'); ?>
<style>
.gm-style .gm-style-iw{
	color: #000;
}
#map_canvas img { 
	max-width:none;
	 }
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
$(document).ready(function() {
	
var geocoder;
var map;
//var image = '//az12497.vo.msecnd.net/4652d5c30d92487890544d254c5bd947/publicImages/glovemap-blue.png';
var image = '<?=base_url()?>img/red@2x.png';
var markersArray = [];
var mapIcon = {
	url: image,
	size: new google.maps.Size( 48,70 ), //original format
	scaledSize: new google.maps.Size( 24,35 ), //retina format
	//origin: new google.maps.Point( 0,0 ),  
	//anchor: new google.maps.Point( 12,35 )
};
	
//var address;
function initialize() {

	geocoder = new google.maps.Geocoder();
	// var latlng = new google.maps.LatLng(39.8282,-98.5795);
	// var latlng = new google.maps.LatLng(0, 0);
	var myOptions = {
	  zoom: 4,
	 // center: latlng,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	
	map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
	map.setCenter(new google.maps.LatLng(39.8282,-98.5795));
	//var bounds = new google.maps.LatLngBounds();


<?php
	//while($row = mysql_fetch_array($result)){
		foreach($contactlocations as $location){
			
			$address = $location->address.' , '.$location->city.', '.$location->state.', '.$location->zip;
			
			$facility_slug = '';
			$query = $this->db->get_where('tblfacilities', array('location_id' => $location->id));
			if($query->num_rows() > 0){
				$result = $query->result();
				$facility_slug = $result[0]->slug;	
				//echo '<br>facility_slug: '.$facility_slug;
			}
			
			
?>
				geocoder.geocode( { 'address': "<?php  echo $address; ?>"}, function(results, status) {
				  if (status == google.maps.GeocoderStatus.OK) {
					//map.setCenter(results[0].geometry.location);
					var marker = new google.maps.Marker({
						map: map, 
						position: results[0].geometry.location,
						//icon: image
						icon: mapIcon
					});
					
					 /* Store the marker for later use */
    				markersArray.push( marker );
				
					var contentString = '<div style="width: 200px; height: 200px; line-height:19px;"><strong><?=$location->name; ?></strong><br/>'+
										  '<?php echo $location->address?><br/>'+
										  '<?=$location->city?>, <?=$location->state?> '+
										  '<?=$location->zip?><br/>'+
										  '<p><strong>Phone:</strong> <?=$location->phone?></p>';
					
					<?php
						if($facility_slug){
					?>
							contentString += '<br><a href="<?=$ourfacility.'/'.$facility_slug?>">More Info</a>';
					<?php		
						}
					?>
					
					contentString += '<br><a href="javascript:void(0)" id="<?=$location->id?>" class="contact_location">Contact this location  &gt;&gt;</a>';
										  
					var infowindow = new google.maps.InfoWindow({
						  content: contentString
					});
					
				  	google.maps.event.addListener(marker, 'click', function() {
					  
						infowindow.open(map,marker);
						
						$(".contact_location").bind('click', function() {
						  // alert("A click happened");
						  
						  var base_url = '<?=base_url()?>';
						  var location_id = $(this).attr('id');
						  
						  // alert('location_id: '+location_id+' base url '+base_url);
						  
						   $.ajax({
							  url: base_url+'locations/getlocationdata/'+location_id,			  
							  dataType: 'json',
							  success: function(data) {
								// alert(data.name+'\n'+data.content);
								 
								 $('#location_name').empty();
								 $('#location_name').html(data.name);
								 
								 $('.page_content').empty();
								 $('.page_content').html(data.content);
								 
								 $('#form_school_2 option[value="' + data.name + '"]').prop('selected', true); // set dropdown value
								 
								 $('#uniform-form_school_2 span').html(data.name); // show dropdown value
								 
								 // alert(data.name);
								 
								 $('#form_school_2').val(data.name);
								 
							  },
							  type: 'GET'
						   });
						  
						});
						
					});
					
				  <?php sleep(1); ?>
				  } else {
				
					alert("Geocode was not successful for the following reason: " + status);
					//setTimeout("wait = true", 2000);
				  }
			});
<?php } ?>

	// fitBounds();
}

function codeAddress(x)
{
	var address = x;
	//alert(x);
	geocoder.geocode( { 'address': address}, function(results, status)	{
		if (status == google.maps.GeocoderStatus.OK){
			
			//alert('location: '+results[0].geometry.location);
			
			map.setCenter(results[0].geometry.location);
			map.setZoom(13);
		}else{
			alert("Geocode was not successful for the following reason: " + status);
		}
	});
}

/* Zoom the map so that all markers fit in the window */
function fitBounds() {
    var i, markerLen, 
		maxZoom = 12,
		bounds = new google.maps.LatLngBounds();

    /* Make sure we don't zoom to far */
    google.maps.event.addListenerOnce( map, "bounds_changed", function( event ) {
		if ( this.getZoom() > maxZoom ) {
			this.setZoom( maxZoom );
		}
    });

    for ( i = 0, markerLen = markersArray.length; i < markerLen; i++ ) {
		bounds.extend ( markersArray[i].position );
    }

    map.fitBounds( bounds );
}

google.maps.event.addDomListener(window, 'load', initialize);


	
      $(".contact_location").click(function(e){
		  e.preventDefault();
		  var base_url = '<?=base_url()?>';
		  var location_id = $(this).attr('id');
		  
		 // alert('location_id: '+location_id+' base url '+base_url);
		  
		  $.ajax({
			  url: base_url+'locations/getlocationdata/'+location_id,			  
			  dataType: 'json',
			  success: function(data) {
				// alert(data.name+'\n'+data.content);
				 
				 $('#location_name').empty();
				 $('#location_name').html(data.name);
				 
				 $('.page_content').empty();
				 $('.page_content').html(data.content);
				 
				 $('#form_school_2 option[value="' + data.name + '"]').prop('selected', true); // set dropdown value
				 
				 $('#uniform-form_school_2 span').html(data.name); // show dropdown value
				 
				 // alert(data.name);
				 
				 $('#form_school_2').val(data.name);
				 
			  },
			  type: 'GET'
		   });
          
      });
   });

</script>
        
<?php

		$pageURL = base_url();
		 
		$query = $this->db->get_where('tblconfigcalendar', array('field_name' => 'multi_location'));
		$result = $query->result();
		$multi_location = $result[0]->field_value;

	?>

<div class="main container clearfix">
	

	<!-- END .sidebar .vertical -->

	

	<div class="main_content light" id="top">

        <div id="google-map">
			<p id="map-search">
				<input type="zipsearch" id="search" name="zipsearch" placeholder="Enter Zip Code"  onFocus="if (this.value=='Enter Zip Code') this.value = ''" onBlur="if (this.value=='') this.value = 'Enter Zip Code'" value="Enter Zip Code">
				<input type="button" name="submit" id="submit" value="Submit" class="zip-search-go" onClick="codeAddress(document.getElementById('search').value)">
			</p>
			
            <div id="map_canvas" style="width: 870px; height: 400px;"></div>
    
		</div>
    
        <div class="content_container">
        
            <div id="list-text-area" class="left">
                <?php
               // echo '<pre>'; print_r($contactlocations); echo '</pre>';
			   
			   $start = 0;
               $first_location = '';
               foreach($contactlocations as $location){
					
					$facility_slug = '';
					$query = $this->db->get_where('tblfacilities', array('location_id' => $location->id));
					
					if($start == 0){
						$first_location = $location;
						$start++;
					}
					
					//echo '<br>location: '.$location->id;
					
					if($query->num_rows() > 0){
						$result = $query->result();
						$facility_slug = $result[0]->slug;	
						//echo '<br>facility_slug: '.$facility_slug;
					}
					
					$staff_slug = '';
					$this->db->select('tblstaff.id, tblstaff.name, tblcontact.id as location_id, tblcontact.name as location, , tblcontact.slug');
					$this->db->from('tblstaff');
					$this->db->join('tblcontact', 'tblcontact.id = tblstaff.location_id', 'left');
					$this->db->group_by('tblcontact.id');
					$this->db->where('tblstaff.published', 1);
					$this->db->where('tblstaff.location_id', $location->id);
					
					$query = $this->db->get();
					
					if($query->num_rows() > 0){
						$result = $query->result();
						$staff_slug = $result[0]->slug;	
						//echo '<br>staff_slug: '.$staff_slug;
					}
					
		
                ?>
                    <div class="list-text-item">
                        <h2 class="list-text-title"><?=$location->name?></h2>
                        <p><?php echo $location->address.' , '.$location->city.', '.$location->state.', '.$location->zip?></p>
                        <p><strong>Phone:</strong> <?=$location->phone?></p>
                        <ul>
                        	<?php
								if(!empty($facility_slug)){
									echo '<li><a href="'.$ourfacility.'/'.$facility_slug.'">More Info</a></li>';
								}
								
								/*if(!empty($staff_slug)){
									//echo '<li><a href="'.$ourstaff.'/'.$staff_slug.'">Contact this location  &gt;&gt;</a></li>';
									echo '<li><a href="javascript:void(0)" id="'.$location->id.'" class="contact_location">Contact this location  &gt;&gt;</a></li>';
								}*/
								
								echo '<li><a href="javascript:void(0)" id="'.$location->id.'" class="contact_location">Contact this location  &gt;&gt;</a></li>';
								
							?>                            
                        </ul>
                    </div>
                
                <?php	
                }
                ?>
            
            </div>
            
            <div id="contact-area" class="right">

                <h1 style="font-size:30px;"><span id="location_name"><?=$first_location->name?></span></h1>		 
    
                <span class="page_content"><?=$first_location->content?></span>		
    
                <form method="post" class="contact_form content_contact_form" action="locations/send">
                
                	<input type="hidden" name="hid_location" value="" />		
                
                    <div class="message">
                        <div id="alert"></div>
                    </div>
    
                    <!-- END .message -->
    
                    <ul class="form_fields">
                        <li class="clearfix">
                            <label class="form_name_2">Name</label>                            
                            <input type="text" name="name" id="form_name_2" />
    
                        </li>
    
    
                        <li class="clearfix">
                            <label class="form_phone_2">Phone</label>
                            <input type="text" onKeyPress="return numbersonly(event)" id="form_phone_2" class="phone_1" maxlength="3" name="phone1">
                            <input type="text" onKeyPress="return numbersonly(event)" class="phone_2" maxlength="3" name="phone2">
                            <input type="text" onKeyPress="return numbersonly(event)" class="phone_3" maxlength="4" name="phone3">
                        </li>
    
                        <li class="clearfix">
                            <label class="form_email_2">Email</label>
                            <input type="text" id="form_email_2" name="form_email_2">
                        </li>
                                        
                        <li class="clearfix">
                            <label class="form_school_2">School</label>
                            <!-- <div class="selector" id="uniform-form_school_2"> -->
                            	<select id="form_school_2" name="school" style="opacity: 0;">
                                <?php
									foreach($contactlocations as $location){
										echo '<option value="'.$location->name.'">'.$location->name.'</option>';
									}
								?>
                            </select><!-- </div> -->
                        </li>
    
                        <li class="clearfix">
                            <label class="form_message_2">Message</label>
                            <textarea id="form_message_2" name="message"></textarea>
                        </li>
    
                        <li class="clearfix last">
                            <input type="hidden" style="display:none" class="submit button" id="email" name="email" value="">			
                            <input type="text" autocomplete="off" style="display:none" name="website" id="website">	
                            <input type="submit" class="submit button" value="Submit">
                            <input type="reset" class="reset button" value="Reset">
                        </li>		
    
                    </ul>
    
                    <!-- END .form_fields -->
    
                </form>
                <!-- END #contact_form -->	
            </div>
        
        </div>
	</div>

	<!-- END .main_content -->

	

</div>

<script language="javascript">

		function numbersonly(evnt)

		{

		var unicode=evnt.charCode? evnt.charCode : evnt.keyCode

		if (unicode<=46||unicode>57 || unicode==47){	

		if(unicode == 8 || unicode == 9)

		return true;

		else

		return false;

		}	

		}

		$(document).ready(function(){

		

		var emailfilter=/^\w+[\+\.\w-]*@([\w-]+\.)*\w+[\w-]*\.([a-z]{2,4}|\d+)$/i;

		var cl = '';

		$(".content_contact_form").submit(function(){

			var err = 0;

			/*$(".content_contact_form label").each(function(){

				$(this).css("color", "#FFF05D");

			});*/

			

			if($("#form_name_2").val().length == 0){

				err = 1;

				cl = $("#form_name_2").attr("id");

				$("."+cl).css("color", "red");

				

			}

			

			if($("#form_email_2").val().length == 0 || emailfilter.test($("#form_email_2").val()) == false){

				err = 1;

				cl = $("#form_email_2").attr("id");

				$("."+cl).css("color", "red");

				

			}



			

			

			if($("#form_message_2").val().length == 0 ){

				err = 1;

				cl = $("#form_message_2").attr("id");

				$("."+cl).css("color", "red");

				

			}			

			if($("#form_school_2").val() == 0 ){

				err = 1;

				cl = $("#form_school_2").attr("id");

				$("."+cl).css("color", "red");

				

			}			

						

			if( eval(err) == 1 ){

				$(".message #alert").html("<b>Please fill in the contact form correctly.</b>");

				$(".message").fadeIn(300);

				//event.preventDefault();

				//exit(0);				

				return false;

			}



			

		});

		});

		</script>
        
<!-- .main .container -->



<?php $this->load->view('includes/footer'); ?> 
