<?php
define('MAIN_DIR', dirname(__FILE__));

include('libs/Autoloader.php');
$autoloader = new Autoloader();
$autoloader->addDirs('libs');
$autoloader->register();

Input::init();

//TODO: routing

function cleanStr($string) {
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function loadPage($tag, $page) {
	$wapi   = new libs_Wapi('RhlrYpS1MM', 'MrktNTguBl');
	$result = $wapi->doRequest('search/entries/page/' . $page, array('q' => $tag));

	$return = [];

	if($wapi->isValid()) {
		foreach($result as $r) {
			$r = $r['embed'];

			if($r && $r['type'] == 'image') {
				$return[] = array(
					'url'       => $r['url'],
					'thumbnail' => $r['preview']
				);
				//print "<a href='" . $r['url'] . "'><img class='block img.responsive img-rounded' src='" . $r['preview'] . "'></a>";
			}
		}

	} else {
		echo $wapi->getError();
	}

	return $return;
}

$imgData = [];

if($tag = Input::get('tag')) {

	if(!$page = (int) Input::get('page')) {
		$page = 1;
	}

	$tag     = '#' . cleanStr($tag);
	$maxPage = 10;

	$imgData = loadPage($tag, $page);

}

if(Input::get('json')) {
	header('Content-Type: application/json');
	echo json_encode($imgData);
}
else {
	$imgHtml = '';

	foreach($imgData as $img) {
		$imgHtml .= '<a href="' . $img["url"] . '"><img class="block img.responsive img-rounded" src="' . $img['thumbnail'] . '"></a>';
	}

	View::render('index', array(
		'imgHtml' => $imgHtml,
	));
}
