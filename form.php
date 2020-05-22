<!DOCTYPE html>
<html lang="ru">
  <head>
    <style>
/* Сообщения об ошибках и поля с ошибками выводим с красным бордюром. */
      .error {
      border: 2px solid red;
      }
      .error1{
      color:red;
      font-weight: bold;
      }
      .mesa {
      font-weight: bold;
      }
      #messages{
      margin-left: 32vh;
      }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Mypage</title>
  </head>
  <body>
    <header>
      <div class="container-fluid justify-content-center p-0">
        <div class="row align-items-center px-0 justify-content-md-center color1 ">
          <div class="col-auto ml-5 ml-md-0  text-center">
            <h1>Форма</h1>
          </div>
        </div>
      </div>
      </header>
<?php
  if (!empty($messages)) {
  print('<div id="messages">');
  // Выводим все сообщения.
  foreach ($messages as $message) {
    print($message);
  }
  print('</div>');
}

// Далее выводим форму отмечая элементы с ошибками классом error
// и задавая начальные значения элементов ранее сохраненными.
?>
      <div class="table & form">
          <div class="col-sm-12 col-md-6 mx-sm-0  mx-md-auto color3 order-md-0 mt-2  ">
            <h2>Форма</h2>
            <?php  if(empty($_SESSION['login'])) print('
            <a href="login.php">
   			<button type="button" class="btn btn-primary" >Вход</button>
  			</a>');
  			?>
  			<?php  if(empty($_SESSION['login'])) print('
            <a href="admin.php">
   			<button type="button" class="btn btn-secondary" >Управление</button>
  			</a>');
  			?>
            <form action="index.php" method="POST">
              <label>
              Имя
              <br>
              <input name="fio" <?php if ($errors['fio']) {print 'class="error"';} ?> value="<?php print $values['fio']; ?>" placeholder="Name">
              </label>
              <br>
              <label>
              Email
              <br>
              <input name="email" <?php if ($errors['email']) {print 'class="error"';} ?> value="<?php print $values['email']; ?>" type="email" placeholder="yourmail@gmail.com">
              </label>
              <br>
              <label>
              Дата рождения
              <br>
              <input name="day" <?php if ($errors['day']) {print 'class="error"';} ?> value="<?php print $values['day']; ?>" type="date">
              </label>
              <br>
              <p>
                Пол
              </p>
              <br>
              <label <?php if ($errors['pol']) {print 'class="error1"';} ?>>
              <input type="radio" <?php if($values['pol'] == "male") {print 'checked="checked"';}?> name="pol" value="male"> М
              </label>
              <label <?php if ($errors['pol']) {print 'class="error1"';} ?>>
              <input type="radio" <?php if($values['pol'] == "fem") {print 'checked="checked"';}?> name="pol" value="fem"> Ж
              </label>
              <br>
              <p>
                Количество конечностей
              </p>
              <br>
              <label <?php if ($errors['lim']) {print 'class="error1"';} ?>>
              <input type="radio" <?php if($values['lim'] == "4") {print 'checked="checked"';}?> name="lim" value="4"> 4
              </label>
              <label <?php if ($errors['lim']) {print 'class="error1"';} ?>>
              <input type="radio"  <?php if($values['lim'] == "3") {print 'checked="checked"';}?> name="lim" value="3"> 3
              </label>
              <label <?php if ($errors['lim']) {print 'class="error1"';} ?>>
              <input type="radio"  <?php if($values['lim'] == "2") {print 'checked="checked"';}?> name="lim" value="2"> 2
              </label>
              <label <?php if ($errors['lim']) {print 'class="error1"';} ?>>
              <input type="radio"  <?php if($values['lim'] == "1") {print 'checked="checked"';}?> name="lim" value="1"> 1
              </label>
              <label <?php if ($errors['lim']) {print 'class="error1"';} ?>>
              <input type="radio"  <?php if($values['lim'] == "0" && (isset($_COOKIE['lim_value'])||isset($user_data[0]['lim']))) {print 'checked="checked"';}?> name="lim" value="0"> 0
              </label>
              <br>
              <label>
                Суперспособности
                <br>
                <select name="abilities[]" multiple="multiple" <?php if ($errors['abil']) {print 'class="error"';} ?>>
                  <option  <?php if($values['god'] == "1") {print 'selected="selected"';}?> value="god">Бессмертие</option>
                  <option  <?php if($values['sten'] == "1") {print 'selected="selected"';}?>value="sten">Прохождение сквозь стены</option>
                  <option  <?php if($values['fly'] == "1") {print 'selected="selected"';}?>value="fly">Левитация</option>
                </select>
              </label>
              <br>
              <label>
              Биография
              <br>
              <textarea name="bio" <?php if ($errors['bio']) {print 'class="error"';} ?> placeholder="Your biography"><?=$values['bio'];?></textarea>
              </label>
              <br>
              <label <?php if ($errors['yes']) {print 'class="error1"';} ?>>
              <input type="checkbox" <?php if($values['yes'] == "1") {print 'checked="checked"';}?> name="yess" value="1"> С контрактом ознакомлен
              </label>
              <br>
              <button class="btn btn-success">Отправить?</button>
            </form>
          </div>
          <div class="col-0 col-md-1">
          </div>
        </div>
    <footer>
      <div class="row color3 mt-2">
        <div class="col-12 ">
          <h2>
            (c)Матвей Скирда
          </h2>
        </div>
      </div>
    </footer>
  </body>
</html>
