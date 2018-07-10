<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		
		
    }
	function getprofile(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('userId',$_POST['propersetId']);
		$query = $this->db->get();
		$results = $query->result_array();
		foreach($results as $key=>$val){
			$likes = $this->getlikescount($val['userId']);
		    $amilike = $this->getamilike($val['userId'],$_POST['userId']);
			if(empty($amilike)){$amilike ="0"; }else{$amilike ="1";}
			$dislike = $this->getdislikecount($val['userId']);
			$amidislike = $this->getamidislike($val['userId'],$_POST['userId']);
			if(empty($amidislike)){$amidislike ="0"; }else{$amidislike ="1";}
			$results[$key]['likes'] = (string) count($likes);
			$results[$key]['amilike'] = $amilike;
			$results[$key]['dislike'] = (string)count($dislike);
			$results[$key]['amidislike'] = $amidislike;
			$results[$key]['videos'] ="0";
			$results[$key]['session'] ="0";
			$results[$key]['tokenId'] = $this->gettoken($val['userId']);
		}
		return $results;
	}
	function gettoken($userid){
		
		$this->db->select('*');
		$this->db->from('auth_token');
		$this->db->where('userId',$userid);
		$query = $this->db->get();
		$results = $query->result_array();
		$tokenId = $results[0]['tokenId'];
		return $tokenId;
		
	}
	function getlikescount($userId){
		$this->db->select('*');
		$this->db->from('likes');
		$this->db->where('propersetId',$userId);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	
	}
	function getdislikecount($userId){
		$this->db->select('*');
		$this->db->from('dislike');
		$this->db->where('propersetId',$userId);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	
	}
	function getamilike($propersetId,$userId){
		
		$this->db->select('*');
		$this->db->from('likes');
		$this->db->where('propersetId',$propersetId);
		$this->db->where('userId',$userId);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	
	}
	function getamidislike($propersetId,$userId){
		$this->db->select('*');
		$this->db->from('dislike');
		$this->db->where('propersetId',$propersetId);
		$this->db->where('userId',$userId);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	
	}
}