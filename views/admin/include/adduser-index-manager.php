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
		<div class="gen-panel">
			
<div class="panel-body">

		<div class="panel-body-holder">

		<div class="form-holder">
		<div class="mb-3 main-content-label page_main_heading"><?=$title?></div>

<form action="<?=base_url()?>admin/setting/saveFacebookLoginkey" method="post">
<!--- end ---->


<h1>Enter your facebook api Id and facebook secret key</h1>
<div class="form-light-holder">
    	<h1>Facebook Api Id</h1>
        <input type="text" name="facebook_api_id" value="<?=$apiKey->facebook_api_id?>" />
</div>
<div class="form-light-holder">
    	<h1>Facebook Secret Key</h1>
        <input type="text" name="facebook_secret_id" value="<?=$apiKey->facebook_secret_id?>" />
 </div>
<div class="form-new-holder">
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

				<div class="mb-3 main-content-label" ><?=$title?></div>
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
								  <h4 class="az-content-title mg-b-5"><?=$title?></h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($user) ? count($user) - 1 : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="admin/<?=$link_type?>/add" class="button_class btn btn-indigo ">Add User</a>
								</div>
							  </div>
							  
			<ul class="alternating_full_width_row"  table_name="tbladmin" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($user)):
			 foreach($user as $row):
			 
				if($row->user_level == 1)
				continue;
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?= $row->fname.' '.$row->lname;?></a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="admin/<?=$link_type;?>/edit/<?=$row->id;?>" class="badge badge-primary">Edit</a>
							  
									<a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tbladmin" item_title="<?= $row->fname.' '.$row->lname;?>" section_type="full_width">Delete</a>
									
								<!--<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tbladmin"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($row->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($row->published == 1) ? 0 : 1;?>" class="publish_type" />
								</div></a> --->
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

<?php //$this->load->view("admin/include/conf_delete_item"); ?>
<?php //$this->load->view("admin/include/footer");?>