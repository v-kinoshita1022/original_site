<?php
session_start();
require_once '../common/dbaccesUtil.php';

if( empty($previous_page)){//リダイレクト変数
  $previous_page = $_SERVER['HTTP_REFERER'];
 }
if(!$_POST['mode']=="CREATE"){//ルートチェック
      header("Location: $previous_page");}


$profile_img = $_SESSION['profile_img'];
$name =  $_SESSION['name'];
$email =  $_SESSION['email'];
$password =  $_SESSION['password'];

//$refresh = isset($_POST['refresh']) ? $_POST['refresh'] : null;

$_SESSION['error'] = registration_user($profile_img, $name, $email, $password);

if(!isset($_SESSION['error'] )){//登録成功ならホーム画面へ
  $_SESSION['name'] = $name;
  $_SESSION['userid'] = login($name, $password);
header("Location: home.php");

}else{//エラーなら登録画面へ
header("Location: registration.php");


}
