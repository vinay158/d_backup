<?php $this->load->view("admin/include/header"); ?>

<script language="javascript" type="text/javascript" src="<?=THEMEPATH;?>themes/global/js/jquery-1.7.2.js"></script>

<style>
.panel-body-holder label {
    text-transform: uppercase;
	font-size: 12px;
    color: rgb(45,45,45);
    font-weight: normal;
    margin: 0;
    padding: 0;
	font-family: "Helvetica Neue", helvetica, sans-serif;
	display: block;
	background:transparent;
}

.btn-bootstrap-default{
	display: inline-block;
    padding: 4px 12px;
    margin-bottom: 0;
    font-size: 14px;
    line-height: 20px;
    color: #333333;
    text-align: center;
    text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
    vertical-align: middle;
    cursor: pointer;
    border: 1px solid #cccccc;
    border-bottom-color: #b3b3b3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
    -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    -moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
	color: #ffffff;
    text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
    background-color: #363636;
    background-image: -moz-linear-gradient(top, #444444, #222222);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#444444), to(#222222));
    background-image: -webkit-linear-gradient(top, #444444, #222222);
    background-image: -o-linear-gradient(top, #444444, #222222);
    background-image: linear-gradient(to bottom, #444444, #222222);
    background-repeat: repeat-x;
    border-color: #222222 #222222 #000000;
    border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
	text-decoration:none !important;
}
.btn-bootstrap-default:hover{
	color:#fff !important;
}


.form-light-holder h1{
	background:none !important;
	padding:0;
	font-size:14px;
}

.error_message{
	padding:20px;margin:20px;
	background:#F5A9BC;
	border:1px solid #F7819F;
	-webkit-border-radius: 10px 10px 10px 10px;
	border-radius: 10px 10px 10px 10px;
	color:#fff;
    font-size: 15px;
}


</style>

<div class="gen-holder">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Add Navigation</div>
			
		</div>
		<div class="panel-body">
			<div class="panel-body-holder">
			
				<div class="manager-items custom">
					
					<?php if(!empty($message)): ?>
						<div class="error_message">
							<?=$message?>
						</div>
					<?php endif; ?>
					
					<form action="" method="post" enctype="multipart/form-data" onsubmit="return fnCheckEmail();">
						<div class="form-light-holder">
							<h1>Title</h1>
							<input type="text" name="title" value="" class="field" placeholder="Title" required />
						</div>
						<div class="form-light-holder">
							<h1>Description</h1>
							<textarea name="desc"class="field" placeholder="Description" required ></textarea>
						</div>
						<div class="form-light-holder">
							<h1>keywords</h1>
							<input type="text" name="keywords" value="" class="field" placeholder="Keywords" required />
						</div>
						<div class="form-light-holder">
							<h1>slug</h1>
							<input type="text" name="slug" value="" class="field" placeholder="Slug" required />
						</div>
						<div class="form-light-holder">
							<h1>url</h1>
							<input type="text" name="url" value="" class="field" placeholder="Url" required />
						</div>
						<div class="form-light-holder">
							<h1>Controller Name</h1>
							<input type="text" name="page" value="" class="field" placeholder="Page" required />
						</div>
						<div class="form-light-holder">
							<h1>Page Name</h1>
							<input type="text" name="page_label" value="" class="field" placeholder="Page Label" required />
						</div>
						<!--
						<div class="form-light-holder">
							<h1>pos</h1>
							<input type="text" name="pos" value="" class="field" placeholder="Pos" required />
						</div>
						-->
						<div class="form-light-holder">
							<h1>Status</h1>
							<label style="width:100px;margin-top:5px;">
								<input type="radio" name="display_status" value="D" checked="checked" /> Display
							</label>
							<label style="width:100px;margin-top:5px;">
								<input type="radio" name="display_status" value="H" /> Hide
							</label>
						</div>
						<div class="form-light-holder">
							<h1></h1>
							
							<button class="btn-bootstrap-default">Submit</button>
							
						</div>
				
					
				</div>
			</div>
		</div>
	</div>
</div>


<script>
$(document).ready(function(){

	
	
});

$(window).load(function(){
	$('#admin_ext a').trigger('click'); 
})


</script>







