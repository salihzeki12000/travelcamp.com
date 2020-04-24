<?php
    require_once('setting.php');
    
    $sum = 0;
    $err = '';
    
    session_start();
 
if (!isset($_SESSION["USERID"])) {
  header("Location: logout_02.php");
  exit;
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
            $err = '接続できませんでした。理由：'.$e->getMessage();
        }



?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>トラベルコンシェルジュ</title>
  <link rel="stylesheet" href="service.css">
</head>
<body>
  <div class="header">
    <div class="header_next_01">
      <h1 class="company_name"><a class="top_logo" href="index_02.php">Travel&nbsp;Camp.com</a></h1>
    </div>
    <div class="header_next_02">
      <span class="welcome">ようこそ<u><?php print h($_SESSION["USERID"]); ?></u>さん
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
  <?php echo $err; ?>
    <div class="center">
      <h2>トラベルコンシェルジュサービス</h2>
      <p class="comment">以下のプルダウンメニューの選択を元にあなたに合う旅行先をご提案します。</p>
      <div class="form">
        <form action="recommend.php" method="POST">
          <p class="index">地&emsp;域</p>
          <select name="area">
            <option value="none_1">選択してください</option>
            <option value="asia">アジア・オセアニア方面</option>
            <option value="europe">ヨーロッパ・中近東方面</option>
            <option value="america">アメリカ大陸</option>
          </select>
          <p class="index">予&emsp;算</p>
          <select name="budget">
            <option value="none_2">選択してください</option>
            <option value="low">１０万円から１５万円</option>
            <option value="middle">１５万円から２０万円</option>
            <option value="high">２０万円から３０万円</option>
          </select>
          <p class="index">日&emsp;数</p>
          <select name="days">
            <option value="none_3">選択してください</option>
            <option value="short">３泊４日</option>
            <option value="normal">４泊５日</option>
            <option value="long">５泊以上</option>
          </select>
          <p class="index">過ごし方</p>
          <select name="time">
            <option value="none_4">選択してください</option>
            <option value="shopping">ショッピング・スパ</option>
            <option value="relax">ビーチなどでのんびり</option>
            <option value="adventure">アドベンチャー</option>
          </select>
            <br><br><p><input class="btn" type="submit" value="結&nbsp;果"></p>
          </form>  
       </div>
        <br><a href="index_02.php">戻る</a>
    </div>
  </div>
  <footer>
    <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>