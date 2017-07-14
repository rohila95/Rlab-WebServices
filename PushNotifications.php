<?php
// Server file
echo "inside pnphp";
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
		$message = array (
				'title' => $data ['mtitle'],
				'message' => $data ['mdesc'],
				'subtitle' => 'dummy',
				'tickerText' => 'dummy',
				'msgcnt' => 1,
				'vibrate' => 1
		);

		$headers = array (
				'Authorization: key=' . self::$API_ACCESS_KEY,
				'Content-Type: application/json'
		);

		$fields = array (						
				'to' => $reg_id,
				'data' => $message
		);
		
		return $this->useCurl ( $url, $headers, json_encode ( $fields ),$message );
	}

	public function useCurl($url, $headers, $fields,$message) {
		// Open connection
		//print_r($fields);
		$ch = curl_init ();
		if ($url) {
			// Set the url, number of POST vars, POST data
			curl_setopt ( $ch, CURLOPT_URL, $url );
			curl_setopt ( $ch, CURLOPT_POST, true );
			curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
				
			// Disabling SSL Certificate support temporarly
			curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
			if ($fields) {
				
				//curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
				echo $fields;
				
				echo "------------------------------>";
				
			
				
				$postStr = "{ \"data\":".json_encode($message).",
  				\"to\" : \"d6xWsRS66eQ:APA91bFCSj0y9aenNSHWa4JNvQeH5K84_jkUMlIRvnCUrDKHQ6iCYjWQ5kS86HoCxetjdp3iJRY_ljBHioUxATCLPkIb3eHxRnbxDNJQX-EG_CJ3lA0-GDhG6K_uyXANVQtoWpkSN50b\"}";
				
				echo $postStr;
				curl_setopt ( $ch, CURLOPT_POSTFIELDS,$fields);
			}
				
			// Execute post
			$result = curl_exec ( $ch );
			
			if ($result === FALSE) {
				die ( 'Curl failed: ' . curl_error ( $ch ) );
			}
				
			// Close connection
			curl_close ( $ch );
				
			return $result;
		}
	}

}
?>