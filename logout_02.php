
<?php
 require_once('setting.php');

session_start();

if (isset($_SESSION["USERID"])) {
  $error = "ログアウトしました。";
}
    else {
      $error = "セッションがタイムアウトしました。";
    }

$_SESSION = array();

@session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>ログアウト</title>
     <link rel="stylesheet" href="logout_02.css">
  </head>
  <body>
    <div class="header">
      <h1 class="company_name">Travel&nbsp;Camp.com</h1>
    </div>
    <div class="main">
      <div class="center">
        <h2>ログアウト</h2>
        <p class="error"><?php print h($error); ?></p>
        <br><a href="login_02.php">ログイン画面に戻る</a>
      </div>
    </div>
  <footer>
    <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
  </body>
</html>