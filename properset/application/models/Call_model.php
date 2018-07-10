<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Call_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
    }
	function startcall(){
		$current_time = date("Y-m-d H:i:s");
		$call_time = date("h:i a d-M-Y");
			$data = array(
			"userId" => $_POST['userId'],
			"callId" => $_POST['callId'],
			"propersetId" => $_POST['propersetId'],
			"sessionname" => $_POST['sessionname'],
			"startTime" => $current_time
		    );
           $this->db->insert("calls",$data);
		   $type = "start call";
		   $message = "call initiated at $call_time";
		   $this->setnotification($type,$message);
		   $startcall =  $this->getcall();
		   return $startcall;
	}
	function endcall(){
		$current_time = date("Y-m-d H:i:s");
		$call_time = date("h:i a d-M-Y");
		$data = array(
			"endTime" =>  $current_time,
		    );
			$this->db->where('userId',$_POST['userId']);			
			$this->db->where('propersetId',$_POST['propersetId']);
			$this->db->where('callId',$_POST['callId']);
			$this->db->update("calls",$data);
			$type = "end call";
			$message = "call ended at $call_time";
			$this->setnotification($type,$message);
			$endcall =  $this->getcall();
			return $endcall;
	}
    function getcall()
	{
		$this->db->select('*');
		$this->db->from('calls');
		$this->db->where('userId',$_POST['userId']);
		$this->db->where('callId',$_POST['callId']);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
	}
	function setnotification($type,$message){
		$current_time = date("Y-m-d H:i:s");
		
			$data = array(
			"senderId" => $_POST['userId'],
			"receiverId" => $_POST['propersetId'],
			"type" => $type,
			"message" => $message,
			"date" => $current_time,
		    );
           $this->db->insert("notification",$data);
	}
}