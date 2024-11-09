<?php
namespace io;

// use io\Extentions;

if (PHP_VERSION_ID < 80000) {
    echo 'io support PHP > 8.0.0 and you are running ' . phpversion() . ', please upgrade PHP ' . PHP_EOL;
    exit(1);
}

if (PHP_SAPI !== 'cli' && PHP_SAPI !== 'phpdbg') {
    echo 'Warning: io should be invoked via the CLI version of PHP, not the ' . PHP_SAPI. ' SAPI' . PHP_EOL;
}

$commands = [
	"make"
];

$command = $_SERVER["argv"][2];

if ($key = array_search($command, $commands) === false) {
	echo 'Warning: io does not exists command "' . $command . '"';
}

define("IO_PATH", __DIR__); // framework io path
define("APP_PATH", $argv[1]); // application path

// io::runCommand($argv[count($argv) - 1]);

// if ($argv[1]) $make = new make($argv[1]);

spl_autoload_register(function ($namespace) {

	if ($pos = strpos($namespace, "\\") === false) {
		echo 'false' . PHP_EOL; // нет namespace;
	} else {
		echo 'true' . PHP_EOL; // есть namespace;
	}

//	echo $namespace . PHP_EOL;

// $prefix = $namespace;

// $pos = strrpos($prefix, '\\');

//echo $prefix = substr($namespace, 0, $pos + 1) . PHP_EOL;

	// $prefix = trim($namespace, '\\') . '\\' . PHP_EOL;

// $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

	$namespaceFragments = explode("\\", $namespace);

	print_r($namespaceFragments);

	$classname = $namespaceFragments[count($namespaceFragments)-1];

	// echo __DIR__ . DIRECTORY_SEPARATOR . $namespaceFragments[0] . PHP_EOL;
// echo __DIR__ . PHP_EOL;

	$pack = new pack(__DIR__);
	// $pack->getPack();

	// $pack->getPSR4();

exit();

	if ($pack->json["autoload"]["psr-4"]) {

		//$namespace = $pack->json["autoload"]["psr-4"][$namespaceFragments . "\\"]

		if ($pack->json["autoload"]["psr-4"][$namespaceFragments[0] . "\\"]) {
			$classpath = __DIR__ . DIRECTORY_SEPARATOR . $pack->json["autoload"]["psr-4"][$namespaceFragments[0] . "\\"] . DIRECTORY_SEPARATOR . $classname . ".php";

			// if (isset($classpath)) {
			// 	require $classpath;
			// 	// echo 'ok';
			// }
		}

		// echo $namespaceFragments[0] . PHP_EOL;
		// print_r($pack->json["autoload"]["psr-4"]) . PHP_EOL;

		// if (array_key_exists($namespaceFragments[0] . "\\", $pack->json["autoload"]["psr-4"])) {

			
		// 	echo $namespaceFragments[0] . "\\" . PHP_EOL;
		// }
	}

// exit();

		// if ($json["files"]["psr-4"][$namespace]) {

		// 	$namespaceFragments = explode("\\", $namespace);
		// 	$class = $namespaceFragments[count($namespaceFragments) - 1];

			// echo $dir . "/" . $json["files"]["psr-4"][$namespace] . "/" . $class . ".php";

		// }

});

//	io::runCommand($argv[count($argv) - 1]);

// if ($argv[1]) $make = new make($argv[1]);

// class io
// {
// 	static $commands = ["make"];

// 	static public function runCommand($command) {
// 		if ($key = array_search($command, self::$commands) === false){
// 			echo 'false';
// 		};
// 	}
// }