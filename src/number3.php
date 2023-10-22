<?php
session_start();
?>
<html>
<head>
	<title>Задание №3</title>
</head>
<body>
	<h1>Задание №3</h1>
    <a href="index.php">| Вернуться на главную страницу | </a>
	<h2>Подсчитать магазина выручку за каждый месяц 2006 года и общую выручку за этот год. </h2>

<?php
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}
$result=mysqli_query($connect,"select MONTH(date) as month,sum(amount) as revenue from orders as O where year(date)=2006 group by month(date) union  select 13 as month, sum(amount) from orders where year(date)=2006 order by 1");
$i=0;
while($row = mysqli_fetch_row($result))
{
echo '<p><strong> Месяц: ';
echo stripslashes($row[0]);
echo '</strong><br /> Выручка: ';
echo stripslashes($row[1]);
echo '</p>';
$i=$i+1;
}
	?>

</body>
</html>

