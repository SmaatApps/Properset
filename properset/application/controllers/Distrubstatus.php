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

class Distrubstatus extends REST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); // Library use to validate given input.
		$this->load->model('Registration_model');
		$this->load->model('Login_model');
		$this->load->model('Distrubstatus_model');
		$this->form_validation->set_error_delimiters('', '');
	}
	
	function index_post(){
		$validationandresult = new validationandresult(); 
		$json_validation = $validationandresult->json_validation();
		if(!empty($json_validation)){
			$this->response($json_validation, 202);
		}else{
				$pre_key = array("userId","disturbStatus");
				$result = $validationandresult->keyvalidation($pre_key);
				if($result['msg'] != ''){	
					$this->response($result, 202);
				}else{
					if($this->checkAuth()=="1"){
								$this->status();
					}else{
						$result = $validationandresult->fail($results,"Authentication Failed");
						$this->response($result,202);
					}
				}
		}
	}
	function checkAuth(){
		
		$headers = apache_request_headers();
		 // here you can check access token of perticular user as well from db
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
	function status(){
				  $validationandresult = new validationandresult(); 
				  $results= $this->Distrubstatus_model->index();
				  $result = $validationandresult->success($results);
				  $this->response($result, 200);
	}
	
}
