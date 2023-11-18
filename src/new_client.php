<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Магазин "Буквофил"</title>
</head>
<body>
    <h1>Результаты регистрации нового клиента </h1>
    <a href="index.php">|Вернуться на главную страницу|</a>
    <?php
        error_reporting(0);
        $name = $_POST['name'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $login = $_POST['login'];
        $password = $_POST['password'];
        $connect = mysqli_connect('mysql', 'root', 'root','books');
        if(!$name || !$address || !$city || !$login || !$password) {
            echo 'Вы ввели не все необходимые сведения!';
            exit;
            }
        if (mysqli_errno($connect)) {
            echo 'Ошибка: Не удалось установить соединение с базой данных';
            exit;
        }
        $result1 = mysqli_query($connect, "SELECT * from customers where name = '$name' and city = '$city' and address = '$address'");
        $row = mysqli_fetch_row($result1);
        if ($row[0] > 0) {
            echo '<h3>Вы уже зарегистрированы в нашем магазине. Ваш номер ', $row[0], '</h3>';
            }
        else {
                $result3 = mysqli_query($connect, "select * from login_password where login='$login' and password=sha1('$password')");
                $row = mysqli_fetch_row($result3);
                if ($row[0] > 0)
                {
                    echo '<h3>Такие логин и пароль уже существуют. Введите другие значения.</h3>';
                    exit;
                }
                $result2 = mysqli_query($connect, "insert into customers values(NULL, '$name', '$address', '$city')");
                $result4 = mysqli_query($connect, "insert into login_password values(NULL, '$login', sha1('$password'))");
                if ($result2 && $result4) {
                    echo '<h3>Поздравляем! Вы добавлены в нашу базу данных.</h3>';
                }
            }
        mysqli_close($connect);
    ?>
</body>
</html>