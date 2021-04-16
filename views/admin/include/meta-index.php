<div class="az-content-body-left  advanced_page custom_full_page meta_url_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?> Manager</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">

<div class="gen-holder">
		<div class="gen-panel">
			<div class="gen-panel-holder"  style="width: 100% !important;">
<div class="panel-body">
<div class="panel-body-holder" >
<div class="manager-items custom">
<div class="mb-3 main-content-label page_main_heading">Meta Tags</div>
<div class="border" style="padding-bottom: 20px;">
<!--<h1><?=$title?><a href="admin/<?=$link_type?>/add" class="button_class">Add Entry</a></h1> -->
<!--<div class="btn-addentry add_entry_button"></div>-->

<!--- DOJO 18/11 ---->
<form action="<?=base_url()?>admin/meta/updatemetavariable" method="post">
<!--- end ---->


<?php
$mainLocation = $this->query_model->getMainLocation("tblcontact");


$meta_school_name = isset($meta_data->meta_school_name) ? $meta_data->meta_school_name : '';
$meta_city = isset($meta_data->meta_city) ? $meta_data->meta_city : '';
$meta_state = isset($meta_data->meta_state) ? $meta_data->meta_state : '';
$meta_city_state = isset($meta_data->meta_city_state) ? $meta_data->meta_city_state : '';
$meta_nearbylocation1 = isset($meta_data->meta_nearbylocation1) ? $meta_data->meta_nearbylocation1 : '';
$meta_nearbylocation2 = isset($meta_data->meta_nearbylocation2) ? $meta_data->meta_nearbylocation2 : '';
$meta_county = isset($meta_data->meta_county) ? $meta_data->meta_county : '';
$meta_main_martial_arts_style = isset($meta_data->meta_main_martial_arts_style) ? $meta_data->meta_main_martial_arts_style : '';
$meta_martial_arts_style = isset($meta_data->meta_martial_arts_style) ? $meta_data->meta_martial_arts_style : '';


$trial_offer1 = isset($meta_data->trial_offer1) ? $meta_data->trial_offer1 : '';
$trial_offer2 = isset($meta_data->trial_offer2) ? $meta_data->trial_offer2 : '';
$main_instructor = isset($meta_data->main_instructor) ? $meta_data->main_instructor : '';
$est_year = isset($meta_data->est_year) ? $meta_data->est_year : '';
$current_location = isset($meta_data->current_location) ? $meta_data->current_location : '';
$url = $_SERVER['HTTP_HOST'];
$street = !empty($mainLocation) ? $mainLocation[0]->address : '';
$suite = !empty($mainLocation) ? $mainLocation[0]->suite : '';
$zip = !empty($mainLocation) ? $mainLocation[0]->zip : '';
$phone = !empty($mainLocation) ? $mainLocation[0]->phone : '';
?>

