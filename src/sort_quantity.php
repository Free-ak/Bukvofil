<?php
session_start();
?>
<html>
<head>
	<title>Рейтинг продаж</title>
</head>
<body>
	<h1>Рейтинг продаж</h1>
    <a href="index.php">| Вернуться на главную страницу | </a>
	<h2>От самых продаваемых к самым непокупаемым (Выбор за Вами):</h2>

<?php
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
echo 'Ошибка: Не удалось установить соединение с базой данных.';
exit;
}
// $result = mysqli_query($connect,"select * from books");
$result = mysqli_query($connect,"select isbn,author,price,sum(quantity) as summ,title from books inner join order_items using(isbn) group by isbn order by summ desc ");
$i=0;
while($row = mysqli_fetch_row($result))
{
echo '<p><strong>'.($i+1).'. Название: ';
echo stripslashes($row[4]);


echo '</strong><br />Автор: ';
echo stripslashes($row[1]);

echo '<br />ISBN: ';
echo stripslashes($row[0]);

echo '<br />Цена: ';
echo stripslashes($row[2]);

echo '<br />Продано экземпляров: ';
echo stripslashes($row[3]);
echo '</p>';
$i=$i+1;
}
echo '<p>Найдено книг: '.$i.'</p>';
	?>

</body>
</html>

