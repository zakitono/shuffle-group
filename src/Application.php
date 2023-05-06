<!-- ここで、アプリ全体の管理 -->
<?php
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/controller/ShuffleController.php';
require_once __DIR__ . '/controller/EmployeeController.php';

class Application
{
    private $router;
    public function __construct()
    #routerに['controller' => 'shuffle', 'action' => 'index']を登録
    {
        $this->router = new Router($this->registerRoutes());
    }

    public function run()
    {
        #getPathInfoで今のパスの情報を取得して、resolve()で配列を返す
        $params = $this->router->resolve($this->getPathInfo());
        $controller = $params['controller'];
        $action = $params['action'];
        $this->runAction($controller, $action);
    }

    private function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        #ShuffleControllerのインスタンス化
        $controller = new $controllerClass();
        $controller->run($action);
    }

    #トップページ '/' のcontroller、actionを配列にして設定
    private function registerRoutes()
    {
        return [
            '/' => ['controller' => 'shuffle', 'action' => 'index'],
            '/shuffle' => ['controller' => 'shuffle', 'action' => 'create'],
            '/employee' => ['controller' => 'employee', 'action' => 'index'],
            '/employee/create' => ['controller' => 'employee', 'action' => 'create'],
        ];
    }
    private function getPathInfo()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
