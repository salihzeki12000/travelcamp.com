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
        $userid = trim($_POST['userid']);
     }
     if (isset($_POST['pwd']) === TRUE) {
        $pwd = trim($_POST['pwd']);
     }
     if (isset($_POST['re_pwd']) === TRUE) {
        $re_pwd = trim($_POST['re_pwd']);
     }
     if(is_empty($userid)) {
         $error[] = 'ユーザーIDが未入力です';
     } else if(!preg_match($userid_regex, $userid) ) {
            $error[] = 'ユーザーIDは半角英数字を6文字以上入力してください';
        }
    if(is_empty($pwd)) {
        $error[] = 'パスワードが未入力です';
    } else if(is_empty($re_pwd)) {
            $error[] = '確認用パスワードが未入力です';
      } else if(!preg_match($pwd_regex, $pwd) && !preg_match($pwd_regex, $re_pwd) ) {
            $error[] = 'パスワードは半角英数字を6文字以上入力してください';
        } else if($pwd !== $re_pwd) {
            $error[] = 'パスワードと確認用パスワードが一致しません';
          }
     if(count($error) === 0) {
         $pwd = password_hash($pwd, PASSWORD_DEFAULT);
        try {
            $sql = 'SELECT name
                    FROM userdata';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();
            }  
                catch (PDOException $e) {
                    $error[] = '接続できませんでした。理由：'.$e->getMessage();
                }
                    foreach($rows as $value) {
                      $db_userid = $value['name'];
                        if($userid === $db_userid) {
                            $result = 'ご入力いただいたユーザーIDは既に使用されています';
                        }
                    }  
         if(empty($result)) {
            try {
                $sql = 'INSERT INTO userdata (name, password, create_datetime) 
                        VALUES(?,?,NOW())';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $userid, PDO::PARAM_STR);
                $stmt->bindValue(2, $pwd, PDO::PARAM_STR);
                $stmt->execute();
                
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
   <title>新規会員登録ページ</title>
   <link rel="stylesheet" href="insert_02.css">
</head>
<body>
  <div class="header">
    <h1 class="company_name">Travel&nbsp;Camp.com</h1>
  </div>
  <div class="main">
    <div class="center">
      <h2>新規会員登録</h2>
<?php foreach ($error as $value) { ?>
    <p class="error"><?php print h($value); ?></p>
<?php } ?>
<?php if(!empty($result)) { ?>
    <p class="error"><?php print h($result); ?></p>
<?php } ?>
<?php foreach($data as $value){ ?>
    <?php print '登録できました。'."<br>".'登録のユーザーIDは'; ?>
    <span class="register"><?php echo h($value['name']); ?></span>パスワードは
    <span class="register"><?php echo h($re_pwd); ?></span>です
<?php } ?>
      <form method="post">
        <p><label for="id">ユーザーID：</label><input type="text" name="userid" id="id"></p>
        <p><label for="pwd">パスワード：</label><input type="password" name="pwd" id="pwd"></p>
        <p><label for="re">確　認　用：</label><input type="password" name="re_pwd" id="re"></p>
        <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
        <input type="submit" value="登録">
        <p><a href="login_02.php">ログインページへ</a></p>
      </form>
    </div>
  </div>
  <footer>
      <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>