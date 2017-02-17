<?php
session_start();
?>

<html>
<head>
    <title></title>
    <meta http-equiv="content-type" content="text/html" charset="utf-8" />
</head>
<body>
<hr size="1" noshade />
更新画面
<hr size="1" noshade />
[ <a href="list.php"> 戻る </a>]
<br />

<?php
require_once("MYDB.php");
$pdo = db_connect();

if(isset($_GET['id']) && $_GET['id'] > 0) {
    $id = $_GET['id'];
    $_SESSION['id'] = $id;
}else {
    exit(' パラメータが不正です。 ');
}

try {
    $sql = "SELECT * FROM member WHERE id = :id ";
    $stmh = $pdo->prepare($sql);
    $stmh->bindValue(':id', $id, PDO::PARAM_INT);
    $stmh->execute();
    $count = $stmh->rowCount();

} catch (PDOException $Exception) {
    print " エラー " . $Exception->getMessage();
}

if($count < 1) {
    print " 更新データはありません。<br /> ";
}else{
    $row = $stmh->fetch(PDO::FETCH_ASSOC);
?>

<form name="form1" method="post" action="list.php">
番号：<?=htmlspecialchars($row['id'])?><br />
氏：<input type="text" name="last_name"
            value="<?=htmlspecialchars($row['last_name'])?>"><br />
名：<input type="text" name="first_name"
            value="<?=htmlspecialchars($row['first_name'])?>"><br />
年齢：<input type="text" name="age"
            value="<?=htmlspecialchars($row['age'])?>"><br />
<input type="hidden" name="action" value="update" />
<input type="submit" value=" 更　新 " />
</form>
<?php
}
?>

</body>
</html>
