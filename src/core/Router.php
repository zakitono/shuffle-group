<?php

class Router
{
    #ルーティングの情報を受け取る
    private $routes;
    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    #取得したpathの情報が、['controller' => 'shuffle', 'action' => 'index']と同じか確認
    public function resolve($pathInfo)
    {
        foreach ($this->routes as $path => $pattern) {
            if ($path === $pathInfo) {
                return $pattern;
            }
        }
        return false;
    }
}
