<?php

require_once('helpers.php');
require_once('init.php');
require_once('functions.php');

$sql = "SELECT user_email, user_name FROM users";
$users = db_get_rows($con, $sql);
$column = 'user_email';
$emails = db_get_column($con, $sql, $column);

$page_content = include_template('register_main.php');	  

if($_SERVER['REQUEST_METHOD']== 'POST'){
	$require_fields = ["email", "password", "name"];
	$errors = [];

	$rules = [

		"email" => function($value) use ($emails){
			return validate_email($value, $emails);
		},
		"name" => function($value){
			return validate_length($value,1, 50);
		},
		"password" => function($value){
			return validate_length($value, 6, 12);
		}

	];

	$new_user = filter_input_array(INPUT_POST, ["email" => FILTER_DEFAULT, "password" => FILTER_DEFAULT, "name" => FILTER_DEFAULT], false);

	foreach($new_user as $key => $value){
		if(isset($rules[$key])){
			$rule = $rules[$key];
			$errors[$key] = $rule($value);
		}

		if(in_array($key, $require_fields) && empty($value)){
			$errors[$key] = "Поле надо заполнить";
		}
	}

	$errors = array_filter($errors);

	if(count($errors)){
		$page_content = include_template('register_main.php', [
			'errors' => $errors,
			'new_user' => $new_user

		]);
	} 
	else {
		
		$new_user['password'] = password_hash($new_user['password'], PASSWORD_DEFAULT);
		$sql = "INSERT INTO users (user_email, password, user_name) VALUES (?, ?, ?);";
		$stmt = db_get_prepare_stmt($con, $sql, $new_user);
		$res = mysqli_stmt_execute($stmt);
   
		header("Location:index.php");

		$page_content = include_template('register_main.php', [
			'new_user' => $new_user
		 
	]);		
			
	}  

} 

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Дела в порядке'

]);

print($layout_content);