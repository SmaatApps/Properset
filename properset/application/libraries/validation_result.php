<?php
	class validationandresult {
		
		function json_validation(){
			
			$entity = file_get_contents('php://input');
			
			if($this->isJSON($entity)){ 
				$this->converttopostvalue($entity);
			}else{ 
				return $this->invalid_json();
			}
		
		}
		
		function api_name_validation(){
			
			$api_names = array('add_shop_logo','add_shop_images','add_staff_image','add_customer_image','login','forgot_password','registration','request_list','customer_request_list','shop_notifications','customer_payment_history','payment_history','update_payment_info','book_appointment','reject_appointment','accept_appointment','start_service','finish_service','shop_details','get_shop_details','staff_details','service_details','add_staff','edit_staff','delete_staff','add_service','edit_service','delete_service','review','post_offer','update_offer_availability','get_shop_offers','get_shop_services','report','update_profile','shop_list','contact','delete_notifications','settings','logout');
			
			if(!(in_array($_POST['api_name'],$api_names))){
				
				$result = array ( "result" => "" );
				$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "0","message" =>"Invalid Api Call","result" => $result); 
				return $message;
				
			}
		
		}
		function customer_api_name_validation(){
			
			
			$api_names = array('login','forgot_password','registration','shop_list','get_shop_details','customer_request_list','book_appointment','customer_payment_history','add_rating','add_favourite','get_favourite','customer_update_profile','customer_profile_details','customer_notifications','reject_appointment','review','contact','customer_payment_update','check_appointment_slot','delete_notifications','settings','logout'); 
			
			if(!(in_array($_POST['api_name'],$api_names))){
				
				$result = array ( "result" => "" );
				$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "0","message" =>"Invalid Api Call","result" => $result); 
				return $message;
				
			}
		
		}
		function invalid_json(){
			
			$result = array ( "result" => "" );
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "0","message" =>"Invalid JSON","result" => $result); 
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
			
		   return is_string($string) && is_array(json_decode($string, true))  ? true : false;
		}
		
		function keyvalidation($pre_key) {
			
			
			$post_key = array_keys($_POST);	
			$result=array_diff($pre_key,$post_key);
			$resc = implode(",",$result);
			$result = array ( "result" => "" );
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "0","message" =>$resc,"result" => $result);
			return $message;
			
			
		}
		
		function formvalidation($validation_errors) {
			
			
			$result = array ( "result" => "" );
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "0","message" => $validation_errors,"result" => $result);
			return $message;
			
			
		}
		
		function successmessagewithemptyresult() {
			
			
			$result = array ( "result" => "" );
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "1","message" => "success","result" => $result);
			return $message;
			
			
		}
		
		function successmessagewithresult($result) {
			
			
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "1","message" => "success","result" => $result);
			return $message;
			
			
		}
		function successmessagewithresult_blocked($result) {
			
			
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "-1","message" => "success","result" => $result);
			return $message;
			
			
		}
		function custommessage($message) {
			
			$result = array ( "result" => "" );
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "1","message" => $message,"result" => $result);
			return $message;
			
			
		}
		function custom_error_message($message,$code) {
			
			$result = array ( "result" => "" );
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => $code,"message" => $message,"result" => $result);
			return $message;
			
			
		}
		function successmessagewithemptyresultzero() {
			
			
			$result = array ( "result" => "" );
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "0","message" => "success","result" => $result); 
			return $message;
			
			
		}
		function invalidrequest() {
			
			
			$result = array ( "result" => "" );
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "0","message" => "Invalid Request!","result" => $result);
			return $message;
			
			
		}
		
		function accountclosed() {
			
			
			$result = array ( "result" => "" );
			$message = array("mode" => $_POST['mode'],"api_name" => $_POST['api_name'],"response_code" => "0","message" => "Account closed.","result" => $result);
			return $message;
			
			
		}
		
		
	}
 ?>