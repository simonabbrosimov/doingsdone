<div class="content">
      <section class="content__side">
        <h2 class="content__side-heading">Проекты</h2>

        <nav class="main-navigation">
          <ul class="main-navigation__list">
          <?php foreach ($categories as $key => $value): ?>  
            <li class="main-navigation__list-item">
              <a class="main-navigation__list-item-link" href="#"><?=htmlspecialchars($value['title'], ENT_QUOTES);?></a>
              <span class="main-navigation__list-item-count"><?=count_categories(htmlspecialchars($value['id'], ENT_QUOTES), $all_goals);?></span>
            </li>
          <?php endforeach; ?>    
            
          </ul>
        </nav>

        <a class="button button--transparent button--plus content__side-button" href="../add-project.php">Добавить проект</a>
      </section>


      <main class="content__main">
        <h2 class="content__main-heading">Добавление проекта</h2>

        <form class="form"  action="../add-project.php" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="project_name">Название <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="project_name" value="<?=$new_project['name'];?>" placeholder="Введите название проекта">
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>
      </main>
    </div>