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

            //ルーティングに存在するパスが一致していれば、コントローラー、アクションの値を変数へ格納
            //コントローラー名
            $controller = $params['controller'];
            //アクション名
            $action = $params['action'];
            $this->runAction($controller, $action);
        } catch (HttpNotFoundEx $ex) {
            //ページが見つからなかった時の処理
            $this->render404Page();
        }

        //runActionのデータをsendメソッドでcontentを表示させる
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
        //EmployeeController 又は
        //ShuffleController を生成して$controllerClassへ格納
        $controllerClass = ucfirst($controllerName) . 'Controller';
        if (!class_exists($controllerClass)) {
            throw new HttpNotFoundEx();
        }
        #EmployeeController 又は
        #ShuffleControllerのインスタンス化
        $controller = new $controllerClass($this);
        //ShuffleController→runアクション(引数がindex,又はcreate)
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
            '/create' => ['controller' => 'employee', 'action' => 'create'],


            // '/employee/employee/create' => ['controller' => 'employee', 'action' => 'validationCreate'],
        ];
    }

    //404エラー画面の表示
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
