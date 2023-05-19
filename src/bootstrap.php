<!-- 初期化の処理 -->
<?php

require 'core/AutoLoader.php';

$loader = new AutoLoader();
//ディレクトリの登録
$loader->registerDir(__DIR__ . '/core');
$loader->registerDir(__DIR__ . '/controller');
$loader->registerDir(__DIR__ . '/models');
$loader->register();
