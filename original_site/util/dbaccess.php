<?php
//DBアクセスutil

function connect2MySQL(){//DBアクセス
try{
    $pdo = new PDO('mysql:host=localhost;dbname=kagoyume_db;charset=utf8','kinoshita','freedom1022');
    $pdo->setAttribute(PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION);
    return $pdo;

} catch (PDOException $e) {
    //ERROR_PROCEDURE();
    die('接続に失敗しました。次記のエラーにより処理を中断します:'.$e->getMessage());
}
}


function login_search($name,$password){//AND検索関数
$login_db = connect2MySQL(); //db接続を確立

$search = "SELECT * FROM user_t WHERE name = :name AND password = :password;";//DBでand検索
//クエリとして用意
$search_query = $login_db->prepare($search);

$search_query->bindValue(':name',$name);
$search_query->bindValue(':password',$password);

try{
//SQLを実行
$search_query->execute();

}catch(PDOException $e) {
   //return $e->getMessage().'<br><br>';

}
//接続オブジェクトを初期化することでDB接続を切断
$login_db=null;
return $search_query->fetchAll(PDO::FETCH_ASSOC);

}

function search($name,$password){//AND検索関数
$login_db = connect2MySQL(); //db接続を確立

$search = "SELECT * FROM user_t WHERE name = :name OR password = :password;";//DBでand検索
//クエリとして用意
$search_query = $login_db->prepare($search);

$search_query->bindValue(':name',$name);
$search_query->bindValue(':password',$password);

try{
//SQLを実行
$search_query->execute();

}catch(PDOException $e) {
   //return $e->getMessage().'<br><br>';

}
//接続オブジェクトを初期化することでDB接続を切断
$login_db=null;
return $search_query->fetchAll(PDO::FETCH_ASSOC);

}


function insert_profiles($name, $password, $mail, $address ){//DBユーザー登録
    //db接続を確立
  $insert_db = connect2MySQL();

    //DBに全項目のある1レコードを登録するSQL
    $insert_sql = "INSERT INTO user_t ( name, password, mail, address, newDate)
     VALUES(:name, :password, :mail, :address, :newDate)";

    //現在時をdatetime型で取得
    $datetime =new DateTime();
    $newDate = $datetime->format('Y-m-d H:i:s');

    //クエリとして用意
    $insert_query = $insert_db->prepare($insert_sql);

    //SQL文にセッションから受け取った値＆現在時をバインド
    $insert_query->bindValue(':name',$name);
    $insert_query->bindValue(':password',$password);
    $insert_query->bindValue(':mail',$mail);
    $insert_query->bindValue(':address',$address);
    $insert_query->bindValue(':newDate',$newDate);


    try{
       $insert_query->execute();

      } catch (PDOException $e) {
        //接続オブジェクトを初期化することでDB接続を切断
      $insert_query=null;
      return  $e->getMessage();

      }
        return null;
}
