<?php

require_once('helpers.php');
require_once('init.php');
require_once('functions.php');
require_once('data.php');

if(isset($_SESSION['name'])){

$sql = "SELECT id, title FROM categories";
$categories = db_get_rows($con, $sql);

$sql = "SELECT goals.status, goals.title, goals.file_path, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id =?";
$all_goals = db_get_data_on_id($con, $sql, $author_id);

$page_content = include_template('main.php', [
'categories' => $categories,
'all_goals' => $all_goals,
'goals' => $all_goals,
'show_complete_tasks' => $show_complete_tasks
]);

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if($id){
$sql = "SELECT goals.status, goals.title, goals.file_path, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id = ? AND categories.id=?";
$goals = db_get_data_on_id($con, $sql, [$author_id, $id]);

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
}
else {
	http_response_code(403);
	print("Error: ");
	print(http_response_code());
	die();
}



			   
