$(window).load(function(){

	var global = $('.GlobalClass').length;
	var glo = 1
	$.each($('.GlobalClass'), function(){
		if(glo == 1){
			$(this).show();
		}
		glo++;
	});
});

$(document).ready(function(){
	
	
	$(".admin_login_error.alert").delay(4000).slideUp(200, function() {
		$(this).alert('close');
	});
	
	$('.view_password').click(function(){
		
		$(this).find('i').toggleClass("fa-eye fa-eye-slash");
		
		var input_type = $("#admin_login_password").attr('input_type');
		
		if(input_type == "hide"){
			$('#admin_login_password').attr('type','text');
			$("#admin_login_password").attr('input_type','show');
		}else{
			$('#admin_login_password').attr('type','password');
			$("#admin_login_password").attr('input_type','hide');
		}
		
	})
	
	
	
		/** code for show active cms navigation menu ****/ 
		var is_url_exists = 0;
		var cms_redirect_url = $('#cms_redirect_url').val();
		//alert(cms_redirect_url);
		$.each($('.cms_menu_url'), function(){
			var slug = $(this).attr('slug');
			var redirect_url = cms_redirect_url;
			//alert(slug+'===>'+redirect_url);
			if(slug == redirect_url){
				is_url_exists = 1;
				
				$(this).parents('li').addClass('active');
				$(this).parents('li').addClass('show');
				
				if (typeof(Storage) !== "undefined") {
					
					sessionStorage.setItem("last_redirect_url", slug);
				
				}
				
			}
		})
		
		if(is_url_exists == 0){
			
			$.each($('.cms_menu_url'), function(){
			var slug = $(this).attr('slug');
			var redirect_url = sessionStorage.getItem("last_redirect_url");
			
			if(slug == redirect_url){
				is_url_exists = 1;
				
				$(this).parents('li').addClass('active');
				$(this).parents('li').addClass('show');
				
				if (typeof(Storage) !== "undefined") {
					
					sessionStorage.setItem("last_redirect_url", slug);
				
				}
				
			}
			
		})
		}
		
		
		
		$('body').on('click', '.closePopup', function(){
			
			var modal_id = $(this).attr('modal_id');
			
			$('#'+modal_id).modal('hide');
		})
		
		
		$("body").on('click','.ajax_record_publish',function(){
			
			//var base_url = $('#site_base_url').val();
			var pub_id = $(this).attr("id").substr(6);
			//var mod_type = $("#mod_type").val().toLowerCase();
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
			url: 'admin/dashboard/ajax_publish_records',						
			data: { pub_id : pub_id, publish_type: publish_type,table_name: table_name }					
			}).done(function(msg){ 
			if(msg == 1){
				
			}
			else{
			
			}
			});
			
		});
		
		
		
		$('body').on('click','.ajax_record_delete', function(){
			var item_id = $(this).attr('item_id');
			var table_name = $(this).attr('table_name');
			var item_title = $(this).attr('item_title');
			var section_type = $(this).attr('section_type');
			
			$('#popupDeleteRecord').find('.delete_modal_title').html(item_title);
			$('#popupDeleteRecord').find('#delete_record_id').val(item_id);
			$('#popupDeleteRecord').find('#delete_record_table_name').val(table_name);
			$('#popupDeleteRecord').find('#delete_record_section_type').val(section_type);
		})
	
	
 	$('body').on('click','.ajax_popup_delete_btn', function(){
		
		
		var formData = $('#popupDeleteRecord').find('form').serialize();
		var form_action = $('#popupDeleteRecord').find('form').attr('action');
		var item_id = $('#popupDeleteRecord').find('#delete_record_id').val();
		var section_type = $('#popupDeleteRecord').find('#delete_record_section_type').val();
		var table_name = $('#popupDeleteRecord').find('#delete_record_table_name').val();
		//alert(table_name); return false;
		
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
				
				if(section_type != "full_width" && section_type != "little_row" ){
					
					var total_record = $('.total_alternating_'+section_type).html();
					total_record = parseInt(total_record) - 1; 
					$('.total_alternating_'+section_type).html(total_record);
				}else{
					var total_record = $('.total_alternating_'+form_type).html();
					total_record = parseInt(total_record) - 1; 
					$('.total_alternating_'+form_type).html(total_record);
				}
				
				
				
				
				$('.'+form_type+'_'+item_id).remove();
				$('#popupDeleteRecord').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully deleted!');
				
				reArrageListSortPositions();
				
				setTimeout(function() {
						$('#responsePopup').modal('hide');
						
						if(table_name == "tbl_sparkpost_mail_flows" || table_name == "twilio_sms_flows"){
							location.reload();
						}
				}, 3000);
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	

if ( $(".ajax_record_sortable").length ) {	
	$(".ajax_record_sortable").sortable({
		update : function () {
			serial = $(this).sortable('serialize');
			table_name = $(this).attr('table_name');
			sort_list_li = $(this).find('li');
			
			$.ajax({
				url: "admin/dashboard/ajax_record_sort",
				type: "post",
				data: {serial,'table_name':table_name},
				success: function(){
					
					$.each(sort_list_li,function(key, value){
						$(this).find('.badge-no').html(parseInt(key)+1+'.');
					});
					
				}
			});
		}
	});
}
	
	
if ( $(".ajax_record_sortable_little").length ) {		
	$(".ajax_record_sortable_little").sortable({
		update : function () {
			serial = $(this).sortable('serialize');
			table_name = $(this).attr('table_name');
			sort_list_li = $(this).find('li');
			$.ajax({
				url: "admin/dashboard/ajax_record_sort",
				type: "post",
				data: {serial,'table_name':table_name},
				success: function(){
					$.each(sort_list_li,function(key, value){
						$(this).find('.badge-no').html(parseInt(key)+1+'.');
					});
					
				}
			});
		}
	});
}
	

if ( $(".ajax_record_sortable_with_extra_field").length ) {	
	$(".ajax_record_sortable_with_extra_field").sortable({
		update : function () {
			serial = $(this).sortable('serialize');
			table_name = $(this).attr('table_name');
			extra_field = $(this).attr('extra_field');
			extra_value = $(this).attr('extra_value');
			sort_list_li = $(this).find('li');
			
			$.ajax({
				url: "admin/dashboard/ajax_record_sort",
				type: "post",
				data: {serial,'table_name':table_name, extra_field : extra_field, extra_value : extra_value},
				success: function(){
					$.each(sort_list_li,function(key, value){
						$(this).find('.badge-no').html(parseInt(key)+1+'.');
					});
					
				}
			});
		}
	});
}	
	
	
	
	$('body').on('click','.ajax_record_duplicate', function(){
	
		var item_id = $(this).attr('item_id');
		var table_name = $(this).attr('table_name');
		var item_title = $(this).attr('item_title');
		var section_type = $(this).attr('section_type');
		//var category_id = $(this).attr('category_id');
		var form_action = $(this).attr('form_action');
		var redirect_path = $(this).attr('redirect_path');
		
		$('#popupDuplicateItem').find('#duplicatePopupForm').attr('action',form_action);
		$('#popupDuplicateItem').find('.modal-title').html('Duplicate : '+item_title);
		$('#popupDuplicateItem').find('#dupcat_program_title').val(item_title);
		$('#popupDuplicateItem').find('#dupcat_item_id').val(item_id);
		$('#popupDuplicateItem').find('#dupcat_item_table_name').val(table_name);
		//$('#popupDuplicateItem').find('#dupcat_item_category_id').val(category_id);
		$('#popupDuplicateItem').find('#dupcat_item_section_type').val(section_type);
		$('#popupDuplicateItem').find('#dupcat_item_redirect_path').val(redirect_path);
	})
	
	
 	$('body').on('click','.dupcat_popup_btn', function(){
		
		var formData = $('#popupDuplicateItem').find('form').serialize();
		var form_action = $('#popupDuplicateItem').find('form').attr('action');
		var item_id = $('#popupDuplicateItem').find('#dupcat_item_id').val();
		//var category_id = $('#popupDuplicateItem').find('#dupcat_item_category_id').val();
		var section_type = $('#popupDuplicateItem').find('#dupcat_item_section_type').val();
		var redirect_path = $('#popupDuplicateItem').find('#dupcat_item_redirect_path').val();
		
		
		
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
				
				if(form_type == "full_width_row"){
					var total_record = $('.total_alternating_'+form_type).html();
					
					total_record = parseInt(total_record) + 1; 
					$('.total_alternating_'+form_type).html(total_record);
				}	
				
				
				//$('.'+form_type+'_'+item_id).remove();
				$('#popupDuplicateItem').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully duplicate!');
				setTimeout(function() {
					
					$('#responsePopup').modal('hide');
					
					window.location.href= redirect_path;
					
					}, 3000);
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	
		
	
	
	
		$('body').on('click','.ajax_lead_record_delete', function(){
			var item_id = $(this).attr('item_id');
			var lead_type = $(this).attr('lead_type');
			var item_title = $(this).attr('item_title');
			var email = $(this).attr('email');
			
			$('#popupDeleteLeadRecord').find('.delete_modal_lead_title').html('Lead: '+item_title);
			$('#popupDeleteLeadRecord').find('#delete_lead_id').val(item_id);
			$('#popupDeleteLeadRecord').find('#delete_lead_lead_type').val(lead_type);
			$('#popupDeleteLeadRecord').find('#delete_lead_email').val(email);
		})
	
	
 	$('body').on('click','.ajax_popup_lead_delete_btn', function(){
		
		
		var formData = $('#popupDeleteLeadRecord').find('form').serialize();
		var form_action = $('#popupDeleteLeadRecord').find('form').attr('action');
		var item_id = $('#popupDeleteLeadRecord').find('#delete_lead_id').val();
		var lead_type = $('#popupDeleteLeadRecord').find('#delete_lead_lead_type').val();
		
		
		$.ajax({ 					
			type: 'POST',						
			url: form_action,						
			data: { formData : formData}					
			}).done(function(msg){ 
			if(msg == 1){
				
				
				
				$('.order_lead_'+item_id).remove();
				$('#popupDeleteLeadRecord').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully deleted!');
				setTimeout(function() {$('#responsePopup').modal('hide');}, 3000);
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	
	
	$('body').on('change', '.custom-file-input', function(){
		
		//var filename = $(this).val().split('\\').pop();
		var filename = $(this)[0].files[0].name;
		filename = truncate_filename(filename, 30);
		$(this).parents('.custom-file').find('.custom-file-label').html(filename);
		
	})
	
	function truncate_filename(n, len) {
		
		  var ext = n.substring(n.lastIndexOf(".") + 1, n.length).toLowerCase();
		  var filename = n.replace('.'+ext,'');
		  if(filename.length <= len) {
			  return n;
		  }
		  filename = filename.substr(0, len) + (n.length > len ? '[...]' : '');
		  return filename + '.' + ext;
	  };
	  
	  
	function reArrageListSortPositions(){
		//alert($(".alternating_full_width_row").length);
		if ( $(".ajax_record_sortable").length ) {
			
			$.each($('.ajax_record_sortable'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
		if ( $(".ajax_record_sortable_little").length ) {
			
			$.each($('.ajax_record_sortable_little'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
		if ( $(".ajax_record_sortable_with_extra_field").length ) {
			
			$.each($('.ajax_record_sortable_with_extra_field'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
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
		
		
		if ( $(".alternating_active_campaign").length ) {
			$.each($('.alternating_active_campaign'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
		if ( $(".alternating_rainmaker").length ) {
			$.each($('.alternating_rainmaker'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
		
		if ( $(".alternating_webhook_outgoing_apis").length ) {
			$.each($('.alternating_webhook_outgoing_apis'),function(k, v){
				var sort_list_li = $(this).find('li');
				$.each(sort_list_li,function(key, value){
					$(this).find('.badge-no').html(parseInt(key)+1+'.');
				});
			});
		}
		
		
	}
	
	
	
	
	
	
		$('body').on('click','.ajax_twilio_record_delete', function(){
			var item_id = $(this).attr('user_id');
			var item_title = $(this).attr('item_title');
			
			$('#popupDeleteTwilioRecord').find('.delete_modal_lead_title').html(item_title);
			$('#popupDeleteTwilioRecord').find('#delete_lead_id').val(item_id);
		})
	
	
 	$('body').on('click','.ajax_popup_twilio_conversaction_delete', function(){
		
		
		var formData = $('#popupDeleteTwilioRecord').find('form').serialize();
		var form_action = $('#popupDeleteTwilioRecord').find('form').attr('action');
		var item_id = $('#popupDeleteTwilioRecord').find('#delete_lead_id').val();
		
		
		$.ajax({ 					
			type: 'POST',						
			url: form_action,						
			data: { formData : formData}					
			}).done(function(msg){ 
			if(msg == 1){
				
				//$('.order_lead_'+item_id).remove();
				$('#popupDeleteTwilioRecord').modal('hide');
				
				$('#responsePopup').modal('show');
				$('#responsePopup').find('.action_response_msg').html('Successfully deleted!');
				setTimeout(function() {
						$('#responsePopup').modal('hide');
						
						var base_url = $('#site_base_url').val();
						window.location.href = base_url+'admin/twilio_sms_messenger';
						//location.reload();
				}, 3000);
				
				
				
			}
			else{
				alert("Oops! Something went wrong!");
				return false;
						
			}
		});
			
	})
	
	
	
	
})