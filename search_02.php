<?php
    require_once('setting.php');
    
    $error = array();
    
    
session_start();

if (!isset($_SESSION["USERID"])) {
  header("Location: logout_02.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (isset($_POST["csrf_token"]) && ($_POST["csrf_token"] === $_SESSION['csrf_token'])) {
        TRUE;
    } else {
          exit("不正なリクエストです");
      } 
    if (isset($_POST['search']) === TRUE) {
        $search = $_POST['search'];
        if(is_empty($search)) {
             $error[] = '行き先を入力してください';
        } else {
            try {
                $sql = 'SELECT ec_master.ID, country_name, price, img, stock, status, country_code
                        FROM ec_master 
                        INNER JOIN ec_stock 
                        ON ec_master.ID = ec_stock.ID
                        WHERE country_name LIKE ? && status = 1';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, "%$search%", PDO::PARAM_STR);
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
  <title>検索結果</title>
  <link rel="stylesheet" href="search_02.css">
</head>
<body>
  <div class="header">
    <div class="header_next"> 
      <h1 class="company_name"><a class="top_logo" href="index_02.php">Travel&nbsp;Camp.com</a></h1>
    </div>
    <div class="header_next">
      <a class="logout" href="logout_02.php">ログアウト</a>&emsp;&emsp;&emsp;
    </div>
  </div>
  <div class="main">
  <table>
    <tr>
      <th><!--picture--></th>
      <th>目的地</th>
    　<th>価格</th>
    　<th>選択</th>
    </tr>
<?php if(count($error) > 0) { ?>
    <?php foreach($error as $value) { ?>
        <?php print h($value); ?>
    <?php } ?>
<?php } else if(empty($data)) {?>
     <p class="nothing"><?php print '該当する商品はございません'; ?></p>
  <?php } else { ?>
        <p class="search_result"><?php print '【検索結果】'; ?>
            <?php if($data) { ?>
                <?php for($i = 0; $i < count($data); $i++) { ?>
                  <?php $sum = $sum + count($data[$i]['ID']); ?>
                <?php } ?>
                  <?php echo '該当'.$sum.'件'; ?>
            <?php } ?>
        </p>
<?php foreach ($data as $value) { ?>
  <form method='post' action='choice_02.php'>
    <tr>
      <td><img src="<?php print $img_dir . h($value['img']) ; ?>"></td>
      <td><?php print h($value['country_name']); ?></td>
      <td><?php print h(number_format($value['price'])).'円〜'; ?></td>
      <td>
        <?php if($value['stock'] > 0) { ?>
          <input type="hidden" name="country_name" value="<?php print $value['country_name']; ?>">
          <input type="hidden" name="img" value="<?php print $value['img']; ?>">
          <input type="hidden" name="stock" value="<?php print $value['stock']; ?>">
          <input type="hidden" name="status" value="<?php print $value['status']; ?>">
          <input type="hidden" name="price" value="<?php print $value['price']; ?>">
          <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
          <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          <input type="submit" value="カートへ入れる">
        <?php } else { ?>
         <p class="sold_out"><?php print '売り切れ'; ?></p>
          <?php } ?>
      </td>
    </tr>
  </form>
<?php } ?>
   <?php } ?>
  </table>
  </div>
    <?php print "<br>". "<br>".'<a href="index_02.php">商品一覧ページへ戻る</a>' ?>
  <footer>
    <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>