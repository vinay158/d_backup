<?php $selected_cat = $this->uri->segment(4); ?>
<style>
	.download_thread_listing .little_row_heading_<?php echo $selected_cat ?>{background:red; color:#fff;padding:13px 0px;margin-top: -12px;margin-bottom: -8px;}
</style>
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
	  

<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>



<div class="az-content-body-left advanced_page custom_full_page onlinespecial_listing_page" >
		
       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="program-cat-page program_lisiting_page">
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
			<a href="javascript:void(0)" class="button_class badge-primary badge  full_alternate_popup"  data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tblcategory" form_type="full_width_row">Add New Category</a>
			

			</nav></div>
            
          </div>

         <!-- <div id="azContactList" class="az-contacts-list"> -->
		 <div id="" class="az-contacts-list">
			
				<ul class="cat_sort ui-sortable alternating_little_row download_thread_listing" style="">
					<?php echo $this->query_model->getCategoryTreeHTML("videos",0,0); ?>
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
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($albums) ? count($albums) : 0; ?></span> Entries</p>
								</div>
								<div>
								
								 <a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>" class="button_class btn btn-indigo" >Add New</a>
								</div>
							  </div>
							  
							<ul class="cat_sort_1 ui-sortable2 alternating_full_width_row">

			<?php
			$sr_testimonials=0; 
							
			if(!empty($albums)):
			 foreach($albums as $row):
			 $sr_testimonials++;
			 
				$videoData = array('video_type'=>$row->video_type,'video_id'=>trim($row->video_id), 'video_img_type' => $row->video_img_type,'custom_video_thumbnail'=>$row->custom_video_thumbnail);
				
				$cover_image = $this->query_model->getVideoThumbnilImage($videoData);
				
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>.</div>
								
								<?php if($row->type == 1): ?>
									<img src="<?php echo !empty($row->link_thumbnail) ? $row->link_thumbnail : base_url().'assets_admin/img/no-image.png'?>" class="list_img">
								<?php else: ?>
								
									<img src="<?php echo !empty($cover_image) ? $cover_image : base_url().'assets_admin/img/no-image.png'?>" class="list_img">
								<?php endif;?>
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=strip_tags($row->desc);?> </a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 <?php 
								$coverImg='';
								if($row->is_cover_image){
									$coverImg=1;
								}
							?>
							
							
							<?php if($row->type == 1) : ?>
							<input type="hidden" name="media_link_<?=$row->id?>" class="<?=$row->desc?>" id="media_link_<?=$row->id?>" title='<?=$coverImg?>' value="<?=$row->link_thumbnail_2;?>" />
							<?php else: ?>
							<input type="hidden" name="media_link_<?=$row->id?>" class="<?=$row->desc?>" id="media_link_<?=$row->id?>" title='<?=$coverImg?>' value="<?=$row->link?>" />
							<?php endif; ?>
							
							  <a href="admin/<?=$link_type?>/edit/<?=$row->id; ?>/view/<?=$row->category;?>" class="badge badge-primary">Edit</a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tblmedia" item_title="<?=$row->desc;?>" section_type="full_width">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tblmedia"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($row->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($row->published == 1) ? 0 : 1;?>" class="publish_type" />
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
  </div>
  </div>
  </div>
  </div>
  


	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />

	<!------- include modal for category ----------->
	<?php //$this->load->view("admin/include/cat-modal"); ?>
	<!--------- end modal for category -------------->
	
	<!------- include modal for category ----------->
	<?php //$this->load->view("admin/include/confirmation-modal"); ?>
	<!--------- end modal for category -------------->
	
	
<script type="text/javascript">
	
	
jQuery(document).ready(function($){


var mod_type = $("#mod_type").val().toLowerCase();

$(".download_thread_heading").mouseover(function(){
		var number = $(this).attr('number'); 
		$('.download_thread_heading').removeClass('selected_heading');
		$(this).addClass('selected_heading');
		$('.nav_box').hide();
		$('.nav_'+number).show(); 
		
	})

	
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
		var table_name = $('#popupDeleteItem').find('#delete_item_table_name').val();
		
		
		$.ajax({ 					
			type: 'POST',						
			url: form_action,						
			data: { formData : formData}					
			}).done(function(msg){ 
			if(msg == 1){
				
				
				var form_type = 'full_width_row';
				if(section_type == "little_row"){
					var form_type = "little_row";
				}
				
				if(table_name == "tblmedia"){
					
					var total_record = $('.total_alternating_'+form_type).html();
					total_record = parseInt(total_record) - 1; 
					$('.total_alternating_'+form_type).html(total_record);
					
					
				}
				
					$('.'+form_type+'_'+item_id).remove();
					
					//$('#popupDeleteItem').find('.close').trigger('click');
					
					
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
		
		$('#fullAlternatePopup').find('.modal-title').html(action_type + ' Video Category');
		
		$.ajax({

				url : 'admin/albums/ajax_full_alternate_popup',
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
				url : 'admin/albums/ajax_save_full_alternate_row',
				dataType : 'json',
				data: { formData : formData, published: published}					
				}).done(function(data){ 
				
				if(data.res == 1){
					
					setTimeout("window.location.href='admin/albums/view/"+data.id+"'",1000);	
					
					
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
		  <form action="admin/albums/ajax_delete_popup_record" method="post" id="deleteForm">
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