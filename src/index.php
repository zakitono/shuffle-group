<?php
$groups = [];
$mysqli = new mysqli('db', 'test_user', 'pass', 'test_database');
if ($mysqli->connect_error) {
    throw new RuntimeException('mysqli接続エラー:' . $mysqli->connect_error);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>シャッフルグループ</title>
</head>

<body>
    <h1>
        <a href="index.php">シャッフルグループ</a>
    </h1>
    <a href="employee.php">社員を登録する</a>

    <form action="index.php" method="post">
        <button type="submit">シャッフルする</button>
    </form>

    <?php foreach ($groups as $i => $group) : ?>
        <h3>
            グループ<?php echo ($i + 1); ?>
        </h3>
        <p>
            <?php foreach ($group as $employee) : ?>
                <?php echo $employee['name']; ?>
            <?php endforeach; ?>
        </p>
    <?php endforeach; ?>
</body>

</html>
