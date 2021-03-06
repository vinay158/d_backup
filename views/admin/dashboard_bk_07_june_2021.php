<?php $this->load->view("admin/include/header"); ?>

 <script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));

</script>
    
      <div class="az-content-header d-block d-md-flex mg-t-0">

        <div>
			
        </div>
	
      </div><!-- az-content-header -->

      <div class="az-content-body homepageupdates">

       <div class="row row-sm">
			
			<section class="greybg">
			
			<div class="col-md-12 col-lg-12 col-xl-12 mg-b-20" style="text-align: center;">
				<div class="dropdown">
					<button class="btn btn-secondary-outline dropdown-toggle month-button" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					   <?php echo isset($dateRanges['sorting_list'][$date_sort]) ? $dateRanges['sorting_list'][$date_sort] : ''; ?>
					</button>
					<div class="dropdown-menu tx-13">
					  <h6 class="dropdown-header tx-uppercase tx-11 tx-bold tx-inverse tx-spacing-1"><?php echo isset($dateRanges['sorting_list'][$date_sort]) ? $dateRanges['sorting_list'][$date_sort] : ''; ?></h6>
					  <?php 
						foreach($dateRanges['sorting_list'] as $key => $val){ 
							if($date_sort != $key){
					?>

						  <a class="dropdown-item <?php echo ($date_sort == $key) ? 'active' : ''; ?>" href="<?php echo base_url().'admin/dashboard?date_sort='.$key; ?><?php echo isset($_GET['type']) ? '&type='.$_GET['type'] : ''; ?>"><?php echo $val; ?></a>

						<?php } } ?>
					</div>
				</div>
			</div>
			<div class="row row-sm">
          <div class="col-md-3 col-lg-3 col-xl-3">

            <div class="card redbg">
              <div class="media">
                <div class="media-body">
				<span>Leads to Call Back</span>
                  <h6 class="total_unique_leads"><?php echo isset($website_leads['total_unique_leads']) ? $website_leads['total_unique_leads'] : 0; ?></h6>
                  <div class="notify">
					<div data-container="body"   data-popover-color="head-primary" data-placement="top" title="" data-content="The number of users that come to the page.The number of users is different from the number of sessions. Users can create multiple sessions.The number of users shows the unique users." data-original-title="Leads to Call Back " aria-describedby="popover86564"><i class="fa fa-question-circle"></i></div>
					
					</div>
					<div class="rightbticon"><i class="fa fa-phone fa-rotate-90" aria-hidden="true"></i></div>
                </div>
              </div>
            </div><!-- card -->
          </div><!-- col -->
          <div class="col-md-3 col-lg-3 col-xl-3 ">
            <div class="card lightblue">
              <div class="media">
                <div class="media-body">				
					<span >Website Leads</span>
                  <h6 class="total_unique_leads"><?php echo isset($website_leads['total_unique_leads']) ? $website_leads['total_unique_leads'] : 0; ?></h6>
				<div class="notify">
					<div data-container="body"   data-popover-color="head-primary" data-placement="top" title="" data-content="The number of users that come to the page.The number of use.rs is different from the number of sessions. Users can create multiple sessions.The number of users shows the unique users." data-original-title="Website Leads " aria-describedby="popover86564"><i class="fa fa-question-circle"0></i></div></div>
					<div class="rightlinkname"><a href="<?php echo base_url().'admin/leads' ?>">View Leads</a></div>	
                </div>
              </div>            
            </div><!-- card -->
          </div><!-- col-3 -->                                               
          <div class="col-md-3 col-lg-3 col-xl-3  ">
            <div class="card lightblue">
              <div class="media">
                <div class="media-body">
				<span>Website Visitors</span>
                  <h6 class="graph_total_website_visitor">0</h6>
                  <div class="notify">
					<div data-container="body"   data-popover-color="head-primary" data-placement="top" title="" data-content="The number of users that come to the page.The number of users is different from the number of sessions. Users can create multiple sessions.The number of users shows the unique users." data-original-title="Website Visitors " aria-describedby="popover86564"><i class="fa fa-question-circle"></i></div></div>
					<div class="rightlinkname"><a href="<?php echo base_url().'admin/site_statistics/report' ?>">View Stats</a></div>		
                </div>
              </div>        
            </div><!-- card -->
          </div><!-- col -->
		   <div class="col-md-3 col-lg-3 col-xl-3 ">
            <div class="card lightblue">
              <div class="media">
                <div class="media-body">
				<span>Conversion Rate</span>
                  <h6 class="graph_conversion_rate">0</h6>
                  <div class="notify">
					<div data-container="body"   data-popover-color="head-primary" data-placement="top" title="" data-content="The number of users that come to the page.The number of users is different from the number of sessions. Users can create multiple sessions.The number of users shows the unique users." data-original-title="Conversion Rate " aria-describedby="popover86564"><i class="fa fa-question-circle"></i></div></div>
					<div class="rightlinkname"><a href="<?php echo base_url().'admin/site_statistics/report' ?>">View Stats</a></div>	
                </div>

              </div>

             

            </div><!-- card -->

          </div><!-- col -->
		
          
		 
		</div>
		</section>

		<div class="col-md-9 col-xl-9 mg-t-20 col-lg-9">
            <div class="card card-dashboard-twentyfive keyword-bar card-body newProspects">
				<label class="az-content-label tx-base mg-b-25">New Prospects</label>
				<ul>
				<?php 
					if(isset($website_leads['latest_leads']) && !empty($website_leads['latest_leads'])){
						$i = 1;
						foreach($website_leads['latest_leads'] as $lead){
							
							$this->db->select(array('color_code'));
							$kanban_lead_status = $this->query_model->getBySpecific('tbl_kanban_lead_status','id',$lead->kanban_status_id);
							
							$status_color_code = !empty($kanban_lead_status) ? $kanban_lead_status[0]->color_code : 'red';
							
							$created = strtotime($lead->created);
						
						if($i <= 5 && $lead->kanban_status_id == 1){
				?>
				<style>
					.newProspects ul .new_lead_<?php echo $lead->kanban_status_id.'_'.$lead->id; ?> .status::before{background:<?php echo $status_color_code; ?>}
					.newProspects ul .new_lead_<?php echo $lead->kanban_status_id.'_'.$lead->id; ?> .status{color:#fff}
				</style>
					<li class="new_lead_<?php echo $lead->kanban_status_id.'_'.$lead->id; ?>">
						<div class="icon">
							<a href="tel:<?php echo $lead->phone; ?>"><i class="fas fa-phone"></i></a>
							<a href="tel:<?php echo $lead->phone; ?>"><i class="fas fa-mobile-alt"></i></a>
							<a href="mailto:<?php echo $lead->email; ?>"><i class="fas fa-envelope"></i></a>
						</div>
						<div class="heading"><?php echo $lead->name ?></div>
						
						<div class="day"><?php echo $this->query_model->getTimeAgo(date('Y-m-d H:i:s',$created)); ?></div>
						<div class="status " style="background:<?php echo $status_color_code; ?>"><?php echo !empty($lead->kanban_status_id) ?  $this->query_model->getKanbanStatusNameByID($lead->kanban_status_id) : '';  ?></div>
						<a href="javascript:void(0)" class="action"><i class="fas fa-angle-right"></i></a>
					</li>
				<?php   $i++; } } } ?>
				</ul>
			</div>
		</div>
		<div class="col-md-3 col-xl-3 mg-t-20 col-lg-3 featire_list">
             <div class="card card-dashboard-twentyfive keyword-bar card-body mg-b-20 featire_box"><a class="quickbox"><img src="<?=base_url();?>assets_admin/img/icon1.png" /><span>Leads Follow-Up Sales Pipeline</span></a></div>
			  <div class="card card-dashboard-twentyfive keyword-bar card-body mg-b-20 featire_box"><a class="quickbox"><img src="<?=base_url();?>assets_admin/img/icon2.png" /><span>Leads Follow-Up Sales Pipeline</span></a></div>
			 <div class="card card-dashboard-twentyfive keyword-bar card-body featire_box"><a class="quickbox"><img src="<?=base_url();?>assets_admin/img/icon3.png" /><span>Leads Follow-Up Sales Pipeline</span></a></div>
    </div>
	
	<div class="col-sm-6 col-xl-6 mg-t-20 col-lg-6 site-statics">
            <div class="card card-dashboard-twentyfive keyword-bar card-body "><div class="row ">
              <div class="col-12 " >
                <div class="chart-wrapper">
                  <div class="d-md-flex">
					<canvas id="chartBar5" style="height:270px !important"></canvas>
			          </div>
                </div><!-- chart-wrapper -->
              </div><!-- col -->
              
            </div><!-- row --></div>
		 </div>
          <div class="col-sm-6 col-xl-6 mg-t-20 col-lg-6 site-statics">
            <div class="card card-dashboard-twentyfive keyword-bar card-body"><div class="row ">
              <div class="col-12 " >
                <label class="card-label mg-l-20">Your SEO/Keyword Rankings on Google</label>
                <div class="chart-wrapper">
                  <div class="d-md-flex">
					<div class="col-md-6 col-lg-5" style="position:relative;"><canvas id="chartPie"></canvas></div>
					<div class="col-md-6 col-lg-7 mg-lg-l-0 mg-t-20 mg-md-t-0">
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Positions 1-3</span>
                        <span>1,320 <span>(45%)</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-45p" style="background:#58a6e1;" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><!-- progress -->
                    </div>
                    <div class="az-traffic-detail-item">
                      <div> 	
                        <span>Positions 4-10</span>
                        <span>987 <span>(20%)</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-20p" style="background:#b2daf8;" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><!-- progress -->
                    </div>
                    <div class="az-traffic-detail-item">
                      <div>
                        <span>Positions 11+</span>
                        <span>2,010 <span>(35%)</span></span>
                      </div>
                      <div class="progress">
                        <div class="progress-bar wd-35p" style="background:#6777cd;" role="progressbar" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                      </div><!-- progress -->
                    </div>
                  </div><!-- col -->
				</div>
                </div><!-- chart-wrapper -->
              </div><!-- col -->              
            </div><!-- row --></div>
		 </div>
		  </div>
     </div><!-- az-content-body -->
	
   </div><!-- az-content -->
	<div class="az-content-body-right">
          
          <label class="az-content-label tx-base mg-b-25">2 Recent Reviews</label>
          <div class="az-media-list-reviews">
            <div class="media">
              <div class="az-img-user"><img src="https://via.placeholder.com/500" alt=""></div>
              <div class="media-body">
                <div class="d-flex justify-content-between mg-b-10">
                  <div>
                    <h6 class="mg-b-0">Bob Smith<br/><span>Karate for Kids

</span></h6>
                    <div class="az-star-group">
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <span>4.1</span>
                    </div><!-- star-group -->
                  </div>
                  <small>1 hour ago</small>
                </div>
                <p class="mg-b-0">Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed amet...<a href="">Read more</a></p>
              </div><!-- media-body -->
            </div><!-- media -->
            <div class="media">
              <div class="az-img-user"><img src="https://via.placeholder.com/500" alt=""></div>
              <div class="media-body">
                <div class="d-flex justify-content-between mg-b-10">
                  <div>
                    <h6 class="mg-b-0">Bob Smith<br/><span>Karate for Kids
	
</span></h6>
                    <div class="az-star-group">
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <div class="az-star-item"><i class="icon ion-md-star"></i></div>
                      <span>4.5</span>
                    </div><!-- star-group -->
                  </div>
                  <small>2 days ago</small>
                </div>
                <p class="mg-b-0">Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed amet...<a href="">Read more</a></p>
              </div><!-- media-body -->
            </div><!-- media -->
          </div><!-- media-list -->

          <hr class="mg-y-25">
          <label class="az-content-label tx-base mg-b-25">Open Tasks</label>
		  <div class="az-open-task">
			<div class="media mg-b-40">
				<div class="desc ">Call Mr. Turtle to renew membership. his credit card was compromised. </div>
				<div class="quicklink">
					<a><i class="fas iconbox fa-angle-right"></i> <div class="name">Raphael  <i class="fas fa-arrow-right"></i> <span class="red">Donatello</span></div><div class="date">Due: Today</div></a>
				</div>
			</div>
			<div class="media mg-b-40">
				<div class="desc mg-b-0">Call Mr. Turtle to renew membership. his credit card was compromised. </div>
				<div class="quicklink">
					<a><i class="fas iconbox fa-angle-right"></i> <div class="name">Raphael  <i class="fas fa-arrow-right"></i> <span class="red">Donatello</span></div><div class="date">Due: Today</div></a>
				</div>
			</div>
          </div><!-- media-list -->
		  <hr class="mg-y-25">
          <label class="az-content-label tx-base mg-b-25">Activity Stream</label> 
          <div class="az-media-list-activity mg-b-20">
		  <?php
			if(!empty($latest_leads)){
				$i = 1;
				foreach($latest_leads as $lead){
					if($i <= 9){
					
					$created = strtotime($lead->created);
					$lead_type = $lead->lead_type;
					$new_lead_type = $this->query_model->getKanbanLeadTypeToOrderType($lead_type);
					$page_name = '';
					
					
					if($new_lead_type == "trial_offer_lead"){
						if(isset($lead->page_url) && !empty($lead->page_url)){
							$PagesList = $this->query_model->getMenuMainPages(0,3);
							$pagesListing = array();
							foreach($PagesList as $pages){
								$pagesListing =  $this->query_model->getAllPagesForAddCode($pages['id'], $pages['slug']);
							}
							
							$page_name = isset($pagesListing[$lead->page_url]) ? $pagesListing[$lead->page_url] : '';
						}
						
					}elseif($new_lead_type == "birthday_party_lead"){
						if(isset($lead->program_id) && !empty($lead->program_id)){
							
							$this->db->select('program');
							$program_detail = $this->query_model->getBySpecific('tblprogram','id',$lead->program_id);
							
							$page_name = !empty($program_detail) ? $program_detail[0]->program : '';
							
						}
						
					}elseif($new_lead_type == "dojocart_lead"){
						if(isset($lead->product_id) && !empty($lead->product_id)){
							
							$this->db->select('product_title');
							$dojocart_detail = $this->query_model->getBySpecific('tbl_dojocarts','id',$lead->product_id);
							
							$page_name = !empty($dojocart_detail) ? $dojocart_detail[0]->product_title : '';
						}
					}
					
					
		  ?>
            <div class="media">
              <div class="media-icon bg-success"><i class="typcn typcn-tick-outline"></i></div>
              <div class="media-body">
                <h6><?php echo isset($lead_types[$lead_type]) ? $lead_types[$lead_type] : ''; ?></h6>
                <span><?php echo $page_name; ?></span>
              </div>
              <div class="media-right"><?php echo $this->query_model->getTimeAgo(date('Y-m-d H:i:s',$created)); ?></div>
            </div><!-- media -->
			<?php $i++; } } } ?>   
          </div><!-- az-media-list-activity -->
          <a href="<?php echo base_url().'admin/kanban_leads' ?>" class="btn btn-outline-light btn-block">View All Activities</a>
        </div>
	</div>
	
	
	<script>
		$(window).load(function(){
			<?php if(isset($_GET['switch_error_code']) && !empty($_GET['switch_error_code'])){ ?>
			
				$('#switchResponsePopup').modal({backdrop: 'static', keyboard: false}) 
				
				setTimeout(function(){ 
					window.location.href= 'admin/dashboard';
				}, 25000);

			<?php } ?>
		})
		
		$(document).ready(function(){
			
			$('body').on('click','#switchResponsePopup .close', function(){
				window.location.href= 'admin/dashboard';
			})
		})
		
	</script>
	
	<div id="switchResponsePopup" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title action_response_heading">Switch User Response</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		 <div class="modal-body edit-form">
            <div class="row row-xs align-items-center text-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
					<?php
						$this->db->select('dojo_crm_url');
						$site_setting = $this->query_model->getByTable('tblsite');
					?>
						
						<p>The user you want switch to <b>CRM Panel</b> does not match the records we have for your account. To troubleshoot, please contact to info@websitedojo.com</p>
						To Login CRM<a href="<?php echo $site_setting[0]->dojo_crm_url; ?>" target="_blank"> Click here </a>
					</div>
				</div>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div>
	
<?php $this->load->view("admin/include/footer");?>

<script src="<?=base_url();?>assets_admin/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?=base_url();?>assets_admin/lib/jquery.flot/jquery.flot.js"></script>

    <script src="<?=base_url();?>assets_admin/lib/jquery.flot/jquery.flot.resize.js"></script>

    <script src="<?=base_url();?>assets_admin/lib/jqvmap/jquery.vmap.min.js"></script>

    <script src="<?=base_url();?>assets_admin/lib/jqvmap/maps/jquery.vmap.world.js"></script>


	<script src="<?=base_url();?>assets_admin/lib/chart.js/Chart.bundle.min.js"></script>
	<script src="<?=base_url();?>assets_admin/lib/jquery.flot/jquery.flot.js"></script>
    <script src="<?=base_url();?>assets_admin/lib/jquery.flot/jquery.flot.pie.js"></script>
    <script src="<?=base_url();?>assets_admin/lib/jquery.flot/jquery.flot.resize.js"></script>
    
    <script src="<?=base_url();?>assets_admin/lib/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="<?=base_url();?>assets_admin/lib/raphael/raphael.min.js"></script>
	<script src="<?=base_url();?>assets_admin/js/owl.carousel.min.js"></script>
    <script src="<?=base_url();?>assets_admin/js/dashboard.sampledata.js"></script>
	
    
<script>

      $(function(){

        'use strict'


        $('.az-sidebar .with-sub').on('click', function(e){

          e.preventDefault();

          $(this).parent().toggleClass('show');

          $(this).parent().siblings().removeClass('show');

        })



        $(document).on('click touchstart', function(e){

          e.stopPropagation();



 0         // closing of sidebar menu when clicking outside of it

          if(!$(e.target).closest('.az-header-menu-icon').length) {

            var sidebarTarg = $(e.target).closest('.az-sidebar').length;

            if(!sidebarTarg) {

              $('body').removeClass('az-sidebar-show');

            }

          }

        });
var datapie = {
    labels: ['1-3', '4-10', '11+'],
    datasets: [{
      data: [45,20,35],
      backgroundColor: ['#58a6e1', '#b2daf8','#482bc5']
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
 /**************** PIE CHART *******************/
          
		  function labelFormatter(label, series) {
            return '<div style="font-size:8pt; text-align:center; padding:2px; color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>';
          }
 
 /* var res_data = <?php echo json_encode($free_paid_trial_leads); ?>;
  var graphData = [];
	$.each(res_data, function(i, item) {
		
		var date = i;
		
		graphData.date = [];
		graphData.push({period: date, trial_offer_type:'Free', total_leads: item.free_trials[0].total_free_trial});
		graphData.push({period: date, trial_offer_type:'Paid', total_leads: item.paid_trials[0].total_paid_trial});
		
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
			if(value.trial_offer_type == "Free"){
				new_user = value.new_user;
			}else{
				returning_user = value.returning_user;
			}
		});
		responseData.push({period: i, new_user : new_user, returning_user: returning_user});
	});
	
	console.log(finalObj); return false;*/
  
    var graphTrialLables = [];
	var graphTotalFreeTrial = [];
	var graphTotalPaidTrial = [];
	
	  <?php 
			if(isset($free_paid_trial_leads) && !empty($free_paid_trial_leads)){
				foreach($free_paid_trial_leads as $date => $lead){
					$total_free_trial_leads = isset($lead['free_trials'][0]->total_free_trial) ? $lead['free_trials'][0]->total_free_trial : 0;
					$total_paid_trial_leads = isset($lead['paid_trials'][0]->total_paid_trial) ? $lead['paid_trials'][0]->total_paid_trial : 0;
		?>
		graphTrialLables.push('<?php echo $date ?>');
		graphTotalFreeTrial.push('<?php echo $total_free_trial_leads ?>');
		graphTotalPaidTrial.push('<?php echo $total_paid_trial_leads ?>');
		<?php } } ?>
	

  var ctx5 = document.getElementById('chartBar5').getContext('2d');
  new Chart(ctx5, {
    type: 'bar',
    data: {
      labels: graphTrialLables,
      datasets: [
		  {
			label: 'Paid Trials',
			data: graphTotalPaidTrial,
			backgroundColor: '#b8dcf7'
		  }, {
			label: 'Free Trials',
			data: graphTotalFreeTrial,
			backgroundColor: '#58a6e1'
		  }
	  ]
    },
    options: {
      maintainAspectRatio: true,
      legend: {
        display: true,
          labels: {
            display: true
          }
      },
	  
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero:true,
            fontSize: 11,
          }
        }
		],
        xAxes: [{
          ticks: {
            beginAtZero:true,
            fontSize: 11,
            max: 100
          }
        }]
      }
    }
  });
var owl = $('.owl-carousel');
      owl.owlCarousel({
        margin: 10,
        loop: true,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 2
          },
          1000: {
            items: 3
          }
        }
      })

        $('#azSidebarToggle').on('click', function(e){

          e.preventDefault();



          if(window.matchMedia('(min-width: 992px)').matches) {

            $('body').toggleClass('az-sidebar-hide');

          } else {

            $('body').toggleClass('az-sidebar-show');

          }

        });



        new PerfectScrollbar('.az-sidebar-body', {

          suppressScrollX: true

        });


		$('[data-toggle="popover"]').popover();

        $('[data-popover-color="head-primary"]').popover({
		  trigger: 'hover',
          template: '<div class="popover popover-head-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        });
		

        /* ----------------------------------- */

        /* Dashboard content */





      });

    </script>
	
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
	//alert(res_data); 
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
  


});
</script>
