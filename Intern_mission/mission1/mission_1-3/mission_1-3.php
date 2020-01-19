<?php
//1-2と同じ書き込みコードの後、読み込んで表示するコードを追加して1-3となります

header("Content-Type:text/html; charset=UTF-8");
//↑文字コードをUTF-8に(恒例)
	$filename = 'kadai2.txt';//ファイル名宣言

	$fp = fopen($filename,'w');//ファイル作成 w:書き込みモード

	fwrite($fp,'test');//ファイル書き込み

	//ここから読み込み

	$fp = fopen($filename,'r');//ファイルをr:読み込みモードで開き直す 一度fcloseで閉じる必要はない
	$txt = fgets($fp);//fgetsは読み込みモードの時一行(この場合'test')を取得する $txtに格納
	echo $txt;//表示
	fclose($fp);
	// 終わり
?>

<?php
	// !!読み込みの別解!!

	// ...
	// ここから読み込み

	// fclose($fp);//一度閉じてしまってから
	// echo file_get_contents($filename);//これだけでおわり
	// この関数はfopenとかは必要なしに、ファイルの全文を一気に取得する。
?>