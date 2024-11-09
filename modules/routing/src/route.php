<?php
namespace io\Routing;

use Closure;

class Route {

	/**
	 * The URI pattern the route responds to.
	 *
	 * @var string
	 */
	public $uri;

	/**
	 * The HTTP methods the route responds to.
	 *
	 * @var array
	 */
	public $methods;

	/**
	 * The route callback.
	 *
	 * @var Closure
	 */
	public $callback;

	/**
	 * The array of matched parameters.
	 *
	 * @var array
	 */
	public $parameters;

	/**
	 * The default values for the route.
	 *
	 * @var array
	 */
	public $defaults = [];

	/**
	 * The regular expression requirements.
	 *
	 * @var array
	 */
	public $wheres = [];

	/**
	 * The compiled version of the route.
	 *
	 * @var \Core\Router\CompiledRoute
	 */
	public $compiled;

//	private $variables = array ();

	/**
	 * Create a new Route instance.
	 *
	 * @param  array|string  $methods
	 * @param  string  $uri
	 * @param  Closure  $callback
	 * @return void
	 */
	public function __construct ($methods, $uri, $callback) {
		$this -> uri = $uri;
		$this -> methods = (array) $methods;
		$this -> callback = $callback; //$this -> parseAction ($action);
	}

	/**
	 * Run the route action and return the response.
	 *
	 * @return mixed
	 */
	public function runCallable ($args) {
		$callback = $this -> callback;

		if ($callback instanceof Closure) {
			call_user_func_array ($callback, $args);

//			return call_user_func ($callback, $value, $ff);
		}

		//return $callable(...array_values($this->resolveMethodDependencies($this->parametersWithoutNulls(), new ReflectionFunction($this->action['uses']))));
	}

	/**
	 * Get the HTTP verbs the route responds to.
	 *
	 * @return array
	 */
	public function getMethods () {
		return $this -> methods;
	}

	/**
	 * Get the URI associated with the route.
	 *
	 * @return string
	 */
	public function getUri () {
		return $this -> uri;
	}

	/**
	 * Set a regular expression requirement on the route.
	 *
	 * @param  array|string  $name
	 * @param  string  $expression
	 * @return $this
	 */
	public function where ($name, $pattern = null) {
		foreach ($this -> parseWhere ($name, $pattern) as $name => $pattern) {
			$this -> wheres[$name] = $pattern;
		}

		return $this;
	}

	/**
	 * Parse arguments to the where method into an array.
	 *
	 * @param  array|string  $name
	 * @param  string  $expression
	 * @return array
	 */
	private function parseWhere ($name, $pattern) {
		return is_array ($name) ? $name : [$name => $pattern];
	}

	public function getWhere ($name) {		
		return isset ($this -> wheres[$name]) ? $this -> wheres[$name] : null;
	}

	public function getWheres () {
		return $this -> wheres;
	}

	/**
	 * Determine a given parameter exists from the route.
	 *
	 * @param  string $name
	 * @return bool
	 */
	public function hasParameter ($name) {

		echo $name;
/*
		if ($this -> hasParameters ()) {
			return array_key_exists ($name, $this -> parameters ());
		}

		return false;
*/
	}

	/**
	 * Compile the route into CompiledRoute instance.
	 *
	 * @return \Core\Routing\CompiledRoute
	 */

	public function compile () {
		if (!$this -> compiled) {
			$this -> compiled = (new RouteCompiler ()) -> compile ($this);
		}

		return $this -> compiled;
	}


}