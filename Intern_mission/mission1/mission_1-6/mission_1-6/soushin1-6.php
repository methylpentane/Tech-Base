<?php
header("Content-Type:text/html; charset=UTF-8");

	$filename = 'hitokoto.txt';
	$fp = fopen($filename,'a'); //新しい要素、'a'は追記で書き込みます('w'は全部上書き!!)
	fwrite($fp,$_GET['hitokoto']."\n");//ポイントとして改行コード"\n"をつけます
	fclose($fp);

	//改行コードっていうのは文字通り、ここで改行という意味の文字です
	//これ無いと一行ずつになりませんよ
	//htmlさんは<br>というタグを改行とみなし、普通のテキストさんは"\n"を改行とみなすルールなので
	//使い分けてあげてください
	//
?>

