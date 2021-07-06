<?php if(!empty($sms_user_detail)){ ?>
        <!--  <div class="az-chat-header">
            <div class="az-img-user"><img src="https://via.placeholder.com/500" alt=""></div>
            <div class="az-chat-msg-name">
              <h6><?php echo $sms_user_detail[0]->name; ?></h6>
              <small>Last seen: <?php echo $this->query_model->getTimeAgo($sms_user_detail[0]->last_updated_date); ?></small>
            </div>
            <nav class="nav">
              <a href="" class="nav-link"><i class="icon ion-md-more"></i></a>
              <a href="" class="nav-link" data-toggle="tooltip" title="Call"><i class="icon ion-ios-call"></i></a>
              <a href="" class="nav-link" data-toggle="tooltip" title="Archive"><i class="icon ion-ios-filing"></i></a>
              <a href="" class="nav-link" data-toggle="tooltip" title="Trash"><i class="icon ion-md-trash"></i></a>
              <a href="" class="nav-link" data-toggle="tooltip" title="View Info"><i class="icon ion-md-information-circle"></i></a>
            </nav>
          </div> 
          <div id="azChatBody" class="az-chat-body">
            <div class="content-inner"> -->
            
		<?php 
			if(!empty($messages)){
				$last_msg_date = '';
				foreach($messages as $msg){
					
				$msg_date = date('Y-m-d', strtotime($msg->created));
					
				if($last_msg_date != $msg_date){ 
				
					$last_msg_date = $msg_date;
			?>
            <label class="az-chat-time"><span><?php echo $this->query_model->getTimeAgo($msg_date, 'day_format'); ?></span></label>
			<?php } ?>
            
			 <div class="media twilio_single_msg msg_<?php echo $msg->chat_message_sid; ?> <?php echo ($msg->sender_by == "admin") ? ' flex-row-reverse' : ''; ?>">
                <div class="az-img-user online"><img src="https://via.placeholder.com/500" alt=""></div>
                <div class="media-body"> 
                  <div class="az-msg-wrapper">
                    <?php //$this->query_model->getDescReplace($msg->message); ?>
					<?php $formData = array('name'=>$sms_user_detail[0]->name,'phone'=> $sms_user_detail[0]->phone,'location'=>'','last_name'=>'','email'=>'','program'=>'','message'=>'');
						$formData['twilio_msg_user_id'] = $sms_user_detail[0]->id;
					$message = nl2br($msg->message);
						echo  $this->query_model->replaceAutoResponderVaribles($message, $formData, ''); ?>
                  </div><!-- az-msg-wrapper -->
                  <div><span><?php echo date('h:i a', strtotime($msg->created)); ?></span>  
				  <?php if($msg->template_msg_status == "hold"){ ?><span class="msg_on_hold">Message On Hold</span> <?php } ?>
					<a href="javascript:void(0)" class="delete_twilio_user_msg" chat_conversation_sid="<?php echo $sms_user_detail[0]->chat_conversation_sid; ?>" chat_message_sid="<?php echo $msg->chat_message_sid; ?>" twilio_user_id="<?php echo $sms_user_detail[0]->id; ?>"  style="display:none" ><i class="fa fa-trash"></i></a></div>
                </div><!-- media-body -->
              </div><!-- media -->
			
		<?php } } ?>
			<div id="newchat_added"></div>
           <!-- </div>
          </div> --->
        <?php } ?> 
		
		
	
