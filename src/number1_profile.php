<?php
 session_start();
?>

<html>
<head>
	<title>Задание №1</title>
</head>
<body>
	<h1>Задание №1</h1>
    <a href="index.php">| Вернуться на главную страницу | </a>
    <a href="old_client.php">|Вернуться в профиль|</a>
	<h2>Удалить книгу, которая пользуется наименьшим спросом.</h2>

<?php
ini_set('display_errors', 0);
# echo stripslashes($login);
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных';
    exit;
}
$login = $_SESSION['login'];
$password = $_SESSION['password'];
#echo stripslashes($login);
#echo stripslashes($password);

$result = mysqli_query($connect,"select customerid from customers inner join login_password using(customerid) where login = '$login' and password = sha1('$password')");
$row = mysqli_fetch_row($result);
$customer_id = $row[0];

//заказы до удаления
echo 'Ваши заказы до удаления книги, которая пользуется наименьшим спросом.';
$result4 = mysqli_query($connect,"SELECT date, amount, author, title, price, quantity, orderid from customers inner join orders using(customerid) inner join login_password using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') order by orderid");
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
$delete=mysqli_query($connect,"select title,order_items.isbn from order_items,books WHERE order_items.isbn=books.isbn group by order_items.isbn order by sum(quantity) limit 1;");

while($roww=mysqli_fetch_row($delete))
    {
        echo '<p></p><strong/>Книга, которая пользуется наименьшим спросом: </strong>';
        echo stripslashes($roww[0]);
        echo ' . Isbn: ';
        $isbn = $roww[1];
        echo stripslashes($isbn);
        echo '</p>';
}
$result=mysqli_query($connect,"SELECT * FROM orders inner join order_items using(orderid) where customerid = $customer_id and isbn = '$isbn'");
$row = mysqli_fetch_row($result);

$delete = mysqli_query($connect,'select * from(select isbn from order_items group by isbn order by sum(quantity) limit 1) as oli');
$delete_row = mysqli_fetch_row($delete);
mysqli_query($connect,"delete from books where isbn IN ('$delete_row[0]')");
mysqli_query($connect,"delete from order_items where isbn IN ('$delete_row[0]')");
mysqli_query($connect,"delete from book_reviews where isbn IN ('$delete_row[0]')");
mysqli_query($connect,"update orders inner join (select orderid, sum(quantity*cB.price) as newAmount from order_items join books as cB using (isbn) join orders using (orderId) group by orderID)k set amount = k.newAmount where orders.orderID = k.orderID");
    

if($row[0]<=0)
{
    echo '<h3>Ваши заказы остались без изменения!</h3>';
    exit;
}
else
{
    echo 'Ваши заказы после удаления книги, которая пользуется наименьшим спросом.';

    //заказы после удаления
    $result4 = mysqli_query($connect,"SELECT date, amount, author, title, price, quantity, orderid from customers inner join orders using(customerid) inner join login_password using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') order by orderid");
    $i=0;
    
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

}
echo '<h3>Общая стоимость сделанных заказов: ';
    $result3 = mysqli_query($connect,"SELECT sum(amount) from customers inner join orders using(customerid) inner join login_password using(customerid) where login = '$login' and password = sha1('$password') group by login");
    $row = mysqli_fetch_row($result3);
    echo stripslashes($row[0]);
    echo '</h3>';
    ?>
</body>
</html>