<?php
require_once('setting.php');

    try {
        $sql = 'SELECT name, password, create_datetime
                FROM userdata ';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(); 
    } 
            catch (PDOException $e) {
                $error[] = '接続できませんでした。理由：'.$e->getMessage();
            } 
        
session_start();
 
if (!isset($_SESSION["USERID"])) {
  header("Location: logout_02.php");
  exit;
}       
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー管理ページ</title>
  <link rel="stylesheet" href="user_02.css">
</head>
<body>
  <h1>ユーザー情報一覧</h1>
    <a href="logout_02.php">ログアウト</a>
    <p><a href="tool_02.php">航空券管理ページへ</a></p>
  <table>
    <tr>
      <th>ユーザID</th>
      <th>パスワード</th>
      <th>作成日時</th>
    </tr>
<?php foreach($data as $value) { ?>
    <tr>
      <td><?php print h($value['name']);?></td>
      <td><?php print h($value['password']);?></td>
      <td><?php print h($value['create_datetime']);?></td>
    </tr>
<?php } ?>
  </table>
</body>
</html>