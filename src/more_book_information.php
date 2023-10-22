<html>
<head>
	<title>Магазин "Буквофил" - Подробная информация о книге</title>
</head>
<body>
	
	<h1>Магазин "Буквофил" - Подробная информация о книге</h1>
	<a href="index.php">| Вернуться на главную страницу| </a>
	<form action="zakaz.php" method = post>
		<?php
		$isbn=$_GET['isbn'];
        $connect=mysqli_connect('mysql', 'root', 'root','books');
        if(mysqli_errno($connect))
        {
            echo 'Ошибка: Не удалось установить соединение с базой данных.';
            exit;
        }
		$result = mysqli_query($connect,"SELECT author, title, isbn, price, review from books join book_reviews using(isbn) where isbn = '$isbn'");
		while($row = mysqli_fetch_row($result))
		{
		echo '<p><strong>Название: ';
		echo stripslashes($row[1]);

		echo '</strong><br />Автор: ';
		echo stripslashes($row[0]);

		echo '</strong><br />ISBN: ';
		echo stripslashes($row[2]);

		echo '</strong><br />Цена: ';
		echo stripslashes($row[3]);

		echo '</strong><br />Краткое описание: ';
		echo stripslashes($row[4]);

		echo '</p>';

		}
		echo '<p><strong>Заказать книгу';
		echo '<input type = "text" name ="isbn" value='.$isbn.' size="13" maxlength="13"/> ';
		echo 'в количестве: ';
		echo '<input type = "text" name ="quantity" size="13" maxlength="13"/> ';
		echo '<input type = "submit" value="Заказадь немедленно!"></strong></p> ';
		?>
	</form>
</body>
</html>