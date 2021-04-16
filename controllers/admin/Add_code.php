<?php 
class Add_code extends CI_Controller{
	

	function index(){

		
		$row = $this->query_model->getbyTable('tbladdcode');
		$data['addCodes'] = $row;
		
		$this->db->limit(1);
		$this->db->order_by("add_more_number", "desc"); 
		$data['exitRows'] =  $this->query_model->getbyTable('tbladdcode');
		
		
		$PagesList = $this->query_model->getMenuMainPages(0,3);
		
		$pagesListing = array();
		foreach($PagesList as $pages){
			//$pages['data'] =  $this->query_model->getAllPagesForAddCode($pages['id'], $pages['slug']);
			//$pagesListing[] = $pages;
			
			$pagesListing =  $this->query_model->getAllPagesForAddCode($pages['id'], $pages['slug']);
		}
		$data['PagesLists'] = $pagesListing;
		//echo '<pre>'; print_r($data['PagesLists']); die;
		$this->load->view('admin/add_code',$data);

	}
	
	function encrypt_code(){
		
		$result = $this->input->post();
		
		$PagesList = $this->query_model->getMenuMainPages(0,3);
		
		$pagesListing = array();
		
		foreach($PagesList as $pages){
			$pagesListing =  $this->query_model->getAllPagesForAddCode($pages['id'], $pages['slug']);
		}
		$pagesListing['ALL'] = 'ALL';
		
		foreach($result['data'] as $val){
			$record = $this->query_model->getbySpecific('tbladdcode', 'add_more_number', $val['add_more_number']);
			//echo '<pre>'; print_r($record); die;
			if(!isset($val['code_checked'])){
				$val['code_checked'] = 0;
			}
			$val['page_slug'] = ($val['page_slug'] == "Home") ? '/' : $val['page_slug'];
			$val['page_title'] = isset($pagesListing[$val['page_slug']]) ? $pagesListing[$val['page_slug']] : '';
			
			if(empty($record)){
				$datass = array("page_slug" => $val['page_slug'], 'header_code' => $val['header_code'], 'footer_code' => $val['footer_code'], 'add_more_number' => $val['add_more_number'],'header_code_placed'=>$val['header_code_placed'],'code_checked'=>$val['code_checked'],'page_title'=>$val['page_title']);
				$this->query_model->insertData('tbladdcode', $datass);
			} else {
				$datas = array("page_slug" => $val['page_slug'], 'header_code' => $val['header_code'], 'footer_code' => $val['footer_code'], 'add_more_number' => $val['add_more_number'],'header_code_placed'=>$val['header_code_placed'],'code_checked'=>$val['code_checked'],'page_title'=>$val['page_title']);
				$this->query_model->updateData('tbladdcode','add_more_number',$val['add_more_number'], $datas);
			}
		} 
		
		$this->session->set_flashdata('good_message','Successfully Updated');
		redirect('admin/add_code/index');
	
	}
	
	
	
	public function delete_add_code(){
		
		if(count($_POST)>0){		
		  $add_codes = $this->query_model->getbyTable('tbladdcode');	
		  
		  if(count($add_codes) > 1){					
				$add_code_number = $_POST['add_more_number'];
				$this->db->where("add_more_number", $add_code_number);
				
				if($this->db->query("delete from tbladdcode where add_more_number=".$add_code_number.""))
				{					
					echo 1;
				}
			} else{
				echo 0;
			}
		}else{
				echo 0;
		}
	}

}
