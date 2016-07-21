<?php
session_start();
require_once '../common/scriptUtil.php';
require_once '../common/defineUtil.php';


$name = isset($_POST['name']) ? $_POST['name'] : null;
$enail = isset($_POST['email']) ? $_POST['email'] : null;
$pssword = isset($_POST['password']) ? $_POST['password'] : null;


 ?>
 <!DOCTYPE html>
 <html lang="ja">
 <head>
 <meta charset="UTF-8">
       <title>登録確認</title>
 </head>
 <body>
<?php if(!$_POST['mode']=="CONFIRM"){
       echo 'アクセスルートが不正です。もう一度トップページからやり直してください<br>';
        }else{

   $confirm_values = array(
                          'profile_img' => bind_p2s('profile_img'),
                           'name' => bind_p2s('name'),
                           'email' => bind_p2s('email'),
                           'password' => bind_p2s('password'));

         $_SESSION['profile_img'] = $confirm_values['profile_img'];
         $_SESSION['name'] = $confirm_values['name'];
         $_SESSION['email'] = $confirm_values['email'];
         $_SESSION['password'] = $confirm_values['password'];

       //1つでも未入力項目があったら表示しない
       if(isset($confirm_values['name'] , $confirm_values['email'] , $confirm_values['password'])){?>
         <div>
           <h1>登録確認画面</h1><br>
           <form action="<?php echo REGISTRATION_USER?>" method="post">
           <?php echo $confirm_values['profile_img'];?>
           ユーザーネーム:<?php echo $confirm_values['name'];?><br>
           メールアドレス:<?php echo $confirm_values['email'];?><br>
           パスワード:<?php echo $confirm_values['password'];?><br>

            上記の内容で登録します。よろしいですか？<br>


           <input type="hidden" name="mode" value="CREATE" >
           <input type="submit" name="yes" value="アカウント作成">
         </form>
         </div>

<?php }else{?>
  <h1>入力項目が不完全です</h1><br>
  再度入力を行ってください<br>
  <h3>不完全な項目</h3>
  <?php
  //連想配列内の未入力項目を検出して表示
  foreach ($confirm_values as $key => $value){
      if($value == null){
          if($key == 'name'){
              echo '名前';
          }
          if($key == 'email'){
              echo 'メールアドレス';
          }
          if($key == 'password'){
              echo 'パスワード';
          }
          echo 'が未記入です<br>';
        }
      }
    }
    echo var_dump($confirm_values);?>
    <form action="<?php echo INSERT ?>" method="POST">
        <input type="hidden" name="mode" value="REINPUT" >
        <input type="submit" name="no" value="登録画面に戻る">
    </form>
    <?php
}?>
</body>
</html>
