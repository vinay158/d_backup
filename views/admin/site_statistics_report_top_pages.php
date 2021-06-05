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
					
				</nav>								<a class="view_night_watch_trackr" href="<?php echo base_url().'admin/search_engine_rankings_report' ?>" target="_blank">Click Here To View Search Engine Rankings Report</a>
          </div>
	
	
	  <div class=" d-block az-content-heading tx-24 mg-b-10 mg-t-10 mg-b-lg-8">
			<div class="float-left col-sm-8">
				<div class="row">
			  <h2 class="az-content-title tx-24 mg-b-5 mg-t-10 mg-b-lg-8">Which pages do your visitors see?</h2>
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
          <div class="col-md-12 col-lg-12 col-xl-12 col-xl-12">

            <div class="card card-dashboard-twentytwo">
              <div class="media">
                <div class="media-body">
                  <h6 class="graph_avg_page_number">0</h6>
                  <span>AVERAGE NUMBER OF PAGES THAT A VISITOR VISITS ON YOUR WEBSITE</span>
                </div>
              </div>
              

            </div><!-- card -->

          </div><!-- col -->

          
        </div><!-- row -->
		
	  
		<div class="row row-sm mg-b-15 mg-sm-b-20 ">
			<div class="col-sm-12 col-xl-12 col-lg-12">
				<div class="cards redbtn">The most popular pages on  <?php echo $_SERVER['HTTP_HOST']; ?></div>
				<div class="card card-dashboard-twentyfive keyword-bar backlinks-link  card-body">
					<table id="chart-1-container" class="table">
					   <thead>
						  <tr>
							 <tr>
								<th class="wd-5p">Sr.No.</th>
								<th class="wd-30p"><span class="help tipso_style">Page <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Page " data-content="The page on your website that gets the users."><i class="fa fa-question-circle"></i></a></span></span></th>
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
		<div class="row row-sm mg-b-15 mg-sm-b-20 ">
			<div class="col-sm-12 col-xl-12 col-lg-12">
				<div class="cards redbtn">Top pages that have the highest conversion rate</div>
				<div class="card card-dashboard-twentyfive keyword-bar backlinks-link  card-body">
					<table id="chart-2-container" class="table">
					   <thead>
						  <tr>
							 <tr>
								<th class="wd-5p">Sr.No.</th>
								<th class="wd-30p"><span class="help tipso_style">Page <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Page " data-content="The page on your website that gets the users."><i class="fa fa-question-circle"></i></a></span></span></th>
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


$(document).ready(function() {
	$('[data-toggle="popover"]').popover();

        $('[data-popover-color="head-primary"]').popover({
			trigger: 'hover',
          template: '<div class="popover popover-head-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        });
		
});	


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
 /* var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	   metrics: 'ga:users,ga:goalConversionRateAll,ga:pageviewsPerSession,ga:goalValueAll',
       dimensions: 'ga:hostname,ga:pagePath',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-1-container',
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
  dataChart1.execute();*/
  
  /***************chart-1-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users,ga:goalConversionRateAll,ga:pageviewsPerSession,ga:goalValueAll',
      dimensions: 'ga:hostname,ga:pagePath',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];
	
	//alert(formattedJson); return false;
		var table; //outside your function scopes // host/page/users/ goal conv rate/  page per session / goal
		table = $('#chart-1-container').DataTable();
		$.each(res_data, function(i, item) {
			var page_url = item[0] + item[1];
			page_url = '<a href="'+page_url+'" title="'+page_url+'">'+page_url+'</a>';
			var page_per_session =  Number.parseFloat(item[4]).toFixed(2);
			var goals_conv_rate =  item[3]+"%";
			var goals =  item[5];
			
			var users = item[2];
			var user_persent = (parseFloat(users) * 100 ) / parseFloat(total_users);
			user_persent =  Number.parseFloat(user_persent).toFixed(1);
			var bg_code = '#DD4B39';
			if(user_persent > 0 && user_persent <= 20 ){
				bg_code = '#DD4B39';
			}else if(user_persent > 20 && user_persent <= 40 ){
				bg_code = '#00C0EF';
			}else if(user_persent > 40 && user_persent <= 60 ){
				bg_code = '#00A65A';
			}else if(user_persent > 60 && user_persent <= 80 ){
				bg_code = '#F39C12';
			}else if(user_persent > 80 && user_persent <= 100 ){
				bg_code = '#0073B7';
			}
			users = '<div class="number">'+users +'</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color:'+bg_code+'; width:'+user_persent+'%" aria-valuenow="'+user_persent+'" aria-valuemin="0" aria-valuemax="999"></div></div>';
			table.row.add([(parseInt(i)+1), page_url,users,page_per_session,goals,goals_conv_rate]).draw( false );
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
  /*var dataChart2 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
      metrics: 'ga:users,ga:goalConversionRateAll,ga:pageviewsPerSession',
      dimensions: 'ga:hostname,ga:pagePath',
      'start-date': start_date,
      'end-date': end_date,
      sort:'-ga:goalConversionRateAll'
    },
    chart: {
      container: 'chart-2-container',
      type: 'TABLE',
      options: {
        width: '100%',
		page: 'enable',
		pageSize: 4,
		showRowNumber: true,
		sortColumn : -1,
		allowHtml : true,
		//startPage : 5
        //pieHole: 4/9
      }
    }
  });
  dataChart2.execute();*/
  
  /***************chart-2-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users,ga:goalConversionRateAll,ga:pageviewsPerSession,ga:goalValueAll',
      dimensions: 'ga:hostname,ga:pagePath',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:goalConversionRateAll'
  })
  .then(function(response) { 
    var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];
	//alert(formattedJson); return false;
		var table; //outside your function scopes // host/page/users/ goal conv rate/  page per session / goal
		table = $('#chart-2-container').DataTable();
		$.each(res_data, function(i, item) {
			var page_url = item[0] + item[1];
			page_url = '<a href="'+page_url+'" title="'+page_url+'">'+page_url+'</a>';
			var page_per_session =  Number.parseFloat(item[4]).toFixed(2);
			var goals_conv_rate =  item[3]+"%";
			var goals =  item[5];
			
			var users = item[2];
			var user_persent = (parseFloat(users) * 100 ) / parseFloat(total_users);
			user_persent =  Number.parseFloat(user_persent).toFixed(1);
			var bg_code = '#DD4B39';
			if(user_persent > 0 && user_persent <= 20 ){
				bg_code = '#DD4B39';
			}else if(user_persent > 20 && user_persent <= 40 ){
				bg_code = '#00C0EF';
			}else if(user_persent > 40 && user_persent <= 60 ){
				bg_code = '#00A65A';
			}else if(user_persent > 60 && user_persent <= 80 ){
				bg_code = '#F39C12';
			}else if(user_persent > 80 && user_persent <= 100 ){
				bg_code = '#0073B7';
			}
			users = '<div class="number">'+users +'</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color:'+bg_code+'; width:'+user_persent+'%" aria-valuenow="'+user_persent+'" aria-valuemin="0" aria-valuemax="999"></div></div>';
			table.row.add([(parseInt(i)+1), page_url,users,page_per_session,goals,goals_conv_rate]).draw( false );
		});
		
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
 /***************************************/
  gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	 metrics: 'ga:pageviewsPerSession',
	  'start-date': start_date,
	  'end-date': end_date,
	  'max-results' : '1',
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows[0];
	res_data = Number.parseFloat(res_data).toFixed(2);
	$('.graph_avg_page_number').html(res_data);
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
  
  
  
});
</script>
