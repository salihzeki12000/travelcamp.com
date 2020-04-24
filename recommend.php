<?php
require_once('city_box.php');
require_once('setting.php');

    $sum = 0;
    
    session_start();
 
if (!isset($_SESSION["USERID"])) {
  header("Location: logout_02.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $area = $_POST['area'];
    $budget = $_POST['budget'];
    $days = $_POST['days'];
    $time = $_POST['time'];
    
    //ここからアジア
        if($area === 'asia' && $budget === 'low' && $days === 'short' && $time === 'shopping' ) {
            $result_img_1 = $seoul->image; $result_town_1 = $seoul->town; $result_activity_1 = $seoul->activity; $result_season_1 = $seoul->season;
            $result_img_2 = $taipei->image; $result_town_2 = $taipei->town; $result_activity_2 = $taipei->activity; $result_season_2 = $taipei->season;
            $result_img_3 = $manila->image; $result_town_3 = $manila->town; $result_activity_3 = $manila->activity; $result_season_3 = $manila->season;
            $result_img_4 = $guam->image; $result_town_4 = $guam->town; $result_activity_4 = $guam->activity; $result_season_4 = $guam->season;
            $result_img_5 = $hongkong->image; $result_town_5 = $hongkong->town; $result_activity_5 = $hongkong->activity; $result_season_5 = $hongkong->season;
        }
        if($area === 'asia' && $budget === 'low' && $days === 'short' && $time === 'relax' ) {
            $result_img_1 = $sebu->image; $result_town_1 = $sebu->town; $result_activity_1 = $sebu->activity; $result_season_1 = $sebu->season;
            $result_img_2 = $guam->image; $result_town_2 = $guam->town; $result_activity_2 = $guam->activity; $result_season_2 = $guam->season;
            $result_img_3 = $saipan->image; $result_town_3 = $saipan->town; $result_activity_3 = $saipan->activity; $result_season_3 = $saipan->season;
        }
        if($area === 'asia' && $budget === 'low' && $days === 'short' && $time === 'adventure' ) {
            $result_img_1 = $bkk->image; $result_town_1 = $bkk->town; $result_activity_1 = $bkk->activity; $result_season_1 = $bkk->season;
            $result_img_2 = $sgn->image; $result_town_2 = $sgn->town; $result_activity_2 = $sgn->activity; $result_season_2 = $sgn->season;
            $result_img_3 = $hanoi->image; $result_town_3 = $hanoi->town; $result_activity_3 = $hanoi->activity; $result_season_3 = $hanoi->season;
        }
        if($area === 'asia' && $budget === 'low' && $days === 'normal' && $time === 'shopping' ) {
            $result_img_1 = $seoul->image; $result_town_1 = $seoul->town; $result_activity_1 = $seoul->activity; $result_season_1 = $seoul->season;
            $result_img_2 = $taipei->image; $result_town_2 = $taipei->town; $result_activity_2 = $taipei->activity; $result_season_2 = $taipei->season;
            $result_img_3 = $manila->image; $result_town_3 = $manila->town; $result_activity_3 = $manila->activity; $result_season_3 = $manila->season;
            $result_img_4 = $guam->image; $result_town_4 = $guam->town; $result_activity_4 = $guam->activity; $result_season_4 = $guam->season;
            $result_img_5 = $hongkong->image; $result_town_5 = $hongkong->town; $result_activity_5 = $hongkong->activity; $result_season_5 = $hongkong->season;
        }
        if($area === 'asia' && $budget === 'low' && $days === 'normal' && $time === 'relax' ) {
            $result_img_1 = $sebu->image; $result_town_1 = $sebu->town; $result_activity_1 = $sebu->activity; $result_season_1 = $sebu->season;
            $result_img_2 = $guam->image; $result_town_2 = $guam->town; $result_activity_2 = $guam->activity; $result_season_2 = $guam->season;
            $result_img_3 = $saipan->image; $result_town_3 = $saipan->town; $result_activity_3 = $saipan->activity; $result_season_3 = $saipan->season;
            $result_img_4 = $pataya->image; $result_town_4 = $pataya->town; $result_activity_4 = $pataya->activity; $result_season_4 = $pataya->season;
        }
        if($area === 'asia' && $budget === 'low' && $days === 'normal' && $time === 'adventure' ) {
            $result_img_1 = $bkk->image; $result_town_1 = $bkk->town; $result_activity_1 = $bkk->activity; $result_season_1 = $bkk->season;
            $result_img_2 = $sgn->image; $result_town_2 = $sgn->town; $result_activity_2 = $sgn->activity; $result_season_2 = $sgn->season;
            $result_img_3 = $hanoi->image; $result_town_3 = $hanoi->town; $result_activity_3 = $hanoi->activity; $result_season_3 = $hanoi->season;
        }
        if($area === 'asia' && $budget === 'low' && $days === 'long' && $time === 'shopping' ) {
            $result_img_1 = $seoul->image; $result_town_1 = $seoul->town; $result_activity_1 = $seoul->activity; $result_season_1 = $seoul->season;
            $result_img_2 = $taipei->image; $result_town_2 = $taipei->town; $result_activity_2 = $taipei->activity; $result_season_2 = $taipei->season;
            $result_img_3 = $manila->image; $result_town_3 = $manila->town; $result_activity_3 = $manila->activity; $result_season_3 = $manila->season;
            $result_img_4 = $guam->image; $result_town_4 = $guam->town; $result_activity_4 = $guam->activity; $result_season_4 = $guam->season;
        }
        if($area === 'asia' && $budget === 'low' && $days === 'long' && $time === 'relax' ) {
            $result_img_1 = $sebu->image; $result_town_1 = $sebu->town; $result_activity_1 = $sebu->activity; $result_season_1 = $sebu->season;
            $result_img_2 = $guam->image; $result_town_2 = $guam->town; $result_activity_2 = $guam->activity; $result_season_2 = $guam->season;
            $result_img_3 = $saipan->image; $result_town_3 = $saipan->town; $result_activity_3 = $saipan->activity; $result_season_3 = $saipan->season;
            $result_img_4 = $pataya->image; $result_town_4 = $pataya->town; $result_activity_4 = $pataya->activity; $result_season_4 = $pataya->season;
        }
        if($area === 'asia' && $budget === 'low' && $days === 'long' && $time === 'adventure' ) {
            $result_img_1 = $bkk->image; $result_town_1 = $bkk->town; $result_activity_1 = $bkk->activity; $result_season_1 = $bkk->season;
            $result_img_2 = $sgn->image; $result_town_2 = $sgn->town; $result_activity_2 = $sgn->activity; $result_season_2 = $sgn->season;
            $result_img_3 = $hanoi->image; $result_town_3 = $hanoi->town; $result_activity_3 = $hanoi->activity; $result_season_3 = $hanoi->season;
            $result_img_4 = $changmai->image; $result_town_4 = $changmai->town; $result_activity_4 = $changmai->activity; $result_season_4 = $changmai->season;
        }
        if($area === 'asia' && $budget === 'middle' && $days === 'short' && $time === 'shopping' ) {
            $result_img_1 = $seoul->image; $result_town_1 = $seoul->town; $result_activity_1 = $seoul->activity; $result_season_1 = $seoul->season;
            $result_img_2 = $taipei->image; $result_town_2 = $taipei->town; $result_activity_2 = $taipei->activity; $result_season_2 = $taipei->season;
            $result_img_3 = $manila->image; $result_town_3 = $manila->town; $result_activity_3 = $manila->activity; $result_season_3 = $manila->season;
            $result_img_4 = $kul->image; $result_town_4 = $kul->town; $result_activity_4 = $kul->activity; $result_season_4 = $kul->season;
            $result_img_5 = $singapor->image; $result_town_5 = $singapor->town; $result_activity_5 = $singapor->activity; $result_season_5 = $singapor->season;
        }
        if($area === 'asia' && $budget === 'middle' && $days === 'short' && $time === 'relax' ) {
            $result_img_1 = $sebu->image; $result_town_1 = $sebu->town; $result_activity_1 = $sebu->activity; $result_season_1 = $sebu->season;
            $result_img_2 = $cairns->image; $result_town_2 = $cairns->town; $result_activity_2 = $cairns->activity; $result_season_2 = $cairns->season;
            $result_img_3 = $guam->image; $result_town_3 = $guam->town; $result_activity_3 = $guam->activity; $result_season_3 = $guam->season;
            $result_img_4 = $saipan->image; $result_town_4 = $saipan->town; $result_activity_4 = $saipan->activity; $result_season_4 = $saipan->season;
        }
        if($area === 'asia' && $budget === 'middle' && $days === 'short' && $time === 'adventure' ) {
            $result_img_1 = $bkk->image; $result_town_1 = $bkk->town; $result_activity_1 = $bkk->activity; $result_season_1 = $bkk->season;
            $result_img_2 = $sgn->image; $result_town_2 = $sgn->town; $result_activity_2 = $sgn->activity; $result_season_2 = $sgn->season;
            $result_img_3 = $hanoi->image; $result_town_3 = $hanoi->town; $result_activity_3 = $hanoi->activity; $result_season_3 = $hanoi->season;
            $result_img_4 = $yangon->image; $result_town_4 = $yangon->town; $result_activity_4 = $yangon->activity; $result_season_4 = $yangon->season;
        }
        if($area === 'asia' && $budget === 'middle' && $days === 'normal' && $time === 'shopping' ) {
            $result_img_1 = $seoul->image; $result_town_1 = $seoul->town; $result_activity_1 = $seoul->activity; $result_season_1 = $seoul->season;
            $result_img_2 = $taipei->image; $result_town_2 = $taipei->town; $result_activity_2 = $taipei->activity; $result_season_2 = $taipei->season;
            $result_img_3 = $manila->image; $result_town_3 = $manila->town; $result_activity_3 = $manila->activity; $result_season_3 = $manila->season;
            $result_img_4 = $kul->image; $result_town_4 = $kul->town; $result_activity_4 = $kul->activity; $result_season_4 = $kul->season;
            $result_img_5 = $singapor->image; $result_town_5 = $singapor->town; $result_activity_5 = $singapor->activity; $result_season_5 = $singapor->season;
        }
        if($area === 'asia' && $budget === 'middle' && $days === 'normal' && $time === 'relax' ) {
            $result_img_1 = $sebu->image; $result_town_1 = $sebu->town; $result_activity_1 = $sebu->activity; $result_season_1 = $sebu->season;
            $result_img_2 = $borakai->image; $result_town_2 = $borakai->town; $result_activity_2 = $cairns->activity; $result_season_2 = $cairns->season;
            $result_img_3 = $guam->image; $result_town_3 = $guam->town; $result_activity_3 = $guam->activity; $result_season_3 = $guam->season;
            $result_img_4 = $saipan->image; $result_town_4 = $bohol->town; $result_activity_4 = $saipan->activity; $result_season_4 = $saipan->season;
            $result_img_5 = $bali->image; $result_town_5 = $bali->town; $result_activity_5 = $bali->activity; $result_season_5 = $bali->season;
        }
        if($area === 'asia' && $budget === 'middle' && $days === 'normal' && $time === 'adventure' ) {
            $result_img_1 = $bkk->image; $result_town_1 = $bkk->town; $result_activity_1 = $bkk->activity; $result_season_1 = $bkk->season;
            $result_img_2 = $sgn->image; $result_town_2 = $sgn->town; $result_activity_2 = $sgn->activity; $result_season_2 = $sgn->season;
            $result_img_3 = $hanoi->image; $result_town_3 = $hanoi->town; $result_activity_3 = $hanoi->activity; $result_season_3 = $hanoi->season;
            $result_img_4 = $yangon->image; $result_town_4 = $yangon->town; $result_activity_4 = $yangon->activity; $result_season_4 = $yangon->season;
        }
        if($area === 'asia' && $budget === 'middle' && $days === 'long' && $time === 'shopping' ) {
            $result_img_1 = $bkk->image; $result_town_1 = $bkk->town; $result_activity_1 = $bkk->activity; $result_season_1 = $bkk->season;
            $result_img_2 = $kul->image; $result_town_2 = $kul->town; $result_activity_2 = $kul->activity; $result_season_2 = $kul->season;
            $result_img_3 = $sydney->image; $result_town_3 = $sydney->town; $result_activity_3 = $sydney->activity; $result_season_3 = $sydney->season;
        }
        if($area === 'asia' && $budget === 'middle' && $days === 'long' && $time === 'relax' ) {
            $result_img_1 = $hukok->image; $result_town_1 = $hukok->town; $result_activity_1 = $hukok->activity; $result_season_1 = $hukok->season;
            $result_img_2 = $borakai->image; $result_town_2 = $borakai->town; $result_activity_2 = $cairns->activity; $result_season_2 = $cairns->season;
            $result_img_3 = $samui->image; $result_town_3 = $samui->town; $result_activity_3 = $samui->activity; $result_season_3 = $samui->season;
            $result_img_4 = $bohol->image; $result_town_4 = $bohol->town; $result_activity_4 = $saipan->activity; $result_season_4 = $saipan->season;
            $result_img_5 = $bali->image; $result_town_5 = $bali->town; $result_activity_5 = $bali->activity; $result_season_5 = $bali->season;
        }
        if($area === 'asia' && $budget === 'middle' && $days === 'long' && $time === 'adventure' ) {
            $result_img_1 = $bkk->image; $result_town_1 = $bkk->town; $result_activity_1 = $bkk->activity; $result_season_1 = $bkk->season;
            $result_img_2 = $sgn->image; $result_town_2 = $sgn->town; $result_activity_2 = $sgn->activity; $result_season_2 = $sgn->season;
            $result_img_3 = $hanoi->image; $result_town_3 = $hanoi->town; $result_activity_3 = $hanoi->activity; $result_season_3 = $hanoi->season;
            $result_img_4 = $yangon->image; $result_town_4 = $yangon->town; $result_activity_4 = $yangon->activity; $result_season_4 = $yangon->season;
            $result_img_5 = $changmai->image; $result_town_5 = $changmai->town; $result_activity_5 = $changmai->activity; $result_season_5 = $changmai->season;
        }
        if($area === 'asia' && $budget === 'high' && $days === 'short' && $time === 'shopping' ) {
            $result_img_1 = $singapor->image; $result_town_1 = $singapor->town; $result_activity_1 = $singapor->activity; $result_season_1 = $singapor->season;
            $result_img_2 = $kul->image; $result_town_2 = $kul->town; $result_activity_2 = $kul->activity; $result_season_2 = $kul->season;
            $result_img_3 = $manila->image; $result_town_3 = $manila->town; $result_activity_3 = $manil->activity; $result_season_3 = $manila->season;
            $result_img_4 = $seoul->image; $result_town_4 = $seoul->town; $result_activity_4 = $seoul->activity; $result_season_4 = $seoul->season;
            $result_img_5 = $taipei->image; $result_town_5 = $taipei->town; $result_activity_5 = $taipei->activity; $result_season_5 = $taipei->season;
        }
        if($area === 'asia' && $budget === 'high' && $days === 'short' && $time === 'relax' ) {
            $result_img_1 = $sebu->image; $result_town_1 = $sebu->town; $result_activity_1 = $sebu->activity; $result_season_1 = $sebu->season;
            $result_img_2 = $cairns->image; $result_town_2 = $cairns->town; $result_activity_2 = $cairns->activity; $result_season_2 = $cairns->season;
        }
        if($area === 'asia' && $budget === 'high' && $days === 'short' && $time === 'adventure' ) {
            $result_img_1 = $bkk->image; $result_town_1 = $bkk->town; $result_activity_1 = $bkk->activity; $result_season_1 = $bkk->season;
            $result_img_2 = $sgn->image; $result_town_2 = $sgn->town; $result_activity_2 = $sgn->activity; $result_season_2 = $sgn->season;
            $result_img_3 = $hanoi->image; $result_town_3 = $hanoi->town; $result_activity_3 = $hanoi->activity; $result_season_3 = $hanoi->season;
            $result_img_4 = $yangon->image; $result_town_4 = $yangon->town; $result_activity_4 = $yangon->activity; $result_season_4 = $yangon->season;
        }
        if($area === 'asia' && $budget === 'high' && $days === 'normal' && $time === 'shopping' ) {
            $result_img_1 = $singapor->image; $result_town_1 = $singapor->town; $result_activity_1 = $singapor->activity; $result_season_1 = $singapor->season;
            $result_img_2 = $kul->image; $result_town_2 = $kul->town; $result_activity_2 = $kul->activity; $result_season_2 = $kul->season;
            $result_img_3 = $manila->image; $result_town_3 = $manila->town; $result_activity_3 = $manila->activity; $result_season_3 = $manila->season;
            $result_img_4 = $seoul->image; $result_town_4 = $seoul->town; $result_activity_4 = $seoul->activity; $result_season_4 = $seoul->season;
            $result_img_5 = $taipei->image; $result_town_5 = $taipei->town; $result_activity_5 = $taipei->activity; $result_season_5 = $taipei->season;
        }
        if($area === 'asia' && $budget === 'high' && $days === 'normal' && $time === 'relax' ) {
            $result_img_1 = $sebu->image; $result_town_1 = $sebu->town; $result_activity_1 = $sebu->activity; $result_season_1 = $sebu->season;
            $result_img_2 = $cairns->image; $result_town_2 = $cairns->town; $result_activity_2 = $cairns->activity; $result_season_2 = $cairns->season;
            $result_img_3 = $bohol->image; $result_town_3 = $bohol->town; $result_activity_3 = $bohol->activity; $result_season_3 = $bohol->season;
            $result_img_4 = $bali->image; $result_town_4 = $bali->town; $result_activity_4 = $bali->activity; $result_season_4 = $bali->season;
        }
        if($area === 'asia' && $budget === 'high' && $days === 'normal' && $time === 'adventure' ) {
            $result_img_1 = $bkk->image; $result_town_1 = $bkk->town; $result_activity_1 = $bkk->activity; $result_season_1 = $bkk->season;
            $result_img_2 = $sgn->image; $result_town_2 = $sgn->town; $result_activity_2 = $sgn->activity; $result_season_2 = $sgn->season;
            $result_img_3 = $hanoi->image; $result_town_3 = $hanoi->town; $result_activity_3 = $hanoi->activity; $result_season_3 = $hanoi->season;
            $result_img_4 = $yangon->image; $result_town_4 = $yangon->town; $result_activity_4 = $yangon->activity; $result_season_4 = $yangon->season;
        }
        if($area === 'asia' && $budget === 'high' && $days === 'long' && $time === 'shopping' ) {
            $result_img_1 = $singapor->image; $result_town_1 = $singapor->town; $result_activity_1 = $singapor->activity; $result_season_1 = $singapor->season;
            $result_img_2 = $kul->image; $result_town_2 = $kul->town; $result_activity_2 = $kul->activity; $result_season_2 = $kul->season;
            $result_img_3 = $manila->image; $result_town_3 = $manila->town; $result_activity_3 = $manil->activity; $result_season_3 = $manila->season;
            $result_img_4 = $sydney->image; $result_town_4 = $sydney->town; $result_activity_4 = $sydney->activity; $result_season_4 = $sydney->season;
            $result_img_5 = $taipei->image; $result_town_5 = $taipei->town; $result_activity_5 = $taipei->activity; $result_season_5 = $taipei->season;
        }
        if($area === 'asia' && $budget === 'high' && $days === 'long' && $time === 'relax' ) {
            $result_img_1 = $sebu->image; $result_town_1 = $sebu->town; $result_activity_1 = $sebu->activity; $result_season_1 = $sebu->season;
            $result_img_2 = $cairns->image; $result_town_2 = $cairns->town; $result_activity_2 = $cairns->activity; $result_season_2 = $cairns->season;
            $result_img_3 = $bohol->image; $result_town_3 = $bohol->town; $result_activity_3 = $bohol->activity; $result_season_3 = $bohol->season;
            $result_img_4 = $bali->image; $result_town_4 = $bali->town; $result_activity_4 = $bali->activity; $result_season_4 = $bali->season;
        }
        if($area === 'asia' && $budget === 'high' && $days === 'long' && $time === 'adventure' ) {
            $result_img_1 = $central_asia->image; $result_town_1 = $central_asia->town; $result_activity_1 = $central_asia->activity; $result_season_1 = $central_asia->season;
        }
        
        
        //ここからヨーロッパ・中近東
        
        if($area === 'europe' && $budget === 'low' && $days === 'short' && $time === 'shopping' ) {
            $result_img_1 = $vladiostock->image; $result_town_1 = $vladiostock->town; $result_activity_1 = $vladiostock->activity; $result_season_1 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'low' && $days === 'short' && $time === 'relax' ) {
            $result_img_1 = $vladiostock->image; $result_town_1 = $vladiostock->town; $result_activity_1 = $vladiostock->activity; $result_season_1 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'low' && $days === 'short' && $time === 'adventure' ) {
            $result_img_1 = $vladiostock->image; $result_town_1 = $vladiostock->town; $result_activity_1 = $vladiostock->activity; $result_season_1 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'low' && $days === 'normal' && $time === 'shopping' ) {
            $result_img_1 = $vladiostock->image; $result_town_1 = $vladiostock->town; $result_activity_1 = $vladiostock->activity; $result_season_1 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'low' && $days === 'normal' && $time === 'relax' ) {
            $result_img_1 = $vladiostock->image; $result_town_1 = $vladiostock->town; $result_activity_1 = $vladiostock->activity; $result_season_1 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'low' && $days === 'normal' && $time === 'adventure' ) {
            $result_img_1 = $vladiostock->image; $result_town_1 = $vladiostock->town; $result_activity_1 = $vladiostock->activity; $result_season_1 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'low' && $days === 'long' && $time === 'shopping' ) {
            $result_img_1 = $vladiostock->image; $result_town_1 = $vladiostock->town; $result_activity_1 = $vladiostock->activity; $result_season_1 = $vladiostock->season;
        }
         if($area === 'europe' && $budget === 'low' && $days === 'long' && $time === 'relax' ) {
            $result_img_1 = $vladiostock->image; $result_town_1 = $vladiostock->town; $result_activity_1 = $vladiostock->activity; $result_season_1 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'low' && $days === 'long' && $time === 'adventure' ) {
            $result_img_1 = $vladiostock->image; $result_town_1 = $vladiostock->town; $result_activity_1 = $vladiostock->activity; $result_season_1 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'middle' && $days === 'short' && $time === 'shopping' ) {
            $result_img_1 = $paris->image; $result_town_1 = $paris->town; $result_activity_1 = $paris->activity; $result_season_1 = $paris->season;
            $result_img_2 = $rome->image; $result_town_2 = $rome->town; $result_activity_2 = $rome->activity; $result_season_2 = $rome->season;
            $result_img_3 = $frank->image; $result_town_3 = $frank->town; $result_activity_3 = $frank->activity; $result_season_3 = $frank->season;
            $result_img_4 = $dubai->image; $result_town_4 = $dubai->town; $result_activity_4 = $dubai->activity; $result_season_4 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'middle' && $days === 'short' && $time === 'relax' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'middle' && $days === 'short' && $time === 'adventure' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
            $result_img_2 = $vladiostock->image; $result_town_2 = $vladiostock->town; $result_activity_2 = $vladiostock->activity; $result_season_2 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'middle' && $days === 'normal' && $time === 'shopping' ) {
            $result_img_1 = $paris->image; $result_town_1 = $paris->town; $result_activity_1 = $paris->activity; $result_season_1 = $paris->season;
            $result_img_2 = $rome->image; $result_town_2 = $rome->town; $result_activity_2 = $rome->activity; $result_season_2 = $rome->season;
            $result_img_3 = $frank->image; $result_town_3 = $frank->town; $result_activity_3 = $frank->activity; $result_season_3 = $frank->season;
            $result_img_4 = $dubai->image; $result_town_4 = $dubai->town; $result_activity_4 = $dubai->activity; $result_season_4 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'middle' && $days === 'normal' && $time === 'relax' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'middle' && $days === 'normal' && $time === 'adventure' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
            $result_img_2 = $vladiostock->image; $result_town_2 = $vladiostock->town; $result_activity_2 = $vladiostock->activity; $result_season_2 = $vladiostock->season;
        }
        if($area === 'europe' && $budget === 'middle' && $days === 'long' && $time === 'shopping' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'middle' && $days === 'long' && $time === 'relax' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'middle' && $days === 'long' && $time === 'adventure' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'high' && $days === 'short' && $time === 'shopping' ) {
            $result_img_1 = $paris->image; $result_town_1 = $paris->town; $result_activity_1 = $paris->activity; $result_season_1 = $paris->season;
            $result_img_2 = $rome->image; $result_town_2 = $rome->town; $result_activity_2 = $rome->activity; $result_season_2 = $rome->season;
            $result_img_3 = $frank->image; $result_town_3 = $frank->town; $result_activity_3 = $frank->activity; $result_season_3 = $frank->season;
            $result_img_4 = $dubai->image; $result_town_4 = $dubai->town; $result_activity_4 = $dubai->activity; $result_season_4 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'high' && $days === 'short' && $time === 'relax' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'high' && $days === 'short' && $time === 'adventure' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
            $result_img_2 = $vladiostock->image; $result_town_2 = $vladiostock->town; $result_activity_2 = $vladiostock->activity; $result_season_2 = $vladiostock->season;
            $result_img_3 = $zuric->image; $result_town_3 = $zuric->town; $result_activity_3 = $zuric->activity; $result_season_3 = $zuric->season;
        }
        if($area === 'europe' && $budget === 'high' && $days === 'normal' && $time === 'shopping' ) {
            $result_img_1 = $paris->image; $result_town_1 = $paris->town; $result_activity_1 = $paris->activity; $result_season_1 = $paris->season;
            $result_img_2 = $rome->image; $result_town_2 = $rome->town; $result_activity_2 = $rome->activity; $result_season_2 = $rome->season;
            $result_img_3 = $frank->image; $result_town_3 = $frank->town; $result_activity_3 = $frank->activity; $result_season_3 = $frank->season;
            $result_img_4 = $dubai->image; $result_town_4 = $dubai->town; $result_activity_4 = $dubai->activity; $result_season_4 = $dubai->season;
            $result_img_5 = $madrid->image; $result_town_5 = $madrid->town; $result_activity_5 = $madrid->activity; $result_season_5 = $madrid->season;
        }
        if($area === 'europe' && $budget === 'high' && $days === 'normal' && $time === 'relax' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
        }
        if($area === 'europe' && $budget === 'high' && $days === 'normal' && $time === 'adventure' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
            $result_img_2 = $vladiostock->image; $result_town_2 = $vladiostock->town; $result_activity_2 = $vladiostock->activity; $result_season_2 = $vladiostock->season;
            $result_img_3 = $zuric->image; $result_town_3 = $zuric->town; $result_activity_3 = $zuric->activity; $result_season_3 = $zuric->season;
        }
        if($area === 'europe' && $budget === 'high' && $days === 'long' && $time === 'shopping' ) {
            $result_img_1 = $paris->image; $result_town_1 = $paris->town; $result_activity_1 = $paris->activity; $result_season_1 = $paris->season;
            $result_img_2 = $rome->image; $result_town_2 = $rome->town; $result_activity_2 = $rome->activity; $result_season_2 = $rome->season;
            $result_img_3 = $frank->image; $result_town_3 = $frank->town; $result_activity_3 = $frank->activity; $result_season_3 = $frank->season;
            $result_img_4 = $dubai->image; $result_town_4 = $dubai->town; $result_activity_4 = $dubai->activity; $result_season_4 = $dubai->season;
            $result_img_5 = $madrid->image; $result_town_5 = $madrid->town; $result_activity_5 = $madrid->activity; $result_season_5 = $madrid->season;
        }
        if($area === 'europe' && $budget === 'high' && $days === 'long' && $time === 'relax' ) {
            $result_img_1 = $dubai->image; $result_town_1 = $dubai->town; $result_activity_1 = $dubai->activity; $result_season_1 = $dubai->season;
            $result_img_2 = $paros->image; $result_town_2 = $paros->town; $result_activity_2 = $paros->activity; $result_season_2 = $paros->season;
        }
        if($area === 'europe' && $budget === 'high' && $days === 'long' && $time === 'adventure' ) {
            $result_img_1 = $cairo->image; $result_town_1 = $cairo->town; $result_activity_1 = $cairo->activity; $result_season_1 = $cairo->season;
            $result_img_2 = $jerusarem->image; $result_town_2 = $jerusarem->town; $result_activity_2 = $jerusarem->activity; $result_season_2 = $jerusarem->season;
            $result_img_3 = $dahab->image; $result_town_3 = $dahab->town; $result_activity_3 = $dahab->activity; $result_season_3 = $dahab->season;
            $result_img_4 = $tehran->image; $result_town_4 = $tehran->town; $result_activity_4 = $tehran->activity; $result_season_4 = $tehran->season;
        }
        
        //ここからアメリカ
        
        if($area === 'america' && $budget === 'low' && $days === 'short' && $time === 'shopping' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'low' && $days === 'short' && $time === 'relax' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'low' && $days === 'short' && $time === 'adventure' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'low' && $days === 'normal' && $time === 'shopping' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'low' && $days === 'normal' && $time === 'relax' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'low' && $days === 'normal' && $time === 'adventure' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'low' && $days === 'long' && $time === 'shopping' ) {
             $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'low' && $days === 'long' && $time === 'relax' ) {
             $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'low' && $days === 'long' && $time === 'adventure' ) {
             $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'middle' && $days === 'short' && $time === 'shopping' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
            $result_img_2 = $LA->image; $result_town_2 = $LA->town; $result_activity_2 = $LA->activity; $result_season_2 = $LA->season;
            $result_img_3 = $NY->image; $result_town_3 = $NY->town; $result_activity_3 = $NY->activity; $result_season_3 = $NY->season;
        }
        if($area === 'america' && $budget === 'middle' && $days === 'short' && $time === 'relax' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'middle' && $days === 'short' && $time === 'adventure' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'middle' && $days === 'normal' && $time === 'shopping' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
            $result_img_2 = $LA->image; $result_town_2 = $LA->town; $result_activity_2 = $LA->activity; $result_season_2 = $LA->season;
            $result_img_3 = $NY->image; $result_town_3 = $NY->town; $result_activity_3 = $NY->activity; $result_season_3 = $NY->season;
        }
        if($area === 'america' && $budget === 'middle' && $days === 'normal' && $time === 'relax' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'middle' && $days === 'normal' && $time === 'adventure' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'middle' && $days === 'long' && $time === 'shopping' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'middle' && $days === 'long' && $time === 'relax' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'middle' && $days === 'long' && $time === 'adventure' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'high' && $days === 'short' && $time === 'shopping' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
            $result_img_2 = $LA->image; $result_town_2 = $LA->town; $result_activity_2 = $LA->activity; $result_season_2 = $LA->season;
            $result_img_3 = $NY->image; $result_town_3 = $NY->town; $result_activity_3 = $NY->activity; $result_season_3 = $NY->season;
        }
        if($area === 'america' && $budget === 'high' && $days === 'short' && $time === 'relax' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'high' && $days === 'short' && $time === 'adventure' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'high' && $days === 'normal' && $time === 'shopping' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
            $result_img_2 = $LA->image; $result_town_2 = $LA->town; $result_activity_2 = $LA->activity; $result_season_2 = $LA->season;
            $result_img_3 = $NY->image; $result_town_3 = $NY->town; $result_activity_3 = $NY->activity; $result_season_3 = $NY->season;
        }
        if($area === 'america' && $budget === 'high' && $days === 'normal' && $time === 'relax' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
        }
        if($area === 'america' && $budget === 'high' && $days === 'normal' && $time === 'adventure' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
            $result_img_2 = $mexicocity->image; $result_town_2 = $mexicocity->town; $result_activity_2 = $mexicocity->activity; $result_season_2 = $mexicocity->season;
        }
        if($area === 'america' && $budget === 'high' && $days === 'long' && $time === 'shopping' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
            $result_img_2 = $LA->image; $result_town_2 = $LA->town; $result_activity_2 = $LA->activity; $result_season_2 = $LA->season;
            $result_img_3 = $NY->image; $result_town_3 = $NY->town; $result_activity_3 = $NY->activity; $result_season_3 = $NY->season;
        }
        if($area === 'america' && $budget === 'high' && $days === 'long' && $time === 'relax' ) {
            $result_img_1 = $hono->image; $result_town_1 = $hono->town; $result_activity_1 = $hono->activity; $result_season_1 = $hono->season;
            $result_img_2 = $miami->image; $result_town_2 = $miami->town; $result_activity_2 = $miami->activity; $result_season_2 = $miami->season;
        }
        if($area === 'america' && $budget === 'high' && $days === 'long' && $time === 'adventure' ) {
            $result_img_1 = $quito->image; $result_town_1 = $quito->town; $result_activity_1 = $quito->activity; $result_season_1 = $quito->season;
            $result_img_2 = $atakama->image; $result_town_2 = $atakama->town; $result_activity_2 = $atakama->activity; $result_season_2 = $atakama->season;
            $result_img_3 = $montevideo->image; $result_town_3 = $montevideo->town; $result_activity_3 = $montevideo->activity; $result_season_3 = $montevideo->season;
        }
        
        //以下、エラー処理
        if($area === 'none_1' || $budget === 'none_2' || $days === 'none_3' || $time === 'none_4' ) {
            $err = '未選択の項目があります。';
        }
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
  <title>提案先</title>
  <link rel="stylesheet" href="recommend.css">
</head>
<body>
  <div class="header">
    <div class="header_next_01">
      <h1 class="company_name"><a class="top_logo" href="index_02.php">Travel&nbsp;Camp.com</a></h1>
    </div>
    <div class="header_next_02">
      <span class="welcome">ようこそ<u><?php print h($_SESSION["USERID"], ENT_QUOTES); ?></u>さん
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
    <div class="center">
      <span class="err"><?php echo h($err); ?></span>
      <?php if(!empty($result_town_1)): ?>
      <span class="name"><?php echo h($_SESSION["USERID"]).'さんにおすすめの旅行先は以下のとおりです。'; ?></span>
      <?php endif ?>
      <table>
        <tr>
          <th><!--picture--></th>
          <th><span class="index">旅行先</span></th>
          <th><span class="index">やるべきこと</span></th>
          <th><span class="index">おすすめシーズン</span></th>
        </tr>
        <tr <?php if(empty($result_img_1)) { ?> class="td_border" <?php } ?>>
          <td><img src="<?php echo h($result_img_1); ?>"></td>
          <td><?php echo h($result_town_1); ?></td>
          <td><?php echo h($result_activity_1); ?></td>
          <td><?php echo h($result_season_1); ?></td>
        </tr>  
        <tr <?php if(empty($result_img_2)) { ?> class="td_border" <?php } ?> >
          <td><img src="<?php echo h($result_img_2); ?>"></td>
          <td><?php echo h($result_town_2); ?></td>
          <td><?php echo h($result_activity_2); ?></td>
          <td><?php echo h($result_season_2); ?></td>
        </tr>
        <tr <?php if(empty($result_img_3)) { ?> class="td_border" <?php } ?>>
          <td><img src="<?php echo h($result_img_3); ?>"></td>
          <td><?php echo h($result_town_3); ?></td>
          <td><?php echo h($result_activity_3); ?></td>
          <td><?php echo h($result_season_3); ?></td>
        </tr>
        <tr <?php if(empty($result_img_4)) { ?> class="td_border" <?php } ?>>
          <td><img src="<?php echo h($result_img_4); ?>"></td>
          <td><?php echo h($result_town_4); ?></td>
          <td><?php echo h($result_activity_4); ?></td>
          <td><?php echo h($result_season_4); ?></td>
        </tr>
        <tr <?php if(empty($result_img_5)) { ?> class="td_border" <?php } ?>>
          <td><img src="<?php echo h($result_img_5); ?>"></td>
          <td><?php echo h($result_town_5); ?></td>
          <td><?php echo h($result_activity_5); ?></td>
          <td><?php echo h($result_season_5); ?></td>
        </tr>
      </table>  
        <br><a href="service.php">前のページへ戻る</a>
    </div>
  </div>
  <footer>
    <p class="copyright">Copyright&nbsp;&copy;&nbsp;Travel&nbsp;Camp.com&nbsp;All&nbsp;Rights&nbsp;Reserved</p>
  </footer>
</body>
</html>