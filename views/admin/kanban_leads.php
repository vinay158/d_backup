<?php $this->load->view("admin/include/header"); ?>
<style>
.custom_footer{display:none}
.az-content-body-left{padding:0px !important}
</style>

    <div class="az-content-body-left advanced_page custom_full_page kanban_leads_page">


      <div class="az-content-body kanban-page mg-t-60">
       <div style="width:100%">
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

						  <a class="dropdown-item <?php echo ($date_sort == $key) ? 'active' : ''; ?>" href="<?php echo base_url().'admin/kanban_leads?date_sort='.$key; ?><?php echo isset($_GET['type']) ? '&type='.$_GET['type'] : ''; ?>"><?php echo $val; ?></a>

						<?php } } ?>
						
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-12 col-xl-12 mg-b-20 position-top">
				<div class="float-left">
					<a href="<?php echo base_url().'admin/leads'; ?>"><button class="btn btn-with-icon btn-block"><i class="typcn typcn-folder"></i>Switch to the leads module View</button></a>
				</div>
				<div class="float-right">
						
						
						<a href="javascript:void(0)" class="full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tbl_kanban_lead_status" form_type="little_row"><button class="btn btn-with-icon btn-block"><i class="typcn typcn-plus"></i> Add Column</button></a>
						<?php if($this->session->userdata('is_search_applied') == "show"){?>
							
							<button class="btn btn-with-icon btn-block filter_result" is_display_search="hide"><i class="typcn typcn-minus"></i> Hide search bar</button>
						<?php }else{?>
							<button class="btn btn-with-icon btn-block filter_result" is_display_search="show"><i class="typcn typcn-plus"></i> Filter Result</button>
						<?php } ?>
						
					</div>
			</div>
			
			<div class="col-md-12 col-lg-12 col-xl-12 mg-b-20 search_box" style="display:<?php echo ($this->session->userdata('is_search_applied') == 'show') ? 'block' : 'none'; ?>">
		
		<div class="gen-panel searchbox">
				<form  method="get" action="">
				
			<div class="form-new-holder">
			<div class="row row-xs align-items-center">
				
				<div class="col-md-12  mg-t-5 mg-md-t-0">
				<div class="row mg-t-10">
				<div class="col-md-2">
						<h1>Status</h1>
						<select name="lead_status" id="kanban_status_dropdown" class="field search_field">
							<option value="">-All Status-</option>
							<?php foreach($kanban_lead_all_status as $key => $status){ ?>
								<option value="<?php echo $status->id; ?>" <?php echo (isset($_GET['lead_status']) && $_GET['lead_status'] == $status->id) ? "selected=selected" : ''; ?>><?php echo $status->title; ?></option>
							<?php } ?>
						</select>
					</div>
				
				<div class="col-md-2">
						<h1>Tag</h1>
						<select name="tags" id="" class="field search_field">
							<option value="">-All Tag-</option>
							<?php foreach($kanban_lead_tags as $key => $val){ ?>
								<option value="<?php echo $val->tag; ?>" <?php echo (isset($_GET['tags']) && $_GET['tags'] == $val->tag) ? "selected=selected" : ''; ?>><?php echo $val->tag; ?></option>
							<?php } ?>
						</select>
					</div>
					
				<?php if($multiLocation[0]->field_value == 1){ ?>
					<div class="col-md-2">
						<h1>Location</h1>
							<select  id='location_sort' name="location" class="field search_field">
								<option value="">-All Locations-</option>
								<?php foreach($allLocations as $location){ ?>
								<option value="<?php echo $location->id ?>" <?php echo (isset($_GET['location']) && $_GET['location'] == $location->id) ? "selected=selected" : ''; ?>><?php echo $location->name; ?></option>
								<?php } ?>
							</select>
					</div><!-- col-3 -->
					<?php } ?>
				
				
					<div class="col-lg-2">
						<h1>Date Range</h1>
						<select name="date_sort" id="" class="field sort_dates search_field">
							<?php foreach($dateRanges['sorting_list'] as $key => $val){ ?>
								<option value="<?php echo $key; ?>" <?php echo ($key == $date_sort) ? 'selected=selected' : '' ?>><?php echo $val; ?></option>
							<?php } ?>
						</select>
					</div>
					
					<div class="col-md-2">
					<h1>Search Keyword</h1>
					<input type="text" name="search_keyword" class="field search_field" value="<?php echo isset($_GET['search_keyword']) ? $_GET['search_keyword'] : ''; ?>">
				</div>
					
					
							<div class="col-lg-1 nopadding">
								<h1>&nbsp;</h1>
								<input type="submit" value="Search" class="searchbtn btn-save" />
							</div>
							
							<div class="col-lg-1 nopadding">
								<h1>&nbsp;</h1>
								<a href="<?php echo base_url().'admin/kanban_leads'; ?>" class="button_class btn btn-outline-light">Clear</a>
							</div>
							
							
					
					</div>
				</div>
			</div>
			</div>

