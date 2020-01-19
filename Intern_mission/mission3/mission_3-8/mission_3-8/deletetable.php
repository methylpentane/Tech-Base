<?php
$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
$db_user = 'co-622.it.3919.c';
$db_pass = 'Mvju89CY4';
try{
	$pdo = new PDO($db_info,$db_user,$db_pass);
}catch(PDOException $e){
	exit($e->getMessage());
}

//////////*-----START HERE DOC-----*/
$sql = <<<EOD
DROP TABLE imgvid,komento
EOD
;
//////////*------END HERE DOC------*/
$stmt = $pdo->query($sql);
?>