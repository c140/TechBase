<html>
<head>
<meta http-equiv = "content-type" content = "text/html"; charset = "UTF-8">
</head>

<?php

//データベースへのアクセス
$dsn ='データベース名';
$user ='ユーザー名';
$password ='パスワード';
$pdo =new PDO($dsn,$user,$password);

$submit1 = $_POST[('投稿')];
$submit2 = $_POST[('削除')];
$submit3 = $_POST[('編集')];
$message1 = $_POST[('name')];
$message2 = $_POST[('comment')];
$counting = $_POST[('count')];
$delete = $_POST[('delete')];
$edit = $_POST[('edit')];
$password1 = $_POST[('password1')];
$password2 = $_POST[('password2')];
$password3 = $_POST[('password3')];
$namech = "";
$commentch = "";
$countch = "";
$passch = "";
$type = 'password';
$nopass = "";
$button = "投稿";

if($submit1 && !empty($message1) && !empty($message2) && !empty($password1) && empty($counting)){
//投稿機能
$date = date("Y年m月d日 H時i分s秒");

$sql =$pdo->prepare("INSERT INTO mission4(name,comment,day,password) VALUES (:name,:comment,:day,:password)");
$sql->bindParam(':name',$name,PDO::PARAM_STR);
$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
$sql->bindParam(':day',$day,PDO::PARAM_STR);
$sql->bindParam(':password',$password,PDO::PARAM_STR);
$name = $message1;
$comment = $message2;
$day = $date;
$password = $password1;
$sql->execute();

}else if($submit2 && !empty($delete) && !empty($password2)){
//削除機能

$sql ="delete from mission4 where id='$delete' and password='$password2'";
$result =$pdo->query($sql);
	
}else if($submit3 && !empty($edit) && !empty($password3)){
//編集選択機能

	$sql = "SELECT * FROM mission4 where id='$edit' and password='$password3'";
	if($result =$pdo->query($sql)){
	$word= $result->fetch(PDO::FETCH_ASSOC);
		if($word){
			$countch = $word['id'];
			$namech = $word['name'];
			$commentch = $word['comment'];
			$passch = $word['password'];
			$type = "hidden";
			$nopass = "記入する必要はありません";
			$button = "編集実行";
		}else if(!$word){
		echo "<p><font size = '15'>一致する投稿はありません</font></p>";
		}
		
	}
}else if($submit1 && !empty($message1) && !empty($message2) && !empty($password1) && !empty($counting)){
//編集実行機能
$date = date("Y年m月d日 H時i分s秒");
$id = $counting;
$nm = $message1;
$com = $message2;
$da = $date;
$sql ="update mission4 set name='$nm',comment='$com',day='$da' where id=$id";
$result =$pdo->query($sql);

}else{

}

?>

<body>
<form method = "post" action= "mission_4-1.php">
<p>名前：<input type = "text" name = "name" size = "20" placeholder = "名前" value = "<?= $namech ?>"></p>
<p>コメント：<input type = "text" name = "comment" size = "20" placeholder = "コメント" value = "<?= $commentch ?>"></p>
<p>パスワード：<input type = "<?= $type ?>" name = "password1" size = "20" placeholder = "パスワード" value = "<?= $passch ?>"><?= $nopass ?></p>
<input type = "hidden" name = "count" size = "20" value = "<?= $countch ?>">
<input type = 'submit' name = '投稿' value = "<?= $button ?>"><br>
<p>削除対象番号：<input type = "text" name = "delete" size = "20" placeholder = "削除する番号の入力"></p>
<p>パスワード：<input type = "password" name = "password2" size = "20" placeholder = "パスワード" value = ""></p>
<input type = 'submit' name = '削除' value = '削除'><br>
<p>編集対象番号：<input type = "text" name = "edit" size = "20" placeholder = "編集する番号の入力"></p>
<p>パスワード：<input type = "password" name = "password3" size = "20" placeholder = "パスワード" value = ""></p>
<input type = 'submit' name = '編集' value = '編集'><br><br>

<?php
//select文で一覧表示
$sql ='select * from mission4 order by id asc';
$results =$pdo->query($sql);
foreach($results as $word){
echo $word['id'].', ';
echo $word['name'].', ';
echo $word['comment'].', ';
echo $word['day'].'<br>';//UTF-8Nの設定
}

?>

</form>
</body>
</html>
