<?php

require_once('helpers.php');
require_once('init.php');

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
    };

    $sql = "SELECT goals.status, goals.title, goals.end_date, goals.category_id FROM goals JOIN categories ON categories.id=goals.category_id WHERE goals.author_id = 1";
    $res = mysqli_query($con, $sql);

    if(!$res){
        $error = mysqli_error($con);
        print("MYSQL error " . $error);
    }
    else {
        $goals = mysqli_fetch_all($res, MYSQLI_ASSOC);
    };
    
};

function count_categories($category, $goals){
    $counter = 0;
    foreach($goals as $key => $value){
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

$page_content = include_template('main.php', [
    'categories' => $categories,
    'goals' => $goals,
    'show_complete_tasks' => $show_complete_tasks

]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'user_name' => $user_name,
    'title' => 'Дела в порядке'

]);

print($layout_content);

?>

               
