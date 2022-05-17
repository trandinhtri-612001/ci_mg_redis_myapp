<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class userController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	 public  $data_request = $this->input->post(); 
	    
	function __construct() {
		parent::__construct();
		// $this->load->model('userModel');
		$this->load->model('mongoModel');
		$this->load->helper('user_helper');
		$this->load->helper('redis_helper');
	}
	public function viewUser()
	{
		

	
$data['info']= $this->mongoModel->getuser()->result_array();

		$this->load->view('admin/user/index.php',$data);
	}
	public function addUser(){
       $this->load->view('admin/user/addUser.php');
	   $data_request = $this->input->post(); 
	   
	   if(isset($_POST['add'])){
		   extract($data_request);
        $res =   validateUser($data_request);
        if(!$res->success){
            echo "<script type ='text/JavaScript'>";  
	    echo "alert('$res->messages')";  
	  echo "</script>";
        }else{
			redisSetService($data_request);
	   $ojb =array('username'=>$username,'email'=>$email,'phone'=>$phone,'date'=>$date,'password'=>$password);
	  $this->mongoModel->addUser($ojb);
        }
	   }
	  
	  
    }
	public function updateUser($id){
		$data['info'] = $this->userModel->getById($id)->result_array();
		$this->load->view('admin/user/updateUser.php',$data);
	}

	public function delateUser($id){
		
		$this->mongoModel->deleteById($id);
	}

	public function updateUserById(){
		$data_request = $this->input->post();
		extract($data_request);
	
		if(isset($_POST['update'])){
            $res =   validateUser($data_request);
            if(!$res->success){
                echo "<script type ='text/JavaScript'>";  
            echo "alert(' $res->messages')";  
          echo "</script>";
          
            }else{
				redisSetService($data_request);
           $ojb =array('username'=>$username,'email'=>$email,'phone'=>$phone,'date'=>$date,'password'=>$password);
          $this->mongoModel->updateById($id,$ojb);
            }
	
		}
		
		



	}

}