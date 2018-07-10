<?php
	class validationandresult {
		
		
		function keyvalidation($pre_key) {
			
			
			$post_key = array_keys($_POST);	
			$result=array_diff($pre_key,$post_key);
			$resc = implode(",",$result);
			$result = Array ( "result" => "" );
			
			$message = array("response_code" => "0","message" =>$resc,"result" => $result);
			return $message;
			
			
		}
		
		function formvalidation($validation_errors) {
			
			
			$result = Array ( "result" => "" );
			//$result = [];
			$message = array("response_code" => "0","message" => $validation_errors,"result" => $result);
			return $message;
			
			
		}
		
		function successmessagewithemptyresult() {
			
			
			$result = Array ( "result" => "" );
			//$result = "";
			$message = array("response_code" => "1","message" => "success","result" => $result);
			return $message;
			
			
		}
		
		function successmessagewithresult($result) {
			
			
			$message = array("response_code" => "1","message" => "success","result" => $result);
			return $message;
			
			
		}
		
		function custommessage($message) {
			
			$result = Array ( "result" => "" );
			//$result = [];
			$message = array("response_code" => "1","message" => $message,"result" => $result);
			return $message;
			
			
		}
		
		function invalidrequest() {
			
			
			$result = Array ( "result" => "" );
			//$result = [];
			$message = array("response_code" => "1","message" => "Invalid Request!","result" => $result);
			return $message;
			
			
		}
		function card() {
			
			
			$result = Array ( "result" => "" );
			//$result = [];
			$message = array("response_code" => "2","message" => "Paymnet details not added","result" => $result);
			return $message;
			
			
		}
		
	}
 ?>