<?php

require_once('helpers.php');
require_once('init.php');
require_once('functions.php');
require_once('data.php');

if(isset($_SESSION['name'])){

$sql = "SELECT id, title FROM categories";
$categories = db_get_rows($con, $sql);

$sql = "SELECT goals.id, goals.status, goals.title, goals.file_path, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id =?";
$all_goals = db_get_data($con, $sql, [$author_id]);

$page_content = include_template('main.php', [
'categories' => $categories,
'all_goals' => $all_goals,
'goals' => $all_goals,
'show_complete_tasks' => $show_complete_tasks
]);

$search = $_GET['search'] ?? '';

if($search){
	$sql = "SELECT goals.id goals.status, goals.title, goals.file_path, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id =? AND MATCH (goals.title) AGAINST (?)";
	$goals = db_get_data($con, $sql, [$author_id, $search]);
	
	$page_content = include_template('main.php', [
	'categories' => $categories,
	'goals' => $goals, 
	'all_goals' => $all_goals,
	'search' => $search,
	'show_complete_tasks' => $show_complete_tasks 

]);
}

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$task_id = filter_input(INPUT_GET, 'task_id', FILTER_SANITIZE_NUMBER_INT);

if($id){
$sql = "SELECT goals.id, goals.status, goals.title, goals.file_path, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id = ? AND categories.id=?";
$goals = db_get_data($con, $sql, [$author_id, $id]);
	

if(!$goals){
	header("Location: index.php");
	
}

$page_content = include_template('main.php', [
	'categories' => $categories,
	'all_goals' => $all_goals,
	'goals' => $goals,
	'show_complete_tasks' => $show_complete_tasks

]);
}

 if($task_id){
	$sql = "SELECT id, status, title, end_date FROM goals WHERE id=?";
	$task = db_get_data($con, $sql, [$task_id]);

	if($task['status'] == 0){
		$new_status = 1;
	}
	else{
		$new_status = 0;
	}
	$sql = "UPDATE goals SET status=? WHERE id=?";
	$stmt = db_get_prepare_stmt($con, $sql, [$new_status, $task_id]);
	$res = mysqli_stmt_execute($stmt);
	header("Location:index.php");
   

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



