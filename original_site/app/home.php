<?php
require_once '../common/dbaccesUtil.php';
require_once '../common/scriptUtil.php';
require_once '../common/defineUtil.php';
session_start();

$name = isset ($_SESSION['name']) ? $_SESSION['name'] : null;
$user_id = isset ($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
var_dump($user_id, $name);
//$datetime =new DateTime();
//echo $datetime;
 ?>

 <!DOCTYPE html>
 <html lang="ja">
 <head>
 <meta charset="UTF-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/style.css">



       <title>ホーム</title>
       <!-- <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
       <link rel="stylesheet"      href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
       <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

 </head>
 <body>

   <div class="header">
     <div class="header_left">
       <ul>
         <li><a href="<?= HOME ?> ">ホーム</a></li>
         <li><a href="<?= INFORMATION ?> ">通知</a></li>
         <li><a href="<?= MESSAGE ?> ">メッセージ</a></li>
         <li><a href="<?= RANKING ?> ">ランキング</a></li>
      </ul>
     </div>
     <div class="header_right">
       <ul>
        <li>
          <form method="get" action="#" class="search">
            <input type="text" name="example" class="textBox">
            <input type="submit" value="検索" class="btn">
          </form>
        </li>

       <li><a href="<?php echo TOP_URI?>" id="logout" name="logout" taype="hidden" value="<?php $_SESSION['logout'] = 'LOGOUT'?>">ログアウト</a></li>
    <!--   <div class="modal_post">
        <input tyope="button" name="post" value="投稿">
    </div> -->
      <li><a data-toggle="modal" href="#post-modal" class="btn btn-primary">投稿</a></li>
     </ul>
    </div>

      <!--投稿ボタン 投稿画面をポップアップ表示-->
      <div class="modal fade" id="post-modal" >
       <div class="modal-dialog">
         <div clas="modal-content">
           <div class="modal-header">
             <button class="close" data-dismiss="modal">&times;</button>
             <h4 class="modal-title">イベント作成</h4>
           </div>
           <div class="modal-body">
              <form  method="post" name="form" id="form" type="file" accept="image/*">
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
   </div>

<div class="main">
      <div class="sidebar_left"><!-- 左-->
        <div class="profiles">
          <?php if (isset( $name, $user_id)) {//ログイン状態ならDBからユーザー情報を取得して表示する
                 $user_profiles = search_profiles($name, $user_id);
                }
          //echo var_dump($user_profiles);
                if (array_keys($user_profiles)){
             //if ($user_profiles[0]['profileImg'] != null){echo $user_profiles[0]['profileImg'];}else{echo <img //src="img.php"/>;<?php}
             echo $user_profiles[0]['username'].'<br>';?>
             投稿<?php echo $user_profiles[0]['post_num'];?>
             follower<?php echo $user_profiles[0]['follower_num'];?>
             follow<?php echo $user_profiles[0]['follow_num'];}?>
        </div>
      </div>

    <?php
    //ログインしているなら投稿情報を取得
    if(isset($name, $user_id)){
      $posts = show_posts($user_id);
    }
    //echo var_dump($posts);?>

    <div class="content"> <!-- タイムライン -->

      <?php //取得した投稿情報をテーブルに入れ、タイムラインを表現
        array_multisort($posts, SORT_DESC);
          foreach ($posts as $key ){?>
            <table class="timeline" table rules="groups" border='1' cellspacing='0' cellpadding='5' width='500'>
      <?php  foreach ($key as $list => $value){

                 if (isset($value)){
                  echo "<tr valign='top'>\n";
                	echo "<td>".$value."</td>\n";
                    }
            	      echo "</tr>\n";
                }
            }?>
      </table>

    </div>

  <!--   <div id="content-detail"> 投稿をクリックする事でポップアップ表示
     <p>投稿の詳細情報</p>
     <p><a id="modal-close" class="button-link">閉じる</a></p>
  </div>
  <div id="modal-overlay"></div>
   -->
   <div class="modal fade" id="post-detail" >
    <div class="modal-dialog">
      <div clas="modal-content">
        <div class="modal-header">
          <button class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">イベント作成</h4>
        </div>
        <div class="modal-body">
           <form  method="post" name="form" id="form" type="file" accept="image/*">
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
</div>

  <div class="sidebar_right">none</div>

</div>

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

<script>//投稿作成時イベント名が入力されていなければエラーを表示
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

<!-- <script>//ログアウトボタン
  $("#logout").click(function(){
    session_unset();
  });
</script> -->

<!-- <script>//投稿の詳細表示
$("#modal-open").click(
   function(){
     echo
   }
 );
</script> -->
<script>
 $(this).blur();
  if($("modal-overlay")[0]) return false;
</script>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="../bootstrap/js/bootstrap.min.js"></script>

   <script>$("body").append('<div id="modal-overlay"></div>');</script>
   <script>$("#modal-overlay").fadeIn("slow");</script>
   <script>$("#modalcontent").fadeIn("slow");
    function centeringModalSyncer(){
      var w = $(window).width();
      var h = $(window).height();
      var cw = $("#content-detail").outerWidth({margin:true});
      var ch = $("#content-detail").outerHeight({margin:true});
      var pxleft = ((w - cw)/2);
      var pxtop = ((h - ch)/2);
      $("#content-detail").css({"left": pxleft + "px"});
      $("#content-detail").css({"top": pxtop + "px"});
    }</script>
    <script>
     $("#modal-overlay,#modalclose").unbind().click(function(){
       //modal-overlayとmodal-closeをフェードアウト
       $("#content-detail, #motal-overlay").fadeOut("slow",function(){
         //フェードアウト後modal-overlayをHTML上から
         $("#modal-overlay").remove();
       });
     });</script>
 </body>
 </html>
