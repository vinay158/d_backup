<?php
	
	$apiKeys = $this->query_model->getbySpecific('tblapikey','location_id', $location_id);
	if(!empty($apiKeys)){
		$apiKeys = $apiKeys[0];
	} else{
		$apiKeys = '';
	}
		
		
	$limit = 200;
	if($apiKeys->facebook_user_id != '' &&  $apiKeys->facebook_access_token != ''){
			$facebook = $this->query_model->facebookUserMedia($apiKeys->facebook_user_id,  $apiKeys->facebook_access_token, $limit, $apiKeys->facebook_page_id);
	} else {
			$facebook = array();
	}
	//echo '<pre>'; print_r($facebook); die;	
		
	if($apiKeys->google_plus_id != '' && $apiKeys->google_plus_api_key != ''){
	   		$googlePlus = $this->query_model->googlePlusUserMedia( $apiKeys->google_plus_id , $apiKeys->google_plus_api_key);
	}else {
			$googlePlus = array();
	}
	
	
	if($apiKeys->google_plus_id != '' && $apiKeys->google_plus_api_key != ''){
	   		$RecentgooglePlus = $this->query_model->googlePlusUserMedia( $apiKeys->google_plus_id , $apiKeys->google_plus_api_key);
	}else {
			$RecentgooglePlus = array();
	}
	
	//echo '<pre>'; print_r($googlePlus); 
	
	 $filePath = base_url().'twitter/index.php?location_id='.$location_id;
	 //echo $filePath; die;
		 $twitter_posts = file_get_contents($filePath);
		$twitterss = json_decode($twitter_posts);
		
		
		if($apiKeys->youtube_channel_id != '' && $apiKeys->youtube_api_key != ''){
			$youtube = $this->query_model->youtubeUserMedia( $apiKeys->youtube_channel_id , $apiKeys->youtube_api_key);
			$youtubeDetails = array(); 
			if(!empty($youtube['items'])){
					foreach($youtube['items'] as $youtube_video){	
						if(isset($youtube_video['id']['videoId'])){
							$url = 'http://www.youtube.com/watch?v='.$youtube_video['id']['videoId'];
							$detail = $this->query_model->get_youtube($url);
							$detail['video_id'] = $youtube_video['id']['videoId'];
							$youtubeDetails[] = $detail;
						}
					}
				}
			$youtubeDetails = $youtubeDetails;
		} else {
			$youtubeDetails = array();
		}
?>

<style>
.box1{position: absolute !important; left: 0px !important; top: 645px;}
.box2{position: absolute !important; left: 216px !important; top: 645px;}
.box3{position: absolute !important; left: 432px !important; top: 645px;}
.box4{position: absolute !important; left: 648px !important; top: 645px;}
.box5{position: absolute !important; left: 864px !important; top: 645px;}
/*.wrongDiv{transform: translate3d(0px, 0px, 0px) !important;}*/
</style>
  <div class="sep-line"></div>

