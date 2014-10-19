<?php

class View {
	static public function render($tpl, array $vars) {
		$file = MAIN_DIR . '/views/' . cleanStr($tpl) . '.php';

		if(file_exists($file)) {
			extract($vars);
			include $file;

			return true;
		}

		return false;
	}
} 