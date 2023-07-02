<form class="form"  action="add.php" method="post" autocomplete="off" enctype="multipart/form-data">
           <?php $classname = isset($errors['name']) ? "form__input--error" : "" ;?> 
          <div class="form__row <?=$classname ;?>">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input" type="text" name="name" id="name" value="<?=htmlspecialchars($new_goal['name'], ENT_QUOTES);?>" placeholder="Введите название">
            <p class="form__message"><?=$errors['name'];?></p>
          </div>
          <?php $classname = isset($errors['project']) ? "form__input--error" : "" ;?> 
          <div class="form__row <?=$classname ; ?>">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select" name="project" id="project">
              <option >Выберите проект</option>
              <?php foreach ($categories as $cat):?>
              <option value="<?=htmlspecialchars($cat['id'], ENT_QUOTES);?>"><?=htmlspecialchars($cat['title'], ENT_QUOTES);?></option>
            <?php endforeach;?>
            </select>
             <p class="form__message"><?=$errors['project'];?></p>
          </div>
          <?php $classname = isset($errors['date']) ? "form__input--error" : "" ;?> 
          <div class="form__row <?=$classname ;?>">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="text" name="date" id="date" value="<?=htmlspecialchars($new_goal['date'], ENT_QUOTES);?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
             <p class="form__message"><?=$errors['date'];?></p>
          </div>

          <div class="form__row">
            <label class="form__label" for="file">Файл</label>

            <div class="form__input-file">
              <input class="visually-hidden" type="file" name="file" id="file" value="">

              <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
              </label>
            </div>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>