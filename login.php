<?php
    session_start();
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
        <?php 
            if (isset($_SESSION["username"])) {
                session_regenerate_id(true);
                header ("Location: ./index.php");
                exit;
            }
            if (isset($_POST["username"], $_POST["password"])) {
                $db = "mysql: host=localhost; dbname=webapp; charset=utf8mb4";
                $username = "wpuser";
                $password = "wppasswd";
    
                $pdo = new PDO($db, $username, $password);

                $stmt = $pdo -> prepare("select * from users where username=:username;");
                $stmt -> bindValue(":username", $_POST["username"], PDO::PARAM_STR);
                $stmt -> execute(); 

                $row = $stmt -> FETCH(PDO::FETCH_ASSOC);
                if(isset($row["username"])){
                    /*
                    print_r($row);
                    echo "<br>";
                    print_r($_POST);
                    echo "<br>"; 
                    */
                    //if($row["password"] == $_POST["password"]){
                    if (password_verify($_POST["password"], $row["password"])){
                        //echo "ログイン可能";
                        session_regenerate_id(true);
                        $_SESSION["username"] = $_POST["username"];
                        $_SESSION["nickname"] = $row["nicname"];
                        header ("Location: ./index.php");
                        exit;
                    }else {
                        echo "パスワードが違います";
                    }
                }else {
                    echo "ユーザ名が違います";
                }
            }
        ?>
        <form action="" method="POST">
            <table class="login">
                <tr>
                    <td>ユーザ名</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td><input type="password" name="password"></td>
                </tr>
            </table>
            <div class="login">
                <button type="submit" class="login">ログイン</button>
            </div>
        </form>
        <a href="./registry.php">新規ユーザー登録はこちら</a>
    </body>
</html>
