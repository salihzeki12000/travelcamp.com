<?php
require_once('ranking_02.php');
require_once('setting.php');

 $result = array();
 $sum = 0;
 
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
    if (isset($_POST['sql_kind']) === TRUE) {
        $sql_kind = $_POST['sql_kind'];
    }
    if($sql_kind === 'number') {
        if (isset($_POST['ID']) === TRUE) {
            $ID = $_POST['ID'];
         }
         if (isset($_POST['country_name']) === TRUE) {
            $country_name = $_POST['country_name'];
         } 
         if (isset($_POST['price']) === TRUE) {
            $price = $_POST['price'];
         } 
         if (isset($_POST['img']) === TRUE) {
            $img = $_POST['img'];
         } 
         if (isset($_POST['stock']) === TRUE) {
            $stock = $_POST['stock'];
         } 
         if (isset($_POST['status']) === TRUE) {
            $status = $_POST['status'];
         }
            try {
                $sql = 'SELECT ec_master.ID, country_name, status, stock
                        FROM ec_master 
                        INNER JOIN ec_stock
                        ON ec_master.ID = ec_stock.ID
                        WHERE ec_master.ID = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetchAll(); 
            } 
                catch (PDOException $e) {
                    $result[] = '接続できませんでした。理由：'.$e->getMessage();
                } 
                    if(empty($data)) {
                        $result[] = $data[0]['country_name'].'は現在お取り扱いしておりません';
                    }   else if(!empty($data)) {
                            if ($data[0]['stock'] < 1) {
                                 $result[] = $data[0]['country_name'].'は売り切れました';
                             }  else if ($data[0]['status'] === 0) {
                                    $result[] = $data[0]['country_name'].'は現在お取り扱いしておりません';
                                }
                        } 
                    if(count($result) === 0) {
                    //   try {
                    //       $sql = 'SELECT ID, country_name, amount, userdata.name
                    //               FROM ec_cart
                    //               INNER JOIN userdata
                    //               ON ec_cart.user_id = userdata.user_id
                    //               WHERE ID = ? && name = ?';
                    //       $stmt = $dbh->prepare($sql);
                    //       $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                    //       $stmt->bindValue(2, $_SESSION["USERID"], PDO::PARAM_STR);
                    //       $stmt->execute();
                    //       $data = $stmt->fetchAll();
                    //   }  
                    //         catch (PDOException $e) {
                    //             $result[] = '接続できませんでした。理由：'.$e->getMessage();
                    //         }
                            //  if(empty($data)) {
                                try {
                                    $sql = 'SELECT ID, country_name
                                            FROM ec_master
                                            WHERE ID = ?';
                                    $stmt = $dbh->prepare($sql);
                                    $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $data_02 = $stmt->fetchAll();
                                    
                                    $sql = 'SELECT user_id
                                            FROM userdata
                                            WHERE name = ?';
                                    $stmt = $dbh->prepare($sql);
                                    $stmt->bindValue(1, $_SESSION["USERID"], PDO::PARAM_STR);
                                    $stmt->execute();
                                    $data_03 = $stmt->fetchAll(); 
                                    
                                    $sql = '
                                            INSERT INTO ec_cart (user_id, ID, country_name, price, img, amount, departure, back, create_datetime, update_datetime) 
                                            VALUES(?,?,?,?,?,?,0,0,NOW(),NOW())
                                            ON DUPLICATE KEY UPDATE amount = amount + 1, update_datetime = NOW()
                                           ';
                                    $stmt = $dbh->prepare($sql);
                                    $stmt->bindValue(1, $data_03[0]['user_id'], PDO::PARAM_INT);
                                    $stmt->bindValue(2, $ID, PDO::PARAM_INT);
                                    $stmt->bindValue(3, $country_name, PDO::PARAM_STR);
                                    $stmt->bindValue(4, $price, PDO::PARAM_INT);
                                    $stmt->bindValue(5, $img, PDO::PARAM_STR);
                                    $stmt->bindValue(6, $amount, PDO::PARAM_INT);
                                    $stmt->execute();
                                    $cart = $data_02[0]['country_name'].'をカートへ入れました';
                                }  
                                        catch (PDOException $e) {
                                            $result[] = '接続できませんでした。理由：'.$e->getMessage();
                                        } 
                            //  } else if(!empty($data)) {
                            //       $amount = $data[0]['amount'] + 1 ;
                            //           try {
                            //               $sql = 'SELECT ID, country_name
                            //                       FROM ec_master
                            //                       WHERE ID = ?';
                            //               $stmt = $dbh->prepare($sql);
                            //               $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                            //               $stmt->execute();
                            //               $data_02 = $stmt->fetchAll();
                                          
                            //               $sql = 'SELECT user_id
                            //                       FROM userdata
                            //                       WHERE name = ?';
                            //               $stmt = $dbh->prepare($sql);
                            //               $stmt->bindValue(1, $_SESSION["USERID"], PDO::PARAM_STR);
                            //               $stmt->execute();
                            //               $data_03 = $stmt->fetchAll(); 
                                          
                            //               $sql = 'UPDATE ec_cart 
                            //                       SET amount = ?, update_datetime = NOW() 
                            //                       WHERE user_id = ? && ID = ?';
                            //               $stmt = $dbh->prepare($sql);
                            //               $stmt->bindValue(1, $amount, PDO::PARAM_INT);
                            //               $stmt->bindValue(2, $data_03[0]['user_id'], PDO::PARAM_INT);
                            //               $stmt->bindValue(3, $data_02[0]['ID'], PDO::PARAM_INT);
                            //               $stmt->execute();
                            //               $cart = $data_02[0]['country_name'].'をカートへ入れました';
                            //           }  
                            //             catch (PDOException $e) {
                            //                 $result[] = '接続できませんでした。理由：'.$e->getMessage();
                            //             }
                            //   }
                    }
    }
}

