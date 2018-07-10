<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//error_reporting(0);
require APPPATH.'/libraries/REST_Controller.php';
require APPPATH.'/libraries/validationandresult.php';

class Imageupload extends REST_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); // Library use to validate given input.
		$this->form_validation->set_error_delimiters('', ''); 
		$this->load->helper('file');
	}
	
	function index_post(){
		$validationandresult = new validationandresult(); 
		
		 if ($_FILES["image_file"]["name"] != "") {
            $my_strings                = substr(str_shuffle(MD5(microtime())), 0, 9);
            $name                      = $_FILES["image_file"]["name"];
            $ext                       = end((explode(".", $name)));
            $_FILES["image_file"]["name"] = $my_strings . "_pics.". $ext;
            $image_file                   = $_FILES["image_file"]["name"];
            $_POST['image_file']          = $_FILES["image_file"]["name"];
            move_uploaded_file($_FILES["image_file"]["tmp_name"], "./uploads/" . $image_file);
            $picture = base_url() . 'uploads/' . $image_file;
        } //$_FILES["picture"]["name"] != ""
        else {
            $picture = "";
        }
        $results= array("imageUrl" =>$picture);
	    $result = $validationandresult->success($results);
	    $this->response($result, 200);
		
		/*
		
		
		 $image_file=time().$_FILES["image_file"]["name"];
		   if($image_file !=""){ 
			    $config['allowed_types'] = '*';
				$config['upload_path'] = './uploads/';
				$this->load->library('upload', $config);
				$ext=explode(".",$image_file);
				$extenstion=$ext[1]; 
				/*
				if(!($extenstion=="jpg" || $extenstion=="png" ||$extenstion=="gif" ||$extenstion=="jpeg" ||$extenstion=="JPEG" ||$extenstion=="GIF" ||$extenstion=="PNG" ||$extenstion=="JPG"  ||$extenstion=="JPG"  )){	
				    $result = "invalid Image";
					$result = $validationandresult->fail($results,"Invalid Format");
					$this->response($result,202);
				}
				else{
				   $up = $this->upload->do_upload('image_file');
				   print_r($up);
				   $data = $this->upload->data();
				    print_r($data);
				   $file_name= $data['file_name'];
				   print_r($file_name);
				   $error= $this->upload->display_errors(); 
				    print_r($error);
				   $result = 'http://52.11.205.56/properset/uploads/'.$file_name;
				   $results= array("imageUrl" => $result);
				   $result = $validationandresult->success($results);
				   $this->response($result, 200);
				}
			   $up = $this->upload->do_upload('image_file');
			   $data = $this->upload->data();
			   $file_name=  $data['file_name'];
			   $error= $this->upload->display_errors();  
			   $result = 'http://52.15.118.146/properset/uploads/'.$file_name;
			   $results= array("imageUrl" =>$result);
			   $result = $validationandresult->success($results);
			   $this->response($result, 200);
		}
		*/
	}
	
}
