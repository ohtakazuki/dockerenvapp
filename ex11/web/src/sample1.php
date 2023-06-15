<?php
print('ただいまの日時は、'.date("Y-m-d H:i:s").'です。<br>');

// 接続情報
$dbname='postgres';
$host='ex11-db';
$dbuser='postgres';
$dbpass='postgres';

try{
  // dbへ接続
  $dbh = new PDO("pgsql:dbname=$dbname;host=$host", $dbuser, $dbpass);
  print('正常に接続されました。<br>');

  print('sysid, ユーザー名<br>');
  
  // クエリを実行しユーザー一覧を表示
  $sql = 'SELECT * FROM pg_user';
  foreach ($dbh->query($sql) as $row) {
    print($row['usesysid'].', ');
    print($row['usename'].'<br>');
  }
}catch (PDOException $e){
  print('エラー:'.$e->getMessage());
  exit();
}
?>
