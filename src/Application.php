<!-- ここで、アプリ全体の管理 -->
<?php

class Application
{
    protected $router;
    protected $request;
    protected $response;
    protected $databaseManager;

    public function __construct()
    #routerに['controller' => 'shuffle', 'action' => 'index']を登録
    {
        $this->router = new Router($this->registerRoutes());
        $this->request = new Request();
        $this->response = new Response();
        $this->databaseManager = new DatabaseManager();
        //DatabaseManagerクラスのconnectメソッドで処理
        $this->databaseManager->connect(
            [
                'hostname' => 'db',
                'username' => 'test_user',
                'password' => 'pass',
                'database' => 'test_database'
            ]
        );
    }

    public function run()
    {

        try {
            #getPathInfoで今のパスの情報を取得して、resolve()で配列を返す
            $params = $this->router->resolve($this->request->getPathInfo());
            if (!$params) {
                throw new HttpNotFoundEx();
            }

            $controller = $params['controller'];
            $action = $params['action'];
            $this->runAction($controller, $action);
        } catch (HttpNotFoundEx $ex) {
            //ページが見つからなかった時の処理
            $this->render404Page();
        }

        $this->response->send();
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function getDatabaseManager()
    {
        return $this->databaseManager;
    }

    private function runAction($controllerName, $action)
    {
        $controllerClass = ucfirst($controllerName) . 'Controller';
        if (!class_exists($controllerClass)) {
            throw new HttpNotFoundEx();
        }
        #ShuffleControllerのインスタンス化
        $controller = new $controllerClass($this);
        $content = $controller->run($action);
        $this->response->setContent($content);
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

    private function render404Page()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->response->setContent(
            <<<EOF
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
EOF
        );
    }
}
