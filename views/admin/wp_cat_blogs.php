<script>

	$(document).ready(function(){	
		$('.blogPost').click(function(){
			var blog_id = $(this).attr('number');
			var category = $(this).attr('category');
			
			$.ajax({
			
					url: '<?=base_url();?>admin/dashboard/getPostsDetail',
					
					type: 'post',
					
					data: {blog_id : blog_id, category : category},
					
					dataType: 'html',
					
					success: function(result) {
						$('#AllBlogs').hide();
						$('#categoryBlogs').hide();
						$('.backButtonOnCatgory').hide();
						$('.ShowMoreCategory').hide();
						$('#getBlogDetail').html(result);
						$('.left-bar').addClass('fullbox');
						$('.side-bar').hide();
						
					}
				  
			});
		});
	});
</script>

<div id="getBlogDetail" class=""> </div>
<div id="categoryBlogs" class="recently-item" style="">
		
	 	<?php if(!empty($wp_cat_blogs->blogs)){ ?>
		<div class="categoryTitle"><?php echo $wp_cat_blogs->blogs[0]->category_name; ?></div>
		<?php foreach($wp_cat_blogs->blogs as $blog){ ?>
		<?php if(!empty($blog->post)){ ?>
			<div class="item blogItem" style="float: left;">
				<a href="javascript:void(0);" class="blogPost"  category="<?php echo $blog->category; ?>"  number="<?php echo $blog->post->ID; ?>">
					<img src="http://dojoservers.com/private/wp-content/uploads/<?php echo $blog->image; ?>" class="blogItemImg" /><br />
					<!-- <span class="blogItemTitle"><?php echo $blog->post->post_title; ?></span>-->
				</a>
			</div>
		<?php } } } else {?>
			<div class="categoryTitle"><?php echo $wp_cat_blogs->category_name; ?></div>
				<span class="noPosts">No Posts in this Category</span>
			<?php } ?>	
			</div>
	<div class="category_back_button backButtonOnCatgory"><a href="admin/dashboard">Back To Category</a></div>					
</div> 
</div>
</div>