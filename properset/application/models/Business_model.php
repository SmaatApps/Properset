<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		
    }
    function index(){
		$this->db->select('*');
		$this->db->from('business_type');
		$query = $this->db->get();
		$results = $query->result_array();
		//$this->db->last_query();
		return $results;
    }
	function gettags(){
		$this->db->select('*');
		$this->db->from('tags');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	function updatebusiness($name){
		$this->db->select('*');
		$this->db->from('business_type');
		$this->db->where('name',$name);
		$query = $this->db->get();
		$results = $query->result_array();
		if(empty($results)){
			
			$data = array(
            "name" => $name,
			"status"  => "1",
			);
			$this->db->insert('business_type',$data);
		}
	}
}