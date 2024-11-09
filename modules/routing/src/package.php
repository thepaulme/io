<?php
namespace io;

class Route extends Packages\Pack {

	protected static function getPackage () {
// 		$class = ;

		if (class_exists('\io\Routing\Router', false)) {
 			echo 'y';
		}
	}

}