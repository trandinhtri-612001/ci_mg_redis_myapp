

<?php
class mongoModel extends CI_Model
{
    
	
   
	
	function __construct() {
		parent::__construct();
		// $this->load->library('mongodb');
		// $this->conn = $this->mongodb->getConn();
		$this->load->library('mongo_db', array('activate'=>'newdb'),'mongo_db2');
	}
  	
	


    public function addUser($data)
    {
  $this->mongo_db->insert('users',$data);
  redirect('userController/viewUser','refresh');
        
    }
    public function getuser(){
        $res = $this->mongo_db->get('users');
        return  $res;
    }
    public function deleteById($id){
        $this->mongo_db->where('id',$id);
        $this->mongo_db->delete("users");
        redirect('userController/viewUser','refresh');
    }
    public function getById($id){
        $this->mongo_db->where('id',$id);
        $res = $this->mongo_db->get('users');
        return $res;
    }
    public function updateById($id,$data){
        $this->mongo_db->where('id',$id);
       $this->mongo_db->update('users',$data);
       redirect('userController/viewUser','refresh');
    }
 }




?>
