
<section class="content__side">
<h2 class="content__side-heading">Проекты</h2>


<nav class="main-navigation">
<ul class="main-navigation__list">
    <?php foreach ($categories as $value): ?>
        
    
    <li class="main-navigation__list-item">
        <a class="main-navigation__list-item-link" href="#"><?=htmlspecialchars($value);?></a>
        <span class="main-navigation__list-item-count"><?=count_categories($value, $goals);?></span>
    </li>
<?php endforeach; ?>
</ul>
</nav>

<a class="button button--transparent button--plus content__side-button"
href="pages/form-project.html" target="project_add">Добавить проект</a>
</section>

<main class="content__main">
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post" autocomplete="off">
<input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

<input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
<nav class="tasks-switch">
    <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
    <a href="/" class="tasks-switch__item">Повестка дня</a>
    <a href="/" class="tasks-switch__item">Завтра</a>
    <a href="/" class="tasks-switch__item">Просроченные</a>
</nav>

<label class="checkbox">
    <!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
    <input class="checkbox__input visually-hidden show_completed" type="checkbox"
    <?php if($show_complete_tasks == 1): ?>
        checked
    <?php endif; ?>    

    >
    <span class="checkbox__text">Показывать выполненные</span>
</label>
</div>

<table class="tasks">
<?php foreach ($goals as $key => $value): ?>
    <?php if(htmlspecialchars($value["is_done"]) == false): ?>
    <?php $res = get_remaining_time(htmlspecialchars($value["date"])) ?>
    <tr class="tasks__item task<?php if ($res <= 24):?> task--important<?php endif; ?>"> 
    
    <td class="task__select">
        <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
            <span class="checkbox__text"><?=htmlspecialchars($value["title"]);?></span>
        </label>
    </td>

    <td class="task__file">  </td>                        
    
    <td class="task__date"><?=htmlspecialchars($value["date"]);?></td>

    <td class="task__controls"></td>

</tr>

    <?php elseif (htmlspecialchars($value["is_done"]) == true && $show_complete_tasks == 0): continue ?> 

    <?php elseif (htmlspecialchars($value["is_done"]) == true && $show_complete_tasks == 1): ?> 

<tr class="tasks__item task--completed"> 
    
    <td class="task__select">
        <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
            <span class="checkbox__text"><?=htmlspecialchars($value["title"]);?></span>
        </label>
    </td>

    <td class="task__file">  </td>                        
    
    <td class="task__date"><?=htmlspecialchars($value["date"]);?></td>

    <td class="task__controls"></td>

</tr> 
    <?php endif; ?>   

<?php endforeach; ?>



</table>
</main>
