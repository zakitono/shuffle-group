<?php

class Controller
{
    protected $actionName;
    protected $request;
    protected $databaseManager;

    public function __construct($application)
    {
        $this->request = $application->getRequest();
        $this->databaseManager = $application->getDatabaseManager();
    }

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
    //ShuffleController 又は EmployeeControllerから与えられた引数を代入
    protected function render($variables = [], $template = null, $layout = 'layout')
    {
        //viewクラスのインスタンス化、引数にパスを指定
        $view = new View(__DIR__ . '/../views');

        //テンプレートの変更が必要がない場合、アクション名を$templateに指定(index,create)
        if (is_null($template)) {
            $template = $this->actionName;
        }
        //クラス名(ShuffleController 又は EmployeeController)の前部分を取得
        // shuffle, employee 大文字を→小文字へ
        $controllerName = strtolower(substr(get_class($this), 0, -10));
        // shuffle/index
        //ここでパスを作成
        $path = $controllerName . '/' . $template;
        //viewクラスのrenderメソッドの処理
        return $view->render($path, $variables, $layout);
    }
}
