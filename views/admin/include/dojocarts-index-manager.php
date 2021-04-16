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

	
<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label" ><?=$title?>s</div>
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
								  <h4 class="az-content-title mg-b-5"><?=$title?>s</h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($dojocartDetails) ? count($dojocartDetails) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="add_dojocart_template" class="button_class btn btn-indigo "  data-toggle="modal" data-target="#popupDojocartTemplate" >Add DojoCart Product</a>
								</div>
							  </div>
							  
			<ul class="alternating_full_width_row"  table_name="tbl_dojocarts" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($dojocartDetails)):
			 foreach($dojocartDetails as $row):
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>.</div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" >
									<?php 
										$product_title = str_replace(array('<br>','</br>','<br/>'), array(" "," "," "),$row->product_title);
										
										$product_title = strip_tags($product_title);
										echo $product_title;
									?>
									
									(<?php echo ucfirst($row->template) ?>)
								</a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="#" class="badge badge-primary getDojocartUrl" dojocart_url="<?= base_url().'promo/'.$row->slug?>" item_title="<?=$product_title;?>"  data-toggle="modal" data-target="#popupDojocartUrl" >Preview Url</a>
							  
							  <a href="admin/<?=$link_type;?>/edit/<?=$row->id;?>" class="badge badge-primary">Edit</a>
							  
							  <a  class="badge badge-primary ajax_record_duplicate" data-toggle="modal" data-target="#popupDuplicateItem" item_id="<?=$row->id;?>"   table_name="tbl_dojocarts" item_title="<?=$product_title;?>" section_type="full_width" form_action="admin/<?=$link_type;?>/duplicateDojocart" redirect_path="admin/<?=$link_type;?>/view">Duplicate</a>
							  
							  
								<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbl_dojocarts" item_title="<?=$product_title;?>" section_type="full_width">Delete</a>
								
								<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tbl_dojocarts"  is_new="0">
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

</div>	

	</div>			

		
</div>
</div>
</div>
</div>


<script>
	jQuery(document).ready(function($){
		
		$('body').on('click','.getDojocartUrl', function(){
			
			var item_title = $(this).attr('item_title');
			var dojocart_url = $(this).attr('dojocart_url');
			
			$('#popupDojocartUrl').find('.modal-title').html('Dojocart: '+ item_title);
			$('#popupDojocartUrl').find('.subheading').html('<a style="color:#596882" target="_blank" href="'+dojocart_url+'">'+dojocart_url+'</a>');
		})
	})

</script>

<div id="popupDojocartUrl" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <div class="modal-body edit-form">
             <div class="row row-xs align-items-center delete_popup_text_block">
					<div class="col-md-12 mg-t-5 mg-md-t-0 text-center">
						<!--<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						<h2 class="heading">Are you sure?</h2> -->
						<h5 class="subheading">You will not be able to recover the deleted record.</h5>
					</div>
				</div>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	

	<div id="popupDojocartTemplate" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title">Add Dojocart Product</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="admin/<?=$link_type?>/saveDojoCartTemplate" method="post" id="addTemplatePopupForm">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Select Template</h1>
						<?php $templates = array('default' => 'Products Template', 'events' => 'Events Template', 'tournaments' => 'Tournaments Template','ata_cr_xma' => 'ATA CR XMA Template','tiger_blank' => 'Tiger Blank Template','novice_blank' => 'Novice Blank Template','traditional_blank' => 'Traditional Blank Template','multi_item_dojocart'=>'Multi Item Dojocart'); ?>
						<select name="dojo_cart_template" id="dojo_cart_template" class="field">
							<?php foreach($templates as $key => $val): ?>
							<option value='<?=$key?>'><?=$val?></option>
							<?php endforeach;?>
						</select>
					</div>
				</div>
          </div>
          <div class="modal-footer">
            <input type="submit" name="submit" value="Save" class="btn-save btn btn-indigo" style="float:left;">
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
