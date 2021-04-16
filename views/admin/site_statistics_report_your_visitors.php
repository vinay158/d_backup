<?php $this->load->view("admin/include/header"); ?>
<link rel="stylesheet" href="<?=base_url();?>css/blue/style.css" type="text/css" media="print, projection, screen" />
<link href="<?=base_url();?>assets_admin/lib/lightslider/css/lightslider.min.css" rel="stylesheet">
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
			  <h2 class="az-content-title tx-24 mg-b-5 mg-t-10 mg-b-lg-8">Who are your visitors?</h2>
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
	  
	<div class="row row-sm mg-b-15 mg-sm-b-20">
		<div class="col-sm-6 col-xl-6 col-lg-6">
			<div class="cards redbtn">Where do your website users live?</div>
            <div class="card card-dashboard-twentyfive keyword-bar card-body">
				<div id="chart-1-container" class="ht-200 ht-sm-300"></div>
				<table id="chart-2-container" class="table">
				   <thead>
					  <tr>
						 <th>Sr.No.</th>
						 <th class="wd-40p">Country</th>
						 <th class="wd-40p">Users</th>
					  </tr>
				   </thead>
				   <tbody>
				   </tbody>
				</table>
				
				<!--<div id="chart-2-container" class="ht-200 ht-sm-300"></div>-->
			</div>
		</div>
			
		<div class="col-sm-6 col-xl-6 col-lg-6">
		  <div class="cards redbtn" >Which languages do your visitors speak? </div>
            <div class="card card-dashboard-twentyfive keyword-bar card-body">
				<div id="chart-3-container" class="ht-200 ht-sm-300"></div>
				<table id="chart-4-container" class="table">
				   <thead>
					  <tr>
						 <th>Sr.No.</th>
						 <th class="wd-40p">Language</th>
						 <th class="wd-40p">Users</th>
					  </tr>
				   </thead>
				   <tbody>
				   </tbody>
				</table>
			</div>
		</div>
		
			</div>		

<div class="row row-sm mg-b-15 mg-sm-b-20 ">
		<div class="col-sm-6 col-xl-6 col-lg-6">
			<div class="cards redbtn" >Which web browsers do your visitors use?</div>
            <div class="card card-dashboard-twentyfive keyword-bar card-body">
				<div id="chart-5-container" class="ht-200 ht-sm-300"></div>
				<table id="chart-6-container" class="table">
				   <thead>
					  <tr>
						 <th>Sr.No.</th>
						 <th class="wd-40p">Browser</th>
						 <th class="wd-40p">Users</th>
					  </tr>
				   </thead>
				   <tbody>
				   </tbody>
				</table>
				
			</div>
		</div>
		<div class="col-sm-6 col-xl-6 col-lg-6">
			<div class="cards redbtn" >Which operating systems do your visitors use? </div>
            <div class="card card-dashboard-twentyfive keyword-bar card-body">
				<div id="chart-7-container" class="ht-200 ht-sm-300"></div>
				<table id="chart-8-container" class="table">
				   <thead>
					  <tr>
						 <th>Sr.No.</th>
						 <th class="wd-40p">Operating System</th>
						 <th class="wd-40p">Users</th>
					  </tr>
				   </thead>
				   <tbody>
				   </tbody>
				</table>
					
			</div>
		</div>
			</div>				

	  <div class="row row-sm mg-b-15 mg-sm-b-20 ">
		<div class="col-sm-6 col-xl-6 col-lg-6">
			<div class="cards redbtn" >How much can your visitors see?
