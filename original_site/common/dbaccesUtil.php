<?php

//DBへの接続を行う。成功ならPDOオブジェクトを、失敗なら中断、メッセージの表示を行う
function connect2MySQL(){
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=original_site;charset=utf8','kinoshita','freedom1022');
        //SQL実行時のエラーをtry-catchで取得できるように設定
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('DB接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
    }
}

function show_posts($user_id){//ログインしているなら投稿情報をタイムラインに返す
  //db接続を確立
  $searchUser_db = connect2MySQL();

  $search_sql = "SELECT title, plase start_time, end_time,detail, tags, img FROM posts WHERE user_id=:user_id";

  //クエリとして用意
  $search_query = $searchUser_db->prepare($search_sql);

  //SQL文に受け取った値をバインド
  $search_query->bindValue(':user_id', $user_id);

  //SQLを実行
  try{
      $search_query->execute();
  } catch (PDOException $e) {
      //接続オブジェクトを初期化することでDB接続を切断
      $searchUser_db=null;
      return $e->getMessage();
  }

  $searchUser_db=null;
  return $search_query->fetchAll(PDO::FETCH_ASSOC);
}

//ユーザーネームとパスワードを渡して、ユーザーIDを返す
function login($name, $password){
  //db接続を確立
  $searchUser_db = connect2MySQL();

  $search_sql = "SELECT user_id FROM users WHERE username=:username AND password=:password";

  //クエリとして用意
  $search_query = $searchUser_db->prepare($search_sql);

  //SQL文に受け取った値をバインド
  $search_query->bindValue(':username', $name);
  $search_query->bindValue(':password', $password);


  //SQLを実行
  try{
      $search_query->execute();
  } catch (PDOException $e) {
      //接続オブジェクトを初期化することでDB接続を切断
      $searchUser_db=null;
      return $e->getMessage();
  }

  $searchUser_db=null;
  return $search_query->fetchAll(PDO::FETCH_ASSOC);
}


//レコードの挿入を行う。失敗した場合はエラー文を返却する
function registration_user($profile_img=null,$name, $email, $password){
    //db接続を確立
    $insert_db = connect2MySQL();

    //DBに全項目のある1レコードを登録するSQL
    $insert_sql = "INSERT INTO users(profileImg,username,email,password,newDate)"
            . "VALUES(:profileImg,:username,:email,:password,:newDate)";

    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $date = $datetime->format('Y-m-d H:i:s');

    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_query->bindValue(':profileImg', $profile_img);
    $insert_query->bindValue(':username', $name);
    $insert_query->bindValue(':email', $email);
    $insert_query->bindValue(':password', $password);
    $insert_query->bindValue(':newDate', $date);

    //SQLを実行
    try{
        $insert_query->execute();
    } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
        $insert_db=null;
        return $e->getMessage();
    }

    $insert_db=null;
    return null;
}

function serch_all_profiles(){
    //db接続を確立
    $search_db = connect2MySQL();

    $search_sql = "SELECT * FROM users";

    //クエリとして用意
    $search_query = $search_db->prepare($search_sql);

    //SQLを実行
    try{
        $search_query->execute();
    } catch (PDOException $e) {
        $search_query=null;
        return $e->getMessage();
    }

    //全レコードを連想配列として返却
    return $search_query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * 複合条件検索を行う
 * @param type $name
 * @param type $year
 * @param type $type
 * @return type
 */

 //ユーザーネームとユーザーidを渡してユーザー情報を返す。ログイン画面用
function search_profiles($name=null,$id=null){
  //db接続を確立
  $searchUser_db = connect2MySQL();

  $search_sql = "SELECT profileImg, username, post_num, follower_num, follow_num FROM users WHERE username=:username AND user_id=:user_id";

  //クエリとして用意
  $search_query = $searchUser_db->prepare($search_sql);

  //SQL文に受け取った値をバインド
  $search_query->bindValue(':username', $name);
  $search_query->bindValue(':user_id', $id);


  //SQLを実行
  try{
      $search_query->execute();
  } catch (PDOException $e) {
      //接続オブジェクトを初期化することでDB接続を切断
      $searchUser_db=null;
      return $e->getMessage();
  }

  $searchUser_db=null;
  return $search_query->fetchAll(PDO::FETCH_ASSOC);
}



function profile_detail($id){//userIDを取得する
    //db接続を確立
    $detail_db = connect2MySQL();

    $detail_sql = "SELECT * FROM user_t WHERE userID=:id";

    //クエリとして用意
    $detail_query = $detail_db->prepare($detail_sql);

    $detail_query->bindValue(':id',$id);

    //SQLを実行
    try{
        $detail_query->execute();
    } catch (PDOException $e) {
        $detail_query=null;
        return $e->getMessage();
    }

    //レコードを連想配列として返却
    return $detail_query->fetchAll(PDO::FETCH_ASSOC);
}

function delete_profile($id){//プロフィール削除
    //db接続を確立
    $delete_db = connect2MySQL();

    $delete_sql = "DELEtE * FROM user_t WHERE userID=:id";

    //クエリとして用意
    $delete_query = $delete_db->prepare($delete_sql);

    $delete_query->bindValue(':id',$id);

    //SQLを実行
    try{
        $delete_query->execute();
    } catch (PDOException $e) {
        $delete_query=null;
        return $e->getMessage();
    }
    return null;
}

function event_insert($user_id,$title,$place=null,$start_time=null,$end_time=null,$detail=null,$tags=null,$img){
      //db接続を確立
    $insert_db = connect2MySQL();

    $eventInsert = "INSERT INTO posts(user_id,title,place,start_time,end_time,detail,tags,img,newDate)"
            . "VALUES(:user_id,:title,:place,:start_time,:end_time,:detail,:tags,:img,:newDate)";

            $datetime =new DateTime();
            $date = $datetime->format('Y-m-d H:i:s');

//クエリとして用意
$insert_query = $insert_db->prepare($eventInsert);

//SQL文にセッションから受け取った値＆現在時をバインド
$insert_query->bindValue(':user_id',$user_id);
$insert_query->bindValue(':title',$title);
$insert_query->bindValue(':place',$place);
$insert_query->bindValue(':start_time',$start_time);
$insert_query->bindValue(':end_time',$end_time);
$insert_query->bindValue(':detail',$detail);
$insert_query->bindValue(':tags',$tags);
$insert_query->bindValue(':img',$img);
$insert_query->bindValue(':newDate',$date);


//SQLを実行
try{
    $insert_query->execute();
} catch (PDOException $e) {
    //接続オブジェクトを初期化することでDB接続を切断
    $insert_db=null;
    return $e->getMessage();
}

$insert_db=null;
return null;
}


function post_num($user_id){//投稿する度に投稿数に１を足してインサートする
  //db接続を確立
  $insert_db = connect2MySQL();

  $insert_sql = "UPDATE users SET post_num=post_num+1 WHERE user_id=:user_id";

  //クエリとして用意
  $insert_query = $insert_db->prepare($insert_sql);

  $insert_query->bindValue(':user_id',$user_id);


  //SQLを実行
  try{
      $insert_query->execute();
  } catch (PDOException $e) {
      //接続オブジェクトを初期化することでDB接続を切断
      $insert_db=null;
      return $e->getMessage();
  }
}
