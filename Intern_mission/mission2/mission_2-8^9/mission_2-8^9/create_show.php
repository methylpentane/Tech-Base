<?php
$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
$db_user = 'co-622.it.3919.c';
$db_pass = 'Mvju89CY4';

try{
	$pdo = new PDO($db_info,$db_user,$db_pass);
}catch(PDOException $e){
	exit('データベース接続失敗。'.$e->getMessage());
}

// 2-8部分
$sql = <<<EOD
CREATE TABLE IF NOT EXISTS test (
id INT UNSIGNED NOT NULL AUTO_INCREMENT,
name VARCHAR(16),
PRIMARY KEY(id)
)
EOD;

$chk = $pdo->query($sql);
if($chk === false) echo 'テーブル作成だめです<br>';

//2-9部分
$stmt = $pdo->query('SHOW TABLES');
if($stmt === false) echo 'テーブル表示駄目です<br>';

foreach($stmt as $re){
	echo $re[0];
	echo "<br>";
}

?>
