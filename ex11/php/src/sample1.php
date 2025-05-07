<?php

// 環境変数からデータベース接続情報を取得
$dbHost = getenv('DB_HOST');
$dbPort = getenv('DB_PORT');
$dbName = getenv('DB_DATABASE');
$dbUser = getenv('DB_USER');
$dbPassword = getenv('DB_PASSWORD');

// 接続情報が不足している場合はエラーメッセージを表示して終了
if (!$dbHost || !$dbPort || !$dbName || !$dbUser || $dbPassword === false) {
    echo "エラー: 必要なデータベース接続情報が環境変数に設定されていません。\n";
    exit(1);
}

// DSN (Data Source Name) を構築
$dsn = "pgsql:host={$dbHost};port={$dbPort};dbname={$dbName}";

try {
    // PDOインスタンスを作成してデータベースに接続
    $pdo = new PDO($dsn, $dbUser, $dbPassword);
    // エラーモードを例外に設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "データベースに接続しました。\n";

    // pg_userテーブルの内容を取得するクエリを実行
    $stmt = $pdo->query('SELECT usename, usesysid FROM pg_catalog.pg_user');

    // 結果を取得して表示
    echo "pg_user テーブルの内容:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }

} catch (PDOException $e) {
    // 接続またはクエリ実行中にエラーが発生した場合
    echo "データベースエラー: " . $e->getMessage() . "\n";
    exit(1);
}

?>