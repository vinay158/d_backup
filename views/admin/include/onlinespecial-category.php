

<div class="manager-categories" id="l_cat_sort">
    <h1>Categories</h1>
    <div class="categories-holder">
    <script language="javascript">
    $(document).ready(function(){
        $(".cat-edit").click(function(){
            var cat_edit = this.id;
            var edit_id = cat_edit.substr(4);
            var cat_color = $(this).children(".cat-color").val();
            $("#dropdown-holder").hide();	
			
			// changelog V2 - get category name from ancher title, instead of inner text
            var cat_title = $("#cat"+edit_id).attr('title');
            var cat_heading = $("#cat"+edit_id).attr('heading');
			var cat_slug = $("#cat"+edit_id).attr('slug');
			
            var post_perm = $(this).children(".post-perm").val();
            $("#dropdown-holder").slideDown(200);
            $("#shared").removeClass("check-on").removeClass("check-off");
            $(".dropdown-title em").html("ID # "+edit_id);
            $("#edit_id").val(edit_id);
            $("#cat_title").val(cat_title);
			$("#cat_heading").val(cat_heading);
            $("#cat_slug").val(cat_slug);
			$(".sef_title").html(cat_title);
            $("#shared-id").val(post_perm);
            $("#cat_color").val(cat_color);
            $(".btn-delete").show();
            $("#operation").val("edit");
			
			
			
            if( post_perm == 1 )
                $("#shared").addClass("check-on");
            else
                $("#shared").addClass("check-off");
            //exit(0);
        });


        var mod_type1 = $("#mod_type").val().toLowerCase();
        
        $(".ui-sortable").sortable({
			// changelog v2 - disble sorting for selected item
			items: "li:not(.ui-state-disabled)",
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
    
    <?php
	$this->db->order_by("pos", 'asc');
	$categories = $this->db->get("tbl_onlinespecial_categories")->result();
	
	if(isset($categories)):?>
    
    
      <ul id="blog-items" class="cat_sort ui-sortable categroysort" style="float:left">
       
        <?php foreach($categories as $cat): ?>
        	<?php                     
				/* 14 June 2013 - changelog v2 */
				$active_class = '';
				$exclude_sortable = '';
				
				if($this->uri->segment(4) == $cat->id) :
						$active_class = 'active';
				endif;
				
			?>
                    
              
            	<li id="menu_<?=$cat->id;?>" class="<?=$exclude_sortable?>">
					<div class="categories-link <?php echo $active_class;?>">
						<a href="admin/<?=$link_type?>/view/<?=$cat->id?><?php if(array_key_exists('location',$_GET) AND $_GET['location'] != ''){ echo '?location='.$_GET['location']; } ?>" id ="cat<?=$cat->id?>" class="show-entries" title="<?=$cat->name?>" heading="<?=$cat->heading?>" slug="<?=$cat->slug?>"><?=$cat->name?></a>
						
							<span><a class="" style="float:left;" id ="edit<?=$cat->id?>" href="admin/<?=$link_type?>/edit_category/<?=$cat->id?>">Edit</a>
							</span>
						<?php if($this->session->userdata['user_level'] == 1){ ?>	
							<small><a href="javascript:void(0);" style="float:left;" class="delete_trial_category" cat_id="<?=$cat->id?>">Delete
										
										</a></small>
						<?php } ?>
							
					</div>
            	</li>	
            
        <?php endforeach;?>
        
        
        
        
        
    <?php endif; ?>
        </ul>
    </div>
</div>