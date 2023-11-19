<?php
session_start();
?>
<html lang="ru">
<head>
    <title>Магазин "Буквофил" - Результаты регистрации нового клиента</title>
</head>
<body>
<h1>Магазин "Буквофил" - Результаты регистрации нового клиента</h1>
<a href="index.php">|Вернуться на главную страницу|</a>

<?php
# ini_set('display_errors', 0);
getenv("HTTP_REFERER");
$a = $_SERVER['HTTP_REFERER'];
if ($a == "http://localhost/index.php")
{
    $login = $_POST['login'];
    $password = $_POST['password'];
    if(!$login || !$password)
    {
        echo '<p>Введите логин и пароль!';
        exit;
    }
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
}
else
{
    $login = $_SESSION['login'];
    $password = $_SESSION['password'];
}
$flag = $_SESSION['flag'];
# //echo ($login);
# //echo ($password);
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных';
    exit;
}

$result1 = mysqli_query($connect,"SELECT * from login_password where login='$login' and password= sha1('$password')");
$row = mysqli_fetch_row($result1);
if($row[0]<=0)
{
    echo '<h3>Логин и пароль неверны!</h3>';
    exit;
}
else
{
    echo '<h3>Вам повезло! Логин и пароль верны! Вам предоставляется информация о сделанных заказах:</h3>';
    echo $login;
    echo $password;
    $result4 = mysqli_query($connect,"SELECT  date,amount, author, title, price, quantity, orderid from customers inner join orders using(customerid) inner join login_password using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') order by orderid");
    $i=0;
    $order_id = 1;
    while($row = mysqli_fetch_row($result4))
    {

            $i=$i+1;
            echo '<p>';
            echo stripslashes($i);
            echo '. Дата: ';
            echo stripslashes($row[0]);
            echo ' Стоимость: ';
            echo stripslashes($row[1]);
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
?>
<a href="number1_profile.php">|Задание 1|</a>
<a href="number2_profile.php">|Задание 2|</a>
<a href="number3_profile.php">|Задание 3|</a>
</body>
</html>