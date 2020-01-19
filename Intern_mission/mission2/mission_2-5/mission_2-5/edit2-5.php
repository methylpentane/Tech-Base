<?php
	$filename = 'komento.txt';
	$editNumber = $_POST['editNumber'];
	$int_editNumber = (int)$editNumber;

	$commentArray = file($filename);
	// $commentArray[0] = 1<>name<>comment<>time\n
	// $commentArray[1] = 2<>name<>comment<>time\n
	// ....
	$fp = fopen($filename,'w');

	foreach ($commentArray as $commentKey => $comment) {
		var_dump($commentKey);
		if(1 + $commentKey == $int_editNumber) {
			$commentFeature = explode('<>', $comment);
			fwrite($fp,$editNumber.'<>'.$_POST['name'].'<>'.$_POST['comment'].'<>'.$commentFeature[3]);
			echo '編集!';
		}else{
			fwrite($fp,$comment);
		}
	}

	if(fclose($fp) == true){
		echo '編集しました';
	}
?>