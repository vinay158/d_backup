<div class="delete-holder" style="display: none;">
  <form action="admin/<?=$link_type;?>/deleteCategory" method="post">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;">Confirmation</div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>
    
    <div class="dropdown-body">
	    <div class="form-item">
		    <h1>Are you sure you want to delete this?</h1><br>
		    <?php if($this->uri->segment(2)=='calendar'){ ?>
		    	<span class="catNote" style="">Note: This will permanently delete all Events in this Category.</span>
		    <?php }elseif($this->uri->segment(2)=='programs'){ ?>		    
		    	<span class="catNote" style="">Note: This will permanently delete all Programs in this Category.</span>
		    <?php } ?>
			<input type="hidden" name="delete-id" id="delete-id" value=""/>
		    
	    </div>
    </div>
    <div class="dropdown-bottom">
	    <input type="submit" value="Delete" class="btn-delete" style="float:left;">
		<script language="javascript">
		$(document).ready(function(){
			$(".btn-cancel").click(function(){
				$(this).parents(".delete-holder").slideUp(300);
			})
		});
		</script>
	    <input type="button" value="Cancel" class="btn-cancel" style="float:left;">
    </div>
  </div></form>
</div>