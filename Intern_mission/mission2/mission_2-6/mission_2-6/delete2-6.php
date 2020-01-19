<?php
	$filename = 'komento.txt';
	$delNumber = $_POST['delNumber'];
	$int_delNumber = (int)$delNumber;

	$commentArray = file($filename);
	// $commentArray[0] = 1<>name<>comment<>time<>password<>\n
	// $commentArray[1] = 2<>name<>comment<>time<>password<>\n
	// ....

	//チェック・認証フェーズ
	$commentFeature = explode('<>',$commentArray[$int_delNumber-1]);
	// var_dump($commentFeature); //debug
	// var_dump($_POST['password']); //debug
	$isNumberValid = (1+count($commentArray) > $int_delNumber and $int_delNumber > 0) ? true : false;
	$check = ($commentFeature[4] === $_POST['password']) ? true : false;

	//実行
	if($check === true and $isNumberValid === true){
		$fp = fopen($filename,'w');
		foreach ($commentArray as $commentKey => $comment) {
			//var_dump($commentKey); //debug
			if(1 + $commentKey == $int_delNumber) {
				fwrite($fp,$delNumber.'<>-= コメントは削除されました =-'."\n");
				//echo '削除!'; //debug
			}else{
				fwrite($fp,$comment);
			}
		}

		if(fclose($fp) == true){
			echo '削除しました<br><a href=http://co-622.it.99sv-coco.com/mission_2-6/main_form2-6.php>メインフォームにもどる<a/>';
		}
	}else{
		if($check === false) echo 'パスワードが違います。';
		if($isNumberValid === false) echo '番号が適正ではありません。';
	}
?>