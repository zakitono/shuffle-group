<p><a href="/employee">社員を登録する</a></p>
<p><a href="/">シャッフルする</a></p>

<h2>社員の一覧</h2>
<ul>
    <?php foreach ($employees as $employee) : ?>
        <li><?php echo $employee['name']; ?></li>
    <?php endforeach; ?>
</ul>
