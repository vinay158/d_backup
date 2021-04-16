<?php $this->load->view("admin/include/header"); ?>
<!-- end head contents -->
<!--wysiwyg editor script -->
<script>
	$(document).ready(function(){
		$(".deleteAddCode").click(function(){

			var add_more_number =$(this).attr('number');
			//alert(add_code_number); return false;
			$.ajax({ 					
			type: 'POST',						
			url: 'admin/add_code/delete_add_code',						
			data: { add_more_number : add_more_number}					
			}).done(function(msg){ 
			if(eval(msg) == 1){		
				$('.AddCodeRow_'+add_more_number).remove();
				//setTimeout("window.location.href='admin/add_code'",500);			
			}
			else{
				alert("Oops! Unable to Delete.");
				return false;					
			}
			});
	
		});
	});
</script>
<div class="az-content-body-left custom_full_page add_code_page advanced_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Add Code</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
	  
	  
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
		<div class="gen-panel">
			
			<?php echo form_open('admin/add_code/encrypt_code');?>
			<div class="panel-body">
				<div class="panel-body-holder">
				
					<div class="form-holder">
						
						
							<?php if($this->session->flashdata('good_message')):?>
							<div class="alert alert-success">
								<?php echo $this->session->flashdata('good_message');?>
							</div>	
							<?php endif; ?>
							
						
						<?php $code_placed = array('header' => htmlentities('Header - above </head>'), 'below_body_tag'=>htmlentities('Body - below <body>'), 'above_body_tag'=> htmlentities('Footer - above </body>'));  ?>	
						<div id="AddMoreAddCode">
							
							
							<?php 
							$i = 1;
							foreach($addCodes as $addCode){ 
							?>
							<div class="AddCodeRow_<?php echo $addCode->add_more_number;  ?>  add_code_box">
								
								<div class="col-sm-12 col-xl-12 add_code_number_box">
								<div class="mb-3 main-content-label">Add Code #<?php echo $i ?>  <span style="float:right"><a href="javascript:void(0);" class="deleteAddCode delete_row_btn" number="<?php echo $addCode->add_more_number; ?>"> Delete</a></span></div>
									
								</div>
								<div class="clearfix"></div>
								<div class="col-sm-12 col-xl-12 add_code_dropdown_box">
										<div class="form-light-holder  d-md-flex  dual_input">
											<div class="adsUrl form-group">
												<h1>Pages</h1>
												<select class="field" name="data[<?php echo $addCode->add_more_number; ?>][page_slug]" required>
												<option value="">-Select Page-</option>
													<option value="ALL"  <?php if($addCode->page_slug == "ALL"){ $showOldUrl = 1; echo 'selected=selected'; }?>>ALL</option>
													<?php foreach($PagesLists as $key => $value){ ?>
													<option value="<?php echo $key; ?>" <?php if($addCode->page_slug == $key){ $showOldUrl = 1; echo 'selected=selected'; }?>><?php echo $value; ?></option>
															
													<?php } ?>
												</select>
												
											
											<label class="ckbox mg-b-10  mg-t-10">
											<input type="checkbox" name="data[<?php echo $addCode->add_more_number; ?>][code_checked]" value="1" <?php if($addCode->code_checked == 1){ echo 'checked=checked'; } ?>><span>Override Code</span></label>
											</div>
											
											<div class="linkTarget form-group">
												<h1>Place Header Code</h1>
													<select class="field"  name="data[<?php echo $addCode->add_more_number; ?>][header_code_placed]">
												
												<?php foreach($code_placed as $key => $value){ ?>
												<option value="<?php echo $key; ?>" <?php if($addCode->header_code_placed == $key){ echo 'selected=selected'; }?>><?php echo $value; ?></option>
												<?php } ?>
											</select>
											</div>
											
											
										</div>
								</div>
								
								
								<?php if($showOldUrl == 0){ ?>
								<div  class="form-light-holder">
									<?php 
										
									?>
									Old Page Title:- <?php echo $addCode->page_title; ?><br/>
									Old Page Slug:- <?php echo $addCode->page_slug; ?>
								</div>
								<?php } ?>
								<div class="col-sm-12 col-xl-12 ">
									<div  class="form-light-holder">
									<h1>Header Code</h1>
										<textarea name="data[<?php echo $addCode->add_more_number; ?>][header_code]" id="header_code" rows="15" placeholder="&nbsp;&nbsp;Paste Header Code Here..."><?php echo $addCode->header_code;?></textarea>
									</div>
									<div  class="form-light-holder">
									<h1>Footer Code</h1>
										<textarea name="data[<?php echo $addCode->add_more_number; ?>][footer_code]" id="footer_code" rows="15" placeholder="&nbsp;&nbsp;Paste Footer Code Here..."><?php echo $addCode->footer_code;?></textarea>
									</div>
									<input type="hidden" name="data[<?php echo $addCode->add_more_number; ?>][add_more_number]" value="<?php echo $addCode->add_more_number; ?>" />
								</div>
							</div>
							<?php $i++; } ?>
							
							
						<div>		
							
							
						
					</div>
				</div>
			
				<div class=""><h3><a href="javascript:void(0);" class="btn btn-outline-light AddMoreButton">Add New Code</a></h3></div>
				<div class="form-white-holder" style="padding-bottom:20px;">
			<input type="submit" value="Save" class="btn-save" style="float:left;" />
		</div>
			</div>
		</div>
		
	</div>
	
	
	<div class="panel-body">
		<div class="panel-body-holder">
			<div class="form-holder">
				<div  class="form-new-holder">
					<h1>Thankyou Page Urls:</h1>
					<hr/>
					<?php 
						if(!empty($PagesLists)){
							foreach($PagesLists as $url => $page){
								if (strpos($url, 'thank-you') !== false) {
									
									$url = ltrim($url, '/');
									$site_url = $this->query_model->changeVideoPathHttp(base_url());
					?>
						<b><?php echo $page ?></b>:- &nbsp;&nbsp;&nbsp;&nbsp;  <?php echo $site_url.$url; ?><hr/>
					<?php 
								}
							}
						}
					?>
					
				</div>
			</div>
		</div>
	</div>
	
			<?php echo form_close();?>
