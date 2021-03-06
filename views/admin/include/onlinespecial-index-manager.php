<!--<script type="text/javascript" src="themes/global/js/tiny_mce/tiny_mce.js"></script>
	-->
	
	<script src="js/ckeditor_full/ckeditor.js"></script>
	
	<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'trial_header_title', 
									{ customConfig : 'mini_half_configy.js' }
							);
							
		 CKEDITOR.replace(  'trial_header_desc', 
									{ customConfig : 'mini_half_configy.js' }
							);
							
		CKEDITOR.replace(  'additional_text_1', 
									{ customConfig : 'config.js' }
							);		
		
	});
</script>
<script>
	$(window).load(function(){
		if($('.another_trial_url_type_hidden_cb').val() == 1){
				$('.mainTrial').hide();
				$('.anotherTrial').show();
				$('.another_trial_url').attr('required',true);
		}else{
				$('.mainTrial').hide();
				$('.anotherTrial').hide();
				$('.another_trial_url').attr('required',false);
		}
	});
	$(document).ready(function(){
			
		$(".another_trial_url_type .another_trial_url_type_checkbox").click(function(){
			if($(this).hasClass("check-on")){
				$(this).removeClass("check-on");
				$(this).addClass("check-off");
				$(this).parents(".form-light-holder").children(".another_trial_url_type_hidden_cb").val("0");
				$('.mainTrial').hide();
				$('.anotherTrial').hide();
				$('.another_trial_url').attr('required',false);
				var tiral_url_type = 0;
				
			}
			else
			{
				$(this).removeClass("check-off");
				$(this).addClass("check-on");
				$(this).parents(".form-light-holder").children(".another_trial_url_type_hidden_cb").val("1");
				$('.mainTrial').hide();
				$('.anotherTrial').show();
				$('.another_trial_url').attr('required',true);
				var tiral_url_type = 1;
			}
		
		$.ajax({ 					
			type: 'POST',						
			url: 'admin/setting/saveTrialUrlType',						
			data: { tiral_url_type : tiral_url_type}					
			}).done(function(msg){ 
			if(msg != null){
			//alert(msg);
			//setTimeout("window.location.reload()",1000);
			}
		});
		
		})
		
		

	});
</script>



 <div class="az-content-body-left advanced_page custom_full_page onlinespecial_listing_page" >
		<div class="az-dashboard-one-title">
					<div>
					  <h2 class="az-dashboard-title">Trial Categories & Offers</h2>
					</div>
					
				  </div>
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
			<a href="admin/<?=$link_type?>/add_category" class="button_class badge-primary badge  full_alternate_popup">Add New Category</a>
			</nav></div>
            
          </div>

         <!-- <div id="azContactList" class="az-contacts-list"> -->
		 <div id="" class="az-contacts-list">
			
			
			<ul class="cat_sort ui-sortable alternating_little_row" style="">
			
		  <?php 
				if(isset($categories)):
				
					foreach($categories as $cat): 
					
						$active_class = '';
						$exclude_sortable = '';
						
						if($this->uri->segment(4) == $cat->id) :
								$active_class = 'active';
						endif;
				
			?>
			<li   id="menu_<?=$cat->id?>" class="az-contact-item <?php if($this->uri->segment(4) == $cat->id || $category_detail[0]->id == $cat->id) { echo "selected"; } ?>  little_row_<?=$cat->id;?> <?=$exclude_sortable?> <?php echo $active_class;?>">
            
              <div class="az-contact-body ">
               <a href="admin/<?=$link_type?>/view/<?=$cat->id?><?php if(array_key_exists('location',$_GET) AND $_GET['location'] != ''){ echo '?location='.$_GET['location']; } ?>"  title="<?=$cat->name?>" heading="<?=$cat->heading?>" slug="<?=$cat->slug?>"> <h6 class="little_row_heading_<?=$cat->id?>"><?=$cat->name?></h6></a>
              </div><!-- az-contact-body -->
			  <nav>
				  <a href="admin/<?=$link_type?>/edit_category/<?=$cat->id?>" class="badge-primary badge full_alternate_popup" >Edit</a>
				  
				  <?php if($this->session->userdata['user_level'] == 1){ ?>	
				  <a class="badge-primary badge delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$cat->id?>"   table_name="tbl_onlinespecial_categories" item_title="<?=$cat->name?>" section_type="little_row">Delete</a>
				  <?php } ?>
				 
				 </nav>
			</li>
			
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
								  <h4 class="az-content-title mg-b-5"><?php echo !empty($category_detail) ? $category_detail[0]->name : ''; ?></h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($offer) ? count($offer) : 0; ?></span> Entries</p>
								</div>
								<div>
								<?php if(count($offer) <= 1){ ?>
								 <a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>" class="button_class btn btn-indigo" >Add Trial Offer</a>
								<?php } ?>
								</div>
							  </div>
							  
							<ul class="cat_sort_1 ui-sortable2 alternating_full_width_row" style="">

							<?php 
								
								
								$sr_calendar=0; 
								if(!empty($offer)): ?>
                       			<?php foreach($offer as $row):
								
									$sr_calendar++;                       				
                       			?>

									<li   id="menu_<?=$row->id;?>" class="full_width_row_<?=$row->id;?> az-contact-info-header">
										<div class="manager-item media">
											<div style="float:left;">
												<div class="badge-no"><?=$sr_calendar?>. </div>
												
                                                
												
												<h4 class="full_width_row_heading_<?=$row->id;?>"><a href="javascript:void(0)" ><?=$row->offer_title;?> <em>( <?php if($row->trial == 1){ echo 'Paid Trial'; } else { echo 'Free Trial'; } ?> )</em></a>
												
												
												</h4>
											</div>
											<div class="manager-item-opts">
											
											
										<nav class="nav">
											 
													
												<a href="admin/<?=$link_type;?>/edit/<?=$row->id;?>" class="badge badge-primary" >Edit</a>
												
												
												
												<a  class="badge badge-primary ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$row->id;?>"   table_name="tblspecialoffer" item_title="<?=$row->offer_title;?>" section_type="full_width" form_action="admin/<?=$link_type;?>/duplicate_trial_offer" redirect_path="admin/<?=$link_type;?>/view/<?=$row->cat_id;?>">Duplicate</a>
												
											  
											<?php if($sr_calendar > 2){ ?>
												<a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$row->id;?>"   table_name="tblspecialoffer" item_title="<?=$row->offer_title;?>" category_id="<?=$row->cat_id;?>" section_type="full_width">Delete</a>
											<?php } ?>
													
												
													
												<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="sections_unpublish"  table_name="tblspecialoffer"  is_new="0">
												<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($row->display_trial == 1) ? 'on' : '';?>" publish_type="<?php echo ($row->display_trial == 1) ? 0 : 1;?>"><span></span>
												<input type="hidden" name="publish_type" value="<?php echo ($row->display_trial == 1) ? 0 : 1;?>" class="publish_type" />
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




