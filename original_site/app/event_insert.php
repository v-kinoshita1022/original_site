<?php
//イベント情報をDBに保存する
session_start();
require_once '../common/dbaccesUtil.php';

if (!isset($_POST['POST'], $_SESSION['user_id'])){
  header("Location: top.php");//ルートチェック
}

if (empty($previous_page)){//リダイレクト用変数
  $previous_page = $_SERVER['HTTP_REFERER'];
}

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$img = isset($_POST['img']) ? $_POST['img'] : null;
$title = isset($_POST['title']) ? $_POST['title'] : null;
$place = isset($_POST['place']) ? $_POST['place'] : null;
$start_time = isset($_POST['startTime']) ? $_POST['startTime'] : null;
$end_time = isset($_POST['endTime']) ? $_POST['endTime'] : null;
$detail = isset($_POST['detail']) ? $_POST['detail'] : null;
$tags = isset($_POST['tags']) ? $_POST['tags'] : null;

$refresh = isset($_POST['refresh']) ? $_POST['refresh'] : null;

//投稿内容をDBにインサートする
$result = event_insert($user_id, $title, $place, $start_time, $end_time, $detail, $tags, $img);

//投稿回数をDBにインサートする
post_num($user_id);


if (empty($result)){
header("Location: $previous_page");}


 ?>
