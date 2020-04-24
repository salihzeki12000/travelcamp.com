<?php
require_once('setting.php');

$result = array();
$warning = array();

session_start();
 
if (!isset($_SESSION["USERID"])) {
  header("Location: logout_02.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $sql = 'SELECT country_name, departure, back, airport, seat_class
                FROM ec_cart
                INNER JOIN userdata
                ON ec_cart.user_id = userdata.user_id 
                WHERE name = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $_SESSION["USERID"], PDO::PARAM_STR);
        $stmt->execute();
        $contents = $stmt->fetchAll();
        }  
            catch (PDOException $e) {
                $result[] = '接続できませんでした。理由：'.$e->getMessage();
            } 
            foreach($contents as $content) {
                if(is_empty_date($content['departure']) || is_empty_date($content['back'])) {
                    $warning[] = $content['country_name'].'の旅行期間を入力してください';
                }
                if(empty($content['airport'])) {
                    $warning[] = $content['country_name'].'の出発地を設定してください';
                }
                if(empty($content['seat_class'])) {
                    $warning[] = $content['country_name'].'の座席クラスを設定してください';
                }
            }
            if(count($warning) === 0) {
                try {
                    $sql = 'SELECT country_name, price, img, ID, amount, departure, back, airport, increase, increase_02, increase_03
                            FROM ec_cart';
                    $stmt = $dbh->prepare($sql);
                    $stmt->execute();
                    $data = $stmt->fetchAll();
                }  
                    catch (PDOException $e) {
                        $result[] = '接続できませんでした。理由：'.$e->getMessage();
                    } 
                foreach($data as $value) {
                    $ID = $value['ID'];
                    $price = $value['price'];
                    $country_name = $value['country_name'];
                    $img = $value['img'];
                    $amount = $value['amount'];
                    $departure = $value['departure'];
                    $back = $value['back'];
                    $airport = $value['airport'];
                    $increase = $value['increase'];
                    $increase_02 = $value['increase_02'];
                    $increase_03 = $value['increase_03'];
                    $total = $price * $amount * $increase * $increase_02 * $increase_03;
                    
                try {
                    $sql = 'SELECT ec_master.ID, country_name, price, img, stock, status
                            FROM ec_master 
                            INNER JOIN ec_stock 
                            ON ec_master.ID = ec_stock.ID
                            WHERE ec_master.ID = ?';
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                    $stmt->execute();
                    $rows = $stmt->fetchAll(); 
                } 
                        catch (PDOException $e) {
                            $result[] = '接続できませんでした。理由：'.$e->getMessage();
                        } 
                        $stock = $rows[0]['stock'];
                        $status = $rows[0]['status'];
                            if ($stock <= 0) {
                                $result[] = $rows[0]['country_name'].'は先ほど売り切れました';
                            }  
                                 else if ($status === 0) {
                                     $result[] = $rows[0]['country_name'].'は現在お取り扱いしておりません';
                                 }  
                        if (count($result) === 0) {
                            try {
                                $sql = 'SELECT userdata.user_id
                                        FROM userdata
                                        WHERE name = ?';
                                $stmt = $dbh->prepare($sql);
                                $stmt->bindValue(1, $_SESSION["USERID"], PDO::PARAM_STR);
                                $stmt->execute();
                                $get_userid = $stmt->fetchAll(); 
                                
                                 $dbh->beginTransaction();
                                try { 
                                    $sql = 'INSERT INTO purchase_history (user_id, ID, country_name, departure, back, airport, charge, create_datetime) 
                                            VALUES(?,?,?,?,?,?,?,NOW())';
                                    $stmt = $dbh->prepare($sql);
                                    $stmt->bindValue(1, $get_userid[0]['user_id'], PDO::PARAM_INT);
                                    $stmt->bindValue(2, $ID, PDO::PARAM_STR);
                                    $stmt->bindValue(3, $country_name, PDO::PARAM_INT);
                                    $stmt->bindValue(4, $departure, PDO::PARAM_INT);
                                    $stmt->bindValue(5, $back, PDO::PARAM_INT);
                                    $stmt->bindValue(6, $airport, PDO::PARAM_STR);
                                    $stmt->bindValue(7, $total, PDO::PARAM_INT);
                                    $stmt->execute();
                                 
                                    $stock = ($rows[0]['stock'] - $value['amount']);
                                    $sql = 'UPDATE ec_stock 
                                            SET stock= ?, update_datetime= NOW()
                                            WHERE ID = ?';
                                    $stmt = $dbh->prepare($sql);
                                    $stmt->bindValue(1, $stock, PDO::PARAM_INT);
                                    $stmt->bindValue(2, $ID, PDO::PARAM_INT);
                                    $stmt->execute();
                                 
                                    $dbh->commit();
                                    $rows = $stmt->fetchAll(); 
                                }  catch (PDOException $e) {
                                    $dbh->rollback();
                                     throw $e;
                                   }
                            }
                            catch (PDOException $e) {
                                    $result[] = '登録できませんでした。理由：'.$e->getMessage();
                            }
                        }
             }
                         if (count($result) === 0) {
                             try {
                                 $sql = 'SELECT ec_cart.user_id, country_name, price, img, amount, departure, back, increase, airport, increase_02, seat_class, increase_03
                                         FROM ec_cart
                                         INNER JOIN userdata
                                         ON ec_cart.user_id = userdata.user_id 
                                         WHERE name = ?';
                                 $stmt = $dbh->prepare($sql);
                                 $stmt->bindValue(1, $_SESSION["USERID"], PDO::PARAM_STR);
                                 $stmt->execute();
                                 $data_02 = $stmt->fetchAll();
                             
                                 $sql = 'DELETE 
                                         FROM ec_cart
                                         WHERE user_id = ?';
                                 $stmt = $dbh->prepare($sql);
                                 $stmt->bindValue(1, $data_02[0]['user_id'], PDO::PARAM_INT);
                                 $stmt->execute();
                             }  
                                catch (PDOException $e) {
                                    $result[] = '接続できませんでした。理由：'.$e->getMessage();
                                } 
                         }
            }
}


