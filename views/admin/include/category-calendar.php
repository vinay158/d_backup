<?php

	$conf = $this->db->get_where('tblconfigcalendar',array('field_name'=>'multi_calendar'))->row_array();
	
	$locations = $this->db->get_where('tblcontact',array('published'=>1))->result_array();
?>

<?php if($conf['field_value'] == 1):?>

<div style="padding:10px;">
	
	<?php
		$g = $_GET;
	?>
	
	<form action="<?php echo base_url();?>admin/calendar/view/<?php echo $this->uri->segment(4);?>" method="GET" id="loc_form">
	<select name="location" id="loc_selector">
	<option value="">Show All Locations </option>
	<?php foreach($locations as $i=>$item):?>
		<option value="<?php echo $item['id'];?>" <?php echo (array_key_exists('location',$g) AND $g['location'] == $item['id'])?'selected':'';?>><?php echo $item['name'];?></option>	
	<?php endforeach; ?>
	</select>
	
	</form>

</div>

<script type="text/javascript">
	$(document).ready(function(){
		
		$('#loc_selector').change(function(){
		
			$('#loc_form').submit();
			
		});
		
	});
</script>


<?php endif; ?>




<div class="manager-categories" id="l_cat_sort">
    <h1>Categories</h1>
    <div class="categories-holder">
    <script language="javascript">
    $(document).ready(function(){
       /* $(".cat-edit").click(function(){
            var cat_edit = this.id;
            var edit_id = cat_edit.substr(4);
            var cat_color = $(this).children(".cat-color").val();
            $("#dropdown-holder").hide();	
			
			// changelog V2 - get category name from ancher title, instead of inner text
            var cat_title = $("#cat"+edit_id).attr('title');
			
            var post_perm = $(this).children(".post-perm").val();
            $("#dropdown-holder").slideDown(200);
            $("#shared").removeClass("check-on").removeClass("check-off");
            $(".dropdown-title em").html("ID # "+edit_id);
            $("#edit_id").val(edit_id);
            $("#cat_title").val(cat_title);
            $(".sef_title").html(cat_title);
            $("#shared-id").val(post_perm);
            $("#cat_color").val(cat_color);
            $(".btn-delete").show();
            $("#operation").val("edit");
			
			if(edit_id == 22 || edit_id == 52){
				$("#delete").hide();
			}
			
            if( post_perm == 1 )
                $("#shared").addClass("check-on");
            else
                $("#shared").addClass("check-off");
            //exit(0);
        });*/


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
    
    <?php if(isset($cat)):?>
    
    
      <ul id="blog-items" class="cat_sort ui-sortable" style="float:left">
        <?php  $categories = $cat;
        	foreach($categories as $cat): ?>
        	<?php
				/* 14 June 2013 - changelog v2 */
				$css = '';
				$exclude_sortable = '';
				if($cat->cat_id == 22 || $cat->cat_id == 52) : 
						//$css = 'restricted_category';
						//$exclude_sortable = 'ui-state-disabled';
						$css = '';
						$exclude_sortable = '';
				endif;
				
				if($this->uri->segment(4) == $cat->cat_id) :
						$css .= ' active';
				endif;
				
			?>
                
            <?php if($cat->cat_id == 22 OR $cat->cat_id == 52) : ?>    
                <li id="menu_<?=$cat->cat_id;?>" class="<?=$exclude_sortable?>">
					<div class="categories-link <?php echo $css;?>">
					<a href="admin/<?=$link_type?>/view/<?=$cat->cat_id?><?php if(array_key_exists('location',$_GET) AND $_GET['location'] != ''){ echo '?location='.$_GET['location']; } ?>" id ="cat<?=$cat->cat_id?>" class="show-entries" title="<?=$cat->cat_name?>"><?=$cat->cat_name?></a>
					<span></span>
					</div>
            	</li>	
            
            <?php endif; ?>
            
        <?php endforeach;
        
        ?>
        
        
        <?php foreach($categories as $cat): ?>
        	<?php                     
				/* 14 June 2013 - changelog v2 */
				$css = '';
				$exclude_sortable = '';
				if($cat->cat_id == 22 || $cat->cat_id == 52) : 
						//$css = 'restricted_category';
						//$exclude_sortable = 'ui-state-disabled';
						$css = '';
						$exclude_sortable = '';
				endif;
				
				if($this->uri->segment(4) == $cat->cat_id) :
						$css .= ' active';
				endif;
			?>
                
            <?php if($cat->cat_id != 22 AND $cat->cat_id != 52) : ?>    
              
            	<li id="menu_<?=$cat->cat_id;?>" class="<?=$exclude_sortable?>">
					<div class="categories-link <?php echo $css;?>">
						<a href="admin/<?=$link_type?>/view/<?=$cat->cat_id?><?php if(array_key_exists('location',$_GET) AND $_GET['location'] != ''){ echo '?location='.$_GET['location']; } ?>" id ="cat<?=$cat->cat_id?>" class="show-entries" title="<?=$cat->cat_name?>"><?=$cat->cat_name?></a>
						
						<span></span>
							<span>
							 <a href="javascript:void(0)" class=" full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$cat->cat_id?>"  table_name="tblcategory" form_type="full_width_row">Edit</a></span>
							 
							 <a class="delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$cat->cat_id?>"   table_name="tblcategory" item_title="<?=$cat->cat_name?>" section_type="full_width">Delete</a>
					</div>
            	</li>	
            <?php endif; ?>
            
        <?php endforeach;?>
        
        
        
        
        
    <?php endif; ?>
        </ul>
    </div>
</div>