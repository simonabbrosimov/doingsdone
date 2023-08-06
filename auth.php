<?php
require_once('helpers.php');
require_once('init.php');
require_once('functions.php');
require_once('data.php');

 $page_content = include_template('auth_main.php');

if($_SERVER['REQUEST_METHOD']== 'POST'){
	$require_fields = ["email", "password"];
	$errors = [];

	$rules = [

		"email" => function($value){
			return check_email($value, $emails);
		},
		"password" => function($value){
			return validate_length($value, 6, 12);
		}

	];

	$user_information = filter_input_array(INPUT_POST, ["email" => FILTER_DEFAULT, "password" => FILTER_DEFAULT], true);

	foreach($user_information as $key => $value){
		if(isset($rules[$key])){
			$rule = $rules[$key];
			$errors[$key] = $rule($value);
		}
		if(in_array($key, $require_fields) && empty($value)){
			$errors[$key] = "Поле надо заполнить";
		}
	} 

	$errors = array_filter($errors);

	if (count($errors)) {
			$page_content = include_template('auth_main.php', [
				'errors' => $errors,
				'user_information' => $user_information

			]);
		}
	else {
		$user = db_get_user($con,$user_information['email']);
		if ($user) {
				if (password_verify($user_information['password'], $user['password'])) {
					session_start();
					$_SESSION['name'] = $user['user_name'];
					$_SESSION['id'] = $user['id'];
					header("Location: index.php");
				}
				else {
					$errors['password'] = 'Неверный пароль';
				}
		}
		else {
			$errors['email'] = 'Такой пользователь не найден';
		}

	}

	
	if (count($errors)) {
		$page_content = include_template('auth_main.php', [
		'errors' => $errors,
		'user_information' => $user_information

		]);

		}
	else {
		header("Location: /index.php");
		}
	}

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Вход'
]);

print($layout_content);