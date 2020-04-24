<?php
    require_once('setting.php');
    
    $error = array();


session_start();
    if(isset($_SESSION["USERID"]) === TRUE && $_SESSION["USERID"] !== 'admin' ) {
         header("Location: index_02.php");
    } else if(isset($_SESSION["USERID"]) === TRUE && $_SESSION["USERID"] === 'admin' ) {
         header("Location: tool_02.php");
      }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["csrf_token"]) && ($_POST["csrf_token"] === $_SESSION['csrf_token'])) {
        TRUE;
    } else {
          exit("不正なリクエストです");
      } 
    if (isset($_POST['userid']) === TRUE) {
        $userid = $_POST['userid'];
    }
    if (isset($_POST['pwd']) === TRUE) {
        $pwd = $_POST['pwd'];
    } 
        if (is_empty($userid)) {
            $error[] = "ユーザーIDが未入力です。";
        } 
        if (is_empty($pwd)) {
            $error[] = "パスワードが未入力です。";
        }
    if(($userid === 'admin') && ($pwd === 'admin')) {
        session_regenerate_id(true);
          $_SESSION["USERID"] = $userid;
          header("Location: tool_02.php");
          exit;
    } else if (!empty($userid) && !empty($pwd)) {
          try {
              $sql = 'SELECT name, password
                      FROM userdata
                      WHERE name = ?';
              $stmt = $dbh->prepare($sql);
              $stmt->bindValue(1, $userid, PDO::PARAM_STR);
              $stmt->execute();
              $data = $stmt->fetchAll();
          }  
                catch (PDOException $e) {
                    $error[] = '接続できませんでした。理由：'.$e->getMessage();
                }
                  if(!empty($data)) {
                      if(password_verify($pwd, $data[0]['password'])) {
                          session_regenerate_id(true);
                          $_SESSION["USERID"] = $userid;
                          header("Location: index_02.php");
                          exit;
                      } else {
                         $result = "ユーザーIDあるいはパスワードに誤りがあります。";
                        }
                  } else {
                      $result = "ユーザーIDあるいはパスワードに誤りがあります。";
                    }
      } 
}

header('X-FRAME-OPTIONS: DENY');

$csrf_token = uniqid();  
$_SESSION['csrf_token'] = $csrf_token; 


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="login_02.css">
</head>
<body>
  <div class="header">
    <h1 class="company_name">Travel&nbsp;Camp.com</h1>
  </div>
  <div class="main">
    <div class="center">
      <h2>ログイン</h2>
    <?php foreach ($error as $value) { ?>
      <p class="error"><?php print h($value); ?></p>
    <?php } ?>
      <p class="error"><?php print h($result) ; ?></p>
      <form method="POST">
        <label for="userid">ユーザーID：</label><input type="text" id="userid" name="userid">
        <br><br>
        <label for="password">パスワード：</label><input type="password" id="password" name="pwd">
        <br> <br>
        <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
        <input type="submit" value="ログイン">
      </form>
      <br><a href="insert_02.php">新規会員登録ページへ</a>
    </div>
  </div>
  <footer>
    <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>