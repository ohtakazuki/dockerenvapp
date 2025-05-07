<?php

// コンテナ自身のホスト名を取得
$hostname = gethostname();

// HTMLでメッセージとホスト名を表示
echo "<h1>Hello from Multi-Stage Build (PHP)!</h1><p>Served by container: " . htmlspecialchars($hostname) . "</p>";

?>
