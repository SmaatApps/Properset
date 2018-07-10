<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
    }
	 function index(){
		$this->db->select('*');
		$this->db->from('notification');
		//$this->db->where('senderId',$_POST['userId']);
		$query = $this->db->get();
		$results = $query->result_array();
		//$this->db->last_query();
		return $results;
    }
	}