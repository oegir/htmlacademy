<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories_arr as $category): ?>
                <li class="nav__item">
                    <a href="all-lots.html"><?=xss_protection($category['name']); ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container form--invalid" action="registration.php" method="post" autocomplete="off"> <!-- form
    --invalid -->
      <h2>Регистрация нового аккаунта</h2>
      <div class="form__item <?php if(isset($form_errors['email'])):?><?=$form_errors['email'];?><?php endif; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=xss_protection($incoming_data['email']); ?>">
        <span class="form__error">Введите e-mail</span>
      </div>
      <div class="form__item <?php if(isset($form_errors['password'])):?><?=$form_errors['password'];?><?php endif; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=xss_protection($incoming_data['password']); ?>">
        <span class="form__error">Введите пароль</span>
      </div>
      <div class="form__item <?php if(isset($form_errors['name'])):?><?=$form_errors['name'];?><?php endif; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=xss_protection($incoming_data['name']); ?>">
        <span class="form__error">Введите имя</span>
      </div>
      <div class="form__item <?php if(isset($form_errors['message'])):?><?=$form_errors['message'];?><?php endif; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?=xss_protection($incoming_data['message']); ?></textarea>
        <span class="form__error">Напишите как с вами связаться</span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button" name="submit">Зарегистрироваться</button>
      <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
  </main>