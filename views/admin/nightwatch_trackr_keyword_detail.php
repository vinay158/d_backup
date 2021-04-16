<?php $this->load->view("admin/include/header"); ?>
<link href="<?=base_url();?>assets_admin/lib/lightslider/css/lightslider.min.css" rel="stylesheet">
<link href="<?=base_url();?>assets_admin/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">

<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>

<div class="az-content-body-left advanced_page custom_full_page rank_traker_api_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><span>SERP Preview</span></h2>
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


<div style="clear:both"></div> 
<form action="" method="get">
<div class="col-sm-12 col-xl-12 col-lg-12 nopadding">
				<div class="mb-3 main-content-label selected_date_heading" >Date : <?php echo (strtotime($dateRanges['start_date']) != strtotime($dateRanges['end_date'])) ?  date('d M Y', strtotime($dateRanges['start_date'])).' to '.date('d M Y', strtotime($dateRanges['end_date'])) : date('d M Y', strtotime($dateRanges['start_date'])); ?>					<span style="float:right"><a class="back_search_engine_page" href="<?php echo base_url().'admin/search_engine_rankings_report' ?>">Back</a></span>
				</div>								
				<div class=" card-dashboard-twentyfive keyword-bar backlinks-link card-body">
					<div class="row row-sm mg-b-20">
	
 

   <div class="col-lg-3"> 
   <h1>Date</h1>
		<select name="date_sort" id="" class="form-control sort_dates">
		<?php foreach($dateRanges['sorting_list'] as $key => $val){ ?>
			<option value="<?php echo $key; ?>" <?php echo ($key == $date_sort) ? 'selected=selected' : '' ?>><?php echo $val; ?></option>
		<?php } ?>
		</select>
	</div>
	
   
  <!-- <div class="col-lg-3">
	 <div class="col-lg-12 float-left">
       <input type="submit"  value="Search" class="btn-save" />
	 </div>
	
   </div>-->
   
   
</div>
<!-- row -->

				</div>
			</div>
</form>			
<?php 
$graph_start_date = date('d M Y', strtotime($dateRanges['start_date']));
$graph_end_date = date('d M Y', strtotime($dateRanges['end_date']));
?>		
		

<div class="panel-body ordersListTable rank_traker_response">
				<div class="panel-body-holder">
					<div class="form-holder">
					
					<div class="col-sm-12 col-xl-12 mg-t-20 col-lg-12 site-statics statics_box">

			<div class="card card-dashboard-twentyfive keyword-bar card-body">
			<div class="row keyword_box_data1">
            
			  <div class="col-7 col-sm-7 custom-keyword-box">
                <div class="chart-wrapper">
                  <div id="chart-1-container" class="custom_graph active"></div>
				  <div class="upload_img_pre_loader_graph" style="display:none"><img src="<?=base_url();?>assets_admin/img/pre_loader.gif"></div>
				  <?php foreach($dateRanges['sorting_list'] as $key => $val){ ?>
					<div id="chart-2-container_<?php echo $key; ?>" class="custom_graph" type="0" style="display:none"></div>
				  <?php } ?>
				 
                </div><!-- chart-wrapper -->
              </div><!-- col -->
             
				 <div class="col-5 col-sm-5 nopadding custom-keyword-box srep_preview" style="width:400px">
					<?php if(isset($keyword_serp_data) && !empty($keyword_serp_data)){ ?>
						<div class="srep_preview_box top1">
							<div class="col-sm-12"><h6>SERP Preview</h6></div>
							<div class="col-sm-5 float-left" style="padding-right:0px"><?php echo $keyword_serp_data->keyword; ?></div>
							<div class="col-sm-2 float-left nopadding">
							<img src="https://flagcdn.com/16x12/<?php echo $keyword_serp_data->data_center; ?>.png" srcset="https://flagcdn.com/32x24/<?php echo $keyword_serp_data->data_center; ?>.png 2x,   https://flagcdn.com/48x36/<?php echo $keyword_serp_data->data_center; ?>.png 3x" width="16" height="12" alt="<?php echo $keyword_serp_data->data_center; ?>"> <?php echo $keyword_serp_data->locale; ?> </div>
							<div class="col-sm-2 float-left keyword_location_box nopadding"><span class="keyword_location" data-toggle="tooltip-primary" data-placement="top" title="" data-original-title="<?php echo $keyword_serp_data->location; ?>"><i class="fas fa-map-marker-alt"></i></span> <?php echo ucwords($keyword_serp_data->data_center); ?></div>
							
							<div class="col-sm-3 float-left nopadding keyword_rank_date"><?php echo date('M d, Y',strtotime($keyword_serp_data->rank_date)); ?></div>
						</div>
						<div class="srep_preview_box top2">
							<div class="col-sm-12">

								<div class="col-sm-10 search_box float-left "><?php echo $keyword_serp_data->keyword; ?></div>
								<div class="col-sm-2 search_icon float-left"><i class="fa fa-search" aria-hidden="true"></i></div>
							</div>
						</div>
						
						<div  id="azChatList" class="srep_preview_records az-chat-list" style="height:500px; clear:both">
							<div class="upload_img_pre_loader" style="display:none"><img src="<?=base_url();?>assets_admin/img/pre_loader.gif"></div>
							<div class="get_keyword_serp_data">
								<?php 
										if(isset($keyword_serp_data->serp) && !empty($keyword_serp_data->serp)){ 
										$i = 1;
											foreach($keyword_serp_data->serp as $serp_data){
									?>

									<div class="srep_preview_record">
										<div class="col-sm-1 s_no float-left nopadding"><?php echo $i; ?>. </div>
										<div class="col-sm-11 result float-left nopadding">
											<h6 class="heading"><a href="<?php echo $serp_data->href; ?>"><?php echo $serp_data->title; ?></a></h6>
											<p class="url"><?php echo $serp_data->href; ?></p>
											<p class="description"><?php echo $serp_data->description; ?></p>
										</div>
									</div>

									<?php $i++; } }  ?>
							</div>
						</div>
					<?php }	?>
				 </div><!-- col -->
              
			 
			
            </div>
			
			</div>
		 </div>
		 
		

						</div>
					</div>
			</div>
			


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
<script src="<?=base_url();?>assets_admin/lib/jquery.flot/jquery.flot.pie.js"></script>

