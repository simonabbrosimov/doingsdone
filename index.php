<?php

require_once('helpers.php');
require_once('init.php');
require_once('functions.php');

$show_complete_tasks = rand(0, 1);


$sql = "SELECT id, title FROM categories";
$categories = db_get_rows($con, $sql);
$sql = "SELECT goals.status, goals.title, goals.file_path, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id = 1;";
$all_goals = db_get_rows($con, $sql);

$page_content = include_template('main.php', [
'categories' => $categories,
'all_goals' => $all_goals,
'goals' => $all_goals,
'show_complete_tasks' => $show_complete_tasks
]);
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if($id){
$sql = "SELECT goals.status, goals.title, goals.file_path, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id = 1 AND categories.id=" . $id;
$goals = db_get_rows($con, $sql);

if(!$goals){
	http_response_code(404);
	print("Error: ");
	print(http_response_code());
	die();
}

$page_content = include_template('main.php', [
	'categories' => $categories,
	'all_goals' => $all_goals,
	'goals' => $goals,
	'show_complete_tasks' => $show_complete_tasks

]);
}


$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'user_name' => $user_name,
	'title' => 'Дела в порядке'

]);

print($layout_content);



			   
