<?php

require_once('helpers.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

                
                
$categories = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

$goals = [
    [
        "title" => "Собеседование в IT компании",
        "date" => "01.12.2019",
        "category" => $categories[2],
        "is_done" => false
    ],

    [
        "title" => "Выполнить тестовое задание",
        "date" => "25.12.2019",
        "category" => $categories[2],
        "is_done" => false
    ],

    [
        "title" => "Сделать задание первого раздела",
        "date" => "21.12.2019",
        "category" => $categories[1],
        "is_done" => true
    ],

    [
        "title" => "Встреча с другом",
        "date" => "22.12.2019",
        "category" => $categories[0],
        "is_done" => false
    ],

    [
        "title" => "Купить корм для кота",
        "date" => null,
        "category" => $categories[3],
        "is_done" => false
    ],

    [
        "title" => "Заказать пиццу",
        "date" => null,
        "category" => $categories[3],
        "is_done" => false
    ]



];

function count_categories($category, $goals){
    $counter = 0;
    foreach($goals as $key => $value){
        if($category == $value["category"]){
            $counter = $counter + 1;
        }
    }

    return $counter;
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

function get_remaining_time($date){

    $goal_date = strtotime($date);
    $now_date = strtotime("now");
    $sec_in_hour = 3600;

    $result = floor(($goal_date - $now_date) / $sec_in_hour);

    return $result;
};

?>

               
