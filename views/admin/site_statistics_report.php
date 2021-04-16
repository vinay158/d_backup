<?php $this->load->view("admin/include/header"); ?>
<link href="<?=base_url();?>assets_admin/lib/lightslider/css/lightslider.min.css" rel="stylesheet">
<link href="<?=base_url();?>assets_admin/lib/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet">

<link href="<?=base_url();?>assets_admin/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css" rel="stylesheet">
<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));

</script>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
 <div class="az-content-body-left  advanced_page custom_full_page site_statistics_report_page" >
	  <div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
            <div>
              <h2 class="az-dashboard-title">Site Statistics</h2>
            </div>      
          </div>
      </div><!-- az-content-header -->
	  
	  
       <div class="row row-sm">
          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 ">
				<div class="az-dashboard-nav">
				<nav class="nav">   
					<?php echo $this->query_model->getSiteStatisticsNavMenu($report_type,$sort); ?>
					
				</nav>
				<a class="view_night_watch_trackr" href="<?php echo base_url().'admin/search_engine_rankings_report' ?>" target="_blank">Click Here To View Search Engine Rankings Report</a>
          </div>
	
	
	  <div class=" d-block az-content-heading tx-24 mg-b-10 mg-t-10 mg-b-lg-8">
			<div class="float-left col-sm-8">
				<div class="row">
			  <h2 class="az-content-title tx-24 mg-b-5 mg-t-10 mg-b-lg-8">How many people visit the website?</h2>
          <p class="mg-b-0">The Ranking Monitor can check the position of your website in <span class="graph_total_countries">0</span> countries and <span class="graph_total_languages">0</span> languages.</p>
			</div></div>
			<div class="dropdown float-right">
			
				<button class="btn dropdown-toggle btn-outline-indigo" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  <?php echo date('d M Y', strtotime($dateRanges['start_date'])).' to '.date('d M Y', strtotime($dateRanges['end_date'])) ?>
				</button>
				
				<div class="dropdown-menu filter_date_dropdown  tx-13" aria-labelledby="dropdownMenuButton">
				<?php foreach($dateRanges['sorting_list'] as $key => $val){ ?>
				  <a class="dropdown-item <?php echo ($sort == $key) ? 'active' : ''; ?>" href="<?php echo base_url().'admin/site_statistics/report?sort='.$key; ?><?php echo isset($_GET['type']) ? '&type='.$_GET['type'] : ''; ?>"><?php echo $val; ?></a>
				<?php } ?>
				</div>
			</div>
		</div>
	  
	  
	   <div class="row row-sm mg-b-15 mg-sm-b-20 mg-sm-t-20 numberrow">
          <div class="col-md-3 col-lg-3 col-xl-3 col-xl-3">

            <div class="card card-dashboard-twentytwo">
              <div class="media">
                <div class="media-body">
                  <h6 class="graph_total_website_visitor">0</h6>
                  <span>Website Visitor</span>
                </div>
              </div>
              

            </div><!-- card -->

          </div><!-- col -->

          <div class="col-md-3 col-lg-3 col-xl-3 mg-t-20 mg-md-t-0 ">

            <div class="card card-dashboard-twentytwo">

              <div class="media">


                <div class="media-body">

                  <h6 class="total_unique_leads"><?php echo $total_unique_leads; ?></h6>

                  <span >Website Leads</span>
                </div>

              </div>

              
 
            </div><!-- card -->

          </div><!-- col-3 -->                                               

          <div class="col-md-3 col-lg-3 col-xl-3  mg-t-20 mg-md-t-0">

            <div class="card card-dashboard-twentytwo">

              <div class="media">


                <div class="media-body">

                  <h6 class="graph_conversion_rate">0</h6>
                  <span>Conversion Rate</span>
                </div>

              </div>

             

            </div><!-- card -->

          </div><!-- col -->
		  <div class="col-md-3 col-lg-3 col-xl-3  mg-t-20 mg-md-t-0">

            <div class="card card-dashboard-twentytwo">

              <div class="media">


                <div class="media-body">

                  <h6 class="graph_conversion_rate">0</h6>
                  <span>Conversion Rate</span>
                </div>

              </div>

             

            </div><!-- card -->

          </div><!-- col -->
          
        </div><!-- row -->
		
		<div class="row row-sm mg-b-15 mg-sm-b-20 ">
		 <div class="col-sm-6 col-xl-6 col-lg-6">
			<div class="cards redbtn"><i class="typcn typcn-phone"></i>Traffic sources </div>
            <div class="card card-dashboard-twentyfive keyword-bar card-body">
				<div id="chart-1-container" class="ht-200 ht-sm-300"></div>
			</div>
		</div>
		<div class="col-sm-6 col-xl-6 col-lg-6">
			<div class="cards redbtn"><i class="typcn typcn-phone"></i>Countries </div>
            <div class="card card-dashboard-twentyfive keyword-bar card-body">
				<div id="chart-2-container" class="ht-200 ht-sm-300"></div>
			</div>
		</div>
	  
	  
			</div>	
	<div class="row row-sm mg-b-15 mg-sm-b-20 ">
			 <div class="col-sm-6 col-xl-6 col-lg-6">
				<div class="cards redbtn"><i class="typcn typcn-phone"></i> <span class="graph_site_session">0</span> sessions (<span class="graph_site_per_day_session">0</span>/day) </div>
				<div class="card card-dashboard-twentyfive keyword-bar card-body">
					<div id="chart-3-container" class="ht-200 ht-sm-300"></div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-6 col-lg-6">
				<div class="cards redbtn"><i class="typcn typcn-phone"></i> Pages per session (<span class="graph_pages_per_session">0</span>) </div>
				<div class="card card-dashboard-twentyfive keyword-bar card-body">
					<div id="chart-4-container" class="ht-200 ht-sm-300"></div>
				</div>
			</div>
		  
		  
				</div>	
	<div class="row row-sm mg-b-15 mg-sm-b-20 ">
			 <div class="col-sm-6 col-xl-6 col-lg-6">
				<div class="cards redbtn"><i class="typcn typcn-phone"></i> Average time on site (<span class="graph_avg_time_on_site">0</span>s) </div>
				<div class="card card-dashboard-twentyfive keyword-bar card-body">
					<div id="chart-5-container" class="ht-200 ht-sm-300"></div>
				</div>
			</div>
			<div class="col-sm-6 col-xl-6 col-lg-6">
				<div class="cards redbtn"><i class="typcn typcn-phone"></i> <span class="graph_new_users">0</span> new users (<span class="graph_per_day_users">0</span>/day) </div>
				<div class="card card-dashboard-twentyfive keyword-bar card-body">
					<div id="chart-6-container" class="ht-200 ht-sm-300"></div>
				</div>
			</div>
			</div>	
	<div class="row row-sm mg-b-15 mg-sm-b-20 ">		
			<div class="col-sm-6 col-xl-6 col-lg-6">
				<div class="cards redbtn"><i class="typcn typcn-phone"></i> Bounce rate (<span class="graph_bounce_rate">0</span>%)  </div>
				<div class="card card-dashboard-twentyfive keyword-bar card-body">
					<div id="chart-7-container" class="ht-200 ht-sm-300"></div>
				</div>
			</div></div>
		  
	  
					
			</div>
      	
			
     </div><!-- az-content-body -->
    
    </div><!-- az-content -->
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

