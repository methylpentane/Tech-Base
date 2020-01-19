<?php
	$filename = 'test.txt';
	$array = file($filename);
	var_dump($array);
	var_dump(count($array));
	echo phpversion();
?>