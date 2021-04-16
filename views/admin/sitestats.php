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
        // we will get a string (better browser support) and validate
        // if it is an int - set the height of the iframe #my-iframe-id
        if (e.data === parseInt(e.data)) 
            document.getElementById('myFrame').height = e.data + "9px";
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
<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Site Statistics</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder">
	<div class="gen-panel-holder"  style="width: 100% !important;">
	<div class="gen-panel">
		
		<div class="panel-body">
		<div class="panel-body-holder">
		<div class="form-holder">
	<div class="mb-3 main-content-label page_main_heading">Site Statistics</div>
    <?php
		//echo $statslink;
		if($statslink && substr($statslink, 0, 4) == 'http'){
	?>
<iframe id='myFrame' width='100%'  scrolling='no' src="<?=$statslink?>" ></iframe>
  		
  		<noframes><body>Please follow <a href="<?=$statslink?>">this link</a>!</body></noframes>

    <?php		
		}
	?>
    
	</div>

		</div>

		</div>

	</div>

	</div>

</div>
</div>
</div>
</div>
<!------------ recent items ----------------->
<?php $this->load->view("admin/include/footer");?>
