<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		
    }
	 function updatecomment(){
		$current_time = date("Y-m-d H:i:s");
			$data = array(
			"userId" => $_POST['userId'],
			"propersetId" => $_POST['propersetId'],
			"comments" =>  $_POST['comment'],
			"review" =>  $_POST['review'],
			"url" =>  $_POST['url'],
			"createdDate" =>  $current_time,
			"updatedDate" =>  $current_time,
		    );
        $this->db->insert("comment",$data);
		$insert_id = $this->db->insert_id();
		$comment= $this->getcomment($insert_id);
		$updatereview = $this->updatereview();
		return $comment;
	}
	function getcomment($insert_id){
		$this->db->select('*');
		$this->db->from('comment');
		$this->db->where('id',$insert_id);
		//$this->db->where('propersetId',$_POST['propersetId']);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	function updatereview(){
		
		$rating = $this->getrating($_POST['propersetId']);
		$data = array(
			 "review" =>  $rating,
		    );
			$this->db->where('userId',$_POST['propersetId']);
            $this->db->update("users",$data);
	}
	function getrating($propersetId){
		
		$this->db->select('AVG(review) as average');
		$this->db->from('comment');
		$this->db->where('propersetId',$propersetId);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results[0]['average'];
	}

}