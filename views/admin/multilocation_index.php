<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<script language="javascript">
$(document).ready(function(){
$("#form-light-holder .checkbox").click(function(){
	
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#form-light-holder").children("#multi-location").val("0");
		$(this).parents("#form-light-holder").children("#multi-facility").val("0");
		$(this).parents("#form-light-holder").children("#multi-staff").val("0");
		$(this).parents("#form-light-holder").children("#location-display").val("0");
		$(this).parents("#form-light-holder").children("#multi-calendar").val("0");
		$(this).parents("#form-light-holder").children("#multi-map").val("0");
		
		$(this).parents("#form-light-holder").children("#multi-social-icons").val("0");
		$(this).parents("#form-light-holder").children("#multi-social-feeds").val("0");
		$(this).parents("#form-light-holder").children("#multi-trial-offers").val("0");
		$(this).parents("#form-light-holder").children("#multi-unique-trial-offers").val("0");
		$(this).parents("#form-light-holder").children("#multi-schools").val("0");
		$(this).parents("#form-light-holder").children("#multi-webhook").val("0");
		$(this).parents("#form-light-holder").children("#multi-student-password").val("0");
		
		
	}
	else
	{
		
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#form-light-holder").children("#multi-location").val("1");
		$(this).parents("#form-light-holder").children("#multi-facility").val("1");
		$(this).parents("#form-light-holder").children("#multi-staff").val("1");
		$(this).parents("#form-light-holder").children("#location-display").val("1");
		$(this).parents("#form-light-holder").children("#multi-calendar").val("1");
		$(this).parents("#form-light-holder").children("#multi-map").val("1");
		
		$(this).parents("#form-light-holder").children("#multi-social-icons").val("1");
		$(this).parents("#form-light-holder").children("#multi-social-feeds").val("1");
		$(this).parents("#form-light-holder").children("#multi-trial-offers").val("1");
		$(this).parents("#form-light-holder").children("#multi-unique-trial-offers").val("1");
		$(this).parents("#form-light-holder").children("#multi-schools").val("1");
		$(this).parents("#form-light-holder").children("#multi-webhook").val("1");
		$(this).parents("#form-light-holder").children("#multi-student-password").val("1");
		
		if($(this).attr('id') == "multi-trial-offers-checkbox"){
			$('#multi-unique-trial-offers-checkbox').removeClass('check-on');
			$('#multi-unique-trial-offers-checkbox').addClass('check-off');
			$('#multi-unique-trial-offers').val('0');
		}else if($(this).attr('id') == "multi-unique-trial-offers-checkbox"){
			$('#multi-trial-offers-checkbox').removeClass('check-on');
			$('#multi-trial-offers-checkbox').addClass('check-off');
			$('#multi-trial-offers').val('0');
		}
		
		var ele_id = ($(this).attr('id'));
		
		var map = $("#multi-map").val();
		var calendar = $("#multi-calendar").val();		

		
		if(ele_id == 'multi-map-button' && map == 1){
			$("#multi-calendar").val('0')
			$("#multi-calendar-button").removeClass("check-on");
			$("#multi-calendar-button").addClass("check-off");
		}
		
		if(ele_id == 'multi-calendar-button' && calendar == 1){
			$("#multi-map").val('0')
			$("#multi-map-button").removeClass("check-on");
			$("#multi-map-button").addClass("check-off");
		}
	}
	
	/*var map = $("#multi-map").val();
	var location = $("#multi-location").val();
	
	if(map == 1){
		$("#multi-location").val('0');
		$("#multi-location").removeClass("check-on");
		$("#multi-location").addClass("check-off");		
	}
	
	if(location == 1){
		$("#multi-map").val('0');
		$("#multi-map").removeClass("check-on");
		$("#multi-map").addClass("check-off");		
	}
	
	alert('map '+map+' location '+location);*/
})

	
$("#btn_save").click(function(){
		student_section = $("#multi-map").val();
		multi_calendar = $("#multi-calendar").val();
		multi_location = $("#multi-location").val();
		multi_facility = $("#multi-facility").val();
		multi_staff = $("#multi-staff").val();		
		location_display = $("#location-display").val(); 
		location_position = $("#location_position").val();
		
		multi_social_icon = $("#multi-social-icons").val();
		multi_social_feeds = $("#multi-social-feeds").val();
		multi_trial_offers = $("#multi-trial-offers").val();
		multi_unique_trial_offers = $("#multi-unique-trial-offers").val();
		multi_schools = $("#multi-schools").val();
		multi_webhook = $("#multi-webhook").val();
		multi_student_password = $("#multi-student-password").val();
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/multilocation/set_multicalendar',
		data: { student_section :  student_section, multi_location :  multi_location, multi_facility :  multi_facility, multi_staff :  multi_staff, location_display: location_display, location_position: location_position, multi_calendar: multi_calendar,multi_social_icon:multi_social_icon,multi_social_feeds:multi_social_feeds,multi_trial_offers:multi_trial_offers,multi_schools:multi_schools,multi_webhook:multi_webhook,multi_unique_trial_offers:multi_unique_trial_offers,multi_student_password:multi_student_password}
			}).done(function(msg){				
				window.location.reload();
			});
	});
})
</script>