<br style="clear:both"/><br />

</div>
</div>
</div>
</div>
</div>
</div>

<input type="hidden" class="totalAddMore" value="<?php if(!empty($exitRows)){ echo $exitRows[0]->add_more_number; }else{ echo 0; } ?>"  />
<script language="javascript" type="text/javascript">
 	
	$(document).ready(function(){
		$('.AddMoreButton').click(function(){
			var addAddMore = $('.totalAddMore').val();
			var i = parseInt(addAddMore) + Number(1);
			$('.totalAddMore').val(i);
			
				
				
				//$('#AddMoreAddCode').append('<div class="AddCodeRow_'+i+' "><div  class="form-light-holder"><b>Add Code # '+i+'&nbsp;</b><i class="fa fa-close" style="cursor:pointer;" onclick="$(this).parent().parent().remove();"> Delete</i><br><label>Pages</label><select name="data['+i+'][page_slug]"><option value="ALL" selected="selected">ALL</option><?php foreach($PagesLists as $key => $value){ echo ($value == "Home") ? "<option  value=".addslashes($value).">".addslashes($value)."</option>" : "<option value=".addslashes($key).">".addslashes($value)."</option>";  } ?></select><label>Placed Header Code</label><select name="data['+i+'][header_code_placed]"><?php foreach($code_placed as $key => $value){ ?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php } ?></select><input type="checkbox" name="data['+i+'][code_checked]" value="1">Override Code</div><div  class="form-light-holder"><label>Header Code</label><textarea name="data['+i+'][header_code]" id="header_code" rows="15" placeholder="Paste Header Code Here"></textarea></div><div  class="form-light-holder"><label>Footer Code</label><textarea name="data['+i+'][footer_code]" id="footer_code" rows="15" placeholder="Paste Footer Code Here"></textarea></div><input type="hidden" name="data['+i+'][add_more_number]" value="'+i+'" /></div>');
				
				$('#AddMoreAddCode').append('<div class="AddCodeRow_'+i+'  add_code_box"><div class="col-sm-12 col-xl-12 add_code_number_box"><div class="mb-3 main-content-label">Add Code #'+i+'  <span style="float:right"><a href="javascript:void(0);" onclick="$(this).parent().parent().parent().parent().remove();" class="delete_row_btn"> Delete</a></span></div></div><div class="clearfix"></div><div class="col-sm-12 col-xl-12 add_code_dropdown_box"><div class="form-light-holder  d-md-flex  dual_input"><div class="adsUrl form-group"><h1>Pages</h1><select class="field" name="data['+i+'][page_slug]" required=""><option value="">-Select Page-</option><option value="ALL" selected="selected">ALL</option><?php foreach($PagesLists as $key => $value){ echo ($value == "Home") ? "<option  value=".addslashes($value).">".addslashes($value)."</option>" : "<option value=".addslashes($key).">".addslashes($value)."</option>";  } ?></select><label class="ckbox mg-b-10  mg-t-10"><input type="checkbox" name="data['+i+'][code_checked]" value="1"><span>Override Code</span></label></div><div class="linkTarget form-group"><h1>Place Header Code</h1><select class="field" name="data['+i+'][header_code_placed]"><?php foreach($code_placed as $key => $value){ ?><option value="<?php echo $key; ?>"><?php echo $value; ?></option><?php } ?></select></div></div></div><div class="col-sm-12 col-xl-12 "><div class="form-light-holder"><h1>Header Code</h1><textarea name="data['+i+'][header_code]" id="header_code" rows="15" placeholder="&nbsp;&nbsp;Paste Header Code Here..."></textarea></div><div class="form-light-holder"><h1>Footer Code</h1><textarea name="data['+i+'][footer_code]" id="footer_code" rows="15" placeholder="&nbsp;&nbsp;Paste Footer Code Here..."></textarea></div><input type="hidden" name="data['+i+'][add_more_number]" value="'+i+'"></div></div>');
			
			
		});
	});	 
	
</script>

<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
