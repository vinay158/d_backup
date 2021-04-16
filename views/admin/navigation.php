<?php $this->load->view("admin/include/header"); ?>


<?php

$navs = array();

foreach($tblmeta as $k => $v){
	$navs[$v['id']] = $v;
}

// pre($navs);exit;

function displayChildren($children, $navs){
	// pre($navs);exit;
	
	$string = '<ol class="dd-list">';
	foreach($children as $k => $v){
		
		$string .= '<li class="dd-item dd3-item" data-id="'.$v->id.'">';
		
		$string .= '<div class="dd-handle dd3-handle" style="height:56px;line-height:45px;">Drag</div>
					<div class="dd3-content" style="height:56px">
						<span class="display-link-name" data-id="<?=$v->id?>" style="font-size:20px;line-height:40px;">
							<input type="checkbox" value="'.$v->id.'" name="title" class="pageManagement" '.($navs[$v->id]['display_status'] == 'D' ? 'checked="checked"' : '').'>
							<span>'.$navs[$v->id]['page_label'].'</span>
							<a href="javascript:;" class="edit-link_name">[ Edit ]</a>
						</span>
						<span class="display-form" data-id="'.$v->id.'" style="display:none;">
							<form action="javascript:;">
								<a href="javascript:;"  class="cancel-link_name">[ Cancel ]</a>
								<input type="text" name="line_name" value="'.$navs[$v->id]['page_label'].'" class="field" style="width:250px;" />
								<button type="submit" name="update" value="Save" class="btn-bootstrap-default btn-save-now">Save</button>
							</form>
						</span>
					</div>';
		
		if(!empty($v->children)){
			$string .= displayChildren($v->children, $navs);
		}
		
		$string .= '</li>';
	}
	$string .= '</ol>';
	return $string;
}

	
?>









	
		
	










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

</style>



<style type="text/css">

.cf:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
* html .cf { zoom: 1; }
*:first-child+html .cf { zoom: 1; }

html { margin: 0; padding: 0; }
/*
body { font-size: 100%; margin: 0; padding: 1.75em; font-family: 'Helvetica Neue', Arial, sans-serif; }
*/
h1 { font-size: 1.75em; margin: 0 0 0.6em 0; }

a { color: #2996cc; }
a:hover { text-decoration: none; }

p { line-height: 1.5em; }
.small { color: #666; font-size: 0.875em; }
.large { font-size: 1.25em; }

/**
 * Nestable
 */

.dd { position: relative; display: block; margin: 0; padding: 0;  list-style: none; font-size: 13px; line-height: 20px;width:100% !impotant; }

.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
.dd-list .dd-list { padding-left: 30px; }
.dd-collapsed .dd-list { display: none; }

.dd-item,
.dd-empty,
.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

.dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd-handle:hover { color: #2ea8e5; background: #fff; }

.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }

.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                         -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
}

.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-handle {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}

/**
 * Nestable Extras
 */

.nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; }

#nestable-menu { padding: 0; margin: 20px 0; }

#nestable-output,
#nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }

#nestable2 .dd-handle {
    color: #fff;
    border: 1px solid #999;
    background: #bbb;
    background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
    background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);
    background:         linear-gradient(top, #bbb 0%, #999 100%);
}
#nestable2 .dd-handle:hover { background: #bbb; }
#nestable2 .dd-item > button:before { color: #fff; }

@media only screen and (min-width: 700px) {

    .dd { float: left; width: 100%; }
    .dd + .dd { margin-left: 2%; }

}