</div>
            <div class="card card-dashboard-twentyfive keyword-bar card-body">
				<div id="chart-9-container" class="ht-200 ht-sm-300"></div>
				<table id="chart-10-container" class="table">
				   <thead>
					  <tr>
						 <th>Sr.No.</th>
						 <th class="wd-40p">Screen Resolution</th>
						 <th class="wd-40p">Users</th>
					  </tr>
				   </thead>
				   <tbody>
				   </tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-6 col-xl-6 col-lg-6">
			<div class="cards redbtn" >Which mobile devices do your visitors use?	 </div>
            <div class="card card-dashboard-twentyfive keyword-bar card-body">
				<div id="chart-11-container" class="ht-200 ht-sm-300"></div>
				<table id="chart-12-container" class="table">
				   <thead>
					  <tr>
						 <th>Sr.No.</th>
						 <th class="wd-60p">Mobile Device Info</th>
						 <th class="wd-40p">Users</th>
					  </tr>
				   </thead>
				   <tbody>
				   </tbody>
				</table>
			</div>
		</div>
			</div>	
	  
		
					
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

  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
     metrics: 'ga:users',
      dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
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
  /*var dataChart2 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-2-container',
      type: 'TABLE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart2.execute();*/
  
  /***************chart-2-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users',
      dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];
	
		var table; //outside your function scopes
		table = $('#chart-2-container').DataTable();
		$.each(res_data, function(i, item) {
			var users = item[1];
			var user_persent = (parseInt(users) * 100 ) / parseInt(total_users);
			user_persent =  Number.parseFloat(user_persent).toFixed(1);
			users = '<span class="data_value">'+users + '</span><strong class="data_percent">'+user_persent+'%</strong>';
			table.row.add([(parseInt(i)+1), item[0],users]).draw( false );
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
  var dataChart3 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:language',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
    },
    chart: {
      container: 'chart-3-container',
      type: 'PIE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart3.execute();
  
  
    
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  /*var dataChart4 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:language',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-4-container',
      type: 'TABLE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart4.execute();*/
  
   /***************chart-4-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users',
      dimensions: 'ga:language',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];
	
		var table; //outside your function scopes
		table = $('#chart-4-container').DataTable();
		$.each(res_data, function(i, item) {
			var users = item[1];
			var user_persent = (parseInt(users) * 100 ) / parseInt(total_users);
			user_persent =  Number.parseFloat(user_persent).toFixed(1);
			users = '<span class="data_value">'+users + '</span><strong class="data_percent">'+user_persent+'%</strong>';
			table.row.add([(parseInt(i)+1), item[0],users]).draw( false );
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
  var dataChart5 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:browser',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
    },
    chart: {
      container: 'chart-5-container',
      type: 'PIE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart5.execute();
  
  
    
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  /*var dataChart6 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:browser',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-6-container',
      type: 'TABLE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart6.execute();*/
  
   /***************chart-6-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users',
      dimensions: 'ga:browser',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];
		
		var table; //outside your function scopes
		table = $('#chart-6-container').DataTable();
		$.each(res_data, function(i, item) {
			var users = item[1];
			var user_persent = (parseInt(users) * 100 ) / parseInt(total_users);
			user_persent =  Number.parseFloat(user_persent).toFixed(1);
			users = '<span class="data_value">'+users + '</span><strong class="data_percent">'+user_persent+'%</strong>';
			table.row.add([(parseInt(i)+1), item[0],users]).draw( false );
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
  var dataChart7 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
       metrics: 'ga:users',
      dimensions: 'ga:operatingSystem',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
    },
    chart: {
      container: 'chart-7-container',
      type: 'PIE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart7.execute();
  
  
    
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
 /* var dataChart8 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:operatingSystem',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-8-container',
      type: 'TABLE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart8.execute();*/
  
  /***************chart-8-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users',
      dimensions: 'ga:operatingSystem',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];
		
		var table; //outside your function scopes
		table = $('#chart-8-container').DataTable();
		$.each(res_data, function(i, item) {
			var users = item[1];
			var user_persent = (parseInt(users) * 100 ) / parseInt(total_users);
			user_persent =  Number.parseFloat(user_persent).toFixed(1);
			users = '<span class="data_value">'+users + '</span><strong class="data_percent">'+user_persent+'%</strong>';
			table.row.add([(parseInt(i)+1), item[0],users]).draw( false );
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
  var dataChart9 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:screenResolution',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
    },
    chart: {
      container: 'chart-9-container',
      type: 'PIE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart9.execute();
  
  
    
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  /*var dataChart10 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:screenResolution',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-10-container',
      type: 'TABLE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart10.execute();*/
  
  /***************chart-10-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users',
      dimensions: 'ga:screenResolution',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];	
		var table; //outside your function scopes
		table = $('#chart-10-container').DataTable();
		$.each(res_data, function(i, item) {
			var users = item[1];
			var user_persent = (parseInt(users) * 100 ) / parseInt(total_users);
			user_persent =  Number.parseFloat(user_persent).toFixed(1);
			users = '<span class="data_value">'+users + '</span><strong class="data_percent">'+user_persent+'%</strong>';
			table.row.add([(parseInt(i)+1), item[0],users]).draw( false );
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
  var dataChart11 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:mobileDeviceInfo',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
    },
    chart: {
      container: 'chart-11-container',
      type: 'PIE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart11.execute();
  
  
    
  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  /*var dataChart12 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users',
      dimensions: 'ga:mobileDeviceInfo',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-12-container',
      type: 'TABLE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart12.execute();*/
  
  /***************chart-12-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users',
      dimensions: 'ga:mobileDeviceInfo',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];
		
		var table; //outside your function scopes
		table = $('#chart-12-container').DataTable();
		$.each(res_data, function(i, item) {
			var users = item[1];
			var user_persent = (parseInt(users) * 100 ) / parseInt(total_users);
			user_persent =  Number.parseFloat(user_persent).toFixed(1);
			users = '<span class="data_value">'+users + '</span><strong class="data_percent">'+user_persent+'%</strong>';
			table.row.add([(parseInt(i)+1), item[0],users]).draw( false );
		});
		
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });

	
	
	$('.table').DataTable({
	 "ordering": true,
		responsive: true,
			language: {
			searchPlaceholder: 'Search...',
			sSearch: '',
			//lengthMenu: '_MENU_ items/page',
		}
	});

});
</script>

