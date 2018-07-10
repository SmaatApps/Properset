<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
*
* Class: Registration
*
* Index Function for this controller is used to save user given data into database.
* @package    CodeIgniter
* @subpackage Registration
* @category   Rest API
* @author     Rajesh
* @copyright  2018 http://smaatapps.com
*
*
* Error status code
* 200 - OK
* 202 - INVALID ACCESS
* 400 - BAD REQUEST
*
*
*/

error_reporting(0);
require APPPATH.'/libraries/REST_Controller.php';
require APPPATH.'/libraries/validationandresult.php';

class Call extends REST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); // Library use to validate given input.
		$this->load->model('Call_model');
		$this->load->model('Login_model');
		$this->form_validation->set_error_delimiters('', '');
	}
	function startcall_Post(){
		
		$validationandresult = new validationandresult(); 
		$json_validation = $validationandresult->json_validation();
			
		if(!empty($json_validation)){
			$this->response($json_validation, 202);
		}else{
			if($this->checkAuth()=="1"){
						$result = $this->startcall();
					}else{
						$result = $validationandresult->fail($results,"Authentication Failed");
						$this->response($result,202);
					}
		}
	}
	function startcall(){
		$validationandresult = new validationandresult();
		$pre_key = array("userId","callId","propersetId","sessionname");
		$result = $validationandresult->keyvalidation($pre_key);
		if($result['msg'] != '')
		{
			$this->response($result, 202);
		}else{
		    $results = $this->Call_model->startcall();
			if(!empty($results)){
				 $result = $validationandresult->success($results,"call started");;
				 $this->response($result,202);
			}else{
				 $result = $validationandresult->fail($results,"invalid ");
				 $this->response($result,202);
			}
		}
	}
	
	function endcall_Post(){
		
		$validationandresult = new validationandresult(); 
		$json_validation = $validationandresult->json_validation();
			
		if(!empty($json_validation)){
			$this->response($json_validation, 202);
		}else{
			
			if($this->checkAuth()=="1"){
						
						$result = $this->endcall();
						
					}else{
						$result = $validationandresult->fail($results,"Authentication Failed");
						$this->response($result,202);
					}
		}
	}
	function endcall(){
		$validationandresult = new validationandresult();
		$pre_key = array("userId","callId");
		$result = $validationandresult->keyvalidation($pre_key);
		if($result['msg'] != '')
		{
			$this->response($result, 202);
		}else{
		    $results = $this->Call_model->endcall();
			if(!empty($results)){
				
				 $result = $validationandresult->success($results,"call started");;
				 $this->response($result,202);
				
			}else{
				 $result = $validationandresult->fail($results,"invalid ");
				 $this->response($result,202);
			}
		}
	}
	function checkAuth(){
		$headers = apache_request_headers();
		 // here you can check access toke of perticular user as well from db
		if(!empty($headers['tokenid'])){
			$auth=$this->Login_model->checkAuth($_POST['userId'],$headers['tokenid']);
			if(empty($auth)){
				$res="0";
			}else{
				$res="1";
			}
		}else{
			
			$res="0";
		}
		return $res;
		
	}
	
}
