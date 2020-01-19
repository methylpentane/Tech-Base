<?php
$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
$db_user = 'co-622.it.3919.c';
$db_pass = 'Mvju89CY4';

try{
	$pdo = new PDO($db_info,$db_user,$db_pass);
}catch(PDOException $e){
	exit('データベース接続失敗。'.$e->getMessage());
}

$sql = 'SELECT * FROM users';
$result = $pdo->query($sql);

foreach($result as $row){
	echo $row[userid].' ';
	echo $row[name].' ';
	echo $row[password].' ';
	echo "<br>";
}

?>
