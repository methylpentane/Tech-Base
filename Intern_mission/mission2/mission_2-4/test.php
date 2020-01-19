<?php
$fp = fopen('test.txt','a');
fwrite($fp,'test');
fclose($fp);
?>