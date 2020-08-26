<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->model('crud_model');
	}	
	
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function insert()
	{
		if ($this->input->is_ajax_request()) {
			  
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');


			if ($this->form_validation->run() == FALSE)
			{
					$data = array('responce' => 'error','message'=> validation_errors());
			}
			else
			{
				$ajax_data = $this->input->post();
				
				if($this->crud_model->insert_entry($ajax_data) ){
					$data = array('responce' => 'success','message'=> 'Data added successfully');
				}else{
					$data = array('responce' => 'error','message'=> 'Failed to add data');
				}
			}

			echo json_encode($data);

		}else{
			echo 'No direct script access allowed';
		}
	}

	public function fetch(){
		if ($this->input->is_ajax_request()) {
			$posts = $this->crud_model->get_entries();

			echo json_encode($posts);
		}
	}
	public function delete(){
		
		if ($this->input->is_ajax_request()) {
			$del_id = $this->input->post('del_id') ;

			if ($this->crud_model->delete_entry($del_id)) {
				$data = array('responce'=> "success");
			} else {
				$data = array('responce'=> "error");
			}
			echo json_encode($data);
		}
	}
}

