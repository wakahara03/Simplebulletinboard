<?php

if (!empty($_POST)) {

	define('ERR01', '入力必須項目です');
	define('ERR02', 'Emailの形式で入力してください');
	define('ERR03', 'パスワード（再入力）があっていません');
	define('ERR04', '半角英数字のみご利用いただけます');
	define('ERR05', '6文字以上で入力してください');

	$err_msg = array();

	if (empty($_POST['name'])) {
		$err_msg['name'] = ERR01;
	}

	if (empty($_POST['email'])) {
		$err_msg['email'] = ERR01;
	}

	if (empty($_POST['pass'])) {
		$err_msg['pass'] = ERR01;
	}

	if (empty($_POST['pass_retype'])) {
		$err_msg['pass_retype'] = ERR01;
	}
	
	if (empty($err_msg)) {
		
		if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
			$err_msg['email'] = ERR02;
		}

		if ($_POST['pass'] !== $_POST['pass_retype']) {
			$err_msg['pass'] = ERR03;
		}

		if (empty($err_msg)) {
			
			if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['pass'])) {
				$err_msg['pass'] = ERR04;

			}elseif (mb_strlen($_POST['pass']) < 6) {
				$err_msg['pass'] = ERR05;
			}

			if(empty($err_msg)){
 		        $dsn = 'mysql:dbname=portforio01;host=localhost;charset=utf8';
		        $user = 'root';
		        $password = 'root';
		        $options = array(
		                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
		            );
		 
		        $dbh = new PDO($dsn, $user, $password, $options);
		 
		        $stmt = $dbh->prepare('INSERT INTO users (name,email,pass,login_time) VALUES (:name,:email,:pass,:login_time)');
		 
		        $stmt->execute(array(':name' => $_POST['name'], ':email' => $_POST['email'], ':pass' => $_POST['pass'], ':login_time' => date('Y-m-d H:i:s')));
		 
		        header("Location:login.php"); 
		    }
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>新規登録</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">

	<div class="contact-form">
		<h2>新規登録</h2>
		<form action="" method="post">
			<span class="err_msg"><?php if(!empty($err_msg['name'])) echo $err_msg['name'];?></span>
			<input type="text" name="name" placeholder="名前" value="<?php if (!empty($_POST['name'])) echo($_POST['name']);?>">

			<span class="err_msg"><?php if(!empty($err_msg['email'])) echo $err_msg['email'];?></span>
			<input type="text" name="email" placeholder="メールアドレス" value="<?php if (!empty($_POST['email'])) echo($_POST['email']);?>">

			<span class="err_msg"><?php if(!empty($err_msg['pass'])) echo $err_msg['pass'];?></span>
			<input type="password" name="pass" placeholder="パスワード" value="<?php if (!empty($_POST['pass'])) echo($_POST['pass']);?>">

			<span class="err_msg"><?php if(!empty($err_msg['pass_retype'])) echo $err_msg['pass_retype'];?></span>
			<input type="password" name="pass_retype" placeholder="パスワード（再入力）" value="<?php if (!empty($_POST['pass_retype'])) echo($_POST['pass_retype']);?>">

			<input type="submit" value="新規会員登録">
		</form>
	</div>
	<a href="login.php">ログイン</a>
	<a href="mypage.php">マイページ</a>
</body>
</html>
