<?php //echo '<pre>main_lead_detail'; print_r($main_lead_detail); 
 $lead_type = $this->query_model->getKanbanLeadTypeToOrderType($main_lead_detail['order_type']); 
 
 $this->db->select(array('image'));
 $profile_img = $this->query_model->getBySpecific('tbl_lead_profile_img','email',$main_lead_detail['email']);
 
 $user_image = !empty($profile_img) ? base_url().'upload/kanban_user_profiles/thumb/'.$profile_img[0]->image : base_url().'assets_admin/img/lead_blank_profile_img.png';
?> 
 <div class="modal-content modal-content-demo">
  <div class="modal-header">
		<span class="update_kanban_status_reponse"></span>
		<input type="hidden" class="update_kanban_status_reponse_code" value="0">
            <button type="button" class="btn btn-success update_lead_status_id" status_type="won" kanban_status_id="<?php echo $main_lead_detail['kanban_status_id']; ?>" lead_type="<?php echo $lead_type; ?>" lead_id="<?php echo $main_lead_detail['id']; ?>">Won <i class="fa fa-check" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-danger update_lead_status_id"  status_type="lost" kanban_status_id="<?php echo $main_lead_detail['kanban_status_id']; ?>"  lead_type="<?php echo $lead_type; ?>" lead_id="<?php echo $main_lead_detail['id']; ?>">Lost</button>
            
			<button type="button" class="close status_update_popup_close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
			<button type="button" class="ellipsis" >
              <!--<i class="fas fa-ellipsis-h"></i>-->
            </button>
          </div>
          <div class="modal-body">
            <div class="cont">
				<div class="detail">
					<div class="az-img-user avatar-xxl d-none d-sm-block">
					<img id="OpenImgUpload" src="<?php echo $user_image; ?>" class="rounded-circle" alt="">
					<input type="hidden" name="lead_profile_img" id="lead_profile_img"  value=""  />
					<input type="file" id="imgupload"  field_name="lead_profile_img" email="<?php echo $main_lead_detail['email']; ?>"  lead_type="<?php echo $lead_type; ?>" lead_id="<?php echo $main_lead_detail['id']; ?>" style="display:none"/> 
					
					</div>
					<div class="media-body">
						<h4><?php echo $main_lead_detail['name']; ?></h4>
						<a href="tel:<?php echo $main_lead_detail['phone']; ?>" class="nav-link"><i class="fas fa-phone"></i><?php echo $main_lead_detail['phone']; ?></a>
						<a href="mailto:<?php echo $main_lead_detail['email']; ?>" class="nav-link"><i class="fas fa-envelope"></i><?php echo $main_lead_detail['email']; ?></a>
					</div>
					<div class="badge_box">
						<?php 
							$lead_status = $this->query_model->getKanbanLeadStatusById($main_lead_detail['kanban_status_id']); 
							
							if(!empty($lead_status)){
						?>
						<span class="badge badge-pill badge-danger" style="background:<?php echo !empty($lead_status->color_code) ? $lead_status->color_code : 'red'; ?>"><?php echo $lead_status->title; ?></span>
						<?php } ?>
						
						<span class="kanban_tag_list_<?php echo $lead_type; ?>_<?php echo $main_lead_detail['id']; ?>">
						<?php 
							
							$tags = $this->query_model->getOrderTagsByOrderId($main_lead_detail['id'],$lead_type);
							
								if(!empty($tags)){ 
									foreach($tags as $tag_id => $tag){
						?>
						<span class="badge badge-pill badge-primary kanban_tag_<?php echo $tag_id; ?>"><?php echo $tag; ?> <span class="remove_kanban_order_tag" tag_id="<?php echo $tag_id; ?>">x</span></span>
						<?php } } ?>
						</span>
						<br/>
						<span><input type="text" class="add_kanban_tag_input" placeholder="Enter Tag"></span>
						<span><a class="add_kanban_tag_btn" lead_type="<?php echo $lead_type; ?>" lead_id="<?php echo $main_lead_detail['id']; ?>" tag_type="custom_tag">Add Tag</a></span>
					</div>
					<div class="comment-detail">
						<p><b>Preferred Contact Method:</b> SMS</p>
						<?php
							$this->db->select(array('name'));
							$school_detail = $this->query_model->getbySpecific('tblcontact','id',$main_lead_detail['location_id']); 
							if(!empty($school_detail)){ 
						?>
						<p><b>Location:</b> <?php echo $school_detail[0]->name; ?></p>
							<?php } ?>
						
					</div>
					<div class="comment-form">
						<textarea rows="3" class="form-control lead_comment" placeholder="Add Comment"></textarea>
						<span class="send_comment_response"></span>
						<a href="javascript:void(0)" class="az-msg-send add_lead_comment" lead_type="<?php echo $lead_type; ?>" lead_id="<?php echo $main_lead_detail['id']; ?>">
						
						<i class="fas fa-arrow-circle-right"></i></a>
					</div>
					
					
					<div id="new_comment_added">
						<?php 
							$comments = $this->query_model->getKanbanLeadComments($main_lead_detail['id'],$lead_type);
							
							if(!empty($comments)){
								foreach($comments as $comment){
						?>
						
						<div class="recent_added_comment"><div class="comment_date"><span class="time_ago"><?php echo $comment['created']; ?></span><span class="comment_datetime"><?php echo $comment['created_date']; ?></span></div><div class="comment"><?php echo $comment['comment']; ?></div></div>
							<?php } } ?>
						
					</div>
					
				</div>
				<div class="grey-detail">
				<?php 
					$form_tag = $this->query_model->getOrderTagsByOrderId($main_lead_detail['id'],$lead_type,'form_tag');
					if(!empty($form_tag)){
				?>
				<b><?php echo isset($lead_status->title) ? $lead_status->title : ''; ?></b>
				<span>
				<?php foreach($form_tag as $tag){ echo $tag; } ?>
				</span>
				<?php } ?>
					<ul>
						<li><i class="far fa-calendar-check"></i><b>Date Added</b><span><?php echo date('M d, Y ', strtotime($main_lead_detail['created'])); ?>    </span></li>
						<li><i class="fa fa-clock" aria-hidden="true"></i><b>Last Contacted</b><span>YYYY/MM/DD</span></li>
						<li><i class="fa fa-file-image" aria-hidden="true"></i><b><?php echo $lead_types[$main_lead_detail['order_type']]; ?></b><span><?php echo isset($page_name) ? $page_name : ''; ?></span></li>
						<li><i class="fa fa-map-marker" aria-hidden="true"></i><b>IP Address</b><span><?php echo $main_lead_detail['ip_address'] ?></span></li>
						<li><i class="fa fa-home fa-fw" aria-hidden="true"></i>
							<b>Jan 31, 2020</b><span>Do you think we need a history list like this</span>
							<b>Jan 31, 2020</b><span>Do you think we need a history list like this</span>
						</li>
					</ul>
					
				</div>
				
			</div>
          </div>
          
