<?php
session_start();
?>
<html lang="ru">
<head>
    <title>Вас приветствует магазин "Буквофил"!</title>
</head>
<body>
    <h1>Вас приветствует магазин "Буквофил"!</h1>
    <form action="old_client.php" method="post">
    <a href="search.html">| Поиск книг по ISBN, автору, названию| </a>
    <a href="sort_price.php">| Сортировка книг по цене | </a>
    <a href="sort_quantity.php">| Сортировка книг по рейтингу продаж |</a>
    <a href="number1.php">| Задание №1 |</a>
    <a href="number2.php">| Задание №2 |</a>
    <a href="number3.php">| Задание №3 |</a>
    <a href="vost.php">| Восстановление БД |</a>
        <h2>Вход для зарегистрированных клиентов:</h2>
        <table border=0>
            <tr>
                <td>Логин</td>
                <td align="center"> <input type="text" name="login" size="30" maxlength="50" /></td>
                <td>Пароль</td>
                <td align="center"> <input type="password" name="password" size="30" maxlength="50" /></td>
                <td align="center"> <input type="submit" value="Войти" /></td>
            </tr>
        </table>
        <a href="registration.html">Зарегистрироваться</a>
    <h2>Сегодня в продаже:</h2>
    <?php
    ini_set('display_errors', 0);
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

        $url = 'more_book_information.php?isbn='.($row[0]);
        echo '<br /><a href='.$url.'>Подробнее...</a>';
        echo '</p>';
        $i=$i+1;
    }
    echo '<p>Найдено книг: '.$i.'</p>';
   
    ?>
</body>
</html>

