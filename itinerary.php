<?php 

require_once('setting.php');
require_once('city_box.php');

$error = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ID']) === TRUE) {
        $ID = $_POST['ID'];
    }
    try {
        $sql = 'SELECT country_name FROM ec_cart WHERE ID = ?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $ID, PDO::PARAM_INT);
        $stmt->execute();
        $data_02 = $stmt->fetchAll(); 
    }  catch (PDOException $e) { $error[] = '接続できませんでした。理由：'.$e->getMessage(); }
          
    if (isset($_POST['airport']) === TRUE) {
        $airport = $_POST['airport'];
    }
    if (isset($_POST['departure']) === TRUE) {
        $departure = $_POST['departure'];
    }
    if (isset($_POST['back']) === TRUE) {
        $back = $_POST['back'];
    }
    if (isset($_POST['seat_class']) === TRUE) {
        $seat_class = $_POST['seat_class'];
    }
    if(is_empty_date($departure) || is_empty_date($back)) {
        $error[] = $data_02[0]['country_name'].'行きの旅行期間が未設定です';
    }
    if(empty($airport)) {
        $error[] = $data_02[0]['country_name'].'行きの出発地が未設定です';
    }
    if(empty($seat_class)) {
        $error[] = $data_02[0]['country_name'].'行きの座席クラスが未設定です';
    } 
    if(count($error) === 0) {
            try {
                $sql = 'SELECT ec_master.ID,ec_master.country_name, ec_master.img, ec_cart.amount, ec_cart.departure, ec_cart.back, ec_cart.airport
                        FROM ec_master 
                        INNER JOIN ec_cart
                        ON ec_master.ID = ec_cart.ID
                        WHERE ec_master.ID = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                $stmt->execute();
                $rows = $stmt->fetchAll();
            }  
                    catch (PDOException $e) {
                        $error[] = '接続できませんでした。理由：'.$e->getMessage();
                    }
                $country_name = $rows[0]['country_name'];
                $destination = City::findByName($destinations, $country_name);
    }
}
   session_start();

if (!isset($_SESSION["USERID"])) {
  header("Location: logout_02.php");
  exit;
} 

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>旅程</title>
  <link rel="stylesheet" href="itinerary.css">
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
    <div class="center">
       <?php foreach($error as $value) { ?>
       <span class="err"><?php echo h($value).'<br>'; ?></span>
       <?php } ?>
      <div class="image">
          <?php foreach($rows as $row) { ?>
        <img src="<?php echo $img_dir . h($row['img']); ?>"><br>
          <?php } ?>
      </div>
          <?php foreach($rows as $row) { ?>
            <p class="country_name"><span><?php  echo h($country_name); ?></span></p>
            <p>往路：<?php echo h($row['airport']).'&nbsp;発'; ?></p>
            <p><?php echo h(date('Y年n月j日', strtotime($row['departure']))); ?></p>
            <?php echo h($destination->flight_for); ?>
            <p class="divide"><span>------------------------------------------</span></p>
            <p>復路：<?php echo h($destination->local_airport).'&nbsp;発'; ?></p>
            <p><?php echo h(date('Y年n月j日', strtotime($row['back']))); ?></p>
            <?php echo h($destination->flight_from); ?>
          <?php } ?>
        <br><br><br><a href="purchase_02.php">閉じる</a>
    </div>
  </div>
    <footer>
      <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
    </footer>
</body>
</html>