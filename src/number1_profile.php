<?php
session_start();
?>
<html lang="ru">
<head>
    <title>Задание №1</title>
</head>
<body>
<h1>Задание №1</h1>
<h2>Удалить книгу, которая пользуется наименьшим спросом.</h2>
<a href="index.php">|Вернуться на главную страницу|</a>
<a href="old_client.php">|Вернуться в профиль|</a>

<?php
function print_order($result,$connect,$login,$password){
    $i=0;
    while($row = mysqli_fetch_row($result))
    {
        $i=$i+1;
        echo '<p>';
        echo stripslashes($i);
        echo '. Дата: ';
        echo stripslashes($row[0]);
        echo ' Стоимость: ';         echo stripslashes($row[1]);
        echo '<p>Автор: ';
        echo stripslashes($row[2]);
        echo '<p>Название: ';
        echo stripslashes($row[3]);
        echo ' <p>Цена: ';
        echo stripslashes($row[4]);
        echo '<p>Количество: ';
        echo stripslashes($row[5]);
    }
    echo '<h3>Общая стоимость сделанных заказов: ';
    $result3 = mysqli_query($connect,"SELECT sum(amount) from customers inner join orders using(customerid) inner join login_password using(customerid) where login = '$login' and password = sha1('$password') group by login");
    $row = mysqli_fetch_row($result3);
    echo stripslashes($row[0]);
    echo '</h3>';
}
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
echo'<p><strong/>Заказы до удаления:</strong>';
$result = mysqli_query($connect,"SELECT  date,amount, author, title, price, quantity, orderid, isbn from customers inner join orders using(customerid) inner join login_password using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') order by orderid");
print_order($result,$connect,$login,$password);
$delete=mysqli_query($connect,"select title,order_items.isbn from order_items,books WHERE order_items.isbn=books.isbn group by order_items.isbn order by sum(quantity) limit 1");
while($row=mysqli_fetch_row($delete))
{
    echo 'Книга, которая пользуется наименьшим спросом: ';
    echo stripslashes($row[0]);
    echo ' . Isbn: ';
    echo stripslashes($row[1]);
    echo '</p>';
}
$minzakaz=mysqli_query($connect,"select order_items.isbn from order_items,books WHERE order_items.isbn=books.isbn group by order_items.isbn order by sum(quantity) limit 1");
$minzakaz=mysqli_fetch_row($minzakaz);

$delete=mysqli_query($connect, "delete from books where isbn='$minzakaz[0]'");
mysqli_query($connect,"update orders inner join (select orderid, sum(quantity*cB.price) as newAmount from order_items join books as cB using (isbn) join orders using (orderId) group by orderID)k set amount = k.newAmount where orders.orderID = k.orderID");

$deleteprof=mysqli_query($connect,"SELECT isbn from customers inner join orders using(customerid) inner join login_password using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') and isbn=(select order_items.isbn from order_items,books WHERE order_items.isbn=books.isbn group by order_items.isbn order by sum(quantity) limit 1)");
$row = mysqli_fetch_row($deleteprof);
if($row [0]>=1) {
    echo'<p>Информация о сделанных заказах:';
    $result = mysqli_query($connect, "SELECT  date,amount, author, title, price, quantity, orderid from customers inner join orders using(customerid) inner join login_password using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') order by orderid");
    print_order($result,$connect,$login,$password);
}
else {
    echo '<p><h2>К счастью, Вы не купили книгу, которая пользуется наименьшим спросом.';
}
mysqli_close($connect);
?>

</body>
</html>
