<?php

namespace App\Helpers;

class Cbis
{
	public static function sendSms($mobile, string $msg)
	{
		if(isset($mobile) && !empty($mobile)){
			$url = "https://alerts.cbis.in/SMSApi/send?userid=taplog&password=Tlog@321&sendMethod=quick&mobile=".$mobile."&msg='".urlencode($msg)."'&senderid=TapLog&msgType=text&duplicatecheck=true&output=json&sendMethod=quick";
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "GET",
				CURLOPT_HTTPHEADER => array(
					"cache-control: no-cache"
				),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				return "cURL Error #:" . $err;
			} else {
				return $response;
			}
		}else{
			return response()->json([
				'status' => 'not ok',
				'message' => 'mobile number not found!'
			]);
		}
	}
}