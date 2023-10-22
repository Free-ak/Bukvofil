<?php
session_start();
?>
<html>
<head>
	<title>Задание №1</title>
</head>
<body>
	<h1>Задание №1</h1>
    <a href="old_client.php">| Вернуться в профиль | </a>
	<h2>Добавить к таблице customer поле VIP, которое характеризует активность клиента. Присвоить клиентам значения VIP1, если клиент сделал заказы на сумму<1000р., VIP2 – 1000-2000р., VIP3>2000р.:</h2>

<?php

/*$login = $_POST['login'];
$password = $_POST['password'];*/
//$logg = $_SESSION['log'];
//$pas = $_SESSION['pass'];
//
//$login = $_SESSION['login'];
//$password = $_SESSION['password'];
//
//

$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}
mysql_query("SET CHARACTER SET cp1251");
mysql_query("ALTER TABLE customers ADD vip char(4)");
mysql_query("UPDATE customers set vip = IF(customerid IN (SELECT customerid from orders group by customerid having sum(amount)<1000), 'vip', IF(customerid IN (SELECT customerid from orders group by customerid having sum(amount)<2000),'vip2', 'vip3'))");

$result = mysql_query("select sum(amount), vip from orders inner join customers using(customerid) inner join login_password using(customerid) where login = '$login' and password = sha1('$password')  group by name");
$i=0;
while($row = mysql_fetch_row($result))
{
echo '<p><strong>'.($i+1).'. Сумма вашего заказа: ';
echo stripslashes($row[0]);


echo '</strong><br />Вам присвоин статус vip: ';
echo stripslashes($row[1]);

echo '</p>';
$i=$i+1;
}

mysql_close();
	?>

</body>
</html>

