<?php

class Controller
{
    protected $actionName;

    public function run($action)
    {
        $this->actionName = $action;

        if (!method_exists($this, $action)) {
            throw new HttpNotFoundEx();
        }
        $content = $this->$action();
        return $content;
    }

    //$template → アクション名
    protected function render($variables = [], $template = null, $layout = 'layout')
    {
        $view = new View(__DIR__ . '/../views');

        if (is_null($template)) {
            $template = $this->actionName;
        }
        //クラス名の前部分を取得
        $controllerName = strtolower(substr(get_class($this), 0, -10));
        // shuffle, employee
        $path = $controllerName . '/' . $template;
        // shuffle/index
        return $view->render($path, $variables, $layout);
    }
}
