<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registration_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Business_model');
    }
	 function updateuser(){
		$user= $this->getuser();
		$current_time = date("Y-m-d H:i:s");
		$tags= $_POST['tags'];
		$taglist= implode(",", $tags);
		
		
		
			$data = array(
			"userName" => $_POST['userName'],
			"title" => $_POST['title'],
			"profileImage" =>  $_POST['profileImage'],
			"category" =>  $_POST['category'],
			"description" =>  $_POST['description'],
			"coverImage" =>  $_POST['coverImage'],
			"portfolio" =>  $_POST['portfolio'],
			"businessName" =>  $_POST['businessName'],
			"tags" =>  $taglist,
			"fullDescription" =>  $_POST['fullDescription'],
			"video" =>  $_POST['video'],
			"audio" =>  $_POST['audio'],
			"chat" =>  $_POST['chat'],
			"updateDate" =>  $current_time,
			"pdfName" => $_POST['pdfName'],
			"new_user" => "0",
		    );
			$this->db->where('userId',$_POST['userId']);
            $this->db->update("users",$data);
		$this->Business_model->updatebusiness($_POST['businessName']);
		$user= $this->getuser();
		return $user;
	}
	function getuser(){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('userId',$_POST['userId']);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	
	function getpage(){
		$this->db->select('*');
		$this->db->from('pages');
		$query = $this->db->get();
		$results = $query->result_array();
		//$this->db->last_query();
		return $results;
    }
	
}