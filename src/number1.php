<html>
<head>
	<title>Задание №1</title>
</head>
<body>
	<h1>Задание №1</h1>
    <a href="index.php">| Вернуться на главную страницу | </a>
	<h2>Удалить книгу, которая пользуется наименьшим спросом.</h2>

<?php

//echo stripslashes($login);
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}

$result = mysqli_query($connect,"delete from order_items where isbn IN (select * from (select isbn from order_items group by isbn order by sum(quantity) limit 1) as oii)");
echo 'Успешно удалено!';
	?>

</body>
</html>

