<html>
<head>
	<title>Магазин "Буквофил" - Оформление заказа</title>
</head>
<body>
<a href="index.php">| Вернуться на главную страницу| </a>
<a href="zakaz.php">| Вернуться на прошлую страницу| </a>
	<h1>Магазин "Буквофил" - Оформление заказа</h1>
	<form action="add_zakaz.php" method = post>
		<?php
		$isbn=$_POST['isbn'];
		$quantity=(int)$_POST['quantity'];
//		$login = $_POST['login'];
//		$password = $_POST['password'];
		$amount = (float)$_POST['amount'];

//		if (!$login || !$password)
//		{
//			echo 'Вы не заполнили поля логина и пароля на предыдущей странице!';
//			exit;
//		}

        $connect=mysqli_connect('mysql', 'root', 'root','books');
        if(mysqli_errno($connect))
        {
            echo 'Ошибка: Не удалось установить соединение с базой данных.';
            exit;
        }
		$result1 = mysqli_query($connect,"SELECT * from login_password where login='$login' and password=sha1('$password')");

        $row = mysqli_fetch_row($result1);
        if($row[0]==0)
        {
            echo 'Вы не зарегистрированный!';
			exit;
        }
		
		
			$customerid = $row[0];
			$result3 = mysqli_query($connect,"INSERT into orders values(NULL, '$customerid', '$amount', 'CURRENT_DATE')");
			$result2 = mysqli_query($connect,"SELECT orderid from orders order by orderid desc");
			while($row = mysqli_fetch_row($result2))
			{
			$orderid = $row[0];
			}
			//echo stripslashes($orderid);
			$result4 = mysqli_query($connect,"INSERT into order_items values('$orderid', '$isbn', '$quantity')");
			if(!$result3||!$result4)
			{
				echo 'Ошибка!';
				exit;
			}
			else
			{
				echo 'Поздравляем! Ваш заказ принят.';
			}
		//$result = mysql_query("SELECT price from books where isbn = '$isbn'");
        mysqli_close($connect);
		?>
	</form>
</body>
</html>