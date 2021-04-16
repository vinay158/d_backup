<?php if($site_setting[0]->calender_layout == "embed_calender"){ ?>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<?php } ?>
<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		
	
		CKEDITOR.replace(  'ckeditor_full',
									{  customConfig : 'config.js' }
						);
				
	});
</script>
<script language="javascript">
$(window).load(function(){
	var calender_layout = $('.calender_layout').val();
	$('.embed_calendar_code').hide();
	$('.calender_listing').show();
	$('.categories-opts').show();
	if(calender_layout == "embed_calender"){
		$('.embed_calendar_code').show();
		$('.calender_listing').hide();
		$('.categories-opts').hide();
	}
})

$(document).ready(function(){
$("#form-light-holder .checkbox").click(function(){
	var multi_calendar = '';
	if($(this).hasClass("check-on")){
		$(this).removeClass("check-on");
		$(this).addClass("check-off");
		$(this).parents("#form-light-holder").children(".hidden_cb").val("0");
		multi_calendar = $(".hidden_cb").val();
	}
	else
	{
		$(this).removeClass("check-off");
		$(this).addClass("check-on");
		$(this).parents("#form-light-holder").children(".hidden_cb").val("1");
		multi_calendar = $(".hidden_cb").val();
	}
	$.ajax({ 					
					type: 'POST',						
					url: 'admin/calendar/update_multicalendar',
					data: { multi_calendar :  multi_calendar}					
				}).done(function(msg){
					alert(msg); 
				});
	
})


$('.calender_layout').change(function(){
	
	var calender_layout = $(this).val();
	$('.embed_calendar_code').hide();
	$('.calender_listing').show();
	$('.categories-opts').show();
	if(calender_layout == "embed_calender"){
		$('.embed_calendar_code').show();
		$('.calender_listing').hide();
		$('.categories-opts').hide();
	}
})

})
</script>



<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?=$title?> Manager</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
	  


<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		
		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">
