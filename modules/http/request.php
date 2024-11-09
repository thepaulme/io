<?php
namespace io\Http;

class Request {

	/**
	 * @var string
	 */
	private $requestUri;

	public function getUri () {

		if (null !== $qs = $this -> getQueryString ()) {
			$qs = '?' . $qs;
		}

		return $this -> getScheme () . "://" . $this -> getHost () . $this -> getRequestUri () . $qs;
	}

	/**
	 * Returns the requested URI (path and query string).
	 *
	 * @return string The raw URI (i.e. not URI decoded)
	 */
	public function getRequestUri () {
		if (null === $this -> requestUri) {
			$this -> requestUri = $this -> prepareRequestUri ();
		}
// echo($this -> requestUri);
// echo "\n";
		return $this -> requestUri;
	}

	private function prepareRequestUri () {
		$requestUri = parse_url (preg_replace ("#/$#", "", $_SERVER['REQUEST_URI']))["path"];
		$requestUri = $requestUri == "" ? "/" : $requestUri;

		return $requestUri;
	}

	/**
	 * Returns the host name.
	 *
	 * This method can read the client host name from the "X-Forwarded-Host" header
	 * when trusted proxies were set via "setTrustedProxies()".
	 *
	 * The "X-Forwarded-Host" header must contain the client host name.
	 *
	 * @return string
	 *
	 * @throws SuspiciousOperationException when the host name is invalid or not trusted
	 */
	public function getHost () {
		$host = $_SERVER["SERVER_NAME"];

		return $host;
	}

	/**
	 * Gets the request's scheme.
	 *
	 * @return string
	 */
	public function getScheme () {
		return $this -> isSecure () ? 'https' : 'http';
	}

	public function getMethod () {
		return $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Checks whether the request is secure or not.
	 *
	 * This method can read the client protocol from the "X-Forwarded-Proto" header
	 * when trusted proxies were set via "setTrustedProxies()".
	 *
	 * The "X-Forwarded-Proto" header must contain the protocol: "https" or "http".
	 *
	 * @return bool
	 */
	public function isSecure () {
		$https = $_SERVER["HTTPS"];

		return !empty ($https) && 'off' !== strtolower ($https);
	}

	/**
	 * Generates the normalized query string for the Request.
	 *
	 * It builds a normalized query string, where keys/value pairs are alphabetized
	 * and have consistent escaping.
	 *
	 * @return string|null A normalized query string for the Request
	 */
	public function getQueryString () {
		$qs = static::normalizeQueryString ($_SERVER["QUERY_STRING"]);

		return '' === $qs ? null : $qs;
	}

	/**
	 * Normalizes a query string.
	 *
	 * It builds a normalized query string, where keys/value pairs are alphabetized,
	 * have consistent escaping and unneeded delimiters are removed.
	 *
	 * @param string $qs Query string
	 *
	 * @return string A normalized query string for the Request
	 */
	private static function normalizeQueryString ($qs) {
		if ('' == $qs) return '';

		parse_str ($qs, $qs);
		ksort ($qs);

		return http_build_query ($qs, '', '&', PHP_QUERY_RFC3986);
	}

}