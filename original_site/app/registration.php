<?php
/*if (!isset($_POST['MODE']) && $_POST['MODE'] != 'REGISTRATION'){
  header("Location: top.php");
}*/
session_start();
require_once '../common/defineUtil.php';
 ?>

 <!DOCTYPE html>
 <html lang="ja">
  <head>
    <meta charset="UTF-8">
       <title>新規登録</title>
  </head>
    <body>
    <?php if (isset($_SESSION['error'])){
      echo '登録に失敗しました。入力からやり直してください。'.$_SESSION['error'];
      unset($_SESSION['error']);
    }
    echo var_dump($_SESSION['error']);?>
       <header>
         <a href="<?php echo TOP_URI?>">FLASH</a>
       <div>
         <form enctype="multipart/form-data" action="<?php echo REGISTRATION_CONFIRM ?>" method="post">
               プロフィール画像<input type="file" name="profile_img"><br>


         ユーザーネーム<input type="text" name="name" placeholder="ユーザーネーム"
            value="<?php if (isset($_POST['mode']) && $_POST['mode'] == 'REINPUT'){echo $_SESSION['REINPUT'][0]['name'];}?> " placeholder="ユーザーネーム"><br>
         メールアドレス<input type="text" name="email" placeholder="メールアドレス"
            value="<?php if (isset($_POST['mode']) && $_POST['mode'] == 'REINPUT'){echo $_SESSION['REINPUT'][0]['email'];}?> "><br>
         パスワード<input type="text" name="password" placeholder="パスワード"
            value="<?php if (isset($_POST['mode']) && $_POST['mode'] == 'REINPUT'){echo $_SESSION['REINPUT'][0]['password'];}?> "><br>

         <input type="hidden" name="mode" value="CONFIRM"><br>
         <input type="submit" name="registration" value="アカウント作成">
       </form>
      </div>
    </body>
  </html>
