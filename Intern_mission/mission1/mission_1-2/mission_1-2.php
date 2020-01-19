<?php
header("Content-Type:text/html; charset=UTF-8");
//↑文字コードをUTF-8へ(UTF-8は一番メジャーで文字化けしにくい文字コードです)この行は必要に応じて

	$filename = 'kadai2.txt';//ファイル名宣言

	$fp = fopen($filename,'w');//$filenameに入った名前でファイルを作成(w:書き込みモード)
	//$fpは、ファイル自体を指している変数と考えましょう
	$fwrite = fwrite($fp,'test');//ファイルにtestと書き込み

	fclose($fp);//ファイルを閉じます

	//fopen→fwrite→fcloseの流れで、testと書かれたkadai2.txtが作られます
	//これらは関数といい、()の中に与えられた値(引数)を用いて特定の処理をする
	//関数はfopenなどのように、値を持つ事がある(返り値という)その値を別の変数に入れたりできる

?>