<p class="p_tag_heading">Enter values and use variables to replace values in meta information</p>
<table cellpadding="0" cellspacing="0" style="margin-left:23px;">  <!-- DOJO 11/02 --->
	<tr>
    	<th>School Name</th>
        <td><input type="text" name="meta_school_name" value="<?=$meta_school_name?>" />&nbsp;{school_name}</td>
    </tr>
    <tr>
    	<th>City</th>
        <td><input type="text" name="meta_city" value="<?=$meta_city?>" />&nbsp;{city}</td>
    </tr>
    <tr>
    	<th>State</th>
        <td><input type="text" name="meta_state" value="<?=$meta_state?>" />&nbsp;{state}</td>
    </tr>
     <tr>
    	<th>City State</th>
        <td><input type="text" name="meta_city_state" value="<?=$meta_city_state?>" />&nbsp;{city_state}</td>
    </tr>    
    <tr>
    	<th>Near By Location 1</th>
        <td><input type="text" name="meta_nearbylocation1" value="<?=$meta_nearbylocation1?>" />&nbsp;{nearby_location1}</td>
    </tr>
    <tr>
    	<th>Near By Location 2</th>
        <td><input type="text" name="meta_nearbylocation2" value="<?=$meta_nearbylocation2?>" />&nbsp;{nearby_location2}</td>
    </tr>
    <tr>
    	<th>County</th>
        <td><input type="text" name="meta_county" value="<?=$meta_county?>" />&nbsp;{county}</td>
    </tr>
    <tr>
    	<th>Main Martial Arts Style</th>
        <td><input type="text" name="meta_main_martial_arts_style" value="<?=$meta_main_martial_arts_style?>" />&nbsp;{main_martial_arts_style}</td>
    </tr>
    <tr>
    	<th>Martial Arts Style</th>
        <td><input type="text" name="meta_martial_arts_style" value="<?=$meta_martial_arts_style?>" />&nbsp;{martial_arts_style}</td>
    </tr>
	<tr>
    	<th>Number of Locations</th>
        <td><input type="text" name="number_of_locations" value="<?= count($allLocations)?>" readonly="readonly" />&nbsp;{locations_number}</td>
    </tr>
	
	<tr>
			<th>Trial Offer 1</th>
			<td><input type="text" name="trial_offer1" value="<?=$trial_offer1?>" />&nbsp;{trial_offer1}</td>
		</tr>
		<tr>
			<th>Trial Offer 2</th>
			<td><input type="text" name="trial_offer2" value="<?=$trial_offer2?>" />&nbsp;{trial_offer2}</td>
		</tr>
	<!--- DOJO 18/11 --->
    <!--<tr>
    	<td>Display This Page</td>
        <td><input type="checkbox" name="display" value="D" />Check</td>
    </tr>-->
	
	<tr>
			<th>Main Instructor</th>
			<td><input type="text" name="main_instructor" value="<?=$main_instructor?>" />&nbsp;{main_instructor}</td>
		</tr>
		<tr>
			<th>Est Year</th>
			<td><input type="text" name="est_year" value="<?=$est_year?>" />&nbsp;{est_year}</td>
		</tr>
		
		<tr style="display:none">
			<th>Current Location</th>
			<td><input type="text" name="current_location" value="<?=$current_location?>" />&nbsp;{current_location}</td>
		</tr>
		
		
		<tr>
			<th>Url</th>
			<td><input type="text" name="url" value="<?=$url?>" readonly="true" />&nbsp;{url}</td>
		</tr>
		
		
		<tr>
			<th>Street</th>
			<td><input type="text" name="street" value="<?=$street?>" readonly="true" />&nbsp;{street}</td>
		</tr>
		
		
		
		<tr>
			<th>Suite</th>
			<td><input type="text" name="suite" value="<?=$suite?>" readonly="true" />&nbsp;{suite}</td>
		</tr>
		
		
		
		<tr>
			<th>Zip</th>
			<td><input type="text" name="zip" value="<?=$zip?>" readonly="true" />&nbsp;{zip}</td>
		</tr>
		
		
		
		<tr>
			<th>Phone</th>
			<td><input type="text" name="phone" value="<?=$phone?>" readonly="true" />&nbsp;{phone}</td>
		</tr>
		
		<tr>
		
			<th>Currency</th>
			<td><input type="text"  value="<?php echo $this->query_model->getSiteCurrencyTypeForAdmin();?>"  readonly="true" />&nbsp;{currency}</td>
		</tr>
		
		
		<tr>
			<th>Base Url</th>
			<td><input type="text" name="url" value="<?php echo base_url(); ?>" readonly="true" />&nbsp;{base_url}</td>
		</tr>
		
		
		
    <tr>
    	<td colspan="2"><input type="submit" name="update" value="Update" class="btn-save" style="padding-left:14px" /></td>
    </tr>
</table>
</form>

</div>

		</div>

		</div>

	</div>
	
	<div class="">

<!--<div class="btn-addentry add_entry_button"></div>-->
<h1 > &nbsp;&nbsp; </h1>


<div class="program_full_detail page-section new_lisiting_block default_template" id="AlternatingFullWidth">

				<div class="mb-3 main-content-label" >Meta Urls</div>
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
								  <h4 class="az-content-title mg-b-5">Meta Urls</h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($meta) ? count($meta) : 0; ?></span> Entries</p>
								</div>
								<div>
								<!-- <a href="admin/<?=$link_type?>/add" class="button_class btn btn-indigo ">Add Meta Url</a>-->
								</div>
							  </div>
							  
			<ul class="ajax_record_sortable alternating_full_width_row"  table_name="tblmeta" >

			<?php
			$sr_testimonials=0; 
							
			if(!empty($meta)):
			 foreach($meta as $row):
			 $sr_testimonials++;
			?>


					<li   id="menu_<?=$row->id?>" class="full_width_row_<?=$row->id?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left;">
								<div class="badge-no"><?=$sr_testimonials?>. </div>
								
									
								<h4 class="full_width_row_heading_<?=$row->id?>"><a href="javascript:void(0)" ><?php echo ucwords($row->page).' - ';?><?=$row->title;?></a></h4>
							</div>
							<div class="manager-item-opts">
							
							
						<nav class="nav">
							 
							  <a href="admin/<?=$link_type?>/edit/<?=$row->id?>" class="badge badge-primary">Edit</a>
							  
							 <!-- <a class="badge badge-primary ajax_record_delete" data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$row->id;?>"   table_name="tblmeta" item_title="<?=$row->page;?>" section_type="full_width">Delete</a>
									
									<a href="javascript:void(0)" id="unpub_<?=$row->id; ?>" class="ajax_record_publish"  table_name="tblmeta"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($row->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($row->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($row->published == 1) ? 0 : 1;?>" class="publish_type" />
								</div></a> -->
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