<div class="az-content-body-left custom_full_page multilocation_page advanced_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Multi-location Manager</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
	  
	  
	  
<!----- Include Blog Panel Body ---------------->
	<div class="gen-holder">
		<div class="gen-panel">
			
			<div class="panel-body">
				<div class="panel-body-holder">
					<div class="manager-items custom">						
                         
                         <div class="border floatNone" style="margin-top: 10px;float: none !important;">   
							<div id="form-light-holder">
								
								<a id="multi-location-button" class="checkbox <?php if($multi_location == 1) echo "check-on"; else echo "check-off";?>"></a>
								<input type="hidden" value="<?=$multi_location?>" id="multi-location" class="hidden_cb" name="multi_location" />
								<h1 class="inline">Multi-Location</h1>
								
							</div>
						</div>
                        
                        <?php
							if($multi_location == 1) {
						?>
                        
                        <!--<div class="border" style="margin-top: 10px;">                        	
                            <div id="form-light-holder">
								<h1 class="inline">Multi Location Map : </h1>
								<a id="multi-map-button" class="checkbox <?php if($multi_map == 1) echo "check-on"; else echo "check-off";?>" style="margin-left: 140px;margin-top: -33px;"></a>
								<input type="hidden" value="<?=$multi_map?>" id="multi-map" class="hidden_cb" name="multi_map" />
								
							</div>                         
                         </div>-->
                         
                        <div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="multi-calendar-button" class="checkbox <?php if($multi_calendar == 1) echo "check-on"; else echo "check-off";?>" ></a>
								<input type="hidden" value="<?=$multi_calendar?>" id="multi-calendar" class="hidden_cb" name="multi_calendar" />	
								<h1 class="inline">Multi Calendar</h1>								
							</div>
						</div>
                        
                        <div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="published" class="checkbox <?php if($multi_facility == 1) echo "check-on"; else echo "check-off";?>"></a>
								<input type="hidden" value="<?=$multi_facility?>" id="multi-facility" class="hidden_cb" name="multi_facility" />	
								<h1 class="inline">Multi About</h1>
							</div>
						</div>
                       
                       <div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="published" class="checkbox <?php if($multi_staff == 1) echo "check-on"; else echo "check-off";?>"></a>
								<input type="hidden" value="<?=$multi_staff?>" id="multi-staff" class="hidden_cb" name="multi_staff" />	
								<h1 class="inline">Multi Staff</h1>								
							</div>
						</div>
						
						
						 <div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="multi-calendar-button" class="checkbox <?php if($multi_social_icon == 1) echo "check-on"; else echo "check-off";?>" ></a>
								<input type="hidden" value="<?=$multi_social_icon?>" id="multi-social-icons" class="hidden_cb" name="multi_social_icon" />	
								<h1 class="inline">Multi-Social Icons</h1>								
							</div>
						</div>
						
						
						 <div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="multi-calendar-button" class="checkbox <?php if($multi_social_feeds == 1) echo "check-on"; else echo "check-off";?>"></a>
								<input type="hidden" value="<?=$multi_social_feeds?>" id="multi-social-feeds" class="hidden_cb" name="multi_social_feeds" />
								<h1 class="inline">Multi-Social Feeds</h1>								
							</div>
						</div>
						
						<div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="multi-trial-offers-checkbox" class="checkbox <?php if($multi_trial_offers == 1) echo "check-on"; else echo "check-off";?>"></a>
								<input type="hidden" value="<?=$multi_trial_offers?>" id="multi-trial-offers" class="hidden_cb" name="multi_trial_offers" />	
								<h1 class="inline">Multi-Trial Offers</h1>								
							</div>
						</div>
						
						
						<div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="multi-unique-trial-offers-checkbox" class="checkbox <?php if($multi_unique_trial_offers == 1) echo "check-on"; else echo "check-off";?>" ></a>
								<input type="hidden" value="<?=$multi_unique_trial_offers?>" id="multi-unique-trial-offers" class="hidden_cb" name="multi_unique_trial_offers" />	
								<h1 class="inline">Multi-Unique Trial Offers</h1>								
							</div>
						</div>
						
						
						<!--<div class="border" style="margin-top: 10px;">                        	
                            <div id="form-light-holder">
								<h1 class="inline">Student Section :</h1>
								<a id="multi-map-button" class="checkbox <?php if($student_section == 1) echo "check-on"; else echo "check-off";?>" style="margin-left: 140px;margin-top: -33px;"></a>
								<input type="hidden" value="<?=$student_section?>" id="multi-map" class="hidden_cb" name="student_section" />
								
							</div>                         
                         </div>-->
						 
                        
						
                        <!-- <div class="border" style="margin-top: 10px;">
							<div id="form-light-holder">
								<h1 class="inline">Location Display Position : </h1>
								<a id="published" class="checkbox <?php if($location_display == 1) echo "check-on"; else echo "check-off";?>" style="margin-left: 170px;margin-top: -33px;"></a>
								<input type="hidden" value="<?=$location_display?>" id="location-display" class="hidden_cb" name="location_display" />								
							</div>
						</div>-->
						
						<div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="multi-school-button" class="checkbox <?php if($multi_schools == 1) echo "check-on"; else echo "check-off";?>"></a>
								<input type="hidden" value="<?=$multi_schools?>" id="multi-schools" class="hidden_cb" name="multi_schools" />	
								<h1 class="inline">Multi-Location with Map (for 2+ locations)</h1>
							</div>
						</div>
						
						
						<div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="multi-webhook-button" class="checkbox <?php if($multi_webhook == 1) echo "check-on"; else echo "check-off";?>" ></a>
								<input type="hidden" value="<?=$multi_schools?>" id="multi-webhook" class="hidden_cb" name="multi_webhook" />	
									<h1 class="inline">Multi-Webhook</h1>
							</div>
						</div>
						
                        
							<?php
                                if($location_display == 1) {
                            ?>
                            <div class="border floatNone" style="margin-top: 10px;float: none  !important;">
                                <div id="form-light-holder">
                                    <h1 class="inline">Location Position : </h1>
                                    <select name="location_position" style="float:left; margin-left: 135px; margin-top: -33px" id="location_position">
                                        <option value="top" <?php echo ($location_position == 'top') ? 'selected="selected"' : ''; ?> >Top Bar</option>
                                        <option value="header" <?php echo ($location_position == 'header') ? 'selected="selected"' : ''; ?>>Header</option>
                                    </select>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
							
							
							<div class="border floatNone" style="margin-top: 10px;float: none !important;">
							<div id="form-light-holder">
								
								<a id="multi-student-password-button" class="checkbox <?php if($multi_student_password == 1) echo "check-on"; else echo "check-off";?>" ></a>
								<input type="hidden" value="<?=$multi_student_password?>" id="multi-student-password" class="hidden_cb" name="multi_student_password" />	
									<h1 class="inline">Multi-Student Password</h1>
							</div>
						</div>
                        
                        <?php
							}
						?>
                        
                        
                        
                        <input type="submit" id="btn_save" value="Save" class="btn-save" style="float:left;margin-top:15px;" />
                        
					</div>
				</div>
			</div>
		</div>		
	</div>
	
</div>
</div>
</div>
</div>
<!--------- end of include --------------->

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