?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>購入結果ページ</title>
   <link rel="stylesheet" href="result_02.css">
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
    <?php if(count($warning) > 0) { ?>
    <a href="purchase_02.php">カートへ戻る</a>
    <?php } ?>
  <table>
    <tr>
      <th><!--picture--></th>
      <th>旅行期間</th>
      <th>出発地</th>
      <th>目的地</th>
      <th>座席クラス</th>
    　<th>価格(円)</th>
    　<th>人数</th>
    </tr>
    <?php foreach ($result as $value) { ?>
        <p class="error_message"><?php print h($value); ?></p>
    <?php } ?>
<?php foreach($warning as $value) { ?>
    <p class="err"><?php echo '<br>'.h($value); ?></p>
<?php } ?>
<?php foreach ($data_02 as $value) { ?>
    <tr>
      <td><img src="<?php print $img_dir . h($value['img']) ; ?>"></td>
      <td><?php  print h(date('Y年n月j日',strtotime($value['departure']))).'&nbsp;〜&nbsp;'.h(date('Y年n月j日', strtotime($value['back']))); ?></td>
      <td><?php  print h($value['airport']); ?></td>
      <td><?php  print h($value['country_name']); ?></td>
      <td><?php  print h($value['seat_class']); ?></td>
      <td><?php  print h(number_format($value['price'] * $value['increase'] * $value['increase_02'] * $value['increase_03'])); ?></td>
      <td><?php  print h($value['amount']); ?></td>
    </tr>
<?php } ?>
  </table>
  <span class="charge">合計
<?php foreach($data_02 as $value) { ?>
<?php $sum += ($value['price'] * $value['increase'] * $value['increase_02'] * $value['increase_03'] * $value['amount']); ?>
<?php } ?>
<?php if(!empty($data_02)) { ?>
<?php print h(number_format($sum));?>
円</span>
    <p class="bottom">ご購入ありがとうございました</p>
<?php } ?>
   <?php print '<br>'.'<br>'.'<br>'. '<a href="index_02.php" >商品一覧ページへ戻る</a>';?>
  </div>
  <footer>
      <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>