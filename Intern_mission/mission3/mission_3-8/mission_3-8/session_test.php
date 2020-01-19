<!DOCTYPE html>
<html>
<head>
	<title>session test</title>
</head>
<body>
<?php
session_start();
print session_name();
echo "<br>";
print session_id();
echo "<br>";
$_SESSION['test'] = 'test';
var_dump($_SESSION['test']);
?>
<a href="http://co-622.it.99sv-coco.com/mission_3-7/session_test2.php">とぶ</a>
</body>
</html>