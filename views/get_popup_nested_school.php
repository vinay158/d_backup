
<?php 

if($is_nested_main == 1){
	if($site_settings[0]->override_logo == 1){
				if($site_settings[0]->override_nav_bar_logo != 1)
				{
				
				$footer_logo = $this->query_model->getbySpecific('tbloverride_logos','s_no', $site_settings[0]->override_nav_bar_logo);
				
					if(!empty($footer_logo)){
					
						$nav_bar_logo = base_url().'upload/override_logos/'.$footer_logo[0]->logos;
						$nav_bar_logo_alt = $footer_logo[0]->logo_alt;
			
					} else{ 
						$nav_bar_logo = $site_settings[0]->sitelogo;
						$nav_bar_logo_alt = $site_settings[0]->logo_alt;
				
					}
			} else{
				$nav_bar_logo = $site_settings[0]->sitelogo;
				$nav_bar_logo_alt = $site_settings[0]->logo_alt;
			
				 } 
			} else{ 
				$nav_bar_logo = $site_settings[0]->sitelogo;
				$nav_bar_logo_alt = $site_settings[0]->logo_alt;
		 }	
?>

<aside class="schoolNestedLocations active">
	<div class="bgImagePop">
		<div class="bgImagePopOverlay"></div>
	</div>
	<div class="schoolNestedLocations_zone">
		<a href="<?php echo base_url(); ?>" class="schoolNestedLocations_logo">
			<img src="<?=$nav_bar_logo?>" alt="<?=$nav_bar_logo_alt?>">
		</a>
		<h3>
                        Choose your <strong>nearest location</strong><br>
                        <span class="line2">to see <strong>available training options and Programs</strong><br></span>
                        
                    </h3>
		<div class="schoolListing">
		<?php 
			if(isset($nested_child_locations) && !empty($nested_child_locations)){
				foreach($nested_child_locations as $child_location){
		?>
			<div class="schoolListing_item">
				<a href="<?php echo base_url().$school_slug->slug.'/'.$child_location->slug; ?>">
					<div class="circleImage"> <span class="hoverState" >
                                            <em></em>
                                            <span></span>
						
						<img src="<?php echo base_url().'images/200x200_map.jpg'; ?>" alt="<?php echo $child_location->name; ?>">
						</span>
					</div>
					<h4><?php echo $child_location->name; ?></h4>
					<em><?php echo $child_location->city ?>  <?php echo $child_location->zip ?></em>
				</a>
			</div>
			<?php } } ?>
		</div>
	</div>
</aside>

<?php } ?>