 <style>
 .custom_footer{position: fixed;}
 </style>
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
			<nav class="pull-right"><a href="admin/programs/program_cat_add" class="badge-primary badge">Add New Category</a>
			
			</nav></div>
            
          </div>

         <!-- <div id="azContactList" class="az-contacts-list"> -->
		 <div id="" class="az-contacts-list">
			<ul class="cat_sort ui-sortable alternating_little_row" style="">
		  <?php 
				if(isset($cat)):
				
					foreach($cat as $cat): 

					if($cat->cat_id != 25){
			?>
			<li   id="menu_<?=$cat->cat_id?>" class="az-contact-item <?php if($this->uri->segment(4) == $cat->cat_id || $category_detail[0]->cat_id == $cat->cat_id) { echo "selected"; } ?>  little_row_<?=$cat->cat_id;?> ">
            
              <div class="az-contact-body ">
               <a href="admin/<?=$link_type?>/view/<?=$cat->cat_id?>" id ="cat<?=$cat->cat_id?>" > <h6><?=$cat->cat_name?></h6></a>
              </div><!-- az-contact-body -->
				  <nav>
				  <?php if(($cat->cat_id != 25) && ($cat->cat_id != 26)) : ?>
					<a href="<?php echo base_url(); ?>admin/programs/program_cat_edit/<?=$cat->cat_id?>" class="badge-primary badge">Edit</a>
				  <?php endif;?>
				  
				  <?php $user_level =$this->session->userdata['user_level']; 
						if($user_level == 1):
							if(($cat->cat_id != 25) && ($cat->cat_id != 26)) : 
					?>
				<a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$cat->cat_id;?>"   table_name="tblcategory" item_title="<?=$cat->cat_name;?>"  section_type="little_row">Delete</a>
				  <?php endif; endif;?>
				  
				  <a  class="badge badge-primary duplicate_record" data-toggle="modal" data-target="#popupDuplicateRecord" item_id="<?=$cat->cat_id;?>"   table_name="tblcategory" item_title="<?=$cat->cat_name;?>" category_id="<?=$cat->cat_id;?>" section_type="full_width" form_action="admin/programs/duplicate_category/<?=$cat->cat_id?>">Clone</a>
				 <!-- <a href="admin/programs/duplicate_category/<?=$cat->cat_id?>" class="badge-primary badge">Clone</a>-->
				 
				 </nav>
				 
				</li>
			
            <?php 
					} 
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
								 <a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>" class="button_class btn btn-indigo" >Add Program</a>
								</div>
							  </div>
							  
							<ul class="cat_sort_1 ui-sortable2 alternating_full_width_row" style="">

<?php
$sr_testimonials=0; 


				
if(!empty($blogs)):?>
<?php foreach($blogs as $program):
 $sr_testimonials++;
