<html lang="ru">
<head>
    <title>Магазин "Буквофил" - Результаты регистрации нового клиента</title>
</head>
<body>
    <h1>Магазин "Буквофил" - Результаты регистрации нового клиента</h1>
    <a href="index.php">|Вернуться на главную страницу|</a>

    <?php

        $name = $_POST['name'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $login = $_POST['login'];
        $password = $_POST['password'];


       $_SESSION['login'] = $login;
       $_SESSION['password'] = $password;

        
        if(!$name || !$address || !$city || !$login || !$password)
        {
            echo 'Вы ввели не все необходимые сведения!';
            exit;
        }
        
        mysql_connect('localhost', 'root', '');
        mysql_select_db('books');
        if(mysql_errno())
        {
        echo 'Ошибка: Не удалось установить соединение с базой данных';
        exit;
        }
        mysql_query("SET CHARACTER SET cp1251");
        $result1 = mysql_query("SELECT * from customers where name = '$name' and city = '$city' and address = '$address'");

        $row = mysql_fetch_row($result1);
        if($row[0]>0)
        {
            echo '<h3>Вы уже зарегистрированы в нашем магазине. Ваш номер ',$row[0],'</h3>';
        }
        else
        {
            $result3 = mysql_query("select * from login_password where login='$login' and password=sha1('$password')");
            $row = mysql_fetch_row($result3);
            if($row[0]>0)
            {
                echo '<h3>Такие логин и пароль уже существуют. Введите другие значения.</h3>';
                exit;
            }
            $result2 = mysql_query("insert into customers values(NULL, '$name', '$address', '$city')");
            $result4 = mysql_query("insert into login_password values(NULL, '$login', sha1('$password'))");
            if($result2 && $result4)
            {
                echo '<h3>Поздравляем! Вы добавлены в нашу базу данных.</h3>';
            }
        }
        mysql_close();
    ?>
</body>
</html>