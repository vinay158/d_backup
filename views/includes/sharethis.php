<?php
		$pageURL = 'http://';
		if (isset($_SERVER['HTTPS']) && filter_var($_SERVER['HTTPS'], FILTER_VALIDATE_BOOLEAN))
			$pageURL .= 'https://';
			
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
	?>
	
<!--<span class='st_sharethis_hcount' displayText='ShareThis'></span>
<span class='st_facebook_hcount' st_url="<?php echo $pageURL;?>" st_title="Share this on Facebook" displayText='Facebook'></span>
<span class='st_twitter_hcount' st_url="<?php echo $pageURL;?>" st_title="Share this on Twitter" displayText='Tweet'></span>
<span class='st_linkedin_hcount' displayText='LinkedIn'></span>
<span class='st_stumbleupon_hcount' st_url="<?php echo $pageURL;?>" st_title="Share this on StumbleUpon" displayText='StumbleUpon'></span>
<span class='st_pinterest_hcount' st_url="<?php echo $pageURL;?>" st_title="Share this on Pinterest" displayText='Pinterest'></span>
<span class='st_email_hcount' st_url="<?php echo $pageURL;?>" st_title="Share this" displayText='Email'></span>-->

<span class='st_sharethis_hcount'  st_url="<?php echo $pageURL;?>" st_title="Share this on Sharethis" displayText='ShareThis'></span>
<span class='st_facebook_hcount'  st_url="<?php echo $pageURL;?>" st_title="Share this on Facebook" displayText='Facebook'></span>
<span class='st_googleplus_hcount'  st_url="<?php echo $pageURL;?>" st_title="Share this on Google+" displayText='Google +'></span>
<span class='st_twitter_hcount'  st_url="<?php echo $pageURL;?>" st_title="Share this on Twitter" displayText='Tweet'></span>
<span class='st_tumblr_hcount'  st_url="<?php echo $pageURL;?>" st_title="Share this on Tumblr" displayText='Tumblr'></span>
<span class='st_stumbleupon_hcount'  st_url="<?php echo $pageURL;?>" st_title="Share this on StumbleUpon" displayText='StumbleUpon'></span>
<span class='st_linkedin_hcount'  st_url="<?php echo $pageURL;?>" st_title="Share this on LinkedIn" displayText='LinkedIn'></span>
<span class='st_email_hcount'  st_url="<?php echo $pageURL;?>" st_title="Share this on Email" displayText='Email'></span>