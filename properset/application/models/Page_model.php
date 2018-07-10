<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		
		
    }
	function getpage(){
		//$this->db->distinct();
		$this->db->select('*');
		$this->db->from('pages');
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	

}