</form>	
			</div>
			</div>
			
		</section>
<?php /*foreach($kanban_lead_status as $status){ ?>		
	<style type="text/css">
	
	.kanban_status_1{
   display: grid !important;
    flex-direction: column !important;
	width:100%;
}

<?php if(isset($all_leads[$status->id]) && !empty($all_leads[$status->id])){  
	if($status->id == 1){
		foreach($all_leads[$status->id] as $lead){
			$lead_type = $this->query_model->getKanbanLeadTypeToOrderType($lead->lead_type);
			$lead_id = $lead->id;
			$kanban_status_id = $status->id;
			
			$sort_number = $this->query_model->getKanbanSortNumber($kanban_status_id,$lead_type,$lead_id);
?>
.kanban_status_1 > .lead_<?php echo $lead_type ?>_<?php echo $lead_id; ?> {order: <?php echo $sort_number ?> !important; display:grid !important} 
<?php 		}
		}
	}
 ?>

	</style>
<?php }*/ ?>
	
	<section class="light-grey-bg" style="display:none;">
			
			<div class="col-md-12 col-lg-12 col-xl-12 mg-t-0 filter-cont" style="text-align: center;">
			<!------old Start----->
				
				<!------old End----->
				<div class="drag-container "></div>
				<div id="slider" >
			<?php if(!empty($kanban_lead_status)){ ?>		
					<ul class="board muuri" style="width: <?php echo 336* count($kanban_lead_status); ?>px;">
					
					<!--<div id="new_added_status"></div>-->
					
					<?php foreach($kanban_lead_status as $status){?>
					
	
	
  <li class="board-column board-column-custom_<?php echo $status->id; ?> todo muuri-item red-theme muuri-item-shown kanban_lead_status_<?php echo $status->id; ?>" color_code="<?php echo !empty($status->color_code) ? $status->color_code : 'red'; ?>" kanban_status_id="<?php echo $status->id; ?>">
    <div class="board-column-container"  >
        <div class="board-column-header"   style="background:<?php echo !empty($status->color_code) ? $status->color_code : 'red'; ?>">
			<div class="heading">
				<h3 class="little_row_heading_<?php echo $status->id; ?>"><?php echo $status->title; ?></h3>
				<span class="float-right"><i class="fas fa-ellipsis-v"></i>
				<nav class="az-menu-sub">
			
<a href="javascript:void(0)" class="nav-link full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?php echo $status->id; ?>"  table_name="tbl_kanban_lead_status" form_type="little_row">Edit</a>
<?php if(!isset($all_leads[$status->id]) || empty($all_leads[$status->id]) ){ ?>
<a href="javascript:void(0)" class="nav-link delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_title="<?php echo $status->title; ?>" item_id="<?php echo $status->id; ?>"  table_name="tbl_kanban_lead_status" form_type="little_row">Delete</a>
<?php } ?>
		</nav></span>
				
			</div>
		</div>
		
      <div class="board-column-content-wrapper board-column-content-wrapper_<?php echo $status->id; ?>">
        <div class="board-column-content muuri kanban_status_<?php echo $status->id; ?>" >
		
		<?php 
			if(isset($all_leads[$status->id]) && !empty($all_leads[$status->id])){  
				foreach($all_leads[$status->id] as $lead){
					
					$lead_type = $this->query_model->getKanbanLeadTypeToOrderType($lead->lead_type);
					
					/*$sort_positions = $this->query_model->getKanbanSortPositions($status->id,$lead_type,$lead->id);
					$position_x = isset($sort_positions->position_x) ? $sort_positions->position_x : 0;
					$position_y = isset($sort_positions->position_y) ? $sort_positions->position_y : 0;*/
		?>
          <aside class="board-item muuri-item order_items_<?php echo $status->id; ?> muuri-item-shown lead_<?php echo $lead_type; ?>_<?php echo $lead->id; ?>" lead_type="<?php echo $lead_type; ?>" lead_id="<?php echo $lead->id; ?>" kanban_status_id="<?php echo $status->id; ?>">
		  
		  <div class="board-item-content modal-effect " data-toggle="modal" data-effect="effect-scale"  lead_type="<?php echo $lead->lead_type; ?>" lead_id="<?php echo $lead->id; ?>" email="<?php echo $lead->email; ?>" popup_title="<?=$lead->email?>"  style="border-left:10px solid <?php echo !empty($status->color_code) ? $status->color_code : 'red'; ?>">
		  
		  <a href="" class="az-img-user"  lead_type="<?php echo $lead->lead_type; ?>" lead_id="<?php echo $lead->id; ?>" email="<?php echo $lead->email; ?>" popup_title="<?=$lead->email?>"><i class="typcn typcn-user"></i></a>
		  
								<a href="" class="username"  lead_type="<?php echo $lead->lead_type; ?>" lead_id="<?php echo $lead->id; ?>" email="<?php echo $lead->email; ?>" popup_title="<?=$lead->email?>"><h4><?php echo $lead->name; ?></h4></a>
								<span class="detail"><strong>Date Added:</strong> <?php echo date('M d, Y ', strtotime($lead->created)); ?></span>
								 <?php
									
									$tags = $this->query_model->getOrderTagsByOrderId($lead->id,$lead_type,'program_tag');
										if(!empty($tags)){ 
											foreach($tags as $tag){
								?>
								<span class="badge badge-primary"><?php echo $tag; ?></span>
								<?php } } ?>
								<!--Email: <?=$lead->email?><br/>
								Lead Type: <?php echo $lead_type; ?><br/>
								Lead ID: <?php echo $lead->id; ?><br/>-->
								<div class="icon">
									<a href="tel:<?php echo $lead->phone; ?>"><i class="fas fa-phone"></i></a>
									<a href="tel:<?php echo $lead->phone; ?>"><i class="fas fa-mobile-alt"></i></a>
									<a href="mailto:<?php echo $lead->email; ?>"><i class="fas fa-envelope"></i></a>
								</div></div></aside>
					<?php } }?>
          
		  </div>
      </div>
    </div>
  </li>
  <?php } ?>  
</ul>
			<?php } ?>  
 
 
			</div>
			
		</section>
		  </div>
     </div><!-- az-content-body -->
	
   </div><!-- az-content -->
	
	</div>


	<div id="popup" class="modal kanban kanban_lead_info_popup">
      <div class="modal-dialog modal-dialog-centered" role="document">
		<div id="order_lead_info"></div>
       </div><!-- modal-dialog -->
    </div><!-- modal -->
  
 <?php $this->load->view("admin/include/footer");?>
 