<div class="mb-3 main-content-label page_main_heading"><?=$title?> Manager</div>

					<form action="<?=base_url()?>admin/offers/editStudentPageTitle" method="post">

					<div class="form-light-holder">
					    	<span class="field_title">Calendar Head Title</span><br />
					       <input type="text" name="title" required="" value="<?= !empty($page_title)? $page_title[0]->title:''; ?>" class="field full_width_input" style="" />&nbsp;
					       <input type="hidden" name="id" value="3"  />
					       <input type="hidden" name="redirect" value="admin/calendar/view" />
					</div>

					
					<div class="form-light-holder">
					<h1>Calendar Layout</h1>
						<select name="calender_layout" class="calender_layout field">
							<option value="default_calender" <?php echo (isset($site_setting[0]->calender_layout) && $site_setting[0]->calender_layout == "default_calender") ? 'selected=selected' : ''; ?>>Dojo Default Calendar</option>
							<option value="embed_calender"  <?php echo (isset($site_setting[0]->calender_layout) && $site_setting[0]->calender_layout == "embed_calender") ? 'selected=selected' : ''; ?>>Embed Calendar Code</option>
						</select>
					</div>

					<div class="form-light-holder embed_calendar_code" style="display:none">
						<h1>Description</h1>
						<textarea name="embed_calendar_code"  id="ckeditor_full" class="ckeditor" ><?php echo isset($site_setting[0]->embed_calendar_code) ? $site_setting[0]->embed_calendar_code : ''; ?></textarea>
					</div>
					
					<div class="form-new-holder">
					    	<input type="submit" name="update" value="Update" class="btn-save" />
					</div>

					</form>

			</div>

		</div>

		</div>

	</div>

	</div>


					<div class="calender_listing">
					<!-- category items -->
					<?php $this->load->view("admin/include/category-calendar");?>
					<!--  End category items -->
						<div class="manager-items">
							<div id="content-replace">
							   	<h1 id="breadcrumbs"></h1>
								<!--<div class="btn-addentry add_entry_button" style="margin-top: -5%; margin-right: 10px"><a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>">Add Calendar Event</a></div>-->
								<div style="font-style:italic;font-size:11px;margin:12px 20px;">
                                	<!-- changelog v2 - modify text -->
									Special Events and Closed Days will be shown on the Upcoming Events widget at the top of the website, as well as on the calendar
								</div>
								<?php 
								 if($this->session->userdata("user_level") == 1) {
										$is_master_admin = true;
									} else {
										$is_master_admin = false;	
									}
									
									/*if(isset($location_data) && count($location_data) > 1 && $multi_calendar->field_value == 1 && $is_master_admin){									
									?>
								<div id="form-light-holder">
									<h1 class="inline">Multi-Calendar</h1>
									<a id="published" class="checkbox <?php if($multi_calendar->field_value ==1) echo "check-on"; else echo "check-off";?>" style="margin-left: 100px;margin-top: -33px;"></a>
									<input type="hidden" value="<?=$multi_calendar->field_value?>" id="multi-calendar" class="hidden_cb" />
								</div>
								<?php } */ ?>
								<!--  
								<ul id="blog-items" class="cat_sort ui-sortable2" style="">
								-->
								
								
								
								<ul id="blog-items" class="cat_sort cat_sort_w66" style="">
								<?php 
								
								
								$sr_calendar=0; 
								if(!empty($blogs)): $counter = 0;?>
                       			<?php foreach($blogs as $brow):
								//pre($brow);
									$multi_check = $this->default_db->getall('tbl_calendar_dates', array('event_id'=>$brow['id']));
                       				$sr_calendar++;                       				
                       			?>
                       			
                       			<?php $counter++; ?>
									<li id="menu_<?=$brow['id'];?>">
										<div class="manager-item">
											<div style="float:left;">
												<!-- <h2><?=$brow['id']; ?></h2> -->
												<h2><?=$sr_calendar?></h2>
                                                
                                                <?php
													$repeat = $brow['repeat'];
													$day = '';
													if($repeat == 'Every week'){
														$day = date('l', strtotime($brow['mydate']));
													}else if($repeat == 'never'){
														$repeat = 'No Repeat';
													}
													elseif($repeat == 'daily'){
														$repeat = '';
													}
												?>
                                                
												<h1 style="margin-top:6px;">
												<a href="admin/<?=$link_type?>/edit/<?=$brow['id'].'/view/'.$this->uri->segment(4)?>">
												<?=character_limiter($brow['title'], 35);?></a> <?php echo ($repeat!='')?'':'';?> 
												
												<?php 
												echo ''.$repeat.' '.$day?>
												
												<?php

													$conf = $this->db->get_where('tblconfigcalendar',array('field_name'=>'multi_calendar'))->row_array();

													$locations = $this->db->get_where('tblcontact')->result_array();
												
												?>

												<?php if($conf['field_value'] == 1):?>
													
													<?php //if(array_key_exists('location',$_GET) AND $_GET['location'] != ''):?>
														<?php $location = $this->db->get_where('tblcontact',array('id'=>$brow['location_id']))->row_array(); 
															
													?>
														<?php
															if(!empty($location['name'])){
																echo '&nbsp; ('.$location['name'].')';
															}
														?>
													<?php //endif; ?>
												<?php endif; ?>
												</h1>
											</div>
											<div class="manager-item-opts">	
                                            <?php
												
												if($brow['is_multiple'] == 1){
													// pre($multi_check);
													// exit;
													//d2muna
													if(count($multi_check) > 1){
														echo 'Multiple Dates';
													}else{
														if(!empty($multi_check) && isset($multi_check[0])){
															if($multi_check[0]['isWhole'] == 1){
																echo 'All Day ';
															}
															
															if($multi_check[0]['repeat'] == 'never'){
																echo date_format(date_create($multi_check[0]['date']), 'F d, Y').' ';
															}else{													
	
																if($multi_check[0]['repeat'] == 'Every year'){
																	echo 'Every Year - '.date_format(date_create($multi_check[0]['date']), 'M jS').
																			' '.$multi_check[0]['start'].' - '.$multi_check[0]['end'];
																}else{
																	if($multi_check[0]['isWhole'] != 1)
																		echo $multi_check[0]['start'].' - '.$multi_check[0]['end'];
																}
	
															}
														}
													}
													
												}else{
													if($brow['isWhole'] == 1){
														echo 'All Day ';
													}
													
													if($brow['repeat'] == 'never'){
														echo date_format(date_create($brow['mydate']), 'F d, Y').' ';
														if( !empty( $brow['start'] &&  $brow['end'] ) ){
															echo $brow['start'] .' - '. $brow['end'];
														}
														else{
															echo "";
														}
														
													}else{													

														if($brow['repeat'] == 'Every year'){
															echo 'Every Year - '.date_format(date_create($brow['mydate']), 'M jS').
																	' '.$brow['start'].' - '.$brow['end'];
														}else{
															if($brow['isWhole'] != 1)
																echo $brow['start'].' - '.$brow['end'];
														}

													}
												}
												
											?>
                                            
                                            
											<?php //date_format(date_create($brow['mydate']), 'F d, Y H:m A')?>
                                            <?php											
												if($this->uri->segment(4) != 22 || $this->uri->segment(4) != 52){	// changelog v2 Remove exceptions from events and closed day that don't repeat
													if($brow['repeat'] == 'Every year' || $brow['repeat'] == 'Every week'){	// exceptions will only show for year and week
											?>
                                            <a href="admin/calendar/exception/<?=$brow['id'].'/view/'.$this->uri->segment(4)?>"  class="lb-preview">Exception</a>
                                            <?php 	}
												} ?>
											<a href="admin/calendar/edit/<?=$brow['id'].'/view/'.$this->uri->segment(4)?>"  class="lb-preview">Edit</a>											
											<input type="hidden" name="mod_type" value="<?=$title;?>" id="mod_type" />
											
											<?php if($brow['published'] == 1){?>
											<a id="unpub_<?=$brow['id']; ?>" class="unpublish" title="Unpublish <?=$brow['title'];?>">Unpublish</a>
											<input type="hidden" name="publish_type" value="0" class="publish_type" />
											<?php }else{ ?>
											<input type="hidden" name="publish_type" value="1" class="publish_type" />
											<a id="unpub_<?=$brow['id']; ?>" class="unpublish" title="Publish <?=$brow['title'];?>">Publish</a>
											<?php }?>
											
											<a id="delitem_<?=$brow['id']; ?>" class="delete_item" title="Delete <?=$brow['title'];?>">Delete</a></div>
										</div>
									</li>
								
								<?php endforeach;?>
								<?php else : ?>
										
										<div class="empty"><a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>" class="nothing-yet">Add an Entry to this Category</a></div>
								<?php endif;?>
								
								</ul>
								
								<style>
									.ActivePageNumber{
										border:1px solid #444444;
									border-radius:3px;
									-moz-border-radius:3px;
									-webkit-border-radius:3px;
									padding:4px 9px 1px;
									 text-decoration: none;
									 background:#444444;
									 color:#FFFFFF;
									 
									}
									
									
									.startPagination > a
									{
									border:1px solid #444444;
									border-radius:3px;
									-moz-border-radius:3px;
									-webkit-border-radius:3px;
									padding:6px 9px 6px 9px;
									 text-decoration: none;
									 color:#444444;
									 
									 
									}
									
									.startPagination > a
									{
									padding-bottom:1px;
									}
									
									.startPagination{ float:right; height:27px; margin-top: 15px;} /** DOJO 16/11 **/
								</style>
								<span class="startPagination">
								<?php  echo $paginglinks;?>
								<span style="font-style:italic;font-size:11px;margin:12px 20px;">
										<?php 							
											if($config['page'] != 1){
												$startRecord = ($config['page'] - 1) * $config['per_page'];
												$endRecord = $config['page']  * $config['per_page'];
												
												if($config['total_rows'] < $endRecord){
													if(($startRecord+1) != $config['total_rows']){
														echo 'Displaying '.($startRecord+1).' - '.$config['total_rows'].' of '.$config['total_rows'];
													} else {
														echo 'Displaying '.($startRecord+1).' of '.$config['total_rows'];
													}
												}else{
													echo 'Displaying '.($startRecord+1).' - '.$endRecord.' of '.$config['total_rows'];
												}
											} else{
												$endRecord = $config['per_page'];
												if($config['per_page'] < $config['total_rows']){
													echo 'Displaying 1'.' - '.$endRecord.' of '.$config['total_rows'];
												}
												
											}
										?>
							</span>
						</span>	
						
						
								<script language="javascript">
								$(document).ready(function(){
									var breadcrumbs = $(".categories-holder .active").children(".show-entries").text();
									var numItems = <?php echo isset($counter)?$counter:0; ?>;
									$("#breadcrumbs").html(breadcrumbs+"<span>"+numItems+"&nbsp;Entries</span>  <a href='admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>' class='button_class'>Add Calendar Event</a>");
									if(numItems>0)
										$(".ti_item_start").html(numItems);
									else
										$(".ti_item_start").html("0");
									$(".ti_item_end").html(numItems);
								});
								</script>
								
							</div>
							
							
										
										
						</div>	
						</div>	
					</div>
					
					<?php $this->load->view("admin/include/conf_delete_item"); ?>
