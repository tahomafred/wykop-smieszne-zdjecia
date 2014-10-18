<?php

/**
 * Class Input
 */
class Input {
	static private $get;
	static private $post;

	static public function init() {
		foreach($_GET as $key => $val) {
			self::$get[ $key ] = $val;
		}

		foreach($_POST as $key => $val) {
			self::$post[ $key ] = $val;
		}
	}

	static public function __callStatic($name, $args) {
		if('get' === strtolower($name)) {
			if(isset(self::$get[ $args[0] ])) {
				return self::$get[ $args[0] ];
			}
		} elseif('post' === strtolower($name)) {
			if(isset(self::$post[ $args[0] ])) {
				return self::$post[ $args[0] ];
			}
		}

		return false;
	}
}