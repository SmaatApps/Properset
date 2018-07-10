<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calllist_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
    }
    function index(){
		
		$this->db->select('*');
		$this->db->from('calls');
		$this->db->where('userId',$_POST['userId']);
		$query = $this->db->get();
		$results = $query->result_array();
		
		foreach($results as $key=>$val){
			
		$start  = date_create($val['startTime']);
		$end 	= date_create($val['endTime']); // Current time and date
		$diff  	= date_diff( $start, $end );


			 $length ="$diff->h:$diff->i:$diff->s";
			 $results[$key]['length'] = $length;
			 $PropersetName = $this->getpropersetName($val['propersetId']);
			
			 $userName = $this->getuserName($val['userId']);
			 $results[$key]['PropersetName'] = $PropersetName;
			 $results[$key]['userName'] = $userName;
			// $results[$key]['length'] =(string) round($rating,1);
			// $results[$key]['videos'] ="0";
			// $results[$key]['session'] ="0";
		 }
		return $results;
    }
	
	function getpropersetName($propersetId){
		$this->db->select('userName');
		$this->db->from('users');
		$this->db->where('userId',$propersetId);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results[0]['userName'];
	
	}
	
	function getuserName($userId){
		$this->db->select('userName');
		$this->db->from('users');
		$this->db->where('userId',$userId);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results[0]['userName'];
	
	}
	
	
}