			
		<li class="sidebar_contact">
			
			<ul class="contact_info">
			
			<?php if(!empty($contact) && (count($contact)==1)) { ?>
			<?php foreach($contact as $contact) :?>
				<li>
					<p class="location"><?=$contact->name?></p>
					<?php if(isset($contact->suite) && !empty($contact->suite)):
					?>
					<p class="address"><?=$contact->address." $contact->suite".", ".$contact->city.", ".$contact->state.", ".$contact->zip;?></p>
					<?php else: ?>
						<p class="address"><?=$contact->address." ".$contact->city.", ".$contact->state.", ".$contact->zip;?></p>
					<?php endif;?>                    
						
					<?php if(!empty($contact->phone)): ?><p class="phone"><b>Phone:</b> <?=$contact->phone?></p><?php endif;?>
					<?php if(!empty($contact->fax)): ?><p class="fax"><b>Fax:</b> <?=$contact->fax?></p><?php endif;?>
					<div class="map">
					<?php
							// First, setup the variables you will use on your <iframe> code
							// Your Iframe will need a Width and Height set
							// as well as the address you plan to Iframe
							// Don't forget to get a Google Maps API key

							$latitude = '';
							$longitude = '';
							$iframe_width = '100%';
							$iframe_height = '241px';
							//$address = $add;
							$address = $contact->address.', '.$contact->city.' '.$contact->state.', '.$contact->zip;
							
							$address = urlencode($address);
							//$key = "AIzaSyBe2tFzAHIHhp0iKTz4aV5G8D1e0fLOJBY";
							//$url = "http://maps.google.com/maps/geo?q=".$address."&output=json&key=".$key;
							$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";

							$ch = curl_init();

							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_HEADER,0);
							curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
							// Comment out the line below if you receive an error on certain hosts that have security restrictions
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

							$data = curl_exec($ch);
							curl_close($ch);

							$geo_json = json_decode($data, true);

							// Uncomment the line below to see the full output from the API request
							//var_dump($geo_json);

							// If the Json request was successful (status 200) proceed
							//if ($geo_json['Status']['code'] == '200') {
							if ($geo_json['status'] == 'OK') {	
							//$latitude = $geo_json['Placemark'][0]['Point']['coordinates'][0];
							//$longitude = $geo_json['Placemark'][0]['Point']['coordinates'][1];
							 
							//for new api calling method
							//$latitude = $geo_json['results'][0]['geometry']['location']['lat'];
							//$longitude = $geo_json['results'][0]['geometry']['location']['lng']; 

							?>
							<iframe width="<?php echo $iframe_width; ?>" height="<?php echo $iframe_height; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $address; ?>&amp;aq=0&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo $address; ?>&amp;t=m&amp;ll=<?php echo $longitude; ?>,<?php echo $latitude; ?>&amp;z=12&amp;iwloc=&amp;output=embed"></iframe>

							<?php

							} else { echo "<p>No Address Available</p>";}

							?>
					</div>
					
				</li>
			<?php endforeach;?>
			<?php } else { 
				if(isset($location)) 
				{
					foreach($contact as $contact) :
					 if(strtolower($location) == strtolower($contact->name)) {
				?>
					<li>
					<p class="location"><?=$contact->name?></p>
					<?php if(isset($contact->suite) && !empty($contact->suite)):
					?>
					<p class="address"><?=$contact->address." $contact->suite".", ".$contact->city.", ".$contact->state.", ".$contact->zip;?></p>
					<?php else: ?>
						<p class="address"><?=$contact->address.", ".$contact->city.", ".$contact->state.", ".$contact->zip;?></p>
					<?php endif;?>
					<?php $add = $contact->address.", ".$contact->state; ?>	
					<?php if(!empty($contact->phone)): ?><p class="phone"><b>Phone:</b> <?=$contact->phone?></p><?php endif;?>
					<?php if(!empty($contact->fax)): ?><p class="fax"><b>Fax:</b> <?=$contact->fax?></p><?php endif;?>                    
                    
					<div class="map">
					<?php
							// First, setup the variables you will use on your <iframe> code
							// Your Iframe will need a Width and Height set
							// as well as the address you plan to Iframe
							// Don't forget to get a Google Maps API key

							$latitude = '';
							$longitude = '';
							$iframe_width = '100%';
							$iframe_height = '241px';
							$address = $contact->address.', '.$contact->city.' '.$contact->state.', '.$contact->zip;

							$address = urlencode($address);
							//$key = "AIzaSyBe2tFzAHIHhp0iKTz4aV5G8D1e0fLOJBY";
							//$url = "http://maps.google.com/maps/geo?q=".$address."&output=json&key=".$key;
							$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$address&sensor=false";

							$ch = curl_init();

							curl_setopt($ch, CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_HEADER,0);
							curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
							// Comment out the line below if you receive an error on certain hosts that have security restrictions
							curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

							$data = curl_exec($ch);
							curl_close($ch);

							$geo_json = json_decode($data, true);

							// Uncomment the line below to see the full output from the API request
							//var_dump($geo_json);

							// If the Json request was successful (status 200) proceed
							//if ($geo_json['Status']['code'] == '200') {
							if ($geo_json['status'] == 'OK') {	
							//$latitude = $geo_json['Placemark'][0]['Point']['coordinates'][0];
							//$longitude = $geo_json['Placemark'][0]['Point']['coordinates'][1];
							 
							//for new api calling method
							//$latitude = $geo_json['results'][0]['geometry']['location']['lat'];
							//$longitude = $geo_json['results'][0]['geometry']['location']['lng']; 

							?>
							<iframe width="<?php echo $iframe_width; ?>" height="<?php echo $iframe_height; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=<?php echo $address; ?>&amp;aq=0&amp;ie=UTF8&amp;hq=&amp;hnear=<?php echo $address; ?>&amp;t=m&amp;ll=<?php echo $longitude; ?>,<?php echo $latitude; ?>&amp;z=12&amp;iwloc=&amp;output=embed"></iframe>

							<?php

							} else { echo "<p>No Address Available</p>";}

							?>
					</div>
				</li>
			<?php 
					}
					endforeach;
				}
			} ?>
				<!-- END .contact -->
				
			
				
			</ul>
			<!-- END .contact_info -->
			
		</li>
		<!-- END .sidebar_contact -->
<script language="javascript">
jQuery(document).ready(function(){

		$("#location_list").change(function(){
				$("#select_location_form").submit();
			});
	});
</script>	
