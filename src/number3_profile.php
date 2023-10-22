<?php
session_start();
?>
<html>
<head>
	<title>Задание №3</title>
</head>
<body>
	<h1>Задание №3</h1>
    <a href="old_client.php">| Вернуться в профиль | </a>
	<h2>Увеличить стоимость заказа клиентов на 500р (за доставку), если сумма заказа <1000р. Подсчитать сумму вырученную за доставку. </h2>

<?php
//$login = $_SESSION['login'];
//$password = $_SESSION['password'];
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}
mysqli_query($connect,"ALTER table orders add delivery int");

mysqli_query($connect,"UPDATE orders inner join (select customerid, sum(amount) as s from orders group by customerid)k using(customerid) set delivery= IF(k.s<1000,500,0)");

$result = mysql_query("SELECT orderid, sum(amount), delivery  from orders join login_password using(customerid) where login = '$login' and password = sha1('$password')");

$i=0;
while($row = mysqli_fetch_row($result))
{
echo '<p></strong>'.'Id заказа: ';
echo stripslashes($row[0]);


echo '<strong><br />Сумма заказа: ';
echo stripslashes($row[1]);

echo '<strong><br />Цена доставки: ';
echo stripslashes($row[2]);



echo '</p>';
$i=$i+1;
}

mysqli_close();
	?>

</body>
</html>

