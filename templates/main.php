
<div class="content">
<section class="content__side">
<h2 class="content__side-heading">Проекты</h2>


<nav class="main-navigation">
<ul class="main-navigation__list">
	<?php foreach ($categories as $key => $value): ?>
	
	<li class="main-navigation__list-item <?php if(htmlspecialchars($value['id'], ENT_QUOTES) == ($_GET['id'] ?? null)): ?> main-navigation__list-item--active <?php endif;?>">
		<a class="main-navigation__list-item-link" href="../index.php?id=<?= $value['id'] 
		;?>"><?=htmlspecialchars($value['title'], ENT_QUOTES);?></a>
		<span class="main-navigation__list-item-count"><?=count_categories(htmlspecialchars($value['id'], ENT_QUOTES), $all_goals);?></span>
	</li>
<?php endforeach; ?>
</ul>
</nav>

<a class="button button--transparent button--plus content__side-button"
href="../add-project.php" target="project_add">Добавить проект</a>
</section>

<main class="content__main">
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="../index.php" method="get" autocomplete="off">
<input class="search-form__input" type="search" name="search" value="" placeholder="Поиск по задачам">

<input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
<nav class="tasks-switch">
	<a href="../index.php" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
	<a href="/" class="tasks-switch__item">Повестка дня</a>
	<a href="/" class="tasks-switch__item">Завтра</a>
	<a href="/" class="tasks-switch__item">Просроченные</a>
</nav>

<label class="checkbox">
	<!--добавить сюда атрибут "checked", если переменная $show_complete_tasks равна единице-->
	<input class="checkbox__input visually-hidden show_completed" type="checkbox"
	<?php if($show_complete_tasks == 1 || $show_complete_tasks == ""): ?>
		checked
	<?php endif; ?>    

	>
	<span class="checkbox__text">Показывать выполненные</span>
</label>
</div>

<table class="tasks">
<?php foreach ($goals as $key => $value): ?>
	<?php if(htmlspecialchars($value["status"], ENT_QUOTES) == false): ?>
	<?php $res = get_remaining_time(htmlspecialchars($value["end_date"], ENT_QUOTES)) ?>
	<tr class="tasks__item task<?php if ($res <= 24):?> task--important<?php endif; ?>"> 
	
	<td class="task__select">
		<label class="checkbox task__checkbox">
			<input class="checkbox__input visually-hidden task__checkbox" type="checkbox" name="name" value="<?=htmlspecialchars($value["id"], ENT_QUOTES);?>">
			<span class="checkbox__text"><?=htmlspecialchars($value["title"], ENT_QUOTES);?></span>
		</label>
	</td>

	<td class="task__file"> </td>                        
	
	<td class="task__date"><?=htmlspecialchars($value["end_date"], ENT_QUOTES);?></td>

	<td class="task__controls"></td>

</tr>

	

	<?php elseif (htmlspecialchars($value["status"], ENT_QUOTES) == true && $show_complete_tasks == 1): ?> 

<tr class="tasks__item task--completed"> 
	
	<td class="task__select">
		<label class="checkbox task__checkbox">
			<input class="checkbox__input visually-hidden task__checkbox" type="checkbox" checked name =
			"name" value="<?=htmlspecialchars($value["id"], ENT_QUOTES);?>">
			<span class="checkbox__text"><?=htmlspecialchars($value["title"], ENT_QUOTES);?></span>
		</label>
	</td>

	<td class="task__file">  </td>                        
	
	<td class="task__date"><?=htmlspecialchars($value["end_date"], ENT_QUOTES);?></td>

	<td class="task__controls"></td>

</tr> 
	<?php endif; ?>   

<?php endforeach; ?>



</table>
</main>
</div>