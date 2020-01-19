<?php
	$filename = 'komento.txt';
	$editNumber = $_POST['editNumber'];
	$int_editNumber = (int)$editNumber;

	$commentArray = file($filename);
	// $commentArray[0] = 1<>name<>comment<>time<>password<>\n
	// $commentArray[1] = 2<>name<>comment<>time<>password<>\n
	// ....

	//チェック・認証フェーズ
	$commentFeature = explode('<>',$commentArray[$int_editNumber-1]);
	// var_dump($commentFeature); //debug
	// var_dump($_POST['password']); //debug
	$isNumberValid = (1+count($commentArray) > $int_editNumber and $int_editNumber > 0) ? true : false;
	$check = ($commentFeature[4] === $_POST['password']) ? true : false;

	if($check === true and $isNumberValid === true){
		$fp = fopen($filename,'w');
		foreach ($commentArray as $commentKey => $comment) {
			// var_dump($commentKey); //debug
			if(1 + $commentKey == $int_editNumber) {
				fwrite($fp,$editNumber.'<>'.$_POST['name'].'<>'.$_POST['comment'].'<>'.$commentFeature[3].'<>'.$commentFeature[4].'<>'."\n");
				// echo '編集!'; //debug
			}else{
				fwrite($fp,$comment);
			}
		}
		if(fclose($fp) == true){
			echo '編集しました<br><a href=http://co-622.it.99sv-coco.com/mission_2-6/main_form2-6.php>メインフォームにもどる<a/>';
		}
	}else{
		if($check === false) echo 'パスワードが違います。';
		if($isNumberValid === false) echo '番号が適正ではありません。';
	}
?>