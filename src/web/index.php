<?php

require '../bootstrap.php';
require '../Application.php';

#Applicationのインスタン化、run();で起動
$app = new Application();
$app->run();
