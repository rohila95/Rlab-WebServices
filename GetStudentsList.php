<?php
include 'DBfile.php';

class PushNotifications {
	// (Android)API access key from Google API's Console.
	public static $API_ACCESS_KEY = 'AAAAfE4vpIk:APA91bHHXdQSuWIjPyntpDvMTJohykTzrBug8AJgfYSkmyw7Khsfv42nbD9npXLJ7T5FgfC2FfsrDlF4Y6o6OQsAi5Ow6a7smUcANxs8jtPBMm6IEO0qGwpnOfDDmmTAua_V4F09AHRi5gmrWUcHRINUW7Sqoigl1A';
	// (iOS) Private key's passphrase.
	public static $passphrase = 'joashp';
	// (Windows Phone 8) The name of our push channel.
	public static $channelName = "joashp";

	function PushNotifications() {
		$this->model = "xyz";
	}

	// Change the above three vriables as per your app.
	/*
	 * public function __construct() {
	 * exit('Init function is not allowed');
	 * }
	 */

	// Sends Push notification for Android users
	public function android($data, $reg_id) {
		$url = 'https://fcm.googleapis.com/fcm/send';
		echo $url;
		
		$message =  array (
				'title' => $data ['mtitle'],
				'message' => $data ['mdesc'],
				'subtitle' => '121',
				'tickerText' => 'asdasd',
				'msgcnt' => 1,
				'vibrate' => 1
		); 
		
		$data= array(json_encode($message));
		 
		//echo $message[0];
		$headers =array('Content-Type: application/json',
		"Authorization: key=AAAAfE4vpIk:APA91bHHXdQSuWIjPyntpDvMTJohykTzrBug8AJgfYSkmyw7Khsfv42nbD9npXLJ7T5FgfC2FfsrDlF4Y6o6OQsAi5Ow6a7smUcANxs8jtPBMm6IEO0qGwpnOfDDmmTAua_V4F09AHRi5gmrWUcHRINUW7Sqoigl1A");
	
		$fields = array (
				'registration_ids' => array ($reg_id),
				'data' => new PushNotifications()
		);
		//echo json_encode($message);
		
		$dummy = json_encode ($fields);
		//echo "Hello";
		//echo $dummy;
		
		return $this->useCurl ( $url, $headers, $fields,$message);
	}

	public function useCurl($url, $headers, $fields,$message) {
		// Open connection
		$ch = curl_init ();
		if ($url) {
		//	echo "{ \"data\": {\"data\":".json_encode($message)."},
 // \"to\" : \"d6xWsRS66eQ:APA91bFCSj0y9aenNSHWa4JNvQeH5K84_jkUMlIRvnCUrDKHQ6iCYjWQ5kS86HoCxetjdp3iJRY_ljBHioUxATCLPkIb3eHxRnbxDNJQX-EG_CJ3lA0-GDhG6K_uyXANVQtoWpkSN50b\"}";
			// Set the url, number of POST vars, POST data
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_POST, true );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
			echo "encoded Json:->".json_encode($message);
			echo " ";
			
			$postStr = "{\"data\":".json_encode($message).",
 \"to\" : \"d6xWsRS66eQ:APA91bFCSj0y9aenNSHWa4JNvQeH5K84_jkUMlIRvnCUrDKHQ6iCYjWQ5kS86HoCxetjdp3iJRY_ljBHioUxATCLPkIb3eHxRnbxDNJQX-EG_CJ3lA0-GDhG6K_uyXANVQtoWpkSN50b\"}";
			
			
			//$postStr = "{\"data\": {\"data\":".json_encode($message)."},
  //\"to\" : \"d6xWsRS66eQ:APA91bFCSj0y9aenNSHWa4JNvQeH5K84_jkUMlIRvnCUrDKHQ6iCYjWQ5kS86HoCxetjdp3iJRY_ljBHioUxATCLPkIb3eHxRnbxDNJQX-EG_CJ3lA0-GDhG6K_uyXANVQtoWpkSN50b\"}";
				
			
			
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $postStr);
				
			// Disabling SSL Certificate support temporarly
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
				
			// Execute post
			echo " ";
			$result = curl_exec ( $ch );
			
			echo $result;
			
			if ($result === FALSE) {
				die ( 'Curl failed: ' . curl_error ( $ch ) );
			}
				
			// Close connection
			curl_close ( $ch );
				
			return $result;
		}
	}

	public function hello() {
		echo "In function";
		// return "function returned";
	}
}

/* $sql="SELECT userid,username from userdetails where role='Student'";
$result=$conn->query($sql);

if($result->num_rows>0)
{

	while($row =$result->fetch_assoc())
	{
		$value[]=$row;
	}
}
 */
$pn= new PushNotifications();

$reg_id="d6xWsRS66eQ:APA91bFCSj0y9aenNSHWa4JNvQeH5K84_jkUMlIRvnCUrDKHQ6iCYjWQ5kS86HoCxetjdp3iJRY_ljBHioUxATCLPkIb3eHxRnbxDNJQX-EG_CJ3lA0-GDhG6K_uyXANVQtoWpkSN50b";
$data1['mtitle']="khaidhino 150";
$data1['mdesc']="chiranjeevi 150th movie";
/* echo "hello";
echo $data1['mtitle'];  */ 

$pn->hello();
//$data={"mtitle":"khaidhino 150", "mdesc":"chiranjeevi 150th movie"};
$pn->android($data1, $reg_id);
/* $data=array("students_list"=>$value);
echo json_encode($data); */


?>