<?php 
?>
<div class="gen-holder">
		<div class="gen-panel">
			<div class="panel-title">
				<div class="panel-title-name"><?=$title?> Manager</div>
				<!--<div class="panel-filter">
                
					<input type="text" name="filter_text" id="filter-input" />
					<input type="submit" name="filter_submit" id="filter-btn" value="Filter">
                 
				</div>-->
			</div>
<div class="panel-body">
				<div class="panel-body-holder manager">
					<div class="manager-holder">
					<!---------------- category items ------------->
					<?php //$this->load->view("admin/include/category");?>
					<!------------  End category items ------------>
						<div class="manager-items" style="margin-left: 1px!important; width: 99.9%">
							<div id="content-replace">
							    <script language="javascript">
								$(document).ready(function(){
									var breadcrumbs = $(".categories-holder .active").children(".show-entries").text();
									var numItems = $('#blog-items li').length;
									$("#breadcrumbs").html(breadcrumbs+"<span>"+numItems+"&nbsp;Entries</span><a href='admin/<?php echo $title?>/add' class='button_class'>Add Page</a>");
									if(numItems>0)
										$(".ti_item_start").html(numItems);
									else
										$(".ti_item_start").html("0");
									$(".ti_item_end").html(numItems);
								});
								</script>
								<h1 id="breadcrumbs"></h1>
								<!--<div class="btn-addentry add_entry_button"></div>-->
								<ul id="blog-items" class="cat_sort ui-sortable" style="">
								<?php if(!empty($pages)): $counter = 0;?>
                       			<?php foreach($pages as $page):?>
                       			<?php $counter++; ?>
									<li>
										<div class="manager-item">
											<div style="float:left;">
												<h2><?php echo  $page->id; ?></h2>
												<h1><a href="admin/<?php echo $title; ?>/edit/<?php echo $page->id; ?>"><?php echo character_limiter($page->title, 15);?></a></h1>
											</div>
											<div class="manager-item-opts"><?php echo date_format(date_create($page->timestamp), 'F d, Y H:m A'); ?>
											<a href="admin/<?php echo $title; ?>/edit/<?php echo $page->id; ?>" class="lb-preview">Edit</a>
											<script language="javascript">
											$(document).ready(function(){
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
											})
											})
											</script>
											<input type="hidden" name="mod_type" value="<?php echo $title;?>" id="mod_type" />
											
											<?php if($page->published == 1){?>
											<a id="unpub_<?php echo $page->id; ?>" href="admin/<?php echo $title?>/publish/<?php echo $page->id; ?>/publish"   class="unpublish" title="Unpublish <?php echo $page->title; ?>">Unpublish</a>
											<input type="hidden" name="publish_type" value="0" class="publish_type" />
											<?php }else{ ?>
											<input type="hidden" name="publish_type" value="1" class="publish_type" />
											<a id="unpub_<?php echo $page->id; ?>" href="admin/<?php echo $title?>/publish/<?php echo $page->id; ?>/unpublish"  class="unpublish" title="Publish <?php echo $page->title; ?>">Publish</a>
											<?php }?>
											<a id="delitem_<?php echo $page->id; ?>" href="admin/<?php echo $title?>/delete/<?php echo $page->id; ?>"  class="delete_item" title="Delete <?php echo $page->title; ?>">Delete</a></div>
                                            </div>
									</li>
								
								<?php endforeach;?>
								<?php else : ?>
								
										<div class="empty"><a href="admin/<?php echo $title; ?>/add/<?php echo $this->uri->segment(4);?>" class="nothing-yet">Add an Entry to this Page</a></div>
								<?php endif;?>
								
								</ul>
							</div>
						</div>	
					</div>
					<?php //$this->load->view("admin/include/conf_delete_item"); ?>
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
						<div class="btn-plus" id="addcats"><a href="admin/<?php echo $title?>/add"></a></div>
					</div>

					<div class="manager-nav" id="nav-updater">
						<div id="paginator" style="float:left;">
							<div class="btn-navleftarrow">
									<div class="pagination-prev"><a href="#" class="ti_prev disabled"></a></div>
							</div>
							<div class="btn-navrightarrow">
									<div class="pagination-next"><a href="#" class="ti_next disabled"></a></div>
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

	<!------- include modal for category ----------->
	<?php //$this->load->view("admin/include/cat-modal"); ?>
	<!--------- end modal for category -------------->
	
	<!------- include modal for category ----------->
	<?php //$this->load->view("admin/include/confirmation-modal"); ?>
	<!--------- end modal for category -------------->