<?php

/**
 *	This file contains functions for the entire project
 */

function isemail($var) {
	if (preg_match('/^[^@]+@[a-zA-Z0-9._-]+\.[a-zA-Z]+$/', $var)) {
		$mailDomain = end(explode("@",$var));
		if (checkdnsrr($mailDomain, "MX")) {
			// email valid
			return true;
		}
	}
	return false;
}

function directoryAboveWebRoot() {
	$pathComponents = explode("/",$_SERVER['DOCUMENT_ROOT']);
	array_pop($pathComponents);
	return implode("/",$pathComponents);
}