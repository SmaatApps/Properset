<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Portfolio_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Business_model');
    }
	 function index(){
		$current_time = date("Y-m-d H:i:s");
			$data = array(
			"description" => $_POST['description'],
			"userId" => $_POST['userId'],
			"url" => $_POST['url'],
			"date" =>  $current_time,
		    );
            $this->db->insert("portfolio",$data);
			$user = $this->getportfolio();
			 return $user;
	}
	function getportfolio(){
		$this->db->select('*');
		$this->db->from('portfolio');
		$this->db->where('userId',$_POST['userId']);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	function getallportfolio(){
		$this->db->select('*');
		$this->db->from('portfolio');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	
}