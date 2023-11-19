<html>
<head>
	<title>Задание №1</title>
</head>
<body>
	<h1>Задание №1</h1>
    <a href="index.php">| Вернуться на главную страницу | </a>
	<h2>Удалить книгу, которая пользуется наименьшим спросом.</h2>

<?php
ini_set('display_errors', 0);
# echo stripslashes($login);
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}
echo'До удаления:';
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
$delete=mysqli_query($connect,"select title,order_items.isbn from order_items,books WHERE order_items.isbn=books.isbn group by order_items.isbn order by sum(quantity) limit 1;");
while($row=mysqli_fetch_row($delete))
    {
        echo 'Книга, которая пользуется наименьшим спросом: ';
        echo stripslashes($row[0]);
        echo ' . Isbn: ';
        echo stripslashes($row[1]);
        echo '</p>';
}
mysqli_query($connect,"delete from books where isbn IN (select * from(select isbn from order_items group by isbn order by sum(quantity) limit 1) as oli)");
$result=mysqli_query($connect,"select * from books");
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

