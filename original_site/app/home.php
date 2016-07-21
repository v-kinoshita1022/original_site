<?php
require_once '../common/dbaccesUtil.php';
require_once '../common/scriptUtil.php';
session_start();

$name = isset ($_SESSION['name']) ? $_SESSION['name'] : null;
$user_id = isset ($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
echo var_dump($user_id);
 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


       <title>ホーム</title>
       <!-- <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
       <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
       <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
 </head>
 <body>

   <header class="container" style="padding:20px 0">
     <a href="<?= HOME ?> ">HOME</a>
     <a href="<?= INFORMATION ?> ">INFOMATION</a>
     <a href="<?= MESSAGE ?> ">MESSAGE</a>
     <a href="<?= RANKING ?> ">RANKING</a>

       <form method="get" action="#" class="search">
          <div>
            <input type="text" name="example" class="textBox">
            <input type="submit" value="検索" class="btn">
          </div>
       </form>

       <a href="<?php echo TOP_URI?>" id="logout">ログアウト</a>
    <!--   <div class="modal_post">
        <input tyope="button" name="post" value="投稿">
    </div> -->
      <a data-toggle="modal" href="#myModal" class="btn btn-primary">投稿</a>

      <div class="modal fade" id="myModal" >
       <div class="modal-dialog">
         <div clas="modal-content">
           <div class="modal-header">
             <button class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">イベント作成</h4>
           </div>
           <div class="modal-body">
              <form action="event_insert.php" method="post" name="form" id="form" type="file" accept="image/*">
                 イメージ画像<input name="img" type="file" /><br>
                 イベント名:<input type="text" name="title" placeholder="簡潔なタイトルを入力" ><br>
                 場所:<input type="text" name="place" placeholder="スポットまたは住所を入力" ><br>
                 開始時間<input type="date" name="start_time"><br>
                 終了時間<input type="date" name="end_time"><br>
                 詳細<textarea name="detail" placeholder="イベントの詳細を記入"></textarea><br>
                 タグ<input type="text" name="tags" placeholder="タグを登録"><br>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
             <input type="hidden" name="POST" value="POST">
             <button type="submit" class="btn btn-primary">投稿</button>
           </from>
           </div>
         </div>
       </div>
      </div>
   </header>

   <div title="profiles">
<?php if (isset( $name, $user_id)) {//ログイン常態ならDBからユーザー情報を取得して表示する
            $user_profiles = search_profiles($name, $user_id  );
        }
      echo var_dump($user_profiles);
       if (array_keys($user_profiles)){
         //if ($user_profiles[0]['profileImg'] != null){echo $user_profiles[0]['profileImg'];}else{echo <img //src="img.php"/>;<?php}
         echo $user_profiles[0]['username'].'<br>';?>
         投稿<?php if ($user_profiles[0]['post_num'] != null){echo $user_profiles[0]['postNum'];}else{echo '0';}?>
         follower<?php if ($user_profiles[0]['follower_num'] != null){echo $user_profiles[0]['followerNum'];}else{echo '0';}?>
         follow<?php if ($user_profiles[0]['follow_num'] != null){echo $user_profiles[0]['followNamu'];}else{echo '0';}
       }?>
   </div>

<?php
//ログインしているならとうこう投稿情報を取得
if(isset($name, $user_id)){
  $posts = show_posts($user_id);
}
echo var_dump($posts);
?>
<table border='1' cellspacing='0' cellpadding='5' width='500'>
<?php
foreach ($posts as $key => $list){
	echo "<tr valign='top'>\n";
	echo "<td>".$list['title'] ."</td>\n";
	echo "<td>".$list['img'] ."</td>\n";
	echo "<td>".$list['startTime'] ."</td>\n";
	echo "<td>".$list['place'] ."<br/>\n";
	echo "<td>".$list['detail'] ."<br/>\n";
	echo "<td>".$list['tags'] ."<br/>\n";
	echo "<small>".$list['stamp'] ."</small></td>\n";
	echo "</tr>\n";
}
?>
</table>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

<script>
   $(function() {
       $("#form").submit(function(){
     if ($("input[title='title']").val() == '') {
       alert('イベント名を入力してください');
       return false;
     } else {
       $("#form").submit();
     }
    });
   });
</script>
<script>
  $("#logout").click(function(){
    session_unset();
  });
</script>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="../bootstrap/js/bootstrap.min.js"></script>
 </body>
 </html>
