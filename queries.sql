#добавляю пользователей
INSERT INTO users (user_email, user_name, password)
VALUES
	('petya@mail.ru', 'petya', '12345TY8'),  
	('vasiya@mail.ru', 'vasiya', 'oo345TY8');

#добавляю проекты
INSERT INTO categories (title, author_id)
VALUES
	('Входящие', 1),
	('Учеба', 1),
	('Работа', 1),
	('Домашние дела', 2),
	('Авто', 2);
	
#добавляю задачи
INSERT INTO goals (status, title, file_path, end_date, author_id, category_id)
VALUES
	(0, 'Собеседование в IT компании', null, '01.12.2019', 1, 3),
    (0, 'Выполнить тестовое задание', null, '25.12.2019', 1, 3),
    (1, 'Сделать задание первого раздела', null, '21.12.2019', 1, 2),
	(0, 'Встреча с другом', null, '22.12.2019', 1, 1),
	(0, 'Купить корм для кота', null, null, 2, 4),
	(0, 'Заказать пиццу', null, null, 2, 4);
	
#получаю список всех проектов для одного пользователя
SELECT categories.title AS 'Название проекта', users.user_name AS 'Имя пользователя' 
FROM categories 
JOIN users 
ON categories.author_id=users.id 
WHERE categories.author_id=1;

#получаю список задач для одного проекта
SELECT goals.title AS 'Название задачи', 
		goals.end_date AS 'Конечная дата', 
		users.user_name AS 'Имя пользователя', 
		categories.title AS 'Название проекта' 
FROM goals 
JOIN users 
ON goals.author_id=users.id 
JOIN categories 
ON goals.category_id=categories.id 
WHERE goals.category_id=3;

#помечаю задачу как выполненную
UPDATE goals 
SET status=1 
WHERE id=2;


#обновляю название задачи
UPDATE goals 
SET title='Заказать суши для кота' 
WHERE id=5;






