<?php
$errors = [];
#データベースに接続する
$mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
if ($mysqli->connect_error) {
    throw new RuntimeException('mysqli接続エラー:' . $mysqli->connect_error);
}

$result = $mysqli->query('SELECT name FROM employees');
$employees = $result->fetch_all(MYSQLI_ASSOC);

#POSTされたデータを保存する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    #バリデーション
    if (!strlen($_POST['name'])) {
        if (!strlen($_POST['name'])) {
            $errors['name'] = '社員名を入力してください。';
        } elseif (strlen($_POST['name']) > 100) {
            $errors['name'] = '社員名は100文字以内で入力してください。';
        }
    }
    if (!count($errors)) {
        $stmt = $mysqli->prepare('INSERT INTO employees (name) VALUES(?)');
        $stmt->bind_param('s', $_POST['name']);
        $stmt->execute();
        $stmt->close();
        #リダイレクト
        header('Location: /employee.php');
    }
}

include __DIR__ . '/views/employee.php';
