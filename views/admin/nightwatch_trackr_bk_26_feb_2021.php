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
					
	<div class="col-lg-3">
      <h1>Groups</h1>
     <select name="url_type" id="" class="form-control url_types">
		<?php foreach($api_reponse_data['url_types'] as $key => $val){ ?>
			<option value="<?php echo $key; ?>" <?php echo (isset($searchData['url_type']) && $searchData['url_type'] == $key) ? 'selected=selected' : '' ; ?>><?php echo ucfirst($val); ?></option>
		<?php } ?>
		</select>
      
   </div>
 
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
							<div class="row row-sm mg-b-15 mg-sm-b-20 ">
			
		<?php if(isset($api_reponse_data['keywords_list']) && !empty($api_reponse_data['keywords_list']) ){ ?>
			<div class="col-sm-12 col-xl-12 col-lg-12 nopadding">
				<!--<div class="mb-3 main-content-label" >Keywords List</div> --->
				<div class=" card-dashboard-twentyfive keyword-bar backlinks-link card-body">
				
				<table id="example3" class="table ">
				<thead>
				<tr>
				<th class="wd-5p">No.</th>
				<th class="wd-10p">Keyword <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Keyword" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">Rank <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Rank " data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">Language <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Language" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<th  class="wd-10p">Country <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Country" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">Evolution <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Evolution" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">D/W/M Changes <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Evolution" data-content="Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."><i class="fa fa-question-circle"></i></span></th>
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
				<td><?php echo $keyword->query; ?> <br/><span style="font-size:10px"><?php echo $keyword->uri; ?></span></td>
				<td class="last_changes"><?php echo !empty($keyword->position) ? $keyword->position : '/'; ?> 
				<?php //if(isset($keyword->last_position_change[0]) && !empty($keyword->last_position_change[0])){ ?>
				<?php 
					$last_position_change = $keyword->last_position_change[0];
					
					echo getLastChangeValue($last_position_change,'last_position_change');
				?>
				
				<td ><?php echo $keyword->id; ?><?php //echo $keyword->google_hl; ?></td>
				<td  ><?php echo $keyword->google_gl; ?></td>
				<td ><img src="https://api.ranktrackr.com/<?php echo $keyword->mini_graph; ?>" width="125px"></td>
				<td class="last_changes">
					<?php 
						echo getLastChangeValue($keyword->last_day_change);
						echo getLastChangeValue($keyword->last_week_change);
						echo getLastChangeValue($keyword->last_month_change);
					?>
					
				<td ><?php echo $keyword->adwords_global_search_volume; ?></td>
				<td ><?php echo $keyword->adwords_global_average_cpc; ?></td>
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
		
});
</script>
<?php 
	function getLastChangeValue($value,$postion_type = ''){
		$result = '';
		if(!empty($value)){
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