<div class="az-content-body-left advanced_page custom_full_page" >
	
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
	  


<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		
		<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">
<div class="mb-3 main-content-label page_main_heading"><?=$title?></div>


<div class="form-light-holder another_trial_url_type">
		<a id="status" class="another_trial_url_type_checkbox  <?php if($site_setting[0]->tiral_url_type == 1) echo "check-on"; else echo "check-off"; ?>"></a>
		<span class="inline">&nbsp; Send Trial Offer to another URL</span>
		<input type="hidden" value="<?php echo $site_setting[0]->tiral_url_type; ?>" name="tiral_url_type" class="another_trial_url_type_hidden_cb" />
</div>

<?php 
	if($multi_location[0]->field_value == 1 && $multi_location[10]->field_value == 1){
?>
<span class="anotherTrial">
<form action="<?=base_url()?>admin/onlinespecial/saveAnotherMultiLocationTrialUrl" method="post">

<?php if(!empty($allLocations)){ 
			foreach($allLocations as $location){
?>
<div class="form-light-holder">
		
		<?php 
			$exitData = array();
			$exitData = $this->query_model->getbySpecific('tbl_multi_trial_offers','location_id',$location->id); 
			if(!empty($exitData)){
				$exitData = $exitData[0];
			}
			
		?>
    	
		<div class="adsUrl">
		<span class="field_title" style="display:block"><?php echo $location->name; ?></span>
		<input type="hidden" value="<?php echo $location->id; ?>" name="data[<?php echo $location->id; ?>][location_id]">
       <input type="text" class="" name="data[<?php echo $location->id; ?>][trial_offer_url]" value="<?php if(!empty($exitData)){ echo $exitData->trial_offer_url;} ?>"  />&nbsp;
	   </div>
	  <span class="field_title" style="display:block">Link Target</span>
	   <div class="linkTarget">
		
		<select name="data[<?php echo $location->id; ?>][trial_offer_link_target]" id="target" class="field input_manage" >
		<option value="_blank" <?php if(!empty($exitData)){ if($exitData->trial_offer_link_target == '_blank'){ echo 'selected=selected'; } } ?>>Blank</option>
		<option value="_self"  <?php if(!empty($exitData)){ if($exitData->trial_offer_link_target == '_self'){ echo 'selected=selected'; } } ?>>Self</option>
		</select>
	   </div>
</div>

<?php } } ?>

<div class="form-new-holder">
		<input type="submit" name="update" value="Update" class="btn-save" />
</div>
</form>
</span>
	<?php }else { ?>
<span class="anotherTrial">
<form action="<?=base_url()?>admin/setting/saveAnotherTrialUrl" method="post">
<div class="form-light-holder">
    	<span class="field_title"> Send Trial Offer to another URL</span><br />
       <input type="text" class="another_trial_url half_field" name="another_trial_url" value="<?php echo $site_setting[0]->another_trial_url; ?>"  />&nbsp;
</div>

<div class="form-new-holder">
		<input type="submit" name="update" value="Update" class="btn-save" />
</div>
</form>
</span>
		<?php } ?>
	
