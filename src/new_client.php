<html lang="ru">
<head>
    <title>������� "��������" - ���������� ����������� ������ �������</title>
</head>
<body>
    <h1>������� "��������" - ���������� ����������� ������ �������</h1>
    <a href="general_page.php">|��������� �� ������� ��������|</a>

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
            echo '�� ����� �� ��� ����������� ��������!';
            exit;
        }
        
        mysqlI_connect('mysql', 'root', 'root');
        if(mysqli_errno())
        {
        echo '������: �� ������� ���������� ���������� � ����� ������';
        exit;
        }
        mysqli_query("SET CHARACTER SET cp1251");
        $result1 = mysqli_query("SELECT * from customers where name = '$name' and city = '$city' and address = '$address'");
        $row = mysqli_fetch_row($result1);
        if($row[0]>0)
        {
            echo '<h3>�� ��� ���������������� � ����� ��������. ��� ����� ',$row[0],'</h3>';
        }
        else
        {
            $result3 = mysqli_query("select * from login_password where login='$login' and password=sha1('$password')");
            $row = mysqli_fetch_row($result3);
            if($row[0]>0)
            {
                echo '<h3>����� ����� � ������ ��� ����������. ������� ������ ��������.</h3>';
                exit;
            }
            $result2 = mysqli_query("insert into customers values(NULL, '$name', '$address', '$city')");
            $result4 = mysqli_query("insert into login_password values(NULL, '$login', sha1('$password'))");
            if($result2 && $result4)
            {
                echo '<h3>�����������! �� ��������� � ���� ���� ������.</h3>';
            }
        }
        mysql_close();
    ?>
</body>
</html>