<script>
	$(document).ready(function(){
		$('.backToCategoryBlogs').click(function(){
			var category_id = $(this).attr('number');
			
			$.ajax({
			
					url: '<?=base_url();?>admin/dashboard/getPostsByCategory',
					
					type: 'post',
					
					data: {category_id: category_id},
					
					dataType: 'html',
					
					success: function(result) {
						$('#AllBlogs').hide();
						$('#getBlogDetail').hide();
						//$('.backButton').show();
						$('#getCategoryBlogs').html(result);
						$('.left-bar').removeClass('fullbox');
						$('.side-bar').show();
						
						
					}
				  
			});
		
		});
	});
</script>


<div class="recently-item" style="">
	<div class="item" style="width: 99%">
		<div class="item-title" style="margin-top:26px; float: none;">
			<br>
			<!--<img src="http://dojoservers.com/private/wp-content/uploads/<?php echo $wp_blog_detail[0]->image; ?>" class="blogImg" /><br /><br />-->
			<h2 class="blogTitle"><?php echo $wp_blog_detail[0]->post->post_title; ?></h2><br>
			<p class="blogContent"><?php echo $wp_blog_detail[0]->post->post_content; ?>
			<!--<div class="videoWrapper">
			    <iframe width="560" height="349" src="https://player.vimeo.com/video/159546002" frameborder="0" allowfullscreen></iframe>
			</div>-->
			</p>
			
		</div>		
	</div>
</div>
<div class="post_back_button backToCategoryBlogs"  number="<?php echo $wp_blog_detail[0]->category; ?>">Back To Post</p>
