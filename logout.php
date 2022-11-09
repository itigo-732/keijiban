<?php 
    session_start();
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time()-42000, "/");
    }
    session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../stylesheet.css">
		<title>一行掲示板ログイン画面</title>
	</head>
    <body>
		<h1>一行掲示板  ログイン画面</h1>
        <p>ログアウトしました</p>
		<p><a href="./login.php">ログインページに戻る</a></p>
	</body>
</html>