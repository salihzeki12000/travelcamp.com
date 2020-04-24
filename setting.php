<?php 

    $img_dir    = './img/'; 
    $filename = './review.txt';
    
    $data = array();
    $data_02 = array();
    $rows = array();
    
    $now = date('Y-m-d') ; 
    $date = date('Y-m-d H:i:s') ; 
    
    $amount = 1;
    $sum_cart = 0;
    $success = '';
    $cart = '';
    $err = '';
    $new_img_filename = '';
    $result = '';
    $userid = '';
    $error = '';
    $sum = '';
    $order = '';
   
    $userid_regex = '([a-zA-Z0-9]{6,100})';
    $pwd_regex = '([a-zA-Z0-9]{6,100})';
    
    $result_img_1 = '';
    $result_img_2 = '';
    $result_img_3 = '';
    $result_img_4 = '';
    $result_img_5 = '';

    $result_town_1 = '';
    $result_town_2 = '';
    $result_town_3 = '';
    $result_town_4 = '';
    $result_town_5 = '';
    
    $result_activity_1 = '';
    $result_activity_2 = '';
    $result_activity_3 = '';
    $result_activity_4 = '';
    $result_activity_5 = '';
    
    $result_season_1 =  '';
    $result_season_2 =  '';
    $result_season_3 =  '';
    $result_season_4 =  '';
    $result_season_5 =  '';

    $host     = 'localhost';
    $username = 'codecamp32133';
    $password = '0127mato'; 
    $dbname   = 'codecamp32133'; 
    $charset  = 'utf8'; 
    $dsn = 'mysql:dbname='.$dbname.';host='.$host.';charset='.$charset;
    
    $dbh = new PDO($dsn, $username, $password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    define('name_max_length', 20);
    
    function is_valid_name_length($name){
        return mb_strlen($name) <= name_max_length;
    }
    
    function is_empty($string){
        return trim(mb_convert_kana($string, "s", 'UTF-8')) === '';
    }
    
    function is_empty_date($string){
        return $string === '0000-00-00';
    }
   
    function h($s) {
        return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
    }
    
    
    
    define('destination', 30);
    
    function is_valid_destination_length($name) {
        return mb_strlen($name) <= destination;
    }
    
    define('comment', 300);
    
    function is_valid_comment_length($comment) {
        return mb_strlen($comment) <= comment;
    }
    
    
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
   <link rel="icon" href="./logo_etc/plane.ico">
</head>
<body>
</body>
</html>
 