try {
    $sql = 'SELECT ec_master.ID, country_name, price, img, stock, status, country_code
            FROM ec_master 
            INNER JOIN ec_stock 
            ON ec_master.ID = ec_stock.ID
            ORDER BY ID DESC';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();
    
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
        $result[] = '接続できませんでした。理由：'.$e->getMessage();
    }

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['order']) === TRUE) {
        $order = $_GET['order'];
    }
    if($order === 'price_high') {
        try {
            $sql = 'SELECT ec_master.ID, country_name, price, img, stock, status, country_code
                    FROM ec_master 
                    INNER JOIN ec_stock 
                    ON ec_master.ID = ec_stock.ID
                    ORDER BY price DESC';
            $stmt = $dbh->prepare($sql);
            $stmt->execute();
            $data_price_high = $stmt->fetchAll();
        }    catch (PDOException $e) {
                  $result[] = '接続できませんでした。理由：'.$e->getMessage();
             } 
    } else if($order === 'price_low') {
          try {
              $sql = 'SELECT ec_master.ID, country_name, price, img, stock, status, country_code
                      FROM ec_master 
                      INNER JOIN ec_stock 
                      ON ec_master.ID = ec_stock.ID
                      ORDER BY price';
              $stmt = $dbh->prepare($sql);
              $stmt->execute();
              $data_price_low = $stmt->fetchAll();
          }    catch (PDOException $e) {
                  $result[] = '接続できませんでした。理由：'.$e->getMessage();
               }
      } else if($order === 'popular') {
            try {
                $sql = 'SELECT COUNT(purchase_history.ID), ec_master.ID, ec_master.country_name, ec_master.price, ec_master.img, ec_stock.stock, ec_master.status, ec_master.country_code
                        FROM purchase_history
                        INNER JOIN ec_master 
                        ON purchase_history.ID = ec_master.ID
                        INNER JOIN ec_stock
                        ON purchase_history.ID = ec_stock.ID
                        GROUP BY purchase_history.ID';
                $stmt = $dbh->prepare($sql);
                $stmt->execute();
                $data_popular = $stmt->fetchAll();
                rsort($data_popular);
            }    catch (PDOException $e) {
                    $result[] = '接続できませんでした。理由：'.$e->getMessage();
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
  <title>商品一覧ページ</title>
  <link rel="stylesheet" href="index_02.css">
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
      <a <?php if($sum < 100) { ?> class="amount" <?php } else { ?> class="amount over_99" <?php } ?> href="purchase_02.php">
          <?php if($sum < 100): echo h($sum); ?>
            <?php else: echo '99+'; ?>
      </a>
            <?php endif ?>
      </span>
      <a href="purchase_02.php"><img class="cart" src="./logo_etc/cart_03.png"></a>
    </div>
  </div> 
  <div class="main">
    <div class="left_side">
      <div class="left_side_scroll">
        <form class="search_box" method="post" action="search_02.php">
          <input type="text" name="search" class="textbox" placeholder="行き先">
          <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          <input class="search_button" type="submit" value="検索" >
        </form>
      <div class="left_box">
        <h2 class="title_left">2020年人気旅行先</h2>
          <ul class="left_box_upper">
            <?php foreach($cities as $city): ?>
            <a  class="city" href="show_02.php?name=<?php echo $city->name; ?>">
              <li class="bar">&emsp;<?php echo h($city->name);?></li>
            </a>
            <?php endforeach ?>
          </ul>
      </div>
      <div class="left_box">
         <h2 class="title_left">今月の格安航空券</h2>
            <ul class="left_box_bottom">
              <li class="bar">&emsp;マニラ（3.4万円〜)
                <?php for ($i = 0; $i < count($data); $i++) { ?>
                  <?php if($data[$i]['country_name'] === 'Manila') { ?>
                    <?php if($data[$i]['stock'] > 0) { ?>
                    <span class="sale"><?php echo '残り'.$data[$i]['stock'].'席'; ?></span>
                    <?php } else { ?>
                    <span class="sale"><?php echo '売切れ'; ?></span>
                      <?php }?>
                  <?php } ?>
                <?php } ?>
              </li>
              <li class="bar">&emsp;台北（2.2万円〜）
                <?php for ($i = 0; $i < count($data); $i++) { ?>
                  <?php if($data[$i]['country_name'] === 'Taipei') { ?>
                    <?php if($data[$i]['stock'] > 0) { ?>
                    <span class="sale"><?php echo '残り'.$data[$i]['stock'].'席'; ?></span>
                    <?php } else { ?>
                    <span class="sale"><?php echo '売切れ'; ?></span>
                      <?php } ?>
                  <?php } ?>
                <?php } ?>
              </li>
              <li class="bar">&emsp;ロンドン（9万円〜）
                <?php for ($i = 0; $i < count($data); $i++) { ?>
                  <?php if($data[$i]['country_name'] === 'London') { ?>
                    <?php if($data[$i]['stock'] > 0) { ?>
                    <span class="sale"><?php echo '残り'.$data[$i]['stock'].'席'; ?></span>
                    <?php } else { ?>
                    <span class="sale"><?php echo '売切れ'; ?></span>
                      <?php } ?>
                   <?php } ?>
                <?php } ?>
              </li>
              <li class="bar">&emsp;ホノルル（6万円〜）
                <?php for ($i = 0; $i < count($data); $i++) { ?>
                  <?php if($data[$i]['country_name'] === 'Honolulu') { ?>
                     <?php if($data[$i]['stock'] > 0) { ?>
                     <span class="sale"><?php echo '残り'.$data[$i]['stock'].'席'; ?></span>
                     <?php } else { ?>
                     <span class="sale"><?php echo '売切れ'; ?></span>
                       <?php } ?>
                  <?php } ?>
                <?php } ?>
              </li>
              <li class="bar">&emsp;ドバイ（7万円〜）
                <?php for ($i = 0; $i < count($data); $i++) { ?>
                  <?php if($data[$i]['country_name'] === 'Dubai') { ?>
                     <?php if($data[$i]['stock'] > 0) { ?>
                     <span class="sale"><?php echo '残り'.$data[$i]['stock'].'席'; ?></span>
                     <?php } else { ?>
                     <span class="sale"><?php echo '売切れ'; ?></span>
                       <?php } ?>
                   <?php } ?>
                <?php } ?>
              </li>
              <li class="bar">&emsp;ソウル（1.3万円〜）
                <?php for ($i = 0; $i < count($data); $i++) { ?>
                  <?php if($data[$i]['country_name'] === 'Seoul') { ?>
                     <?php if($data[$i]['stock'] > 0) { ?>
                     <span class="sale"><?php echo '残り'.$data[$i]['stock'].'席'; ?></span>
                     <?php } else { ?>
                     <span class="sale"><?php echo '売切れ'; ?></span>
                       <?php } ?>
                  <?php } ?>
                <?php } ?>
              </li>
              <li class="bar">&emsp;ローマ（12万円〜）
                <?php for ($i = 0; $i < count($data); $i++) { ?>
                  <?php if($data[$i]['country_name'] === 'Rome') { ?>
                     <?php if($data[$i]['stock'] > 0) { ?>
                     <span class="sale"><?php echo '残り'.$data[$i]['stock'].'席'; ?></span>
                     <?php } else { ?>
                     <span class="sale"><?php echo '売切れ'; ?></span>
                       <?php } ?>
                  <?php } ?>
                <?php } ?>
              </li>
            </ul>
      </div>
      </div>
    <div>
      <span>旅行体験記は</span><a href="bbs.php">こちら</a>
    </div>
      <div class="service">
        <p>まだ旅行先が決まっていない方は<a href="service.php">こちら</a></p>
      </div>
    </div>
    <div class="layout">
      <form id="row" class="order" method="GET">
        <select name="order" onChange="this.form.submit()">
          <option>新着順</option>
          <option value="price_high" <?php if($order === 'price_high') { ?>  selected <?php } ?>>価格が高い順</option>
          <option value="price_low" <?php if($order === 'price_low') { ?>  selected <?php } ?>>価格が安い順</option>
          <option value="popular" <?php if($order === 'popular') { ?>  selected <?php } ?>>人気順</option>
        </select>
      </form>
      <div class="clearfix">
        <p class="cart_msg"><?=  h($cart); ?></p>
        <?php foreach ($result as $value) { ?>
              <p class="err_msg"><?php print h($value); ?></p>
        <?php } ?>
        <h2 class="direction">アメリカ・ヨーロッパ方面</h2>
<?php if($order === 'price_high') { ?>
    <?php foreach($data_price_high as $value) { ?>
        <?php if (($value['status'] === 1) && ($value['country_code'] === 1)) { ?>
            <div class="inner_top">
              <span title="<?php echo h($value['country_name']); ?>"><img class="pic" src="<?php print $img_dir . h($value['img']); ?>"></span>
              <span class="pic_bottom"><?php print h($value['country_name']); ?></span>
              <span class="pic_bottom"><?php print h(number_format($value['price'])); ?>円〜</span>
            <?php if($value['stock'] > 0) { ?>
                <span class="pic_bottom">
                  <form method='post'>
                    <input type="hidden" name="sql_kind" value="number">
                    <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
                    <input type="hidden" name="price" value="<?php print $value['price']; ?>">
                    <input type="hidden" name="img" value="<?php print $value['img']; ?>">
                    <input type="hidden" name="stock" value="<?php print $value['stock']; ?>">
                    <input type="hidden" name="status" value="<?php print $value['status']; ?>">
                    <input type="hidden" name="country_name" value="<?php print $value['country_name']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
                    <input type="submit" name="submit" value="カートへ入れる">
                  </form>
                </span>
            <?php } ?>
                <?php if($value['stock'] === 0) { ?>
                <span class="sold_out"><?php print '売切れ'; ?></span>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
<?php } else if($order === 'price_low') { ?>
    <?php foreach($data_price_low as $value) { ?>
        <?php if (($value['status'] === 1) && ($value['country_code'] === 1)) { ?>
            <div class="inner_top">
              <span title="<?php echo h($value['country_name']); ?>"><img class="pic" src="<?php print $img_dir . h($value['img']); ?>"></span>
              <span class="pic_bottom"><?php print h($value['country_name']); ?></span>
              <span class="pic_bottom"><?php print h(number_format($value['price'])); ?>円〜</span>
            <?php if($value['stock'] > 0) { ?>
                <span class="pic_bottom">
                  <form method='post'>
                    <input type="hidden" name="sql_kind" value="number">
                    <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
                    <input type="hidden" name="price" value="<?php print $value['price']; ?>">
                    <input type="hidden" name="img" value="<?php print $value['img']; ?>">
                    <input type="hidden" name="stock" value="<?php print $value['stock']; ?>">
                    <input type="hidden" name="status" value="<?php print $value['status']; ?>">
                    <input type="hidden" name="country_name" value="<?php print $value['country_name']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
                    <input type="submit" name="submit" value="カートへ入れる">
                  </form>
                </span>
            <?php } ?>
                <?php if($value['stock'] === 0) { ?>
                <span class="sold_out"><?php print '売切れ'; ?></span>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
<?php }  else if($order === 'popular') { ?>
    <?php foreach($data_popular as $value) { ?>
        <?php if (($value['status'] === 1) && ($value['country_code'] === 1)) { ?>
            <div class="inner_top">
              <span title="<?php echo h($value['country_name']); ?>"><img class="pic" src="<?php print $img_dir . h($value['img']); ?>"></span>
              <span class="pic_bottom"><?php print h($value['country_name']); ?></span>
              <span class="pic_bottom"><?php print h(number_format($value['price'])); ?>円〜</span>
            <?php if($value['stock'] > 0) { ?>
                <span class="pic_bottom">
                  <form method='post'>
                    <input type="hidden" name="sql_kind" value="number">
                    <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
                    <input type="hidden" name="price" value="<?php print $value['price']; ?>">
                    <input type="hidden" name="img" value="<?php print $value['img']; ?>">
                    <input type="hidden" name="stock" value="<?php print $value['stock']; ?>">
                    <input type="hidden" name="status" value="<?php print $value['status']; ?>">
                    <input type="hidden" name="country_name" value="<?php print $value['country_name']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
                    <input type="submit" name="submit" value="カートへ入れる">
                  </form>
                </span>
            <?php } ?>
                <?php if($value['stock'] === 0) { ?>
                <span class="sold_out"><?php print '売切れ'; ?></span>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <?php foreach ($data as $value)  { ?>
        <?php if (($value['status'] === 1) && ($value['country_code'] === 1)) { ?>
            <div class="inner_top">
              <span title="<?php echo h($value['country_name']); ?>"><img class="pic" src="<?php print $img_dir . h($value['img']); ?>"></span>
              <span class="pic_bottom"><?php print h($value['country_name']); ?></span>
              <span class="pic_bottom"><?php print h(number_format($value['price'])); ?>円〜</span>
            <?php if($value['stock'] > 0) { ?>
                <span class="pic_bottom">
                  <form method='post'>
                    <input type="hidden" name="sql_kind" value="number">
                    <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
                    <input type="hidden" name="price" value="<?php print $value['price']; ?>">
                    <input type="hidden" name="img" value="<?php print $value['img']; ?>">
                    <input type="hidden" name="stock" value="<?php print $value['stock']; ?>">
                    <input type="hidden" name="status" value="<?php print $value['status']; ?>">
                    <input type="hidden" name="country_name" value="<?php print $value['country_name']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
                    <input type="submit" name="submit" value="カートへ入れる">
                  </form>
                </span>
            <?php } ?>
                <?php if($value['stock'] === 0) { ?>
                <span class="sold_out"><?php print '売切れ'; ?></span>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
<?php } ?>
      </div>
      <div class="clearfix footer">
        <h2 class="direction">東南アジア・オセアニア方面</h2>
<?php if($order === 'price_high') { ?>
    <?php foreach($data_price_high as $value) { ?>
        <?php if (($value['status'] === 1) && ($value['country_code'] === 2)) { ?>
            <div class="inner_top">
              <span title="<?php echo h($value['country_name']); ?>"><img class="pic" src="<?php print $img_dir . h($value['img']); ?>"></span>
              <span class="pic_bottom"><?php print h($value['country_name']); ?></span>
              <span class="pic_bottom"><?php print h(number_format($value['price'])); ?>円〜</span>
            <?php if($value['stock'] > 0) { ?>
                <span class="pic_bottom">
                  <form method='post'>
                    <input type="hidden" name="sql_kind" value="number">
                    <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
                    <input type="hidden" name="price" value="<?php print $value['price']; ?>">
                    <input type="hidden" name="img" value="<?php print $value['img']; ?>">
                    <input type="hidden" name="stock" value="<?php print $value['stock']; ?>">
                    <input type="hidden" name="status" value="<?php print $value['status']; ?>">
                    <input type="hidden" name="country_name" value="<?php print $value['country_name']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
                    <input type="submit" name="submit" value="カートへ入れる">
                  </form>
                </span>
            <?php } ?>
                <?php if($value['stock'] === 0) { ?>
                <span class="sold_out"><?php print '売切れ'; ?></span>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
<?php } else if($order === 'price_low') { ?>
    <?php foreach($data_price_low as $value) { ?>
        <?php if (($value['status'] === 1) && ($value['country_code'] === 2)) { ?>
            <div class="inner_top">
              <span title="<?php echo h($value['country_name']); ?>"><img class="pic" src="<?php print $img_dir . h($value['img']); ?>"></span>
              <span class="pic_bottom"><?php print h($value['country_name']); ?></span>
              <span class="pic_bottom"><?php print h(number_format($value['price'])); ?>円〜</span>
            <?php if($value['stock'] > 0) { ?>
                <span class="pic_bottom">
                  <form method='post'>
                    <input type="hidden" name="sql_kind" value="number">
                    <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
                    <input type="hidden" name="price" value="<?php print $value['price']; ?>">
                    <input type="hidden" name="img" value="<?php print $value['img']; ?>">
                    <input type="hidden" name="stock" value="<?php print $value['stock']; ?>">
                    <input type="hidden" name="status" value="<?php print $value['status']; ?>">
                    <input type="hidden" name="country_name" value="<?php print $value['country_name']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
                    <input type="submit" name="submit" value="カートへ入れる">
                  </form>
                </span>
            <?php } ?>
                <?php if($value['stock'] === 0) { ?>
                <span class="sold_out"><?php print '売切れ'; ?></span>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
<?php } else if($order === 'popular') { ?>
    <?php foreach($data_popular as $value) { ?>
        <?php if (($value['status'] === 1) && ($value['country_code'] === 2)) { ?>
            <div class="inner_top">
                <span title="<?php echo h($value['country_name']); ?>"><img class="pic" src="<?php print $img_dir . h($value['img']); ?>"></span>
                <span class="pic_bottom"><?php print h($value['country_name']); ?></span>
                <span class="pic_bottom"><?php print h(number_format($value['price'])); ?>円〜</span>
            <?php if($value['stock'] > 0) { ?>
                <span class="pic_bottom">
                  <form method='post'>
                    <input type="hidden" name="sql_kind" value="number">
                    <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
                    <input type="hidden" name="price" value="<?php print $value['price']; ?>">
                    <input type="hidden" name="img" value="<?php print $value['img']; ?>">
                    <input type="hidden" name="stock" value="<?php print $value['stock']; ?>">
                    <input type="hidden" name="status" value="<?php print $value['status']; ?>">
                    <input type="hidden" name="country_name" value="<?php print $value['country_name']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
                    <input type="submit" name="submit" value="カートへ入れる">
                  </form>
                </span>
            <?php } ?>
                <?php if($value['stock'] === 0) { ?>
                <span class="sold_out"><?php print '売切れ'; ?></span>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <?php foreach ($data as $value)  { ?>
        <?php if (($value['status'] === 1) && ($value['country_code'] === 2)) { ?>
            <div class="inner_top">
                <span title="<?php echo h($value['country_name']); ?>"><img class="pic" src="<?php print $img_dir . h($value['img']); ?>"></span>
                <span class="pic_bottom"><?php print h($value['country_name']); ?></span>
                <span class="pic_bottom"><?php print h(number_format($value['price'])); ?>円〜</span>
            <?php if($value['stock'] > 0) { ?>
                <span class="pic_bottom">
                  <form method='post'>
                    <input type="hidden" name="sql_kind" value="number">
                    <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
                    <input type="hidden" name="price" value="<?php print $value['price']; ?>">
                    <input type="hidden" name="img" value="<?php print $value['img']; ?>">
                    <input type="hidden" name="stock" value="<?php print $value['stock']; ?>">
                    <input type="hidden" name="status" value="<?php print $value['status']; ?>">
                    <input type="hidden" name="country_name" value="<?php print $value['country_name']; ?>">
                    <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
                    <input type="submit" name="submit" value="カートへ入れる">
                  </form>
                </span>
            <?php } ?>
                <?php if($value['stock'] === 0) { ?>
                <span class="sold_out"><?php print '売切れ'; ?></span>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>
<?php } ?>
      </div>
    </div>
  </div>
  <footer>
    <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>