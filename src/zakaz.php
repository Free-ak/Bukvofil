<html>
<head>
	<title>Магазин "Буквофил" - Подтверждение заказа книги</title>
</head>
<body>
<a href="index.php">| Вернуться на главную страницу| </a>
<a href="more_book_information.php">| Вернуться на прошлую страницу| </a>
	<h1>Магазин "Буквофил" - Подтверждение заказа книги</h1>
	<form action="add_zakaz.php" method = post>
		<?php
		$isbn=$_POST['isbn'];
		$quantity=(int)$_POST['quantity'];
		if ($quantity<=0)
		{
			echo 'Вы ничего не заказали на предыдущей странице!';
			exit;
		}
		echo '<p><strong>Вы пожелали заказать книгу';
		echo '<input type = "text" name ="isbn" value='.$isbn.' size="13" maxlength="13"/> ';
		echo 'в количестве: ';
		echo '<input type = "text" name ="quantity" value='.$quantity.' size="13" maxlength="13"/> ';
		echo 'экземпляров </strong>';

        $connect=mysqli_connect('mysql', 'root', 'root','books');
		if(mysqli_errno($connect))
		{
		echo 'Ошибка: Не удалось установить соединение с базой данных.';
		exit;
		}
		$result = mysqli_query($connect,"SELECT price from books where isbn = '$isbn'");
		while($row = mysqli_fetch_row($result))
		{
			$price = $row[0];
		}
		$amount = $quantity*$price;
		echo '<p><strong>Сумма заказа составит:';
		echo '<input type = "text" name ="amount" value='.$amount.' size="13" maxlength="13"/> ';
		echo 'руб. !!!</strong>';
//		echo '</br>Для подтверждение заказа введите свои логин и пароль, ';
//		echo 'а если вы не зарегистрированы в нашем магазине, ';
//		echo 'то перед оформлением заказа пройдите регистрацию на главной странице.';
//
		?>

<!--		<table border=0>-->
<!--			<tr>-->
<!--				<td>Логин</td>-->
<!--				<td align="center"><input type="text" name="login" size="30" maxlength="50" /></td>-->
<!--				<td>Пароль</td>-->
<!--				<td align="center"><input type="password" name="password" size="30" maxlength="50" /></td>-->
<!--				<td align="center"><input type="submit" value = "Подтверждение заказа" /></td>-->
<!--				-->
<!--			</tr>-->
<!---->
<!--		</table>-->
	</form>
</body>
</html>