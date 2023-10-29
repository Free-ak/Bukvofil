<?php
session_start();
?>
<html>
<head>
	<title>Задание №2</title>
</head>
<body>
	<h1>Задание №2</h1>
    <a href="index.php">| Вернуться на главную страницу | </a>
	<h2>Снизить на 10% цену на книги по РНР и пересчитать стоимости заказов, в которые входят такие книги.</h2>

<?php
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}
echo' Цены до скидки';
$result=mysqli_query($connect,'select * from orders');
$i=0;
while($row = mysqli_fetch_row($result))
{
	echo '<p><strong> Id заказа: ';
	echo stripslashes($row[0]);

	echo '</strong><br />Id заказчика: ';
	echo stripslashes($row[1]);

	echo '</strong><br />Сумма заказа: ';
	echo stripslashes($row[2]);
	echo '</strong><br />Дата: ';
	echo stripslashes($row[3]);
	echo '</p>';
	$i=$i+1;
}
    mysqli_query($connect,'update orders inner join (select orderid, sum(quantity*cB.price) as newAmount from order_items join books as cB using (isbn) join orders using (orderId) group by orderID)k set amount = k.newAmount where orders.orderID = k.orderID');
    echo' Цены со скидкой';
    $result=mysqli_query($connect,'select * from orders');
    $i=0;
    while($row = mysqli_fetch_row($result))
    {
    echo '<p><strong> Id заказа: ';
            echo stripslashes($row[0]);

            echo '</strong><br />Id заказчика: ';
        echo stripslashes($row[1]);

        echo '</strong><br />Сумма заказа: ';
        echo stripslashes($row[2]);
        echo '</strong><br />Дата: ';
        echo stripslashes($row[3]);
        echo '</p>';
    $i=$i+1;
    }
    ?>
</body>
</html>

