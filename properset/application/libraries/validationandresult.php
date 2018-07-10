<?php
error_reporting(0);
	class validationandresult {
		function json_validation(){
			
			$entity = file_get_contents('php://input');
			if($this->isJSON($entity)){ 
				$this->converttopostvalue($entity);
			}else{ 
				return $this->invalid_json();
			}
		
		}
		function invalid_json(){
			
			$result = array ();
			$message = array("error_code" => "0","msg" => "Invalid JSON","result" => $result);
			return $message;
			
			
		}
		function converttopostvalue($entity){
			
			
			if((isset($entity)) && ($entity != '')){
				$object = json_decode($entity);
				$propertyName = get_object_vars($object);
				$post_key = array_keys($propertyName);
				foreach($propertyName as $key=>$val){
					$_POST[$key] = $val;
				}
			}
			
		}
		
		function isJSON($string){
		   return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
		}
		function keyvalidations($pre_key,$mode,$api_name,$parameter) {
			
			
			
		}
		function keyvalidation($pre_key) {
			
			
			$post_key = array_keys($_POST);	
			$result=array_diff($pre_key,$post_key);
			$resc = implode(",",$result);
			$result = array ( );
			$message = array("error_code" => "0","msg" => $resc,"result" => $result);
			return $message;
			
			
		}
		
		function success($result){
			
			$message = array("error_code" => "1","msg" => "Success","result" => $result);
			return $message;
		}
		
		function fail($result,$messsage){
			
			$result = array();
			$message = array("error_code" => "0","msg" => $messsage,"result" => $result);
			return $message;
		}
		function keyvalidations_custom($pre_key,$req_key,$decoded){
			$validate= true;
		    $message="";
			foreach($req_key as $val){
				if($decoded[$val]==""){
					$validate= false;
					$message .= $val. " field is required,";
				}
            }
			$message = rtrim($message, ',');
			$error = $message;
			$result = array ();
			$message = array("error_code" => "0","msg" => $error,"result" => $result);
			return $message;
		}
		
	}
 ?>