<!--<script src="<?=base_url();?>assets_admin/lib/jquery/jquery.min.js"></script>-->
    
 
    
<script src="<?=base_url();?>assets_admin/lib/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script src="<?=base_url();?>assets_admin/js/owl.carousel.min.js"></script>
	<script src="<?=base_url();?>assets_admin/js/jquery.swipeSlider.js"></script>
	 <script src="<?=base_url();?>assets_admin/lib/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?=base_url();?>assets_admin/js/web-animations.min.js"></script>
<script src="<?=base_url();?>assets_admin/js/muuri.min.js"></script>
<script src="<?=base_url();?>assets_admin/js/azia.js"></script>


<script src="color_overlay_opacity_pickier/js/spectrum.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="color_overlay_opacity_pickier/css/spectrum.css">
	
	
    <script>
	 if(window.matchMedia('(min-width: 992px)').matches) {
	var $width = $('.greybg').width();
		console.log($width + 'px');
		$(".filter-cont").css("width", $width + 'px');
		$(".light-grey-bg").css("display", 'block');
		new PerfectScrollbar('#slider');
	} else {
		
	}
		 
      $(function(){
	
        'use strict'
		// showing modal with effect
       
		
		
	   

        // hide modal with effect
        $('#popup').on('hidden.bs.modal', function (e) {
		
          $(this).removeClass (function (index, className) {
              return (className.match (/(^|\s)effect-\S+/g) || []).join(' ');
          });
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

          suppressScrollX: true,
		  	

        });


		

        /* ----------------------------------- */

        /* Dashboard content */


		var dragContainer = document.querySelector('.drag-container');
		var itemContainers = [].slice.call(document.querySelectorAll('.board-column-content'));
		var columnGrids = [];
		var boardGrid;

// Init the column grids so we can drag those items around.
itemContainers.forEach(function (container) {
  var grid = new Muuri(container, {
    items: '.filter-cont .board-item',
	
	hideDuration: 300,
	hideEasing: 'ease',	
	visibleStyles: {
    opacity: '1',
    transform: 'scale(1)'
  },
  hiddenStyles: {
    opacity: '0',
    transform: 'scale(0.5)'
  },
    // Layout
  layout: {
    fillGaps: false,
    horizontal: false,
    alignRight: false,
    alignBottom: false,
    rounding: false
  },
  layoutOnResize: 150,
  layoutOnInit: true,
  layoutDuration: 300,
  layoutEasing: 'ease',
  
  
  itemClass: 'muuri-item',
  itemVisibleClass: 'muuri-item-shown',
  itemHiddenClass: 'muuri-item-hidden',
  itemPositioningClass: 'muuri-item-positioning',
  itemDraggingClass: 'muuri-item-dragging',
  itemReleasingClass: 'muuri-item-releasing',
  itemPlaceholderClass: 'muuri-item-placeholder',
    dragEnabled: true,
	dragStartPredicate: {
    distance: 40,
    delay: 200 
  },
  dragSortPredicate: {
    threshold: 70,
    action: 'move',
    migrateAction: 'move'
  },
   dragRelease: {
              duration: 400,
              easing: 'cubic-bezier(0.625, 0.225, 0.100, 0.890)',
              useDragContainer: true,
            },
            dragPlaceholder: {
              enabled: true,
              createElement: (item) => item.getElement().cloneNode(true),
            },
    dragSort: function () {
		
      return columnGrids;
	 
    },
	
    dragContainer: dragContainer,
    dragAutoScroll: {
		
      targets: item => {
        return [
        { element: window, priority: 0 },
        { element: item.getGrid().getElement().parentNode, priority: 1 }];

      } } }).


  on('dragInit', function (item) {
	 // alert('dragInit');
	// console.log('dragInit');
    item.getElement().style.width = item.getWidth() + 'px';
    item.getElement().style.height = item.getHeight() + 'px';
	
	
  }).
  
  on('dragReleaseEnd', function (item) {
	//alert('drag pass');
	//console.log('dragReleaseEnd');
	console.log(item);
    item.getElement().style.width = '';
    item.getElement().style.height = '';
    item.getGrid().refreshItems([item]);
	
	var newdata = item._element;
	
	 var old_kanban_status_id = newdata.getAttribute('kanban_status_id');
	 var lead_type = newdata.getAttribute('lead_type');
	 var lead_id = newdata.getAttribute('lead_id');
	 var new_kanban_status_id = $('.lead_'+lead_type+'_'+lead_id).parents('.board-column').attr('kanban_status_id');
	
	//console.log('old_kanban_status_id=>'+old_kanban_status_id+'=>'+'lead_type=>'+lead_type+'=>'+'lead_id=>'+lead_id+'=>'+'new_kanban_status_id=>'+new_kanban_status_id);
			
			
		$.ajax({
				url: "admin/kanban_leads/update_move_lead_status_id",
				type: "post",
				dataType: "json",
				data: {lead_type:lead_type,lead_id:lead_id,new_kanban_status_id:new_kanban_status_id,old_kanban_status_id:old_kanban_status_id,'action':'update_lead_status'},
				success:function(data){
					$('#popup').modal('hide');
					if(data.response == 1){
						
						
						$('.lead_'+lead_type+'_'+lead_id).attr('kanban_status_id',data.status_type_id);
						$('.lead_'+lead_type+'_'+lead_id).removeClass('order_items_'+old_kanban_status_id);
						$('.lead_'+lead_type+'_'+lead_id).addClass('order_items_'+new_kanban_status_id);
						var color_code = $('.kanban_lead_status_'+data.status_type_id).attr('color_code');
						$('.kanban_status_'+data.status_type_id).find('.board-item-content').css('border-left','10px solid '+color_code);
						
							
							
					}else{
						alert('something went wrong'); return false;
					}
					
				}
						
		});
		
		// updateSortOrders(new_kanban_status_id,'drag');
		
  }).
  on('layoutStart', function () {
	// console.log('layoutStart');
    boardGrid.refreshItems().layout();
  });

  columnGrids.push(grid);
	
  //grid.refreshItems();
  
  grid.on('dragEnd', function (item, event) {
	  
	 // console.log($(this).attr('lead_type'));
	 //console.log(data.item._element);
	 var newdata = item._element;
	 var current_kanban_status_id = newdata.getAttribute('kanban_status_id');
	 
	 updateSortOrders(current_kanban_status_id,'move');
	 
	 
	
	});
	
	

});
 $('.muuri-item .heading .float-right').click(function(){
			  $(this).toggleClass('is-active');
			});
if ($(window).width() < 700) {
			var options = {
					// animationDuration: 300,
					// autoReverse: true,
					// autoTransitionDuration: false, // in ms
					// bounce: true,
					// drag: true,
					// infinite: true,
					// onSlideStartCallback: function() {},
					// onSlideCompleteCallback: function() {},
					// onMoveCallback: function() {},
					// onStartCallback: function() {},
					// startIndex: 0
				}

				var slider = $('#slider').swipeSlider(options);
				
// Init board grid so we can drag those columns around.
boardGrid = new Muuri('.board', {
  dragEnabled: false,
  dragHandle: '.board-column-header' });
		} else {
			
		<?php 
		if(!empty($kanban_lead_status)){
			foreach($kanban_lead_status as $status){ ?>	
		new PerfectScrollbar('.board-column-content-wrapper_<?php echo $status->id; ?>', {
            suppressScrollX: true
          });
		  
		  $('.board-column-content-wrapper_<?php echo $status->id; ?>').scrollTop($('.board-column-content-wrapper_<?php echo $status->id; ?>').prop('scrollHeight'));
		<?php } } ?>
		  /*new PerfectScrollbar('.yellow-theme .board-column-content-wrapper', {
            suppressScrollX: true
          }); 
		  new PerfectScrollbar('.orange-theme .board-column-content-wrapper', {
            suppressScrollX: true
          });
		  new PerfectScrollbar('.red-theme .board-column-content-wrapper', {
            suppressScrollX: true
          });
		  new PerfectScrollbar('.blue-theme .board-column-content-wrapper', {
            suppressScrollX: true
          });
		  
		  new PerfectScrollbar('.green-theme .board-column-content-wrapper', {
            suppressScrollX: true
          });*/
		  //   alert($('.board-column-content-wrapper').prop('scrollHeight')); 
          
		  
		 

// Init board grid so we can drag those columns around.
boardGrid = new Muuri('.board', {
  dragEnabled: true,
  dragAxis: 'x',

  dragHandle: '.board-column-header' })
  .on('dragEnd', function (item, event) {
	 console.log('pass');
	 
	 var responseData = [];
	 $.each($('.board-column'),function(i, item){
		 var kanban_status_id = $(this).attr('kanban_status_id');
		 responseData.push({kanban_status_id: kanban_status_id,position:$(this).css('transform').split(',')[4]});
		
	 })
	//console.log(responseData); 
	if(responseData.length === 0){
		
	}else{
		$.ajax({
				url: "admin/kanban_leads/ajax_sort_kanban_status",
				type: "post",
				dataType: "json",
				data: {responseData:responseData,'action':'sort_kanban_status'},
				success:function(data){
					
				}
						
		});
	}
	
  
  });

    //# sourceURL=pen.js
		}

        
      });


