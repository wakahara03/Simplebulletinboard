<?php

if (!empty($_POST)) {

	define('ERR01', '入力必須項目です');
	define('ERR02', 'Emailの形式で入力してください');
	define('ERR03', '半角英数字のみご利用いただけます');
	define('ERR04', '6文字以上で入力してください');

	$err_msg = array();

	if (empty($_POST['email'])) {
		$err_msg['email'] = ERR01;
	}

	if (empty($_POST['pass'])) {
		$err_msg['pass'] = ERR01;
	}
	if (empty($err_msg)) {
		
		if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
			$err_msg['email'] = ERR02;
		}

		if (empty($err_msg)) {
			if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['pass'])) {
				$err_msg['pass'] = ERR03;
			}elseif (mb_strlen($_POST['pass']) < 6) {
				$err_msg['pass'] = ERR04;
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
			 
			  $stmt = $dbh->prepare('SELECT * FROM users WHERE email = :email AND pass = :pass');
			 
			  $stmt->execute(array(':email' => $_POST['email'], ':pass' => $_POST['pass']));
			 
			  $result = 0;
			 
			  $result = $stmt->fetch(PDO::FETCH_ASSOC);
			 
			  if(!empty($result)){
			 
				    session_start();
				 
				    $_SESSION['login'] = true;
				 
				    header("Location:mypage.php"); 
			  	}
		    }
		}    
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>ログイン</title>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
	<div class="contact-form">
		<h2>ログイン</h2>
		<form action="" method="post">
			<span class="err_msg"><?php if(!empty($err_msg['email'])) echo $err_msg['email'];?></span>
			<input type="text" name="email" placeholder="メールアドレス" value="<?php if (!empty($_POST['email'])) echo(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));?>">

			<span class="err_msg"><?php if(!empty($err_msg['pass'])) echo $err_msg['pass'];?></span>
			<input type="password" name="pass" placeholder="パスワード" value="<?php if (!empty($_POST['pass'])) echo(htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8'));?>">
			
			<input type="submit" value="ログイン">
		</form>
	</div>
	<a href="mypage.php">マイページ</a>
	<a href="signup.php">新規登録</a>
</body>
</html>
