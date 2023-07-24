<?php

require_once('helpers.php');
require_once('init.php');
require_once('functions.php');

$sql = "SELECT id, title FROM categories";
$categories = db_get_rows($con, $sql);
$column = 'id';
$categories_id = db_get_column($con, $sql, $column);
$sql = "SELECT goals.status, goals.title, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id = 1";
$all_goals = db_get_rows($con, $sql);
  
$page_content = include_template('add-project_main.php', [
	'categories' => $categories,
	'all_goals' => $all_goals    
]);

if($_SERVER['REQUEST_METHOD']== 'POST'){
	$require_fields = ["name", "project"];
	$errors = [];

	$rules = [

		"project" => function($value)use ($categories_id){
			return validate_category($value, $categories_id);
		},
		"name" => function($value){
			return validate_length($value,1, 200);
		},
		"date" => function($value){
			return validate_date($value);
		}

	];

	$new_goal = filter_input_array(INPUT_POST, ["name" => FILTER_DEFAULT, "project" => FILTER_DEFAULT, "date" => FILTER_DEFAULT, "file" => FILTER_DEFAULT], $add_empty = true);

	foreach($new_goal as $key => $value){
		if(isset($rules[$key])){
			$rule = $rules[$key];
			$errors[$key] = $rule($value);
		}

		if(in_array($key, $require_fields) && empty($value)){
			$errors[$key] = "Поле надо заполнить";
		}
	}

	$errors = array_filter($errors);

	if ($_FILES['file']['name'] != null) {
	$file_name = $_FILES['file']['name'];
	$tmp_name = $_FILES['file']['tmp_name'];
	$file_path = __DIR__ . '/uploads/';
	move_uploaded_file($tmp_name, $file_path . $file_name);
	$new_goal['file'] = __DIR__ . '/uploads/' . $file_name;
	}
	
	if(count($errors)){
		$page_content = include_template('add-project_main.php', [
			'categories' => $categories,
			'categories_id' => $categories_id,
			'errors' => $errors,
			'new_goal' => $new_goal

		]);
	} 
	else {
		
		$sql = "INSERT INTO goals (title, category_id, end_date, file_path, author_id, status) VALUES (?, ?, ?, ?, 1, 0);";
		$stmt = db_get_prepare_stmt($con, $sql, $new_goal);
		$res = mysqli_stmt_execute($stmt);
   
		$goal_id = mysqli_insert_id($con);
		header("Location:index.php");

		$page_content = include_template('add-project_main.php', [
		 'categories' => $categories,
		 'new_goal' => $new_goal
		 
	]);		

				

	}  

} 

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'categories' => $categories,
	'all_goals' => $all_goals,
	'title' => 'Дела в порядке'

]);

print($layout_content);