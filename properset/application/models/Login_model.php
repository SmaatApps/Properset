<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		
		
    }
    function index(){
		
		$this->db->select('mobile,tokenNo');
		$this->db->from('users');
		$this->db->where('mobile',$_POST['mobile']);
		$this->db->where('code',$_POST['code']);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
    }
	function createuser(){
		
		$otp = mt_rand(1000, 9999);
		
		$str = urlencode(ltrim($_POST['code'].$_POST['mobile'], '+'));
		
		//echo base_url()."twiliosms/Services/sms.php?otp=$otp&number=".$str;
		$sms= file_get_contents(base_url()."twiliosms/Services/sms.php?otp=$otp&number=".$str);
		
		
		$tokenNo = mt_rand(100000, 999999);
		if(isset($_POST['deviceId']) || !empty($_POST['deviceId'])){
            $d_id = $_POST['deviceId'];
        }else{
            $d_id = 0;
        }
		if(isset($_POST['deviceType']) || !empty($_POST['deviceType'])){
            $d_type = $_POST['deviceType'];
        }else{
            $d_type = "android";
        }
		
        $data = array(
            "mobile" => $_POST['mobile'],
			"code" => $_POST['code'],
            "otp"   => $otp,
            "tokenNo"   => $tokenNo,
            "deviceId" => $d_id,
			"deviceType" => $d_type,
            "status"  => "0",
        );
        $this->db->insert('users',$data);
        $resut = $this->db->insert_id();
        return $resut; 
		
	}
	function verifyuser(){
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('tokenNo',$_POST['tokenNo']);
		$this->db->where('mobile',$_POST['mobile']);
		$this->db->where('code',$_POST['code']);
		$query = $this->db->get();
		$results = $query->result_array();
		if(!empty($results)){
			
			if($results[0]['otp']==$_POST['otp']){
				$this->status_update($results[0]['userId']);
			}
			foreach($results as $key=>$val){
				
				$results[0]['tokenId'] = $this->generatetoken($val['userId']);
				
			}
		}
		
		return $results;
	}
	
	function updatetoken(){
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('userId',$_POST['userId']);
		
		$query = $this->db->get();
		$results = $query->result_array();
		if(!empty($results)){
			foreach($results as $key=>$val){
				$results[0]['tokenId'] = $this->generatetoken($_POST['userId']);
			}
		}
		return $results;
	}
	
	function checkAuth($userId,$tokenId){
		$end_time= date("Y-m-d H:i:s");
		$this->db->select('*');
		$this->db->from('auth_token');
		$this->db->where('tokenId',$tokenId);
		$this->db->where('userId',$userId);
		$this->db->where('endTime >',$end_time);
		$query = $this->db->get();
		$results = $query->result_array();
		return $results;
		
	}
	
	function generatetoken($userid){
		$tokenId = bin2hex(openssl_random_pseudo_bytes(16));
		$end_time= date("Y-m-d H:i:s", strtotime("+2 months"));
		$this->db->select('*');
		$this->db->from('auth_token');
		$this->db->where('userId',$userid);
		$query = $this->db->get();
		$results = $query->result_array();
		if(!empty($results)){
			
			$data = array(
            "tokenId"   => $tokenId,
            "userId" => $userid,
			"endTime	" => $end_time,
		    );
			$this->db->where('userId',$userid);
			$this->db->update("auth_token",$data);
			
		}else{
			
			$data = array(
            "tokenId"   => $tokenId,
            "userId" => $userid,
			"endTime	" => $end_time,
            );
			$this->db->insert('auth_token',$data);
		}
		
		return $tokenId;
		
	}
	function status_update($userId){
		
		$data = array(
			  'status'  => "1",
			  'verifyStatus'  => "1"
		);
		$this->db->where('userId',$userId);
		$this->db->update("users",$data);
		
	}
	function updateotp(){
		$otp = mt_rand(1000, 9999);
		$str = urlencode(ltrim($_POST['code'].$_POST['mobile'], '+'));
		//echo base_url()."twiliosms/Services/sms.php?otp=$otp&number=".$str;
		$sms= file_get_contents(base_url()."twiliosms/Services/sms.php?otp=$otp&number=".$str);
		$tokenNo = mt_rand(100000, 999999);
		if(isset($_POST['deviceId']) || !empty($_POST['deviceId'])){
            $d_id = $_POST['deviceId'];
        }else{
            $d_id = 0;
        }
		if(isset($_POST['deviceType']) || !empty($_POST['deviceType'])){
            $d_type = $_POST['deviceType'];
        }else{
            $d_type = "android";
        }
		$data = array(
            "otp"   => $otp,
            "deviceId" => $d_id,
			"deviceType" => $d_type,
			"verifyStatus" => "0",
			"tokenNo"  =>$tokenNo
         );
		$this->db->where("mobile" , $_POST['mobile']);
		$this->db->update("users",$data);
	}
	

}