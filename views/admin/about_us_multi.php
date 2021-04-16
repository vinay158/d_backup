<?php $this->load->view("admin/include/header"); ?>

<script src="js/ckeditor_full/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		 CKEDITOR.replace(  'ckeditor_mini', 
									{ customConfig : 'config.js' }
							);
	
		
	});
</script>

<script language="javascript">
$(document).ready(function(){
	
	$("#delete_img").click(function(){
		
		$('#img').hide();
		var id=$(this).attr('number');
		
		var mod_type = 'setting';
		//alert(staff_id);
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/about/delete_about_us_image',						
		data: { id : id}					
		}).done(function(msg){ 
		if(eval(msg) == 1){
			//setTimeout("window.location.href='admin/testimonials/view'",1000);
		}
		else{
			alert("Oops! Unable to Delete, Please check folder permission.");
			return false;					
		}
		});

	});
	
})
</script>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">About Text Section</h2>
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


<form action="" method="post"  enctype="multipart/form-data">
<div class="mb-3 main-content-label page_main_heading">Text Section</div>
<div class="form-light-holder">
	<span class="field_title">Title</span>
	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->title); } ?>" name="title"  class="field full_width_input" placeholder="Enter title here"  style=""/>
</div>


<div class="form-light-holder">
	<span class="field_title">Sub Title</span>
	<input type="text" value="<?php if(!empty($pagedetails)){ echo $this->query_model->getStrReplaceAdmin($pagedetails[0]->sub_title); } ?>" name="sub_title"  class="field full_width_input" placeholder="Enter sub title here"  style=""/>
</div>

<div class="form-light-holder">
	<span class="field_title">Content</span>
	<textarea type="text" name="description" id="ckeditor_mini" class="field ckeditor full_width_input" placeholder=""  style=""/><?php echo !empty($pagedetails) ? $pagedetails[0]->description : '';?></textarea>
</div>

<div class="form-light-holder   d-md-flex  dual_input" style="overflow:auto;">
	<div class="adsUrl form-group">
	
	<h1>Photo uploader </h1>
	<div class="custom-file half_width_custom_file">
		<input type="file" name="userfile" class="custom-file-input" id="customFile1"  accept="image/*"  />
	<label class="custom-file-label" for="customFile">Choose file</label></div>
	
	<?php if(!empty($pagedetails[0]->photo)): ?>
	<div><img id='img' src="<?php echo base_url().'upload/about_us/'.$pagedetails[0]->photo;?>" style="width: 100px; clear:both;" /></div>
	<input type="hidden" name="last-photo" value="<?=$pagedetails[0]->photo;?>" />
	<?php endif;?>
	
	<?php if(!empty($pagedetails[0]->photo)){ 
			echo "<a href='javascript:void(0);' id='delete_img'  class='delete_image_btn_new'  number='".$pagedetails[0]->id."'>Delete image</a>";
			}
	?>	
	</div>
	
	<div class="linkTarget form-group">
		<h1>Image alt text</h1>
	<input value="<?php echo !empty($pagedetails) ? $this->query_model->getStrReplaceAdmin($pagedetails[0]->photo_alt_text) : ''; ?>" name="photo_alt_text" id="" class="field" placeholder="image alt text" type="text">
		</div>
</div>
<div class="form-light-holder">
	<span class="field_title">Image Top Spacing</span><br />
	<input type="text" name="img_top_spacing" id="img_top_spacing" class="field  img_top_spacing" placeholder=""  style="width: 7%" value="<?php echo !empty($pagedetails) ? $pagedetails[0]->img_top_spacing : ''?>"/> <span style="font-size:15px"><strong>px</strong></span><br/>
	<em>Note: Please use only integer or float value. don't use "px" in input field</em>
	
</div>
<div class="form-new-holder">
	<input type="hidden" value="<?= $location_id; ?>" name="location_id" class="location_id" />
		<input type="submit" name="update" value="Update" class="btn-save" />
</div>
</form>

	</div>

		</div>

		</div>

	</div>
	
	
	
	<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->


<h1 > &nbsp;&nbsp; </h1>

<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label" >Full Width Rows</div>
				<div class="row row-xs align-items-center  mg-t-25 mg-b-5">
					<div class="col-md-12">
						<p>You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.</p>
					</div>
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5">Full Width Rows</h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($aboutUsRows) ? count($aboutUsRows) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/<?=$link_type?>/add_aboutus_row/<?php echo $location_id; ?>" class="button_class btn btn-indigo ">Add Full Width Row</a>
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable_with_extra_field alternating_full_width_row"  table_name="tbl_aboutus_rows" extra_field="location_id" extra_value="<?php echo $location_id; ?>">

			<?php
			$sr_testimonials=0; 
							
			if(!empty($aboutUsRows)):
			 foreach($aboutUsRows as $row):
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no">. <?=$sr_testimonials?></div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?=$row->title;?> ( <?php echo ucfirst($row->photo_side);?> )</a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="admin/about/edit_aboutus_row/<?=$row->id;?>" class="badge badge-primary">Edit</a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_aboutus_rows" item_title="<?=$row->title;?>" section_type="full_width">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tbl_aboutus_rows"  is_new="0">
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

	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />		
			
						
						
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


<?php $this->load->view("admin/include/conf_delete_about_rows"); ?>
<?php $this->load->view("admin/include/footer");?>