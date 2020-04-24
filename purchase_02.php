<?php
    require_once('setting.php');
    require_once('city_box.php');
    
    $error = array();
    $total = 0;
    
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
    if($sql_kind === 'delete') {
    if (isset($_POST['delete']) === TRUE) {
        $delete = $_POST['delete'];
    }
    if (isset($_POST['ID']) === TRUE) {
        $ID = $_POST['ID'];
    } 
    try {
        $sql = 'SELECT country_name, userdata.user_id
                FROM ec_cart
                INNER JOIN userdata
                ON ec_cart.user_id = userdata.user_id 
                WHERE ID = ? && name = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
        $stmt->bindValue(2, $_SESSION["USERID"], PDO::PARAM_STR);
        $stmt->execute();
        $data_02 = $stmt->fetchAll(); 
        
        $sql = 'DELETE
                FROM ec_cart 
                WHERE ID = ? && user_id = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
        $stmt->bindValue(2, $data_02[0]['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(); 
        $error[] = $data_02[0]['country_name'].'を削除しました';
    } 
        catch (PDOException $e) {
            $error[] = '接続できませんでした。理由：'.$e->getMessage();
        }
    } 
    if (isset($_POST['sql_kind']) === TRUE) {
         $sql_kind = $_POST['sql_kind'];
    }     
    if($sql_kind === 'amount') {
    if (isset($_POST['amount']) === TRUE) {
        $amount = $_POST['amount'];
    }
    if (isset($_POST['ID']) === TRUE) {
        $ID = $_POST['ID'];
    }
    try {
        $sql = 'SELECT country_name, userdata.user_id, amount
                FROM ec_cart
                INNER JOIN userdata
                ON ec_cart.user_id = userdata.user_id 
                WHERE ID = ? && name = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
        $stmt->bindValue(2, $_SESSION["USERID"], PDO::PARAM_STR);
        $stmt->execute();
        $data_02 = $stmt->fetchAll(); 
    }  catch (PDOException $e) { 
        $error[] = '接続できませんでした。理由：'.$e->getMessage();
       }
          
    if (is_empty($amount) || (intval($amount) === $data_02[0]['amount'])) {
        $error[] = $data_02[0]['country_name'].'行きの変更人数を入力してださい';
    } else if (!ctype_digit($amount) || intval($amount) === 0) {
            $error[] = $data_02[0]['country_name'].'行きの変更人数は1以上の整数を入力してください';
      }
        if(count($error) === 0) {
            try {
                $sql = 'SELECT stock
                        FROM ec_stock 
                        WHERE ID = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetchAll(); 
            } 
                catch (PDOException $e) {
                    $error[] = '接続できませんでした。理由：'.$e->getMessage();
                }
                if($data[0]['stock'] < $amount) {
                     $error[] = $data_02[0]['country_name'].'行きの在庫が足りません';
                } else {
                    try {
                        $sql = 'SELECT country_name, userdata.user_id
                                FROM ec_cart
                                INNER JOIN userdata
                                ON ec_cart.user_id = userdata.user_id 
                                WHERE ID = ? && name = ?';
                        $stmt = $dbh->prepare($sql);
                        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                        $stmt->bindValue(2, $_SESSION["USERID"], PDO::PARAM_STR);
                        $stmt->execute();
                        $data_02 = $stmt->fetchAll(); 
                    
                        $sql = 'UPDATE ec_cart 
                                SET amount = ?, update_datetime = NOW()
                                WHERE ID = ? && user_id = ?';
                        $stmt = $dbh->prepare($sql);
                        $stmt->bindValue(1, $amount, PDO::PARAM_INT);
                        $stmt->bindValue(2, $ID, PDO::PARAM_INT);
                        $stmt->bindValue(3, $data_02[0]['user_id'], PDO::PARAM_INT);
                        $stmt->execute();
                        $error[] = $data_02[0]['country_name'].'行きの人数を変更しました';
                    } catch (PDOException $e) {
                          $error[] = '接続できませんでした。理由：'.$e->getMessage();
                      }
                 }
        }
    }
    if (isset($_POST['sql_kind']) === TRUE) {
         $sql_kind = $_POST['sql_kind'];
    }
    if (isset($_POST['ID']) === TRUE) {
            $ID = $_POST['ID'];
    }
    try {
        $sql = 'SELECT country_name, userdata.user_id
                FROM ec_cart
                INNER JOIN userdata
                ON ec_cart.user_id = userdata.user_id 
                WHERE ID = ? && name = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
        $stmt->bindValue(2, $_SESSION["USERID"], PDO::PARAM_STR);
        $stmt->execute();
        $data_02 = $stmt->fetchAll(); 
    }  catch (PDOException $e) { $error[] = '接続できませんでした。理由：'.$e->getMessage(); }
                   
    if($sql_kind === 'place') {
        if (isset($_POST['airport']) === TRUE) {
            $airport = $_POST['airport'];
        }
        if($airport === 'bar') {
            $error[] = $data_02[0]['country_name'].'行きの出発地を選択してください';
        } else {
            try {
                if(($airport === '成田空港') || ($airport === '羽田空港')) {
                      $increase_02 = 1;
                } else if($airport ==='関西空港') {
                        $increase_02 = 1.1;
                  }  else {
                          $increase_02 = 1.2;
                     }
                $sql = 'UPDATE ec_cart 
                        SET airport =?, increase_02 = ?  
                        WHERE ID = ? && user_id = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $airport, PDO::PARAM_STR);
                $stmt->bindValue(2, $increase_02, PDO::PARAM_STR);
                $stmt->bindValue(3, $ID, PDO::PARAM_INT);
                $stmt->bindValue(4, $data_02[0]['user_id'], PDO::PARAM_INT);
                $stmt->execute();
                $error[] = $data_02[0]['country_name'].'行きの出発地を設定しました';
            }  
                    catch (PDOException $e) {
                        $error[] = '接続できませんでした。理由：'.$e->getMessage();
                    }
          }
    }
    if (isset($_POST['sql_kind']) === TRUE) {
         $sql_kind = $_POST['sql_kind'];
    } 
    if($sql_kind === 'travel_term') {
        if (isset($_POST['departure']) === TRUE) {
            $departure = $_POST['departure'];
        } 
        if (isset($_POST['back']) === TRUE) {
            $back = $_POST['back'];
        }  
        if (isset($_POST['ID']) === TRUE) {
            $ID = $_POST['ID'];
        }
        try {
            $sql = 'SELECT country_name, userdata.user_id
                    FROM ec_cart
                    INNER JOIN userdata
                    ON ec_cart.user_id = userdata.user_id 
                    WHERE ID = ? && name = ?';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $ID, PDO::PARAM_INT);
            $stmt->bindValue(2, $_SESSION["USERID"], PDO::PARAM_STR);
            $stmt->execute();
            $data_02 = $stmt->fetchAll(); 
        }  catch (PDOException $e) { $error[] = '接続できませんでした。理由：'.$e->getMessage(); }
          
        if(($departure < $now) || ($back < $now)) {
            $error[] = $data_02[0]['country_name'].'行きの旅行期間に誤りがあります';
        } else if(($departure > $back) || ($departure === $back)) {
              $error[] = $data_02[0]['country_name'].'行きの旅行期間に誤りがあります';
          } 
               if(count($error) === 0) {
                 try {
                     $total = (strtotime($back) - strtotime($departure))/(60 * 60 * 24);
                        if($total > 10 && $total < 20) {
                             $increase = 1.1;
                        } else if($total > 20 && $total < 30) {
                               $increase = 1.2;
                          } else if($total > 30 && $total < 100) {
                                  $increase = 1.3;
                            } else {
                                $increase = 1;
                              }
                     $sql = 'UPDATE ec_cart
                             SET departure = ?, back = ?, increase = ?
                             WHERE ID = ? && user_id = ?';
                     $stmt = $dbh->prepare($sql);
                     $stmt->bindValue(1, $departure, PDO::PARAM_INT);
                     $stmt->bindValue(2, $back, PDO::PARAM_INT);
                     $stmt->bindValue(3, $increase, PDO::PARAM_STR);
                     $stmt->bindValue(4, $ID, PDO::PARAM_INT);
                     $stmt->bindValue(5, $data_02[0]['user_id'], PDO::PARAM_INT);
                     $stmt->execute();
                     $error[] = $data_02[0]['country_name'].'行きの旅行期間を設定しました';
                 }   
                    catch (PDOException $e) {
                        $error[] = '接続できませんでした。理由：'.$e->getMessage();
                    } 
               }
    }
    if (isset($_POST['sql_kind']) === TRUE) {
         $sql_kind = $_POST['sql_kind'];
    }     
    if($sql_kind === 'seat') {
    if (isset($_POST['seat_class']) === TRUE) {
        $seat_class = $_POST['seat_class'];
    } 
    if (isset($_POST['ID']) === TRUE) {
            $ID = $_POST['ID'];
    }
    try {
        $sql = 'SELECT country_name, userdata.user_id
                FROM ec_cart
                INNER JOIN userdata
                ON ec_cart.user_id = userdata.user_id 
                WHERE ID = ? && name = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
        $stmt->bindValue(2, $_SESSION["USERID"], PDO::PARAM_STR);
        $stmt->execute();
        $data_02 = $stmt->fetchAll(); 
    }  catch (PDOException $e) { $error[] = '接続できませんでした。理由：'.$e->getMessage(); }
         
    if($seat_class === 'seat_bar') {
        $error[] = $data_02[0]['country_name'].'行きの座席クラスを選択してください';
    } else {
        try {
            if($seat_class === 'エコノミー') {
                $increase_03 = 1;
            } else if($seat_class === 'プレエコ') {
                  $increase_03 = 2;
              } else if($seat_class === 'ビジネス') {
                    $increase_03 = 5;
                } else {
                      $increase_03 = 7;
                  }
            $sql = 'UPDATE ec_cart 
                    SET seat_class =?, increase_03 = ?  
                    WHERE ID = ? && user_id = ?';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $seat_class, PDO::PARAM_STR);
            $stmt->bindValue(2, $increase_03, PDO::PARAM_STR);
            $stmt->bindValue(3, $ID, PDO::PARAM_INT);
            $stmt->bindValue(4, $data_02[0]['user_id'], PDO::PARAM_INT);
            $stmt->execute();
            $error[] = $data_02[0]['country_name'].'行きの座席クラスを設定しました';
        }  
                catch (PDOException $e) {
                    $error[] = '接続できませんでした。理由：'.$e->getMessage();
                }
       }
    }
}
    try {
        $sql = 'SELECT country_name, price, img, ID, amount, departure, back, increase, airport, increase_02, seat_class, increase_03
                FROM ec_cart
                INNER JOIN userdata
                ON ec_cart.user_id = userdata.user_id 
                WHERE name = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $_SESSION["USERID"], PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll();
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
  <title>カート</title>
  <link rel="stylesheet" href="purchase_02.css">
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
 <div class="sub_main">
  <table>
    <tr>
      <th><!--picture--></th>
      <th>旅行期間<span class="must">(必須)</span></th>
      <th>出発地<span class="must">(必須)</span></th>
      <th>行先</th>
      <th>座席ｸﾗｽ<span class="must">(必須)</span></th>
      <th>旅程</th>
    　<th>価格(円)</th>
    　<th>人数</th>
    　<th>削除</th>
    </tr>
    　<?php foreach ($error as $value) { ?>
        <p class="err_msg"><?php print h($value); ?></p>
    <?php } ?>
   <?php foreach ($data as $value) { ?>
      <tr>
        <td><img src="<?php print $img_dir . h($value['img']) ; ?>"></td>
        <form method="post">
          <td>
            <p class="travel_term">行き</p>
            <input type="date" name="departure" value="<?php echo h($value['departure']); ?>">
            <p class="travel_term">帰り</p>
            <input type="date" name="back" value="<?php echo h($value['back']); ?>" onChange="this.form.submit()" >
            <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
            <input type="hidden" name="sql_kind" value="travel_term">
            <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          </td>
        </form>
        <form method="post">
          <td>
            <select name="airport" onChange="this.form.submit()">
              <option value="bar">---</option>
              <option <?php if($value['airport'] === '成田空港') { ?>  selected <?php } ?>>成田空港</option>
              <option <?php if($value['airport'] === '羽田空港') { ?>  selected <?php } ?>>羽田空港</option>
              <option <?php if($value['airport'] === '中部空港') { ?>  selected <?php } ?>>中部空港</option>
              <option <?php if($value['airport'] === '関西空港') { ?>  selected <?php } ?>>関西空港</option>
            </select>
            <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
            <input type="hidden" name="sql_kind" value="place">
            <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          </td>
        </form>
        <td><?php  print h($value['country_name']); ?></td>
        <form method="post">
          <td>
            <select name="seat_class" onChange="this.form.submit()">
              <option value="seat_bar">---</option>
              <option <?php if($value['seat_class'] === 'エコノミー') { ?>  selected <?php } ?>>エコノミー</option>
              <option <?php if($value['seat_class'] === 'プレエコ') { ?>  selected <?php } ?>>プレエコ</option>
              <option <?php if($value['seat_class'] === 'ビジネス') { ?>  selected <?php } ?>>ビジネス</option>
              <option <?php if($value['seat_class'] === 'ファースト') { ?>  selected <?php } ?>>ファースト</option>
            </select>
            <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
            <input type="hidden" name="sql_kind" value="seat">
            <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          </td>
        </form>
        <td>
          <form action="itinerary.php" method="POST">
            <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
            <input type="hidden" name="airport" value="<?php print $value['airport']; ?>">
            <input type="hidden" name="departure" value="<?php print $value['departure']; ?>">
            <input type="hidden" name="back" value="<?php print $value['back']; ?>">
            <input type="hidden" name="seat_class" value="<?php print $value['seat_class']; ?>">
            <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
            <button>確認</button>
          </form>
        </td>
        <td><?php  print number_format(h($total = $value['price'] * $value['increase'] * $value['increase_02'] * $value['increase_03'])); ?></td>
    　　<td class="line-height">
    　　    <form method="post">
            <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
            <input type="text" name="amount" size="5" value="<?php print h($value['amount']); ?>">人
            <input type="hidden" name="sql_kind" value="amount">
            <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
            <input type="submit" name="submit" value="変更">
          </form>
    　　</td>
    　　<td class="line-height">
          <form method="post">
            <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
            <input type="hidden" name="sql_kind" value="delete">
            <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
            <input type="submit" name="submit" value="削除">
          </form>
        </td>
      </tr> 
   　<?php } ?>
   </table>
  </div>
<span class="charge">合計
<?php foreach($data as $value) { ?>
  <?php $sum += ($value['price'] * $value['increase'] * $value['increase_02'] * $value['increase_03'] * $value['amount']); ?>
<?php } ?> 
<?php if(!empty($data)) { ?>
<?php print number_format(h($sum)); ?>円
</span>
    <form method='POST' action='result_02.php'>
      <input type="hidden" name="departure" value="<?php echo $value['departure']; ?>">
      <input type="hidden" name="back" value="<?php echo $value['back']; ?>">
      <input type="hidden" name="total" value="<?php echo $total; ?>">
      <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
      <input class="bottom" type="submit" value="購  入" onclick="return confirm('購入しますか？')">
    </form>
<?php } else { ?>
  <?php print '<br>'.'<br>'.'カートに商品はございません'; ?>
  <?php } ?>
    <br><a href="index_02.php">商品一覧へ戻る</a>
    </div>
  </div>
  <footer>
      <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</P>
  </footer>
</body>
</html>