<?php 
	if(!empty($keyword_result)){ 
	echo '<div class="keyword_result">';
		foreach($keyword_result as $key => $val){
?>
		<input type="hidden" id="date_<?php echo $key; ?>" value="<?php echo $val; ?>">
	<?php } 
	echo '</div>';
	} ?>
	
<?php $page_url = base_url().'admin/search_engine_rankings_report/keyword/'.$this->uri->segment(4); ?>

<script>

 $(function(){

        'use strict'


        if(window.matchMedia('(min-width: 992px)').matches) {
          new PerfectScrollbar('#azChatList', {
            suppressScrollX: true,
			minScrollbarLength: 100
          });

        }
});
	  
  

	$(document).ready(function() {
	
		
		 <?php 
			if(isset($keyword_average_position['average_position']) && !empty($keyword_average_position['average_position'])){ 
					
					$keyword_position =	$keyword_average_position['average_position'];
					
					if(!empty($keyword_position['graph'])){
		?>


		if ($('#chart-1-container').length){
			var min_value = <?php echo (isset($keyword_position['min_value']) && !empty($keyword_position['min_value'])) ? $keyword_position['min_value'] : 0; ?>;
			var max_value = <?php echo (isset($keyword_position['max_value']) && !empty($keyword_position['max_value'])) ? $keyword_position['max_value'] : 0; ?>;
			var graphData = [];
			var colors = [];
			<?php 
				$old_graph_value = 0;
				foreach($keyword_position['graph'] as $series){
				$graph_val = !empty($series[1]) ? $series[1] : 0; 
				
			?>
				graphData.push({period: "<?php echo $series[0] ?>", average_position: "<?php echo $graph_val ?>"});
				
				<?php if($old_graph_value < $graph_val){ ?>
						colors.push("red");
				<?php  }elseif($old_graph_value > $graph_val){ ?>
						colors.push("green");
				<?php }else{ ?>
						colors.push("blue");
				<?php }
					$old_graph_value = $graph_val;
				?>
				
				
			<?php } ?>
			//console.log('container==>chart-<?php echo $key; ?>-container===>'+min_value+'==>'+max_value+ colors);
			//console.log(colors);
			Morris.Line({
				  element: 'chart-1-container',
				  data: graphData,
				  lineColors: ['#007bff'],
				  xkey: 'period',
				  ykeys: ['average_position'],
				  labels: ['Average Position'],
				  xLabels: 'day',
				  xLabelAngle: 45,
				  resize: true,
				  hideHover: 'auto',
				  stacked: true,
				  grid: true,
				  ymin: max_value,
				  ymax: 1,
				  lineWidth : 2,
				  smooth : false
				  //axes: "no",
				});

			}

			<?php } } ?>
			
	var thisDate;		
	$('body').on('click','#chart-1-container svg,#chart-2-container_last_1_days svg,#chart-2-container_last_2_days svg,#chart-2-container_last_7_days svg,#chart-2-container_last_14_days svg,#chart-2-container_last_30_days svg,#chart-2-container_current_month svg,#chart-2-container_current_year svg,#chart-2-container_last_month svg,#chart-2-container_last_3_months svg,#chart-2-container_last_6_months svg,#chart-2-container_last_year svg',function(){
		var container_id = '';
		$.each($('.custom_graph'),function(){
			if($(this).hasClass("active")){
				container_id = $(this).attr('id');
			}
		})
		//alert(container_id);
		thisDate = $("#"+container_id).find(".morris-hover-row-label").html();
		//alert(thisDate);
		var keyword_id = '<?php echo $this->uri->segment(4) ?>';
		var keyword_result_id = 0;
		if ($('#date_'+thisDate).length){
			keyword_result_id = $('#date_'+thisDate).val();
		
		$('.upload_img_pre_loader').show();
		$('.srep_preview_record').hide();
		$('.get_keyword_serp_data').html('');
		
		if(thisDate != ""){
			
			
			var date = new Date(thisDate);
		
			var year = date.getFullYear();
			var month = date.toLocaleString('default', { month: 'short' });
			var day = date.getDate().toString();
			//day = 1 + parseInt(day);
			var newDate = month+' '+day+', '+year;
			
			$('.keyword_rank_date').html(newDate);
			
			
			
			const ps = new PerfectScrollbar('#azChatList', {
					suppressScrollX: true,
					minScrollbarLength: 100
				  });
				  
			$.ajax({
					url: "admin/search_engine_rankings_report/get_keyword_serp",
					type: "post",
					dataType: "html",
					data: {date:thisDate,keyword_id:keyword_id,keyword_result_id:keyword_result_id,'action':'get_keyword_serp'},
					success:function(data){
						$('.srep_preview_record').show();
						$('.get_keyword_serp_data').html(data);
						$('.upload_img_pre_loader').hide();
						ps.update();
						//$('#azChatList').scrollTop(parseInt($('#azChatList').prop('scrollHeight')) + 100);
						
					}
				});
			}
		}else{
			$('.get_keyword_serp_data').html("<span class='keyword_result_error'>No record found for this date!</span>");
		}
	})	
	
	
	$('body').on('change','.sort_dates',function(){
		var sort_date = $(this).val();
		var keyword_id = '<?php echo $this->uri->segment(4) ?>';
		$('.custom_graph').hide();
		$('.custom_graph').removeClass('active');
		$('.upload_img_pre_loader_graph').show();
		var page_url   = "<?php echo $page_url; ?>?date_sort="+sort_date;
		window.history.pushState({}, '', page_url);
		
		if($('#chart-2-container_'+sort_date).attr('type') == 1){
			
			$('#chart-2-container_'+sort_date).show();
			$('#chart-2-container_'+sort_date).addClass('active');
			$('.upload_img_pre_loader_graph').hide();
			
			$.ajax({
				url: "admin/search_engine_rankings_report/get_keyword_sort_date_format",
				type: "post",
				dataType: "json",
				data: {sort_date:sort_date,'action':'get_keyword_sort_date_format'},
				success:function(data){
					var selected_date_heading = data.selected_date_heading;
					$('.selected_date_heading').html('Date: '+selected_date_heading);
				}
			});
			
		}else{
			$.ajax({
				url: "admin/search_engine_rankings_report/get_keyword_graph_values",
				type: "post",
				dataType: "json",
				data: {sort_date:sort_date,keyword_id:keyword_id,'action':'get_keyword_graph_values'},
				success:function(data){
					if(data.respose == 1){
						
						var selected_date_heading = data.selected_date_heading;
						$('.selected_date_heading').html('Date: '+selected_date_heading);
						
						$('.upload_img_pre_loader_graph').hide();
						$('#chart-2-container_'+sort_date).show();
						$('#chart-2-container_'+sort_date).attr('type',1);
						$('#chart-2-container_'+sort_date).addClass('active');
						var min_value = data.keyword_average_position.average_position.min_value;
						var max_value = data.keyword_average_position.average_position.max_value;
						var graphData = [];
						var graph_obj = data.keyword_average_position.average_position['graph'];
						$.each(graph_obj, function(key,value) {
						  //console.log(value[0]+'==>'+value[1]);
						  var graph_value = 0;
						  if(value[1] > 0){
							graph_value = value[1];
						  }
						  graphData.push({period: value[0], average_position: graph_value});
						}); 
						
						Morris.Line({
						  element: 'chart-2-container_'+sort_date,
						  data: graphData,
						  lineColors: ['#007bff'],
						  xkey: 'period',
						  ykeys: ['average_position'],
						  labels: ['Average Position'],
						  xLabels: 'day',
						  xLabelAngle: 45,
						  resize: true,
						  hideHover: 'auto',
						  stacked: true,
						  grid: true,
						  ymin: max_value,
						  ymax: 1,
						  lineWidth : 2,
						  smooth : false
						  //axes: "no",
						});
						
					}
				}
			});
		}
						
		
			
	})

	});
</script>

