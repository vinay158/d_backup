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
</div>
</div>
</div>
</div>
</div>

 <div class="az-content-body-left advanced_page" >

       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 program-cat-page program_lisiting_page">
				<div class="container">
	  
	  
        
    <div class="az-content az-content-app az-content-contacts pd-b-0">
      <div class="container">
	  
        <div class="az-content-left az-content-left-contacts">


         <div class="az-mail-header">
            <div>
              <h4 class="az-content-title mg-b-5">CATEGORIES</h4>
            </div>
			<div>
			<nav class="pull-right">
			<a href="javascript:void(0)" class="button_class badge-primary badge  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tblcategory" form_type="little_row">Add New Category</a>
			</nav></div>
            
          </div>

         <!-- <div id="azContactList" class="az-contacts-list"> -->
		 <div id="" class="az-contacts-list">
			
			<?php //$this->load->view("admin/include/category-calendar");?>
			<?php

	$conf = $this->db->get_where('tblconfigcalendar',array('field_name'=>'multi_calendar'))->row_array();
	
	$locations = $this->db->get_where('tblcontact',array('published'=>1))->result_array();
?>

<?php /*if($conf['field_value'] == 1):?>

<div >
	
	<?php
		$g = $_GET;
	?>
	
	<form action="<?php echo base_url();?>admin/calendar/view/<?php echo $this->uri->segment(4);?>" method="GET" id="loc_form" >
		<div class="form-light-holder">
			<select name="location" id="loc_selector" class="field">
			<option value="">Show All Locations </option>
			<?php foreach($locations as $i=>$item):?>
				<option value="<?php echo $item['id'];?>" <?php echo (array_key_exists('location',$g) AND $g['location'] == $item['id'])?'selected':'';?>><?php echo $item['name'];?></option>	
			<?php endforeach; ?>
			</select>
		</div>
	</form>

</div>

<script type="text/javascript">
	$(document).ready(function(){
		
		$('#loc_selector').change(function(){
		
			$('#loc_form').submit();
			
		});
		
	});
</script>


<?php endif;*/ ?>

			
			<ul class="cat_sort ui-sortable alternating_little_row" style="">
			
		  <?php 
				if(isset($cat)):
				
					foreach($cat as $cat): 
					
					$exclude_sortable = '';
					if($cat->cat_id == 22 || $cat->cat_id == 52) : 
							$exclude_sortable = '';
					endif;
				
				$is_editable = 1;
				if($cat->cat_id == 22 OR $cat->cat_id == 52){
					$is_editable = 0;
				}
				
			?>
			<li   id="menu_<?=$cat->cat_id?>" class="az-contact-item <?php if($this->uri->segment(4) == $cat->cat_id || $category_detail[0]->cat_id == $cat->cat_id) { echo "selected"; } ?>  little_row_<?=$cat->cat_id;?> ">
            
              <div class="az-contact-body ">
               <a href="admin/<?=$link_type?>/view/<?=$cat->cat_id?>" id ="cat<?=$cat->cat_id?>" > <h6 class="little_row_heading_<?=$cat->cat_id?>"><?=$cat->cat_name?></h6></a>
              </div><!-- az-contact-body -->
			  <?php if($is_editable == 1){ ?>
				  <nav>
				  <a href="javascript:void(0)" class="badge-primary badge full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$cat->cat_id?>"  table_name="tblcategory" form_type="little_row">Edit</a>
				  
				  <a class="badge-primary badge delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$cat->cat_id?>"   table_name="tblcategory" item_title="<?=$cat->cat_name?>" section_type="little_row">Delete</a>
				 
				 </nav>
			  <?php } ?>
			
            <?php 
					//} 
				endforeach;
			 endif; 
			?>
			</ul>
          </div><!-- az-contacts-list -->

        </div> <!-- az-content-left -->
				
			<div class="az-content-body az-content-body-contacts ">
				
							
<div class="program_full_detail page-section new_lisiting_block " id="AlternatingFullWidth">
				
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								
								<div>
								  <h4 class="az-content-title mg-b-5"><?php echo !empty($category_detail) ? $category_detail[0]->cat_name : ''; ?></h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($blogs) ? count($blogs) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>" class="button_class btn btn-indigo" >Add Calendar Event</a>
								</div>
							  </div>
							  
							<ul class="cat_sort_1 ui-sortable2 alternating_full_width_row calender_listing" style="">

							<?php 
								
								
								$sr_calendar=0; 
								if(!empty($blogs)): $counter = 0;?>
                       			<?php foreach($blogs as $brow):
								//pre($brow);
									$multi_check = $this->default_db->getall('tbl_calendar_dates', array('event_id'=>$brow['id']));
                       				$sr_calendar++;                       				
                       			?>
								<?php $counter++; ?>

									<li   id="menu_<?=$brow['id']?>" class="full_width_row_<?=$brow['id']?> az-contact-info-header">
										<div class="manager-item media">
											<div style="float:left;">
												<div class="badge-no"><?=$sr_calendar?>. </div>
												
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
												
												<h4 class="full_width_row_heading_<?=$brow['id']?>"><a href="javascript:void(0)" ><?=character_limiter($brow['title'], 35);?></a>
												
												<p class="extra_heading">
												<?php echo ($repeat!='')?'':'';?> 
												
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
												
											?></p>
											
												</h4>
											</div>
											<div class="manager-item-opts">
											
											
										<nav class="nav">
											 
												<?php											
													if($this->uri->segment(4) != 22 || $this->uri->segment(4) != 52){	// changelog v2 Remove exceptions from events and closed day that don't repeat
														if($brow['repeat'] == 'Every year' || $brow['repeat'] == 'Every week'){	// exceptions will only show for year and week
												?>
												<a href="admin/calendar/exception/<?=$brow['id'].'/view/'.$this->uri->segment(4)?>"  class="badge badge-primary">Exception</a>
												<?php 	}
												} ?>
												
													
												<a href="admin/calendar/edit/<?=$brow['id'].'/view/'.$this->uri->segment(4)?>" class="badge badge-primary" >Edit</a>
											  
											
												<a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$brow['id'];?>"   table_name="tblcalendar" item_title="<?=$brow['title'];?>" category_id="<?=$brow['id'];?>" section_type="full_width">Delete</a>
													
												
													
												<a href="javascript:void(0)" id="unpub_<?=$brow['id']; ?>" class="sections_unpublish"  table_name="tblcalendar"  is_new="0">
												<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($brow['published'] == 1) ? 'on' : '';?>" publish_type="<?php echo ($brow['published'] == 1) ? 0 : 1;?>"><span></span>
												<input type="hidden" name="publish_type" value="<?php echo ($brow['published'] == 1) ? 0 : 1;?>" class="publish_type" />
												</div></a> 
										</nav>
			
			
			
											</div>
										</div>
									</li>
