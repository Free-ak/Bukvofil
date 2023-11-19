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
	<h2>Снизить на 10% цену на книги по РНР и пересчитать стоимости заказов, в которые входят такие книги.</h2>
	
<?php
ini_set('display_errors', 0);
//$login = $_SESSION['login'];
//$password = $_SESSION['password'];
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}
$login = $_SESSION['login'];
$password = $_SESSION['password'];

$result = mysqli_query($connect,"select customerid from customers inner join login_password using(customerid) where login = '$login' and password = sha1('$password')");
$row = mysqli_fetch_row($result);
$customer_id = $row[0];

function print_order($connect,$login,$password){
	$result4=mysqli_query($connect,"SELECT date, amount, author, title, price, quantity, orderid from customers inner join orders using(customerid) inner join login_password using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') order by orderid");
	$i=0;
$order_id=0;
while($row = mysqli_fetch_row($result4))
{
    if($order_id!=$row[6])
    {
        $i=$i+1;
        echo '<p>';
        echo stripslashes($i);
        echo '. Дата: ';
        echo stripslashes($row[0]);
        echo ' Стоимость: ';
        echo stripslashes($row[1]);
    }
    $order_id = $row[6];
    
    echo '<p>Автор: ';
    echo stripslashes($row[2]);

    echo '  Название: ';
    echo stripslashes($row[3]);

    echo '  Цена: ';
    echo stripslashes($row[4]);

    echo '  Количество: ';
    echo stripslashes($row[5]);
}
echo '<h3>Общая стоимость сделанных заказов: ';
    $result3 = mysqli_query($connect,"SELECT sum(amount) from customers inner join orders using(customerid) inner join login_password using(customerid) where login = '$login' and password = sha1('$password') group by login");
    $row = mysqli_fetch_row($result3);
    echo stripslashes($row[0]);
    echo '</h3>';
}

//наши заказы
$result = mysqli_query($connect,"SELECT * from orders inner join customers using(customerid) inner join login_password using(customerid) where login = '$login' and password = sha1('$password')");
$i=0;
echo '<p><h2>Ваши заказы: </h2>';
print_order($connect,$login,$password);


    $result = mysqli_query($connect,"SELECT distinct(orderid) from order_items inner join books using(isbn) inner join orders using(orderid) inner join customers using(customerid) inner join login_password using(customerid) where title like '%PHP%' and login = '$login' and password = sha1('$password')");

    mysqli_query($connect,"update books set price=price*0.9 where title like '%PHP%'");
    mysqli_query($connect,"update orders inner join (select orderid, sum(quantity*cB.price) as newAmount from order_items join books as cB using (isbn) join orders using (orderId) group by orderID)k set amount = k.newAmount where orders.orderID = k.orderID");
    $row = mysqli_fetch_row($result);
    if(!$row)
    {
        echo '<h2>На ваши заказы скидка не распространяется</h2>';
    }
    else
    {
        $result = mysqli_query($connect,"SELECT * from orders inner join customers using(customerid) inner join login_password using(customerid) where login = '$login' and password = sha1('$password')");

        $i=0;
        echo '<p>Ваши заказы после начисления скидки: </h2>';
        print_order($connect,$login,$password);
    }
	?>

</body>
</html>

