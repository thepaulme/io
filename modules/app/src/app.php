<?php
namespace io;

class App {

	const VERSION = '1.0.0';

	const IO_PATH = '.io';

	const CACHE_PATH = '';

	private static $appPath;

	/**
	 * The registered type aliases.
	 *
	 * @var array
	 */
	protected $aliases = [];
	
	/**
	 * The registered aliases keyed by the abstract name.
	 *
	 * @var array
	 */
	protected $abstractAliases = [];

	/**
	 * Instances.
	 *
	 * @var array
	 */
	public $instances = [];

	public function __construct ($appPath = null) {
		if ($appPath) {
			$this -> setAppPath ($appPath);
		}

		try {
			$this -> createPartisanDir ();
		} catch (\Exception $e) {
			print_r($e -> getMessage ());
		}

//		$this -> reg ();

// 		$this -> instances["db"] = new \Partisan\Database\Database;
//		$this -> instances["router"] = new \Partisan\Routing\Router;

		Pack::setApplication ($this);

// print_r($this -> instances["router"]);
/*
		print_r($this -> abstractAliases);
		print_r($this -> aliases);
*/

// 		$this -> registerCoreAliases ();

//		AliasLoader::getInstance ($this -> aliases) -> register ();
	}

	protected function setAppPath ($path) {
		static::$appPath = rtrim ($path, DIRECTORY_SEPARATOR);

		return $this;
	}

	public function appPath () {
		return static::$appPath;
	}

	protected function createPartisanDir () {
		$pastisanDir = $this -> appPath () . DIRECTORY_SEPARATOR . self::PARTISAN_PATH;

		if (file_exists ($pastisanDir)) return true;

		if (false === @mkdir ($pastisanDir)) {
			throw new ErrorException ('<b>Fatal error</b>: Partisan can not create "' . DIRECTORY_SEPARATOR . self::PARTISAN_PATH . '" folder in the root folder of the application. Check the permissions on the root folder (chmod("' . DIRECTORY_SEPARATOR . self::PARTISAN_PATH . '", 0700)).', 1);
		}
	}

	protected function cachePath () {
//		return 
	}

	private function alias ($abstract, $alias) {
		$this -> aliases[$alias] = $abstract;

		$this -> abstractAliases[$abstract][] = $alias;
	}

	private function reg () {
		foreach ([
			'db' => [\Partisan\Database\Database::class],
			'routing' => [\Partisan\Routing\Router::class, \Partisan\Routing\Route::class]
		] as $key => $aliases) {
			foreach ($aliases as $alias) {
				$this -> alias ($key, $alias);
			}
		}
	}


}