function updateSortOrders(current_kanban_status_id,event_type){
	//alert(current_kanban_status_id);
	var kanban_status_id = '';
	 <?php 
		if(!empty($kanban_lead_status)){
			foreach($kanban_lead_status as $status){ 
	?>	
	 kanban_status_id = '<?php echo $status->id ?>';
	 var responseData = [];
	 var total_result = $('.order_items_'+kanban_status_id).length;
	 console.log('current_kanban_status_id=>'+current_kanban_status_id+'==>'+event_type);
	 $.each($('.order_items_'+kanban_status_id),function(i, item){
		 var final_total_result = parseInt(total_result) - 1;
		 var lead_type = $(this).attr('lead_type');
		 var lead_id = $(this).attr('lead_id');
		 var positionX = $(this).css('transform').split(',')[4];
		 var positionY = $(this).css('transform').split(',')[5];
		 if(event_type == "move"){
			if(current_kanban_status_id == kanban_status_id){
				if(i != 0){
					responseData.push({lead_type: lead_type, lead_id: lead_id,position:$(this).css('transform').split(',')[5],positionX:positionX,positionY:positionY});
				 }
			 }else{
				  responseData.push({lead_type: lead_type, lead_id: lead_id,position:$(this).css('transform').split(',')[5],positionX:positionX,positionY:positionY});
			 }
		 }else{
			 //responseData.push({lead_type: lead_type, lead_id: lead_id,position:$(this).css('transform').split(',')[5],positionX:positionX,positionY:positionY}); 
		 }
		 
		 
		
	 })
	
	//console.log(responseData); 
	 console.log('type==>'+event_type);
	 console.log(responseData);
	if(responseData.length === 0){
		
	}else{
		
		$.ajax({
				url: "admin/kanban_leads/ajax_sort_kanban_leads",
				type: "post",
				dataType: "json",
				data: {responseData:responseData,kanban_status_id:kanban_status_id,'action':'sort_kanban_leads'},
				success:function(data){
					$('#popup').modal('hide');
					if(data.response == 1){
							
							
					}else{
						alert('something went wrong'); return false;
					}
					
				}
						
		});
	}
		<?php } } ?>	
}	  
	  
