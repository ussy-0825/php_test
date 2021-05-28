<?php
///パスワードを記録したファイルの場所
echo __FILE__; 
// /Applications/MAMP/htdocs/php_test/mainte/test.php

echo '<br>';
///パスワード（暗号化）
echo(password_hash('pw', PASSWORD_BCRYPT));
