<?php
class ShuffleController
{
    public function run($action)
    {
        $this->$action();
    }

    private function index()
    {
        echo 'Hello, index';
    }
}