$(document).ready(function(){
	

	$('body').on('click','.filter_result', function(){
		$('.search_box').toggle('show');
		var is_display_search = $(this).attr('is_display_search');
		if(is_display_search == 'show'){
			$(this).html('<i class="typcn typcn-minus"></i> Hide Search Bar');
			$(this).attr('is_display_search','hide');
		}else{
			$(this).html('<i class="typcn typcn-plus"></i> Filter Result');
			$(this).attr('is_display_search','show');
		}
		
		
		$.ajax({
				url: "admin/kanban_leads/update_search_bar",
				type: "post",
				dataType: "json",
				data: {is_display_search:is_display_search,'action':'update_search_bar'},
				success:function(data){
					
				}
						
		});
		
	});
	
	$('body').on('click','.remove_kanban_order_tag', function(){
		
		var tag_id = $(this).attr('tag_id');
		$.ajax({

				url : 'admin/kanban_leads/ajax_remove_kanban_order_tag',
				type : 'POST',
				dataType: "json",
				data :{tag_id : tag_id,action:'remove_kanban_tag'},
				success:function(data){
					if(data.response == 1){
						$('.kanban_tag_'+tag_id).remove();
					}
				}

		});
		
		
			
	})
	
	$('body').on('click','.add_kanban_tag_btn', function(){
		
		var lead_type = $(this).attr('lead_type');
		var lead_id = $(this).attr('lead_id');
		var tag_type = $(this).attr('tag_type');
		var tag = $('.add_kanban_tag_input').val();
		
		$.ajax({

				url : 'admin/kanban_leads/ajax_add_kanban_order_tag',
				type : 'POST',
				dataType: "json",
				data :{lead_type : lead_type,lead_id:lead_id,tag_type:tag_type,tag:tag,action:'add_kanban_tag'},
				success:function(data){
					if(data.response == 1){
						$('.kanban_tag_list_'+lead_type+'_'+lead_id).append('<span class="badge badge-pill badge-primary kanban_tag_'+data.tag_id+'">'+tag+'<span class="remove_kanban_order_tag" tag_id="'+data.tag_id+'">x</span></span>');
						$('.add_kanban_tag_input').val('');
					}
				}

		});
		
		
			
	})
	
	
	$('body').on('click','.full_alternate_popup', function(){
		
		var action_type = $(this).attr('action_type');
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var form_type = $(this).attr('form_type');
		
		$('#fullAlternatePopup').find('.modal-title').html(action_type + ' Status');
		
		$.ajax({

				url : 'admin/kanban_leads/ajax_add_kanban_lead_status',
				type : 'POST',
				data :{action_type : action_type, item_id : item_id,table_name:table_name,form_type:form_type},
				success:function(data){
					$('#fullAlternatePopup').modal('show');
					$('#form_alternate_popup').html(data);
					
				}

		});
		
		
			
	})
	
	$('body').on('keyup','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	
	$('body').on('click','.save_full_row_add_btn', function(){
		
		var form_color_code = $(".form_color_code").val();
		var form_status_title = $(".form_status_title").val();
		//alert(form_color_code); 
		$('.form_error_msg').hide();
		var error = 0;
		$.each($('.required_field'),function(){
			var check = $(this).val();
			if(check == '') {
				$(this).css('border','1px solid red');
				error = 1;
			}
		})
		
		if(error == 0){
			
			var formData = $('#fullAlternateAddForm').serialize();
			
			$.ajax({ 					
				type: 'POST',						
				url : 'admin/kanban_leads/ajax_save_full_alternate_row',
				dataType : 'json',
				data: { formData : formData}					
				}).done(function(data){ 
				
				if(data.res == 1){
					
					if(data.form_action == "add"){
						
						
						$('#fullAlternatePopup').modal('hide');
						
						$('#responsePopup').find('.action_response_msg').html('Successfully added!');
						
					}else{
						var item_id = data.id;
						var form_type = data.form_type;
						//alert('.'+form_type+'_heading_'+item_id); 
						$('.'+form_type+'_heading_'+item_id).html(data.title);
						$('.kanban_lead_status_'+item_id).find('.board-column-header').css('background',form_color_code);
						$('.kanban_lead_status_'+item_id).find('.board-item-content').css('border-left','10px solid '+form_color_code);
						
						
						$('#fullAlternatePopup').modal('hide');
						
						//alert('dsafdsaf');//kanban_status_dropdown
						$('#kanban_status_dropdown').empty();
									
						$("#kanban_status_dropdown").append('<option value="">-All Status-</option>');
						
						 <?php
							$selected_kanban_status = (isset($_GET['lead_status']) && !empty($_GET['lead_status'])) ? $_GET['lead_status'] : ''; 
						?>
						$.each(data.kanban_lead_status, function(index, element) {
							var selected_kanban_status = '<?php echo $selected_kanban_status; ?>';
							if(element.id == selected_kanban_status){
								$("#kanban_status_dropdown").append('<option value="'+element.id+'" selected="selected">'+element.title+'</option>');
							}else{
								$("#kanban_status_dropdown").append('<option value="'+element.id+'">'+element.title+'</option>');
							}
							
						});
						
						
						$('#responsePopup').find('.action_response_msg').html('Successfully updated!');
					
					}
					
					$('#responsePopup').modal('show');
					setTimeout(function() {
						$('#responsePopup').modal('hide');
							if(data.form_action == "add"){
								location.reload();
							}
						}, 3000);
					
					
					
				}
			});
			
		}else{
			$('.form_error_msg').show();
		}
		
			
	})
	
	$('body').on('click','.add_lead_comment',function(){
		var comment = $('.lead_comment').val();
		var lead_type = $(this).attr('lead_type');
		var lead_id = $(this).attr('lead_id');
		$('.send_comment_response').hide();
		if(comment != "" && comment != null){
			$.ajax({
					url: "admin/kanban_leads/save_lead_comment",
					type: "post",
					dataType: "json",
					data: {lead_type:lead_type,lead_id:lead_id,comment:comment,'action':'send_comment'},
					success:function(data){
						
						if(data.response == 1){
							$('.lead_comment').val('');
							$("#new_comment_added").prepend('<div class="recent_added_comment"><div class="comment_date">A FEW SECONDS AGO</div><div class="comment">'+data.comment+'</div></div>');
							$('.lead_comment').attr('placeholder','Add Comment');
							
							$('.send_comment_response').show();	
							$('.send_comment_response').addClass('success');
							$('.send_comment_response').removeClass('error');
							$('.send_comment_response').html('Comment Successfully Added.');
							
							setTimeout(function() {
									$('.send_comment_response').hide();	
								}, 3000);
								
						}else{
							$('.send_comment_response').show();	
							$('.send_comment_response').removeClass('success');
							$('.send_comment_response').addClass('error');
							$('.send_comment_response').html('Please write something in comment area!');
							
							setTimeout(function() {
									$('.send_comment_response').hide();	
								}, 3000);
							
							return false;
							
						}
						
					}
				});
		}else{
			$('.send_comment_response').show();	
			$('.send_comment_response').removeClass('success');
			$('.send_comment_response').addClass('error');
			$('.send_comment_response').html('Please write something in comment area!');
			
			setTimeout(function() {
					$('.send_comment_response').hide();	
				}, 3000);
			
			return false;
		}
	})
	
	$('body').on('click','.update_lead_status_id',function(){
		var status_type = $(this).attr('status_type');
		var lead_type = $(this).attr('lead_type');
		var lead_id = $(this).attr('lead_id');
		var kanban_status_id = $(this).attr('kanban_status_id');
		
		$.ajax({
				url: "admin/kanban_leads/update_lead_status_id",
				type: "post",
				dataType: "json",
				data: {lead_type:lead_type,lead_id:lead_id,status_type:status_type,kanban_status_id:kanban_status_id,'action':'update_lead_status'},
				success:function(data){
					
					if(data.response == 1){
						
						var old_lead_html = $('.lead_'+lead_type+'_'+lead_id).html();
						$('.lead_'+lead_type+'_'+lead_id).remove();
						
						$('.kanban_status_'+data.status_type_id).append('<aside class="board-item muuri-item muuri-item-shown order_items_'+data.status_type_id+' lead_'+lead_type+'_'+lead_id+'" lead_type="'+lead_type+'" lead_id="'+lead_id+'" kanban_status_id="'+data.status_type_id+'" >'+old_lead_html+'</aside>');
						
						var color_code = $('.kanban_lead_status_'+data.status_type_id).attr('color_code');
						
						$('.kanban_status_'+data.status_type_id).find('.board-item-content').css('border-left','10px solid '+color_code);
						
						$('#popup').modal('hide');
						$('#responsePopup').find('.action_response_msg').html('Successfully tranferd lead '+data.old_kanban_status_name +' to '+data.kanban_status_name);
						
						$('#responsePopup').modal('show');
							setTimeout(function() {
								$('#responsePopup').modal('hide');
								location.reload();	
								}, 3000);
								
						

							
							
					}else{
						alert('something went wrong'); return false;
					}
					
				}
						
		});
			
	})
	
	
	 $('body').on('click','.board-item-content .az-img-user,.board-item-content  .username', function(e){
          e.preventDefault();
		   
		   var lead_id = $(this).attr('lead_id');
		   var email = $(this).attr('email');
		   var popup_title = $(this).attr('popup_title');
		   var lead_type = $(this).attr('lead_type');
		   
		   $.ajax({
				url : '<?=base_url();?>admin/kanban_leads/ajax_kanban_lead_info',
				type :'POST',
				dataType :'html',
				data : {lead_id : lead_id, email : email,lead_type:lead_type, action: 'get_record'}
			}).done(function(result){
				
				$('#popup').addClass('effect-slide-in-bottom').modal('show');
				
				$('.user_name_info').html(popup_title);
				$('#order_lead_info').html(result);
			});
		   
		   
		   
		  
        });
		
		
		
$('body').on('click','.delete_item', function(){
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var form_type = $(this).attr('form_type');
		var item_title = $(this).attr('item_title');
		
		$('#popupDeleteItem').modal('show');
		$('#popupDeleteItem').find('.modal-title').html('Status: '+item_title);
		$('#popupDeleteItem').find('#delete_item_id').val(item_id);
		$('#popupDeleteItem').find('#delete_item_table_name').val(table_name);
		$('#popupDeleteItem').find('#delete_item_section_type').val(form_type);
	})
	
	
 	$('body').on('click','.popup_delete_btn', function(){
		
		
		var formData = $('#popupDeleteItem').find('form').serialize();
		var form_action = $('#popupDeleteItem').find('form').attr('action');
		var item_id = $('#popupDeleteItem').find('#delete_item_id').val();
		
		
		$.ajax({ 					
			type: 'POST',						
			url: form_action,						
			data: { formData : formData}					
			}).done(function(msg){ 
			if(msg == 1){
				
				
				$('.kanban_lead_status_'+item_id).remove();
				$('#popupDeleteItem').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully deleted!');
				setTimeout(function() {
						$('#responsePopup').modal('hide');
						location.reload();
						}, 3000);
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	
		
	
})

    </script>
	

<div id="fullAlternatePopup" class="modal add_kanban_lead_status">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form id="fullAlternateAddForm" action="" method="post" enctype="multipart/form-data">
		  <div id="form_alternate_popup"></div>
		  
		  <input type="hidden" name="program_id" value="<?php echo $this->uri->segment(4) ?>" class="" />
		  <input type="hidden" name="cat_id" value="<?php echo $this->uri->segment(6) ?>" class="" />
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	<div id="popupDeleteItem" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="admin/kanban_leads/delete_kanban_status" method="post" id="deleteForm">
          <div class="modal-body edit-form">
             <div class="row row-xs align-items-center delete_popup_text_block">
					<div class="col-md-12 mg-t-5 mg-md-t-0 text-center">
						<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
						<h2 class="heading">Are you sure?</h2>
						<h5 class="subheading">You will not be able to recover the deleted record.</h5>
					</div>
				</div>
				<input type="hidden" name="delete-item-id" id="delete_item_id" value="">
				<input type="hidden" name="table_name" id="delete_item_table_name" value="">
				<input type="hidden"  id="delete_item_section_type" value="">
          </div>
          <div class="modal-footer">
			  <div class="col-md-6 text-left">
				<a href="javascript:void(0)" class="btn btn-indigo popup_cancel_btn" data-dismiss="modal">No, cancel please !</a>
			  </div>
			   <div class="col-md-6 text-right">
				<a href="javascript:void(0)" class="btn btn-indigo popup_delete_btn">Yes, Delete It !</a>
			   </div>
          </div>
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	