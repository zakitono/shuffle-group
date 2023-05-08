<?php

class View
{
    //__DIR__ . '/../views'
    protected $baseDir;

    public function __construct($baseDir)
    {
        $this->baseDir = $baseDir;
    }

    public function render($path, $variables, $layout = false)
    {
        //['groups' => []]
        // $groups = [];
        //変数の宣言
        extract($variables);

        //ob_start() → 画面出力せず、一時的に保持
        ob_start();
        require $this->baseDir . '/' . $path . '.php';
        //require 'views/shuffle/index.php'
        $content = ob_get_clean();

        ob_start();
        require $this->baseDir . '/' . $layout . '.php';
        //layout.php
        $layout = ob_get_clean();

        //HTML情報のリターン
        return $layout;
    }
}
