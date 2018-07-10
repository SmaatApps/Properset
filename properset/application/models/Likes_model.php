<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Likes_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
    }
	function updatelikes(){
		
		//$this->db->distinct();
		$this->db->select('*');
		$this->db->from('likes');
		$this->db->where('userId',$_POST['userId']);
		$this->db->where('propersetId',$_POST['propersetId']);
		$query = $this->db->get();
		$likes = $query->result_array();
		
		$this->db->select('*');
		$this->db->from('dislike');
		$this->db->where('userId',$_POST['userId']);
		$this->db->where('propersetId',$_POST['propersetId']);
		$query = $this->db->get();
		$dislike = $query->result_array();
		if(!empty($likes)){
		
			$this->db->where('userId', $_POST['userId']);
			$this->db->where('propersetId', $_POST['propersetId']);
			$this->db->delete('likes');
            $results = array();			

		}else if(!empty($dislike)) {
			$this->db->where('userId', $_POST['userId']);
			$this->db->where('propersetId', $_POST['propersetId']);
			$this->db->delete('dislike');
            $results = array();
			
			$current_time = date("Y-m-d H:i:s");
			$data = array(
			"userId" => $_POST['userId'],
			"propersetId" => $_POST['propersetId'],
			"date" =>  $current_time,
		    );
            $this->db->insert("likes",$data);
			$insert_id = $this->db->insert_id();
			$results = $this->getlikes($insert_id);
		
		}else{
			$current_time = date("Y-m-d H:i:s");
			$data = array(
			"userId" => $_POST['userId'],
			"propersetId" => $_POST['propersetId'],
			"date" =>  $current_time,
		    );
            $this->db->insert("likes",$data);
			$insert_id = $this->db->insert_id();
			$results = $this->getlikes($insert_id);
		}
		return $results;
	}
	
	function getlikes($id){
		
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->from('likes');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
    }
	

}