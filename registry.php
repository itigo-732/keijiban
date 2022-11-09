<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../stylesheet.css">
		<title>一行掲示板-新規登録</title>
	</head>
	<body>
		<h1>一行掲示板  新規会員登録</h1>
        <?php 
            if (isset($_POST["username"])) {
                if ($_POST["password"] != $_POST["passwordConfirm"] ) {
                    echo "パスワードが一致しません";
                }else {
                    $db = "mysql: host=localhost; dbname=keijiban; charset=utf8mb4";
                    $username = "****";
                    $password = "****";
        
                    $pdo = new PDO($db, $username, $password);

                    $stmt = $pdo -> prepare("select * from users where username=:username;");
                    $stmt -> bindValue(":username", $_POST["username"], PDO::PARAM_STR);
                    $stmt -> execute(); 
                    $row = $stmt -> rowCount();
                    if($row != 0){
                        echo "そのユーザ名は使われています";
                    }else{
                        $pw = password_hash($_POST["password"], PASSWORD_DEFAULT);
                        $stmt = $pdo -> prepare("Insert into users(username, password, nickname) Values (:username, :password, :nickname);");
                        $stmt -> bindValue(":username", $_POST["username"], PDO::PARAM_STR);
                        //$stmt -> bindValue(":password", $_POST["password"], PDO::PARAM_STR);
                        $stmt -> bindValue(":password", $pw, PDO::PARAM_STR);
                        $stmt -> bindValue(":nickname", $_POST["nickname"], PDO::PARAM_STR);
                        $stmt -> execute(); 
                        $row = $stmt -> rowCount();

                        header ("Location: ./index.php");
                        exit;
                    }
                }
            }
            ?>
        <form action="" method="POST">
            <table class="login">
                <tr>
                    <td>ユーザ名</td>
                    <td><input type="text" name="username" required></td>
                </tr>
                <tr>
                    <td>パスワード</td>
                    <td><input type="password" name="password" required></td>
                </tr>
                <tr>
                    <td>パスワード(確認用)</td>
                    <td><input type="password" name="passwordConfirm" required></td>
                </tr>
                <td>ニックネーム</td>
                    <td><input type="text" name="nickname" required></td>
            </table>
            <div class="registry">
                <button type="submit" class="registry">登録</button>
            </div>
        </form>
    </body>
</html>
