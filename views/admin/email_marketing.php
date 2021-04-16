<?php $this->load->view("admin/include/header"); ?>

<!---------- end head contents ---------------->
<!---------------wysiwyg editor script ------------>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>
<script src="<?=THEMEPATH;?>themes/global/ckeditor/ckeditor.js"></script>
	<script type="text/javascript">
    // browser compatibility: get method for event 
    // addEventListener(FF, Webkit, Opera, IE9+) and attachEvent(IE5-8)
    var myEventMethod = 
        window.addEventListener ? "addEventListener" : "attachEvent";
    // create event listener
    var myEventListener = window[myEventMethod];
    // browser compatibility: attach event uses onmessage
    var myEventMessage = 
        myEventMethod == "attachEvent" ? "onmessage" : "message";
    // register callback function on incoming message
    myEventListener(myEventMessage, function (e) {
		//alert(e.data);
        // we will get a string (better browser support) and validate
        // if it is an int - set the height of the iframe #my-iframe-id
        if (e.data === parseInt(e.data)) 
            document.getElementById('myFrame').height = (parseInt(e.data) * 3) + "px";
    }, false);
</script>
<script type="text/javascript">
    // all content including images has been loaded
    window.onload = function() {
        // post our message to the parent
        window.parent.postMessage(
            // get height of the content
            document.body.scrollHeight
            // set target domain
            ,"*"
        )
    };
</script>
<style type="text/css">
.full-container{width:98% !important; margin:0 1% !important; margin-top:3% !important;}
.page-container{width: 100% !important; margin:-28px auto 0; padding:0 20px 40px 20px; border:1px solid #dddddd; border-top:0; background:#ffffff; box-sizing:border-box;}
.page-container h2{ text-align:left}
.page-container p{ text-align:center}
.page-container p a{ text-align:center; border-radius:20px; -o-border-radius:20px;-ms-border-radius:20px;-webkit-border-radius:20px;-moz-border-radius:20px; display:inline-block; padding:5px 15px; background:#EF1616;color:#fff;}
.pull-left{ float:left;}
.pull-right{ float:right;}
.message{display:block; font-size:13px; font-weight:normal; color:red}
</style>
<div class="gen-holder  full-container">
	<div class="gen-panel-holder page-container" >
	<!--<h2 class="pull-left">Email Marketing <span class="message"><em>Note: The Token will expired in  60 minutes.</em></span></h2> -->
    <?php
		//echo $statslink;
		if($response == 1){
	?>
	
	<p class="text-center "> <a target="_blank" href="<?=$autoLoginUrl?>" target="_blank">Open Email Marketing Module in New Browser Window</a></p>
	
	<!--<p> Main site Url: <a href="<?=$autoLoginUrl?>" > <?=$autoLoginUrl?> </a> </p>-->
<iframe id='myFrame' width='100%' scrolling='no' src="<?=$autoLoginUrl?>" ></iframe>
  		
  		<noframes><body>Please follow <a href="<?=$autoLoginUrl?>">this link</a>!</body></noframes>

    <?php		
		}else{
			
			echo '<h4 style="margin:0px; text-align:center">'.$error_msg.'</h4>';
			
		}
	?>
    
	</div>



<br style="clear:both"/><br />
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