<script>

gapi.analytics.ready(function() {

  /**
   * Authorize the user with an access token obtained server side.
   */
  gapi.analytics.auth.authorize({
    'serverAuth': {
      'access_token': '<?php echo $access_token; ?>'
    }
  });

var start_date = "<?php echo $dateRanges['start_date'] ?>";
var end_date = "<?php echo $dateRanges['end_date'] ?>";


gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
   // var formattedJson = JSON.stringify(response.result, null, 2);
   // document.getElementById('chart-4-container').value = formattedJson;
	var res_data = response.result.rows[0];
	$('.graph_total_website_visitor').html(res_data);
	
	var total_unique_leads = $('.total_unique_leads').html();
	var graph_conversion_rate = (parseInt(total_unique_leads) * 100) / parseFloat(res_data);
	graph_conversion_rate = Number.parseFloat(graph_conversion_rate).toFixed(1);
	$('.graph_conversion_rate').html(graph_conversion_rate+'%');
	
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
       metrics: 'ga:users,ga:pageviews,ga:goalConversionRateAll,ga:avgTimeOnPage',
      dimensions: 'ga:source',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-1-container',
      type: 'PIE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart1.execute();
  
  
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  var dataChart2 = new gapi.analytics.googleCharts.DataChart({
    query: {
      //'ids': 'ga:100367422', // <-- Replace with the ids value for your view.
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
       metrics: 'ga:sessions',
      dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-2-container',
      type: 'PIE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart2.execute();
  
  
  
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  /*var dataChart3 = new gapi.analytics.googleCharts.DataChart({
    query: {
     'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
       metrics: 'ga:sessions',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
      //'max-results': 6,
      //sort: '-ga:sessions'
    },
    chart: {
      container: 'chart-3-container',
      type: 'LINE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart3.execute();*/
  
  /***********chart-3-container*************/
  gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	   metrics: 'ga:sessions,ga:users',
      dimensions: 'ga:date,ga:userType',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
    var res_data = response.result.rows;
	
	var total_sessions = response.result.totalsForAllResults['ga:sessions'];
	$('.graph_site_session').html(total_sessions);
	var bitween_days = '<?php echo $bitween_days ?>';
	var per_day_data = parseFloat(total_sessions) / bitween_days;
	per_day_data = Number.parseFloat(per_day_data).toFixed(2);
	$('.graph_site_per_day_session').html(per_day_data);
	
	var graphData = [];
	$.each(res_data, function(i, item) {
		var date = item[0];
		date = date.match(new RegExp('.{1,4}', 'g')).join("-");
		date = date.match(new RegExp('.{1,7}', 'g')).join("-");
		
		graphData.date = [];
		if(item[1] == "New Visitor"){
			graphData.push({period: date, new_user: item[3],user_type:item[1]});
		}else{
			graphData.push({period: date, returning_user: item[3],user_type:item[1]});
		}
		
	});
	
	let finalObj = {}
      graphData.forEach((games) => {
        const date = games.period.split('T')[0]
        if (finalObj[date]) {
          finalObj[date].push(games);
        } else {
          finalObj[date] = [games];
        }
      })
    
	var responseData = [];
	$.each(finalObj, function(i, item) {
		var new_user = 0;
		var returning_user = 0;
		$.each(item, function(a, value) {
			if(value.user_type == "New Visitor"){
				new_user = value.new_user;
			}else{
				returning_user = value.returning_user;
			}
		});
		responseData.push({period: i, new_user : new_user, returning_user: returning_user});
	});
	
	 Morris.Line({
	  element: 'chart-3-container',
	  data: responseData,
	  lineColors: ['#007bff', '#f10075'],
	  xkey: 'period',
	  ykeys: ['new_user','returning_user'],
	  labels: ['New Customer', 'Returning Customer'],
	  xLabels: 'day',
	  xLabelAngle: 45,
	  resize: true
	});
	
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
  
  
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
 /* var dataChart4 = new gapi.analytics.googleCharts.DataChart({
    query: {
     'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
       metrics: 'ga:pageviewsPerSession',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-4-container',
      type: 'LINE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart4.execute();*/
  
  
  /***********chart-4-container*************/
  gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	   metrics: 'ga:users,ga:pageviewsPerSession',
      dimensions: 'ga:date,ga:userType',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
    var res_data = response.result.rows;
	
	var total_pageviews_per_session = response.result.totalsForAllResults['ga:pageviewsPerSession'];
	total_pageviews_per_session = Number.parseFloat(total_pageviews_per_session).toFixed(2);
	$('.graph_pages_per_session').html(total_pageviews_per_session);
	
	var graphData = [];
	$.each(res_data, function(i, item) {
		var date = item[0];
		date = date.match(new RegExp('.{1,4}', 'g')).join("-");
		date = date.match(new RegExp('.{1,7}', 'g')).join("-");
		
		var data_value = Number.parseFloat(item[3]).toFixed(2);
		
		if(item[1] == "New Visitor"){
			graphData.push({period: date, new_user: data_value,user_type:item[1]});
		}else{
			graphData.push({period: date, returning_user: data_value,user_type:item[1]});
		}
		
	});
	
	let finalObj = {}
      graphData.forEach((games) => {
        const date = games.period.split('T')[0]
        if (finalObj[date]) {
          finalObj[date].push(games);
        } else {
          finalObj[date] = [games];
        }
      })
    
	var responseData = [];
	$.each(finalObj, function(i, item) {
		var new_user = 0;
		var returning_user = 0;
		$.each(item, function(a, value) {
			if(value.user_type == "New Visitor"){
				new_user = value.new_user;
			}else{
				returning_user = value.returning_user;
			}
		});
		responseData.push({period: i, new_user : new_user, returning_user: returning_user});
	});
	
	 Morris.Line({
	  element: 'chart-4-container',
	  data: responseData,
	  lineColors: ['#007bff', '#f10075'],
	  xkey: 'period',
	  ykeys: ['new_user','returning_user'],
	  labels: ['New Customer', 'Returning Customer'],
	  xLabels: 'day',
	  xLabelAngle: 45,
	  resize: true
	});
	
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
  
  
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  /*var dataChart5 = new gapi.analytics.googleCharts.DataChart({
    query: {
     'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
     metrics: 'ga:avgTimeOnPage',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-5-container',
      type: 'LINE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart5.execute();*/
  
  /***********chart-5-container*************/
  gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	   metrics: 'ga:users,ga:avgTimeOnPage',
      dimensions: 'ga:date,ga:userType',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
    var res_data = response.result.rows;
	var total_avg_time_on_page = response.result.totalsForAllResults['ga:avgTimeOnPage'];
	total_avg_time_on_page = Number.parseFloat(total_avg_time_on_page).toFixed(2);
	$('.graph_avg_time_on_site').html(total_avg_time_on_page);
	//alert(formattedJson);//
	var graphData = [];
	$.each(res_data, function(i, item) {
		var date = item[0];
		date = date.match(new RegExp('.{1,4}', 'g')).join("-");
		date = date.match(new RegExp('.{1,7}', 'g')).join("-");
		
		var data_value = Number.parseFloat(item[3]).toFixed(2);
		
		if(item[1] == "New Visitor"){
			graphData.push({period: date, new_user: data_value,user_type:item[1]});
		}else{
			graphData.push({period: date, returning_user: data_value,user_type:item[1]});
		}
		
	});
	
	let finalObj = {}
      graphData.forEach((games) => {
        const date = games.period.split('T')[0]
        if (finalObj[date]) {
          finalObj[date].push(games);
        } else {
          finalObj[date] = [games];
        }
      })
    
	var responseData = [];
	$.each(finalObj, function(i, item) {
		var new_user = 0;
		var returning_user = 0;
		$.each(item, function(a, value) {
			if(value.user_type == "New Visitor"){
				new_user = value.new_user;
			}else{
				returning_user = value.returning_user;
			}
		});
		responseData.push({period: i, new_user : new_user, returning_user: returning_user});
	});
	
	 Morris.Line({
	  element: 'chart-5-container',
	  data: responseData,
	  lineColors: ['#007bff', '#f10075'],
	  xkey: 'period',
	  ykeys: ['new_user','returning_user'],
	  labels: ['New Customer', 'Returning Customer'],
	  xLabels: 'day',
	  xLabelAngle: 45,
	  resize: true
	});
	
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
  
  
  
	
  
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  /*var dataChart6 = new gapi.analytics.googleCharts.DataChart({
    query: {
     'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
     metrics: 'ga:newUsers',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-6-container',
      type: 'LINE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart6.execute();*/
  
   /***********chart-6-container*************/
  gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	   metrics: 'ga:newUsers',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
    var res_data = response.result.rows;
	var total_new_users = response.result.totalsForAllResults['ga:newUsers']; 
	$('.graph_new_users').html(total_new_users);
	var bitween_days = '<?php echo $bitween_days ?>';
	var per_day_data = parseFloat(total_new_users) / bitween_days;
	per_day_data = Number.parseFloat(per_day_data).toFixed(2);
	$('.graph_per_day_users').html(per_day_data);
	//alert(formattedJson);
	var graphData = [];
	$.each(res_data, function(i, item) {
		var date = item[0];
		date = date.match(new RegExp('.{1,4}', 'g')).join("-");
		date = date.match(new RegExp('.{1,7}', 'g')).join("-");
		
		graphData.push({period: date, new_user: item[1]});
		
	});
	
	 Morris.Line({
	  element: 'chart-6-container',
	  data: graphData,
	  lineColors: ['#007bff'],
	  xkey: 'period',
	  ykeys: ['new_user'],
	  labels: ['New Customer'],
	  xLabels: 'day',
	  xLabelAngle: 45,
	  resize: true
	});
	
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
  
  
  
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
 /* var dataChart7 = new gapi.analytics.googleCharts.DataChart({
    query: {
     'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:bounceRate',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-7-container',
      type: 'LINE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart7.execute();*/
  
   /***********chart-7-container*************/
  gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	   metrics: 'ga:users,ga:bounceRate',
      dimensions: 'ga:date,ga:userType',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
   //var formattedJson = JSON.stringify(response.result, null, 2);
    var res_data = response.result.rows;
	var total_bounceRate = response.result.totalsForAllResults['ga:bounceRate'];
	total_bounceRate = Number.parseFloat(total_bounceRate).toFixed(2);
	$('.graph_bounce_rate').html(total_bounceRate);
	//alert(formattedJson);
	var graphData = [];
	$.each(res_data, function(i, item) {
		var date = item[0];
		date = date.match(new RegExp('.{1,4}', 'g')).join("-");
		date = date.match(new RegExp('.{1,7}', 'g')).join("-");
		
		var data_value = Number.parseFloat(item[3]).toFixed(2);
		
		if(item[1] == "New Visitor"){
			graphData.push({period: date, new_user: data_value,user_type:item[1]});
		}else{
			graphData.push({period: date, returning_user: data_value,user_type:item[1]});
		}
		
	});
	
	let finalObj = {}
      graphData.forEach((games) => {
        const date = games.period.split('T')[0]
        if (finalObj[date]) {
          finalObj[date].push(games);
        } else {
          finalObj[date] = [games];
        }
      })
    
	var responseData = [];
	$.each(finalObj, function(i, item) {
		var new_user = 0;
		var returning_user = 0;
		$.each(item, function(a, value) {
			if(value.user_type == "New Visitor"){
				new_user = value.new_user;
			}else{
				returning_user = value.returning_user;
			}
		});
		responseData.push({period: i, new_user : new_user, returning_user: returning_user});
	});
	
	 Morris.Line({
	  element: 'chart-7-container',
	  data: responseData,
	  lineColors: ['#007bff', '#f10075'],
	  xkey: 'period',
	  ykeys: ['new_user','returning_user'],
	  labels: ['New Customer', 'Returning Customer'],
	  xLabels: 'day',
	  xLabelAngle: 45,
	  resize: true
	});
	
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
  
  
  
  /**********************************/
 /* gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:sessions',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
   // document.getElementById('chart-4-container').value = formattedJson;
	var res_data = response.result.rows[0];
	$('.graph_site_session').html(res_data);
	
	var bitween_days = '<?php echo $bitween_days ?>';
	var per_day_data = parseFloat(res_data) / bitween_days;
	per_day_data = Number.parseFloat(per_day_data).toFixed(2);
	$('.graph_site_per_day_session').html(per_day_data);
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });*/


/**********************************/
  /*gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:pageviewsPerSession',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
   // document.getElementById('chart-4-container').value = formattedJson;
	var res_data = response.result.rows[0];
	res_data = Number.parseFloat(res_data).toFixed(2);
	$('.graph_pages_per_session').html(res_data);
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });*/


/**********************************/
 /* gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:avgTimeOnPage',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
    var formattedJson = JSON.stringify(response.result, null, 2); 
   // document.getElementById('chart-4-container').value = formattedJson;
	var res_data = response.result.rows[0];
	res_data = Number.parseFloat(res_data).toFixed(2);
	$('.graph_avg_time_on_site').html(res_data); 
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });*/

/**********************************/
 /*gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:newUsers',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
   // document.getElementById('chart-4-container').value = formattedJson;
	var res_data = response.result.rows[0];
	$('.graph_new_users').html(res_data);
	
	var bitween_days = '<?php echo $bitween_days ?>';
	var per_day_data = parseFloat(res_data) / bitween_days;
	per_day_data = Number.parseFloat(per_day_data).toFixed(2);
	$('.graph_per_day_users').html(per_day_data);
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });*/


/**********************************/
 /*gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:bounceRate',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
   // var formattedJson = JSON.stringify(response.result, null, 2);
	// document.getElementById('chart-4-container').value = formattedJson;
	var res_data = response.result.rows[0];
	res_data = Number.parseFloat(res_data).toFixed(2);
	$('.graph_bounce_rate').html(res_data);
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });*/

/**********************************/
 gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	 metrics: 'ga:users',
      dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
   // var formattedJson = JSON.stringify(response.result, null, 2);
	
	var res_data = response.result.rows
	var total_record = 0;
	$.each(res_data, function(i, item) {
		total_record += 1;
	});
	
	$('.graph_total_countries').html(total_record);
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });


/**********************************/
 gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	 metrics: 'ga:users',
      dimensions: 'ga:language',
      'start-date': start_date,
      'end-date': end_date
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	
	var res_data = response.result.rows
	var total_record = 0;
	$.each(res_data, function(i, item) {
		total_record += 1;
	});
	$('.graph_total_languages').html(total_record);
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });





});
</script>

