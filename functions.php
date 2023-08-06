<?php
function count_categories($category, $all_goals){
	$counter = 0;
	foreach($all_goals as $key => $value){
		if($category == $value["category_id"]){
			$counter = $counter + 1;
		}
	}

	return $counter;
};

function get_remaining_time($date){

	$goal_date = strtotime($date);
	$now_date = strtotime("now");
	$sec_in_hour = 3600;

	$result = floor(($goal_date - $now_date) / $sec_in_hour);

	return $result;
};

function validate_category($id, $allowed_list) {
	if (!in_array ($id, $allowed_list)) {
		return "Указана несуществующая категория";
	}

	return null;
};

function validate_length($value, $min, $max) {
	if ($value) {
		$len = strlen($value);
		if ($len < $min or $len > $max) {
			return "Значение должно быть от $min до $max символов";
		}
	}

	return null;
};

function validate_date($value){
	if($value == null) {
	return null;  
	} 
	elseif(date('Y-m-d', strtotime($value)) === $value){
	$now_date = date('Y-m-d');
	$now_date = strtotime($now_date);
	$end_date = strtotime($value);
	if($now_date <= $end_date){
		return null;
	}
	else{
		return "Введенная дата должна быть больше текущей";
	}
	}
	else{
	return "Введенная дата должна быть в формате ГГГГ-ММ-ДД";
	}
};


function db_get_rows($con, $sql){
	$res = mysqli_query($con, $sql);
	return mysqli_fetch_all($res, MYSQLI_ASSOC); 
	};

function db_get_column($con, $sql, $column){
	$res = mysqli_query($con, $sql);
	$cat = mysqli_fetch_all($res, MYSQLI_ASSOC);
	return array_column($cat, $column); 
	
};

function validate_email($value, $allowed_list) {
	$email = filter_var($value, FILTER_VALIDATE_EMAIL);
	if($email){
		if (in_array ($value, $allowed_list)) {
			return "Пользователь с данным e-mail уже зарегистрирован";
	}	
		else {
			return null;
		}

	}
	else {
		return "Введите правильный e-mail";
	}	
	
};

function check_email($value) {
	$email = filter_var($value, FILTER_VALIDATE_EMAIL);
	if(!$email){
		return "Введите правильный e-mail";
	}	
	else {
		return null;
	}
};

function db_get_user($con, $email) {
	$sql = "SELECT id, user_email, user_name, password FROM users WHERE user_email=?";
	$stmt = mysqli_prepare($con, $sql);
	mysqli_stmt_bind_param($stmt, 's', $email);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$user_data = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;
	
	return $user_data;
};

function db_get_data($con, $sql, $data) {
	$stmt = db_get_prepare_stmt($con, $sql, $data);
	mysqli_stmt_execute($stmt);
	$res = mysqli_stmt_get_result($stmt);
	$user_data = $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : null;
	
	return $user_data;
};



