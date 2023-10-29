<?php
session_start();
?>
<html>
<head>
    <title>Магазин "Буквофил" - История ваших покупок</title>
</head>
<body>
    
<a href="general_page.php">| Вернуться на главную страницу| </a>
    
    <?php

        getenv("HTP_REFERER");
        $vs = $_SERVER['HTTP_REFERER'];
        if ($vs == "http://localhost/general_page.php")
        {
            $login = $_POST['login'];
            $password = $_POST['password'];
            if(!$login || !$password)
            {
                echo 'Вы ввели не все необходимые сведения!';
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
       
      
        mysql_connect('localhost', 'root', '');
        mysql_select_db('books');
        if(mysql_errno())
        {
        echo 'Ошибка: Не удалось установить соединение с базой данных';
        exit;
        }
        mysql_query("SET CHARACTER SET cp1251");
       if ($login == 'admin' && $password == 'admin')
       {
       
    
      
        ?>
        <form action="sales.php" method = post>
        <h1>Магазин "Буквофил" - Панель администратора</h1>
        <form action="sales.php" method = post> 
        <table border=0>
                <tr>
                <td>Начало распродажи</td>
				<td align="center"><input type="date" name="start_sale" size="30" maxlength="50" /></td>
				<td>Пароль</td>
				<td align="center"><input type="date" name="stop_sale" size="30" maxlength="50" /></td>
                    <td align="center"><input type="submit" value = "Устроить распродажу!" /></td>
                    
                </tr>
    
            </table>
        </form>
        <form action="no_sales.php" method = post> 
        <table border=0>
                <tr>
                    
                    <td align="center"><input type="submit" value = "Завершить распродажу!" /></td>
                    
                </tr>
    
            </table>
        </form>
            <?php

        
$start_sale = $_SESSION['start_sale'];
$stop_sale = $_SESSION['stop_sale'];

    $result6 = mysql_query("select date, sum(quantity) from order_items join orders using(orderid) where date >= '$start_sale' and date < '$stop_sale'");
 while($row = mysql_fetch_row($result6))
{

echo '<p><strong>'.'Объем продаж во время распродажи: ';
echo stripslashes($row[1]);
$price = $row[1];
}

      

    $result6 = mysql_query("select date, sum(quantity) from order_items join orders using(orderid) where year(date) = year('$start_sale') and  month(date) >= month('$start_sale')-1 and month(date) < month('$start_sale')");

while($row = mysql_fetch_row($result6))
{

echo '<p><strong>'.'Объем продаж за месяц до распродажи: ';
echo stripslashes($row[1]);
$price1 = $row[1];
}



 $proc = $price/$price1 * 100 - 100;
echo '<p><strong>'.'Продажи увеличились на '.floor($proc).' %';

       } 
        else{
           

            ?>
            <h1>Магазин "Буквофил" - История ваших покупок</h1>
    
    <a href="number1_profile.php?login=<?php echo $login, $password; ?>">| Задание №1 | </a>
    <a href="number2_profile.php">| Задание №2 | </a>
    <a href="number3_profile.php">| Задание №3 | </a>
   
            <?php
        $result5 = mysql_query("select * from login_password where login = '$login' and password =sha1('$password')");
        $row = mysql_fetch_row($result5);
        if($row[0]<=0)
        {
            
            echo '<h3>Логин и пароль неверны!</h3>';
        }
       
        else
        {
            echo '<h3>Вам повезло! Логин и пароль верны! Вам предоставляется информация о сделанных заказах:</h3>';
          
            
                $result6 = mysql_query("select date, amount from login_password inner join orders using(customerid) inner join order_items using(orderid) inner join book_sales using(isbn) where login = '$login' and password = sha1('$password') and date >= '$start_sale' and date < '$stop_sale'  group by date");
          
            $s = 0;
            $i=0;
            $s1 =0;

            while($row = mysql_fetch_row($result6))
            {
            
            echo '<p><strong>'.($i+1).'.Дата: ';
            echo stripslashes($row[0]);

            echo '</strong> Стоимость: ';
            echo stripslashes($row[1]);
            $s+=$row[1];
            $result9 = mysql_query("select author, title, price, quantity  from login_password inner join orders using(customerid) inner join order_items using(orderid) inner join book_sales using(isbn) where login = '$login' and password = sha1('$password') and month(date) >= month('$start_sale')-1 and month(date) <= month('$start_sale')'");
            while($row1 = mysql_fetch_row($result9))
            {
            echo '<br />';
            echo '<br />Автор: ';
            echo stripslashes($row1[0]);

            echo '<br />Название: ';
            echo stripslashes($row1[1]);

            echo '<br />Цена: ';
            echo stripslashes($row1[2]);

            echo '<br />Количество: ';
            echo stripslashes($row1[3]);

            }
            $i++;
            
            $summ = 0;
            $result7 = mysql_query("select date, amount from login_password inner join orders using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') and date != CURRENT_DATE() group by date");
            while($row = mysql_fetch_row($result7))
            {
            
            echo '<p><strong>'.($i+1).'.Дата: ';
            echo stripslashes($row[0]);

            echo '</strong> Стоимость: ';
            echo stripslashes($row[1]);
            $summ+=$row[1];
            $result8 = mysql_query("select author, title, price, quantity  from login_password inner join orders using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') and date = '$row[0]'");
            while($row1 = mysql_fetch_row($result8))
            {
            echo '<br />';
            echo '<br />Автор: ';
            echo stripslashes($row1[0]);

            echo '<br />Название: ';
            echo stripslashes($row1[1]);

            echo '<br />Цена: ';
            echo stripslashes($row1[2]);

            echo '<br />Количество: ';
            echo stripslashes($row1[3]);
            }
            }
            $i++;
        
            echo '</p>';
            $s+=$summ;
            //$ss = $s1+$s;
            }
            echo '<p><strong>Общая сумма сделанных заказов: '.$s.'</p>';
            
        }
        
        }
        mysql_close();
?>
       
  

</body>
</html>