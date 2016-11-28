<?php
require_once '../common/defineUtil.php';
require_once '../common/dbaccesUtil.php';
require_once '../common/scriptUtil.php';
session_start();

//アクセスルートチェック
if (!isset($_POST['login']) && $_POST['login'] != 'LOGIN'){
  header("Location: top.php");
  die();//ログイン失敗ならトップに戻る
}

$name = isset($_POST['name']) ? $_POST['name'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

//echo $name;
//echo $password;
if (isset($name, $password)){
  $login = login($name, $password);

    if (array_keys($login)){//検索結果がtrueならユーザー名とIDをセッションに保存

        $_SESSION['user_id'] = $login[0]['user_id'];
        $_SESSION['name'] = $name;
//echo var_dump($_SESSION['userID']);
//echo var_dump($_SESSION['name']);

        header("Location: home.php");//ログイン成功ならホーム画面に移動
      }else{
        $_SESSION['login_error'] = '*ユーザーネーム又はパスワードに誤りがあります';
        //header("Location: top.php");//ログイン失敗ならトップに戻る

        //echo $login[0]['id'];
        var_dump($login, $name, $password);
        echo 'error';
      }

}
