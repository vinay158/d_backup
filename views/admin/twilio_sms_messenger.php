<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->
<!--<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>--->
<!---------------wysiwyg editor script ------------>

 <div class="az-content-body-left  advanced_page custom_full_page twilio_sms_chat_page" >

       <div class="row row-sm">

          <div class="col-sm-12 col-xl-12"  >
			<div class="card pd-sm-20 chat-page">
				<div class="container">
	  
	  
        
    <div class="az-content az-content-app pd-b-0">
      <div class="container">
	  
	  
        <div class="az-content-left az-content-left-chat">
		
		<div class="form-light-holder search_bar_box">
			<div class="search_input_box">
			<input type="text" value="" name="title" id="search_user" class="field full_width_input form-control" placeholder="Search here..." autocomplete>
			</div>
			<div class="back_btn_box">
				<span><a href="javascript:void(0)" class="clear_search_user">Back</a></span>
			</div>
		</div>

          <div id="azChatList" class="az-chat-list">
		  
		  <?php 
			if(!empty(!empty($lead_users))){
				$i = 1;
				foreach($lead_users as $user){
					
					 $this->db->select(array('image'));
					 $profile_img = $this->query_model->getBySpecific('tbl_lead_profile_img','email',$user->email);
					 
					 $user_image = !empty($profile_img) ? base_url().'upload/kanban_user_profiles/thumb/'.$profile_img[0]->image : base_url().'assets_admin/img/lead_blank_profile_img.png';
		?>
            <div class="media user_number_<?php echo $i; ?> twilio_user_id_<?php echo $user->id ?> new sms_users_list twilio_u_list" user_id="<?php echo $user->id ?>" user_name="<?php echo $user->name ?>" msg_last_seen="<?php echo $this->query_model->getTimeAgo($user->last_updated_date); ?>" user_number="<?php echo $i; ?>" user_profile_image="<?php echo $user_image; ?>">
              <div class="az-img-user">
                <img src="<?php echo $user_image; ?>" alt="">
				<?php //if(!empty($user->total_msgs)){ ?>
                <span class="total_msgs_<?php echo $user->id ?> user_new_msgs" style="display:<?php echo ($user->total_msgs > 0) ? 'flex' : 'none'; ?>"><?php echo $user->total_msgs ?></span>
				<?php //} ?>
              </div>
              <div class="media-body">
                <div class="media-contact-name">
                  <span><?php echo $user->name ?></span>
                  <span class="user_msg_time_<?php echo $user->id ?>"><?php echo $this->query_model->getTimeAgo($user->last_updated_date); ?></span>
                </div>
                <p><i class="icon ion-ios-call"></i> <?php echo $user->phone ?></p>
              </div><!-- media-body -->
            </div><!-- media -->
			<?php $i++; } } ?>
       </div><!-- az-chat-list -->

        </div><!-- az-content-left -->
        <div class="az-content-body az-content-body-chat">
		 
				<!--<div class="single_user_msgs"></div> -->
			<div class="az-chat-header">
            <div class="az-img-user"><img src="<?php echo base_url().'assets_admin/img/lead_blank_profile_img.png'; ?>" class="twilio_user_image" alt=""></div>
            <div class="az-chat-msg-name">
              <h6 class="twilio_user_name"></h6>
              <small class="twilio_user_last_seen"></small>
            </div>
            <nav class="nav">
              <a href="" class="nav-link"><i class="icon ion-md-more"></i></a>
            <!--  <a href="" class="nav-link" data-toggle="tooltip" title="Call"><i class="icon ion-ios-call"></i></a>
              <a href="" class="nav-link" data-toggle="tooltip" title="Archive"><i class="icon ion-ios-filing"></i></a>-->
              <a href="" class="nav-link ajax_twilio_record_delete"  data-toggle="modal" data-target="#popupDeleteTwilioRecord" user_id="" item_title="" data-toggle="tooltip" title="Trash"><i class="icon ion-md-trash"></i></a>
              <a href="javascript:void(0)" class="nav-link view_user_info" data-toggle="tooltip" title="View Info" user_id="0"><i class="icon ion-md-information-circle"></i></a>
            </nav>
          </div> 
			 <div id="azChatBody" class="az-chat-body">
				
				<div class="content-inner "> 	
					<div class="upload_img_pre_loader" style="display:none"><img src="<?=base_url();?>assets_admin/img/pre_loader.gif"></div>
					<div class="single_user_msgs"></div>
					
					<input type="hidden" value="1" class="is_cron_request">
				 </div>
			 </div>
			 
			
         
		
		 <div class="az-chat-footer">
           <!-- <nav class="nav">
              <a href="" class="nav-link" data-toggle="tooltip" title="Add Photo"><i class="fas fa-camera"></i></a>
              <a href="" class="nav-link" data-toggle="tooltip" title="Attach a File"><i class="fas fa-paperclip"></i></a>
              <a href="" class="nav-link" data-toggle="tooltip" title="Add Emoticons"><i class="far fa-smile"></i></a>
              <a href="" class="nav-link"><i class="fas fa-ellipsis-v"></i></a>
            </nav> -->
            <input type="text" class="form-control text_message" placeholder="Type your message here...">
            <a href="javascript:void(0)" class="az-msg-send send_user_msg" user_id="0"><i class="fas fa-arrow-circle-right"></i></a>
          </div><!-- az-chat-footer -->
        </div><!-- az-content-body -->
      </div>
    </div><!-- az-content -->
