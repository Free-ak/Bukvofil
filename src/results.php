<?php
session_start();
?>
<html>
<head>
<title>������� "��������" - ��������� ������</title>
</head>

<body>
    <h1>������� "��������" - ��������� ������</h1>
    <a href="general_page.php">| ��������� �� ������� �������� | </a>
    <a href="search.html">| ��������� � ������ | </a>
    <?php
    $searchtype=$_POST['searchtype'];
    $searchterm=$_POST['searchterm'];
    $searchterm = trim($searchterm);

    if(!$searchtype || !$searchterm)
    {
        echo '�� �� ����� ��������� ������. ����������, ��������� �� ���������� �������� � ��������� ����.';
        exit;
    }
    mysql_connect('localhost', 'root', '');
    mysql_select_db('books');
if(mysql_errno())
{
echo '������: �� ������� ���������� ���������� � ����� ������.';
exit;
}
mysql_query("SET CHARACTER SET cp1251");
$result=mysql_query("select * from books where ".$searchtype." like '%$searchterm%'");
    $i=0;
while($row = mysql_fetch_row($result))
{
echo '<p><strong>'.($i+1).'.��������: ';
echo stripslashes($row[2]);


echo '</strong><br />�����: ';
echo stripslashes($row[1]);

echo '<br />ISBN: ';
echo stripslashes($row[0]);

echo '<br />����: ';
echo stripslashes($row[3]);

echo '</p>';
$i=$i+1;
}
echo '<p>������� ����: '.$i.'</p>';
mysql_close();
	?>
</body>
</html>