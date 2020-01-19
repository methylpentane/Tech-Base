<?php
header("Content-Type:text/html; charset=UTF-8");

	echo 'コメント:'.$_POST["hitokoto"];
	//このコードのファイル名は、html側のformタグaction属性が指しているもの
	//method属性をPOSTにすれば、フォーム情報は$_POSTという配列に格納される
	//ちなみにGETなら$_GET
	//配列なんで、この場合$_POST["hitokoto"]というところにコメントが入ってます！
	//hitokotoはinputタグのname属性で設定した名前でしたね
?>