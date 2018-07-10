<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userlist_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		
		
    }
	
	function getuserlist(){
		
		$this->db->select('*');
		$this->db->from('users');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	
    function index(){
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where_not_in('userId',$_POST['userId']);
		$query = $this->db->get();
		$results = $query->result_array();
		
		foreach($results as $key=>$val){
			
			$likes = $this->getlikescount($val['userId']);
			$rating = $this->getrating($val['userId']);
			$results[$key]['likes'] = count($likes);
			$results[$key]['ratingcount'] = $rating;
			$results[$key]['videos'] ="0";
			$results[$key]['session'] = "0";
		}
		return $results;
    }
	
	function getlikescount($userId){
		$this->db->select('*');
		$this->db->from('likes');
		$this->db->where('propersetId',$userId);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	
	}
	
	function getrating($propersetId){
		
		$this->db->select('count(review) as average');
		$this->db->from('comment');
		$this->db->where('propersetId',$propersetId);
		$query = $this->db->get();
		$results = $query->result_array();
		if($results[0]['average'] ==null){
		$results[0]['average'] = "0";
		}
		return $results[0]['average'];
	}

}