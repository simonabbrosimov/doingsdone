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