?>


									<li   id="menu_<?=$program->id?>" class="full_width_row_<?=$program->id?> az-contact-info-header">
										<div class="manager-item media">
											<div style="float:left;">
												<div class="badge-no"><?=$sr_testimonials?>.</div>
												
                                                    
												<h4 class="full_width_row_heading_<?=$program->id?>"><a href="javascript:void(0)" ><?=character_limiter($program->program, 100);?></a></h4>
											</div>
											<div class="manager-item-opts">
											
											
										<nav class="nav">
											 
											  <a href="admin/<?=$link_type?>/edit/<?=$program->id; ?>/view/<?=$program->category;?>" class="badge badge-primary" >Edit</a>
											  
											  <a  class="badge badge-primary duplicate_record" data-toggle="modal" data-target="#popupDuplicateRecord" item_id="<?=$program->id;?>"   table_name="tblprogram" item_title="<?=$program->program;?>" category_id="<?=$program->category;?>" section_type="full_width" form_action="admin/<?=$link_type?>/duplicate_program">Duplicate</a>
											  
													<a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$program->id;?>"   table_name="tblprogram" item_title="<?=$program->program;?>" category_id="<?=$program->category;?>" section_type="full_width">Delete</a>
													
												
													
													<a href="javascript:void(0)" id="unpub_<?=$program->id; ?>" class="sections_unpublish"  table_name="tblprogram"  is_new="0">
												<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($program->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($program->published == 1) ? 0 : 1;?>"><span></span>
												<input type="hidden" name="publish_type" value="<?php echo ($program->published == 1) ? 0 : 1;?>" class="publish_type" />
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

<script language="javascript">
$(document).ready(function(){

									
var mod_type1 = $("#mod_type").val().toLowerCase();

$(".cat_sort_1").sortable({
update : function () {
serial = $('.cat_sort_1').sortable('serialize');
sort_list_li = $(this).find('li');
$.ajax({
url: "admin/"+mod_type1+"/sortthis",
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

$(".cat_sort").sortable({									
	update : function () {
	serial = $('.cat_sort').sortable('serialize');
	$.ajax({
	url: "admin/"+mod_type1+"/sortcategory",
	type: "post",
	data: serial,
	error: function(){
	alert("theres an error with AJAX");
	}
	});
	}
});	


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
	url: 'admin/'+mod_type+'/publish',						
	data: { pub_id : pub_id, publish_type: publish_type }					
	}).done(function(msg){ 
	if(msg == 1){
		
	}
	else{
	//setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
	//alert(msg);
	}
	});
	
});


/********************** new code for popup *********************/
$('body').on('click','.delete_item', function(){
	
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var item_title = $(this).attr('item_title');
		var section_type = $(this).attr('section_type');
		var category_id = $(this).attr('category_id');
		
		$('#popupDeleteItem').find('.modal-title').html(item_title);
		$('#popupDeleteItem').find('#delete_item_id').val(item_id);
		$('#popupDeleteItem').find('#delete_item_table_name').val(table_name);
		$('#popupDeleteItem').find('#delete_item_category_id').val(category_id);
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
				
				var form_type = 'full_width_row';
				if(section_type == "little_row"){
					var form_type = "little_row";
				}
				
				if(form_type == "full_width_row"){
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
	
	
$('body').on('click','.duplicate_record', function(){
	
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var item_title = $(this).attr('item_title');
		var section_type = $(this).attr('section_type');
		var category_id = $(this).attr('category_id');
		var form_action = $(this).attr('form_action');
		
		$('#popupDuplicateRecord').find('#duplicateForm').attr('action',form_action);
		$('#popupDuplicateRecord').find('.modal-title').html('Duplicate : '+item_title);
		$('#popupDuplicateRecord').find('#duplicate_program_title').val(item_title);
		$('#popupDuplicateRecord').find('#duplicate_item_id').val(item_id);
		$('#popupDuplicateRecord').find('#duplicate_item_table_name').val(table_name);
		$('#popupDuplicateRecord').find('#duplicate_item_category_id').val(category_id);
		$('#popupDuplicateRecord').find('#duplicate_item_section_type').val(section_type);
	})
	
	
 	$('body').on('click','.popup_duplicate_btn', function(){
		
		var formData = $('#popupDuplicateRecord').find('form').serialize();
		var form_action = $('#popupDuplicateRecord').find('form').attr('action');
		var item_id = $('#popupDuplicateRecord').find('#duplicate_item_id').val();
		var category_id = $('#popupDuplicateRecord').find('#duplicate_item_category_id').val();
		var section_type = $('#popupDuplicateRecord').find('#duplicate_item_section_type').val();
		//alert('.'+section_type+'_'+item_id); return false;
		
		
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
				
				if(form_type == "full_width_row"){
					var total_record = $('.total_alternating_'+form_type).html();
					
					total_record = parseInt(total_record) + 1; 
					$('.total_alternating_'+form_type).html(total_record);
				}	
				
				
				//$('.'+form_type+'_'+item_id).remove();
				$('#popupDuplicateRecord').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully duplicated!');
				setTimeout(function() {
					$('#responsePopup').modal('hide');
					
					window.location.href='admin/programs/view/'+category_id;
					
					}, 3000);
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
		
	
			
	})


	/*$('.az-toggle').on('click', function(){
		 $(this).toggleClass('on');
	})*/

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
		  <form action="admin/<?=$link_type;?>/delete_program_and_pro_cat" method="post" id="deleteForm">
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
				<input type="hidden" name="category_id" id="delete_item_category_id" value="">
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


<div id="popupDuplicateRecord" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="" method="post" id="duplicateForm">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Title</h1>
						<input type="text" name="program_title" id="duplicate_program_title" class="field full_width_input" value="">
						<em> Note: If you want then change title </em>
					</div>
				</div>
				<input type="hidden" name="action" value="duplicate_record">
				<input type="hidden" name="item_id" id="duplicate_item_id" value="">
				<input type="hidden" name="table_name" id="duplicate_item_table_name" value="">
				<input type="hidden" name="category_id" id="duplicate_item_category_id" value="">
				<input type="hidden"  id="duplicate_item_section_type" value="">
          </div>
          <div class="modal-footer">
            <a href="javascript:void(0)" class="btn btn-indigo popup_duplicate_btn">Save</a>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	 <script>

      $(function(){

        'use strict'



       /* new PerfectScrollbar('#azContactList', {
          suppressScrollX: true
        });

         new PerfectScrollbar('.az-contact-info-body', {
          suppressScrollX: true
        });*/ 
		
		/*az-content-body az-content-body-contacts */

        $('.az-contact-item').on('click touch', function() {
          $(this).addClass('selected');
          $(this).siblings().removeClass('selected');

          $('body').addClass('az-content-body-show');
        })        

      });

    </script>
	
	<!------- include modal for category ----------->
	<?php //$this->load->view("admin/include/cat-modal"); ?>
	<!--------- end modal for category -------------->
	
	<!------- include modal for category ----------->
	<?php //$this->load->view("admin/include/confirmation-modal"); ?>
	
	<?php //$this->load->view("admin/include/program_duplicate_model"); ?>
	<!--------- end modal for category -------------->