<div class="clearfix"></div>		
<span class="mainTrial" style="display:none">
<form action="<?=base_url()?>admin/onlinespecial/miniformvalues" method="post">

<div class="form-light-holder">
		<span class="field_title">Override Logo</span> <br />
			<select name="trial_override_logo" id="window" class="field">
				<?php foreach($override_logos as  $override_logo):?>
				<option value="<?=$override_logo->s_no?>" <?php if($site_setting[0]->trial_override_logo == $override_logo->s_no){ echo 'selected=selected';} ?>><?=$override_logo->logo_name?></option>
				<?php endforeach;?>
			</select>
</div>
<div class="form-light-holder">
    	<span class="field_title">Header Title</span></br>
        <textarea type="text" name="trial_header_title" id="trial_header_title" class="ckeditor"  /><?= $mini_form_detail[0]->trial_header_title ?></textarea>
</div>
<div class="form-light-holder">
    	<span class="field_title">Header Description</span></br>
		<textarea type="text" name="trial_header_desc" id="trial_header_desc" class="ckeditor"/><?= $mini_form_detail[0]->trial_header_desc ?></textarea>
</div>


<div class="form-light-holder" style="clear:both">
    	<span class="field_title">Additional Text 2</span><br />
		<textarea id="frm-text" name="additional_text_1" id="additional_text_1" class="ckeditor" placeholder="Enter Additional Text 1 Here" >
		<?php echo $mini_form_detail[0]->additional_text_1;?> </textarea>&nbsp;
   </div>
 <div class="form-light-holder">
    	<span class="field_title">Additional Text 2</span><br />
        <input type="text" value="<?=$mini_form_detail[0]->additional_text_2?>" name="additional_text_2" id="additional_text_2"  class="field full_width_input" placeholder="Enter Additional Text 2 Here" style=""/>&nbsp;
 </div>
<div class="form-light-holder">
    	<span class="field_title">Additional Text 3</span><br />
        <input type="text" value="<?=$mini_form_detail[0]->additional_text_3?>" name="additional_text_3" id="additional_text_3"  class="field full_width_input" placeholder="Enter Additional Text 2 Here" />&nbsp;
  </div>
<div class="form-light-holder">
    	<input type="submit" name="update" value="Update" class="btn-save" />
</div>
</form>
</span>

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
	
	
	<script type="text/javascript">
	jQuery(document).ready(function($){

	var mod_type = $("#mod_type").val().toLowerCase();
	
 $(".cat_sort").sortable({
	// changelog v2 - disble sorting for selected item
	items: "li:not(.ui-state-disabled)",
	update : function () {
		serial = $('.ui-sortable').sortable('serialize');
		$.ajax({
			url: "admin/"+mod_type+"/category_sort",
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
				
				reArrageCustomListSortPositions();
				
				setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	
	
	function reArrageCustomListSortPositions(){
		if ( $(".alternating_full_width_row").length ) {
			$.each($('.alternating_full_width_row'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
		if ( $(".alternating_little_row").length ) {
			$.each($('.alternating_little_row'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
	}
	
	
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
		
		var total_published = 0;
		$.each($('.alternate_full_width_toogle'), function(){
			if($(this).attr('publish_type') == 0){
				total_published = parseInt(total_published) + 1;
			} 
		})
		
		if(total_published > 2){
			$(this).children(".toogle_btn").attr('publish_type',1);
			$(this).find('.az-toggle').removeClass('on');
			alert('Maximum 2 trial offer can be active'); return false;
		}
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/displaytrials',						
		data: { pub_id : pub_id, display_trial: publish_type,table_name: table_name }					
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
				<a href="javascript:void(0)" class="btn btn-indigo popup_cancel_btn" data-dismiss="modal">No, cancel please!</a>
			  </div>
			   <div class="col-md-6 text-right">
				<a href="javascript:void(0)" class="btn btn-indigo popup_delete_btn">Yes, Delete It!</a>
			   </div>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->