<script>
	$(window).load(function(){
		$('.countSocialPosts').val(10);
			var show_social_posts = $('.showPosts').length;
			$('.countALLPosts').val(show_social_posts);
			
			
	});
	
	
	$(document).ready(function(){
		/*$('.all-social').click(function(){
			$('.checkPostType').val($(this).attr('type'));
		
		});*/
		
		$('.socialButton').click(function(){
				var socialType = $(this).attr('type');
				
				if(socialType == 'twitter'){
					var countImages = $('.countTwitterSocialPosts').val();
					var showImages = parseInt(countImages) + Number(0);
					$('.countTwitterSocialPosts').val(showImages);
				} else if(socialType == 'facebook'){
					var countImages = $('.countFacebookSocialPosts').val();
					var showImages = parseInt(countImages) + Number(0);
					$('.countFacebookSocialPosts').val(showImages);
				} else if(socialType == 'youtube'){
					var countImages = $('.countYoutubeSocialPosts').val();
					var showImages = parseInt(countImages) + Number(0);
					$('.countYoutubeSocialPosts').val(showImages);
				} else if(socialType == 'googleplus'){
					var countImages = $('.countGooglePlusSocialPosts').val();
					var showImages = parseInt(countImages) + Number(0);
					$('.countGooglePlusSocialPosts').val(showImages);
				} 
		
			//alert(socialType);
				$.each( $( "."+socialType ), function() {
					 var number = $(this).attr('number');
					// var newnumber = parseInt(number) - Number(countImages);
					 if(number > 0 && number <= showImages){
					 	
					 	$(this).removeClass('hidePosts');
						$(this).addClass('showPosts');
						//$(this).addClass('wrongDiv');
						
						
					 	
					 }
					
					
				});
				
				//$(document.body).trigger('load');
				
			  // init Isotope
			      var newQsRegex;
  					
				  var $grid = $('.social-list').isotope({
					itemSelector: '.social_items',
					//layoutMode: 'fitRows',
					  filter: function() {
					 // console.log('filtering1212');
					  var $this = $(this);
					 // return newQsRegex ? $this.text().match( newQsRegex ) : true;
					}
				  });
			  
			  // use value of search field to filter
			  var $newQuicksearch = $('.quicksearch').keypress( debounce( function() {
			  
				newQsRegex = new RegExp( $newQuicksearch.val(), 'gi' );
				//alert($('.social-list').text().match( newQsRegex ).attr('number'));
				console.log( "."+socialType);
				$( "."+socialType ).removeClass('showPosts');
				$( "."+socialType ).addClass('hidePosts');
				
				
					$.each( $( "."+socialType ), function() {
					 var number = $(this).attr('number');
					
					 if(number > 0 && number <= showImages){
					 		
						if($(this).text().match( newQsRegex )){
							$(this).addClass('showPosts');
							$(this).removeClass('hidePosts');
							
						}
						
					 }
					
				});
				
				$grid.isotope();
			  }) );
			  
			  
			  // filter functions
			  var filterFns = {
				// show if number is greater than 50
				numberGreaterThan50: function() {
				  var number = $(this).find('.number').text();
				  return parseInt( number, 10 ) > 50;

				},
				// show if name ends with -ium
				ium: function() {
				  var name = $(this).find('.name').text();
				  return name.match( /ium$/ );
				}
			  };
			  // bind filter button click
			 // $('.filters-button-group').on( 'click', 'a', function() {
			  //	$('.showMoreSocialPosts').removeClass('hidePosts');
				var filterValue = '.'+socialType;
				// use filterFn if matches value
				filterValue = filterFns[ filterValue ] || filterValue;
				$grid.isotope({ filter: filterValue });
			 // });
			  // change is-checked class on buttons
			  $('.button-group').each( function( i, buttonGroup ) {
				var $buttonGroup = $( buttonGroup );
				$buttonGroup.on( 'click', 'a', function() {
					//$('.showMoreSocialPosts').removeClass('hidePosts');
				  $buttonGroup.find('.is-checked').removeClass('is-checked');
				  $( this ).addClass('is-checked');
				});
			  });
  			
		});
		
		$('.showMoreSocialPosts').click(function(){
			
			var socialType = $('.checkPostType').val();
			
			if(socialType != 'ALL'){
				if(socialType == 'twitter'){
					var countImages = $('.countTwitterSocialPosts').val();
					var showImages = parseInt(countImages) + Number(5);
					$('.countTwitterSocialPosts').val(showImages);
				} else if(socialType == 'facebook'){
					var countImages = $('.countFacebookSocialPosts').val();
					var showImages = parseInt(countImages) + Number(5);
					$('.countFacebookSocialPosts').val(showImages);
				} else if(socialType == 'youtube'){
					var countImages = $('.countYoutubeSocialPosts').val();
					var showImages = parseInt(countImages) + Number(5);
					$('.countYoutubeSocialPosts').val(showImages);
				} else if(socialType == 'googleplus'){
					var countImages = $('.countGooglePlusSocialPosts').val();
					var showImages = parseInt(countImages) + Number(5);
					$('.countGooglePlusSocialPosts').val(showImages);
				}
		
				$.each( $( "."+socialType ), function() {
					 var number = $(this).attr('number');
					// var newnumber = parseInt(number) - Number(countImages);
					 if(number > 5 && number <= showImages){
					 
					 	$(this).removeClass('hidePosts');
						$(this).addClass('showPosts');
						//$(this).addClass('wrongDiv');
					 	
					 }
					
				});
				
				//$(document.body).trigger('load');
				
			  // init Isotope
			   var newQsRegex;
			  var $grid = $('.social-list').isotope({
				itemSelector: '.social_items',
				layoutMode: 'fitRows',
				filter: function() {
				  var $this = $(this);
				// return newQsRegex ? $this.text().match( newQsRegex ) : false;
				}
			  });
			  
			   var $newQuicksearch = $('.quicksearch').keyup( debounce( function() {
			  
				newQsRegex = new RegExp( $newQuicksearch.val(), 'gi' );
				$( "."+socialType ).removeClass('showPosts');
				$( "."+socialType ).addClass('hidePosts');
					$.each( $( "."+socialType ), function() {
					 var number = $(this).attr('number');
					
					 if(number > 0 && number <= showImages){
					 		
						if($(this).text().match( newQsRegex )){
							$(this).addClass('showPosts');
							$(this).removeClass('hidePosts');	
						}
					 	
					 }
					
				});
				
				$grid.isotope();
			  }) );
			  
			  
			  // filter functions
			  var filterFns = {
				// show if number is greater than 50
				numberGreaterThan50: function() {
				  var number = $(this).find('.number').text();
				  return parseInt( number, 10 ) > 50;

				},
				// show if name ends with -ium
				ium: function() {
				  var name = $(this).find('.name').text();
				  return name.match( /ium$/ );
				}
			  };
			  // bind filter button click
			 // $('.filters-button-group').on( 'click', 'a', function() {
			  //	$('.showMoreSocialPosts').removeClass('hidePosts');
				var filterValue = '.'+socialType;
				// use filterFn if matches value
				filterValue = filterFns[ filterValue ] || filterValue;
				$grid.isotope({ filter: filterValue });
			 // });
			  // change is-checked class on buttons
			  $('.button-group').each( function( i, buttonGroup ) {
				var $buttonGroup = $( buttonGroup );
				$buttonGroup.on( 'click', 'a', function() {
					//$('.showMoreSocialPosts').removeClass('hidePosts');
				  $buttonGroup.find('.is-checked').removeClass('is-checked');
				  $( this ).addClass('is-checked');
				});
			  });
  			
			
			
			/***** For ALL *****/
			
			} else {
				
				$('.facebook').removeClass('showPosts');
				$('.twitter').removeClass('showPosts');
				$('.facebook').addClass('hidePosts');
				$('.twitter').addClass('hidePosts');
				var show_social_posts = $('.countALLPosts').val();
				//aler(show_social_posts);
				var countALLPosts = parseInt(show_social_posts) + Number(5);
				//alert(show_social_posts); return false;
				$('.countALLPosts').val(countALLPosts);
				
				
				
				
				/*if(countALLPosts == 15){
						var current = 3;
					} else{
						var current = 0;
					}*/
					
					var current = 0;
				$.each( $( '.ALL'), function() {
					 if(current > 5 && current < countALLPosts){
					 	$(this).removeClass('hidePosts');
						$(this).addClass('showPosts');
					 }
					 
					 current++;
					
				});
				
				var newQsRegex;
				 var $grid = $('.social-list').isotope({
				itemSelector: '.social_items',
				layoutMode: 'fitRows',
				 filter: function() {
					   var $this = $(this);
					   $('.facebook').addClass('hidePosts');
					   $('.twitter').addClass('hidePosts');
					   return newQsRegex ? $this.text().match( newQsRegex ) : true;
					}
			  });
			  
			  
			   var $newQuicksearch = $('.quicksearch').keyup( debounce( function() {
					
				newQsRegex = new RegExp( $newQuicksearch.val(), 'gi' );
				/*if(countALLPosts == 15){
						var current = 3;
					} else{
						var current = 0;
					}*/
					
					var current = 0;
					$.each( $( '.ALL'), function() {
						 if(current > 5 && current < countALLPosts){
							if($(this).text().match( newQsRegex )){
								$(this).removeClass('hidePosts');
								$(this).addClass('showPosts');
							}
						 }
						 
						 current++;
						
					});
				
				$grid.isotope();
			  }) );
			  
			  
			  // filter functions
			  var filterFns = {
				// show if number is greater than 50
				numberGreaterThan50: function() {
				  var number = $(this).find('.number').text();
				  return parseInt( number, 10 ) > 50;
				},
				// show if name ends with -ium
				ium: function() {
				  var name = $(this).find('.name').text();
				  return name.match( /ium$/ );
				}
			  };
			  // bind filter button click
			
			}

			
		});
		
		
	});
