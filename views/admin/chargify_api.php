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
.full-container {
width: 100% !important;
margin: 0 !important;
margin-top: 0 !important;
}

.page-container {
width: 100% !important;
margin: 0;
padding: 0;
border: none;
border-top: 0;
background: #ffffff;
box-sizing: border-box;
}
.page-container h2{ text-align:center}
.page-container p{ text-align:center}
.page-container p a{ text-align:center; border-radius:20px; -o-border-radius:20px;-ms-border-radius:20px;-webkit-border-radius:20px;-moz-border-radius:20px; display:inline-block; padding:5px 15px; background:#EF1616;color:#fff;}
.pull-left{ float:left;}
.pull-right{ float:right;}
</style>

<div class="az-content-body-left advanced_page custom_full_page" >
	<div class="az-content-header d-block d-md-flex">
		<div class="az-dashboard-one-title">
			<div>
			  <h2 class="az-dashboard-title">Billing</h2>
			</div>
			
		  </div>
	  </div>
	   <div class="row row-sm program-cat-page">

          <div class="col-sm-12 col-xl-12 az-content-body-contacts"  >
			<div class="card pd-sm-20 edit-form">
			
<div class="gen-holder  full-container">
	<div class="gen-panel-holder page-container" >
	<!-- <h2 class="pull-left">Billing</h2> -->
	<div class="mb-3 main-content-label page_main_heading">Billing</div>
	<?php if(!empty($subscriptionUrl)){ ?>
	<!-- <p class="text-center"> <a target="_blank" href="<?=$subscriptionUrl?>">View Main Site </a></p> -->
	<iframe id='myFrame' width='100%' scrolling='no' src="<?=$subscriptionUrl?>" ></iframe>
  		
  	<noframes><body>Please follow <a href="<?=$subscriptionUrl?>">this link</a>!</body></noframes>
    <?php }else{ ?>
	
	<h4 style="margin:0px; text-align:center"> Page Not Found </h4>
	
	<?php } ?>
	
	
	</div>


	</div>

</div>
</div>
</div>
</div>
<!------------ recent items ----------------->
<?php //$this->load->view("admin/include/footer");?>
