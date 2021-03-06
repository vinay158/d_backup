<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->

<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>


<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>

<!-- accordion -->

<link rel="stylesheet" href="<?php echo base_url(); ?>lightbox/accordion/css/smk-accordion.css" />
<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<div class="az-content-body-left custom_full_page api_manager_page advanced_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title"><?php echo $title; ?></h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
	  
	  

<div class="gen-holder">

	<div class="gen-panel-holder"  style="width: 100% !important;">

	<div class="gen-panel">

		<!--<div class="panel-title">

			<div class="panel-title-name"><?php echo $title; ?></div>

		</div> -->

		<div class="panel-body">
			<div class="panel-body-holder">
				
		<div class="accordion_example4">
		  <!-- acc_active class for active -->
		  <div class="mb-3 main-content-label">Email Auto-Responders APIs</div>
			<!-- Section 1 -->
			<div class="accordion_in  <?php echo (!empty($apis_mailchimp['detail']) && $apis_mailchimp['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Mailchimp</div>
				<div class="acc_content"> <?php //echo '<prE>apis_mailchimp'; print_r($apis_mailchimp); die; ?>
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_mailchimp", $apis_mailchimp, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			
			<!-- Section 6 -->
			<div class="accordion_in  <?php echo (!empty($apis_active_campaign['detail']) && $apis_active_campaign['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Active Campaign</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_active_campaign", $apis_active_campaign, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			<!-- Section 6 -->
			<div class="accordion_in  <?php echo (!empty($apis_sparkpost_mail['detail']) && $apis_sparkpost_mail['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Sparkpost Email API</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_sparkpost_mail", $apis_sparkpost_mail, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			

			<!-- Section 2 -->
			 <div class="mb-3 main-content-label">CRM APIs</div>
			<div class="accordion_in   <?php echo (!empty($apis_rainmaker['detail']) && $apis_rainmaker['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Rainmaker</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_rainmaker", $apis_rainmaker, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			<!-- Section 5 -->
			<div class="accordion_in  <?php echo (!empty($apis_kicksite['detail']) && $apis_kicksite['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Kicksite</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_kicksite", $apis_kicksite, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			<!-- Section 5 -->
			<div class="accordion_in  <?php echo (!empty($apis_velocify['detail']) && $apis_velocify['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Velocify</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_velocify", $apis_velocify, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			<!-- Section 2 -->
			<div class="accordion_in   <?php echo (!empty($apis_perfectmind['detail']) && $apis_perfectmind['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Perfectmind</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_perfectmind", $apis_perfectmind, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			<!-- Section 5 -->
			<div class="accordion_in  <?php echo (!empty($apis_mystudio['detail']) && $apis_mystudio['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">MyStudio</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_mystudio", $apis_mystudio, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			<!-- Section 5 -->
			<div class="accordion_in  <?php echo (!empty($apis_mat['detail']) && $apis_mat['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">MAT</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_mat", $apis_mat, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>

			<!-- Section 3 -->
			<div class="mb-3 main-content-label">Payment Gateway APIs</div>
			<div class="accordion_in   <?php echo (!empty($apis_authorize_net_payment['detail']) && $apis_authorize_net_payment['detail']->authorize_net_payment == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Authorize.net Payment</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_authorize_net_payment", $apis_authorize_net_payment, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>

			<!-- Section 4 -->
			<div class="accordion_in <?php echo (!empty($apis_braintree_payment['detail']) && $apis_braintree_payment['detail']->braintree_payment == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Braintree Payment</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_braintree_payment", $apis_braintree_payment, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			<!-- Section 3 -->
			<div class="accordion_in   <?php echo (!empty($apis_stripe_payment_gateway['detail']) && $apis_stripe_payment_gateway['detail']->stripe_payment == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Stripe Payment</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_stripe_payment_gateway", $apis_stripe_payment_gateway, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			<div class="accordion_in   <?php echo (!empty($apis_stripe_ideal_payment_gateway['detail']) && $apis_stripe_ideal_payment_gateway['detail']->stripe_ideal_payment == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Stripe With iDEAL Payment</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_stripe_ideal_payment_gateway", $apis_stripe_ideal_payment_gateway, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			<div class="accordion_in   <?php echo (!empty($apis_paypal_payment['detail']) && $apis_paypal_payment['detail']->paypal_payment == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Paypal Payment</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_paypal_payment", $apis_paypal_payment, TRUE); ?>
				</div>
			</div>
			
			
			
			
			<div class="mb-3 main-content-label">Miscellaneous APIs</div>
			
			<div class="accordion_in acc_active">
				<div class="acc_head">Email Marketing</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_email_marketing", $apis_email_marketing, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			
			<!-- Section 7 -->
			<?php 
					$chargify_permission = $this->query_model->getOtherPagePermissions($this->session->userdata("userid"), 'admin/chargify_api');
					if($chargify_permission == 1){
				 ?>
			<div class="accordion_in  <?php echo (!empty($apis_chargify['detail']) && $apis_chargify['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Chargify</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_chargify", $apis_chargify, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
					<?php } ?>
					
					
			<!-- Section 8 -->
			
			<div class="accordion_in  <?php echo (!empty($apis_fb_messenger['detail']) && $apis_fb_messenger['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Facebook Messenger</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_fb_messenger", $apis_fb_messenger, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
					
			<!-- Section 8 -->
			
			<div class="accordion_in acc_active">
				<div class="acc_head">Tinyjpg</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_tinyjpg", $apis_chargify, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			
			<div class="accordion_in acc_active">
				<div class="acc_head">Email Id Manager</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_email_ids_manager", $apis_email_ids_manager, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			<!-- Section 7 -->
			
			<div class="accordion_in  acc_active <?php echo (!empty($apis_twilio['detail']) && $apis_twilio['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Twilio</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_twilio", $apis_twilio, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
			
			<div class="accordion_in  acc_active <?php echo (!empty($apis_twilio['detail']) && $apis_twilio['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Twilio Chat Api</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_twilio_chat", $apis_twilio_chat, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>
					
			<div class="accordion_in  <?php echo (!empty($apis_spamcheck['detail']) && $apis_spamcheck['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Spam Check Api</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_spam_check", $apis_spamcheck, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>	
			
			<div class="accordion_in  <?php echo (!empty($apis_google_captcha['detail']) && $apis_google_captcha['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Google reCaptcha Api</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_google_captcha", $apis_google_captcha, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>	

			<div class="accordion_in  <?php echo (!empty($apis_analytics['detail']) && $apis_analytics['detail']->analytics_report_type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Google Analytics Report Api</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_analytics", $apis_analytics, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>	
			
			<div class="accordion_in  <?php echo (!empty($apis_rank_trackr['detail']) && $apis_rank_trackr['detail']->type == 1) ? 'acc_active' : ''; ?>">
				<div class="acc_head">Rank Trackr Api</div>
				<div class="acc_content">
					<!-- Your text here. For this demo, the content is generated automatically. -->
					<?php echo $this->load->view("admin/apis_rank_trackr", $apis_rank_trackr, TRUE); ?>
				</div><div style="clear:both"></div>
			</div>	
			
			
	
			</div>
		</div>

	</div>

	</div>

