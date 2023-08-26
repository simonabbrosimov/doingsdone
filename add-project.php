<?php

require_once('helpers.php');
require_once('init.php');
require_once('functions.php');
require_once('data.php');

if(isset($_SESSION['name'])){

$sql = "SELECT id, title FROM categories";
$categories = db_get_rows($con, $sql);
$column = 'id';
$categories_id = db_get_column($con, $sql, $column);

$sql = "SELECT goals.id, goals.status, goals.title, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id = ?";
$all_goals = db_get_data($con, $sql, [$author_id]);

$page_content = include_template('add-project_main.php', [
	'categories' => $categories,
	'all_goals' => $all_goals    
]);

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Дела в порядке'

]);

if($_SERVER['REQUEST_METHOD']== 'POST'){
		
	$new_project = filter_input_array(INPUT_POST, ["name" => FILTER_DEFAULT],  $add_empty = true);

	if($_POST['name']){
		$new_project['author_id'] = $author_id;
		$sql = "INSERT INTO categories (title, author_id) VALUES (?, ?);";

		$stmt = db_get_prepare_stmt($con, $sql, $new_project);
		$res = mysqli_stmt_execute($stmt);
   
		header("Location:index.php");

        $page_content = include_template('add-project_main.php', [
		 'categories' => $categories,
		 'all_goals' => $all_goals,
		 'new_project' => $new_project
		 
	]);		


	}

	$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Дела в порядке'

]);
    
} 

print($layout_content);

}
else {
	http_response_code(403);
	print("Error: ");
	print(http_response_code());
	die();
}