<?php
namespace io\Routing;

class CompiledRoute {

	private $regex;
	private $tokens;
	private $variables;

	public function __construct (String $regex, Array $tokens, Array $variables) {
		$this -> regex = $regex;
		$this -> tokens = $tokens;
		$this -> variables = $variables;	
	}

	public function getRegex () {
		return $this -> regex;
	}

	public function getTokens () {
		return $this -> tokens;
	}

	public function getVariables () {
		return $this -> variables;
	}
}