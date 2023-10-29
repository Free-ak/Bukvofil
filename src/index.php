<?php
session_start();
?>
<html lang="">
<head>
    <title>Вас приветствует магазин "Буквофил"!</title>
</head>
<body>
<form action="index.php" ">
    <h1>Вас приветствует магазин "Буквофил"!</h1>
    <a href="search.html">| Поиск книг по ISBN, автору, названию| </a>
    <a href="sort_price.php">| Сортировка книг по цене | </a>
    <a href="sort_quantity.php">| Сортировка книг по рейтингу продаж |</a>
    <a href="number1.php">| Задание №1 |</a>
    <a href="number2.php">| Задание №2 |</a>
    <a href="number3.php">| Задание №3 |</a>
    <a href="vost.php">| Восстановление БД |</a>
    <h2>Сегодня в продаже:</h2>
    <?php
    $connect=mysqli_connect('mysql', 'root', 'root','books');
    if(mysqli_errno($connect))
    {
        echo 'Ошибка: Не удалось установить соединение с базой данных.';
        exit;
    }
    $result = mysqli_query($connect,"select * from books");
    $i=0;
    while($row = mysqli_fetch_row($result))
    {
        echo '<p><strong>'.($i+1).'. Название: ';
        echo stripslashes($row[2]);

        echo '</strong><br />Автор: ';
        echo stripslashes($row[1]);

        echo '<br />ISBN: ';
        echo stripslashes($row[0]);

        echo '<br />Цена: ';
        echo stripslashes($row[3]);


        echo '</p>';
        $i=$i+1;
    }
    echo '<p>Найдено книг: '.$i.'</p>';
    ?>
</body>
</html>

