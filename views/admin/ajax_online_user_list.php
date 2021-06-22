<?php 
	if(!empty($users_list)){							
		$n = 1;
		foreach($users_list as $user):
		?>
		
		<tr class="online_user_data little_row_<?php echo $user->id; ?>">
			<td><label class="ckbox"><input type="checkbox" class="checkbox_list" name="user_ids[<?php echo $user->id ?>]" value="<?php echo $user->id ?>"><span>&nbsp;</span></label></td>
			<td><?=$n?></td>
			<td><?=$user->firstname?></td>
			<td><?=$user->lastname?></td>
			<td><?=$user->email?></td>
			<td><?=ucfirst($user->signup_type)?></td>
			<td><?=$user->phone?></td>
			<?php if($multiLocation[0]->field_value == 1){ ?>
			<td><?=$user->location?></td>
			<?php } ?>
			<td><?php echo date('M d, Y ', strtotime($user->created)); ?></td>
			<td class="table_action_col">
			
			<div class="manager-item-opts">
						<nav class="nav">
							 
							  <a href="javascript:void(0)" class="badge badge-primary edit_onlinedojo_user lb-preview " user_id="<?php echo $user->id; ?>" popup_title="<?php echo "Edit User: ". $user->firstname.' '.$user->lastname ?>"> Edit</a>
							  
							  <a id="delitem_<?=$user->id?>" class="delete_item badge badge-primary  ajax_record_delete" title='Delete <?=$user->email;?>' data-toggle="modal" data-target="#popupDeleteRecord" item_id="<?=$user->id;?>"   table_name="tbl_onlinedojo_users" item_title="<?=$user->firstname.' '.$user->lastname;?>" section_type="little_row">Delete</a>
							  
							  <a href="javascript:void(0)" id="unpub_<?=$user->id; ?>" class="ajax_record_publish"  table_name="tbl_onlinedojo_users"  is_new="0">
				<div class="az-toggle az-toggle-success alternate_full_width_toogle toogle_btn <?php echo ($user->published == 1) ? 'on' : '';?>" publish_type="<?php echo ($user->published == 1) ? 0 : 1;?>"><span></span>
				<input type="hidden" name="publish_type" value="<?php echo ($user->published == 1) ? 0 : 1;?>" class="publish_type" />
				</div></a>
								
						</nav>

			</div>
							
							
			
			
				<?php /*if($user->published == 1){?>
				<div class="action_btn active">
				<a id="unpub_<?=$user->id; ?>" class="unpublish  "   user_status="0"  title="Inactive <?=$user->firstname?>">Active</a> 
				<input type="hidden" name="publish_type" value="0" class="publish_type user_publish_type" />
				</div>
				<?php }else{ ?>
				<div class="action_btn inactive">
				<input type="hidden" name="publish_type" value="1" class="publish_type user_publish_type" />
				<a id="unpub_<?=$user->id; ?>" class="unpublish " user_status="1" title="Active <?=$user->firstname?>">Inactive</a> 
				</div>
				<?php } */ ?>
			
			
			<!--<div class="action_btn">
				
			</div> -->
			</td>
				
				
				
			
		</tr>
		
		<?php 
				$n++; 
				endforeach;
			}else{
				echo '<tr><td colspan="10" style="text-align:center"><b>No result found..</b></td></tr>';
			}
		?>	