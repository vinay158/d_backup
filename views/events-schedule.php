<?php $this->load->view('includes/header'); ?>



<?php $this->load->view('includes/student_header/masthead'); ?>

<?php

		$query = $this->db->get_where('tblsite', array( 'id' => 1));
		$site_settings = $query->row_array();
		$check_http = $site_settings['https'];
		$secureHost = ($check_http == 1) ? "https" : 'http';
		
		$this->db->select(array('calender_layout','embed_calendar_code'));
		$calender_setting = $this->query_model->getByTable("tblsite");
?>
	
<?php if($calender_setting[0]->calender_layout == "default_calender"){ ?>	
<script src="<?php echo $secureHost; ?>://websitedojo.com/themesv2/global/js/jquery.1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo $secureHost; ?>://websitedojo.com/themesv2/global/js/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo $secureHost; ?>://websitedojo.com/themesv2/global/js/jquery.hoverIntent.min.js" type="text/javascript"></script>
<script src="js/new/master.js"></script>
<?php } ?>


<section id="calendar" class="section">
<div class="main container clearfix">
	
	<div class="main_content" id="top">
	<div class="title-main">
		<?php if(isset($location) && !empty($location)){?> 
			 <h2><span><?php echo $title; ?><?= $location_count > 1 && ($multi_location == 1) ? " - ".$location : '' ?></span></h2>
		<?php }else{?>
			 <h2><span><?php echo $title; ?></span></h2>
		<?php }?>
		</div>
		
		
		<div class="calendar_wrapper">
		<?php 
	if($calender_setting[0]->calender_layout == "default_calender"){		
		if(!empty($categories)):  
//echo "<pre>"; print_r($categories); die;
			?>
			<form class="calendar_categories">
			<?php foreach($categories as $category): ?>
					
					<!--- DOJO 03/11  -->
					<?php 
						// DOJO 03/11
						$category_id = 'cat_'.$category->cat_id;
						$checkBoxData = $this->session->userdata($category_id);
					?>
					<label id="cat_<?=$category->cat_id?>" class="parent_category <?=$category->color?> <?=$category->color?>" <?php if($category->cat_id == 52) echo "style='display:none'" ?>>
					
					<input type="checkbox"  name="<?=$category->cat_name;?>" <?php if($checkBoxData != ''){ if($checkBoxData['checkboxValue'] == 1){ echo 'checked=checked';} } else {  echo 'checked=checked'; }?>   class="cat_check" <?php if($category->cat_id == 52) echo "style='display:none'" ?> value="<?php if($checkBoxData != ''){ echo $checkBoxData['checkboxValue']; } else{ echo 1; } ?>"  />
					
					 <?=$category->cat_name;?>
					</label>
				<!-- End DOJO -->
			
			<?php endforeach;?>
			</form>
		<?php endif; ?>
			<!-- END .calendar_buttons -->
			
			<p class="note"><?php echo $this->query_model->getStaticTextTranslation('hover_events_for_more_info'); ?></p>
			<?=$calendar;?>
			
			<?php }elseif($calender_setting[0]->calender_layout == "embed_calender"){
				if(!empty($calender_setting[0]->embed_calendar_code)){
					$this->query_model->getDescReplace($calender_setting[0]->embed_calendar_code);
				}
			} ?>
		
		</div>
		<!-- END .calendar_wrapper -->
	
	</div>
	<!-- END .main_content -->
	
