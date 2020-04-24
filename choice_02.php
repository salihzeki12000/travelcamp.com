<?php
    require_once('setting.php');
    
    $result = array();
    
    session_start();
 
if (!isset($_SESSION["USERID"])) {
  header("Location: logout_02.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     if (isset($_POST['country_name']) === TRUE) {
         $country_name = $_POST['country_name'];
     } 
     if (isset($_POST['ID']) === TRUE) {
         $ID = $_POST['ID'];
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
                $sql = 'SELECT ec_master.ID, status, stock, country_name
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
                }  else if(!empty($data)) {
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
  


?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>検索結果</title>
  <link rel="stylesheet" href="choice_02.css">
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
      <p class="cart_msg"><?php echo h($cart); ?></p>
  <?php foreach ($result as $value) { ?> 
      <?php print h($value); ?>
  <?php } ?> 
   <?php print '<br>'.'<a href="index_02.php">商品一覧ページへ戻る</a>' ?>
  </div>
  <footer>
    <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>
