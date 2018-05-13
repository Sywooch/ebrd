<?php

namespace frontend\components\yandex;

use frontend\components\yandex\YandexInterface;

class YandexRequest implements YandexInterface
{
	public $yandexUrl = 'https://api-metrika.yandex.ru/management/v1/counter/';

	private $counterId = '47926829';


	public function createGoal()
	{
		$url = $this->yandexUrl . $this->counterId . '/goals?';
		
		$data = [
			'goal' => 'testCURLgoal'
		];
		
		$this->sendCurl($url, $data);

	}
	

		private function sendCurl($url, $data = null, $type = 'POST')
	{
		$json = json_encode($data);

		$curl = curl_init(); # Save the cURL session handle
		# Set the necessary options for cURL session
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//		curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-API-client/1.0');
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST , $type);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
		curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
		curl_setopt($curl, CURLOPT_HEADER, false);
//		curl_setopt($curl, CURLOPT_COOKIEFILE, __DIR__ . '/amo_cookie.txt');
//		curl_setopt($curl, CURLOPT_COOKIEJAR, __DIR__ . '/amo_cookie.txt');
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

		$out = curl_exec($curl); # Initiate a request to the API and stores the response to variable
		$code = curl_getinfo($curl, CURLINFO_HTTP_CODE); # Obtain the HTTP-server response code
		curl_close($curl); # Close cURL session
		
		return $this->processRequest($code, $out);
	}
	
	private function processRequest(int $code, string $out)
	{
		$errors = [
			301 => 'Moved permanently',	
			400 => 'Bad request',
			401 => 'Unauthorized',
			403 => 'Forbidden',
			404 => 'Not found',
			500 => 'Internal server error',
			502 => 'Bad gateway',
			503 => 'Service unavailable'
		];
		
		try {
			# If the response code is not equal to 200 or 204 - returns an error message
			if($code!=200 && $code!=204) {
				throw new \Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error', $code);
			}				
		} catch(\Exception $E) {
			die('Error: '.$E->getMessage().PHP_EOL.'Error code: '.$E->getCode());
		}

		return json_decode($out,true);
	}
}
