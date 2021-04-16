<?php $this->load->view("admin/include/header"); ?>
<link href="<?=base_url();?>assets_admin/lib/lightslider/css/lightslider.min.css" rel="stylesheet">
<link href="<?=base_url();?>assets_admin/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">

<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>

<div class="az-content-body-left advanced_page custom_full_page rank_traker_api_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Nightwatch Report</h2>
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
	
<?php if($respose == 1){ ?>
<script>

	$(document).ready(function(){
		$('.url_types').change(function(){
			var url_type = $(this).val();
			<?php 
				$selected_keyword_id = (isset($searchData['keyword_id']) && !empty($searchData['keyword_id'])) ? $searchData['keyword_id'] : ''; 
				$selected_start_date = (isset($searchData['start_date']) && !empty($searchData['start_date'])) ? $searchData['start_date'] : ''; 
				$selected_end_date = (isset($searchData['end_date']) && !empty($searchData['end_date'])) ? $searchData['end_date'] : ''; 
				
			?>
			var selected_keyword_id = "<?php echo $selected_keyword_id; ?>";
			var selected_start_date = "<?php echo $selected_start_date; ?>";
			var selected_end_date = "<?php echo $selected_end_date; ?>";
			
			$.ajax({

				url : '<?php echo base_url("admin/nightwatch_trackr/ajaxGetRankTrackrKeywords"); ?>',
					type : 'POST',
					dataType :'json',
					data :{url_type:url_type, keyword_id:selected_keyword_id, start_date:selected_start_date, end_date:selected_end_date, action: 'getKeywords'},
					success:function(data){
						if(data.response == 1){
								$('.keyword_dropdown').empty();
								
								$('.keyword_dropdown').append('<option label="Choose one"></option>');
								$.each(data.result, function(index, element) {
									if(index == selected_keyword_id){
										$('.keyword_dropdown').append('<option value="'+index+'" selected="selected">'+element+'</option>');
									}else{
										$('.keyword_dropdown').append('<option value="'+index+'" >'+element+'</option>');
									}
									
								});
						}
					}

			});
			/*var queryString = "?url_type="+url_type;
			var redirect_path = "<?php echo base_url().ltrim($_SERVER['REDIRECT_QUERY_STRING'],'/') ?>"+queryString;
			window.location.href = redirect_path;*/
			
		})
	})
</script>

<div style="clear:both"></div> 
<form action="" method="get">
<div class="col-sm-12 col-xl-12 col-lg-12 nopadding">
				<div class="mb-3 main-content-label" >Keywords List : <?php echo (strtotime($dateRanges['start_date']) != strtotime($dateRanges['end_date'])) ?  date('d M Y', strtotime($dateRanges['start_date'])).' to '.date('d M Y', strtotime($dateRanges['end_date'])) : date('d M Y', strtotime($dateRanges['start_date'])); ?>
					<?php if(isset($api_reponse_data['report_link']) && !empty($api_reponse_data['report_link']) ){ ?>
						<span style="float:right"><a href="<?php echo $api_reponse_data['report_link']; ?>" class=" delete_row_btn" target="_blank">View Report</a></span> 
					<?php } ?>
				</div>
				<div class=" card-dashboard-twentyfive keyword-bar backlinks-link card-body">
					<div class="row row-sm mg-b-20">
					
	<!--<div class="col-lg-3">
      <h1>Groups</h1>
     <select name="url_type" id="" class="form-control url_types">
		<?php foreach($api_reponse_data['url_types'] as $key => $val){ ?>
			<option value="<?php echo $key; ?>" <?php echo (isset($searchData['url_type']) && $searchData['url_type'] == $key) ? 'selected=selected' : '' ; ?>><?php echo ucfirst($val); ?></option>
		<?php } ?>
		</select>
      
   </div> -->
 
<!-- <script>
    $(function() {
        $( "#start_date" ).datepicker({ dateFormat: "yy-mm-dd",maxDate: new Date() });
		$( "#end_date" ).datepicker({ dateFormat: "yy-mm-dd",maxDate: new Date() });
    });
    </script>
   <div class="col-lg-4">
      <h1>Start Time</h1>
      <input type="text" value="<?php echo (isset($searchData['start_date'])) ? $searchData['start_date'] : ''; ?>" name="start_date" id="start_date" class="dateRange form-control" placeholder="mm/dd/yyyy" maxlength="10"/>
      
   </div>
   <div class="col-lg-4 mg-t-20 mg-lg-t-0">
      <h1>End Time</h1>
      <input type="text" value="<?php echo (isset($searchData['end_date'])) ? $searchData['end_date'] : ''; ?>" name="end_date" id="end_date" class="dateRange form-control" placeholder="mm/dd/yyyy" maxlength="10"/>
      
   </div> --->
   <div class="col-lg-3"> 
   <h1>Date</h1>
		<select name="date_sort" id="" class="form-control sort_dates">
		<?php foreach($dateRanges['sorting_list'] as $key => $val){ ?>
			<option value="<?php echo $key; ?>" <?php echo ($key == $date_sort) ? 'selected=selected' : '' ?>><?php echo $val; ?></option>
		<?php } ?>
		</select>
	</div>
	
   <!-- col-3 -->
   <?php /*if(isset($api_reponse_data['keywords_list']) && !empty($api_reponse_data['keywords_list']) ){ ?>
   <div class="col-lg-4 mg-t-20 mg-lg-t-0">
      <h1>Keyword</h1>
      <select class="form-control keyword_dropdown" name="keyword_id" >
         <option label="Choose one"></option>
		
		 <?php 
			$n = 1;
			foreach($api_reponse_data['keywords_list'] as $k => $keyword){ 
		?> 
			 <option value="<?php echo $keyword->id; ?>" <?php echo (isset($searchData['keyword_id']) && $searchData['keyword_id'] == $keyword->id) ?  'selected=selected' : ''; ?> ><?php echo $keyword->query; ?></option>
		<?php $n++; } ?>
      </select>
     
   </div>
   <?php }*/ ?>
   <!-- col-3 -->
   <div class="col-lg-3 mg-t-20 mg-lg-t-0">
      <h1>Report Type</h1>
	  <?php $reportTypes = array('simple'=>'Simple','extended'=>'Extended','csv'=>'CSV','csv_overview'=>'Csv Overview'); ?>
      <select class="form-control" name="report_type">
         <?php foreach($reportTypes as $key => $report_type){ ?>
         <option value="<?php echo $key; ?>" <?php echo (isset($searchData['report_type']) && $searchData['report_type'] == $key) ? 'selected=selected' : '' ; ?>><?php echo $report_type ?></option>
		 <?php } ?>
         
      </select>
      
   </div>
   <div class="col-lg-3">
	 <div class="col-lg-4 float-left">
       <input type="submit"  value="Search" class="btn-save" />
	 </div>
	  <div class="col-lg-8 float-left">
	   <a href="<?php echo base_url().'admin/nightwatch_trackr?sort=google' ?>" class="button_class btn btn-outline-light">Clear</a>
	  </div>
   </div>
   
   
</div>
<!-- row -->

				</div>
			</div>
</form>			
		
		
<?php if(!empty($api_reponse_data)){ ?>
<div class="panel-body ordersListTable rank_traker_response">
				<div class="panel-body-holder">
					<div class="form-holder">
					
					<div class="col-sm-12 col-xl-12 mg-t-20 col-lg-12 site-statics statics_box">

            <div class="card card-dashboard-twentyfive keyword-bar card-body ">
			<div class="row keyword_box_data1">
              <div class="col-6 col-sm-6 custom-keyword-box first">
                <label class="card-label">Average position</label>
                <div class="chart-wrapper">
                  <div>
					<?php 
					$average_position_current_record = 0;
					if(isset($graph_data['average_position']['current_record']) && !empty($graph_data['average_position']['current_record'])){ 
						$average_position_current_record = $graph_data['average_position']['current_record'];
					?>
					<div class="average_position_current"><h2><?php echo $graph_data['average_position']['current_record']; ?></h2></div>
					<?php } ?>
					
					<?php if(isset($graph_data['average_position']['change_value']) && !empty($graph_data['average_position']['change_value'])){ ?>
					<div class="average_position_change last_changes">
						<?php echo getLastChangeValue($graph_data['average_position']['change_value'],'average_position'); ?>
					</div>
					<?php } ?>
					 
				  </div>
				  <div class="average_position_empty_space"></div>
				  
					<div class="progress" style="clear:both">
						
						<div class="progress-bar progress-bar-striped bg-success" style="width:<?php echo round($average_position_current_record); ?>%" role="progressbar" aria-valuenow="<?php echo $average_position_current_record; ?>" aria-valuemin="0" aria-valuemax="100"></div>
					  </div>
					<div class="average_position_progress_number">
					<span class="start">1</span>
					<span class="end">100</span>
				  </div>
                </div><!-- chart-wrapper -->
              </div><!-- col -->
              <div class="col-6 col-sm-6 custom-keyword-box" >
                <label class="card-label mg-l-20">Keyword Distribution</label>
				
					
                <div class="chart-wrapper">
                  <div class="d-md-flex">
					<div class="col-6 col-sm-5 " style="position:relative;"><canvas id="chartPie"></canvas></div>
					
					<?php 
					if(isset($graph_data['keyword_distribution']['current_record']) && !empty($graph_data['keyword_distribution']['current_record'])){
		
						$keyword_current_top_3 = (isset($graph_data['keyword_distribution']['current_record']->top_3) && !empty($graph_data['keyword_distribution']['current_record']->top_3)) ? $graph_data['keyword_distribution']['current_record']->top_3 : 0;
						$keyword_current_top_10 = (isset($graph_data['keyword_distribution']['current_record']->top_10) && !empty($graph_data['keyword_distribution']['current_record']->top_10)) ? $graph_data['keyword_distribution']['current_record']->top_10 : 0;
						$keyword_current_top_100 = (isset($graph_data['keyword_distribution']['current_record']->top_100) && !empty($graph_data['keyword_distribution']['current_record']->top_100)) ? $graph_data['keyword_distribution']['current_record']->top_100 : 0;
						$keyword_current_no_rank = (isset($graph_data['keyword_distribution']['current_record']->no_rank) && !empty($graph_data['keyword_distribution']['current_record']->no_rank)) ? $graph_data['keyword_distribution']['current_record']->no_rank : 0;
						
						$keyword_change_top_3 = (isset($graph_data['keyword_distribution']['change_value']['top_3']) && !empty($graph_data['keyword_distribution']['change_value']['top_3'])) ? $graph_data['keyword_distribution']['change_value']['top_3'] : 0;
						$keyword_change_top_10 = (isset($graph_data['keyword_distribution']['change_value']['top_10']) && !empty($graph_data['keyword_distribution']['change_value']['top_10'])) ? $graph_data['keyword_distribution']['change_value']['top_10'] : 0;
						$keyword_change_top_100 = (isset($graph_data['keyword_distribution']['change_value']['top_100']) && !empty($graph_data['keyword_distribution']['change_value']['top_100'])) ? $graph_data['keyword_distribution']['change_value']['top_100'] : 0;
						$keyword_change_no_rank = (isset($graph_data['keyword_distribution']['change_value']['no_rank']) && !empty($graph_data['keyword_distribution']['change_value']['no_rank'])) ? $graph_data['keyword_distribution']['change_value']['no_rank'] : 0;
					
					
				?>
					<div class="col-md-6 col-lg-7 mg-lg-l-0 mg-t-20 mg-md-t-0">
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Top 3</span>
                        <span><?php echo $keyword_current_top_3; ?> 
						<span class="last_changes">
							<?php echo getLastChangeValue($keyword_change_top_3); ?>
						</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-45p" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="background:#5620cd; width:<?php echo $keyword_current_top_3 ?>%"></div>
                      </div><!-- progress -->
                    </div>
                    <div class="az-traffic-detail-item">
                      <div> 	
                        <span>Top 10</span>
                        <span><?php echo $keyword_current_top_10; ?> 
						<span class="last_changes">
							<?php echo getLastChangeValue($keyword_change_top_10); ?>
						</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-20p" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="background:#fb0d1c; width:<?php echo $keyword_current_top_10 ?>%"></div>
                      </div><!-- progress -->
                    </div>
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Top 100</span>
                        <span><?php echo $keyword_current_top_100; ?> 
						<span class="last_changes">
							<?php echo getLastChangeValue($keyword_change_top_100); ?>
						</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-35p" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="background:#69cf30; width:<?php echo $keyword_current_top_100 ?>%"></div>
                      </div><!-- progress -->
                    </div>
					
					<div class="az-traffic-detail-item">
                      <div>
                        <span>No rank</span>
                        <span><?php echo $keyword_current_no_rank; ?> 
						<span class="last_changes">
							<?php echo getLastChangeValue($keyword_change_no_rank); ?>
						</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-35p" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="background:#3ea2ff; width:<?php echo $keyword_current_no_rank ?>%"></div>
                      </div><!-- progress -->
					 
                    </div>
                    
                  </div>
				<?php } ?>
				  <!-- col -->
          </div>
                </div><!-- chart-wrapper -->
              </div><!-- col -->
             
            </div>
			
			<div class="row keyword_box_data2">
					 <div class="col-6 col-sm-6 custom-keyword-box first">
                <label class="card-label"> Keywords Up / Down </label>
				<?php if(isset($graph_data['up_down']['current_record']) && !empty($graph_data['up_down']['current_record'])){ 
				
				$current_up_keyword =	(isset($graph_data['up_down']['current_record']->went_up) && !empty($graph_data['up_down']['current_record']->went_up)) ? $graph_data['up_down']['current_record']->went_up : 0;
				$current_down_keyword =	(isset($graph_data['up_down']['current_record']->went_down) && !empty($graph_data['up_down']['current_record']->went_down)) ? $graph_data['up_down']['current_record']->went_down : 0;
				$current_stagnant_keyword =	(isset($graph_data['up_down']['current_record']->stagnant) && !empty($graph_data['up_down']['current_record']->stagnant)) ? $graph_data['up_down']['current_record']->stagnant : 0;
				?>
				<div >
				  
					<div class="keyword_up_down">
						<span class="last_changes">
							<?php echo getLastChangeValue($current_up_keyword); ?>
						</span>
						
						<span class="last_changes">
							<?php echo getLastChangeValue($current_down_keyword,'up_down_down'); ?>
						</span>
						
						<span class="last_changes">
							<?php echo getLastChangeValue($current_stagnant_keyword); ?> <span class="text">stagnant</span>
						</span>
					</div>
					
					<div class="progress">
					  <div class="progress-bar progress-bar-up" style="width: <?php echo $current_up_keyword; ?>%;">
					  </div>
					  <div class="stick"></div>
					  <div class="progress-bar progress-bar-down" style="width: <?php echo $current_down_keyword; ?>%;">
					  </div>
					  <div class="stick"></div>
				 </div>
					  
					 <!--  <div class="average_position_progress_number">
						<span class="start">1</span>
						<span class="end">100</span>
					  </div> -->
					  
					
                </div><!-- chart-wrapper -->
				<?php } ?>
              </div><!-- col -->
              
			<div class="col-6 col-sm-6 custom-keyword-box" >
                <label class="card-label mg-l-20">Search Visibility</label>
				
					
                <div class="chart-wrapper">
                  <div class="d-md-flex">
					
					<?php 
						$indexed_pages_current = (isset($graph_data['indexed_pages']['current_record']) && !empty($graph_data['indexed_pages']['current_record'])) ? $graph_data['indexed_pages']['current_record'] : 0;
						$indexed_pages_change_value = (isset($graph_data['indexed_pages']['change_value']) && !empty($graph_data['indexed_pages']['change_value'])) ? $graph_data['indexed_pages']['change_value'] : 0;
					?>
					<div class="col-md-12  mg-lg-l-0 mg-t-20 mg-md-t-0">
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Indexed Pages</span>
                        <span><?php echo $indexed_pages_current; ?> 
						<!--<span class="last_changes">
							<?php echo getLastChangeValue($indexed_pages_change_value); ?>
						</span>--></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-45p" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="background:#5620cd; width:<?php echo $indexed_pages_current ?>%"></div>
                      </div><!-- progress -->
                    </div>
					
					<?php 
						$search_visibility_current = (isset($graph_data['search_visibility_index']['current_record']) && !empty($graph_data['search_visibility_index']['current_record'])) ? $graph_data['search_visibility_index']['current_record'] : 0;
						$search_visibility_change_value = (isset($graph_data['search_visibility_index']['change_value']) && !empty($graph_data['search_visibility_index']['change_value'])) ? $graph_data['search_visibility_index']['change_value'] : 0;
					?>
                    <div class="az-traffic-detail-item">
                      <div> 	
                        <span>Search Visibility %</span>
                        <span><?php echo $search_visibility_current; ?> 
						<!--<span class="last_changes">
							<?php echo getLastChangeValue($search_visibility_change_value); ?>
						</span>--></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-20p" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="background:#fb0d1c; width:<?php echo $search_visibility_current ?>%"></div>
                      </div><!-- progress -->
                    </div>
					
					<?php 
						$click_potential_current = (isset($graph_data['click_potential']['current_record']) && !empty($graph_data['click_potential']['current_record'])) ? $graph_data['click_potential']['current_record'] : 0;
						$click_potential_change_value = (isset($graph_data['click_potential']['change_value']) && !empty($graph_data['click_potential']['change_value'])) ? $graph_data['click_potential']['change_value'] : 0;
					?>
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Click Potential</span>
                        <span><?php echo $click_potential_current; ?> 
						<!--<span class="last_changes">
							<?php echo getLastChangeValue($click_potential_change_value); ?>
						</span>--></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-35p" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100" style="background:#69cf30; width:<?php echo $click_potential_current ?>%"></div>
                      </div><!-- progress -->
                    </div>
					
                    
                  </div>
				  <!-- col -->
          </div>
                </div><!-- chart-wrapper -->
              </div><!-- col -->
             
			
			
			</div>
			
			<!-- row --></div>
		 </div>
		 
							<div class="row row-sm mg-b-15 mg-sm-b-20 ">
			
		<?php if(isset($api_reponse_data['keywords_list']) && !empty($api_reponse_data['keywords_list']) ){ ?>
			<div class="col-sm-12 col-xl-12 col-lg-12 nopadding">
				<!--<div class="mb-3 main-content-label" >Keywords List</div> --->
				<div class=" card-dashboard-twentyfive keyword-bar backlinks-link card-body">
				
				<table id="example3" class="table ">
				<thead>
				<tr>
				<th class="wd-5p">No.</th>
				<th class="wd-20p">Keyword <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Keyword" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">Rank <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Rank " data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<!--<th class="wd-10p">Language <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Language" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>-->
				<th  class="wd-10p">Country <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Country" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<!--<th class="wd-10p">Evolution <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Evolution" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>-->
				<th class="wd-15p">D/W/M Changes <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Evolution" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">SV (Global) <span data-container="body" data-popover-color="head-primary" data-placement="top" title="SV (Global)" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">CPC (Global) <span data-container="body" data-popover-color="head-primary" data-placement="top" title="CPC (Global)" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<!--<th class="wd-10p">Last Update <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Last Update" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>-->
				</tr>
				</thead>

				<tbody>
			<?php 
				$n = 1;
				foreach($api_reponse_data['keywords_list'] as $k => $keyword){ 
			?> 
				<tr >
				<td ><?=$n?>.</td>
				<td>
				<?php 
					$search_engine = '';
					if($keyword->engine == "google"){
						$search_engine = 'google.png';
					}elseif($keyword->engine == "bing"){
						$search_engine = 'bing.png';
					}
				?>
				<img class="search_engine_img" src="<?php echo base_url('/').'assets_admin/img/'.$search_engine ?>">
				<span class="keyword_lang"><?php  echo $keyword->google_hl; ?></span>
				<?php echo $keyword->query; ?> <br/><span style="font-size:10px"><?php echo $keyword->uri; ?></span></td>
				<td class="last_changes"><?php echo !empty($keyword->position) ? $keyword->position : '/'; ?> 
				<?php //if(isset($keyword->last_position_change[0]) && !empty($keyword->last_position_change[0])){ ?>
				<?php 
					$last_position_change = $keyword->last_position_change[0];
					
					echo getLastChangeValue($last_position_change,'last_position_change');
				?>
				
				<!--<td ><?php echo $keyword->id.'==>'; ?><?php  echo $keyword->google_hl; ?></td>-->
				<td  ><?php echo $keyword->google_gl; ?></td>
				<!--<td ><img src="https://api.ranktrackr.com/<?php echo $keyword->mini_graph; ?>" width="125px"></td>-->
				<td class="last_changes">
					<?php 
						echo getLastChangeValue($keyword->last_day_change);
						echo getLastChangeValue($keyword->last_week_change);
						echo getLastChangeValue($keyword->last_month_change);
					?>
				</td>	
				<td ><?php echo !empty($keyword->adwords_global_search_volume) ? $keyword->adwords_global_search_volume : '/'; ?></td>
				<td ><?php echo !empty($keyword->adwords_global_average_cpc) ? $keyword->adwords_global_average_cpc : '/'; ?></td>
				<!--<td ><?php echo date('m-d-Y H:i:s', strtotime($keyword->last_processed_at)); ?></td>-->
				</tr>
			<?php $n++; }?>	
				
				</tbody></table></div>
			</div>
		<?php } ?>	
			
		
		<?php if(isset($api_reponse_data['competitors_list']) && !empty($api_reponse_data['competitors_list']) ){ ?>
		
			<div class="col-sm-12 col-xl-12 col-lg-12 nopadding">
				<div class="mb-3 main-content-label" >Competitors List</div>
				<div class=" card-dashboard-twentyfive keyword-bar backlinks-link card-body">
				
				<table id="example4" class="table ">
				<thead>
				<tr>
				<th class="wd-5p">No.</th>
				<th class="wd-10p">Competitor <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat." data-content="Competitor"><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">Site Url <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. " data-content="Site Url"><i class="fa fa-question-circle"></i></span></th>
				
				</tr>
				</thead>

				<tbody>
			<?php 
				$n = 1;
				foreach($api_reponse_data['competitors_list'] as $k => $competitor){ 
			?> 
				<tr >
				<td ><?=$n?></td>
				<td  ><?php echo $competitor->display_name; ?></td>
				<td ><?php echo $competitor->url; ?></td>
				</tr>
			<?php $n++; }?>	
			
				</tbody></table></div>
			</div>
		<?php } ?>	
		
		
		
		  
		  
		
		
			
		
		</div>

						</div>
					</div>
			</div>
<?php } ?>
	
			


		<?php }else{ ?>
		
			Something went wrong. Check ranktrackr api  and credentials. <a href="<?php echo base_url().'admin/apis_manager' ?>" target="_blank">view api</a>
		<?php } ?>


		
		</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
