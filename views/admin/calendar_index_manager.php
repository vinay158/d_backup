<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name"><?=$title?> Manager</div>
				<!--  
				<div class="panel-filter">
					<input type="text" name="filter_text" id="filter-input" />
					<input type="submit" name="filter_submit" id="filter-btn" value="Filter">
				</div>
				-->
			</div>
<div class="panel-body">
				<div class="panel-body-holder manager">
					<div class="manager-holder">
					<!-- category items -->
					<?php $this->load->view("admin/include/category-calendar");?>
					<!--  End category items -->
						<div class="manager-items">
							<div id="content-replace">
							   	<h1 id="breadcrumbs"></h1>
								<div class="btn-addentry"><a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>"></a></div>
								<div style="font-style:italic;font-size:11px;margin:12px 100px;">
                                	<!-- changelog v2 - modify text -->
									Special Events and Closed Days will be shown on the Upcoming Events widget at the top of the website, as well as on the calendar
								</div>
								
								<!--  
								<ul id="blog-items" class="cat_sort ui-sortable2" style="">
								-->
								<ul id="blog-items" class="cat_sort" style="">
								<?php
								$sr_calendar=0; 
								if(!empty($blogs)): $counter = 0;?>
                       			<?php foreach($blogs as $brow):
                       				$sr_calendar++;                       				
                       			?>
                       			
                       			<?php $counter++; ?>
									<li id="menu_<?=$brow->id?>">
										<div class="manager-item">
											<div style="float:left;">
												<!-- <h2><?=$brow->id; ?></h2> -->
												<h2><?=$sr_calendar?></h2>
												<h1><a href="admin/<?=$link_type?>/edit/<?=$brow->id.'/view/'.$this->uri->segment(4)?>"><?=character_limiter($brow->title, 35);?></a> - <?=$brow->repeat?></h1>
											</div>
											<div class="manager-item-opts">
											
											<?=date_format(date_create($brow->mydate), 'F d, Y H:m A')?>
											
											<?php if($brow->repeat == 'never' AND $brow->is_multiple ==0):?>
												<?php echo $brow->start;?> - <?php echo $brow->end;?>
											<?php endif;?>
											
                                            <a href="admin/calendar/exception/<?=$brow->id.'/view/'.$this->uri->segment(4)?>"  class="lb-preview">Exception</a>
											<a href="admin/calendar/edit/<?=$brow->id.'/view/'.$this->uri->segment(4)?>"  class="lb-preview">Edit</a>
											<script language="javascript">
											$(document).ready(function(){
												var mod_type1 = $("#mod_type").val().toLowerCase();
												//alert(mod_type1);return false;
												/*try {
													$(".ui-sortable2").sortable({
													update : function () {
													serial = $('.ui-sortable2').sortable('serialize');
													$.ajax({
													url: "admin/"+mod_type1+"/sortthis",
													type: "post",
													data: serial,
													error: function(){
													alert("theres an error with AJAX");
													}
													});
													}
													});
												} catch(e) {  }*/
											$(".unpublish").click(function(){
												var pub_id = $(this).attr("id").substr(6);
												var mod_type = $("#mod_type").val().toLowerCase();
												var publish_type = $(this).parents(".manager-item-opts").children(".publish_type").val();
												//alert (publish_type);
												$.ajax({ 					
												type: 'POST',						
												url: 'admin/'+mod_type+'/publish',						
												data: { pub_id : pub_id, publish_type: publish_type }					
												}).done(function(msg){ 
												if(msg != null){
												//alert(msg);
												setTimeout("window.location.reload()",1000);
												}
												else{
												setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
												//alert(msg);
												}
												});
												//exit(0);
											});
											$(".delete_item").click(function(){
											var del_item_id = $(this).attr("id").substr(8);
											$("#delete-item-id").val(del_item_id);
											$(".delete-holder-item").hide();
											$(".delete-holder-item").slideDown(300);
											//exit(0);
											});


											$("#sortcats").click(function(){												
												
												$(this).hide();
												$("#finishedsorting").show();
												$(".categories-link").each(function(){
													//$(this).children("span").empty();
													$(this).children("").addClass("handle");
													$(this).children("span").children("a").css("visibility", "hidden");
												});
												return true;
												
												});
												
												
												$("#finishedsorting").click(function(){											
												$(this).hide();											
												$("#sortcats").show();											
												$(".categories-link").each(function(){
												//$(this).children("span").empty();
												$(this).children("span").removeClass("handle");
												$(this).children("span").children("a").css("visibility", "visible");
												});
												window.location.reload();					
												
												});
											})
											</script>
											<!-- <input type="hidden" name="mod_type" value="<?=$title;?>" id="mod_type" /> -->
											
											<a id="delitem_<?=$brow->id; ?>" class="delete_item" title="Delete <?=$brow->title?>">Delete</a></div>
										</div>
									</li>
								
								<?php endforeach;?>
								<?php else : ?>
										
										<div class="empty"><a href="admin/<?=$link_type?>/add/<?=$this->uri->segment(4);?>" class="nothing-yet">Add an Entry to this Category</a></div>
								<?php endif;?>
								
								</ul>
								<script language="javascript">
								$(document).ready(function(){
									var breadcrumbs = $(".categories-holder .active").children(".show-entries").text();
									var numItems = <?php echo isset($counter)?$counter:0; ?>;
									$("#breadcrumbs").html(breadcrumbs+"<span>"+numItems+"&nbsp;Entries</span>");
									if(numItems>0)
										$(".ti_item_start").html(numItems);
									else
										$(".ti_item_start").html("0");
									$(".ti_item_end").html(numItems);
								});
								</script>
								
							</div>
						</div>	
					</div>
					<?php $this->load->view("admin/include/conf_delete_item"); ?>
					<script language="javascript">