<script language="javascript">
$(document).ready(function(){
	var mod_type1 = $("#mod_type").val().toLowerCase();
	
$(".unpublish").click(function(){
	var pub_id = $(this).attr("id").substr(6);
	var mod_type = $("#mod_type").val().toLowerCase();
	//alert(mod_type); return false;
	var publish_type = $(this).parents(".manager-item-opts").children(".publish_type").val();
	//alert (publish_type);
	$.ajax({ 					
	type: 'POST',						
	url: 'admin/'+mod_type+'/publish',						
	data: { pub_id : pub_id, publish_type: publish_type }					
	}).done(function(msg){ 
	if(msg != null){
	//alert(msg);
	setTimeout("window.location.reload()",1000);
	}
	else{
	setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
	//alert(msg);
	}
	});
	//exit(0);
});

$(".delete_item").click(function(){
	//alert('delete clicked');
	var del_item_id = $(this).attr("id").substr(8);
	//alert(del_item_id);
	$("#delete-item-id").val(del_item_id);
	$(".delete-holder-item").hide();
	$(".delete-holder-item").slideDown(300);
	//exit(0);
});


$("#sortcats").click(function(){												
	
	$(this).hide();
	$("#finishedsorting").show();
	$(".categories-link").each(function(){
		//$(this).children("span").empty();
		$(this).children("").addClass("handle");
		$(this).children("span").children("a").css("visibility", "hidden");
	});
	return true;
	
	});
	
	
	$("#finishedsorting").click(function(){											
	$(this).hide();											
	$("#sortcats").show();											
	$(".categories-link").each(function(){
	//$(this).children("span").empty();
	$(this).children("span").removeClass("handle");
	$(this).children("span").children("a").css("visibility", "visible");
	});
	window.location.reload();					
	
	});
})
</script>
                                                                
	<script language="javascript">
		$(document).ready(function(){
		
		$(".close-btn").click(function(){
		$("#dropdown-holder").slideUp(200);
		$(".delete-holder").slideUp(200);	
		});
		});
	</script>
					<div class="categories-opts">
					<script language="javascript">
					/*$(document).ready(function(){
						$("#addcats").click(function(){
						$("#dropdown-holder").hide();
						$(".delete-holder").hide();	
						$("#dropdown-holder").slideDown(200);
						$(".drop-add-title").html("Add Category");
						$("#cat_title").val("");
						$(".sef_title").html("");
						$("#shared").removeClass("check-on");
						$("#shared").addClass("check-off");
						$("#shared-id").val(0);
						$("#operation").val("add");
						$(".btn-delete").hide();
						});
					});*/
					</script>
					
						<a href="javascript:void(0)" class="button_class btn btn-indigo  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tblcategory" form_type="full_width_row">Add New</a><?php #if(count($cat) <= 20): ?><?php #endif;?>
						
						
						<div class="btn-sortcats" id="sortcats"><a></a></div>
						<div class="btn-finishedsorting" id="finishedsorting" style="display:none;"><a></a></div>
					</div>
					
					<!---- DOJO 16/11 ---->
					<!--<div class="manager-nav" id="nav-updater">
						<div id="paginator" style="float:left;">
							<div class="btn-navleftarrow">
									<div class="pagination-prev"><a href="" class="ti_prev disabled"></a></div>
							</div>
							<div class="btn-navrightarrow">
									<div class="pagination-next"><a href="" class="ti_next disabled"></a></div>
							</div>
							<div id="paginator_links" class="ti_numbers"><span class="ti_number_current">1</span></div>
						</div>
						<div id="paginator-msg" style="padding-top:5px;float:right;">
							Showing <span class="ti_item_start"></span>-<span class="ti_item_end"></span>
						</div>
					</div>-->

				
		

