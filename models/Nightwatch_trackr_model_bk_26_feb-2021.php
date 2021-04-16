<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nightwatch_trackr_model extends CI_Model{	
	
	
	
 public function requestApi($rankTrackerDetail, $request_url, $request_method, $data = ''){
		
		$result = array();
		
		if($request_method == "GET"){
			$query = "";
			foreach( $data as $key => $value ) 
			
			if(is_array($value)){
				foreach($value as $k => $v){
					$query .= urlencode($key) . '[]=' . $v . '&';
				}
			}else{
				$query .= urlencode($key) . '=' . urlencode($value) . '&';
			}
			
			$query = rtrim($query, '& ');
			
		
			$url = 'https://api.nightwatch.io'.$request_url.'?' . $query;
			//echo $url.'==><br/>';
		}else{
			$url = 'https://api.nightwatch.io'.$request_url;
		}
	
		$request = curl_init($url); // initiate curl object
		curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
		curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
		
		if($request_method == "POST"){
			curl_setopt($request, CURLOPT_POSTFIELDS, $data); // use HTTP POST to send form data
		}
		
		curl_setopt($request, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($request, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment if you get no gateway response and are using HTTPS

		$response = (string)curl_exec($request); // execute curl post and store results in $response

		
		curl_close($request); // close curl object

		
		if ( !empty($response) ) {
			
			$result = json_decode($response);
			//die('Nothing was returned. Do you have a connection to Email Marketing server?');
		}
		
		return $result;
		
 }
	
	
}