</div>
				
			</div>
			
      	
			
     </div><!-- az-content-body -->
    
    </div><!-- az-content -->
</div>


<!------------ recent items ----------------->
<script>
$(window).load(function(){
	
	
	
	<?php 
		if(isset($_GET['kanban_user_phone_number']) && !empty($_GET['kanban_user_phone_number'])){ 
			
			$kanban_user_phone_number = $_GET['kanban_user_phone_number'];
			
			$this->db->select(array('id','phone'));
			$twilio_user_id = $this->query_model->getBySpecific('twilio_sms_users','phone',$kanban_user_phone_number);
			if(!empty($twilio_user_id)){
	?>
		var twilio_user_id = "<?php echo $twilio_user_id[0]->id; ?>";
		
		$('.twilio_user_id_'+twilio_user_id).trigger( "click" );
		
		var phone_number = "<?php echo $kanban_user_phone_number; ?>";
		phone_number = phone_number.toLowerCase();
		$('#search_user').val(phone_number);
		$(".sms_users_list").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(phone_number) > -1)
		});
	
		$('.twilio_user_id_'+twilio_user_id).addClass( "selected" );
		
	<?php } }elseif($this->uri->segment(4) != ""){ 
			
			$kanban_user_id = base64_decode(strtr($this->uri->segment(4), '-_', '+/'));;
			
			$this->db->select(array('id','phone'));
			$twilio_user_id = $this->query_model->getBySpecific('twilio_sms_users','id',$kanban_user_id);
			if(!empty($twilio_user_id)){
	?>
		var twilio_user_id = "<?php echo $twilio_user_id[0]->id; ?>";
		
		$('.twilio_user_id_'+twilio_user_id).trigger( "click" );
		
		var phone_number = "<?php echo $twilio_user_id[0]->phone; ?>";
		phone_number = phone_number.toLowerCase();
		$('#search_user').val(phone_number);
		$(".sms_users_list").filter(function() {
		  $(this).toggle($(this).text().toLowerCase().indexOf(phone_number) > -1)
		});
	
		$('.twilio_user_id_'+twilio_user_id).addClass( "selected" );
		
	<?php } }else{?>
		if($('.user_number_1').length > 0){
			$('.user_number_1').trigger( "click" );
			$('.user_number_1').addClass('selected');
		}
	<?php } ?>
})

