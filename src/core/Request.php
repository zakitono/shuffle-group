<?php

class Request
{
    public function isPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }
        return false;
    }

    //URLの取得
    public function getPathInfo()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
