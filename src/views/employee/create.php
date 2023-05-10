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

<form action="/employee/create/list" method="post">
    <button type="submit">社員の一覧</button>
</form>
