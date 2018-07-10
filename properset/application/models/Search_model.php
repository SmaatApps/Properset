<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
    }
	function index(){
		
		$this->db->select('*');
		$this->db->from('users');
		//$this->db->where('category',"1");
		$this->db->like('userName',$_POST['name']);
		$this->db->or_like('businessName',$_POST['name']);
		$this->db->where('userId!=',$_POST['userId']);
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
		
	    
	   $BusinessType = $this->getbusinessType($start);

		$result['search'] = $results;
		$result['company'] = $BusinessType;
		return $result;
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
		return $results[0]['average'];
	}
	
	function getbusinessType($id){
		
		$this->db->select('businessName,count(businessName) as count');
		$this->db->from('users');
		$this->db->where('category',"1");
		$this->db->like('userName',$_POST['name']);
		$this->db->or_like('businessName',$_POST['name']);
		$this->db->where('userId!=',$_POST['userId']);
		$this->db->group_by('businessName'); 
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	
	}
	}