<br style="clear:both" /><br />



<script type="text/javascript" src="<?php echo base_url(); ?>lightbox/accordion/js/smk-accordion.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($){

		//$('#responsePopup').modal('show');
		
		$(".accordion_example4").smk_Accordion({
			closeAble: true, //boolean
			closeOther: false, //boolean
		});
		
		
		/********************** new code for popup *********************/
$('body').on('click','.delete_item', function(){
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var item_title = $(this).attr('item_title');
		var section_type = $(this).attr('section_type');
		
		$('#popupDeleteItem').find('.modal-title').html(item_title);
		$('#popupDeleteItem').find('#delete_item_id').val(item_id);
		$('#popupDeleteItem').find('#delete_item_table_name').val(table_name);
		$('#popupDeleteItem').find('#delete_item_section_type').val(section_type);
	})
	
	
 	$('body').on('click','.popup_delete_btn', function(){
		
		
		var formData = $('#popupDeleteItem').find('form').serialize();
		var form_action = $('#popupDeleteItem').find('form').attr('action');
		var item_id = $('#popupDeleteItem').find('#delete_item_id').val();
		var section_type = $('#popupDeleteItem').find('#delete_item_section_type').val();
		//alert('.'+section_type+'_'+item_id); return false;
		
		
		$.ajax({ 					
			type: 'POST',						
			url: form_action,						
			data: { formData : formData}					
			}).done(function(msg){ 
			if(msg == 1){
				
				var form_type = 'full_width_row';
				if(section_type == "little_row"){
					var form_type = "little_row";
				}
				
				var total_record = $('.total_alternating_'+form_type).html();
				//alert(section_type+'==>'+form_type+'==>'+'.total_alternating_'+form_type+'==>'+total_record); return false;
				total_record = parseInt(total_record) - 1; 
				$('.total_alternating_'+form_type).html(total_record);
				
				
				
				$('.'+form_type+'_'+item_id).remove();
				
				reArrageCustomListSortPositions();
				
				$('#popupDeleteItem').find('.close').trigger('click');
				
				
				
				/*$('#popupDeleteItem').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully deleted!');
				setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);*/
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	
	function reArrageCustomListSortPositions(){
		if ( $(".alternating_full_width_row").length ) {
			$.each($('.alternating_full_width_row'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
		if ( $(".alternating_little_row").length ) {
			$.each($('.alternating_little_row'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
	}
	
	$('body').on('click','.full_alternate_popup', function(){
		
		var action_type = $(this).attr('action_type');
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var form_type = $(this).attr('form_type');
		//fullAlternatePopup
		
		if(form_type == "full_width_row"){
			$('#fullAlternatePopup').find('.modal-title').html(action_type + ' Webhook Api (Incoming Leads)');
		}else{
			$('#fullAlternatePopup').find('.modal-title').html(action_type + ' Webhook Apis (Outgoing Leads)');
		}
		
		
		
		$.ajax({

				url : 'admin/apis_manager/ajax_full_alternate_popup',
				type : 'POST',
				data :{action_type : action_type, item_id : item_id,table_name:table_name,form_type:form_type},
				success:function(data){
					
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
	
	$('body').on('change','.required_field', function(){
		var check = $(this).val();
		if(check == '') {
			$(this).css('border','1px solid red');
		}else{
			$(this).css('border','1px solid rgb(223,223,223)');
		}
	});
	
	$('body').on('click','.save_full_row_add_btn', function(){
		
		var alt_row_form_type = $("#alt_row_form_type").val();
		
		var required_mapping_fields = 0;
		if(alt_row_form_type == "full_width_row"){
			required_mapping_fields = $('.required_mapping_fields_checkbox').attr('checkbox_value');
		}
		
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
				url : 'admin/apis_manager/ajax_save_full_alternate_row',
				dataType : 'json',
				data: { formData : formData, required_mapping_fields: required_mapping_fields}					
				}).done(function(data){ 
				
				if(data.res == 1){
					
					if(data.form_action == "add"){
						
						var form_type = data.form_type;
						var total_numbers = $('.alternating_'+form_type+' li').length;
						var new_number = 1;
						if(new_number > 0){
							new_number = parseInt(total_numbers) + 1;
						}
						
						var total_record = $('.total_alternating_'+form_type).html();
						total_record = parseInt(total_record) + 1; 
						$('.total_alternating_'+form_type).html(total_record);
						
						$('.alternating_'+form_type).append('<li id="menu_'+data.id+'" class="'+form_type+'_'+data.id+'   az-contact-info-header ui-sortable-handle "><div class="manager-item media"><div style="float:left;"><div class="badge-no">'+new_number+'.</div><h4 class="'+form_type+'_heading_'+data.id+'"><a href="javascript:void(0)">'+data.title+'</a></h4></div><div class="manager-item-opts"><nav class="nav"><a href="javascript:void(0)" class="badge badge-primary  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="'+data.id+'" table_name="'+data.table_name+'" form_type="'+form_type+'">Edit</a><a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="'+data.id+'" table_name="'+data.table_name+'" item_title="'+data.title+'" section_type="'+form_type+'">Delete</a><a href="javascript:void(0)" id="unpub_'+data.id+'" class="sections_unpublish" table_name="'+data.table_name+'" is_new="1"><div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn on" publish_type="0"><span></span><input type="hidden" name="publish_type" value="0" class="publish_type"></div></a></nav></div></div></li>');
						
						
						$('#fullAlternatePopup').find('.close').trigger('click');
						//$('#fullAlternatePopup').modal('hide');
						
						//$('#responsePopup').find('.action_response_msg').html('Successfully added!');
					}else{
						var item_id = data.id;
						var form_type = data.form_type;
						//alert('.'+form_type+'_heading_'+item_id); return false;
						$('.'+form_type+'_heading_'+item_id).find('a').html(data.title );
						
						
						$('#fullAlternatePopup').find('.close').trigger('click');
						//$('#fullAlternatePopup').modal('hide');
						
						//$('#responsePopup').find('.action_response_msg').html('Successfully updated!');
					
					}
					
					//$('#responsePopup').modal('show');
					//setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
					
				}
			});
			
		}else{
			$('.form_error_msg').show();
		}
		
			
	})
	
	
	$("body").on('click','.sections_unpublish',function(){
		//alert('adsfdasf');
		var pub_id = $(this).attr("id").substr(6);
		var mod_type = $("#mod_type").val().toLowerCase();
		var table_name = $(this).attr('table_name');
		var is_new = $(this).attr('is_new');
		var publish_type = $(this).children(".toogle_btn").attr('publish_type');
		//alert(pub_id+'=>'+mod_type+'=>'+table_name+'=>'+is_new+'=>'+publish_type); return false;
		var updated_type = 1;
		if(publish_type == 1){
			updated_type = 0;
		}
		
		
		if(is_new == 1){
			if(updated_type == 1){
				$(this).find('.az-toggle').removeClass('on');
			}else{
				$(this).find('.az-toggle').addClass('on');
			}
		}
		
		$(this).children(".toogle_btn").attr('publish_type',updated_type); 
		
		$.ajax({ 					
		type: 'POST',						
		url: 'admin/'+mod_type+'/ajaxPublishWebhookApi',						
		data: { pub_id : pub_id, publish_type: publish_type,table_name: table_name }					
		}).done(function(msg){ 
		if(msg == 1){
			
		}
		else{
		//setTimeout('$("#alert-holder").html("<div><b class=red>Unable to Unpublish.</b></div>")',1000);
		//alert(msg);
		}
		});
		
	});

	});
</script>

<!------------ recent items ----------------->

<!----------- Webhook Apis ------------->

<div class="program_full_detail page-section new_lisiting_block " id="webhook-api-incoming">
				<div class="mb-3 main-content-label" >Webhook Api (Incoming Leads)</div>
				<div class="row row-xs align-items-center  mg-t-25 mg-b-5">
					<div class="col-md-12">
						<p><?php
								$this->db->select(array('https'));
								$query = $this->db->get_where('tblsite', array( 'id' => 1));
								$site_settings = $query->row_array();
								$check_http = $site_settings['https'];
								
								if($check_http == 1){
									$baseUrl = str_replace('http','https',base_url());
								}else{
									$baseUrl = str_replace('https','http',base_url());
								}
							?>
							<?php echo $baseUrl.'webhook/saveWhook'; ?>
								</p>
					</div>
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20  alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5">Webhook API (Incoming Leads)</h4>
								  <p>You have <span class="total_alternating_full_width_row"><?php echo !empty($webhook_apis_incoming_leads) ? count($webhook_apis_incoming_leads) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="javascript:void(0)" class="button_class btn btn-indigo  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tbl_webhook_apis_incoming" form_type="full_width_row">Add New</a>
								</div>
							  </div>
							  
							<ul class="cat_sort_1 ui-sortable alternating_full_width_row" style="">

<?php
$sr_news=0;  
if(!empty($webhook_apis_incoming_leads)):?>
<?php foreach($webhook_apis_incoming_leads as $webhook_api_incoming):
 $sr_news++;
?>


									<li   id="menu_<?=$webhook_api_incoming->id?>" class="full_width_row_<?=$webhook_api_incoming->id?> az-contact-info-header">
										<div class="manager-item media">
											<div style="float:left;">
												<div class="badge-no"><?=$sr_news?>.</div>
												
                                                    
												<h4 class="full_width_row_heading_<?=$webhook_api_incoming->id?>"><a href="javascript:void(0)" ><?=$webhook_api_incoming->api_name;?></a></h4>
											</div>
											<div class="manager-item-opts">
											
											
										<nav class="nav">
											 
											  <a href="javascript:void(0)" class="badge badge-primary  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$webhook_api_incoming->id;?>"  table_name="tbl_webhook_apis_incoming" form_type="full_width_row">Edit</a>
											  
													<a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$webhook_api_incoming->id;?>"   table_name="tbl_webhook_apis_incoming" item_title="<?=$webhook_api_incoming->api_name;?>" section_type="full_width">Delete</a>
													<!--<div class="az-toggle az-toggle-success alternate_full_width_toogle on"><span></span></div> -->
													
													<a href="javascript:void(0)" id="unpub_<?=$webhook_api_incoming->id; ?>" class="sections_unpublish"  table_name="tbl_webhook_apis_incoming"  is_new="0">
												<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($webhook_api_incoming->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($webhook_api_incoming->published == 1) ? 0 : 1;?>"><span></span>
												<input type="hidden" name="publish_type" value="<?php echo ($webhook_api_incoming->published == 1) ? 0 : 1;?>" class="publish_type" />
												</div></a>
										</nav>
			
			
			
											</div>
										</div>
									</li>
<?php endforeach;?>								

<?php else: ?>

<?php endif;?>
								</ul>

			
			
						
						
				</div>
			</div>
		</div>
</div>



<div class="program_full_detail page-section new_lisiting_block" id="webhook-api">
				<div class="mb-3 main-content-label" >Webhook Apis Manager  (Outgoing Leads)</div>
				<div class="row row-xs align-items-center  mg-t-25 mg-b-5">
					<!--<div class="col-md-12">
						<p>You may rearrange the order of the items below by dragging them above or below other item rows. Changes will automatically be saved.</p>
					</div> -->
					
				</div>
				
				<div class="row row-xs align-items-center mg-b-20 alternating-row-section ">
					
					<div class="col-md-12 mg-t-5 mg-md-t-0 ">
						<div class="az-content-body ">
			
							<div class="az-mail-header">
								<div>
								  <h4 class="az-content-title mg-b-5">Webhook Api (Outgoing Leads)</h4>
								  <p>You have <span class="total_alternating_little_row"><?php echo !empty($webhook_apis) ? count($webhook_apis) : 0; ?></span> Entries</p>
								</div>
								<div>
								 <a href="javascript:void(0)" class="button_class btn btn-indigo  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="add" item_id="" table_name="tbl_webhook_apis" form_type="little_row">Add New</a>
								</div>
							  </div>
							  
						<ul class="cat_sort_2 ui-sortable alternating_little_row" style="">

					<?php
					$sr_news=0;  
					if(!empty($webhook_apis)):?>
					<?php foreach($webhook_apis as $webhook_api):
					 $sr_news++;
					?>
					<li   id="menu_<?=$webhook_api->id?>" class="little_row_<?=$webhook_api->id;?> az-contact-info-header">
						<div class="manager-item media">
							<div style="float:left" >
								
								<div class="badge-no"><?=$sr_news?>.</div>	
								<h4  class="little_row_heading_<?=$webhook_api->id?>"><a href="javascript:void(0)" ><?=$webhook_api->api_name;?></a></h4>
							</div>
							<div class="manager-item-opts">
							
							
							
							<nav class="nav">
							  
							  <a href="javascript:void(0)" class="badge badge-primary  full_alternate_popup" data-toggle="modal" data-target="#fullAlternatePopup" action_type="edit" item_id="<?=$webhook_api->id;?>"  table_name="tbl_webhook_apis" form_type="little_row">Edit</a>
							  
									<a class="badge badge-primary delete_item" data-toggle="modal" data-target="#popupDeleteItem" item_id="<?=$webhook_api->id;?>"   table_name="tbl_webhook_apis" item_title="<?=$webhook_api->api_name;?>"  section_type="little_row">Delete</a>
									<!--<div class="az-toggle az-toggle-success alternate_full_width_toogle on"><span></span></div> -->
									
									<a href="javascript:void(0)" id="unpub_<?=$webhook_api->id; ?>" class="sections_unpublish"  table_name="tbl_webhook_apis"  is_new="0">
								<div class="az-toggle az-toggle-success alternate_little_toogle toogle_btn <?php echo ($webhook_api->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($webhook_api->published == 1) ? 0 : 1;?>"><span></span>
								<input type="hidden" name="publish_type" value="<?php echo ($webhook_api->published == 1) ? 0 : 1;?>" class="publish_type" />
								</div></a>
						</nav>
							
							</div>
						</div>
					</li>
<?php endforeach;?>								

<?php else: ?>

<?php endif;?>
				</ul>
	  


				</div>
			</div>
		</div>
</div>

</div>
</div>
</div>
</div>
</div>
<input type="hidden" name="mod_type" value="apis_manager" id="mod_type" />
<!----------- End ---------->


<?php $this->load->view("admin/include/footer");?>




 <div id="popupDeleteItem" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="admin/apis_manager/ajax_delete_webhook_apis" method="post" id="deleteForm">
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
				<a href="javascript:void(0)" class="btn btn-indigo popup_cancel_btn" data-dismiss="modal">No, cancel please!</a>
			  </div>
			   <div class="col-md-6 text-right">
				<a href="javascript:void(0)" class="btn btn-indigo popup_delete_btn">Yes, Delete It!</a>
			   </div>
          </div>
		  
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->
	
	
	<div id="fullAlternatePopup" class="modal">
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
	
	
	

