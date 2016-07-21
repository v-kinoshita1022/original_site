<?php
require_once '../common/defineUtil.php';
@session_destroy();
session_start();
  $name = isset ($_SESSION['name'] ) ? $_SESSION['name'] : null;
  $password = isset ($_SESSION['password']) ? $_SESSION['password'] : null;
 echo var_dump($_SESSION);
if (isset($name , $password)){

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
   <form action="<?php echo LOGIN ?>" method="POST">
     ユーザーネーム<input type='text' name='name' value="<?= $name;?>">
     パスワード<input type='text' name='password' value="<?= $password;?>">
     <input type='hidden' name='MODE' value='LOGIN'>
     <input type="submit" name="login" value="ログイン">
   </form>
