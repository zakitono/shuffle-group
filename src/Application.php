<!-- ここで、アプリ全体の管理 -->
<?php
require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/core/HttpNotFoundEx.php';
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

        try {
            #getPathInfoで今のパスの情報を取得して、resolve()で配列を返す
            $params = $this->router->resolve($this->getPathInfo());
            if (!$params) {
                throw new HttpNotFoundEx();
            }

            $controller = $params['controller'];
            $action = $params['action'];
            $this->runAction($controller, $action);
        } catch (HttpNotFoundEx $ex) {
            $this->render404Page();
        }
    }

    private function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        if (!class_exists($controllerClass)) {
            throw new HttpNotFoundEx();
        }
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

    private function render404Page()
    {
        header('HTTP/1.1 404 Page Not Found');
        $content = <<<EOF
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404</title>
</head>
<body>
    <h1>
        404 Page Not Found.
    </h1>
</body>
</html>

EOF;
        echo $content;
    }
}
