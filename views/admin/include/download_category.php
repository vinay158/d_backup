						<div class="manager-categories" id="l_cat_sort">
							<h1>Categories</h1>
							<div class="categories-holder">
							<script language="javascript">
							$(document).ready(function(){
								var base_url = '<?=base_url()?>';
								/*$(".delete_item").click(function(){
								var del_item_id = $(this).attr("id");
								
								var action_path = 'admin/downloads/download_cat_delete/'+del_item_id;
								$('.delete_form_download').attr('action',action_path);
								$("#delete-item-id").val(del_item_id);
								$(".delete-holder-category").hide();
								$(".delete-holder-category").slideDown(300);
								//exit(0);
								});
								
								$(".cat-edit").click(function(){
								 	var cat_edit = this.id;
									var edit_id = cat_edit.substr(4);
									
									$.ajax({
										type: "POST",
										dataType: "json",
										url: base_url+"admin/downloads/getCategory",
										data: { cat_id: edit_id }
									})		
									.done(function( obj ) {
										$("#dropdown-holder").hide();	
										
										var cat_title = $("#cat"+edit_id).text();
										var post_perm = $(this).children(".post-perm").val();
										
										$("#dropdown-holder").slideDown(200);
										$("#shared").removeClass("check-on").removeClass("check-off");
										
										$(".dropdown-title em").html("ID # "+edit_id);
										$("#edit_id").val(edit_id);
										
										$("#cat_title").val(obj.cat_name);
										
										$("#shared-id").val(post_perm);
										
										$(".btn-delete").show();
										
										$("#operation").val("edit");
										
										if( post_perm == 1 )
											$("#shared").addClass("check-on");
										else
											$("#shared").addClass("check-off");
										
									});
										
									//exit(0);
								});*/

								var mod_type1=''; 
								
								if(typeof($("#mod_type")) != 'undefined' && $("#mod_type")!= null) {								    
									mod_type1 = $("#mod_type").val().toLowerCase();
							    }
							    
								$(".ui-sortable").sortable({									
								update : function () {
								serial = $('.ui-sortable').sortable('serialize');
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
								
							});
							</script>
							<ul id="cat-items" class="cat_sort ui-sortable " >
							<?php if(isset($cat)):?>
								<?php foreach($cat as $cat): ?>
								<?php if($cat->cat_id != 25){ ?>
								<li   id="menu_<?=$cat->cat_id?>">
								<div class="categories-link <?php if($this->uri->segment(4) == $cat->cat_id) echo "active"?>" id="catid_<?=$cat->cat_id?>">
										<a href="admin/<?=$link_type?>/view/<?=$cat->cat_id?>" id ="cat<?=$cat->cat_id?>" class="show-entries"><?=$cat->cat_name?></a>
										<span></span>
										<?php if(($cat->cat_id != 25) && ($cat->cat_id != 26)) : ?>
										<!--<span><a href="javascript:void(0);" class="cat-edit" style="float:left;" id ="edit<?=$cat->cat_id?>">Edit
										<input type="hidden" name="post-perm" class="post-perm" value="<?=$cat->permission?>"/>
										</a></span> -->
										<span>
											 <a href="javascript:void(0)" class=" full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$cat->cat_id?>"  table_name="tblcategory" form_type="full_width_row">Edit</a>
										</span>
										
											 
											 <a class="delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$cat->cat_id?>"   table_name="tblcategory" item_title="<?=$cat->cat_name?>" section_type="full_width">Delete</a>
											 
										<?php endif;?>
										
										
										
											 
										
										<?php /*if(($cat->cat_id != 25) && ($cat->cat_id != 26)) : ?><small><a href="javascript:void(0);" style="float:left;" class="delete_item" id ="<?=$cat->cat_id?>">Delete
										<input type="hidden" name="post-perm" class="post-perm" value="<?=$cat->permission?>"/>
										</a></small><?php endif; */ ?>
										
										
										
								</div>
								</li>
								<?php } ?>
								<?php endforeach;?>
							<?php endif; ?>
							<input type="hidden" id="mod_type" value="downloads" />
							<input type="hidden" id="mod_type1" value="downloads" />
								</ul>
							</div>
						</div>
						
						
<div class="delete-holder-category delete-holder-item" style="display: none;">
  <form  method="post" class="delete_form_download">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;">Confirmation</div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>
    
    <div class="dropdown-body">
	    <div class="form-item">
		    <h1>Are you sure you want to delete this?</h1><br>
		    <span class="catNote" style="">Note: This will permanently delete all Download Entires in this Category, as well as all the Comments associated with those Download Entries.</span>
			<input type="hidden" name="delete-item-id" id="delete-item-id" value=""/>
		    <input type="hidden" name="category_loc" id="category_loc" value="<?=$this->uri->segment(4);?>" />
	    </div>
    </div>
    <div class="dropdown-bottom">
		
	    <input type="submit" value="Delete" class="btn-delete actionButtons" style="float:left;">
		<script language="javascript">
		$(document).ready(function(){
			$(".btn-cancel").click(function(){
				$(this).parents(".delete-holder-item").slideUp(300);
			})
		});
		</script>
	    <input type="button" value="Cancel" class="btn-cancel actionButtons" style="float:left;">
    </div>
  </div></form>
</div>