$(document).ready(function(){ 

		$('.clear_search_user').click(function(){
			$('#search_user').val('');
			var value = $('#search_user').val().toLowerCase();
			$(".sms_users_list").filter(function() {
			  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		})
		  
		   $("#search_user").on("keyup", function() {
				var value = $(this).val().toLowerCase();
				$(".sms_users_list").filter(function() {
				  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
				});
		    });
			
			
			/******** for view user info ***********/
			$(".view_user_info").click(function(){
				
				var user_id = $(this).attr('user_id');
				
				$.ajax({
					url: "admin/twilio_sms_messenger/get_twilio_user_info",
					type: "post",
					dataType: "json",
					data: {user_id:user_id,'action':'get_user_info'},
					success:function(data){
						
						$('#popupTwilioUserInfo').modal('show');
				
						$('#popupTwilioUserInfo').find('.modal-title').html('User Info: '+data.twilio_user_detail.name);
						$('#popupTwilioUserInfo').find('.popup_user_name').html(data.twilio_user_detail.name);
						$('#popupTwilioUserInfo').find('.popup_user_phone').html(data.twilio_user_detail.phone);
						$('#popupTwilioUserInfo').find('.popup_user_last_seen').html(data.last_updated_date);
						
					}
				});
				
				
			})
			
			/********* for view single user msg ********/
			$('.sms_users_list').on('click', function(){
				
				
				
				var user_id = $(this).attr('user_id');
				var user_name = $(this).attr('user_name');
				var msg_last_seen = $(this).attr('msg_last_seen');
				var user_profile_image = $(this).attr('user_profile_image');
				
				$('.twilio_user_name').html(user_name);
				$('.twilio_user_image').attr("src",user_profile_image);
				$('.twilio_user_last_seen').html('Last seen: '+msg_last_seen);
				$('.view_user_info').attr('user_id',user_id);
				$('.ajax_twilio_record_delete').attr('user_id',user_id);
				$('.ajax_twilio_record_delete').attr('item_title',user_name);
				
				$('.sms_users_list').removeClass('selected');
				$(this).addClass('selected');
				
				var is_cron_request = $('.is_cron_request').val();
				
				if(is_cron_request == 1){
					$('.single_user_msgs').hide();
					$('.upload_img_pre_loader').show();
				}
				
				
				const ps = new PerfectScrollbar('#azChatBody', {
					suppressScrollX: true
				  });
				 // alert($('#azChatBody').prop('scrollHeight'));
				 // 
				$.ajax({
					url: "admin/twilio_sms_messenger/get_twilio_user_msgs",
					type: "post",
					dataType: "html",
					data: {user_id:user_id,'action':'get_user_msgs'},
					success:function(data){
						if(is_cron_request == 1){
							$('.single_user_msgs').show();
							$('.upload_img_pre_loader').hide();
						}
						
						$('.total_msgs_'+user_id).hide();
						$('.send_user_msg').attr('user_id',user_id);
						
						
						$('.single_user_msgs').html(data);
						
						ps.update();
						$('#azChatBody').scrollTop(parseInt($('#azChatBody').prop('scrollHeight')) + 100);
						// $('#azChatBody').PerfectScrollbar('update');
						
					}
				});
			
			})
			
			$('.twilio_u_list').on('click', function(){
				$('.is_cron_request').val(1);
			})
			
			$('body').on('mouseover','.twilio_single_msg', function(){
				$(this).find('.delete_twilio_user_msg').show();
			})
			
			$('body').on('mouseout','.twilio_single_msg', function(){
				$(this).find('.delete_twilio_user_msg').hide();
			})
			
			$('body').on('click','.delete_twilio_user_msg', function(){
				
				var chat_conversation_sid = $(this).attr("chat_conversation_sid");
				var chat_message_sid = $(this).attr("chat_message_sid");
				var twilio_user_id = $(this).attr("twilio_user_id");
				var sender_by = $(this).attr("sender_by");
				
				$.ajax({
					url: "admin/twilio_sms_messenger/ajax_delete_twilio_msg",
					type: "post",
					dataType: "json",
					data: {chat_conversation_sid:chat_conversation_sid,chat_message_sid:chat_message_sid,twilio_user_id:twilio_user_id,sender_by:sender_by,'action':'delete_msg'},
					success:function(data){
						
						if(data == 1){
							$('.msg_'+chat_message_sid).remove();
						}
					}
				});
			})
			
			/********** for send user sms *************/
			$('body').on('click','.send_user_msg', function(){
				
				var message = $('.text_message').val();
				var user_id = $(this).attr('user_id');
				$('.text_message').val('');
				$('.text_message').attr('placeholder','sending....');
				
				if(user_id > 0){
					
					/*$("#newchat_added").append('<div class="media  flex-row-reverse"><div class="az-img-user online"><img src="https://via.placeholder.com/500" alt=""></div><div class="media-body"><div class="az-msg-wrapper">'+message+'</div><div><span>just now</span> <a href=""><i class="icon ion-android-more-horizontal"></i></a></div></div></div>');*/
					
					const ps = new PerfectScrollbar('#azChatBody', {
						suppressScrollX: true
					  });
					  
					$.ajax({
						url: "admin/twilio_sms_messenger/save_text_message",
						type: "post",
						dataType: "json",
						data: {user_id:user_id,message:message,'action':'send_msg'},
						success:function(data){
							
							
						$("#newchat_added").append('<div class="media  flex-row-reverse"><div class="az-img-user online"><img src="https://via.placeholder.com/500" alt=""></div><div class="media-body"><div class="az-msg-wrapper">'+data.message+'</div><div><span>'+data.new_created+'</span> <a href=""><i class="icon ion-android-more-horizontal"></i></a></div></div></div>');
							
							ps.update();
							$('#azChatBody').scrollTop(parseInt($('#azChatBody').prop('scrollHeight')) + 100);
							$('.text_message').attr('placeholder','Type your message here...');
						}
					});
				}
				
				
			})
			
			
			setInterval(twilio_user_conversations, 10000);
			
			function twilio_user_conversations(){
				
				$.ajax({
					url: "admin/twilio_sms_messenger/get_twilio_user_conversations",
					type: "post",
					dataType: "json",
					data: {'action':'get_conversations'},
					success:function(data){
						
						$('.user_new_msgs').hide();
						
						if(data.response == 1){
							$.each(data.record, function(i, item) {
							
								if(item.total_msgs > 0){
									$(".total_msgs_"+item.id).html(item.total_msgs);
									$(".user_msg_time_"+item.id).html(item.last_updated_date);
									$(".total_msgs_"+item.id).show();
									//alert('sss');
								}
							})
						}
						
						
					}
				});
				
				$('.is_cron_request').val(0);
				var list_number = $("#azChatList").children(".selected").attr("user_number");
				$('.user_number_'+list_number).trigger( "click" );
				
			}

	  })
</script>

<?php $this->load->view("admin/include/footer");?>
<script src="<?=base_url();?>assets_admin/lib/lightslider/js/lightslider.min.js"></script>
<script>

      $(function(){

        'use strict'


$('#chatActiveContacts').lightSlider({
          autoWidth: true,
          controls: false,
          pager: false,
          slideMargin: 12
        });

        if(window.matchMedia('(min-width: 992px)').matches) {
          new PerfectScrollbar('#azChatList', {
            suppressScrollX: true
          });

         /* const azChatBody = new PerfectScrollbar('#azChatBody', {
            suppressScrollX: true
          });

          $('#azChatBody').scrollTop($('#azChatBody').prop('scrollHeight'));*/
        }


        $('.az-chat-list .media').on('click touch', function() {
          $(this).addClass('selected').removeClass('new');
          $(this).siblings().removeClass('selected');

          if(window.matchMedia('(max-width: 991px)').matches) {
            $('body').addClass('az-content-body-show');
            $('html body').scrollTop($('html body').prop('scrollHeight'));
          }
        });

       // $('[data-toggle="tooltip"]').tooltip();

        $('#azChatBodyHide').on('click touch', function(e){
          e.preventDefault();
          $('body').removeClass('az-content-body-show');
        })

        

      });
	  
	  
 

    </script>


<div id="popupTwilioUserInfo" class="modal">
      <div class="modal-dialog modal-dialog-centered sortable-box" role="document">
        <div class="modal-content modal-content-demo">
          <div class="modal-header">
            <h6 class="modal-title"></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
		  <form action="" method="post" >
          <div class="modal-body edit-form">
            <div class="row row-xs align-items-center">
					<div class="col-md-12 mg-t-5 mg-md-t-0">
						<p>Name: <span class="popup_user_name"></span></p>
						<p>Phone: <span class="popup_user_phone"></span></p>
						<p>Last Seen: <span class="popup_user_last_seen"></span></p>
					</div>
					

				</div>
				
          </div>
          
		  </form>
        </div>
      </div><!-- modal-dialog -->
    </div><!-- modal -->