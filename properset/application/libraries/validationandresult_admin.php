<?php
	class validationandresult {
		
		
		
		
		
		function formvalidation($validation_errors) {
			
			
			$result = array ( "result" => "" );
			$message = array("StatusCode" => "0","message" => $validation_errors,"result" => $result);
			return $message;
			
			
		}
		
		
		
		function successmessagewithresult($result) {
			
			
			$message = array("StatusCode" => "1","message" => "success","result" => $result);
			return $message;
			
			
		}
		
		
	}
 ?>