</div>
</div>
</div>
</div>
	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
	<!------- include modal for category ----------->
	<?php //$this->load->view("admin/include/cat-modal-calendar"); ?>
	<!--------- end modal for category -------------->
	
	<!------- include modal for category ----------->
	<?php $this->load->view("admin/include/confirmation-modal"); ?>
	<!--------- end modal for category -------------->
	
	
	<script type="text/javascript">
	jQuery(document).ready(function($){

		
		
		/********************** new code for popup *********************/
$('body').on('click','.delete_item', function(){
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var item_title = $(this).attr('item_title');
		var section_type = $(this).attr('section_type');
		
		$('#popupDeleteItem').find('.modal-title').html(item_title);
		$('#popupDeleteItem').find('#delete_item_id').val(item_id);
		$('#popupDeleteItem').find('#delete_item_table_name').val(table_name);
		$('#popupDeleteItem').find('#delete_item_section_type').val(section_type);
	})
	
	
 	$('body').on('click','.popup_delete_btn', function(){
		
		
		var formData = $('#popupDeleteItem').find('form').serialize();
		var form_action = $('#popupDeleteItem').find('form').attr('action');
		var item_id = $('#popupDeleteItem').find('#delete_item_id').val();
		var section_type = $('#popupDeleteItem').find('#delete_item_section_type').val();
		//alert('.'+section_type+'_'+item_id); return false;
		
		
		$.ajax({ 					
			type: 'POST',						
			url: form_action,						
			data: { formData : formData}					
			}).done(function(msg){ 
			if(msg == 1){
				
				setTimeout("window.location.href='admin/calendar/view/22'",1000);	
				
				/*var form_type = 'full_width_row';
				if(section_type == "little_row"){
					var form_type = "little_row";
				}
				
				var total_record = $('.total_alternating_'+form_type).html();
				//alert(section_type+'==>'+form_type+'==>'+'.total_alternating_'+form_type+'==>'+total_record); return false;
				total_record = parseInt(total_record) - 1; 
				$('.total_alternating_'+form_type).html(total_record);
				
				
				
				$('.'+form_type+'_'+item_id).remove();
				
				$('#popupDeleteItem').find('.close').trigger('click');*/
				
				
				/*$('#popupDeleteItem').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully deleted!');
				setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);*/
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	
	
	$('body').on('click','.full_alternate_popup', function(){
		
		var action_type = $(this).attr('action_type');
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var form_type = $(this).attr('form_type');
		//fullAlternatePopup
		
		$('#fullAlternatePopup').find('.modal-title').html(action_type + ': Calendar Category');
		
		$.ajax({

				url : 'admin/calendar/ajax_full_alternate_popup',
				type : 'POST',
				data :{action_type : action_type, item_id : item_id,table_name:table_name,form_type:form_type},
				success:function(data){
					
					$('#form_alternate_popup').html(data);
					
				}

		});
		
		
			
	})
	
	$('body').on('keyup','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('change','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('click','.save_full_row_add_btn', function(){
		
		var published = $('.required_mapping_fields_checkbox').attr('checkbox_value');
		
		$('.form_error_msg').hide();
		var error = 0;
		$.each($('.required_field'),function(){
			var check = $(this).val();
			if(check == '') {
				$(this).css('border','1px solid red');
				error = 1;
			}
		})
		
		if(error == 0){
			
			var formData = $('#fullAlternateAddForm').serialize();
			
			$.ajax({ 					
				type: 'POST',						
				url : 'admin/calendar/ajax_save_full_alternate_row',
				dataType : 'json',
				data: { formData : formData, published: published}					
				}).done(function(data){ 
				
				if(data.res == 1){
					
					setTimeout("window.location.href='admin/calendar/view/"+data.id+"'",1000);	
					
					/*if(data.form_action == "add"){
						
						var form_type = data.form_type;
						var total_numbers = $('.alternating_'+form_type+' li').length;
						var new_number = 1;
						if(new_number > 0){
							new_number = parseInt(total_numbers) + 1;
						}
						
						var total_record = $('.total_alternating_'+form_type).html();
						total_record = parseInt(total_record) + 1; 
						$('.total_alternating_'+form_type).html(total_record);
						
						$('.alternating_'+form_type).append('<li id="menu_'+data.id+'" class="'+form_type+'_'+data.id+'   az-contact-info-header ui-sortable-handle "><div class="manager-item media"><div style="float:left;"><div class="badge-no">. '+new_number+'</div><h4 class="'+form_type+'_heading_'+data.id+'"><a href="javascript:void(0)">'+data.title+'</a></h4></div><div class="manager-item-opts"><nav class="nav"><a href="javascript:void(0)" class="badge badge-primary  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="'+data.id+'" table_name="'+data.table_name+'" form_type="'+form_type+'">Edit</a><a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="'+data.id+'" table_name="'+data.table_name+'" item_title="'+data.title+'" section_type="'+form_type+'">Delete</a><a href="javascript:void(0)" id="unpub_'+data.id+'" class="sections_unpublish" table_name="'+data.table_name+'" is_new="1"><div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn on" publish_type="0"><span></span><input type="hidden" name="publish_type" value="0" class="publish_type"></div></a></nav></div></div></li>');
						
						
						$('#fullAlternatePopup').find('.close').trigger('click');
						//$('#fullAlternatePopup').modal('hide');
						
						//$('#responsePopup').find('.action_response_msg').html('Successfully added!');
					}else{
						var item_id = data.id;
						var form_type = data.form_type;
						//alert('.'+form_type+'_heading_'+item_id); return false;
						$('.'+form_type+'_heading_'+item_id).find('a').html(data.title );
						
						
						$('#fullAlternatePopup').find('.close').trigger('click');
						//$('#fullAlternatePopup').modal('hide');
						
						//$('#responsePopup').find('.action_response_msg').html('Successfully updated!');
					
					}*/
					
					//$('#responsePopup').modal('show');
					//setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
					
				}
			});
			
		}else{
			$('.form_error_msg').show();
		}
		
			
	})
	
	
	$("body").on('click','.sections_unpublish',function(){
		//alert('adsfdasf');
		var pub_id = $(this).attr("id").substr(6);
		var mod_type = $("#mod_type").val().toLowerCase();
		var table_name = $(this).attr('table_name');
		var is_new = $(this).attr('is_new');
		var publish_type = $(this).children(".toogle_btn").attr('publish_type');
		//alert(pub_id+'=>'+mod_type+'=>'+table_name+'=>'+is_new+'=>'+publish_type); return false;
		var updated_type = 1;
		if(publish_type == 1){
			updated_type = 0;
		}
		
		
		if(is_new == 1){
			if(updated_type == 1){
				$(this).find('.az-toggle').removeClass('on');
			}else{
				$(this).find('.az-toggle').addClass('on');
			}
		}
		
		$(this).children(".toogle_btn").attr('publish_type',updated_type); 
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/ajaxPublishWebhookApi',						
		data: { pub_id : pub_id, publish_type: publish_type,table_name: table_name }					
		}).done(function(msg){ 
		if(msg == 1){
			
		}
		else{
		//setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
		//alert(msg);
		}
		});
		
	});

	});
</script>
	
	<div id="fullAlternatePopup" class="modal calendar_cat_form_popup">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form id="fullAlternateAddForm" action="" method="post" enctype="multipart/form-data">
		  <div id="form_alternate_popup"></div>
		  
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	 <div id="popupDeleteItem" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="admin/calendar/ajax_delete_popup_record" method="post" id="deleteForm">
          <div class="modal-body edit-form">
             <div class="row row-xs align-items-center delete_popup_text_block">
					<div class="col-md-12 mg-t-5 mg-md-t-0 text-center">
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						<h2 class="heading">Are you sure?</h2>
						<h5 class="subheading">You will not be able to recover the deleted record.</h5>
					</div>
				</div>
				<input type="hidden" name="delete-item-id" id="delete_item_id" value="">
				<input type="hidden" name="table_name" id="delete_item_table_name" value="">
				<input type="hidden"  id="delete_item_section_type" value="">
          </div>
          <div class="modal-footer">
			  <div class="col-md-6 text-left">
				<a href="javascript:void(0)" class="btn btn-indigo popup_cancel_btn" data-dismiss="modal">No, cancel please !</a>
			  </div>
			   <div class="col-md-6 text-right">
				<a href="javascript:void(0)" class="btn btn-indigo popup_delete_btn">Yes, Delete It !</a>
			   </div>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->