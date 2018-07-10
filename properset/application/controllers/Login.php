<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
*
* Class: Login
*
* Index Function for this controller is used to save user given data into database.
* @package    CodeIgniter
* @subpackage Login
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
//error_reporting(0);
require APPPATH.'/libraries/REST_Controller.php';
require APPPATH.'/libraries/validationandresult.php';

class Login extends REST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); // Library use to validate given input.
		$this->load->model('Login_model');
		$this->form_validation->set_error_delimiters('', '');
		
	}
	
	function index_post(){
		
		$validationandresult = new validationandresult(); 
		$json_validation = $validationandresult->json_validation();
			
		if(!empty($json_validation)){
			
			$this->response($json_validation, 202);
			
		}else{
			
			$this->process();
			
		}
		
	}
	function process(){
		
		$validationandresult = new validationandresult();
		
		$pre_key = array("mobile","code","deviceType","deviceId");
		$result = $validationandresult->keyvalidation($pre_key);
		if($result['msg'] != '')
		{
			$this->response($result, 202);

		}else{
	
		    $results = $this->Login_model->index();
					
			if(empty($results)){
				
			    $this->Login_model->createuser();
				$results = $this->Login_model->index();
				$result = $validationandresult->success($results);
				$this->response($result, 200);
				
			}else{
				
				$this->Login_model->updateotp();
				$results = $this->Login_model->index();
				$result = $validationandresult->success($results);
				$this->response($result, 200);
			}
					
		}
	}
	function verify_post(){
		
		$validationandresult = new validationandresult(); 
		$json_validation = $validationandresult->json_validation();
			
		if(!empty($json_validation)){
			$this->response($json_validation, 202);
		}else{
			
			$this->verifyuser();
			
		}
	}
	function verifyuser(){
		
		$validationandresult = new validationandresult();
		
		$pre_key = array("mobile","code","deviceType","deviceId","otp","tokenNo");
		$result = $validationandresult->keyvalidation($pre_key);
		if($result['msg'] != '')
		{
			$this->response($result, 202);

		}else{
	
		    $results = $this->Login_model->verifyuser();
			if(!empty($results)){
				
			    if($results[0]['otp']==$_POST['otp']){
					 $results = $this->Login_model->verifyuser();
					 $result = $validationandresult->success($results);
				     $this->response($result, 200);
					
				}else{
					 $results= array();
					 $result = $validationandresult->fail($results,"Invalid");
				     $this->response($result,202);
				}
				
				
			}else{
				 $result = $validationandresult->fail($results,"Mobilenumber not yet regeister");
				 $this->response($result,202);
			}
					
		}
		
	}
	function updatetoken_post(){
		$validationandresult = new validationandresult(); 
		$json_validation = $validationandresult->json_validation();
			
		if(!empty($json_validation)){
			$this->response($json_validation, 202);
		}else{
			$this->updatetoken();
		}
	}
	function updatetoken(){
		$validationandresult = new validationandresult();
		$pre_key = array("userId","tokenId");
		$result = $validationandresult->keyvalidation($pre_key);
		if($result['msg'] != '')
		{
			$this->response($result, 202);

		}else{
			
		    $results = $this->Login_model->updatetoken();
			if(!empty($results)){
				
				 $result = $validationandresult->success($results,"token updated");;
				 $this->response($result,202);
				
			}else{
				 $result = $validationandresult->fail($results,"invalid ");
				 $this->response($result,202);
			}
		}
	}
	
	function resent_post(){

		$validationandresult = new validationandresult(); 
		$json_validation = $validationandresult->json_validation();
			
		if(!empty($json_validation)){
			$this->response($json_validation, 202);
		}else{
			$this->resentotp();
		}
		
	}
	function resentotp(){
		
		$validationandresult = new validationandresult();
		$pre_key = array("mobile","code","deviceType","deviceId");
		$result = $validationandresult->keyvalidation($pre_key);
		if($result['msg'] != '')
		{
			$this->response($result, 202);

		}else{
		    $results = $this->Login_model->index();
			if(!empty($results)){
				$this->Login_model->updateotp();
				$results = $this->Login_model->index();
				$result = $validationandresult->success($results);
				$this->response($result, 200);
			}else{
				$result = $validationandresult->fail($results,"Mobilenumber not yet regeister");
				$this->response($result,202);
			}
					
		}
		
	}
	
}
