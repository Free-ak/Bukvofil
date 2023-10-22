<?php
session_start();
?>
<html>
<head>
	<title>Задание №2</title>
</head>
<body>
	<h1>Задание №2</h1>
    <a href="old_client.php">| Вернуться в профиль | </a>
	<h2>Расположите книги в порядке убывания проданных экземпляров в 2006г</h2>

<?php
//$login = $_SESSION['login'];
//$password = $_SESSION['password'];
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}
$result = mysqli_query($connect,"SELECT title, sum(quantity) from customers join login_password using(customerid) join orders using(customerid) join order_items using(orderid) join books using(isbn) where year(date) = 2006 and login = '$login' and password = sha1('$password') group by 1 order by 2 desc");

$i=0;

while($row = mysqli_fetch_row($result))
{
echo '<p><strong>'.($i+1).'. Название книги: ';
echo stripslashes($row[0]);


echo '</strong><br />Количество заказов книги: ';
echo stripslashes($row[1]);

echo '</p>';
$i=$i+1;
}
echo '<p>Найдено книг: '.$i.'</p>';
mysqli_close();
	?>

</body>
</html>

