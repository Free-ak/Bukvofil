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
$result=mysqli_query($connect,"select MONTH(date) as month,sum(amount) as revenue from orders as o where year(date)=2006 group by month(date) order by 1");
while($row = mysqli_fetch_row($result))
    {
        echo '<p><strong> Месяц: ';
        echo stripslashes($row[0]);
        echo '</strong><br /> Выручка: ';
        echo stripslashes($row[1]);
        echo '</p>';
    }
$result=mysqli_query($connect, "select 'Итого за год' as month, sum(amount) from orders where year(date)=2006");
while($row = mysqli_fetch_row($result)){
   echo '<p><strong>';
            echo stripslashes($row[0]);
            echo '</strong><br /> Выручка: ';
        echo stripslashes($row[1]);
        echo '</p>';
    }
    ?>
</body>
</html>

