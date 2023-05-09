<!-- データベースとの接続を操作,モデル（テーブル）を取得する -->
<?php

class DatabaseManager
{
    protected $mysqli;
    protected $models;

    //ApplicationクラスからDBへ接続するための処理
    public function connect($params)
    {
        $mysqli = new mysqli($params['hostname'], $params['username'], $params['password'], $params['database']);

        if ($mysqli->connect_error) {
            throw new RuntimeException('mysqli接続エラー:' . $mysqli->connect_error);
        }
        $this->mysqli = $mysqli;
    }

    //モデルの取得
    public function get($modelName)
    {
        if (!isset($this->models[$modelName])) {
            //$modelName → Employeeクラス
            $model = new $modelName($this->mysqli);
            $this->models[$modelName] = $model;
        }

        return $this->models[$modelName];
    }
    //インスタンスが使われなくなったタイミングで自動的にクローズ
    public function __destruct()
    {
        $this->mysqli->close();
    }
}
