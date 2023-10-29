<html lang="ru">
<head>
    <title>Магазин "Буквофил" - Результаты регистрации нового клиента</title>
</head>
<body>
    <h1>Магазин "Буквофил" - Результаты регистрации нового клиента</h1>
    <a href="general_page.php">|Вернуться на главную страницу|</a>

    <?php

        $name = $_POST['name'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $login = $_POST['login'];
        $password = $_POST['password'];
/*
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;

        */
        if(!$name || !$address || !$city || !$login || !$password)
        {
            echo 'Вы ввели не все необходимые сведения!';
            exit;
        }
        
        mysqlI_connect('mysql', 'root', 'root');
        if(mysqli_errno())
        {
        echo 'Ошибка: Не удалось установить соединение с базой данных';
        exit;
        }
        mysqli_query("SET CHARACTER SET cp1251");
        $result1 = mysqli_query("SELECT * from customers where name = '$name' and city = '$city' and address = '$address'");
        $row = mysqli_fetch_row($result1);
        if($row[0]>0)
        {
            echo '<h3>Вы уже зарегистрированы в нашем магазине. Ваш номер ',$row[0],'</h3>';
        }
        else
        {
            $result3 = mysqli_query("select * from login_password where login='$login' and password=sha1('$password')");
            $row = mysqli_fetch_row($result3);
            if($row[0]>0)
            {
                echo '<h3>Такие логин и пароль уже существуют. Введите другие значения.</h3>';
                exit;
            }
            $result2 = mysqli_query("insert into customers values(NULL, '$name', '$address', '$city')");
            $result4 = mysqli_query("insert into login_password values(NULL, '$login', sha1('$password'))");
            if($result2 && $result4)
            {
                echo '<h3>Поздравляем! Вы добавлены в нашу базу данных.</h3>';
            }
        }
        mysql_close();
    ?>
</body>
</html>