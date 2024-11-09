<?php
namespace io\Routing;

use io\Http\Request;
use io\Http\Response;

class Router {

	/**
	 * 
	 * 
	 * @var \Routing\RouteCollection
	 */
	public $routes;

	public function __construct () {
// 		echo (new Request) -> getUri ();

		$this -> routes = new RouteCollection;
// 		print_r($this -> routes);
// 		$route -> compileRoute ();

	}

	public function __destruct () {
		$route = $this -> findRoute (new Request);

		if (false === $route) {
			$response = new Response (
				'',
				Response::HTTP_NOT_FOUND,
				array('Content-Type' => 'text/html')
			);
//print_r($response);
//			$response -> send ();
		}
	}

	/**
	 * Add a route to the underlying route collection.
	 *
	 * @param  array|string  $methods
	 * @param  string  $uri
	 * @param  \Closure|array|string|null  $callback
	 * @return \Illuminate\Routing\Route
	 */
	private function addRoute ($methods, $uri, $callback) {
		return $this -> routes -> add ($this -> createRoute ($methods, $uri, $callback));
	}

	/**
	 * Create a new route instance.
	 *
	 * @param  array|string  $methods
	 * @param  string  $uri
	 * @param  mixed  $callback
	 * @return \Illuminate\Routing\Route
	 */
	private function createRoute ($methods, $uri, $callback) {

		$route = new Route ($methods, $uri, $callback);

// 		print_r($route);

		//return new Route ($methods, $uri, $callback);
	// If the route is routing to a controller we will parse the route action into
	// an acceptable array format before registering it and creating this route
	// instance itself. We need to build the Closure that will call this out.
/*
	if ($this->actionReferencesController($action)) {
		$action = $this->convertToControllerAction($action);
	}
	
	$route = $this->newRoute(
	$methods, $this->prefix($uri), $action
	);
*/
	
	// If we have groups that need to be merged, we will merge them now after this
	// route has already been created and is ready to go. After we're done with
	// the merge we will be ready to return the route back out to the caller.
/*
	if ($this->hasGroupStack()) {
	$this->mergeGroupAttributesIntoRoute($route);
	}
	
	$this->addWhereClausesToRoute($route);
*/

		return $route;
	}

	public function get ($uri, $callback = null) {
		return $this -> addRoute (["GET"], $uri, $callback);
	}

	public function post ($uri, $callback = null) {
		return $this -> addRoute (["POST"], $uri, $callback);
	}

	protected function runRoute (Request $request, Route $route) {
		$request -> setRouteResolver (function () use ($route) {
			return $route;
		});

//		$this -> events -> dispatch (new Events\RouteMatched ($route, $request));

		return $this -> prepareResponse ($request,
			$this -> runRouteWithinStack ($route, $request)
		);
	}

	/**
	 * Find the route matching a given request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Routing\Route
	 */
	protected function findRoute (Request $request) {
//print_r($this -> routes);
		$route = $this -> routes -> match ($request);

//print_r($route);
//  		echo 'ыва';
		
/*
		$this->current = $route = $this->routes->match($request);
	
		$this->container->instance(Route::class, $route);
*/

		return $route;
	}

}