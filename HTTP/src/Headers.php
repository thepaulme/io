<?php
namespace IO\HTTP;

class Headers {
	public $headers = [];

	public function __construct (Array $headers = []) {
		foreach ($headers as $key => $values) {
			$this -> set ($key, $values);
		}
	}

/*
	public function __destruct() {
		print_r($this -> headers);
	}
*/

	public function set ($key, $values, $replace = true) {
		$key = str_replace('_', '-', strtolower($key));

		if (is_array($values)) {
			$values = array_values($values);
	
			if (true === $replace || !isset($this -> headers[$key])) {
				$this -> headers[$key] = $values;
			} else {
				$this -> headers[$key] = array_merge($this -> headers[$key], $values);
			}
		} else {
			if (true === $replace || !isset($this -> headers[$key])) {
				$this -> headers[$key] = [$values];
			} else {
				$this -> headers[$key][] = $values;
			}
		}

		if ('cache-control' === $key) {
// 			$this->cacheControl = $this->parseCacheControl(implode(', ', $this->headers[$key]));
		}
	}
}