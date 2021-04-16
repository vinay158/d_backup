<?php if(!empty($staffDetail)): ?>
<div id="staff-block" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      
      </div>
      <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="staff-bio-detail">
            <img  src="<?php base_url(); ?>upload/staff/<?= $staffDetail[0]->lightbox_photo; ?>" alt="<?= $this->query_model->getStrReplace($staffDetail[0]->lightbox_photo_alt_text); ?>"  class="img-responsive">

            <h2><?= $staffDetail[0]->name; ?></h2>
            <h3><?= $this->query_model->getStrReplace($staffDetail[0]->position); ?></h3>
            <p class="lead"><?= $this->query_model->getStrReplace($staffDetail[0]->belt); ?></p>
            
            <p><?= $this->query_model->getStrReplace($staffDetail[0]->content); ?></p>
          </div>
        </div>
        <!--  <div class="col-sm-12 col-md-6"> 
         <img  src="<?php base_url(); ?>upload/staff/<?= $staffDetail[0]->lightbox_photo; ?>" alt="<?= $this->query_model->getStrReplace($staffDetail[0]->lightbox_photo_alt_text); ?>"  class="img-responsive">
         </div>
         <div class="col-sm-12 col-md-6">
            <h2><?= $staffDetail[0]->name; ?></h2>
            <h3><?= $this->query_model->getStrReplace($staffDetail[0]->position); ?></h3>
            <p class="lead"><?= $this->query_model->getStrReplace($staffDetail[0]->belt); ?></p>
            
            <p><?= $this->query_model->getStrReplace($staffDetail[0]->content); ?></p>
         </div> -->
      </div>
      </div>
     
    </div>
  </div>
  
  <?php endif; ?>