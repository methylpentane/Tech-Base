<?php
$db_info = 'mysql:dbname=co_622_it_3919_com;host=localhost;charset=utf8';
$db_user = 'co-622.it.3919.c';
$db_pass = 'Mvju89CY4';
try{
	$pdo = new PDO($db_info,$db_user,$db_pass);
}catch(PDOException $e){
	exit($e->getMessage());
}

$tablename2 = 'imgvid';
//////////*-----START HERE DOC-----*/
$sql = <<<EOD
SELECT content FROM $tablename2 WHERE id_at = {$_GET['id']}
EOD
;
//////////*------END HERE DOC------*/
$stmt = $pdo->query($sql);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
if($result){
    header( "Content-Type: ".$_GET['mime'] );
    echo $result['content'];
}
?>