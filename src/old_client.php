<?php
session_start();
?>
<html>
<head>
    <title>Магазин "Буквофил" - История ваших покупок</title>
</head>
<body>
    
    <h1>Магазин "Буквофил" - История ваших покупок</h1>
    <a href="index.php">| Вернуться на главную страницу| </a>
    <a href="number1_profile.php?login=<?php echo $login, $password; ?>">| Задание №1 | </a>
    <a href="number2_profile.php">| Задание №2 | </a>
    <a href="number3_profile.php">| Задание №3 | </a>
    
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
       

        
       
      


       

        mysql_connect('localhost', 'root', '');
        mysql_select_db('books');
        if(mysql_errno())
        {
        echo 'Ошибка: Не удалось установить соединение с базой данных';
        exit;
        }
        mysql_query("SET CHARACTER SET cp1251");
        $result5 = mysql_query("select * from login_password where login = '$login' and password =sha1('$password')");
        $row = mysql_fetch_row($result5);
        if($row[0]<=0)
        {
            
            echo '<h3>Логин и пароль неверны!</h3>';
        }
        else
        {
            echo '<h3>Вам повезло! Логин и пароль верны! Вам предоставляется информация о сделанных заказах:</h3>';
            $result6 = mysql_query("select date, amount from login_password inner join orders using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') group by date");
            $s = 0;
            $i=0;
           
            while($row = mysql_fetch_row($result6))
            {
            
            echo '<p><strong>'.($i+1).'.Дата: ';
            echo stripslashes($row[0]);

            echo '</strong> Стоимость: ';
            echo stripslashes($row[1]);
            $result7 = mysql_query("select author, title, price, quantity  from login_password inner join orders using(customerid) inner join order_items using(orderid) inner join books using(isbn) where login = '$login' and password = sha1('$password') and date = '$row[0]'");
            while($row1 = mysql_fetch_row($result7))
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

            

            echo '</p>';
            $s=$s+$row[1];
            }
            echo '<p><strong>Общая сумма сделанных заказов: '.$s.'</p>';
            
        }
        
       
        mysql_close();

       
    ?>
    
</body>
</html>