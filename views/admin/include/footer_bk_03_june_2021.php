<div class="clearfix"></div>

<?php 
	$custom_footer_cls = 'custom_footer';
	$customFooterArr = array('dashboard'); 
	
	if($this->uri->segment(2) != ""){
		if(in_array($this->uri->segment(2),$customFooterArr)){
			$custom_footer_cls = '';
		}
	}else{
		$custom_footer_cls = '';
	}
?>

<?php if($this->uri->segment(2) == "" || $this->uri->segment(2) == "dashboard"){ ?>
<div class="az-footer  <?= $custom_footer_cls; ?> ht-40">
	<div class="container-fluid mg-t-20 mg-b-20 ht-100p">
	<a href="index.html" class="az-logo"><img src="<?=base_url();?>assets_admin/img/logo-footer.png" alt=""></a>
	<span class="pull-right">Version 5.0 | © <?php echo  date('Y') ?> Websitedojo 
		<br>
		<div class="footerlink"><a>Home</a> | <a>Contact</a> | <a>Support</a></div>
	</span>
	</div><!-- container -->
  </div>
<?php }else{ ?>

<div class="az-footer <?= $custom_footer_cls; ?> ht-40">
        <div class="container-fluid pd-t-0-f ht-100p">
          <span>&copy; <?php echo  date('Y') ?></span>
        </div>
      </div>
<?php } ?>

</div>
	  


<?php 
	$is_home_page = 0;
	
	if($this->uri->segment(1) == "admin" && $this->uri->segment(2) == ""){
		$is_home_page = 1;
	}else{
		if($this->uri->segment(1) == "admin" && $this->uri->segment(2) == "dashboard"){
			$is_home_page = 1;
		}
	}
	
?>

	<?php if($is_home_page == 1){ ?>
		<script src="<?=base_url();?>assets_admin/lib/jquery/jquery.min.js"></script>
	<?php } ?>
	
	<script src="<?=base_url();?>assets_admin/lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="<?=base_url();?>assets_admin/js/azia.js"></script>
	<script src="<?=base_url();?>assets_admin/lib/ionicons/ionicons.js"></script>
	
	
     <script>
$(document).ready(function() {
		
		
		
		$('#azContactList a').bind('click', function(e) {
				e.preventDefault(); // prevent hard jump, the default behavior

				var target = $(this).attr("href"); // Set the target as variable

				// perform animated scrolling by getting top-position of target-element and set it as scroll target
				$('html, body').stop().animate({
						scrollTop: $(target).offset().top
				}, 600, function() {
						location.hash = target; //attach the hash (#jumptarget) to the pageurl
				});

				return false;
				
		});
});

$(window).scroll(function() {
		var scrollDistance = $(window).scrollTop();
		
		
		$('.page-section').each(function(i) {
				if ($(this).position().top <= scrollDistance) {
						$('#azContactList a.selected').removeClass('selected');
						$('#azContactList a').eq(i).addClass('selected');
				}
		});

		
}).scroll();
</script>
	

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



        // closing of sidebar menu when clicking outside of it

          if(!$(e.target).closest('.az-header-menu-icon').length) {

            var sidebarTarg = $(e.target).closest('.az-sidebar').length;

            if(!sidebarTarg) {

              $('body').removeClass('az-sidebar-show');

            }

          }

        });

        

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
	
	
	
	/*$('[data-toggle="tooltip-primary"]').tooltip({
			  template: '<div class="tooltip tooltip-primary" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>'
    });*/

	$('.az-toggle').on('click', function(){
          $(this).toggleClass('on');
        })


      });

    </script>
	
	
	
	<script>
		$(window).load(function(){
			<?php 
				//$user_level = $this->session->userdata('user_level');
				//if($user_level != 1){
			?>
			$.each($('.subChildPage'),function(){
				if($(this).find("a").length){
					
				}else{
					$(this).hide();
				}
			})
			<?php //} ?>
		})
	</script>
	
	
	
	