</script>
<style>
.social_items{transform:none !important} 

/*.social-list,
.social-list .social_items {
  
  -webkit-transition-duration: 0.1s !important;
     -moz-transition-duration: 0.1s !important;
      -ms-transition-duration: 0.1s !important;
       -o-transition-duration: 0.1s !important;
          transition-duration: 0.1s !important;
}

.social-list {
  -webkit-transition-property: height, width !important;
     -moz-transition-property: height, width !important;
      -ms-transition-property: height, width !important;
       -o-transition-property: height, width !important;
          transition-property: height, width !important;
}

.social-list .social_items {
  -webkit-transition-property: -webkit-transform, opacity !important;
     -moz-transition-property:    -moz-transform, opacity !important;
      -ms-transition-property:     -ms-transform, opacity !important;
       -o-transition-property:      -o-transform, opacity !important;
          transition-property:         transform, opacity !important;
}
*/

</style>

<?php if(isset($facebook['error']) && !empty($facebook['error'])){
	echo '<span class="error_fb_access_token">Please Provide Valid Access Token</span>';
} ?>

<?php
	$total_posts = 10;
	$allsocial_news_box = 4;
	$blank = 0;
	
	$face_p = 3;
	$twitter_p = 3;
	$youtube_p = 2;
	$google_p = 2;
	
	if(empty($apiKeys->twitter_user_name) || empty($apiKeys->twitter_consumer_key) || empty($apiKeys->twitter_consumer_secret) || empty($apiKeys->twitter_access_token) || empty($apiKeys->twitter_access_token_secret)){
		$blank += 1;
		$twitter_p= 0;
		
		$face_p  = ($face_p == 0)?0:($face_p+1);
		$youtube_p  = ($face_p == 0)?0:($youtube_p+1);
		$google_p  = ($face_p == 0)?0:($google_p+1);
	}
	
	if(empty($apiKeys->facebook_user_id) || empty($apiKeys->facebook_access_token)){
		$blank += 1;
		
		$face_p= 0;
		$twitter_p  = ($twitter_p == 0)?0:($twitter_p+1);
		$youtube_p  = ($youtube_p == 0)?0:($youtube_p+1);
		$google_p  = ($google_p == 0)?0:($google_p+1);
	}
	
	if(empty($apiKeys->google_plus_id) || empty($apiKeys->google_plus_api_key)){ 
		$blank += 1;
		
		
		$google_p = 0;
		
		$twitter_p  = ($twitter_p == 0)?0:($twitter_p+1);
		$face_p  = ($face_p == 0)?0:($face_p+1);
		$youtube_p  = ($youtube_p == 0)?0:($youtube_p);
		
		
	} 
	
	
	if(empty($apiKeys->youtube_channel_id) || empty($apiKeys->youtube_api_key)){
		$blank += 1;
		
		$youtube_p= 0;
		
		$twitter_p  = ($twitter_p == 0)?0:($twitter_p+1);
		$face_p  = ($face_p == 0)?0:($face_p+1);
		$google_p  = ($google_p == 0)?0:($google_p);
	}
	
	
	//$total_box = $allsocial_news_box - $blank;
	//echo 'youtube_p==>'.$youtube_p.'<br>twitter_p==>'.$twitter_p.'<br>face_p==>'.$face_p.'<br>google_p==>'.$google_p;
	if($blank == 3){
		if(!empty($apiKeys->google_plus_id) && !empty($apiKeys->google_plus_api_key)){ 
			$google_p = 10;
		}
			 
		if(!empty($apiKeys->facebook_user_id) && !empty($apiKeys->facebook_access_token)){
			$face_p = 10;
		}
			  
		if(!empty($apiKeys->youtube_channel_id) && !empty($apiKeys->youtube_api_key)){ 
			$youtube_p = 10;
		}			  
		
		if(!empty($apiKeys->twitter_user_name) && !empty($apiKeys->twitter_consumer_key) && !empty($apiKeys->twitter_consumer_secret) && !empty($apiKeys->twitter_access_token) && !empty($apiKeys->twitter_access_token_secret)){ 
			$twitter_p = 10;
		}
	
	}
	
	if($blank == 2){
		if(!empty($apiKeys->google_plus_id) && !empty($apiKeys->google_plus_api_key)){ 
			$google_p = 5;
		}
			 
		if(!empty($apiKeys->facebook_user_id) && !empty($apiKeys->facebook_access_token)){
			$face_p = 5;
		}
			  
		if(!empty($apiKeys->youtube_channel_id) && !empty($apiKeys->youtube_api_key)){ 
			$youtube_p = 5;
		}			  
		
		if(!empty($apiKeys->twitter_user_name) && !empty($apiKeys->twitter_consumer_key) && !empty($apiKeys->twitter_consumer_secret) && !empty($apiKeys->twitter_access_token) && !empty($apiKeys->twitter_access_token_secret)){ 
			$twitter_p = 5;
		}
	
	}
	
	
	
	
	
