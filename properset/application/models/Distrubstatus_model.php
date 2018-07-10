<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distrubstatus_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
    }
	function index(){
			$data = array(
			"disturbStatus" => $_POST['disturbStatus'],
		    );
			$this->db->where('userId',$_POST['userId']);
			$user = $this->db->update("users",$data);
			if($user){
				$datas = $this->input->post();
			}
		return $datas;
    }
}