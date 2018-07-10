<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dislike_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
    }
	function updatedislike(){
		
		//$this->db->distinct();
		$this->db->select('*');
		$this->db->from('dislike');
		$this->db->where('userId',$_POST['userId']);
		$this->db->where('propersetId',$_POST['propersetId']);
		$query = $this->db->get();
		$dislike = $query->result_array();
		
		$this->db->select('*');
		$this->db->from('likes');
		$this->db->where('userId',$_POST['userId']);
		$this->db->where('propersetId',$_POST['propersetId']);
		$query = $this->db->get();
		$like = $query->result_array();
		
		if(!empty($dislike)){
			
			$this->db->where('userId', $_POST['userId']);
			$this->db->where('propersetId', $_POST['propersetId']);
			$this->db->delete('dislike');
            $results = array();			

		}if(!empty($like)) {
			$this->db->where('userId', $_POST['userId']);
			$this->db->where('propersetId', $_POST['propersetId']);
			$this->db->delete('likes');
            $results = array();	
			
			$current_time = date("Y-m-d H:i:s");
			$data = array(
			"userId" => $_POST['userId'],
			"propersetId" => $_POST['propersetId'],
			"date" =>  $current_time,
		    );
            $this->db->insert("dislike",$data);
			$insert_id = $this->db->insert_id();
			$results = $this->getdislikes($insert_id);
		}
		else {
			
			$current_time = date("Y-m-d H:i:s");
			$data = array(
			"userId" => $_POST['userId'],
			"propersetId" => $_POST['propersetId'],
			"date" =>  $current_time,
		    );
            $this->db->insert("dislike",$data);
			$insert_id = $this->db->insert_id();
			$results = $this->getdislikes($insert_id);
		}
		return $results;
	}
	
	function getdislikes($id){
		
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->from('dislike');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
    }
	

}