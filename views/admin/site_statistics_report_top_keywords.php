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
			  <h2 class="az-content-title tx-24 mg-b-5 mg-t-10 mg-b-lg-8">Which keywords are used to find your website?</h2>
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
	  
	  
	   <div class="row row-sm mg-b-15 mg-sm-b-20 ">
		<div class="col-sm-6 col-xl-6 col-lg-6">
			<div class="cards redbtn" style="background:#0073B7;">These keywords send the most visitors</div>
			 <div class="card card-dashboard-twentyfive keyword-bar card-body">
             <div id="chart-1-container" class="ht-200 ht-sm-300"></div>
				
			</div>
		</div>
		<div class="col-sm-6 col-xl-6 col-lg-6 numberrow" >
			<div class="cards redbtn" >The most important keyword</div>
			<div class="card card-dashboard-twentytwo keywords_box" style="height: 340px;">
              <div class="media redbtn"> 
                <div class="media-body">
					 <h6><div class="graph_important_keyword" class="ht-200 ht-sm-300"></div></h6>
                  <span>is the keyword that delivers the most users to your website.</span>
                </div>
              </div>
            </div><!-- card -->
		</div>
	</div>
	  
		<div class="row row-sm mg-b-15 mg-sm-b-20 ">
			<div class="col-sm-12 col-xl-12 col-lg-12">
				<div class="cards redbtn">Top keywords that send visitors to the website</div>
				<div class="card card-dashboard-twentyfive keyword-bar backlinks-link  card-body">
					<!--<div id="chart-3-container" class="ht-200 ht-sm-300"></div>-->
					<table id="chart-3-container" class="table">
					   <thead>
						  <tr>
							 <tr>
								<th class="wd-5p">Sr.No.</th>
								<!--<th class="wd-30p"><span class="help tipso_style">Page <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Page " data-content="The page on your website that gets the users."><i class="fa fa-question-circle"></i></a></span></span></th>-->
								<th class="wd-10p"><span class="help tipso_style">Keyword <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Keyword " data-content="The number of users that come to the page.The number of users is different from the number of sessions. Users can create multiple sessions.The number of users shows the unique users."><i class="fa fa-question-circle"></i></a></span></span></th>
								<th class="wd-10p"><span class="help tipso_style">Users <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Users " data-content="The number of users that come to the page.The number of users is different from the number of sessions. Users can create multiple sessions.The number of users shows the unique users."><i class="fa fa-question-circle"></i></a></span></span></th>
								<th class="wd-10p"><span class="help tipso_style">Pages p.s. <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Pages per session" data-content="The average number of pages per session that users visit on your site."><i class="fa fa-question-circle"></i></a></span></span></th>
								<th class="wd-10p"><span class="help tipso_style">Goals <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Goals " data-content="The number of goals that are completed by people who visit the page."><i class="fa fa-question-circle"></i></a></span></span></th>
								<th class="wd-10p"><span class="help tipso_style">Conv. rate <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Conversion rate" data-content="The percentage of users who visit the page and complete a goal on your website."><i class="fa fa-question-circle"></i></a></span></span></th>
							</tr>
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
       dimensions: 'ga:keyword',
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
  /*var dataChart2 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users',
      dimensions: 'ga:keyword',
      'start-date': start_date,
      'end-date': end_date,
      sort:'-ga:keyword',
      'max-results' : '1',
	  //output : 'json',
	  
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
  
  
   /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  /*var dataChart3 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	   metrics: 'ga:users,ga:pageviewsPerSession,ga:goalConversionRateAll',
       dimensions: 'ga:pagePath,ga:keyword',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-3-container',
      type: 'TABLE',
      options: {
        width: '100%',
		page: 'enable',
		pageSize: 4,
		showRowNumber: true,
		sortColumn : -1,
		allowHtml : true,
        //pieHole: 4/9
      }
    }
  });
  dataChart3.execute();*/
  
  
  /***************chart-3-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users,ga:goalConversionRateAll,ga:pageviewsPerSession,ga:goalValueAll',
     // dimensions: 'ga:hostname,ga:pagePath,ga:keyword',
      dimensions: 'ga:keyword',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	//alert(formattedJson); return false;
		var table; //outside your function scopes // host/page/users/ goal conv rate/  page per session / goal
		table = $('#chart-3-container').DataTable();
		$.each(res_data, function(i, item) {
			
			var page_per_session =  Number.parseFloat(item[3]).toFixed(2);
			var keyword =  item[0];
			var users =  item[1];
			var goals_conv_rate =  item[4]+"%";
			var goals =  item[2];
			table.row.add([(parseInt(i)+1),keyword,users,page_per_session,goals,goals_conv_rate]).draw( false );
			
		});
		
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
 /***************************************/
  
  
  
  
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	 metrics: 'ga:users',
	  dimensions: 'ga:keyword',
	  'start-date': start_date,
	  'end-date': end_date,
	  'max-results' : '1',
  })
  .then(function(response) { 
   // var formattedJson = JSON.stringify(response.result, null, 2);
	//alert(formattedJson);
	var res_data = response.result.rows[0];
	$('.graph_important_keyword').html('“'+res_data[0]+"”");
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
 
});
</script>
