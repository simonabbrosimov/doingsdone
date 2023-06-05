<?php

require_once('helpers.php');
require_once('init.php');
require_once('functions.php');

$show_complete_tasks = rand(0, 1);

if(!$con){
    print("Connection error " . msqli_connect_error());
}
else {       
    $sql = "SELECT id, title FROM categories WHERE author_id = 1";
    $res = mysqli_query($con, $sql);

    if(!$res){
        $error = mysqli_error($con);
        print("MYSQL error " . $error);
    }
    else {
        $categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } 

}

if(!$con){
    print("Connection error " . msqli_connect_error());
}
else {       
    $sql = "SELECT goals.status, goals.title, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id = 1";
    $res = mysqli_query($con, $sql);

    if(!$res){
        $error = mysqli_error($con);
        print("MYSQL error " . $error);
    }
    else {
        $all_goals = mysqli_fetch_all($res, MYSQLI_ASSOC);
    } 

}


$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if($id){
    $sql = "SELECT goals.status, goals.title, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE categories.id=" . $id;
    
}
else {
    $sql = "SELECT goals.status, goals.title, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id = 1";
}

$res = mysqli_query($con, $sql);

if(!$res){
    $error = mysqli_error($con);
    print("MYSQL error " . $error);
}
else {
    $goals = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

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

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'user_name' => $user_name,
    'title' => 'Дела в порядке'

]);

print($layout_content);



               
