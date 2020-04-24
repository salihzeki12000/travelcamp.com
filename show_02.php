<?php
require_once('ranking_02.php');
require_once('review_02.php');
require_once('setting.php');

$err = '';

session_start();
 
if (!isset($_SESSION["USERID"])) {
  header("Location: logout_02.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') { 
    if(isset($_GET['name']) === TRUE) {
        $town = $_GET['name'];
        $city = Ranking::findByName($cities, $town);
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
}


?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ランキング</title>
  <link rel="stylesheet" href="show_02.css">
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
      <?php $sum_cart += $value['amount']; ?>
      <?php endforeach ?>
      <a <?php if($sum_cart < 100) { ?> class="amount" <?php } else {?> class="amount over_99" <?php } ?> href="purchase_02.php">
          <?php if($sum_cart < 100): echo h($sum_cart); ?>
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
      <div class="image">
        <img src="<?php if(isset($city->img)) { echo h($city->img); } ?>"><br>
      </div>
        <h2 class="city_name"><?php if(isset($city->name)) { echo h($city->name) . '<br>'; } ?></h2>
        <p class="review"><?php if(isset($city->food)) { echo '食べ物：'.h($city->food).'<br>'; } ?></p>
        <p class="review"><?php if(isset($city->sightseeing)) { echo '観　光：'.h($city->sightseeing).'<br>'; } ?></p>
        <p class="review"><?php if(isset($city->price)) { echo '物　価：'.h($city->price).'<br>'; } ?></p>
        <?php if(isset($town)) { ?>
        <p class="review_title">&lt;&nbsp;口コミ&nbsp;&gt;
        <?php } ?>
        <?php if(isset($_GET['name']) === TRUE): ?>
            <?php foreach($reviews as $review): ?>
                <?php if($review->city_name === $town): ?>
                    <?php $sum += count($review->city_name); ?>
                <?php endif ?>
           <?php endforeach ?>
        <?php endif ?>
       <?php if(isset($town)) { ?>
            <?php echo h($sum).'件'; ?>
       <?php } ?>
        </p>
        <?php if(isset($_GET['name']) === TRUE): ?>
            <?php foreach($reviews as $review): ?>
                <?php if($review->city_name === $town): ?>
                <ul>
                    <li><?php echo h($review->comment) ; ?></li>
                </ul>
                <?php endif ?>
            <?php endforeach ?>
        <?php endif ?>
        <br><a href="index_02.php">戻る</a>
    </div>
  </div>
  <footer>
    <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>