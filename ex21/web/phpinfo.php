<?php
$date = date("Y-m-d H:i:s");
var_dump($date);
?>

<h1>ようこそ！PHP！</h1>
ただいまの日時は、<?php echo $date ?> です。

<?php
echo phpinfo()
?>