?>


 <div class="container">
    <div class="row text-center">
	<div class="col-md-12">
      <div class="button-group filters-button-group social-button">
	  	  <ul>
			  <li><a href="javascript:void(0)"  data-filter=".ALL" class="all-social"  type="ALL"><?php echo $this->query_model->getStaticTextTranslation('all'); ?>
</a></li>
			  
			   <?php if(!empty($apiKeys->google_plus_id) && !empty($apiKeys->google_plus_api_key)){ ?>
			 	 <li><a href="javascript:void(0)" data-filter=".googleplus" class="socialButton" type="googleplus"><i class="fa fa-google-plus"></i></a></li>
			  <?php } ?>
			 
			  <?php if(!empty($apiKeys->facebook_user_id) && !empty($apiKeys->facebook_access_token)){ ?>
			  <li><a href="javascript:void(0)" data-filter=".facebook" class="socialButton" type="facebook"><i class="fa fa-facebook"></i></a></li>
			  <?php } ?>
			  
			  <?php if(!empty($apiKeys->youtube_channel_id) && !empty($apiKeys->youtube_api_key)){ ?>
			  <li><a href="javascript:void(0)" data-filter=".youtube" class="socialButton" type="youtube"><i class="fa fa-play"></i></a></li>
			  <?php } ?>
			  
			  <?php if(!empty($apiKeys->twitter_user_name) && !empty($apiKeys->twitter_consumer_key) && !empty($apiKeys->twitter_consumer_secret) && !empty($apiKeys->twitter_access_token) && !empty($apiKeys->twitter_access_token_secret)){ ?>
			  <li><a id="twitter" href="javascript:void(0)" data-filter=".twitter" class="socialButton" type="twitter"><i class="fa fa-twitter"></i></a></li>
			  <?php } ?>
			  
			  <li>
				<input type="search" class="search-box quicksearch" placeholder="Search">
				<span><i class="fa fa-search"></i></span> </li>
        </ul>
         
        </div>
	  
	  <div class="social-list" id="social-news">
			<ul id="all_elements">
		<!--- GOOGLE PLUS POSTS ----->
		<?php 
			if(!empty($googlePlus['items'])){
				$a = 1;
				foreach($googlePlus['items'] as $googlePlus){
				$hidePosts = 'showPosts';
				if($a > 0){ $hidePosts = 'hidePosts'; }
		?>
          <li class="social_items <?= $hidePosts; ?>  googleplus posts_<?= $a ?> " number="<?= $a ?>"  data-category="googleplus" >
            <div class="content-social">
             <?php if(!empty($googlePlus['object']['attachments'])){ ?>
			  <div class="img-s"> 
			  	 <img src="<?php echo $googlePlus['object']['attachments'][0]['fullImage']['url']; ?>"   class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo $googlePlus['actor']['displayName']; ?>" style="min-height:130px;"> 
				</div>
			  <?php } ?>
              <div class="<?php if(!empty($googlePlus['object']['attachments'])){ echo 'txt'; } else { echo 'padding-set';} ?>">
                <p>
				<?php 	
						$googlePlus_content = $googlePlus['title'];
						if(strlen($googlePlus['title'])> 100){
							$googlePlus_content = substr($googlePlus['title'],0,100);
							$googlePlus_content = $googlePlus_content;
						}
						echo $googlePlus_content;
				?>
				</p>
				<?php if(!empty($googlePlus['object']['attachments'])){ ?>
                <a href="<?php echo $googlePlus['object']['attachments'][0]['url']; ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a>
				<?php }else{ ?>
				<a href="<?php echo $googlePlus['url']; ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a>
				<?php } ?>
			 </div>
              <div class="user">
                <h3><a href="javascript:void(0);"><?php echo $googlePlus['actor']['displayName']; ?></a></h3>
                <p><?php echo date("M d", strtotime($googlePlus['published'])); ?></p>
              </div>
            </div>
            <div class="icon icon-g"> <i class="fa fa-google-plus"></i> </div>
          </li>
		<?php $a++; } } ?>
		
		<!--- TWITTER POSTS --->
		<?php if(!empty($apiKeys->twitter_user_name) && !empty($apiKeys->twitter_consumer_key) && !empty($apiKeys->twitter_consumer_secret) && !empty($apiKeys->twitter_access_token) && !empty($apiKeys->twitter_access_token_secret)){ ?>
		<?php 
			if(!empty($twitterss)){
				$b = 1;
				foreach($twitterss as $twitter_post){
				$hidePosts = 'showPosts';
				if($b > 0){ $hidePosts = 'hidePosts'; }
		?>
          <li class="social_items <?= $hidePosts; ?>  twitter posts_<?= $b ?>" number="<?= $b ?>"  data-category="twitter">
            <div class="content-social">
			  <?php  if(isset($twitter_post->entities->media[0]->media_url_https)){ ?>
			  <div class="img-s"> 
			  	<img src="<?php echo $twitter_post->entities->media[0]->media_url_https;?>" class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo $twitter_post->user->name; ?>" style="min-height:130px;"> 
				</div>
			  <?php } ?>
              <div class="txt <?php  if(!isset($twitter_post->entities->media[0]->media_url_https)){ echo 'padding-set'; } ?>">
                <p>
				<?php 	
						$twitter_content = $twitter_post->text;
						if(strlen($twitter_post->text)> 100){
							$twitter_content = substr($twitter_post->text,0,100);
							$twitter_content = $twitter_content;
						}
						echo $twitter_content;
				?></p>
               <a href="<?php echo 'https://twitter.com/'.$twitter_post->user->screen_name.'/status/'.$twitter_post->id_str; ?><?php //if(isset($twitter_post->entities->media['0']->expanded_url)){ echo $twitter_post->entities->media['0']->expanded_url; } elseif(isset($twitter_post->entities->urls['0']->expanded_url)) { echo $twitter_post->entities->urls['0']->expanded_url; } else { echo 'javascript:void(0)'; }  ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a>
				</div>
              <div class="user">
                <h3> <a href="<?php echo 'https://twitter.com/'.$twitter_post->user->screen_name; ?>" target="_blank"><?php echo  $twitter_post->user->name; ?></a></h3>
                <p>@ <a href="<?php echo 'https://twitter.com/'.$twitter_post->user->screen_name; ?>" target="_blank"><?php echo  $twitter_post->user->screen_name; ?></a> <?php echo date("M d", strtotime($twitter_post->created_at)); ?></p>
              </div>
            </div>
            <div class="icon icon-t"> <i class="fa fa-twitter"></i> </div>
          </li>
		<?php $b++; } } ?>
		<?php } ?>
		<!--- FACEBOOK POSTS ---->
		<?php 
			// Code for FaceBook
			if(!empty($facebook['data'])){
				$c = 1;
				foreach($facebook['data'] as $facebooks){
					$hidePosts = 'showPosts';
					if($c > 0){ $hidePosts = 'hidePosts'; }
		?>
          <li class="social_items 2__ <?= $hidePosts; ?>  facebook posts_<?= $c ?>" number="<?= $c ?>"  data-category="facebook">
            <div class="content-social">
               <!--- jiten 2 sep Start-->
             <?php if(isset($facebooks['attachments']['data'][0]['media']['image']['src'])){ ?>
			   <div class="img-s">
			  	 <img src="<?php echo $facebooks['attachments']['data'][0]['media']['image']['src']; ?>" class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo isset($facebooks['from']['name']) ? $facebooks['from']['name'] : ''; ?>" style="min-height:130px;">
				</div>
			 <?php }elseif(isset($facebooks['attachments']['data'][0]['subattachments']['data'][0]['media']['image']['src'])){ ?>
			 			<div class="img-s">
			 			 <img src="<?php echo $facebooks['attachments']['data'][0]['subattachments']['data'][0]['media']['image']['src']; ?>" class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo isset($facebooks['from']['name']) ? $facebooks['from']['name'] : ''; ?>" style="min-height:130px;">
						</div>
			 <?php } ?>
			 
			 <!--- jiten 2 sep End-->

              <div class=" <?php  if(isset($facebooks['attachments']['data'][0]['media']['image']['src']) || isset($facebooks['attachments']['data'][0]['subattachments']['data'][0]['media']['image']['src'])){ echo 'txt'; }else{ echo 'text padding-set'; } ?>">
                <p>
				<?php if(isset($facebooks['message'])){ 
						
							$facebook_content = $facebooks['message'];
							if(strlen($facebooks['message'])> 100){
								$facebook_content = substr($facebooks['message'],0,100);
								$facebook_content = $facebook_content;
							}
							echo $facebook_content;
					} 
				?></p>
                <a href="<?php if(isset($facebooks['link'])){ echo $facebooks['link']; }elseif(isset($facebooks['attachments']['data'][0]['target']['url'])){ echo $facebooks['attachments']['data'][0]['target']['url']; } else { echo isset($facebooks['from']['id']) ? 'https://www.facebook.com/'.$facebooks['from']['id'] : '';} ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a> </div>
              <div class="user">
			  <?php if(isset($facebooks['from'])){ ?>
                <h3><a href="https://www.facebook.com/<?=$facebooks['from']['id'] ?>" target="_blank"><?php echo $facebooks['from']['name']; ?></a></h3>
			  <?php } ?>
                <p><?php echo date("M d", strtotime($facebooks['created_time'])); ?></p>
              </div>
            </div>
            <div class="icon icon-fb"> <i class="fa fa-facebook"></i> </div>
          </li>
		<?php $c++; } } ?>
		
		<!---- YOUTUBE VIDEOS ---->
		<?php 
			if(!empty($youtubeDetails)){
				$d = 1;
				foreach($youtubeDetails as $youtube_video){	
					$hidePosts = 'showPosts';
					if($d > 0){ $hidePosts = 'hidePosts'; }
		?>
          <li class="social_items <?= $hidePosts; ?>  youtube posts_<?= $d ?>" number="<?= $d ?>"  data-category="youtube">
             <div class="content-social">
              <div class="img-s">
			  	<img src="<?php echo $youtube_video['thumbnail_url']; ?>" class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo $youtube_video['title']; ?>">
			  </div>
              <div class="txt">
                <p>
				<?php 		$youtube_video_content = $youtube_video['title'];
							if(strlen($youtube_video['title'])> 100){
								$youtube_video_content = substr($youtube_video['title'],0,100);
								$youtube_video_content = $youtube_video_content;
							}
							echo $youtube_video_content;
				?>
				</p>
                <a href="<?php echo 'https://www.youtube.com/watch?v='.$youtube_video['video_id']; ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a> </div>
              <div class="user">
                <h3><?php echo $youtube_video['author_name']; ?></h3>
                <p>Jan 15</p>
              </div>
            </div>
            <div class="icon icon-fb"> <i class="fa fa-youtube"></i> </div>
          </li>
		<?php $d++; } } ?>
		
		
		
		
		
		
		
		
		
		
		<!----------- ALL -------------->
		
		
		
		<!--- TWITTER POSTS --->
		<?php if(!empty($apiKeys->twitter_user_name) && !empty($apiKeys->twitter_consumer_key) && !empty($apiKeys->twitter_consumer_secret) && !empty($apiKeys->twitter_access_token) && !empty($apiKeys->twitter_access_token_secret)){ ?>
		<?php 
			if(!empty($twitterss)){
				$b = 1;
				foreach($twitterss as $twitter_post){
				$hidePosts = 'showPosts';
				if($b > $twitter_p){ $hidePosts = 'hidePosts'; }
				//echo '<pre>'; print_r($twitter_post); die;
		?>
          <li class="social_items <?= $hidePosts; ?>  ALL posts_<?= $b ?>" number="<?= $b ?>"  data-category="twitter" date_filter="<?php echo strtotime($twitter_post->created_at); ?>">
		  	<h2 style="display:none"><?php echo strtotime($twitter_post->created_at); ?></h2>
            <div class="content-social">
			  	<?php  if(isset($twitter_post->entities->media[0]->media_url_https)){ ?>
			  <div class="img-s"> 
			  	<img src="<?php echo  $twitter_post->entities->media[0]->media_url_https;?>" class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo $twitter_post->user->name; ?>" style="min-height:130px;"> 
				</div>
				<?php } ?>
              <div class="txt <?php  if(!isset($twitter_post->entities->media[0]->media_url_https)){ echo 'padding-set'; } ?>">
                <p>
				<?php 	
						$twitter_content = $twitter_post->text;
						if(strlen($twitter_post->text)> 100){
							$twitter_content = substr($twitter_post->text,0,100);
							$twitter_content = $twitter_content;
						}
						echo $twitter_content;
				?></p>
                <a href="<?php echo 'https://twitter.com/'.$twitter_post->user->screen_name.'/status/'.$twitter_post->id_str; ?><?php //if(isset($twitter_post->entities->media['0']->expanded_url)){ echo $twitter_post->entities->media['0']->expanded_url; } elseif(isset($twitter_post->entities->urls['0']->expanded_url)) { echo $twitter_post->entities->urls['0']->expanded_url; } else { echo 'javascript:void(0)'; }  ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a>
				</div>
              <div class="user">
                <h3> <a href="<?php echo 'https://twitter.com/'.$twitter_post->user->screen_name; ?>" target="_blank"><?php echo  $twitter_post->user->name; ?></a></h3>
                <p>@ <a href="<?php echo 'https://twitter.com/'.$twitter_post->user->screen_name; ?>" target="_blank"><?php echo  $twitter_post->user->screen_name; ?></a> <?php echo date("M d", strtotime($twitter_post->created_at)); ?></p>
              </div>
            </div>
            <div class="icon icon-t"> <i class="fa fa-twitter"></i> </div>
          </li>
		<?php $b++; } } ?>
		<?php } ?>
		<!--- FACEBOOK POSTS ---->
		<?php 
			// Code for FaceBook
			if(!empty($facebook['data'])){
				$c = 1;
				foreach($facebook['data'] as $facebooks){
					$hidePosts = 'showPosts';
					if($c > $face_p){ $hidePosts = 'hidePosts'; }
		?>
          <li class="social_items 1__ <?= $hidePosts; ?>  ALL posts_<?= $c ?>" number="<?= $c ?>"  data-category="facebook" date_filter="<?php echo strtotime($facebooks['created_time']); ?>">
		  <h2 style="display:none"><?php echo strtotime($facebooks['created_time']); ?></h2>
            <div class="content-social">
               <!--- jiten 2 sep Start-->
             <?php if(isset($facebooks['attachments']['data'][0]['media']['image']['src'])){ ?>
			   <div class="img-s">
			  	 <img src="<?php echo $facebooks['attachments']['data'][0]['media']['image']['src']; ?>" class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo isset($facebooks['from']['name']) ? $facebooks['from']['name'] : ''; ?>" style="min-height:130px;">
				</div>
			 <?php }elseif(isset($facebooks['attachments']['data'][0]['subattachments']['data'][0]['media']['image']['src'])){ ?>
			 			<div class="img-s">
			 			 <img src="<?php echo $facebooks['attachments']['data'][0]['subattachments']['data'][0]['media']['image']['src']; ?>" class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo isset($facebooks['from']['name']) ? $facebooks['from']['name'] : ''; ?>" style="min-height:130px;">
						</div>
			 <?php } ?>
			 
			 <!--- jiten 2 sep End-->

              <div class=" <?php  if(isset($facebooks['attachments']['data'][0]['media']['image']['src']) || isset($facebooks['attachments']['data'][0]['subattachments']['data'][0]['media']['image']['src'])){ echo 'txt'; }else{ echo 'text padding-set'; } ?>">
                <p>
				<?php if(isset($facebooks['message'])){ 
						
							$facebook_content = $facebooks['message'];
							if(strlen($facebooks['message'])> 100){
								$facebook_content = substr($facebooks['message'],0,100);
								$facebook_content = $facebook_content;
							}
							echo $facebook_content;
					} 
				?></p>
                <a href="<?php if(isset($facebooks['link'])){ echo $facebooks['link']; }elseif(isset($facebooks['attachments']['data'][0]['target']['url'])){ echo $facebooks['attachments']['data'][0]['target']['url']; } else { echo isset($facebooks['from']['id']) ? 'https://www.facebook.com/'.$facebooks['from']['id'] : ''; } ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a> </div>
              <div class="user">
			  <?php if(isset($facebooks['from'])){ ?>
                <h3><a href="https://www.facebook.com/<?=$facebooks['from']['id'] ?>" target="_blank"><?php echo $facebooks['from']['name']; ?></a></h3>
			  <?php } ?>
                <p><?php echo date("M d", strtotime($facebooks['created_time'])); ?></p>
              </div>
            </div>
            <div class="icon icon-fb"> <i class="fa fa-facebook"></i> </div>
          </li>
		<?php $c++; } } ?>
		
		<!---- YOUTUBE VIDEOS ---->
		<?php 
			if(!empty($youtubeDetails)){
				$d = 1;
				foreach($youtubeDetails as $youtube_video){
					$hidePosts = 'showPosts';
					if($d >  $youtube_p){ $hidePosts = 'hidePosts'; }
		?>
          <li class="social_items <?= $hidePosts; ?>  ALL posts_<?= $d ?>" number="<?= $d ?>"  data-category="youtube">
             <div class="content-social">
              <div class="img-s">
			  	<img src="<?php echo $youtube_video['thumbnail_url']; ?>" class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo $youtube_video['title']; ?>">
			  </div>
              <div class="txt">
                <p>
				<?php 		$youtube_video_content = $youtube_video['title'];
							if(strlen($youtube_video['title'])> 100){
								$youtube_video_content = substr($youtube_video['title'],0,100);
								$youtube_video_content = $youtube_video_content;
							}
							echo $youtube_video_content;
				?>
				</p>
                <a href="<?php echo 'https://www.youtube.com/watch?v='.$youtube_video['video_id']; ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a> </div>
              <div class="user">
                <h3><?php echo $youtube_video['author_name']; ?></h3>
                <p>Jan 15</p>
              </div>
            </div>
            <div class="icon icon-fb"> <i class="fa fa-youtube"></i> </div>
          </li>
		<?php $d++; } } ?>
		
		
		<!--- GOOGLE PLUS POSTS ----->
		<?php //echo '<pre>'; print_r($RecentgooglePlus); die;
			if(!empty($RecentgooglePlus)){
				$a = 1;
				foreach($RecentgooglePlus['items'] as $googlePlus){
				$hidePosts = 'showPosts';
				if($a > $google_p){ $hidePosts = 'hidePosts'; } 
		?>
          <li style="DOJO1" class="social_items <?php echo $hidePosts; ?>  ALL posts_<?= $a ?> " number="<?= $a ?>"  data-category="googleplus" date_filter="<?php echo strtotime($googlePlus['published']); ?>">
		  <h2 style="display:none"><?php echo strtotime($googlePlus['published']); ?></h2>
            <div class="content-social">
              <?php if(!empty($googlePlus['object']['attachments'])){ ?>
			  <div class="img-s"> 
			  	 <img src="<?php echo $googlePlus['object']['attachments'][0]['fullImage']['url']; ?>"   class="img-responsive fancybox"  data-fancybox-group="gallery" title="<?php echo $googlePlus['actor']['displayName']; ?>" style="min-height:130px;"> 
				</div>
			<?php } ?>
			  
              <div class="<?php if(!empty($googlePlus['object']['attachments'])){ echo 'txt'; } else { echo 'txt';} ?>">
                <p>
				<?php 	
						$googlePlus_content = $googlePlus['title'];
						if(strlen($googlePlus['title'])> 100){
							$googlePlus_content = substr($googlePlus['title'],0,100);
							$googlePlus_content = $googlePlus_content;
						}
						echo $googlePlus_content;
				?>
				</p>
				<?php if(!empty($googlePlus['object']['attachments'])){ ?>
                <a href="<?php echo $googlePlus['object']['attachments'][0]['url']; ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a>
				<?php }else{ ?>
				<a href="<?php echo $googlePlus['url']; ?>" target="_blank"><?php echo $this->query_model->getStaticTextTranslation('read_more'); ?></a>
				<?php } ?>
			 </div>
              <div class="user">
                <h3><a href="javascript:void(0);"><?php echo $googlePlus['actor']['displayName']; ?></a></h3>
                <p><?php echo date("M d", strtotime($googlePlus['published'])); ?></p>
              </div>
            </div>
            <div class="icon icon-g"> <i class="fa fa-google-plus"></i> </div>
          </li>
		<?php $a++; } } ?>
		
        </ul>
		
 </div>
	  <input type="hidden" class="checkPostType" value="ALL" />
	  <input type="hidden" class="countTwitterSocialPosts" value="5"  />
	  <input type="hidden" class="countFacebookSocialPosts" value="5"  />
	  <input type="hidden" class="countYoutubeSocialPosts" value="5"  />
	  <input type="hidden" class="countGooglePlusSocialPosts" value="5"  />
	  <input type="hidden" class="countALLPosts" value="10"  />
     <div class="text-center showMoreSocialPosts"> <a href="javascript:void(0);" class=" load-more"><?php echo $this->query_model->getStaticTextTranslation('load_more'); ?>
