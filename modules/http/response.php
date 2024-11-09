<?php
namespace io\Http;

class Response {

	const HTTP_CONTINUE = 100;
	const HTTP_SWITCHING_PROTOCOLS = 101;
	const HTTP_PROCESSING = 102;            // RFC2518
	const HTTP_EARLY_HINTS = 103;           // RFC8297
	const HTTP_OK = 200;
	const HTTP_CREATED = 201;
	const HTTP_ACCEPTED = 202;
	const HTTP_NON_AUTHORITATIVE_INFORMATION = 203;
	const HTTP_NO_CONTENT = 204;
	const HTTP_RESET_CONTENT = 205;
	const HTTP_PARTIAL_CONTENT = 206;
	const HTTP_MULTI_STATUS = 207;          // RFC4918
	const HTTP_ALREADY_REPORTED = 208;      // RFC5842
	const HTTP_IM_USED = 226;               // RFC3229
	const HTTP_MULTIPLE_CHOICES = 300;
	const HTTP_MOVED_PERMANENTLY = 301;
	const HTTP_FOUND = 302;
	const HTTP_SEE_OTHER = 303;
	const HTTP_NOT_MODIFIED = 304;
	const HTTP_USE_PROXY = 305;
	const HTTP_RESERVED = 306;
	const HTTP_TEMPORARY_REDIRECT = 307;
	const HTTP_PERMANENTLY_REDIRECT = 308;  // RFC7238
	const HTTP_BAD_REQUEST = 400;
	const HTTP_UNAUTHORIZED = 401;
	const HTTP_PAYMENT_REQUIRED = 402;
	const HTTP_FORBIDDEN = 403;
	const HTTP_NOT_FOUND = 404;
	const HTTP_METHOD_NOT_ALLOWED = 405;
	const HTTP_NOT_ACCEPTABLE = 406;
	const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
	const HTTP_REQUEST_TIMEOUT = 408;
	const HTTP_CONFLICT = 409;
	const HTTP_GONE = 410;
	const HTTP_LENGTH_REQUIRED = 411;
	const HTTP_PRECONDITION_FAILED = 412;
	const HTTP_REQUEST_ENTITY_TOO_LARGE = 413;
	const HTTP_REQUEST_URI_TOO_LONG = 414;
	const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
	const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
	const HTTP_EXPECTATION_FAILED = 417;
	const HTTP_I_AM_A_TEAPOT = 418;                                               // RFC2324
	const HTTP_MISDIRECTED_REQUEST = 421;                                         // RFC7540
	const HTTP_UNPROCESSABLE_ENTITY = 422;                                        // RFC4918
	const HTTP_LOCKED = 423;                                                      // RFC4918
	const HTTP_FAILED_DEPENDENCY = 424;                                           // RFC4918

	public static $statusTexts = [
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',            // RFC2518
		103 => 'Early Hints',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',          // RFC4918
		208 => 'Already Reported',      // RFC5842
		226 => 'IM Used',               // RFC3229
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',    // RFC7238
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Payload Too Large',
		414 => 'URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot',                                               // RFC2324
		421 => 'Misdirected Request',                                         // RFC7540
		422 => 'Unprocessable Entity',                                        // RFC4918
		423 => 'Locked',                                                      // RFC4918
		424 => 'Failed Dependency',                                           // RFC4918
		425 => 'Too Early',                                                   // RFC-ietf-httpbis-replay-04
		426 => 'Upgrade Required',                                            // RFC2817
		428 => 'Precondition Required',                                       // RFC6585
		429 => 'Too Many Requests',                                           // RFC6585
		431 => 'Request Header Fields Too Large',                             // RFC6585
		451 => 'Unavailable For Legal Reasons',                               // RFC7725
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',                                     // RFC2295
		507 => 'Insufficient Storage',                                        // RFC4918
		508 => 'Loop Detected',                                               // RFC5842
		510 => 'Not Extended',                                                // RFC2774
		511 => 'Network Authentication Required'                             // RFC6585
	];

	public $headers;

	public $data;

	protected $version;

	protected $statusCode;

	protected $statusText;

	protected $charset;

	public function __construct ($data = '', Int $status = 200, Array $headers = []) {
		$this -> headers = new Headers ($headers);
		$this -> setData ($data);
		$this -> setStatusCode ($status);
		$this -> setProtocolVersion('1.0');

// 		return $this;
	}

	public function setData ($data) {
/*
        if (null !== $data && !\is_string ($data) && !is_numeric ($data) && !\is_callable (array ($data, '__toString'))) {
            throw new \Exception (sprintf ('The Response content must be a string or object implementing __toString(), "%s" given.', \gettype ($data)));
        }
*/

		$this -> data = (string) $data;

//         return $this;
	}

/*
	public function setHeaders () {
		if (headers_sent ()) {
			return $this;
		}
	}
*/

	public function setProtocolVersion (string $version) {
		$this -> version = $version;

		return $this;
	}

	public function getProtocolVersion (): string {
		return $this -> version;
	}

	public function setStatusCode (Int $code, $text = null) {
		$this -> statusCode = $code;

		if (null === $text) {
			$this -> statusText = isset(self::$statusTexts[$code]) ? self::$statusTexts[$code] : 'unknown status';

			return $this;
		}

		if (false === $text) {
			$this -> statusText = '';

			return $this;
		}

		$this -> statusText = $text;

		return $this;
	}

	public function setCharset (String $charset) {
		$this -> charset = $charset;

		return $this;
	}

	public function sendHeaders () {
		// headers have already been sent by the developer
		if (headers_sent()) {
			return $this;
		}
// print_r($this -> headers);
		// headers
		foreach ($this -> headers -> headers as $name => $values) {
// 			$replace = 0 === strcasecmp($name, 'Content-Type');
			foreach ($values as $value) {
/*
				echo ($name . ": ". $value);
				echo "\n";
*/
//				echo $this -> statusCode;
				header($name . ': ' . $value, false, $this -> statusCode);
			}
		}

		// cookies
/*
		foreach ($this->headers->getCookies() as $cookie) {
			header('Set-Cookie: '.$cookie->getName().strstr($cookie, '='), false, $this->statusCode);
		}
*/

		// status
		header(sprintf('HTTP/%s %s %s', $this -> version, $this -> statusCode, $this -> statusText), true, $this -> statusCode);

		return $this;
	}

	public function sendData () {
		echo $this -> data;
	}

	public function send () {
		if ('HTTP/1.0' != $_SERVER['SERVER_PROTOCOL']) {
			$this -> setProtocolVersion ('1.1');
		}

		$this -> sendHeaders ();
		$this -> sendData ();
	}
}