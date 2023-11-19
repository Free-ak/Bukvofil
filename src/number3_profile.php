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
	<h2>Подсчитать cуммы заказов за каждый месяц 2006 года и сумму заказов за этот год. </h2>

<?php
ini_set('display_errors', 0);
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных';
    exit;
}
$login = $_SESSION['login'];
$password = $_SESSION['password'];
echo ($login);
echo ($password);
$i=0;
$result = mysqli_query($connect,"select month(date), sum(amount) from login_password inner join orders using(customerid) where year(date) = 2006 and login = '$login' and password = sha1('$password') group by month(date) order by 1");
$row1 = mysqli_fetch_row($result);
if ($row1[0]>0)
{
     echo '<br />Сумма заказов по месяцам за 2006 год:';
     $result = mysqli_query($connect,"select month(date), sum(amount) from login_password inner join orders using(customerid) where year(date) = 2006 and login = '$login' and password = sha1('$password') group by month(date) order by 1");
    $sum=0;
     while($row1 = mysqli_fetch_row($result))
    {
    echo '<br /><strong>Месяц: </strong>';
    echo stripslashes($row1[0]);
    echo '<br />Вы заказали на: ';
    echo stripslashes($row1[1]).' руб.'; 
    $sum+=$row1[1];
	$i++;
    } 
    echo '<br /><strong>Итого сумма  заказов за год:</strong> '.$sum;
}
else{
	echo '<br />Вы ничего не купили в 2006году';
}

            

mysqli_close($connect);
	?>

</body>
</html>

