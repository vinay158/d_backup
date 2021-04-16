<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dojocarts_model extends CI_Model{
	
	var $table = 'tbl_dojocarts';
	

		function addCart(){
//echo '<pre>post'; print_R($_POST); die;
		
		$image_video = trim ($this->input->post('image_video'));
		$image_alt = $this->input->post('image_alt');
		$video_type = $this->input->post('video_type');
		$youtube_video = trim ($this->input->post('youtube_video'));
		$vimeo_video = trim ($this->input->post('vimeo_video'));

		$product_title = trim ($this->input->post('product_title'));
		$product_description = $this->input->post('product_description');
		$offer_title = $this->input->post('offer-title');
		$features = serialize($this->input->post('features'));
		//$features = serialize($_POST['features']);
		$offer_description = $this->input->post('offer_description');
		$payment_type = $this->input->post('payment_type');
		
		$upsale = (isset($_POST['upsale']) && !empty($_POST['upsale'])) ? $_POST['upsale'] : 0;
		$dojocart_item = (isset($_POST['dojocart_item']) && !empty($_POST['dojocart_item'])) ? $_POST['dojocart_item'] : 0;
		
		
		$show_price = $this->input->post('show_price');
		$price = $this->input->post('price');
		$show_quantity = $this->input->post('show_quantity');

		$sales_taxable = $this->input->post('sales_taxable');
		$sales_tax_main = !empty($_POST['sales_tax_main']) ? $_POST['sales_tax_main'] :0;
		$multi_item_sales_taxable = isset($_POST['multi_item_sales_taxable']) ? $_POST['multi_item_sales_taxable'] : 0;
		
		$show_term_condition = $this->input->post('show_term_condition');
		$term_condition = $this->input->post('term_condition');

		$meta_title = $this->input->post('meta_title');
		$meta_desc = $this->input->post('meta_desc');


		$published = $this->input->post('published');
		
		$override_logo = isset($_POST['override_logo']) ? $_POST['override_logo'] : 0;
		$money_back_img = isset($_POST['money_back_img']) ? $_POST['money_back_img'] : 0;
		$satisfaction_gurantee_img = isset($_POST['satisfaction_gurantee_img']) ? $_POST['satisfaction_gurantee_img'] : 0;
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : 0;
		$template = !empty($_POST['template']) ? $_POST['template'] : 'default';
		
		$show_date = isset($_POST['show_date']) ? $_POST['show_date'] : 0;
		$date = !empty($_POST['date']) ? $_POST['date'] : '';
		$date_custom_text = !empty($_POST['date_custom_text']) ? $_POST['date_custom_text'] : '';
		$show_time = isset($_POST['show_time']) ? $_POST['show_time'] : 0;
		$start_time = !empty($_POST['start_time']) ? $_POST['start_time'] : '';
		$end_time = !empty($_POST['end_time']) ? $_POST['end_time'] : '';
		$time_custom_text = !empty($_POST['time_custom_text']) ? $_POST['time_custom_text'] : '';
		$body_id = !empty($_POST['body_id']) ? $_POST['body_id'] : '';
		$offer_image_alt_text = isset($_POST['offer_image_alt_text']) ? $_POST['offer_image_alt_text'] : '';
		$body_class = isset($_POST['body_class']) ? $_POST['body_class'] : '';
		$submit_btn_text = isset($_POST['submit_btn_text']) ? $_POST['submit_btn_text'] : '';
		/*$coupon_code_name = !empty($_POST['coupon_code_name']) ? $_POST['coupon_code_name'] : '';
		$coupon_discount_amount = !empty($_POST['coupon_discount_amount']) ? $_POST['coupon_discount_amount'] : ''; */

		$slug = $this->input->post('slug');
		if(empty($slug)){
		$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "", $product_title);
		$slug = str_replace(' ', '-',strtolower($replce_slug));
		$slug = str_replace('--', '-',strtolower($slug));
		}else{
			$slug  = trim($slug);
			$replce_slug2 = preg_replace("/[^A-Za-z0-9\ ]/", "", $slug);
			$slug = str_replace(' ', '-',strtolower($replce_slug2));
			$slug = str_replace('--', '-',strtolower($slug));
		}

		$slug = $this->get_unique_slug($slug);
		
		$show_location_type = (isset($_POST['show_location_type']) && !empty($_POST['show_location_type'])) ? $_POST['show_location_type'] : 'show_all';
		$locations = (isset($_POST['locations']) && !empty($_POST['locations'])) ? serialize($_POST['locations']) : '';
		$unique_email_address = isset($_POST['unique_email_address']) ? $_POST['unique_email_address'] : '';
		$form_bottom_text = isset($_POST['form_bottom_text']) ? $_POST['form_bottom_text'] : '';
		$is_unique_dojocart = isset($_POST['is_unique_dojocart']) ? $_POST['is_unique_dojocart'] : 0;
		$form_right_side_text = isset($_POST['form_right_side_text']) ? $_POST['form_right_side_text'] : '';
		//echo $slug; die;

		$product_description = htmlentities($product_description);
			
		
			$this->load->model('upload_model');
			$v_image ="";

			$product_image = '';
			
			$image = isset($_FILES['userfile1']['name']) ? $_FILES['userfile1']['name'] : '';
			$_FILES['userfile1']['name'] = time().$image;
			if(!empty($_FILES['userfile1']['name'] ) && strlen($_FILES['userfile1']['name'] )> 10){
				$path = $_FILES['userfile1']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$_FILES['userfile1']['name'] = time().'_img.'.$ext;
				
				$path = "upload/dojocarts/";

				if($a = $this->upload_model->upload_image($path, 'userfile1')){
					
					$b='';
					//image resize process start			
					$filename=basename($a);	
					$umask=umask(0);
					$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
					$dirpath.='/'.$path;			
					chmod($dirpath.$filename ,0777);
					umask($umask);        				
					$this->load->library('image_lib');
					$config=array();			
					$config['image_library'] = 'gd2';
					$config['source_image'] = $dirpath.$filename;						
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['allowed_types'] = 'jpg|gif|png';
					$config['new_image'] = $dirpath.$filename;
					$config['quality'] = "100%";
					$config['width'] = 280;
 					$config['height'] = 300;
					//$image_config['new_image'] = $dirpath.$filename;
					//$image_config['quality'] = "100%";
					
					
			$imagedetails = getimagesize($_FILES['userfile1']['tmp_name']);

			$width = $imagedetails[0];
			$height = $imagedetails[1];
			
			$ratio = $width/$height;
			
			if($width >= 280){
			 	 $width = 280;
			}
			
			$config['width'] = $width;
			$config['height'] = 300;
			
/*			
			   if( $ratio > 1) {
			    // wight
				    $ratio_w = $imagedetails[1] / $imagedetails[0];
				    $config['width'] = $width;
				    $config['height'] = $width * $ratio_w;
			    }
			    else {
				  // height
				  $ratio_h = $imagedetails[0] / $imagedetails[1];
				  $config['width'] = $height * $ratio_h;
				  $config['height'] = $height;
				}*/
			
			
			$this->load->library('image_lib', $config);			 			
	        $this->image_lib->initialize($config);        
	        
			if (!$this->image_lib->resize())
			{
			    echo  $this->image_lib->display_errors();
			    exit;		    
			}else{			
				$this->image_lib->clear();
				$filename=str_replace('.','_thumb.',$filename);
				//die($filename);
				$b=$path.$filename;
			}
			
			$original_image = base_url().$a;
			$img_name = str_replace('upload/dojocarts/','',$a);
			$photo_thumb = 'upload/dojocarts/thumb/'.$img_name;
			$product_image = $filename;
			
			$imageType = str_replace('image/','',$imagedetails['mime']);
/*			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/dojocarts/thumb/'.$img_name, 280, 158);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/dojocarts/thumb/'.$img_name, 280, 158);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/dojocarts/thumb/'.$img_name, 280, 158);
			}*/
			
				
				}
		}




		// code for offer image

			$offer_image = '';
			$image = $_FILES['userfile2']['name'];
			$_FILES['userfile2']['name'] = time().$image;
			if(!empty($_FILES['userfile2']['name'] ) && strlen($_FILES['userfile2']['name'] )> 10){
				$path = $_FILES['userfile2']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$_FILES['userfile2']['name'] = time().'_img.'.$ext;
				
				$path = "upload/dojocarts/";

				if($a = $this->upload_model->upload_image($path, 'userfile2')){
					
					$b='';
					//image resize process start			
					$filename=basename($a);	
					$umask=umask(0);
					$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
					$dirpath.='/'.$path;			
					chmod($dirpath.$filename ,0777);
					umask($umask);        				
					$this->load->library('image_lib');
					$config=array();			
					$config['image_library'] = 'gd2';
					$config['source_image'] = $dirpath.$filename;						
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['allowed_types'] = 'jpg|gif|png';
					$image_config['new_image'] = $dirpath.$filename;
					$image_config['quality'] = "100%";
					
					
			$imagedetails = getimagesize($_FILES['userfile2']['tmp_name']);

			$width = $imagedetails[0];
			$height = $imagedetails[1];
			
			

			$ratio = $width/$height;
			
			if($width >= 400){
			 	 $width = 400;
			}
			
			$config['width'] = $width;
			$config['height'] = $height;
			
			/**if($width >= 400 && $height <= 213){
				//$config['width'] = 538;
				$config['height'] =208;
			} elseif($height >= 213 && $width <= 400){
				$config['width'] = 400;
				//$config['height'] = 254;
			}else{
				$config['height'] =213;
				$config['width'] = 400;
			} **/
			
			
			
			
			
			
			$this->load->library('image_lib', $config);			 			
	        $this->image_lib->initialize($config);        
	        
			if (!$this->image_lib->resize())
			{
			    echo  $this->image_lib->display_errors();
			    exit;		    
			}else{			
				$this->image_lib->clear();
				$filename=str_replace('.','_thumb.',$filename);
				$b=$path.$filename;
			}
			
			$original_image = base_url().$a;
			$img_name = str_replace('upload/dojocarts/','',$a);
			$photo_thumb = 'upload/dojocarts/thumb/'.$img_name;
			$offer_image = $filename;
			
			$imageType = str_replace('image/','',$imagedetails['mime']);
/*			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/dojocarts/thumb/'.$img_name, 378, 213);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/dojocarts/thumb/'.$img_name, 378, 213);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/dojocarts/thumb/'.$img_name, 378, 213);
			}*/
			
				
				}
		}



			if(!empty($_FILES['userfile3']['name'])){
			$path_offer = "upload/dojocarts/";
			$v_image = $this->upload_model->upload_image($path_offer,'userfile3');
			}
			
	
				$data = array(

					'videoimage' => $v_image,
					'image_video' => $image_video,
					'video_type'  => $video_type,
					'youtube_video' => $youtube_video,
					'vimeo_video'	=> $vimeo_video,
					'image_alt'		=> $image_alt,
					'product_title' => $product_title,
					'product_description' => $product_description,
					'product_image' => $product_image,
					'offer_title' => $offer_title,
					'features' => $features,
					'offer_description' => $offer_description,
					'payment_type' => $payment_type,
					'offer_image' => $offer_image,
					'price' => $price,
					'show_price' => $show_price,
					'show_quantity' => $show_quantity,
					'term_condition' => $term_condition,
					'upsale' => $upsale,
					'dojocart_item' => $dojocart_item,
					'show_term_condition' => $show_term_condition,
					'slug' => $slug,
					'meta_title' => $meta_title,
					'meta_desc'	 => $meta_desc,
					'published' => $published,
					'sales_tax_main' => $sales_tax_main,
					'sales_taxable' => $sales_taxable,
					'override_logo' =>$override_logo,
					'money_back_img' =>$money_back_img,
					'satisfaction_gurantee_img' =>$satisfaction_gurantee_img,
					'coupon_code' =>$coupon_code,
					'template' => $template,
					'show_date' => $show_date,
					'date' => $date,
					'date_custom_text' => $date_custom_text,
					'show_time' => $show_time,
					'start_time' => $start_time,
					'end_time' => $end_time,
					'time_custom_text' => $time_custom_text,
					'body_id' => $body_id,
					'offer_image_alt_text' => $offer_image_alt_text,
					'body_class' => $body_class,
					'submit_btn_text' => $submit_btn_text,
					'show_location_type' => $show_location_type,
					'locations' => $locations,
					'unique_email_address' => $unique_email_address,
					'form_bottom_text' => $form_bottom_text,
					'is_unique_dojocart' => $is_unique_dojocart,
					'form_right_side_text' => $form_right_side_text,
					'multi_item_sales_taxable' => $multi_item_sales_taxable,
				);
				
			//echo '<pre>'; print_r($data); die;

				if($this->query_model->insertData($this->table,$data)){
					$insert_id = $this->db->insert_id();
					if($upsale == 1){
					foreach($_POST['data'] as $upsalePage){
						$updata['up_title'] = $upsalePage['up_title'];
						$updata['up_price'] = $upsalePage['up_price'];
						$updata['sales_tax'] = !empty($upsalePage['sales_tax'])?$upsalePage['sales_tax']:'0';
						$updata['yes'] = $upsalePage['yes'];
						$updata['no'] = $upsalePage['no'];
						$updata['dojocart_id'] = $insert_id;
						$updata['is_qty_apply'] = (isset($upsalePage['is_qty_apply']) && !empty($upsalePage['is_qty_apply'])) ? $upsalePage['is_qty_apply'] : 0;
					$this->query_model->insertData('tbl_dojocart_upsales',$updata);
				}
				
					//echo $insert_id; die;
				}
				
				if($dojocart_item == 1){
					foreach($_POST['dojocartItem'] as $item){
						if(!empty($item['item_price'])){
							$updata['item_title'] = $item['item_title'];
							$updata['item_price'] = $item['item_price'];
							$updata['sales_tax'] = !empty($item['sales_tax'])?$item['sales_tax']:'0';
							$updata['item_description'] = $item['item_description'];
							$updata['dojocart_id'] = $insert_id;
							$this->query_model->insertData('tbl_dojocart_items',$updata);
						}
					}
				
					//echo $insert_id; die;
				}
				
				//dojocart_item
				
				// saving coupons
				if(isset($_POST['Coupons'])){
					foreach($_POST['Coupons'] as $coupon){
						if(isset($coupon['coupon_code_name']) && !empty($coupon['coupon_code_name'])){
							$couponData['coupon_discount_type'] = isset($coupon['coupon_discount_type']) ? $coupon['coupon_discount_type'] : 'amount';
							$couponData['coupon_discount_percent'] = isset($coupon['coupon_discount_percent']) ? $coupon['coupon_discount_percent'] : '';
							
								$couponData['expiry_date'] = (isset($coupon['expiry_date']) && !empty(($coupon['expiry_date']))) ? $coupon['expiry_date'] : date('Y-m-d');
								
							$couponData['coupon_code_name'] = isset($coupon['coupon_code_name']) ? trim($coupon['coupon_code_name']) : '';
							$couponData['coupon_discount_amount'] =  isset($coupon['coupon_discount_amount']) ? $coupon['coupon_discount_amount'] : '';
							$couponData['dojocart_id'] = $insert_id;
							$this->query_model->insertData('tbl_dojocart_coupons',$couponData);
						}
						
					}
				}
				
				
				
				if(isset($_POST['custom_field']) && !empty($_POST['custom_field'])){
					foreach($_POST['custom_field'] as $custom_field){
						$customFieldData['type'] = isset($custom_field['type']) ? $custom_field['type'] : '';
						$customFieldData['label_text'] = isset($custom_field['label_text']) ? $custom_field['label_text'] : '';
						$customFieldData['field_coloumn_class'] = isset($custom_field['field_coloumn_class']) ? $custom_field['field_coloumn_class'] : '';
						$customFieldData['is_field_required'] = (isset($custom_field['is_field_required']) && !empty($custom_field['is_field_required'])) ? $custom_field['is_field_required'] : 0;
						$customFieldData['right_sidebar'] = (isset($custom_field['right_sidebar']) && !empty($custom_field['right_sidebar'])) ? $custom_field['right_sidebar'] : 0;
						$customFieldData['dropdown_values'] = (isset($custom_field['dropdown_values']) && !empty($custom_field['dropdown_values'])) ? serialize($custom_field['dropdown_values']) : '';
						$customFieldData['dojocart_id'] = $insert_id;
						$customFieldData['created'] = date('Y-m-d H:i:s');
						$this->query_model->insertData('tbl_dojocart_custom_fields',$customFieldData);
					}
				}
				
				//saving data in form instance model
					$details = $this->query_model->getbySpecific('tbl_dojocarts','id', $insert_id);
					//,'page_url', $old_cart_slug
					$this->db->limit(1);
					$this->db->where("page_url LIKE '%/promo%'");
					$form_instancesDetail = $this->query_model->getByTable('tbl_form_instances');
					
					if(!empty($form_instancesDetail)){	
						$formInstanceData = array();
						$formInstanceData['form_type_id'] = $form_instancesDetail[0]->form_type_id;
						$formInstanceData['form_module_id'] = $form_instancesDetail[0]->form_module_id;
						$formInstanceData['page_url'] = '/promo/'.$details[0]->slug;
						$formInstanceData['page_name'] = 'Dojocart- '.$details[0]->product_title;
						
						$this->query_model->insertData('tbl_form_instances', $formInstanceData);
					}
					
					
					
				
					redirect("admin/dojocart");
				}

			
		
	}

	function get_unique_slug($slug, $id=''){
		
		$this->load->helper('string');
		
		$query = $this->db->get_where('tbl_dojocarts', array('slug' => $slug));
		
		if($query->num_rows() > 0){			
			$row = $query->row_object();
			if($id)
				$slug = $slug.'-'.$id;
			else{
				$rand = random_string('numeric', 3);
				$slug = $slug.'-'.$rand;					
			}
			return $slug;
		}else{
			return $slug;
		}		
	}


	function getDetailById($id){
		return $this->query_model->getbyId($this->table, $id);
	}


	function updateDojoCart(){
		
		
		
		
		$image_video = trim ($this->input->post('image_video'));
		$image_alt = $this->input->post('image_alt');
		$video_type = $this->input->post('video_type');
		$youtube_video = trim ($this->input->post('youtube_video'));
		$vimeo_video = trim ($this->input->post('vimeo_video'));

		$dcart_id = $this->input->post('dojo_cart_id');
		$product_title = trim ($this->input->post('product_title'));
		$product_description = $this->input->post('product_description');
		$offer_title = $this->input->post('offer-title');
		$features = serialize($this->input->post('features'));
		//$payment_type = $this->input->post('payment_type');
		$payment_type = $_POST['payment_type'];
		
		$paymentDetail = $this->query_model->getbySpecific('tbl_payments','id',1);
		if(!empty($paymentDetail)  && ($paymentDetail[0]->authorize_net_payment == 0 && $paymentDetail[0]->braintree_payment == 0  && $paymentDetail[0]->stripe_payment == 0   && $paymentDetail[0]->stripe_ideal_payment == 0    && $paymentDetail[0]->paypal_payment == 0 )){
			$payment_type = 'free';
		}
		
		$upsale = (isset($_POST['upsale']) && !empty($_POST['upsale'])) ? $_POST['upsale'] : 0;
		$dojocart_item = (isset($_POST['dojocart_item']) && !empty($_POST['dojocart_item'])) ? $_POST['dojocart_item'] : 0;
		
		
		$offer_description = $this->input->post('offer_description');
		$show_price = $this->input->post('show_price');
		$price = $this->input->post('price');

		$sales_taxable = $this->input->post('sales_taxable');
		$sales_tax_main = !empty($_POST['sales_tax_main']) ? $_POST['sales_tax_main'] :0;
		$multi_item_sales_taxable = (isset($_POST['multi_item_sales_taxable']) && !empty($_POST['multi_item_sales_taxable'])) ? $_POST['multi_item_sales_taxable'] : 0;
		$show_quantity = $this->input->post('show_quantity');
		
		$show_term_condition = $this->input->post('show_term_condition');
		$term_condition = $this->input->post('term_condition');

		$meta_title = $this->input->post('meta_title');
		$meta_desc = $this->input->post('meta_desc');

		$published = $this->input->post('published');

		$slug = $this->input->post('slug');
		
		$override_logo = isset($_POST['override_logo']) ? $_POST['override_logo'] : 0;
		$money_back_img = isset($_POST['money_back_img']) ? $_POST['money_back_img'] : 0;
		$satisfaction_gurantee_img = isset($_POST['satisfaction_gurantee_img']) ? $_POST['satisfaction_gurantee_img'] : 0;
		$coupon_code = isset($_POST['coupon_code']) ? $_POST['coupon_code'] : 0;
		
		$show_date = isset($_POST['show_date']) ? $_POST['show_date'] : 0;
		$date = !empty($_POST['date']) ? $_POST['date'] : '';
		$date_custom_text = !empty($_POST['date_custom_text']) ? $_POST['date_custom_text'] : '';
		$show_time = isset($_POST['show_time']) ? $_POST['show_time'] : 0;
		$start_time = !empty($_POST['start_time']) ? $_POST['start_time'] : '';
		$end_time = !empty($_POST['end_time']) ? $_POST['end_time'] : '';
		$time_custom_text = !empty($_POST['time_custom_text']) ? $_POST['time_custom_text'] : '';
		$body_id = !empty($_POST['body_id']) ? $_POST['body_id'] : '';
		$offer_image_alt_text = isset($_POST['offer_image_alt_text']) ? $_POST['offer_image_alt_text'] : '';
		$body_class = isset($_POST['body_class']) ? $_POST['body_class'] : '';
		$submit_btn_text = isset($_POST['submit_btn_text']) ? $_POST['submit_btn_text'] : '';
		//$coupon_code_name = !empty($_POST['coupon_code_name']) ? $_POST['coupon_code_name'] : '';
		//$coupon_discount_amount = !empty($_POST['coupon_discount_amount']) ? $_POST['coupon_discount_amount'] : '';
		
		if(empty($slug)){
			$slug = slugify(trim($product_title));
			//$replce_slug = preg_replace("/[^A-Za-z0-9\ ]/", "", $product_title);
			//$slug = str_replace(' ', '-',strtolower($replce_slug));
			//$slug = str_replace('--', '-',strtolower($slug));
		}else{
			$slug = slugify(trim($slug));
			//$slug  = trim($slug);
			//$replce_slug2 = preg_replace("/[^A-Za-z0-9\ ]/", "", $slug);
			//$slug = str_replace(' ', '-',strtolower($replce_slug2));
			//$slug = str_replace('--', '-',strtolower($slug));
		}
		
		$product = $this->getDetailById($dcart_id);
		
		$show_location_type = (isset($_POST['show_location_type']) && !empty($_POST['show_location_type'])) ? $_POST['show_location_type'] : 'show_all';
		$locations = (isset($_POST['locations']) && !empty($_POST['locations'])) ? serialize($_POST['locations']) : '';
		
		$unique_email_address = isset($_POST['unique_email_address']) ? $_POST['unique_email_address'] : '';
		$form_bottom_text = isset($_POST['form_bottom_text']) ? $_POST['form_bottom_text'] : '';
		$is_unique_dojocart = isset($_POST['is_unique_dojocart']) ? $_POST['is_unique_dojocart'] : 0;
		$form_right_side_text = isset($_POST['form_right_side_text']) ? $_POST['form_right_side_text'] : '';
		
		if($slug != $product[0]->slug){
			$slug = $this->get_unique_slug($slug, $dcart_id);
		}
		
		//echo $slug; die;
	
		$old_product_image = $this->input->post('old_product_image');
		$old_offer_image = $this->input->post('old_offer_image');
		$old_videoimage = $this->input->post('old_videoimage');
		
		$this->load->model('upload_model');
		$path_product = "upload/dojocarts/";
		$v_image ="";


			$product_image = '';
			$image = isset($_FILES['userfile1']['name']) ? $_FILES['userfile1']['name'] : '';
			
			
			
			if(isset($_FILES['userfile1']['name']) && !empty($_FILES['userfile1']['name'] ) && strlen($_FILES['userfile1']['name'] )> 10){
				$path = $_FILES['userfile1']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$_FILES['userfile1']['name'] = time().'_img.'.$ext;
				
				$path = "upload/dojocarts/";

				if($a = $this->upload_model->upload_image($path, 'userfile1')){
					
					$b='';
					//image resize process start			
					$filename=basename($a);	
					$umask=umask(0);
					$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
					$dirpath.='/'.$path;			
					chmod($dirpath.$filename ,0777);
					umask($umask);        				
					$this->load->library('image_lib');
					$config=array();			
					$config['image_library'] = 'gd2';
					$config['source_image'] = $dirpath.$filename;						
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['allowed_types'] = 'jpg|gif|png';
					$config['new_image'] = $dirpath.$filename;
					$config['quality'] = "100%";
					$config['width'] = 280;
 					$config['height'] = 300;
					
					
			$imagedetails = getimagesize($_FILES['userfile1']['tmp_name']);
			
			$width = $imagedetails[0];
			$height = $imagedetails[1];


			$ratio = $width/$height;
			
			if($width >= 280){
			 	 $width = 280;
			}
			
			$config['width'] = $width;
			$config['height'] = 300;
			   
			/**   if( $ratio > 1) {
			    // wight
				    $ratio_w = $imagedetails[1] / $imagedetails[0];
				    $config['width'] = $width;
				    $config['height'] = $width * $ratio_w;
			    }
			    else {
				  // height
				  $ratio_h = $imagedetails[0] / $imagedetails[1];
				  $config['width'] = $height * $ratio_h;
				  $config['height'] = $height;
				} **/

			
			$this->load->library('image_lib', $config);			 			
	        $this->image_lib->initialize($config);        
	        
			if (!$this->image_lib->resize())
			{
			    echo  $this->image_lib->display_errors();
			    exit;		    
			}else{			
				$this->image_lib->clear();
				$filename=str_replace('.','_thumb.',$filename);
				$b=$path.$filename;
			}
			
			$original_image = base_url().$a;
			$img_name = str_replace('upload/dojocarts/','',$a);
			$photo_thumb = 'upload/dojocarts/thumb/'.$img_name;
			$product_image = $filename;
			
			$imageType = str_replace('image/','',$imagedetails['mime']);
/*			if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/dojocarts/thumb/'.$img_name, 280, 158);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/dojocarts/thumb/'.$img_name, 280, 158);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/dojocarts/thumb/'.$img_name, 280, 158);
			}*/
			
				
				}
		}
		else {
				$product_image = $old_product_image;
			}


		// code for offer image

			$offer_image = '';
			$image = $_FILES['userfile2']['name'];
			$_FILES['userfile2']['name'] = time().$image;
			if(!empty($_FILES['userfile2']['name'] ) && strlen($_FILES['userfile2']['name'] )> 10){
				$path = $_FILES['userfile2']['name'];
				$ext = pathinfo($path, PATHINFO_EXTENSION);
				$_FILES['userfile2']['name'] = time().'_img.'.$ext;
				
				$path = "upload/dojocarts/";

				if($a = $this->upload_model->upload_image($path, 'userfile2')){
					
					$b='';
					//image resize process start			
					$filename=basename($a);	
					$umask=umask(0);
					$dirpath=dirname($_SERVER['SCRIPT_FILENAME']);
					$dirpath.='/'.$path;			
					chmod($dirpath.$filename ,0777);
					umask($umask);        				
					$this->load->library('image_lib');
					$config=array();			
					$config['image_library'] = 'gd2';
					$config['source_image'] = $dirpath.$filename;						
					$config['create_thumb'] = TRUE;
					$config['maintain_ratio'] = TRUE;
					$config['allowed_types'] = 'jpg|gif|png';
					$image_config['new_image'] = $dirpath.$filename;
					$image_config['quality'] = "100%";
					
					
			$imagedetails = getimagesize($_FILES['userfile2']['tmp_name']);

			$width = $imagedetails[0];
			$height = $imagedetails[1];
			
			/**if($width >= 400 && $height <= 213){
				//$config['width'] = 538;
				$config['height'] =208;
			} elseif($height >= 213 && $width <= 400){
				$config['width'] = 400;
				//$config['height'] = 254;
			}else{
				$config['height'] =213;
				$config['width'] = 400;
			} **/
			
			

			$ratio = $width/$height;
			
			if($width >= 400){
			 	 $width = 400;
			}
			
			$config['width'] = $width;
			$config['height'] = $height;
			//echo '<prE>config'; print_r($config); die;
			
			
			$this->load->library('image_lib', $config);			 			
	        $this->image_lib->initialize($config);        
	        
			if (!$this->image_lib->resize())
			{
			    echo  $this->image_lib->display_errors();
			    exit;		    
			}else{			
				$this->image_lib->clear();
				$filename=str_replace('.','_thumb.',$filename);
				//die($filename);
				$b=$path.$filename;
			}
			
			$original_image = base_url().$a;
			$img_name = str_replace('upload/dojocarts/','',$a);
			$photo_thumb = 'upload/dojocarts/thumb/'.$img_name;
			$offer_image = $filename;
			
			$imageType = str_replace('image/','',$imagedetails['mime']);


			/**if($imageType == 'png'){
				$this->query_model->resize_and_crop_png($original_image, 'upload/dojocarts/thumb/'.$img_name, 378, 213);
			}elseif($imageType == 'gif'){
				$this->query_model->resize_and_crop_gif($original_image, 'upload/dojocarts/thumb/'.$img_name, 378, 213);
			} else {
				$this->query_model->resize_and_crop($original_image, 'upload/dojocarts/thumb/'.$img_name, 378, 213);
			} **/
			
				
				}
		}
		else{
			$offer_image = $old_offer_image;
			}



		    // Image or Video

			if (!empty($_FILES['userfile3']['name'])) {
				$v_image = $this->upload_model->upload_image($path_product,'userfile3');
			}
			else {
				$v_image = $old_videoimage;
			}
			
	
				$data = array(

					'videoimage' => $v_image,
					'image_video' => $image_video,
					'video_type'  => $video_type,
					'youtube_video' => $youtube_video,
					'vimeo_video'	=> $vimeo_video,
					'image_alt'		=> $image_alt,
					'product_title' => $product_title,
					'product_description' => $product_description,
					'product_image' => $product_image,
					'offer_title' => $offer_title,
					'features' => $features,
					'offer_description' => $offer_description,
					'payment_type' => $payment_type,
					'offer_image' => $offer_image,
					'price' => $price,
					'show_price' => $show_price,
					'show_quantity' => $show_quantity,
					'upsale'		=> $upsale,
					'dojocart_item' => $dojocart_item,
					'term_condition' => $term_condition,
					'show_term_condition' => $show_term_condition,
					'slug' => $slug,
					'meta_title' => $meta_title,
					'meta_desc'	 => $meta_desc,
					'published' => $published,
					'sales_tax_main' => $sales_tax_main,
					'sales_taxable' => $sales_taxable,
					'override_logo' =>$override_logo,
					'money_back_img' =>$money_back_img,
					'satisfaction_gurantee_img' =>$satisfaction_gurantee_img,
					'coupon_code' =>$coupon_code,
					'show_date' => $show_date,
					'date' => $date,
					'date_custom_text' => $date_custom_text,
					'show_time' => $show_time,
					'start_time' => $start_time,
					'end_time' => $end_time,
					'time_custom_text' => $time_custom_text,
					'body_id' => $body_id,
					'offer_image_alt_text' => $offer_image_alt_text,
					'body_class' => $body_class,
					'submit_btn_text' => $submit_btn_text,
					'show_location_type' => $show_location_type,
					'locations' => $locations,
					'unique_email_address' => $unique_email_address,
					'form_bottom_text' => $form_bottom_text,
					'is_unique_dojocart' => $is_unique_dojocart,
					'form_right_side_text' => $form_right_side_text,
					'multi_item_sales_taxable' => $multi_item_sales_taxable,
					//'coupon_code_name' =>$coupon_code_name,
					//'coupon_discount_amount' =>$coupon_discount_amount
					
				);
				

			if($this->query_model->update($this->table,$this->uri->segment(4),$data)){
				
				if(isset($_POST['data']) && !empty($_POST['data'])){
					$this->query_model->deletebySpecific('tbl_dojocart_upsales','dojocart_id',$this->uri->segment(4));
					foreach($_POST['data'] as $upsalePage){
						if(!empty($upsalePage['up_price'])){
							$updata['up_title'] = !empty($upsalePage['up_title']) ? $upsalePage['up_title'] : '';
							$updata['up_price'] = !empty($upsalePage['up_price']) ? $upsalePage['up_price'] : '';
							$updata['sales_tax'] = !empty($upsalePage['sales_tax']) ? $upsalePage['sales_tax'] : '0';
							$updata['is_qty_apply'] = (isset($upsalePage['is_qty_apply']) && !empty($upsalePage['is_qty_apply'])) ? $upsalePage['is_qty_apply'] : 0;
							$updata['yes'] = !empty($upsalePage['yes']) ? $upsalePage['yes'] : '' ;
							$updata['no'] = !empty($upsalePage['no']) ? $upsalePage['no'] : '';
							$updata['dojocart_id'] = $this->uri->segment(4);
							$this->query_model->insertData('tbl_dojocart_upsales',$updata);
						}
					}
				}
				
				
				if(isset($_POST['dojocartItem']) && !empty($_POST['dojocartItem'])){
					$this->query_model->deletebySpecific('tbl_dojocart_items','dojocart_id',$this->uri->segment(4));
					foreach($_POST['dojocartItem'] as $item){
						if(!empty($item['item_price'])){
							$updata['item_title'] = $item['item_title'];
							$updata['item_price'] = $item['item_price'];
							$updata['sales_tax'] = !empty($item['sales_tax'])?$item['sales_tax']:'0';
							$updata['item_description'] = $item['item_description'];
							$updata['dojocart_id'] = $this->uri->segment(4);
							$this->query_model->insertData('tbl_dojocart_items',$updata);
						}
					}
				}
				
				
				
				if(isset($_POST['Coupons'])){
					$this->query_model->deletebySpecific('tbl_dojocart_coupons','dojocart_id',$this->uri->segment(4));
					foreach($_POST['Coupons'] as $coupon){
						
						if(isset($coupon['coupon_code_name']) && !empty($coupon['coupon_code_name'])){
							$couponData['coupon_discount_type'] = isset($coupon['coupon_discount_type']) ? $coupon['coupon_discount_type'] : 'amount';
							$couponData['coupon_discount_percent'] = isset($coupon['coupon_discount_percent']) ? $coupon['coupon_discount_percent'] : '';
							$couponData['expiry_date'] = (isset($coupon['expiry_date']) && !empty(($coupon['expiry_date']))) ? $coupon['expiry_date'] : date('Y-m-d');
							
							$couponData['coupon_code_name'] = isset($coupon['coupon_code_name']) ? trim($coupon['coupon_code_name']) : '';
							$couponData['coupon_discount_amount'] =  isset($coupon['coupon_discount_amount']) ? $coupon['coupon_discount_amount'] : '';
							$couponData['dojocart_id'] = $this->uri->segment(4);
							$this->query_model->insertData('tbl_dojocart_coupons',$couponData);
						}
					}
				}
				
				
				
				if(isset($_POST['custom_field']) && !empty($_POST['custom_field'])){
					//$this->query_model->deletebySpecific('tbl_dojocart_custom_fields','dojocart_id',$this->uri->segment(4));
					foreach($_POST['custom_field'] as $custom_field){
						$customFieldData['type'] = isset($custom_field['type']) ? $custom_field['type'] : '';
						$customFieldData['label_text'] = isset($custom_field['label_text']) ? $custom_field['label_text'] : '';
						$customFieldData['field_coloumn_class'] = isset($custom_field['field_coloumn_class']) ? $custom_field['field_coloumn_class'] : '';
						$customFieldData['is_field_required'] = (isset($custom_field['is_field_required']) && !empty($custom_field['is_field_required'])) ? $custom_field['is_field_required'] : 0;
						$customFieldData['right_sidebar'] = (isset($custom_field['right_sidebar']) && !empty($custom_field['right_sidebar'])) ? $custom_field['right_sidebar'] : 0;
						$customFieldData['dropdown_values'] = (isset($custom_field['dropdown_values']) && !empty($custom_field['dropdown_values'])) ? serialize($custom_field['dropdown_values']) : '';
						$customFieldData['dojocart_id'] = $this->uri->segment(4);
						$customFieldData['created'] = date('Y-m-d H:i:s');
						
						if(isset($custom_field['custom_field_id']) && !empty($custom_field['custom_field_id'])){
							
							$this->query_model->update('tbl_dojocart_custom_fields',$custom_field['custom_field_id'],$customFieldData);
						}else{
							$this->query_model->insertData('tbl_dojocart_custom_fields',$customFieldData);
						}
					}
				}
				
				redirect("admin/dojocart");
			}
			
		}

	

}