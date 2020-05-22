<?php

/**
 * Файл login.php для не авторизованного пользователя выводит форму логина.
 * При отправке формы проверяет логин/пароль и создает сессию,
 * записывает в нее логин и id пользователя.
 * После авторизации пользователь перенаправляется на главную страницу
 * для изменения ранее введенных данных.
 **/

// Отправляем браузеру правильную кодировку,
// файл login.php должен быть в кодировке UTF-8 без BOM.
header('Content-Type: text/html; charset=UTF-8');

// Начинаем сессию.
session_start();

// В суперглобальном массиве $_SESSION хранятся переменные сессии.
// Будем сохранять туда логин после успешной авторизации.
if (!empty($_SESSION['login'])) {
  // Если есть логин в сессии, то пользователь уже авторизован.
  // TODO: Сделать выход (окончание сессии вызовом session_destroy()
  //при нажатии на кнопку Выход).
  // Делаем перенаправление на форму.
  header('Location: ./');
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    if(isset($_COOKIE['autor_error'])){
        print('Ошибка авторизации. Побробуйте снова');
        $login_value= isset($_COOKIE['login_value']) ? $_COOKIE['login_value'] : '';
    }
    setcookie('autor_error', '', 100000); 
    setcookie('login_value', '', 100000);
?>
<form action="" method="post">
  <input name="login" value="<?php !empty($login_value) ? print $login_value : '' ?>" />
  <input name="pass" />
  <input type="submit" value="Войти" />
</form>

<?php
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
    
    $user = 'u20397';
    $pass = '5245721';
    $db = new PDO('mysql:host=localhost;dbname=u20397', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
  // Подготовленный запрос. Не именованные метки.
  try {
    $stmt = $db->prepare("SELECT id FROM utable WHERE login = ? AND password = md5(?)");
    $stmt->execute(array($_POST['login'], $_POST['pass']));
  }
  catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
  } 
 
  $user_id = $stmt->fetchAll();
  if (!empty($user_id[0]['id'])) {
    setcookie('autor_error', '', 100000);
    setcookie('login_value', '', 100000);
    // Если все ок, то авторизуем пользователя.
    $_SESSION['login'] = $_POST['login'];
    // Записываем ID пользователя.
    $_SESSION['uid'] = $user_id[0]['id'];
    // Делаем перенаправление.
    header('Location: ./');
  }
  else {
    setcookie('autor_error', '1', time() + 24 * 60 * 60);
    setcookie('login_value',$_POST['login'], time() + 24 * 60 * 60);
    // Делаем перенаправление.
    header('Location: ./login.php');
  }
  
}
