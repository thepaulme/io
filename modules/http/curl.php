<?php

namespace io\Http;

class cURL
{

	private $ch = null;

	public function __construct(String $url, $params, String $method = "POST", array $headers = [])
	{
		$this->ch = curl_init();

		curl_setopt($this->ch, CURLOPT_URL, $url);
		curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($this->ch, CURLOPT_FAILONERROR, true);

		if (count($headers) > 0) {
			curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
		} elseif (count($headers) == 0) {
			curl_setopt($this->ch, CURLOPT_HEADER, false);
			// curl_setopt($this->ch, CURLOPT_HTTPHEADER, false);
		}

		switch ($method) {
			case "POST":
				$this->setPostMethod($params);
				break;
			case "GET":
				$this->setGetMethod($params, $url);
				break;
		}
	}

	private function setPostMethod($params)
	{
		curl_setopt($this->ch, CURLOPT_POST, 1);

		if (is_string($params)) {
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
		} elseif (is_array($params)) {
			curl_setopt($this->ch, CURLOPT_POSTFIELDS, $params);
			// curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));
		}
	}

	private function setGetMethod($params, String $url = '')
	{
		if (count($params) > 0) {
			$url = $url . "?" . http_build_query($params);
			curl_setopt($this->ch, CURLOPT_URL, $url);
		}
	}

	public function exec()
	{
		if ($this->ch === null) {
			return false;
		}

		$exec_result = curl_exec($this->ch);
// print_r($exec_result);
		if ($exec_result === false) {
			return [
				"error" => curl_error($this->ch),
				"code" => curl_errno($this->ch)
			];
		} else {
			$curl_info = [
				"info" => curl_getinfo($this->ch),
				"data" => $exec_result
			];

			curl_close($this->ch);

			return $curl_info;
		}

		// return $exec_result;

		// if ($exec = curl_exec($this->ch) === false) {
		// 	return curl_error($this->ch);
		// } else {
		// 	$result = curl_getinfo($this->ch);

		// 	curl_close($this->ch);

		// 	return $exec;
		// }

		//$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	}
}
