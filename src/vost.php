<?php
session_start();
?>
<html>
<head>
	<title>Восстановление БД</title>
</head>
<body>
	<h1>Восстановление БД</h1>
	<a href="index.php">| Вернуться на главную| </a>
	<h2>БД восстановлена!</h2>

<?php
$connect=mysqli_connect('mysql', 'root', 'root','books');
if(mysqli_errno($connect))
{
echo 'Ошибка: Не удалось установить соединение с базой данных.';
exit;
}

mysqli_query($connect,"SET FOREIGN_KEY_CHECKS=0");
mysqli_query($connect,"DROP TABLE customers");
mysqli_query($connect,"DROP TABLE  orders");
mysqli_query($connect,"DROP TABLE  books");
mysqli_query($connect,"DROP TABLE  order_items");
mysqli_query($connect,"DROP TABLE  book_reviews");
// mysqli_query($connect,"DROP TABLE login_password");

mysqli_query($connect,"create table customers
(customerid int unsigned not null auto_increment primary key, 
name char (50) not null, 
address char(100) not null,
city char (30) not null)"
);

mysqli_query($connect,"create table books
(
isbn char(13) not null primary key,
author char(50), 
title char(100),
price float (6,2)
)");

mysqli_query($connect,"create table orders 
( 
orderid int unsigned not null auto_increment primary key, 
customerid int unsigned not null, 
amount float (8,2),
date date not null,
FOREIGN KEY (customerid)  REFERENCES customers (customerid) ON DELETE 
CASCADE)");

mysqli_query($connect,"create table order_items( 
	orderid int unsigned not null, 
	isbn char (13) not null, 
	quantity tinyint unsigned,
	primary key(orderid, isbn),
	FOREIGN KEY (orderid)  REFERENCES orders(orderid) ON DELETE CASCADE,
	FOREIGN KEY (isbn)  REFERENCES books(isbn) ON DELETE CASCADE
	)");

mysqli_query($connect,"create table book_reviews
(
isbn char (13) not null primary key, 
review text,
FOREIGN KEY (isbn)  REFERENCES order_items(isbn) ON DELETE CASCADE
)");
//
//mysqli_query($connect,"create table login_password
//(
//customerid int unsigned not null auto_increment primary key,
//login varchar(20),
//password varchar(40),
//FOREIGN KEY (customerid)  REFERENCES customers (customerid) ON DELETE CASCADE)");


mysqli_query($connect,"insert into customers values 
(1,'Иванов Иван Иванович','Транспортная, 23-45','Саранск'),
(2,'Петров Петр Петрович','Московская, 12-45','Саранск'),
(3,'Сидоров Сидор Сидорович','Советская, 7-5','Саранск'),
(4,'Григорьев Григорий Григорьевич','Ленина, 34-45','Рузаевка'),
(5,'Денисов Денис Денисович','Пролетарская, 90-67','Рузаевка')
");

mysqli_query($connect,"insert into orders values
(NULL, 1, 101.00, '2009-10-02'),
(NULL, 2, 3000.80, '2006-08-12'),
(NULL, 2, 4500.40, '2006-06-13'),
(NULL, 3, 1871.73, '2008-07-23'),
(NULL, 4, 1500.91, '2001-08-24'),
(NULL, 4, 3000.00, '2006-07-09'),
(NULL, 5, 362.70, '2006-10-12'),
(NULL, 5, 2107.90, '2006-09-15'),
(NULL, 5, 6001.60, '2006-09-27'),
(NULL, 5, 20.20, '2011-09-30')
");

mysqli_query($connect,"insert into books values
('0-672-31697-8', 'Чайников В.', 'MySQL для чайников', 120.90),
('0-672-89765-6', 'Профи С.', 'MySQL для профессионалов', 432.70),
('0-672-56743-2', 'Браун Д.', 'MySQL для студентов кооперативного института',1500.00),
('0-672-09876-3', 'Чайников В.', 'PHP для чайников', 100.90),
('0-672-45637-4', 'Профи С.', 'PHP для профессионалов', 300.50),
('0-672-23456-6', 'Браун Д.', 'PHP для студентов кооперативного института', 1500.40),
('0-672-23769-8', 'Александров Л.', 'Зачет по электронной коммерции за 5 минут', 1.01)
");

mysqli_query($connect,"insert into order_items values 
(1, '0-672-23769-8', 100),
(2, '0-672-23456-6', 2),
(3, '0-672-23456-6',1),
(3, '0-672-56743-2',2),
(4, '0-672-23769-8', 3),
(4, '0-672-31697-8', 8),
(4, '0-672-45637-4', 3),
(5, '0-672-09876-3', 2 ),
(5, '0-672-89765-6', 3),
(5, '0-672-23769-8', 1),
(6, '0-672-56743-2', 2),
(7, '0-672-31697-8', 3),
(8, '0-672-09876-3', 6),
(8, '0-672-45637-4', 5),
(9, '0-672-23456-6', 4),
(10, '0-672-23769-8', 20)
");

mysqli_query($connect,"insert into book_reviews values
('0-672-31697-8', 'Увлекательное чтение гарантировано!'),
('0-672-89765-6','Очень нужная и полезная книга. Полностью оправдывает свое название.'), 
('0-672-56743-2','В книге полностью раскрыта проблематика изучения MySQL в кооперативном институте. Приведены принципиальные отличия обучаемости студентов в МУПК от студентов других ВУЗов'),
('0-672-09876-3','Ничего не понял из написанного. Пишите проще.'),
('0-672-45637-4', 'Рассматриваются вопросы создания электронного магазина на РНР. Достаточно легко читается и можно списать PHР-сценарии для личного использования'), 
('0-672-23456-6', 'Вся книга посвящена описанию оператора ECHO в его различных модификациях. В конце обучения обычно этот оператор пишут без ошибок'), 
('0-672-23769-8','С помощью книги вся наша группа сдала зачет досрочно')
");
//
//mysqli_query($connect,"insert into login_password values
//(1, 'iii_1', sha1('my_password_1')),
//(2, 'ppp_2', sha1('my_password_2')),
//(3, 'sss_3', sha1('my_password_3')),
// (4, 'ggg_4', sha1('my_password_4')),
// (5, 'ddd_5', sha1('my_password_5'))
//");

mysqli_query($connect,"SET FOREIGN_KEY_CHECKS=1");
mysqli_close($connect);
	?>

</body>
</html>