$(document).ready(function(){

$(".close-btn").click(function(){
$("#dropdown-holder").slideUp(200);
$(".delete-holder").slideUp(200);	
});
});
</script>
					<div class="categories-opts">
					<script language="javascript">
					$(document).ready(function(){
						$("#addcats").click(function(){
						$("#dropdown-holder").hide();
						$(".delete-holder").hide();	
						$("#dropdown-holder").slideDown(200);
						$(".drop-add-title").html("Add Category");
						$("#cat_title").val("");
						$(".sef_title").html("");
						$("#shared").removeClass("check-on");
						$("#shared").addClass("check-off");
						$("#shared-id").val(0);
						$("#operation").val("add");
						$(".btn-delete").hide();
						});
					});
					</script>
					
						<div class="btn-plus" id="addcats"><?php if(count($cat) <= 20): ?><a></a><?php endif;?></div>
						<div class="btn-sortcats" id="sortcats"><a></a></div>
						<div class="btn-finishedsorting" id="finishedsorting" style="display:none;"><a></a></div>
					</div>
					
					<div class="manager-nav" id="nav-updater">
						<div id="paginator" style="float:left;">
							<div class="btn-navleftarrow">
									<div class="pagination-prev"><a href="" class="ti_prev disabled"></a></div>
							</div>
							<div class="btn-navrightarrow">
									<div class="pagination-next"><a href="" class="ti_next disabled"></a></div>
							</div>
							<div id="paginator_links" class="ti_numbers"><span class="ti_number_current">1</span></div>
						</div>
						<div id="paginator-msg" style="padding-top:5px;float:right;">
							Showing <span class="ti_item_start"></span>-<span class="ti_item_end"></span>
						</div>
					</div>

				</div>
			</div> 
		</div>
	</div>
	<input type="hidden" name="mod_type" value="<?=$link_type;?>" id="mod_type" />
	<!-- include modal for category -->
	<?php $this->load->view("admin/include/cat-modal-calendar"); ?>
	<!-- end modal for category -->
	
	<!-- include modal for category -->
	<?php $this->load->view("admin/include/confirmation-modal"); ?>
	<!-- end modal for category -->