<?php
	$filename = 'komento.txt';
	$delNumber = $_POST['delNumber'];
	$int_delNumber = (int)$delNumber;

	$commentArray = file($filename);
	// $commentArray[0] = 1<>name<>comment<>time\n
	// $commentArray[1] = 2<>name<>comment<>time\n
	// ....
	$fp = fopen($filename,'w');

	foreach ($commentArray as $commentKey => $comment) {
		//var_dump($commentKey);
		if(1 + $commentKey == $int_delNumber) {
			fwrite($fp,$delNumber.'<>-= コメントは削除されました =-'."\n");
			//echo '削除!';
		}else{
			fwrite($fp,$comment);
		}
	}

	if(fclose($fp) == true){
		echo '削除しました';
	}
?>