<?php
// public/index.php

// タイムゾーンを設定 (任意)
date_default_timezone_set('Asia/Tokyo');

// PHPのバージョンを取得
$phpVersion = phpversion();

// 現在の日時を取得
$currentTime = date('Y-m-d H:i:s T');

// サーバー情報の一部を取得 (例)
$serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'; // ビルトインサーバーの場合など

// Xdebugが有効かどうかの簡単なチェック
$xdebugStatus = extension_loaded('xdebug') ? '有効' : '無効';
$debugMode = ini_get('xdebug.mode');

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Dev Container - Web Page</title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            margin: 2em;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            background-color: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 0.3em;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin-bottom: 0.5em;
            background-color: #ecf0f1;
            padding: 0.5em 1em;
            border-radius: 4px;
        }
        strong {
            color: #3498db;
            margin-right: 0.5em;
        }
        .xdebug-info {
            margin-top: 1em;
            padding: 0.5em;
            background-color: #e8f6f3;
            border-left: 4px solid #1abc9c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>ようこそ PHP Dev Container へ！</h1>
        <p>これはPHPビルトインWebサーバーによって提供されるシンプルなWebページです。</p>

        <h2>環境情報:</h2>
        <ul>
            <li><strong>PHP Version:</strong> <?php echo htmlspecialchars($phpVersion); ?></li>
            <li><strong>Server Software:</strong> <?php echo htmlspecialchars($serverSoftware); ?></li>
            <li><strong>Current Time:</strong> <?php echo htmlspecialchars($currentTime); ?></li>
        </ul>

        <div class="xdebug-info">
            <strong>Xdebug Status:</strong> <?php echo htmlspecialchars($xdebugStatus); ?>
            <?php if ($xdebugStatus === '有効'): ?>
                (Mode: <?php echo htmlspecialchars($debugMode ?: 'N/A'); ?>)
            <?php endif; ?>
        </div>

        <p><a href="?action=phpinfo">PHP Info を表示</a></p>

        <?php
        // phpinfo() を表示するリンクがクリックされた場合
        if (isset($_GET['action']) && $_GET['action'] === 'phpinfo') {
            echo '<h2>PHP Info:</h2>';
            // ここにブレークポイントを設定してデバッグを試すことができます
            $infoVar = "Displaying PHP Info"; // デバッグ用変数
            phpinfo();
        }
        ?>
    </div>
</body>
</html>