</div>
<!-- .main .container -->
<?php if($calender_setting[0]->calender_layout == "default_calender"){ ?>
		<script language="javascript">

		function getCookie(c_name)
		{
		var c_value = document.cookie;		
		var c_start = c_value.indexOf(" " + c_name + "=");
		
		if (c_start == -1)
		  {
		  c_start = c_value.indexOf(c_name + "=");
		  
		  }
		if (c_start == -1)
		  {
		  c_value = null;
		  }
		else
		  {
			
		  c_start = c_value.indexOf("=", c_start) + 1;
		  var c_end = c_value.indexOf(";", c_start);
		  if (c_end == -1)
		    {
		    c_end = c_value.length;
		    }
		  c_value = unescape(c_value.substring(c_start,c_end));
		  }
		return c_value;
		}

		function setCookie(c_name,value,exdays)
		{	
			var exdate=new Date();
			exdate.setDate(exdate.getDate() + exdays);
			var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
			document.cookie=c_name + "=" + c_value;
			return true;
		}
		

		function expireCookie(name){			
			var cookieValue=getCookie(name);
			if (cookieValue!=null && cookieValue!="")
			{	var expires =value= "";				
				document.cookie = name+"="+value+expires+";";								
			  return true;
			}
			return false;
		}

		function checkCookie(name,value)
		{	
		var cookieValue=getCookie(name);
		if (cookieValue!=null && cookieValue!="")
		  {  
		   	return true;
		  }
		else 
		  {
		    setCookie(name,value,365);
		  
		  }
		}
		
		
		
		
		
		
		// DOJO 03/11
		
		$(document).ready(function(){
		
			$('.navbar-toggle').click(function(){
				var menu_type = $(this).attr('menu_type');
				if(menu_type == 'open'){
					$(this).attr('aria-expanded', false);
					$(this).addClass('collapsed');
					$('.navbar-collapse').removeClass('in');
					$('.navbar-collapse').attr('aria-expanded', false);
					$(this).attr('menu_type', 'close');
				}else{
					$(this).attr('aria-expanded', true);
					$(this).removeClass('collapsed');
					$('.navbar-collapse').addClass('in');
					$('.navbar-collapse').attr('aria-expanded', true);
					$(this).attr('menu_type', 'open');
					
				}
			});

			
			$(".parent_category").each(function(){
			// alert('aaaa');
				var id = $(this).attr("id").substr(4);
				//var id=''; 
				var background = $(this).css("background-color");
				var color = $(this).css("color");
		
				//Color change vice-versa 
				background= rgb2hex(background);
				background=background.toUpperCase();		
				$(".cat_"+id).css("background-color", background);
				$(".cat_"+id).css("color", color);
			
				var arr = ["#DEF5F6","#F9F9D6","#DEFFAB","#FFE2C6" ,"#E4E4E4" ,"#FFDEEB" ,"#FAE2FF" ,"#E9D2B7" ,"#FFE3DE" ,"#E1E3FF" ];
				var _index =jQuery.inArray(background, arr);
				if(_index=0 || _index != -1 ){
					background=color;
				}
				
				$(".header_"+id).css("color", background);	
				$(".header_"+id).css("font-weight", "bold");
				$(".header_"+id).css("font-size", "14px");
				
				$(this).stop();
				
			});
			
			
	
			$('.parent_category').on('change', function(){
				var id = $(this).attr("id");
				//alert(id); return false;
				var status = $(this).find('.cat_check').attr('checked');
				
				var checkboxValue = '';
				if(typeof status == 'undefined'){
					
					$(this).find('.cat_check').val(0); // DOJO 03/11 count
					$(this).find('.count').val(0);
					var checkboxValue = 0;
					//alert($(this).find('.cat_check').val());
					$('.'+id).fadeOut();
				}else{
					
					$(this).find('.cat_check').val(1); // DOJO 03/11
					$(this).find('.count').val(1);
					var checkboxValue = 1;
					//alert($(this).find('.cat_check').val());
					$('.'+id).fadeIn();
				}
				
				
				$.ajax({
						   type: "POST",
						   url: '<?=base_url();?>events/getCheckBoxValue',
						   data: { id : id , checkboxValue: checkboxValue},
					   	   success: function(result) {
							
							 
						   }
						 });
				
			})

		
		});

var hexDigits = new Array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f"); 

//Function to convert hex format to a rgb color
function rgb2hex(rgb) {
 rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
 return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function hex(x) {
  return isNaN(x) ? "00" : hexDigits[(x - x % 16) / 16] + hexDigits[x % 16];
 }
		
function loadPreserve(){
	
	// DOJO 03/11
	
	$(".parent_category").each(function(){
		var id = $(this).attr("id");
		var checkBoxValue = $(this).find('.cat_check').val();
		if(checkBoxValue == 0){
			$('.'+id).fadeOut();
		}
		
	});
	
	
	
}




loadPreserve();	

		</script>
<?php } ?>

</section>

<?php $this->load->view('includes/footer'); ?>
	
