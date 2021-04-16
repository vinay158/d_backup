<div class="delete-holder-advert" style="display: none;">
  <form action="admin/<?=$link_type;?>/deleteadvert" method="post">
  <div class="dropdown-panel">
    <div class="dropdown-title">
      <div style="float:left;">Confirmation</div>
      <div class="btn-close"><a class="close-btn"></a></div>
    </div>
    
    <div class="dropdown-body">
	    <div class="form-item">
		    <h1>Are you sure you want to delete this?</h1><br>
		    <span class="catNote" style="">Note: This will permanently delete all data</span>
			<input type="hidden" name="delete-advert-id" id="delete-advert-id" value=""/>
		    <input type="hidden" name="category_loc" id="category_loc" value="<?=$this->uri->segment(4);?>" />
	    </div>
    </div>
    <div class="dropdown-bottom">
	    <input type="submit" value="Delete" class="btn-delete" style="float:left;">
		<script language="javascript">
		$(document).ready(function(){
			$(".btn-cancel").click(function(){
				$(this).parents(".delete-holder-item").slideUp(300);
			})
		});
		</script>
	    <input type="button" value="Cancel" class="btn-cancel" style="float:left;">
    </div>
  </div></form>
</div>