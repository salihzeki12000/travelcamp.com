<?php
    require_once('setting.php');
    
    $error = array();
    $sum = 0;

session_start();
 
if (!isset($_SESSION["USERID"])) {
  header("Location: logout_02.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST["csrf_token"]) && ($_POST["csrf_token"] === $_SESSION['csrf_token'])) {
        TRUE;
    } else {
          exit("不正なリクエストです");
      } 
    if (isset($_POST['name']) === TRUE) {
        $name = $_POST['name'];
    }
    if (isset($_POST['comment']) === TRUE) {
        $comment = $_POST['comment'];
    }
    if (isset($_POST['term1']) === TRUE) {
        $term1 = $_POST['term1'];
    }
    if (isset($_POST['term2']) === TRUE) {
        $term2 = $_POST['term2'];
    }
    if (is_empty($name)) {
        $error[] = '旅行先を入力してください';
    } else if (!is_valid_destination_length($name)) {
          $error[] = '旅行先は30文字以内で入力してください';
      }
    if (empty($term1) || empty($term2)) {
        $error[] = '旅行期間を入力してください';
    }
    if($term2 < $term1){
        $error[] = '旅行期間に誤りがあります。';
    } else if(($term1 > $now) || ($term2 > $now)) {
          $error[] = '旅行期間に誤りがあります。';
      }
    if (is_empty($comment)) {
        $error[] = 'レビューを入力してださい';
    } else if (!is_valid_comment_length($comment)) {
          $error[] = 'レビューは300文字以内で入力してください';
      }
    if (count($error) === 0) {
        $log = array($name, $term1, $term2, $comment, date('Y-m-d H:i:s'), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
        if (($fp = fopen($filename, 'a')) !== FALSE) {
            if (fputcsv($fp, $log) === FALSE) {
                $error[] = 'ファイル書き込み失敗:  ' . $filename;
            }
              fclose($fp). $success = '投稿しました';
        }
    }
}
if (is_readable($filename) === TRUE) {
    if (($fp = fopen($filename, 'r')) !== FALSE) {
      while (($tmp = fgetcsv($fp)) !== FALSE) {
        $data[] = $tmp;
        $data = array_reverse($data);
      }
      fclose($fp);
    }
} else {
    $error[] = 'データがありません';
  }
 
try {
    $sql = 'SELECT amount, userdata.name
            FROM ec_cart
            INNER JOIN userdata
            ON ec_cart.user_id = userdata.user_id
            WHERE name = ?';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(1, $_SESSION["USERID"], PDO::PARAM_STR);
    $stmt->execute();
    $rows = $stmt->fetchAll();
}  
    catch (PDOException $e) {
        $error[] = '接続できませんでした。理由：'.$e->getMessage();
    }

header('X-FRAME-OPTIONS: DENY');

$csrf_token = uniqid();  
$_SESSION['csrf_token'] = $csrf_token; 

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>旅行体験記</title>
  <link rel="stylesheet" href="bbs.css">
</head>
<body>
    <div class="header">
        <div class="header_next_01">
           <h1 class="company_name"><a class="top_logo" href="index_02.php">Travel&nbsp;Camp.com</a></h1>
        </div>
        <div class="header_next_02">
            <span class="welcome">
              ようこそ<u><?php print h($_SESSION["USERID"], ENT_QUOTES); ?></u>さん
              <a href="logout_02.php">ログアウト</a>
              <?php foreach($rows as $value): ?>
                <?php $sum += $value['amount']; ?>
              <?php endforeach ?>
              <a <?php if($sum < 100) { ?> class="amount" <?php } else {?> class="amount over_99" <?php } ?> href="purchase_02.php">
                  <?php if($sum < 100): echo h($sum); ?>
                    <?php else: echo '99+'; ?>
              </a>
                    <?php endif ?>
            </span>
              <a href="purchase_02.php"><img class="cart" src="./logo_etc/cart_03.png"></a>
        </div>
    </div>
    <div class="main">
    <h2>旅行体験記</h2>
<span class="msg"><?php echo h($success); ?></span>
    <ul>
    <?php foreach ($error as $value) { ?>
        <li class="msg"><?php print h($value); ?></li>
    <?php } ?>
    </ul>
    <form method="post">
        <p><label for="trip">旅 行 先</label></p>
        <input class="destination" type="text" name="name" id="trip" size="30">
        <p><label for="term">旅行期間</label></p>
        <input class="term" type="date" name="term1" id="term">から<input type="date" name="term2" id="term">まで
    　　<p><label for="review">レビュー(300字以内)</label></p>
    　　<textarea class="textarea" name="comment" id="review"></textarea>
    　　<input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
        <p><input type="submit" name="submit" value="投稿"></p>
    </form>
    <div class="table_container">
     <table>
         <thead>
           <tr>
            <th>旅行先</th>
            <th>旅行期間(出発)</th>
            <th>旅行期間(帰国)</th>
            <th class="review review_center">レビュー</th>
      　   </tr>
         </thead>
         <tbody class="contents">
        <?php foreach ($data as $read) { ?> 
          <tr>
            <td><?php echo h($read[0]); ?></td>
            <td><?php echo h($read[1]); ?></td>
            <td><?php echo h($read[2]); ?></td>
            <td class="review"><?php echo h($read[3]); ?></td>
          </tr>
        <?php } ?>
         </tbody>
   </table>
   </div>
   <br><br><a href="index_02.php">戻る</a>
  </div>
  <footer>
      <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>