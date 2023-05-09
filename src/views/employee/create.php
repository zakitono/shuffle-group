<!-- リロードしてくださいの文言表示のためだけに作成 -->
<!-- リファクタリング必要 -->
<h2>社員の登録</h2>

<?php if (count($errors)) : ?>
    <ul>
        <?php foreach ($errors as $error) : ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <h3><?php echo $register; ?></h3>
<?php endif; ?>

<form action="create" method="post">
    <div>
        <label for="name">社員名</label>
        <input type="text" name="name">
    </div>
    <button type="submit">登録する</button>
</form>
<h2>社員の一覧</h2>
<ul>
    <?php foreach ($employees as $employee) : ?>
        <li><?php echo $employee['name']; ?></li>
    <?php endforeach; ?>
</ul>
