<?php

/**
 * Very simple autoloader
 *
 * Autoloader->addPrefixDirs("Auto\", "./autoloader");
 * new \Auto\Class;
 *
 * The autoloader will try to load the class from ./autoloader/Auto/Class.php
 *
 * If no directories are set it will try to load from the main directory (./Auto/Class).
 *
 * Class Autoloader
 * @package Epick
 */

class Autoloader {

	protected $classMap = array();
	protected $prefixDirs = array();
	protected $dirs = array();

	public function addClassMap(array $map, $overwrite = null) {
		$this->classMap = ($overwrite ? $map : array_merge($this->classMap, $map));

		return $this;
	}

	public function getClassMap() {
		return $this->classMap;
	}

	public function addPrefixDirs($prefix, $path) {

		if(! $prefix) {
			return;
		}

		if(! isset($this->prefixDirs[$prefix])) {
			$this->prefixDirs[$prefix] = array();
		}

		$this->prefixDirs[$prefix] = array_merge($this->prefixDirs[$prefix], (array) $path);
	}

	public function addDirs($dirs) {
		if(! is_array($dirs)) {
			$dirs = (array) $dirs;
		}

		$this->dirs = array_merge($this->dirs, $dirs);
	}

	public function getPrefixDirs() {
		return $this->prefixDirs;
	}

	public function register() {
		spl_autoload_register(array($this, 'autoload'));
	}

	public function deregister() {
		spl_autoload_unregister(array($this, 'autoload'));
	}

	public function findClass($className) {

		if(isset($this->classMap[$className])) {
			return $this->classMap[$className];
		}

		$pathToClass = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

		if(file_exists($pathToClass)) {
			return $pathToClass;
		}

		if (false !== $lastNsPos = strrpos($className, '\\')) {
			//$class = substr($className, $lastNsPos + 1);
			$pathToClass = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

			foreach($this->prefixDirs as $prefix => $dirs) {
				if(0 === strpos($className, $prefix)) {
					foreach($dirs as $dir) {
						if (file_exists($file = $dir . DIRECTORY_SEPARATOR . $pathToClass)) {
							return $file;
						}
					}
				}
			}
		}

		foreach($this->dirs as $dir) {
			if (file_exists($file = $dir . DIRECTORY_SEPARATOR . $pathToClass)) {
				return $file;
			}
		}

		return false;
	}

	public function autoload($className) {

		// https://bugs.php.net/50731
		$className = ltrim($className, '\\');

		$fileName = $this->findClass($className);

		if(file_exists($fileName)) {
			includeFile($fileName, E_USER_ERROR);
		}
	}
}

function includeFile($file) {
	include $file;
	//scope related things
}