</a> </div>
    </div>
  </div>
  </div>
  
 <script>

	$( function() {
  // quick search regex
  var qsRegex;
  var buttonFilter;
  
  // init Isotope
  var $container = $('.social-list').isotope({
    itemSelector: '.social_items',
    layoutMode: 'fitRows',
    filter: function() {
      console.log('filtering');
      var $this = $(this);
      var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
      var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
      return searchResult && buttonResult;
    }
  });

   // store filter for each group
    var filterFns = {
    // show if number is greater than 50
    numberGreaterThan50: function() {
      var number = $(this).find('.number').text();
      return parseInt( number, 10 ) > 50;
    },
    // show if name ends with -ium
    ium: function() {
      var name = $(this).find('.name').text();
      return name.match( /ium$/ );
    }
  };
  var filters = {};

  $('.filters-button-group').on( 'click', 'a', function() {
  	
 	$('.checkPostType').val($( this ).attr('type'));
    var filterValue = $( this ).attr('data-filter');
	
	/*if(filterValue == '*'){
		$('.showMoreSocialPosts').hide();
	} else{
		$('.showMoreSocialPosts').show();
	}*/
    // use filterFn if matches value
    filterValue = filterFns[ filterValue ] || filterValue;
    $container.isotope({ filter: filterValue });
  });
  
  // use value of search field to filter
  var $quicksearch = $('.quicksearch').keyup( debounce( function() {
    qsRegex = new RegExp( $quicksearch.val(), 'gi' );
    $container.isotope();
  }) );

  
    // change is-checked class on buttons
  $('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });
  
  
});

// debounce so filtering doesn't happen every millisecond
function debounce( fn, threshold ) {
  var timeout;
  return function debounced() {
    if ( timeout ) {
      clearTimeout( timeout );
    }
    function delayed() {
      fn();
      timeout = null;
    }
    setTimeout( delayed, threshold || 100 );
  };
}
</script>  