</div>

<script>
	$(document).ready(function(){
		// upload image by ajax
$('body').on('change','#imgupload',function(){
	
	var file = $(this)[0].files[0];
	var field_name = $(this).attr('field_name');
	var email = $(this).attr('email');
	var lead_type = $(this).attr('lead_type');
	var lead_id = $(this).attr('lead_id');
	var upload = new Upload(file);
	
	upload.doUpload(field_name,email,lead_type,lead_id);
		
})



	var Upload = function (file) {
    this.file = file;
};

Upload.prototype.getType = function() {
    return this.file.type;
};
Upload.prototype.getSize = function() {
    return this.file.size;
};
Upload.prototype.getName = function() {
	var uniqueNumber = new Date().getTime(); 
	var imageName = uniqueNumber+this.file.name;
	//alert(imageName+'==>'+uniqueNumber);
    return imageName;
};
Upload.prototype.doUpload = function (field_name,email,lead_type,lead_id) {
	/*$('.save_full_row_add_btn').css("pointer-events", "none");
	$('.upload_img_pre_loader').show();*/
	
    var that = this;
    var formData = new FormData();

    // add assoc key values, this will be posts values
    formData.append("file", this.file, this.getName());
    formData.append("upload_file", true);
    formData.append("email", email);
	
	//$("#"+field_name).val(this.getName());
	
    $.ajax({
        type: "POST",
        url: "admin/kanban_leads/ajaxSaveLeadProfileImage",
        xhr: function () {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
				myXhr.upload.addEventListener('progress', that.progressHandling, false);
            }
            return myXhr;
        },
        success: function (data) {
			$("#"+field_name).val(data);
			var image_path = '<?php echo base_url() ?>upload/kanban_user_profiles/thumb/'+data;
			$('#OpenImgUpload').attr('src',image_path);
			$('.profile_img_'+lead_type+'_'+lead_id).addClass('profile_img_exist');
			$('.profile_img_'+lead_type+'_'+lead_id).html('<img src="'+image_path+'">');
			/*$('.upload_img_pre_loader').hide();
			$('.save_full_row_add_btn').css("pointer-events", "all");*/
			//$('.saveProgramButton').removeAttr("disabled");
			//alert(data);
            // your callback here
        },
        error: function (error) {
			/*$('.upload_img_pre_loader').show();
			$('.save_full_row_add_btn').css("pointer-events", "none");*/
			//$('.saveProgramButton').removeAttr("disabled");
            // handle error
        },
        async: true,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        timeout: 60000
    });
};

Upload.prototype.progressHandling = function (event) {
	
    
};
	})
</script>
