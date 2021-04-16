<div class="container">
            <div class="row">
               <div class="col-sm-12 col-md-12">
                  <div class="staff-block">
                     <ul>
					 <?php foreach($ourStaffs as $staff){ ?>
                        <li>
					 <?php  if($staff->not_linked == 1){ ?>
                       <?php if($staff->lightbox_or_url == 'url'){ ?>
					   <a href="<?php echo $staff->url ?>" target="<?php echo $staff->target; ?>">
					   <?php }else{ ?>
						<a class="staffInfoPopUp" href="javascript:void(0)" number="<?= $staff->id?>"  data-toggle="modal" data-target=".staff-popup">
						
					   <?php } ?>
                           <img  src="<?php base_url(); ?>upload/school_staff/thumb/<?= $staff->photo; ?>" alt="<?= $this->query_model->getStrReplace($staff->photo_alt_text); ?>">
					 		<div class="staff-hover">
					 			<button class="btn btn-theme btn-bio"><?php echo $this->query_model->getStaticTextTranslation('read_bio'); ?></button>
					 			
					 		</div>
                        </a>
					 <?php }else{ ?>
							<img  src="<?php base_url(); ?>upload/school_staff/thumb/<?= $staff->photo; ?>" alt="<?= $this->query_model->getStrReplace($staff->photo_alt_text); ?>">
					 <?php } ?>
                          <h3><?= $this->query_model->getStrReplace($staff->name); ?></h3>
                          <h4><?= $this->query_model->getStrReplace($staff->position); ?></h4>
                          <p><?= $this->query_model->getStrReplace($staff->belt); ?></p> 
						  
						</li>
					 <?php } ?>
						</ul>
                  </div>
               </div>
            </div>
         </div>