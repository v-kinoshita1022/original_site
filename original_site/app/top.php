<?php
require_once '../common/defineUtil.php';

session_start();
  $name = isset ($_SESSION['name'] ) ? $_SESSION['name'] : null;
  $password = isset ($_SESSION['password']) ? $_SESSION['password'] : null;
  $login_error = isset ($_SESSION['login_error']) ? $_SESSION['login_error'] : null;
  $logout = isset ($_SESSION['logout']) &&  $_SESSION['logout'] == 'LOGOUT' ? $_SESSION['logout'] : null;
 var_dump($_SESSION);

if (isset ($logout)) { //ログアウトボタンを押されているならセッションを破棄する
  $_SESSION = array();
  if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
  }
  session_destroy();
}
 ?>
 
 <!DOCTYPE html>
 <html lang="ja">
 <head>
 <meta charset="UTF-8">
     <title>トップページ</title>
 </head>
 <body>
   <h1><a href="<?php echo TOP_URI?>">FLASH</a></h1>
   <form>
   <input type="button" onclick="location.href='<?= REGISTRATION?>'" name="registration" value="新規登録" >
   <input type="hidden" name="MODE" value="REGISTRATION">
   </form>

     <?php if (isset ($login_error)) { //ログインエラーメッセージ?>
       <font color="red"> <?php echo $login_error; ?> </font>
     <?php } ?>

   <form action="<?php echo LOGIN ?>" method="POST">
     ユーザーネーム<input type='text' name='name' value="<?= $name;?>">
     パスワード<input type='text' name='password' value="<?= $password;?>">
     <input type='hidden' name='MODE' value='LOGIN'>
     <input type="submit" name="login" value="ログイン">
   </form>
