<?php

class ShuffleController extends Controller
{
    public function index()
    {
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        if ($mysqli->connect_error) {
            throw new RuntimeException('mysqli接続エラー:' . $mysqli->connect_error);
        }

        //レンダリング
        //Controller.phpのrenderメソッドで処理する
        return $this->render([
            'groups' => [],
        ]);
        // include  __DIR__ . '/../views/index.php';
    }

    public function create()
    {
        if (!$this->request->isPost()) {
            throw new HttpNotFoundEx();
        }

        $groups = [];
        $mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
        if ($mysqli->connect_error) {
            throw new RuntimeException('mysqli接続エラー:' . $mysqli->connect_error);
        }

        $result = $mysqli->query('SELECT name FROM employees');
        $employees = $result->fetch_all(MYSQLI_ASSOC);
        shuffle($employees);
        $cnt = count($employees);

        if ($cnt % 2 === 0) {
            $groups = array_chunk($employees, 2);
        } else {
            $extra = array_pop($employees);
            $groups = array_chunk($employees, 2);
            array_push($groups[0], $extra);
        }

        return $this->render([
            'groups' => $groups,
        ], 'index');
    }
}
