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
			  <h2 class="az-content-title tx-24 mg-b-5 mg-t-10 mg-b-lg-8">How do visitors find your website?</h2>
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
		<div class="col-sm-12 col-xl-12 col-lg-12">
			<div class="cards redbtn">These sources send visitors to the website</div>
            <div class="card card-dashboard-twentyfive keyword-bar card-body">
			<table id="chart-1-container" class="table">
              <thead>
                  <tr>
                      <th class="wd-10p" >S No.</th>
                      <th class="wd-20p" >Source</th>
                      <th class="wd-15p">Referred users</th>
                      <th class="wd-15p">Page views</th>
                      <th class="wd-15p">Avg. time on site</th>
                      <th class="wd-10p">Goals</th>
                      <th class="wd-30p">Conversion rate</th>
                  </tr>
              </thead>
              <tbody>
				
			   </tbody>
            </table>
			
			<!--	<div class="chartjs-wrapper-demo" style="
    height: 550px;
"><canvas id="chartStacked2" ></canvas></div> -->
			</div>
		</div>
			</div>

	<!--<div class="row row-sm mg-b-15 mg-sm-b-20 ">
		<div class="col-sm-12 col-xl-12 col-lg-12">
			<div class="cards redbtn" > Top backlinks from other pages that send users to your site
 </div>
            <div class="card card-dashboard-twentyfive keyword-bar backlinks-link card-body">
				<table id="example2" class="table">
					<thead>
						<tr>
							<th class="wd-10p">No.</th>
							<th class="wd-20p">Linking web page <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Linking web page" data-content="The URL of the page that links to your site."><i class="fa fa-question-circle"></i></span></th>
							<th class="wd-35p">Users <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Users " data-content="The number of users that your website received through that link.The number of users is different from the number of sessions. Users can create multiple sessions.The number of users shows the unique users."><i class="fa fa-question-circle"></i></span></th>
							<th class="wd-15p">Pages p.s. <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Pages per session" data-content="The number of pages per session that users that arrived through that link visit on your website."><i class="fa fa-question-circle"></i></span></th>
							<th class="wd-15p">Goals <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Goals " data-content="The number of goals that have been completed by users who reached your website through the link."><i class="fa fa-question-circle"></i></span></th>
							<th class="wd-15p">Conv. <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Conversion rate" data-content="The percentage of users who completed a goal after reaching your website through the link."><i class="fa fa-question-circle"></i></span></th>
						</tr>
					</thead>
					<tbody>
					<tr>
					<td >1.</td>
					<td><a href="http://m.facebook.com/" target="_blank">m.facebook.com</a></td>
					<td ><div class="number">472</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color:#0073B7; width:47.2%" aria-valuenow="472" aria-valuemin="0" aria-valuemax="999"></div></div></td>
					<td>4.05</td>
					<td>2</td>
					<td>0.42%</td>
					</tr>

					<tr>
					<td >2.</td>
					<td><a href="http://facebook.com/" target="_blank">facebook.com</a></td>
					<td ><div class="number">112</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" aria-valuenow="112" style="background-color: #F39C12; width:12.2%" aria-valuemin="0" aria-valuemax="999"></div></div></td>
					<td >3.04</td>
					<td  >0</td>
					<td >0.00%</td>
					</tr>

					<tr>
					<td >3.</td>
					<td>l.facebook.com</a></td>
					<td ><div class="number">67</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color: #DD4B39; width:6.7%" aria-valuenow="472" aria-valuemin="0" aria-valuemax="999"></div></div></td>
					<td >4.06</td>
					<td  >1</td>
					<td >1.49%</td>
					</tr>

					<tr>
					<td >4.</td>
					<td> <a href="http://l.facebook.com/" target="_blank">l.facebook.com</a></td>
					<td ><div class="number">53</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color: #DD4B39; width:5.3%" aria-valuenow="472" aria-valuemin="0" aria-valuemax="999"></div></div></td>
					<td >4.25</td>
					<td  >0</td>
					<td >0.00%</td>
					</tr>

					<tr>
					<td >5.</td>
					<td><a href="http://lm.facebook.com/" target="_blank">lm.facebook.com&#8203;</a></td>
					<td ><div class="number">11</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color: #DD4B39; width:1.1%" aria-valuenow="472" aria-valuemin="0" aria-valuemax="999"></div></div></td>
					<td >4.04</td>
					<td  >0</td>
					<td >0.00%</td>
					</tr>

					<tr>
					<td >6.</td>
					<td> <a href="http://dnserrorassist.att.net/search/" target="_blank">dnserrorassist.</a></td>
					<td ><div class="number">11</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color: #DD4B39; width:0.5%" aria-valuenow="472" aria-valuemin="0" aria-valuemax="999"></div></div></td>
					<td >2.42</td>
					<td  >0</td>
					<td >0.00%</td>
					</tr>

					<tr>
					<td >7.</td>
					<td><a href="http://us.search.yahoo.com/" target="_blank">us.search.yahoo&#8203;.com</a></td>
					<td ><div class="number">5</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color: #DD4B39; width:0.5%" aria-valuenow="472" aria-valuemin="0" aria-valuemax="999"></div></div></td>
					<td >3.29</td>
					<td  >0</td>
					<td >0.00%</td>
					</tr>

					<tr >
					<td >8.</td>
					<td><a href="http://mail.yahoo.com/" target="_blank">mail.yahoo.com</a></td>
					<td ><div class="number">4</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color: #DD4B39; width:0.4%" aria-valuenow="472" aria-valuemin="0" aria-valuemax="999"></div></div></td>
					<td >2.86</td>
					<td  >0</td>
					<td >0.00%</td>
					</tr>

					</tbody>
				</table>
			</div>
		</div>
			</div>	--->	
		<div class="row row-sm mg-b-15 mg-sm-b-20 ">
			<div class="col-sm-12 col-xl-12 col-lg-12">
				<div class="cards redbtn" >Search engines that send users to your site</div>
				<div class="card card-dashboard-twentyfive keyword-bar backlinks-link card-body">
				<!--<div id="morrisLine1" class="morris-wrapper-demo"></div>-->
				
				<table id="chart-2-container" class="table ">
				<thead>
				<tr>
				<th class="wd-5p">No.</th>
				<th class="wd-10p">Search engine <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Search engine" data-content="The name of the search engine that sends users to your website."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">Users <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Users " data-content="The number of users that the search engine sends to your website.The number of users is different from the number of sessions. Users can create multiple sessions.The number of users shows the unique users."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">Pages per session <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Number of pages" data-content="The number of pages that users from that search engine visit on your website."><i class="fa fa-question-circle"></i></span></th>
				<th  class="wd-10p">Goals <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Goals" data-content="The number of goals that users from that search engine complete on your website."><i class="fa fa-question-circle"></i></span></th>
				<th class="wd-10p">Conversion rate <span data-container="body" data-popover-color="head-primary" data-placement="top" title="Conversion rate" data-content="The percentage of users who complete a goal on your website."><i class="fa fa-question-circle"></i></span></th>
				</tr>
				</thead>

				<tbody>
				
				</tbody></table></div>
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
  /*var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	   metrics: 'ga:users,ga:pageviews,ga:goalConversionRateAll,ga:avgTimeOnPage',
      dimensions: 'ga:source',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-1-container',
      type: 'TABLE',
      options: {
        width: '100%',
        //pieHole: 4/9
      }
    }
  });
  dataChart1.execute();*/
  
   /***************chart-1-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users,ga:pageviews,ga:goalConversionRateAll,ga:avgTimeOnPage,ga:goalValueAll',
      dimensions: 'ga:source',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];
	//alert(formattedJson); return false;
		var table; //outside your function source/users/pageviews/goal rate/avg time / goal
		table = $('#chart-1-container').DataTable();
		$.each(res_data, function(i, item) {
			var source = item[0];
			//var users = item[1];
			var page_views = item[2];
			var goal_conv_rate = item[3]+'%';
			var avg_time_on_page =  Number.parseFloat(item[4]).toFixed(2);
			var goals = item[5];
			
				var users = item[1];
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
				
			table.row.add([(parseInt(i)+1),source,users,page_views,avg_time_on_page,goals,goal_conv_rate ]).draw( false );
		});
		
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
  
 
  /***************chart-2-container*************/
   gapi.client.analytics.data.ga.get({
    'ids': '<?php echo $graph_view_id; ?>', // <-- Replace with the ids value for your view.
	  metrics: 'ga:users,ga:pageviewsPerSession,ga:goalConversionRateAll,ga:goalValueAll',
      dimensions: 'ga:source',
      'start-date': start_date,
      'end-date': end_date,
	  sort : '-ga:users'
  })
  .then(function(response) { 
    //var formattedJson = JSON.stringify(response.result, null, 2);
	var res_data = response.result.rows;
	var total_users = response.result.totalsForAllResults['ga:users'];
	var total_page_per_session = response.result.totalsForAllResults['ga:pageviewsPerSession'];
	
		var table; //outside your function source/users/pageviews/goal rate/avg time / goal
		table = $('#chart-2-container').DataTable();
		$.each(res_data, function(i, item) {
			var source = item[0];
			if(source == "google" || source == "bing" || source == "yahoo" || source == "duckduckgo" || source == "ecosia" || source == "baidu" || source == "yandex" || source == "ask" || source == "aol" || source == "archive"){
				//var users = item[1];
				var page_per_session =   Number.parseFloat(item[2]).toFixed(2);
				var goal_conv_rate = item[3]+'%';
				var goals = item[4];
				
				var users = item[1];
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
				
				/**** page per session ***/
				var page_per_session = item[2];
				var session_persent = (parseFloat(page_per_session) * 100 ) / parseFloat(total_page_per_session);
				session_persent =  Number.parseFloat(session_persent).toFixed(1);
				var session_bg_code = '#DD4B39';
				if(session_persent > 0 && session_persent <= 20 ){
					session_bg_code = '#DD4B39';
				}else if(session_persent > 20 && session_persent <= 40 ){
					session_bg_code = '#00C0EF';
				}else if(session_persent > 40 && session_persent <= 60 ){
					session_bg_code = '#00A65A';
				}else if(session_persent > 60 && session_persent <= 80 ){
					session_bg_code = '#F39C12';
				}else if(session_persent > 80 && session_persent <= 100 ){
					session_bg_code = '#0073B7';
				}
				
				page_per_session = '<div class="number">'+page_per_session +'</div><div class="progress"><div class="progress-bar progress-bar-striped " role="progressbar" style="background-color:'+session_bg_code+'; width:'+session_persent+'%" aria-valuenow="'+session_persent+'" aria-valuemin="0" aria-valuemax="999"></div></div>';
				
				table.row.add([(parseInt(i)+1),source,users,page_per_session,goals,goal_conv_rate ]).draw( false );
			}
			
		});
		
  })
  .then(null, function(err) {
      // Log any errors.
      console.log(err);
  });
  
  
 
 
});
</script>