<?php endforeach;?>								

<?php else: ?>

<?php endif;?>
								</ul>

			
			
						
						
				</div>
			</div>
		</div>
		<div class="col-md-12 pagination_block nopadding" style="top:20px">
				<span class="displaying_text">
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
				<span class="startPagination">
								
							<?php  echo $paginglinks;?>
								
						</span>
			  
			  </div>
		 
</div>

	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />


					</div>
				</div><!-- az-content-body -->
			  </div>
			  
			   </div>
	   </div><!-- az-content -->
	</div>	
   </div>
  </div>
</div>
</div>
</div>
	
	
	<script type="text/javascript">
	jQuery(document).ready(function($){

	var mod_type = $("#mod_type").val().toLowerCase();
	
 $(".cat_sort").sortable({
	// changelog v2 - disble sorting for selected item
	items: "li:not(.ui-state-disabled)",
	update : function () {
		serial = $('.ui-sortable').sortable('serialize');
		$.ajax({
			url: "admin/"+mod_type+"/sortcategory",
			type: "post",
			data: serial,
			error: function(){
				alert("theres an error with AJAX");
			}
		});
	}
});

 $(".cat_sort_1").sortable({
	// changelog v2 - disble sorting for selected item
	items: "li:not(.ui-state-disabled)",
	update : function () {
		serial = $('.ui-sortable2').sortable('serialize');
		sort_list_li = $(this).find('li');
		$.ajax({
			url: "admin/"+mod_type+"/sortthis",
			type: "post",
			data: serial,
			success: function(){
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			}
		});
	}
});
		
		
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
				
				//setTimeout("window.location.href='admin/calendar/view/22'",1000);	
				
				var form_type = 'full_width_row';
				if(section_type == "little_row"){
					var form_type = "little_row";
				}
				
				if(form_type != "little_row"){
					var total_record = $('.total_alternating_'+form_type).html();
					total_record = parseInt(total_record) - 1; 
					$('.total_alternating_'+form_type).html(total_record);
				}
				
				
				$('.'+form_type+'_'+item_id).remove();
				
				$('#popupDeleteItem').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully deleted!');
				setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
				
				
				
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
					
					//setTimeout("window.location.href='admin/calendar/view/"+data.id+"'",1000);	
					
					if(data.form_action == "add"){
						
						var form_type = data.form_type;
						var total_numbers = $('.alternating_'+form_type+' li').length;
						var new_number = 1;
						if(new_number > 0){
							new_number = parseInt(total_numbers) + 1;
						}
						
						var total_record = $('.total_alternating_'+form_type).html();
						total_record = parseInt(total_record) + 1; 
						$('.total_alternating_'+form_type).html(total_record);
					
						
						$('.alternating_'+form_type).append('<li id="menu_'+data.id+'" class="az-contact-item   little_row_'+data.id+' "><div class="az-contact-body "><a href="admin/calendar/view/'+data.id+'" id="cat'+data.id+'"> <h6 class="'+form_type+'_heading_'+data.id+'">'+data.title+'</h6></a></div><nav><a href="javascript:void(0)" class="badge-primary badge full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="'+data.id+'" table_name="tblcategory" form_type="little_row">Edit</a><a class="badge-primary badge delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="'+data.id+'" table_name="tblcategory" item_title="'+data.title+'" section_type="little_row">Delete</a></nav></li>');
						
						
						//$('#fullAlternatePopup').find('.close').trigger('click');
						$('#fullAlternatePopup').modal('hide');
						
						$('#responsePopup').find('.action_response_msg').html('Successfully added!');
					}else{
						var item_id = data.id;
						var form_type = data.form_type;
						//alert('.'+form_type+'_heading_'+item_id); return false;
						$('.'+form_type+'_heading_'+item_id).html(data.title );
						
						
						//$('#fullAlternatePopup').find('.close').trigger('click');
						$('#fullAlternatePopup').modal('hide');
						
						$('#responsePopup').find('.action_response_msg').html('Successfully updated!');
					
					}
					
					$('#responsePopup').modal('show');
					setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
					
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