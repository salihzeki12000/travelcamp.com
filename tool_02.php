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
    if (isset($_POST['sql_kind']) === TRUE) {
        $sql_kind = $_POST['sql_kind'];
    }
    if ($sql_kind === 'insert') {
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
        if (isset($_POST['country_code']) === TRUE) {
            $country_code = $_POST['country_code'];
        } 
        if(!($status === '0' || $status === '1')) {
            $error[] = '不正なアクセスです';
        }
        if (is_empty($country_name)) {
            $error[] = '商品名を入力してください';
        } else if (!is_valid_name_length($country_name)) {
            $error[] = '商品名は20文字以内で入力してください';
          }
        if (is_empty($price)) {
            $error[] = '値段を入力してださい';
        } else if (!ctype_digit($price)) {
            $error[] = '数字は整数を記入してください';
          }
        if (is_empty($stock)) {
            $error[] = '個数を入力してださい';
        } else if (!ctype_digit($stock)) {
            $error[] = '数字は整数を記入してください';
          }
        if (is_uploaded_file($_FILES['img']['tmp_name']) === TRUE) {
            $extension = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
            if ($extension === 'png' || $extension === 'jpeg' || $extension === 'jpg') {
                $new_img_filename = sha1(uniqid(mt_rand(), true)). '.' . $extension;
                if (is_file($img_dir . $new_img_filename) !== TRUE) {
                    if (move_uploaded_file($_FILES['img']['tmp_name'], $img_dir . $new_img_filename) !== TRUE) {
                        $error[] = 'ファイルアップロードに失敗しました';
                    }
                } else {
                    $error[] = 'ファイルアップロードに失敗しました。再度お試しください。';
                  }
            } else {
                  $error[] = 'ファイル形式が異なります。画像ファイルはJPEGまたはPNGのみ利用可能です。';
              }
        } else {
              $error[] = 'ファイルを選択してください';
          }
        if (count($error) === 0 ) {
            try {
               $dbh->beginTransaction();
               try {  
                   $sql = 'INSERT INTO ec_master (img, country_name, price, status, country_code, create_datetime, update_datetime)
                           VALUES(?,?,?,?,?,NOW(),NOW())';
                   $stmt = $dbh->prepare($sql);
                   $stmt->bindValue(1, $new_img_filename, PDO::PARAM_STR);
                   $stmt->bindValue(2, $country_name, PDO::PARAM_STR);
                   $stmt->bindValue(3, $price, PDO::PARAM_STR);
                   $stmt->bindValue(4, $status, PDO::PARAM_STR);
                   $stmt->bindValue(5, $country_code, PDO::PARAM_INT);
                   $stmt->execute();
                   $ID = $dbh->lastInsertId('ID');
                  
                   $sql = 'INSERT INTO ec_stock (ID, stock, create_datetime, update_datetime) 
                           VALUES(?,?,NOW(),NOW())';
                   $stmt = $dbh->prepare($sql);
                   $stmt->bindValue(1, $ID, PDO::PARAM_STR);
                   $stmt->bindValue(2, $stock, PDO::PARAM_STR);
                   $stmt->execute();
                   $data = $stmt->fetchAll();
                   $dbh->commit();
                   $error[] = 'データを登録しました';
               }  catch (PDOException $e) {
                   $dbh->rollback();
                      throw $e;
                  }
            } catch (PDOException $e) {
                  $error[] = '接続できませんでした。理由：'.$e->getMessage();
              }
        }
    }
    if ($sql_kind === 'stock') {
        if (isset($_POST['stock']) === TRUE) {
            $stock = $_POST['stock'];
        }
        if (isset($_POST['ID']) === TRUE) {
            $ID = $_POST['ID'];
        }
        try{
           $sql = 'SELECT ec_master.ID, country_name, stock
                   FROM ec_master
                   INNER JOIN ec_stock
                   ON ec_master.ID = ec_stock.ID
                   WHERE ec_master.ID = ?';
           $stmt = $dbh->prepare($sql);
           $stmt->bindValue(1, $ID, PDO::PARAM_INT);
           $stmt->execute();
           $data_02 = $stmt->fetchAll();
        } catch (PDOException $e) { $error[] = '接続できませんでした。理由：'.$e->getMessage(); }
        
        if (is_empty($stock) || intval($stock) === $data_02[0]['stock']) {
            $error[] = $data_02[0]['country_name'].'の在庫数を入力してください';
        } else if (!ctype_digit($stock)) {
              $error[] = $data_02[0]['country_name'].'の在庫数は整数を入力してください';
          }
        if (empty($ID)) {
            $error[] = '商品を選択してください';
        } 
        if (count($error) === 0 ) {
            try {
                $sql = 'UPDATE ec_stock 
                        SET stock = ?, update_datetime = NOW()
                        WHERE ID = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $stock, PDO::PARAM_INT);
                $stmt->bindValue(2, $ID, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetchAll();
                $error[] = $data_02[0]['country_name'].'の在庫数を変更しました';
            } catch (PDOException $e) {
                  $error[] = '接続できませんでした。理由：'.$e->getMessage();
              }
        }
    }
    if ($sql_kind === 'change_country_name') {
        if (isset($_POST['change_country_name']) === TRUE) {
            $change_country_name = $_POST['change_country_name'];
        }
        if (isset($_POST['ID']) === TRUE) {
            $ID = $_POST['ID'];
        }
        try {
            $sql = 'SELECT ID, country_name
                    FROM ec_master
                    WHERE ID = ?';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $ID, PDO::PARAM_INT);
            $stmt->execute();
            $data_02 = $stmt->fetchAll();
        }   catch (PDOException $e) {  $error[] = '接続できませんでした。理由：'.$e->getMessage(); }

        if (is_empty($change_country_name) || $change_country_name === $data_02[0]['country_name']) {
            $error[] = 'ID'.$ID.'の変更名を入力してください';
        } else if (!is_valid_name_length($change_country_name)) {
                $error[] = 'ID'.$ID.'の変更名は20文字以内で入力してください';
          }
        if (count($error) === 0 ) {
            try {
                $sql = 'UPDATE ec_master 
                        SET country_name = ?, update_datetime = NOW()
                        WHERE ID = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $change_country_name, PDO::PARAM_STR);
                $stmt->bindValue(2, $ID, PDO::PARAM_INT);
                $stmt->execute();
                $error[] = 'ID'.$ID.'の商品名を変更しました';
            } catch (PDOException $e) {
                  $error[] = '接続できませんでした。理由：'.$e->getMessage();
              }
        }
    }
    if ($sql_kind === 'change_price') {
        if (isset($_POST['change_price']) === TRUE) {
            $change_price = $_POST['change_price'];
        }
        if (isset($_POST['ID']) === TRUE) {
            $ID = $_POST['ID'];
        }
        try {
            $sql = 'SELECT ID, country_name, price
                    FROM ec_master
                    WHERE ID = ?';
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(1, $ID, PDO::PARAM_INT);
            $stmt->execute();
            $data_02 = $stmt->fetchAll();
        }   catch (PDOException $e) {  $error[] = '接続できませんでした。理由：'.$e->getMessage(); }
            
        if (is_empty($change_price) || intval($change_price) === $data_02[0]['price']) {
            $error[] = $data_02[0]['country_name'].'の変更価格を入力してください';
        } else if (!ctype_digit($change_price)) {
            $error[] = $data_02[0]['country_name'].'の変更価格は整数を入力してください';
          }
        if (empty($ID)) {
            $error[] = '商品を選択してください';
        } 
        if (count($error) === 0 ) {
            try {
                $sql = 'UPDATE ec_master 
                        SET price = ?, update_datetime = NOW()
                        WHERE ID = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $change_price, PDO::PARAM_INT);
                $stmt->bindValue(2, $ID, PDO::PARAM_INT);
                $stmt->execute();
                $error[] = $data_02[0]['country_name'].'の価格を変更しました';
            } catch (PDOException $e) {
                  $error[] = '接続できませんでした。理由：'.$e->getMessage();
              }
        }
    }
    if ($sql_kind === 'status') {
        if (isset($_POST['ID']) === TRUE) {
            $ID = $_POST['ID'];
        }
        if (isset($_POST['status']) === TRUE) {
            $status = $_POST['status'];
        }
        if(!ctype_digit($ID)) {
            $error[] = '不正なアクセスです';
        }
        if(!($status === '0' || $status === '1')) { 
            $error[] = '不正なアクセスです';
        }  
        if(count($error) === 0) {
            try { 
                $sql = 'SELECT ID, country_name
                        FROM ec_master
                        WHERE ID = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                $stmt->execute();
                $data_02 = $stmt->fetchAll();
                  
                $sql = 'UPDATE ec_master 
                        SET status = ?, update_datetime = NOW()
                        WHERE ID = ?';
                $stmt = $dbh->prepare($sql);
                      if($status === '0') {
                          $status = 1;
                      } else if($status === '1') {
                          $status = 0;
                        } 
                $stmt->bindValue(1, $status, PDO::PARAM_INT);
                $stmt->bindValue(2, $ID, PDO::PARAM_INT);
                $stmt->execute();
                $error[] = $data_02[0]['country_name'].'の公開ステータスを変更しました';
            } catch (PDOException $e) {
                $error[] = '接続できませんでした。理由：'.$e->getMessage();
              }
        }
    }
    if($sql_kind === 'delete') {
        if (isset($_POST['ID']) === TRUE) {
            $ID = $_POST['ID'];
        }
            try {
                $sql = 'SELECT ID, country_name
                        FROM ec_master
                        WHERE ID = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                $stmt->execute();
                $data_02 = $stmt->fetchAll();
                
                $sql = 'DELETE ec_master, ec_stock
                        FROM ec_master
                        INNER JOIN ec_stock 
                        ON ec_master.ID = ec_stock.ID
                        WHERE ec_master.ID = ?';
                $stmt = $dbh->prepare($sql);
                $stmt->bindValue(1, $ID, PDO::PARAM_INT);
                $stmt->execute();
                
                $error[] = $data_02[0]['country_name'].'を削除しました';
                
            } 
                catch (PDOException $e) {
                    $error[] = '接続できませんでした。理由：'.$e->getMessage();
                }
    } 
}
    try {
        $sql = 'SELECT ec_master.ID, country_name, price, img, stock, status, country_code
                FROM ec_master 
                INNER JOIN ec_stock 
                ON ec_master.ID = ec_stock.ID';
        $stmt = $dbh->prepare($sql);
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
  <title>航空券管理ツール</title>
  <link rel="stylesheet" href="tool_02.css">
</head>
<body>
  <h1>航空券管理ツール</h1>
    <a href="logout_02.php">ログアウト</a>
  <h2>新規商品追加</h2>
    <a href="user_02.php">ユーザー管理ページ</a>
    <ul>
      <?php foreach ($error as $value) { ?>
        <li><?php print h($value); ?></li>
      <?php } ?>
    </ul>
  <form method="post" enctype="multipart/form-data">
    <br><label for="name">名前：</label><input type="text" name="country_name" id="name" size="20"><br>
    <label for="price">値段：</label><input type="text" name="price" id="price" size="20"><br>
    <label for="stock">個数：</label><input type="text" name="stock" id="stock" size="20"><br>
    <input type="file" name="img" value="ファイルを選択"><br>
      <select name="status">
        <option value="0">非公開</option>
        <option value="1">公開</option>
      </select>
      <select name="country_code">
        <option value="1">アメリカ・ヨーロッパ方面</option>
        <option value="2">東南アジア・オセアニア方面</option>
      </select>
      <input type="hidden" name="sql_kind" value="insert">
      <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
      <br><input type="submit" name="submit" value="商品を追加">
  </form>
  <table>
    <h2 class="prd_chg">商品情報変更</h2>
    <p class="prd_index">商品一覧</p>
    <tr>
      <th>ID</th>
      <th>商品画像</th>
      <th>商品名</th>
    　<th>価格</th>
    　<th>在庫</th>
    　<th>公開ステータス</th>
    　<th>削除</th>
    　<th>国コード</th>
    </tr>
<?php foreach ($data as $value)  { ?>
    <tr <?php if(($value['status'] === 0) || ($value['stock'] === 0)) { ?> class="grey" <?php } ?>>
      <td><?php echo h($value['ID']); ?></td>
      <td><img src="<?php print $img_dir . h($value['img']) ; ?>"></td>
      <td>
        <form method="post">
          <input type="text" name="change_country_name" size="16" value="<?php print h($value['country_name']); ?>">
          <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
          <input type="hidden" name="sql_kind" value="change_country_name">
          <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          <input type="submit" name="submit" value="変更">
        </form>
      </td>
      <td>
        <form method="post">
          <input type="text" name="change_price" size="10" value="<?php print h($value['price']); ?>">
          <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
          <input type="hidden" name="sql_kind" value="change_price">
          <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          <input type="submit" name="submit" value="変更">
        </form>
      </td>
      <td>
        <form method="post">
          <input type="text" name="stock" size="6" value="<?php print h($value['stock']); ?>">
          <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
          <input type="hidden" name="sql_kind" value="stock">
          <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          <input type="submit" name="submit" value="変更">
        </form>
      </td>
      <td>
        <form method="post">
          <input type="hidden" name="sql_kind" value="status">
          <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
          <input type="hidden" name="status" value="<?php print $value['status']; ?>">
          <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          <?php if($value['status'] === 0 ) { ?>
          <input type="submit" value="非公開から→公開へ変更"; ?>
          <?php } ?> 
          <?php if($value['status'] === 1 ) { ?> 
          <input type="submit" value="公開から→非公開へ変更"; ?>
          <?php } ?> 
        </form>
      </td>
      <td>
        <form method="post">
          <input type="hidden" name="ID" value="<?php print $value['ID']; ?>">
          <input type="hidden" name="sql_kind" value="delete">
          <input type="hidden" name="csrf_token" value="<?php print $csrf_token; ?>">
          <input type="submit" name="submit" value="削除">
        </form>
      </td>
      <td><?php print h($value['country_code']); ?></td>
    <tr>
<?php } ?>
  </table>
</body>
</html>