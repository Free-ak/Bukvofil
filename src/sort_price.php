<?php
session_start();
?>
<html>
<head>
    <meta charset="UTF-8">
	<title>Сортировка книг по цене</title>
</head>
<body>
<h1>Сортировка книг по цене</h1>
    <a href="index.php">| Вернуться на главную страницу | </a>
	<h2>От самых дешевых к самым дорогим (Выбор за Вами):</h2>
<?php

$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
    echo 'Ошибка: Не удалось установить соединение с базой данных.';
    exit;
}
$result = mysqli_query($connect,"select * from books order by price");
$i=0;
while($row = mysqli_fetch_row($result))
{
    echo '<p><strong>'.($i+1).'. Название: ';
    echo stripslashes($row[2]);
    
    
    echo '</strong><br />Автор: ';
    echo stripslashes($row[1]);
    
    echo '<br />ISBN: ';
    echo stripslashes($row[0]);
    
    echo '<br />Цена: ';
    echo stripslashes($row[3]);
    
    echo '</p>';
    $i=$i+1;
}
echo '<p>Найдено книг: '.$i.'</p>';
	?>

</body>
</html>