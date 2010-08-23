<?php

function getWidth($image) {
	$cmd = "identify '" . $image . "' 2>/dev/null";
	$results = exec($cmd);
	$results = trim($results);
	$results = explode(" ", $results);
	foreach ($results as $i=> $result) {
		if (preg_match("/^[0-9]*x[0-9]*$/", $result)) {
			$results = explode("x", $result);
			break;
		}
	}
	return $results[0];
}

function getHeight($image) {
	$cmd = "identify '" . $image . "' 2>/dev/null";
	$results = exec($cmd);
	$results = trim($results);
	$results = explode(" ", $results);
	foreach ($results as $i=> $result) {
		if (preg_match("/^[0-9]*x[0-9]*$/", $result)) {
			$results = explode("x", $result);
			break;
		}
	}
	return $results[1];
}

?>