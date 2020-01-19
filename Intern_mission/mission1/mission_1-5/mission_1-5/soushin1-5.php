<?php
header("Content-Type:text/html; charset=UTF-8");
	// 今回は書き込み
	// でも、やることは1-2と一緒!!
	$filename = 'hitokoto.txt';
	$fp = fopen($filename,'w');
	fwrite($fp,$_GET['hitokoto']);
	fclose($fp);
?>

<?php
	// また別解

	// ...
	// $filename = 'hitokoto.txt';
	// file_put_contents($filename, $_GET['hitokoto']); //おわり

	// 1-3の別解(file_get_contents)の書き込みバージョンだと思って。同じくfopen必要なし
?>