<?php if($is_home_page == 1){ ?>
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

    <script src="<?=base_url();?>assets_admin/js/dashboard.sampledata.js"></script>
	
    


    <script>

      $(function(){

        'use strict'

$('[data-popover-color="head-primary"]').popover({
          template: '<div class="popover popover-head-primary" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
        });
       
var datapie = {
    labels: ['1-3', '4-10', '11+'],
    datasets: [{
      data: [45,20,35],
      backgroundColor: ['#5620cd', '#fb0d1c','#26a8d3']
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
 
  var datapie = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
    datasets: [{
      data: [20,20,30,5,25],
      backgroundColor: ['#560bd0', '#007bff','#00cccc','#cbe0e3','#74de00']
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
  
  var ctx5 = document.getElementById('chartBar5').getContext('2d');
  new Chart(ctx5, {
    type: 'bar',
    data: {
      labels: ['Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
      datasets: [{
		label: 'Paid Trials',
        data: [90, 60, 40, 60, 40],
        backgroundColor: '#fe0000'
      }, {
		label: 'Free Trials',
        data: [55, 45, 33, 55, 35],
        backgroundColor: '#26a8d3'
      }]
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





        /* ----------------------------------- */

        /* Dashboard content */





        


       


        $.plot('#flotChart5', [{

            data: dashData2,

            color: '#00cccc'

          },{

            data: dashData3,

            color: '#007bff'

          },{

            data: dashData4,

            color: '#f10075'

          }], {

          series: {

            shadowSize: 0,

            lines: {

              show: true,

              lineWidth: 2,

              fill: false,

              fillColor: { colors: [ { opacity: 0 }, { opacity: 1 } ] }

            }

          },

          grid: {

            borderWidth: 0,

            labelMargin: 20

          },

          yaxis: {

            show: false,

            min: 0,

            max: 100

          },

          xaxis: {

            show: true,

            color: 'rgba(0,0,0,.16)',

            ticks: [

              [0, ''],

              [10, '<span>Nov</span><span>05</span>'],

              [20, '<span>Nov</span><span>10</span>'],

              [30, '<span>Nov</span><span>15</span>'],

              [40, '<span>Nov</span><span>18</span>'],

              [50, '<span>Nov</span><span>22</span>'],

              [60, '<span>Nov</span><span>26</span>'],

              [70, '<span>Nov</span><span>30</span>'],

            ]

          }

        });



        $.plot('#flotChart6', [{

            data: dashData2,

            color: '#6f42c1'

          },{

            data: dashData3,

            color: '#007bff'

          },{

            data: dashData4,

            color: '#00cccc'

          }], {

          series: {

            shadowSize: 0,

            stack: true,

            bars: {

              show: true,

              lineWidth: 0,

              fill: 0.85

              //fillColor: { colors: [ { opacity: 0 }, { opacity: 1 } ] }

            }

          },

          grid: {

            borderWidth: 0,

            labelMargin: 20

          },

          yaxis: {

            show: false,

            min: 0,

            max: 100

          },

          xaxis: {

            show: true,

            color: 'rgba(0,0,0,.16)',

            ticks: [

              [0, ''],

              [10, '<span>Nov</span><span>05</span>'],

              [20, '<span>Nov</span><span>10</span>'],

              [30, '<span>Nov</span><span>15</span>'],

              [40, '<span>Nov</span><span>18</span>'],

              [50, '<span>Nov</span><span>22</span>'],

              [60, '<span>Nov</span><span>26</span>'],

              [70, '<span>Nov</span><span>30</span>'],

            ]

          }

        });



        



      });

    </script>
<?php } ?>




	
	<div id="responsePopup" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title action_response_heading">Success</h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		 <div class="modal-body edit-form">
            <div class="row row-xs align-items-center text-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<p class="action_response_msg"></p>
					</div>
				</div>
          </div>
        </div>
      </div><!-- modal-dialog -->
    </div>
	
	<div id="popupDeleteRecord" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title delete_modal_title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="admin/dashboard/ajax_delete_record" method="post" id="deleteRecordForm">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center delete_popup_text_block">
					<div class="col-md-12 mg-t-5 mg-md-t-0 text-center">
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						<h2 class="heading">Are you sure?</h2>
						<h5 class="subheading">You will not be able to recover the deleted record.</h5>
					</div>
				</div>
				<input type="hidden" name="delete-item-id" id="delete_record_id" value="">
				<input type="hidden" name="table_name" id="delete_record_table_name" value="">
				<input type="hidden"  id="delete_record_section_type" value="">
          </div>
          <div class="modal-footer">
			  <div class="col-md-6 text-left">
				<a href="javascript:void(0)" class="btn btn-indigo popup_cancel_btn"  data-dismiss="modal">No, cancel please !</a>
			  </div>
			   <div class="col-md-6 text-right">
				<a href="javascript:void(0)" class="btn btn-indigo ajax_popup_delete_btn">Yes, Delete It !</a>
			   </div>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	
	<div id="popupDuplicateItem" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="" method="post" id="duplicatePopupForm">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<h1>Title</h1>
						<input type="text" name="title" id="dupcat_program_title" class="field full_width_input" value="">
						<em> Note: If you want then change title </em>
					</div>
				</div>
				<input type="hidden" name="action" value="duplicate_record">
				<input type="hidden" name="item_id" id="dupcat_item_id" value="">
				<input type="hidden" name="table_name" id="dupcat_item_table_name" value="">
				<input type="hidden"  id="dupcat_item_redirect_path" value="">
				<input type="hidden"  id="dupcat_item_section_type" value="">
          </div>
          <div class="modal-footer">
            <a href="javascript:void(0)" class="btn btn-indigo dupcat_popup_btn">Save</a>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	<div id="popupDeleteLeadRecord" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title delete_modal_lead_title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="admin/leads/ajax_delete_record" method="post" id="deleteRecordForm">
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center delete_popup_text_block">
					<div class="col-md-12 mg-t-5 mg-md-t-0 text-center">
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						<h2 class="heading">Are you sure?</h2>
						<h5 class="subheading">You will not be able to recover the deleted record.</h5>
					</div>
				</div>
				<input type="hidden" name="delete-item-id" id="delete_lead_id" value="">
				<input type="hidden" name="lead_type" id="delete_lead_lead_type" value="">
				<input type="hidden" name="delete-lead-email" id="delete_lead_email" value="">
          </div>
          <div class="modal-footer">
			  <div class="col-md-6 text-left">
				<a href="javascript:void(0)" class="btn btn-indigo popup_cancel_btn"  data-dismiss="modal">No, cancel please !</a>
			  </div>
			   <div class="col-md-6 text-right">
				<a href="javascript:void(0)" class="btn btn-indigo ajax_popup_lead_delete_btn">Yes, Delete It !</a>
			   </div>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	


<input type="hidden" id="site_base_url" value="<?php echo base_url() ?>">
  </body>

</html>