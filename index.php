<!-- 2022-06-21 作成-->

<?php 
ini_set("session.gc_maxlifetime", 1800);
ini_set("settion.gc_probability", 1);
ini_set("session.gc_divisor", 1);
session_start(); 



?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../stylesheet.css">
		<title>一行掲示板</title>
	</head>
	<body>
		<h1>一行掲示板</h1>
		<?php

			if (!isset($_SESSION["username"])) {
				header ("Location: ./login.php");
				exit;
			}

			$db = "mysql: host=localhost; dbname=webapp; charset=utf8mb4";
			$username = "wpuser";
			$password = "wppasswd";

			$pdo = new PDO($db, $username, $password);

			if (isset($_POST["newcontent"])) {
				$stmt = $pdo -> prepare("insert into bbs (content, updated_at, speaker)
										values (:content, now(), :speaker);");
				$stmt -> bindValue(":content", $_POST["newcontent"], PDO::PARAM_STR);
				$stmt -> bindValue(":speaker", $_SESSION["nickname"], PDO::PARAM_STR);
				$stmt -> execute();
			}

			if (isset($_POST["delete_id"])) {
				$stmt = $pdo -> prepare("delete from bbs where id=:delete_id;");
				$stmt -> bindValue(":delete_id", $_POST["delete_id"], PDO::PARAM_INT);
				$stmt -> execute();
			}
			$stmt = $pdo -> prepare('select * from bbs;');
			$stmt -> execute();
		?>
		<p>
			<span style="font-size:200%">
				<?php echo $_SESSION["nickname"]; ?>
			</span>さん　ようこそ
		</p>
		<h2>投稿フォーム</h2>
		<form action="" method="POST">
			<label>
				投稿内容:<input type="text" name="newcontent">
			</label>
			<button type="submit">送信</button>
		</form>
		<h2>発言リスト</h2>


		<table class="bbs">
			<tr>
				<th>発言者</th>
				<th>日時</th>
				<th>投稿内容</th>
				<th>削除</th>
			</tr>
			<?php 
				while($row = $stmt -> fetch(PDO::FETCH_ASSOC)){	
			?>
			<tr>
				<td><?php echo htmlspecialchars($row["speacker"], ENT_QUOTES, "utf-8");?></td>
				<td><?php echo htmlspecialchars($row["updated_at"], ENT_QUOTES, "utf-8"); ?></td>
				<td><?php echo htmlspecialchars($row["content"], ENT_QUOTES, "utf-8"); ?></td>
				<td>
					<form action="" method="POST">
						<input type="hidden" name="delete_id" value=<?php echo $row["id"]; ?>>
						<button type="submit" class="delete">削除</button>
					</form>
				</td>
			</tr>
			<?php  } ?>
		</table>
		<p><a href="./logout.php">ログアウトはこちら</a></p>
	</body>
</html>