.dd-hover > .dd-handle { background: #2ea8e5 !important; }

/**
 * Nestable Draggable Handles
 */

.dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd3-content:hover { color: #2ea8e5; background: #fff; }

.dd-dragel > .dd3-item > .dd3-content { margin: 0; }

.dd3-item > button { margin-left: 30px; }

.dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
    border: 1px solid #aaa;
    background: #ddd;
    background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
    background:         linear-gradient(top, #ddd 0%, #bbb 100%);
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}
.dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
.dd3-handle:hover { background: #ddd; }

    </style>


<div class="gen-holder">
	<div class="gen-panel">
		<div class="panel-title">
			<div class="panel-title-name">Navigation Management</div>
			
		</div>
		<div class="panel-body">
			<div class="panel-body-holder">
			
				<div style="width:100%;height:40px;margin-bottom:10px;">
					<a href="<?=base_url()?>admin/navigation/add" class="btn-bootstrap-default" style="float:left;">Add Navigation</a>
					<div style="float:right;background:#F6CECE;color:#DF0101;font-weight:bold;padding:20px;border:1px solid #F78181;-webkit-border-radius: 8px 8px 8px 8px;border-radius: 8px 8px 8px 8px;">
						Note: Every move(Drag) of navigation is automatically saved.
					</div>
				</div>
				<div id="nestable" class="manager-items custom">
					
					<?php /*foreach($tblmeta as $k => $v): ?>
						<div class="form-light-holder">
								<span class="display-link-name" data-id="<?=$v['id']?>">
									<input type="checkbox" value="<?=$v['id']?>" name="title" class="pageManagement" <?=$v['display_status'] == 'D' ? 'checked="checked"' : ''?>>
									<span><?=$v['page_label']?></span>
									<a href="javascript:;" class="edit-link_name">[ Edit ]</a>
								</span>
								<span class="display-form" data-id="<?=$v['id']?>" style="display:none;">
									<form action="javascript:;">
										<a href="javascript:;"  class="cancel-link_name">[ Cancel ]</a>
										<input type="text" name="line_name" value="<?=$v['page_label']?>" class="field" />
										<button type="submit" name="update" value="Save" class="btn-save"></button>
									</form>
								</span>

						</div>
					<?php endforeach;*/ ?>
					
					
					
					<div class="cf nestable-lists">

						<div class="dd" id="nestable3">
						
						<?php
							echo displayChildren($nav_list, $navs);
						?>
						
						<?php /*
							<ol class="dd-list">
							<?php foreach($tblmeta as $k => $v): ?>
								<li class="dd-item dd3-item" data-id="<?=$v['id']?>">
									<div class="dd-handle dd3-handle" style="height:56px;line-height:45px;">Drag</div>
									<div class="dd3-content" style="height:56px">
										<span class="display-link-name" data-id="<?=$v['id']?>" style="font-size:20px;line-height:40px;">
											<input type="checkbox" value="<?=$v['id']?>" name="title" class="pageManagement" <?=$v['display_status'] == 'D' ? 'checked="checked"' : ''?>>
											<span><?=$v['page_label']?></span>
											<a href="javascript:;" class="edit-link_name">[ Edit ]</a>
										</span>
										<span class="display-form" data-id="<?=$v['id']?>" style="display:none;">
											<form action="javascript:;">
												<a href="javascript:;"  class="cancel-link_name">[ Cancel ]</a>
												<input type="text" name="line_name" value="<?=$v['page_label']?>" class="field" style="width:250px;" />
												<button type="submit" name="update" value="Save" class="btn-bootstrap-default btn-save-now">Save</button>
											</form>
										</span>
									</div>
								</li>
							<?php endforeach; ?>
							</ol>
						*/ ?>
						</div>

					</div>
					
					
				</div>
				
				
				
			</div>
		</div>
	</div>
</div>


<script>
$(document).ready(function(){
	$('.pageManagement').on('change', function(){
		// console.log($(this).is(':checked'));
		var me = $(this);
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: '<?=base_url()?>admin/navigation/active_page',
			data:{'status': me.is(':checked'),'id': me.val()},
			success:function(resp){
				alert(resp);
			}
		})
	});
	$('a.edit-link_name').on('click', function(){
		$(this).parent().hide();
		$(this).parent().next().slideDown();
	});
	$('a.cancel-link_name').on('click', function(){
		$(this).parent().parent().hide();
		$(this).parent().parent().prev().slideDown();
	});			
	$('button.btn-save-now').on('click', function(){
		var me = $(this);
		var val = me.prev().val();
		var id = me.parent().parent().data('id');
		
		$.ajax({
			dataType: 'JSON',
			type: 'POST',
			url: '<?=base_url()?>admin/navigation/change_link_name',
			data:{'val': val,'id': id},
			success:function(resp){
				alert(resp);
				me.parent().parent().prev().find('span').html(val);
				$('a.cancel-link_name').trigger('click');
				location.reload();
			}
		});
	});
	
	
});

$(window).load(function(){
	$('#admin_ext a').trigger('click'); 
})

</script>



<script src="<?=base_url()?>js/jquery.nestable.js"></script>
<script>

var pageLoaded = false;

$(document).ready(function(){
	
	function pushToArray(){
		var data = {};
		
		// for(var x=0;x<a.length;x++){
			// data[x] = {'id': a[x].id, 'children': []};
			// console.log(data[x]);
			// if(typeof a[x].children != "undefined"){
				// for(var y=0;y<(a[x].children).length;y++){
					// data[x].children[y] = {}a[x].children[y].id;
				// }
			// }
		// }
	}

	  var updateOutput = function(e)
    {
        var list   = e.length ? e : $(e.target),
            output = list.data('output');
        // if (window.JSON) {
            // output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
        // } else {
            // output.val('JSON browser support required for this demo.');
        // }
		
		var a = $('#nestable3').nestable('serialise');
		
		var data = a;
		
		if(!pageLoaded){
			console.log('wala muna');
			pageLoaded = true;
		}else{
			
			$.ajax({
				dataType: 'JSON',
				type: 'POST',
				url: '<?=base_url()?>admin/navigation/save_arrangement',
				data: {'data': data},
				success:function(resp){
					
					if(resp.bol == 'false' || resp.bol == false){
						alert('Error!!');
					}
					
				}
			});
		
		}
    };
	
	$(nestable3).nestable({
		group: 1
		// ,'serialize': function(e){
						// var data,
							// depth = 0,
							// list = this;
						// var step = function (level, depth) {
							// var array = [];
							// var items = level.children(list.options.itemNodeName);
							// items.each(function () {
								// var li = $(this); 
								// var sub = li.children(list.options.listNodeName);

								// var item = {};
								// $(li[0].attributes).each(function(){
									// var attrName = this.nodeName;
									// if(attrName.startsWith('data-')){
										// attrName = attrName.replace('data-','');
										// item[attrName] = this.nodeValue;
									// }
								// });

								// if (sub.length) {
									// item.children = step(sub, depth + 1);
								// }
								// array.push(item);
							// });
							// return array;
						// };
						// data = step(list.el.find(list.options.listNodeName).first(), depth);
						// return data;
					// }
	}).on('change', updateOutput);

	 updateOutput($('#nestable3').data('output', $('#nestable3-output')));
	
    // $('#nestable3').nestable(function(){
		// console.log('asdasd');
	// });

});
</script>