<script src="<?=base_url();?>assets_admin/lib/chart.js/Chart.bundle.min.js"></script>
<script src="<?=base_url();?>assets_admin/lib/morris.js/morris.min.js"></script>
<script src="<?=base_url();?>assets_admin/lib/raphael/raphael.min.js"></script>

<script src="<?=base_url();?>assets_admin/lib/jquery.flot/jquery.flot.js"></script>
<script src="<?=base_url();?>assets_admin/lib/jquery.flot/jquery.flot.pie.js"></script><!-- 
<script src="<?=base_url();?>assets_admin/lib/bootstrap/js/bootstrap.bundle.min.js"></script> -->

<script src="<?=base_url();?>assets_admin/lib/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>assets_admin/lib/datatables.net-dt/js/dataTables.dataTables.min.js"></script>
<script src="<?=base_url();?>assets_admin/lib/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url();?>assets_admin/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
   // For a doughnut chart
		$('.table').DataTable({
		 "ordering": true,
			responsive: true,
				language: {
				searchPlaceholder: 'Search...',
				sSearch: '',
			}
        });
		
		
		$('[data-toggle="popover"]').popover();

        $('[data-popover-color="head-primary"]').popover({
          template: '<div class="popover popover-head-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        });
		
		
<?php 
	if(isset($graph_data['keyword_distribution']['current_record']) && !empty($graph_data['keyword_distribution']['current_record'])){
		
		$top_3 = (isset($graph_data['keyword_distribution']['current_record']->top_3) && !empty($graph_data['keyword_distribution']['current_record']->top_3)) ? $graph_data['keyword_distribution']['current_record']->top_3 : 0;
		$top_10 = (isset($graph_data['keyword_distribution']['current_record']->top_10) && !empty($graph_data['keyword_distribution']['current_record']->top_10)) ? $graph_data['keyword_distribution']['current_record']->top_10 : 0;
		$top_100 = (isset($graph_data['keyword_distribution']['current_record']->top_100) && !empty($graph_data['keyword_distribution']['current_record']->top_100)) ? $graph_data['keyword_distribution']['current_record']->top_100 : 0;
		$no_rank = (isset($graph_data['keyword_distribution']['current_record']->no_rank) && !empty($graph_data['keyword_distribution']['current_record']->no_rank)) ? $graph_data['keyword_distribution']['current_record']->no_rank : 0;
		
		

?>
	var datapie = {
    labels: ['Top 3 Keywords', 'Top 10 Keywords', 'Top 100 Keywords', 'No Rank Keywords'],
    datasets: [{
      data: [20,30,12,32],
      backgroundColor: ['#5620cd', '#fb0d1c','#69cf30','#3ea2ff']
    }]
  };
  var optionpie = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false,
    },
    animation: {
      animateScale: true,
      animateRotate: true
    }
  };
 var ctx6 = document.getElementById('chartPie');
  var myPieChart6 = new Chart(ctx6, {
    type: 'doughnut',
    data: datapie,
    options: optionpie
  });
  
<?php } ?>
		
});
</script>
<?php 
	function getLastChangeValue($value,$postion_type = ''){
		$result = '';
		if(!empty($value)){
			if($postion_type == "average_position"){
				if($value > 0){
					$day_change_cls = 'negative';
					$day_change_arrow = '<i class="fa fa-caret-down"></i>';
					$day_change_values = $value;
				}else{
					
					$day_change_cls = 'postive';
					$day_change_arrow = '<i class="fa fa-caret-up"></i>';
					$day_change_values = str_replace('-','',$value);
				}
			}elseif($postion_type == "up_down_down"){
				$day_change_cls = 'negative';
				$day_change_arrow = '<i class="fa fa-caret-down"></i>';
				$day_change_values = $value;
			}else{
				if($value == "appeared"){
					$day_change_cls = 'postive';
					$day_change_arrow = '<i class="fa fa-caret-up"></i>';
					$day_change_values = '∞';
				}elseif($value == "disappeared"){
					if($postion_type == "last_position_change"){
						$day_change_cls = 'blank';
						$day_change_arrow = '<i class="fa fa-circle"></i>';
						$day_change_values = '';
					}else{
						$day_change_cls = 'negative';
						$day_change_arrow = '<i class="fa fa-caret-up"></i>';
						$day_change_values = "∞";
					}
				}elseif($value > 0){
					$day_change_cls = 'postive';
					$day_change_arrow = '<i class="fa fa-caret-up"></i>';
					$day_change_values = $value;
				}elseif($value == 0){
					$day_change_cls = 'postive';
					$day_change_arrow = '<i class="fa fa-caret-up"></i>';
					$day_change_values = $value;
				}else{
					$day_change_cls = 'negative';
					$day_change_arrow = '<i class="fa fa-caret-down"></i>';
					$day_change_values = str_replace('-','',$value);
				}
			}
			
			
		}else{
			if($postion_type == "last_position_change"){
				$day_change_cls = 'blank';
				$day_change_arrow = '<i class="fa fa-circle"></i>';
				$day_change_values = '';
			}else{
				$day_change_cls = 'blank';
				$day_change_arrow = '<i class="fa fa-circle"></i>';
				$day_change_values = '';
			}
			
		}
		
		
		
		$result = '<span class="last_day_change '.$day_change_cls.'">'.$day_change_arrow.$day_change_values.'</span>';		
		
		return $result;
	}
?>