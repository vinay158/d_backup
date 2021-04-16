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
	
  </body>

</html>