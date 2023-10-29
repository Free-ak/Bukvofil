<?php
session_start();
?>
<html>
<head>
<title>Магазин "Буквофил" - Резултаты поиска</title>
</head>

<body>
    <h1>Магазин "Буквофил" - Резултаты поиска</h1>
    <a href="general_page.php">| Вернуться на главную страницу | </a>
    <a href="search.html">| Вернуться к поиску | </a>
    <?php
    $searchtype=$_POST['searchtype'];
    $searchterm=$_POST['searchterm'];
    $searchterm = trim($searchterm);

    if(!$searchtype || !$searchterm)
    {
        echo 'Вы не ввели параметры поиска. Пожалуйста, вернитесь на предыдущую страницу и повторите ввод.';
        exit;
    }
    mysql_connect('localhost', 'root', '');
    mysql_select_db('books');
if(mysql_errno())
{
echo 'Ошибка: Не удалось установить соединение с базой данных.';
exit;
}
mysql_query("SET CHARACTER SET cp1251");
$result=mysql_query("select * from books where ".$searchtype." like '%$searchterm%'");
    $i=0;
while($row = mysql_fetch_row($result))
{
echo '<p><strong>'.($i+1).'.Название: ';
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
mysql_close();
	?>
</body>
</html>