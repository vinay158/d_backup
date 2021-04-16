<?php $this->load->view("admin/include/header"); ?>
<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>
<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Google Analytics</div>
			
			
		</div>
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
		
		<?php if($analyticsDetail->analytics_report_type == 1 && !empty($analyticsDetail->client_id) && !empty($analyticsDetail->client_secret)){ ?>
		
		<?php 
			//	echo '<pre>user email ==> '; print_r($userData->email);
			//	echo '<pre>SEssion=>'; print_r($_SESSION['googleAuth_access_token']); echo '</pre>';
			?>	
<style>
    .chart_box_width{
        width: 46% !important;
        border: 2px solid #fafafa;
        float: left;
        margin-left: 2%;
       margin-bottom:20px;
    }
    
    .chart_box_fullwidth{
        width: 98% !important;
        border: 2px solid #fafafa;
        float: left;
        margin-left: 2%;
       margin-bottom:20px;
    }
    
    .chart_box_topvalues_width{
        width: 32% !important;
        border: 2px solid #fafafa;
        float: left;
        margin-left: 0.5%;
       margin-bottom:20px;
    }
	
	.chart_box_tabs{
        width: 14% !important;
        border: 2px solid #fafafa;
        float: left;
        margin-left: 0.5%;
       margin-bottom:20px;
	   background:#e0e4e7;
	   padding:10px;
	   text-align:center
    }
	.chart_box_tabs  a{color:rgb(0,0,0,0.7);font-weight:400}
	.chart_box_tabs.active_tab{background:#3d4145}
	.chart_box_tabs.active_tab a{color:#fff}
    
    .chart_heading{font-size:18px; color:#fff; background:#F39C12; margin-left:5px; padding:10px;border-radius:4px;}
    
    .gapi-analytics-data-chart .google-visualization-table-td-number{text-align:left !important;}
	
	.sort_dates option:nth-child(1), .sort_dates option:nth-child(5) , .sort_dates option:nth-child(13) {
		font-weight:bold;
		background:#e0e4e7;
		font-size: 14px;
	}
</style>

<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));

</script>

<script>
	$(document).ready(function(){
		$('.sort_dates').change(function(){
			var sort = $(this).val();
			
			if(sort == "currently"){
				return false;
			}else if(sort == "fixed"){
				return false;
			}else if(sort == "sliding"){
				return false;
			}else{
				var queryString = '';
				<?php if(isset($_GET['type'])){ ?>
						queryString = '?type='+"<?php echo $_GET['type'] ?>&sort="+sort;
				<?php }else{ ?>
						queryString = "?sort="+sort;
				<?php } ?>
				
				var redirect_path = "<?php echo base_url().ltrim($_SERVER['REDIRECT_QUERY_STRING'],'/') ?>"+queryString;
				//alert(redirect_path); return false;
				window.location.href = redirect_path;
			}
			
		})
	})
</script>
<div class="welcome_video">

	<div class="adsUrl">
		<h1>Date: <?php echo date('d M Y', strtotime($dateRanges['start_date'])).' to '.date('d M Y', strtotime($dateRanges['end_date'])) ?></h1>
		<select name="sort" id="" class="field sort_dates">
		<?php foreach($dateRanges['sorting_list'] as $key => $val){ ?>
			<option value="<?php echo $key; ?>" <?php echo ($key == $sort) ? 'selected=selected' : '' ?>><?php echo $val; ?></option>
		<?php } ?>
		</select>
	
	</div>
	<div class="linkTarget">
		
	</div>
	
</div> 
<br/>
<div style="clear:both"></div> 

<div class="chart_box_tabs <?php echo ($report_type == "overview") ? 'active_tab' : ''; ?>">
<a href="<?php echo base_url().'admin/googleanalytic/show_report?type=overview' ?><?php echo isset($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>">Overview</a>
</div>
<div class="chart_box_tabs <?php echo ($report_type == "social_media") ? 'active_tab' : ''; ?>">
<a href="<?php echo base_url().'admin/googleanalytic/show_report?type=social_media' ?><?php echo isset($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>">Social Media</a>
</div>
<div class="chart_box_tabs <?php echo ($report_type == "top_reffers") ? 'active_tab' : ''; ?>">
<a href="<?php echo base_url().'admin/googleanalytic/show_report?type=top_reffers' ?><?php echo isset($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>">Top Reffers</a>
</div>
<div class="chart_box_tabs <?php echo ($report_type == "top_keywords") ? 'active_tab' : ''; ?>">
<a href="<?php echo base_url().'admin/googleanalytic/show_report?type=top_keywords' ?><?php echo isset($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>">Top Keywords</a>
</div>
<div class="chart_box_tabs <?php echo ($report_type == "top_pages") ? 'active_tab' : ''; ?>">
<a href="<?php echo base_url().'admin/googleanalytic/show_report?type=top_pages' ?><?php echo isset($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>">Top Pages</a>
</div>
<div class="chart_box_tabs <?php echo ($report_type == "your_visitors") ? 'active_tab' : ''; ?>">
<a href="<?php echo base_url().'admin/googleanalytic/show_report?type=your_visitors' ?><?php echo isset($_GET['sort']) ? '&sort='.$_GET['sort'] : ''; ?>">Your Visitors</a>
</div>


<?php if($report_type == "overview"){ ?>
<div id="embed-api-auth-container"></div>
<div class="chart_box_topvalues_width">
<div id="chart-1-container"></div>
<div id="view-selector-1-container" style="display:none"></div>
</div>
<div class="chart_box_topvalues_width">
<div id="chart-2-container"></div>
<div id="view-selector-2-container" style="display:none"></div>
</div>
<div class="chart_box_topvalues_width"><div id="chart-3-container"></div>
<div id="view-selector-3-container" style="display:none"></div>
</div>


<div class="chart_box_width">
<p class="chart_heading">
Countries </p>
<div id="chart-4-container"></div>
<div id="view-selector-4-container" style="display:none"></div>
</div>
<div class="chart_box_width">
<p class="chart_heading">
Sessions </p>
<div id="chart-5-container"></div>
<div id="view-selector-5-container" style="display:none"></div>
</div>
<div class="chart_box_width">
<p class="chart_heading">
Pages Per Session </p>
<div id="chart-6-container"></div>
<div id="view-selector-6-container" style="display:none"></div>
</div>
<div class="chart_box_width">
<p class="chart_heading">
Average time on site (seconds)</p>
<div id="chart-7-container"></div>
<div id="view-selector-7-container" style="display:none"></div>
</div>
<div class="chart_box_width">
<p class="chart_heading">
New Users</p>
<div id="chart-8-container"></div>
<div id="view-selector-8-container" style="display:none"></div>

</div>
<div class="chart_box_width">
<p class="chart_heading">
Bounce Rate (%) </p>
<div id="chart-9-container"></div>
<div id="view-selector-9-container" style="display:none"></div>
</div>

<?php } ?>

<?php if($report_type == "your_visitors"){ ?>
<div style="width:100%;clear:both"><b>Your Visitors</b><br/></div>
<div class="chart_box_width">
 <p class="chart_heading">Where do your website users live?</p>
<div id="chart-15-container"></div>
<div id="view-selector-15-container" style="display:none"></div>
<div id="chart-16-container"></div>
<div id="view-selector-16-container" style="display:none"></div>

</div>

<div class="chart_box_width">
<p class="chart_heading">Which languages do your visitors speak?</p>
<div id="chart-17-container"></div>
<div id="view-selector-17-container" style="display:none"></div>
<div id="chart-18-container"></div>
<div id="view-selector-18-container" style="display:none"></div>
</div>

<div class="chart_box_width">
<p class="chart_heading">
Which web browsers do your visitors use?</p>
<div id="chart-19-container"></div>
<div id="view-selector-19-container" style="display:none"></div>
<div id="chart-20-container"></div>
<div id="view-selector-20-container" style="display:none"></div>
</div>

<div class="chart_box_width">
<p class="chart_heading">
Which operating systems do your visitors use?</p>
<div id="chart-21-container"></div>
<div id="view-selector-21-container" style="display:none"></div>
<div id="chart-22-container"></div>
<div id="view-selector-22-container" style="display:none"></div>
</div>

<div class="chart_box_width">
<p class="chart_heading">
How much can your visitors see?</p>
<div id="chart-23-container"></div>
<div id="view-selector-23-container" style="display:none"></div>
<div id="chart-24-container"></div>
<div id="view-selector-24-container" style="display:none"></div>
</div>

<div class="chart_box_width">
<p class="chart_heading">
Which mobile devices do your visitors use?</p>
<div id="chart-25-container"></div>
<div id="view-selector-25-container" style="display:none"></div>
<div id="chart-26-container"></div>
<div id="view-selector-26-container" style="display:none"></div>
</div>
<?php } ?>

<?php if($report_type == "top_pages"){ ?>
<div style="width:100%;clear:both"><b>Top Pages</b><br/></div>
<div class="chart_box_fullwidth">
 <p class="chart_heading">The most popular pages on <?php echo $_SERVER['HTTP_HOST'] ?></p>
<div id="chart-27-container"></div>
<div id="view-selector-27-container" style="display:none"></div>

</div>

<div class="chart_box_fullwidth">
 <p class="chart_heading">Top pages that have the highest conversion rate</p>
<div id="chart-28-container"></div>
<div id="view-selector-28-container" style="display:none"></div>
</div>

<div class="chart_box_width">
<p class="chart_heading">
Page Views </p>
<div id="chart-10-container"></div>
<div id="view-selector-10-container" style="display:none"></div>
</div>
<div class="chart_box_width">
<p class="chart_heading">
Users (dimensions : userType) </p>
<div id="chart-11-container"></div>
<div id="view-selector-11-container" style="display:none"></div>
</div>
<div class="chart_box_width">
<p class="chart_heading">
Session Duration (dimensions : sessionDurationBucket) </p>
<div id="chart-12-container"></div>
<div id="view-selector-12-container" style="display:none"></div>
</div>
<div class="chart_box_width">
<p class="chart_heading">
Page Views by Page Title (dimensions : pageTitle)</p>
<div id="chart-13-container"></div>
<div id="view-selector-13-container" style="display:none"></div>
</div>
<div class="chart_box_width" style="display:none">
<p class="chart_heading">
organicSearches (dimensions : source)  </p>
<div id="chart-14-container"></div>
<div id="view-selector-14-container" style="display:none"></div>
</div>
<?php } ?>

<?php if($report_type == "top_reffers"){ ?>
<div style="width:100%;clear:both"><b>Top Reffers</b><br/></div>
<div class="chart_box_fullwidth">
 <p class="chart_heading">Traffic sources
</p>
<div id="chart-34-container"></div>
<div id="view-selector-34-container" style="display:none"></div>

</div>

<div class="chart_box_fullwidth">
 <p class="chart_heading">These sources send visitors to the website
</p>
<div id="chart-29-container"></div>
<div id="view-selector-29-container" style="display:none"></div>

</div>
<?php } ?>

<?php if($report_type == "top_keywords"){ ?>
<div style="width:100%;clear:both"><b>Top Keywords</b><br/></div>
<div class="chart_box_width">
 <p class="chart_heading">These keywords send the most visitors
</p>
<div id="chart-30-container"></div>
<div id="view-selector-30-container" style="display:none"></div>
</div>

<div class="chart_box_width">
 <p class="chart_heading">The most important keyword
</p>
<div id="chart-31-container"></div>
<div id="view-selector-31-container" style="display:none"></div>
</div>


<div class="chart_box_fullwidth">
 <p class="chart_heading">Top keywords that send visitors to the website
</p>
<div id="chart-32-container"></div>
<div id="view-selector-32-container" style="display:none"></div>
</div>
<?php } ?>

<?php if($report_type == "social_media"){ ?>
<div style="width:100%;clear:both"><b>Social Media</b><br/></div>
<div class="chart_box_fullwidth">
 <p class="chart_heading">Social sessions progression
</p>
<div id="chart-33-container"></div>
<div id="view-selector-33-container" style="display:none"></div>
</div>
<?php } ?>

<script>

gapi.analytics.ready(function() {

  /**
   * Authorize the user immediately if the user has already granted access.
   * If no access has been created, render an authorize button inside the
   * element with the ID "embed-api-auth-container".
   */
  gapi.analytics.auth.authorize({
    container: 'embed-api-auth-container',
   // clientid: '277650455436-vajl8bkm1i6sfosqo0qg447qve7adbr4.apps.googleusercontent.com'
   'serverAuth': {
      'access_token': "<?php echo $_SESSION['googleAuth_access_token']['access_token'] ?>"
    }
  });


  /**
   * Create a ViewSelector for the first view to be rendered inside of an
   * element with the id "view-selector-1-container".
   */
   
  <?php if($report_type == "overview"){ ?>
  var viewSelector1 = new gapi.analytics.ViewSelector({
    container: 'view-selector-1-container'
  });

  
  var viewSelector2 = new gapi.analytics.ViewSelector({
    container: 'view-selector-2-container'
  });


  var viewSelector3 = new gapi.analytics.ViewSelector({
    container: 'view-selector-3-container'
  });
  
   var viewSelector4 = new gapi.analytics.ViewSelector({
    container: 'view-selector-4-container'
  });
  
   var viewSelector5 = new gapi.analytics.ViewSelector({
    container: 'view-selector-5-container'
  });
  
   var viewSelector6 = new gapi.analytics.ViewSelector({
    container: 'view-selector-6-container'
  });
  
   var viewSelector7 = new gapi.analytics.ViewSelector({
    container: 'view-selector-7-container'
  });
  
  var viewSelector8 = new gapi.analytics.ViewSelector({
    container: 'view-selector-8-container'
  });

    var viewSelector9 = new gapi.analytics.ViewSelector({
    container: 'view-selector-9-container'
  });
  
  <?php } ?>
  
  
  
  <?php if($report_type == "your_visitors"){ ?>
    var viewSelector15 = new gapi.analytics.ViewSelector({
    container: 'view-selector-15-container'
  });
  
    var viewSelector16 = new gapi.analytics.ViewSelector({
    container: 'view-selector-16-container'
  });

      var viewSelector17 = new gapi.analytics.ViewSelector({
    container: 'view-selector-17-container'
  });
  
    var viewSelector18 = new gapi.analytics.ViewSelector({
    container: 'view-selector-18-container'
  });
  
    var viewSelector19 = new gapi.analytics.ViewSelector({
    container: 'view-selector-19-container'
  });
  
    var viewSelector20 = new gapi.analytics.ViewSelector({
    container: 'view-selector-20-container'
  });
  
  var viewSelector21 = new gapi.analytics.ViewSelector({
    container: 'view-selector-21-container'
  });
  
    var viewSelector22 = new gapi.analytics.ViewSelector({
    container: 'view-selector-22-container'
  });
  
  var viewSelector23 = new gapi.analytics.ViewSelector({
    container: 'view-selector-23-container'
  });
  
    var viewSelector24 = new gapi.analytics.ViewSelector({
    container: 'view-selector-24-container'
  });
  
  var viewSelector25 = new gapi.analytics.ViewSelector({
    container: 'view-selector-25-container'
  });
  
    var viewSelector26 = new gapi.analytics.ViewSelector({
    container: 'view-selector-26-container'
  });
  <?php } ?>
  
  <?php if($report_type == "top_pages"){ ?>
    var viewSelector27 = new gapi.analytics.ViewSelector({
    container: 'view-selector-27-container'
  });


  var viewSelector28 = new gapi.analytics.ViewSelector({
    container: 'view-selector-28-container'
  });
  
  var viewSelector10 = new gapi.analytics.ViewSelector({
    container: 'view-selector-10-container'
  });

    var viewSelector11 = new gapi.analytics.ViewSelector({
    container: 'view-selector-11-container'
  });
  
  var viewSelector12 = new gapi.analytics.ViewSelector({
    container: 'view-selector-12-container'
  });
  
  var viewSelector13 = new gapi.analytics.ViewSelector({
    container: 'view-selector-13-container'
  });

  var viewSelector14 = new gapi.analytics.ViewSelector({
    container: 'view-selector-14-container'
  });
  <?php } ?>
  
  <?php if($report_type == "top_reffers"){ ?>
   var viewSelector34 = new gapi.analytics.ViewSelector({
    container: 'view-selector-34-container'
  });
  
  var viewSelector29 = new gapi.analytics.ViewSelector({
    container: 'view-selector-29-container'
  });
  <?php } ?>

	<?php if($report_type == "top_keywords"){ ?>
  
   var viewSelector30 = new gapi.analytics.ViewSelector({
    container: 'view-selector-30-container'
  });
  
   var viewSelector31 = new gapi.analytics.ViewSelector({
    container: 'view-selector-31-container'
  });
  
   var viewSelector32 = new gapi.analytics.ViewSelector({
    container: 'view-selector-32-container'
  });
  <?php } ?>

<?php if($report_type == "social_media"){ ?>
  var viewSelector33 = new gapi.analytics.ViewSelector({
    container: 'view-selector-33-container'
  });
<?php } ?>


  // Render both view selectors to the page.
  <?php if($report_type == "overview"){ ?>
  viewSelector1.execute(); //sessions
  viewSelector2.execute();
  viewSelector3.execute();
  viewSelector4.execute();
  viewSelector5.execute();
  viewSelector6.execute();
  viewSelector7.execute();
  viewSelector8.execute();
  viewSelector9.execute();
  <?php } ?>
  <?php if($report_type == "top_pages"){ ?>
  viewSelector10.execute();
  viewSelector11.execute();
  viewSelector12.execute();
  viewSelector13.execute();
  viewSelector14.execute();
  <?php } ?>

<?php if($report_type == "your_visitors"){ ?>
  viewSelector15.execute();
  viewSelector16.execute();
  viewSelector17.execute();
  viewSelector18.execute();
  viewSelector19.execute();
  viewSelector20.execute();
  viewSelector21.execute();
  viewSelector22.execute();
  viewSelector23.execute();
  viewSelector24.execute();
  viewSelector25.execute();
  viewSelector26.execute();
  <?php } ?>

<?php if($report_type == "top_pages"){ ?>
  viewSelector27.execute();
  viewSelector28.execute();
  <?php } ?>

<?php if($report_type == "top_reffers"){ ?>
  viewSelector29.execute();
  viewSelector34.execute();
  <?php } ?>

<?php if($report_type == "top_keywords"){ ?>
  viewSelector30.execute();
  viewSelector31.execute();
  viewSelector32.execute();
<?php } ?>
 <?php if($report_type == "social_media"){ ?>
  viewSelector33.execute();
 <?php } ?>

var start_date = "<?php echo $dateRanges['start_date'] ?>";
var end_date = "<?php echo $dateRanges['end_date'] ?>";

	<?php if($report_type == "overview"){ ?>
	
       var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
     // dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-1-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
   var dataChart2 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:newUsers',
     // dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-2-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
   var dataChart3 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:pageviews',
     // dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-3-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
    var dataChart4 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-4-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9,
        //title: 'Sessions over the past week.',
       // fontSize: 12
      }
    }
  });
  

  /**
   * Create the first DataChart for top countries over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  var dataChart5 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessions',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
      //'max-results': 6,
      //sort: '-ga:sessions'
    },
    chart: {
      container: 'chart-5-container',
      type: 'LINE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });


     /**
   * Create the second DataChart for top countries over the past 30 days.
   * It will be rendered inside an element with the id "chart-2-container".
   */
  var dataChart6 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:pageviewsPerSession',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-6-container',
      type: 'LINE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
   
    /**
   * Create the second DataChart for top countries over the past 30 days.
   * It will be rendered inside an element with the id "chart-2-container".
   */
  var dataChart7 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:avgTimeOnPage',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-7-container',
      type: 'LINE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
  var dataChart8 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:newUsers',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-8-container',
      type: 'LINE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
    var dataChart9 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:bounceRate',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-9-container',
      type: 'LINE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });


  
<?php } ?>
  <?php if($report_type == "top_pages"){ ?>
  
  /**
   * Create the second DataChart for top countries over the past 30 days.
   * It will be rendered inside an element with the id "chart-2-container".
   */
  var dataChart10 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:pageviews',
      dimensions: 'ga:date',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-10-container',
      type: 'LINE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
  /**
   * Create the second DataChart for top countries over the past 30 days.
   * It will be rendered inside an element with the id "chart-2-container".
   */
  var dataChart11 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:userType',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-11-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
   var dataChart12 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:sessionDuration',
      dimensions: 'ga:sessionDurationBucket',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-12-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
   var dataChart13 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:pageviews',
      dimensions: 'ga:pageTitle',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-13-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });

   
    var dataChart14 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:organicSearches',
      dimensions: 'ga:sessions',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-14-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
	<?php  } ?>
  
  <?php if($report_type == "your_visitors"){ ?>
  var dataChart15 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-15-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  var dataChart16 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:country',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-16-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
   var dataChart17 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:language',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-17-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  var dataChart18 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:language',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-18-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
   var dataChart19 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:browser',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-19-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  var dataChart20 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:browser',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-20-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
   var dataChart21 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:operatingSystem',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-21-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  var dataChart22 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:operatingSystem',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-22-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
  var dataChart23 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:screenResolution',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-23-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  var dataChart24 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:screenResolution',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-24-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  var dataChart25 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:mobileDeviceInfo',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-25-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  var dataChart26 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:mobileDeviceInfo',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-26-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  <?php } ?>
  
  <?php if($report_type == "top_pages"){ ?>
  var dataChart27 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users,ga:goalConversionRateAll,ga:pageviewsPerSession',
      dimensions: 'ga:hostname,ga:pagePath',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-27-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  var dataChart28 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users,ga:goalConversionRateAll,ga:pageviewsPerSession',
      dimensions: 'ga:hostname,ga:pagePath',
      'start-date': start_date,
      'end-date': end_date,
      sort:'-ga:goalConversionRateAll'
    },
    chart: {
      container: 'chart-28-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  <?php } ?>
  
  <?php if($report_type == "top_reffers"){ ?>
  var dataChart34 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users,ga:pageviews,ga:goalConversionRateAll,ga:avgTimeOnPage',
      dimensions: 'ga:source',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-34-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  var dataChart29 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users,ga:pageviews,ga:goalConversionRateAll,ga:avgTimeOnPage',
      dimensions: 'ga:source',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-29-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  <?php } ?>
  
  <?php if($report_type == "top_keywords"){ ?>
  var dataChart30 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:keyword',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-30-container',
      type: 'PIE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
  var dataChart31 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users',
      dimensions: 'ga:keyword',
      'start-date': start_date,
      'end-date': end_date,
      sort:'-ga:keyword',
      'max-results' : '1'
    },
    chart: {
      container: 'chart-31-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  
  
  
  var dataChart32 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:users,ga:pageviewsPerSession,ga:goalConversionRateAll',
      dimensions: 'ga:keyword',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-32-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  <?php } ?>
  
  
  <?php if($report_type == "social_media"){ ?>
  var dataChart33 = new gapi.analytics.googleCharts.DataChart({
    query: {
      metrics: 'ga:pageviews,ga:avgTimeOnPage,ga:goalConversionRateAll',
      dimensions: 'ga:hasSocialSourceReferral',
      'start-date': start_date,
      'end-date': end_date
    },
    chart: {
      container: 'chart-33-container',
      type: 'TABLE',
      options: {
        width: '100%',
        pieHole: 4/9
      }
    }
  });
  <?php } ?>
 
  
   
<?php if($report_type == "overview"){ ?>
  /**
   * Update the first dataChart when the first view selecter is changed.
   */
   viewSelector1.on('change', function(ids) {
    dataChart1.set({query: {ids: ids}}).execute();
  });

  /**
   * Update the second dataChart when the second view selecter is changed.
   */
  viewSelector2.on('change', function(ids) {
    dataChart2.set({query: {ids: ids}}).execute();
  });

    /**
   * Update the second dataChart when the second view selecter is changed.
   */
  viewSelector3.on('change', function(ids) {
    dataChart3.set({query: {ids: ids}}).execute();
  });

viewSelector4.on('change', function(ids) {
    dataChart4.set({query: {ids: ids}}).execute();
  });

viewSelector5.on('change', function(ids) {
    dataChart5.set({query: {ids: ids}}).execute();
  });
  
  viewSelector6.on('change', function(ids) {
    dataChart6.set({query: {ids: ids}}).execute();
  });
  
  viewSelector7.on('change', function(ids) {
    dataChart7.set({query: {ids: ids}}).execute();
  });
  
   viewSelector8.on('change', function(ids) {
    dataChart8.set({query: {ids: ids}}).execute();
  });

    viewSelector9.on('change', function(ids) {
    dataChart9.set({query: {ids: ids}}).execute();
  });

<?php } ?>
  <?php if($report_type == "top_pages"){ ?>
  
    viewSelector10.on('change', function(ids) {
        dataChart10.set({query: {ids: ids}}).execute();
     });
     
     viewSelector11.on('change', function(ids) {
        dataChart11.set({query: {ids: ids}}).execute();
     });

     viewSelector12.on('change', function(ids) {
        dataChart12.set({query: {ids: ids}}).execute();
     });

     viewSelector13.on('change', function(ids) {
        dataChart13.set({query: {ids: ids}}).execute();
     });

     viewSelector14.on('change', function(ids) {
        dataChart14.set({query: {ids: ids}}).execute();
     });
	 
<?php } ?>
     
	 <?php if($report_type == "your_visitors"){ ?>
     viewSelector15.on('change', function(ids) {
        dataChart15.set({query: {ids: ids}}).execute();
     });

      viewSelector16.on('change', function(ids) {
        dataChart16.set({query: {ids: ids}}).execute();
     });


     viewSelector17.on('change', function(ids) {
        dataChart17.set({query: {ids: ids}}).execute();
     });

      viewSelector18.on('change', function(ids) {
        dataChart18.set({query: {ids: ids}}).execute();
     });


     viewSelector19.on('change', function(ids) {
        dataChart19.set({query: {ids: ids}}).execute();
     });

      viewSelector20.on('change', function(ids) {
        dataChart20.set({query: {ids: ids}}).execute();
     });

     viewSelector21.on('change', function(ids) {
        dataChart21.set({query: {ids: ids}}).execute();
     });

      viewSelector22.on('change', function(ids) {
        dataChart22.set({query: {ids: ids}}).execute();
     });


    viewSelector23.on('change', function(ids) {
        dataChart23.set({query: {ids: ids}}).execute();
     });

      viewSelector24.on('change', function(ids) {
        dataChart24.set({query: {ids: ids}}).execute();
     });
     
     viewSelector25.on('change', function(ids) {
        dataChart25.set({query: {ids: ids}}).execute();
     });

      viewSelector26.on('change', function(ids) {
        dataChart26.set({query: {ids: ids}}).execute();
     });
	 <?php } ?>

	<?php if($report_type == "top_pages"){ ?>
      viewSelector27.on('change', function(ids) {
        dataChart27.set({query: {ids: ids}}).execute();
     });

      viewSelector28.on('change', function(ids) {
        dataChart28.set({query: {ids: ids}}).execute();
     });
	<?php } ?>

	<?php if($report_type == "top_reffers"){ ?>
	viewSelector34.on('change', function(ids) {
        dataChart34.set({query: {ids: ids}}).execute();
     });
	 
	viewSelector29.on('change', function(ids) {
        dataChart29.set({query: {ids: ids}}).execute();
     });
	<?php } ?>
	
	<?php if($report_type == "top_keywords"){ ?>
	viewSelector30.on('change', function(ids) {
        dataChart30.set({query: {ids: ids}}).execute();
     });
     
     viewSelector31.on('change', function(ids) {
        dataChart31.set({query: {ids: ids}}).execute();
     });
     
     viewSelector32.on('change', function(ids) {
        dataChart32.set({query: {ids: ids}}).execute();
     });
	<?php } ?>

	<?php if($report_type == "social_media"){ ?>
	 viewSelector33.on('change', function(ids) {
        dataChart33.set({query: {ids: ids}}).execute();
     });
	<?php } ?>




});
</script>

		<?php }else{ ?>
		
			Something went wrong. Check google analytics api  and credentials. <a href="<?php echo base_url().'admin/apis_manager' ?>" target="_blank">view api</a>
		<?php } ?>


		
		</div>
		</div>
		</div>
	</div>
	</div>

<br style="clear:both"		 /><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
