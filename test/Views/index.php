<?php
/**
 * @var null|array $statistic
 */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div>
    <a href="/start">Запустить</a>
    <br>
    <?php if ($statistic): ?>
        <table>
            <thead>
            <tr>
                <td>Минута выполнения</td>
                <td>Количество выполнений</td>
                <td>Среднее количество символов</td>
                <td>Время первого сообщения</td>
                <td>Время последнего сообщения</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($statistic as $item): ?>
                <tr>
                    <td><?= $item['minute'] ?></td>
                    <td><?= $item['row_count'] ?></td>
                    <td><?= $item['avg_length'] ?></td>
                    <td><?= $item['first_message_time'] ?></td>
                    <td><?= $item['last_message_time'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>