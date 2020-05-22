<?php
header('Content-Type: text/html; charset=UTF-8');
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $messages = array();
  
  if (!empty($_COOKIE['save'])) {
      setcookie('save', '', 100000);
      setcookie('login', '', 100000);
      setcookie('pass', '', 100000);
      $messages[] = 'Спасибо, результаты сохранены.';
      if (!empty($_COOKIE['pass'])) {
          $messages[] = sprintf('Вы можете <a href="login.php">войти</a> с логином <strong>%s</strong>
        и паролем <strong>%s</strong> для изменения данных.',
              strip_tags($_COOKIE['login']),
              strip_tags($_COOKIE['pass']));
      }
  }

  $errors = array();
  $errors['fio'] = !empty($_COOKIE['fio_error']);
  $errors['email'] = !empty($_COOKIE['email_error']);
  $errors['bday'] = !empty($_COOKIE['bday_error']);
  $errors['sex'] = !empty($_COOKIE['sex_error']);
  $errors['lim'] = !empty($_COOKIE['lim_error']);
  $errors['abil'] = !empty($_COOKIE['abil_error']);
  $errors['bio'] = !empty($_COOKIE['bio_error']);
  $errors['yes'] = !empty($_COOKIE['yes_error']);

  if ($errors['fio']) {
    setcookie('fio_error', '', 100000);
    if($_COOKIE['fio_error'] == '1')
    $messages[] = '<div class="mesa">Заполните Имя.</div>';
    else $messages[] = '<div class="mesa">Недопустимые символы в Имени</div>';
  }
  
  if ($errors['email']) {
      setcookie('email_error', '', 100000);
      if($_COOKIE['email_error'] == 1)
          $messages[] = '<div class="mesa">Заполните Email.</div>';
          else $messages[] = '<div class="mesa">Недопустимые символы в Email</div>';
  }
  
  if ($errors['bday']) {
      setcookie('bday_error', '', 100000);
      if($_COOKIE['bday_error'] == 1)
          $messages[] = '<div class="mesa">Заполните Дату рождения.</div>';
          else $messages[] = '<div class="mesa">Недопустимый формат Дня рождения </div>';
  }
  
  if ($errors['sex']) {
      setcookie('sex_error', '', 100000);
      if($_COOKIE['sex_error'] == 1)
          $messages[] = '<div class="mesa">Выберете Пол.</div>';
          else $messages[] = '<div class="mesa">Недопустимый формат Пола </div>';
  }


  if ($errors['lim']) {
      setcookie('lim_error', '', 100000);
      if($_COOKIE['lim_error'] == 1)
          $messages[] = '<div class="mesa">Выберете Количество конечностей.</div>';
          else $messages[] = '<div class="mesa">Недопустимый формат Количество конечностей.</div>';
  }

  if ($errors['abil']) {
      setcookie('abil_error', '', 100000);
      if($_COOKIE['abil_error'] == 1)
          $messages[] = '<div class="mesa">Выберете Способность.</div>';
          else $messages[] = '<div class="mesa">Недопустимый формат Способности.</div>';
  }
  
  if ($errors['bio']) {
      setcookie('bio_error', '', 100000);
      $messages[] = '<div class="mesa">Заполните биографию.</div>';
  }
  
  if ($errors['yes']) {
      setcookie('yes_error', '', 100000);
      $messages[] = '<div class="mesa">Неверное значение С контрактом ознакомлен</div>';
  }
  
  if(isset($_COOKIE['token_error'])){
      setcookie('token_error', '', 100000);
      $messages[] = '<div class="mesa">Ошибка отправки формы</div>';
  }
  
  $values = array();
  
  if (isset($_COOKIE['fio_value']))
  $values['fio'] = !preg_match('/^[а-яА-Я ]+$/u',$_COOKIE['fio_value']) || empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
  else $values['fio']='';
  
  if (isset($_COOKIE['email_value']))
  $values['email'] = !preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u'
      ,$_COOKIE['email_value']) || empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
  else $values['email']='';
  
  if (isset($_COOKIE['bday_value']))
  $values['bday'] = !preg_match('/^\d\d\d\d\-\d\d\-\d\d$/' ,$_COOKIE['bday_value']) || empty($_COOKIE['bday_value']) ? '' : $_COOKIE['bday_value'];
  else $values['bday']='';
  
  if (isset($_COOKIE['sex_value']))
      $values['sex'] = !preg_match('/^WOM|MAN$/' ,$_COOKIE['sex_value']) || empty($_COOKIE['sex_value']) ? '' : $_COOKIE['sex_value'];
      else $values['sex']='';

  if (isset($_COOKIE['lim_value']))
      $values['lim'] = !preg_match('/^[0-4]$/' ,$_COOKIE['lim_value']) || empty($_COOKIE['lim_value']) ? '0' : $_COOKIE['lim_value'];
      else $values['lim']='0';

  if (isset($_COOKIE['abil_value'])){
      $abiln=unserialize($_COOKIE['abil_value']);
      $values['god'] = !preg_match('/^[0-1]$/' , $abiln['god']) || empty($abiln['god']) ? '0' : $abiln['god'];
      $values['twalk'] = !preg_match('/^[0-1]$/' ,$abiln['twalk']) || empty($abiln['twalk']) ? '0': $abiln['twalk'];
      $values['fly'] = !preg_match('/^[0-1]$/' ,$abiln['fly']) || empty($abiln['fly']) ? '0': $abiln['fly'];

  }
      else {
        $values['god']='0';
        $values['twalk']='0';
        $values['fly']='0';
      }
      
   if (isset($_COOKIE['bio_value']))
       $values['bio'] =  empty($_COOKIE['bio_value']) ? '' : strip_tags($_COOKIE['bio_value']);
       else $values['bio']='';
       
   if (isset($_COOKIE['yes_value']))
       $values['yes'] = $_COOKIE['yes_value'];
   else $values['yes']='0';
 

   if (empty(array_filter($errors)) && !empty($_COOKIE[session_name()]) &&
       session_start() && !empty($_SESSION['login'])) {
           // Загрузить данные пользователя из БД.
           printf('Вход с логином %s, uid %d', $_SESSION['login'], $_SESSION['uid']);
           
           $user = 'u20362';
           $pass = '5800777';
           $db = new PDO('mysql:host=localhost;dbname=u20362', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
           
           // Подготовленный запрос. Не именованные метки.
           try {
               $stmt = $db->prepare("SELECT * FROM Autouser WHERE id = ?");
               $stmt->execute(array($_SESSION['uid']));
           }
           catch(PDOException $e){
               print('Error : ' . $e->getMessage());
               exit();
           }
           
          
           
           $user_data = $stmt->fetchAll();
         
           $values['fio'] = !empty($user_data[0]['fio']) ? strip_tags($user_data[0]['fio']) : '';
           $values['email'] = !empty($user_data[0]['email']) ? strip_tags($user_data[0]['email']) : '';
           $values['bday'] = !empty($user_data[0]['bday']) ? date("Y-m-d",$user_data[0]['bday']) : '';
           $values['sex'] = !empty($user_data[0]['sex']) ? strip_tags($user_data[0]['sex']) : '';
           $values['lim'] = !empty($user_data[0]['lim']) ? $user_data[0]['lim'] : '0';
           $values['god'] = !empty($user_data[0]['god']) ? $user_data[0]['god'] : '';
           $values['twalk'] = !empty($user_data[0]['twalk']) ? $user_data[0]['twalk'] : '';
           $values['fly'] = !empty($user_data[0]['fly']) ? $user_data[0]['fly'] : '';
           $values['bio'] = !empty($user_data[0]['bio']) ? strip_tags($user_data[0]['bio']) : '';
           $values['yes'] = !empty($user_data[0]['yess']) ? $user_data[0]['yess'] : '';
       }  
   
  include('form.php');
}
else {
  $errors = FALSE;
  if (empty($_POST['fio'])) {
    setcookie('fio_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
  }
  else if(!preg_match('/^[а-яА-Я ]+$/u', $_POST['fio'])){
    setcookie('fio_error', '2', time() + 30 * 24 * 60 * 60);
    $errors = TRUE;
  }  else {
      setcookie('fio_value', $_POST['fio'], time() + 30 * 24 * 60 * 60);
  }
  
  if (empty($_POST['email'])) {
      setcookie('email_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
  } else if(!preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1})|([0-9А-Яа-я]{1}[-0-9А-я\.]{1,}[0-9А-Яа-я]{1}))@([-A-Za-z]{1,}\.){1,2}[-A-Za-z]{2,})$/u', $_POST['email']))
  {
      setcookie('email_error', '2', time() + 30 * 24 * 60 * 60);
      $errors = TRUE;
  }  else {
      setcookie('email_value', $_POST['email'], time() + 30 * 24 * 60 * 60);
  }
  
  if (empty($_POST['bday'])) {
      setcookie('bday_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
  } else if(!preg_match('/^\d\d\d\d\-\d\d\-\d\d$/', $_POST['bday']))
  {
      setcookie('bday_error', '2', time() + 30 * 24 * 60 * 60);
      $errors = TRUE;
  }  else {
      setcookie('bday_value', $_POST['bday'], time() + 30 * 24 * 60 * 60);
  }
  
  if (empty($_POST['sex'])) {
      setcookie('sex_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
  } else if(!preg_match('/^WOM|MAN$/', $_POST['sex']))
  {
      setcookie('sex_error', '2', time() + 30 * 24 * 60 * 60);
      $errors = TRUE;
  }  else {
      setcookie('sex_value', $_POST['sex'], time() + 30 * 24 * 60 * 60);
  }

    if (empty($_POST['lim']) && $_POST['lim']!='0') {
      setcookie('lim_error', '1', time() + 24 * 60 * 60);
      $errors = TRUE;
  } else if(!preg_match('/^[0-4]$/', $_POST['lim']))
  {
      setcookie('lim_error', '2', time() + 30 * 24 * 60 * 60);
      $errors = TRUE;
  }  else {
      setcookie('lim_value', $_POST['lim'], time() + 30 * 24 * 60 * 60);
  }

  $ability_labels = ['god' => 'Бессмертие', 'twalk' => 'Прохождение сквозь стены', 'fly' => 'Левитация' ];
  $ability_data = array_keys($ability_labels);
  $error_ab = FALSE;
  if (empty($_POST['abilities'])) {
    setcookie('abil_error', '1', time() + 24 * 60 * 60);
    $errors = TRUE;
    $error_ab = TRUE;
  }
  else{
  $abilities = $_POST['abilities'];
  foreach ($abilities as $ability) {
    if (!in_array($ability, $ability_data)) {
      setcookie('abil_error', '2', time() + 24 * 60 * 60);
      $errors = TRUE;
      $error_ab = TRUE;
      }
    }
    }
    if(!$error_ab) {
      $ability_insert = [];
      foreach ($ability_data as $ability) {
      $ability_insert[$ability] = in_array($ability, $abilities) ? 1 : 0;
      setcookie('abil_value', serialize($ability_insert) , time() + 30 * 24 * 60 * 60);
    }
    }
    
    if (empty($_POST['bio'])) {
        setcookie('bio_error', '1', time() + 24 * 60 * 60);
        $errors = TRUE;
    } else {
        setcookie('bio_value', $_POST['bio'], time() + 30 * 24 * 60 * 60);
    }
    
    if (!empty($_POST['yess']) && $_POST['yess']!='1' )
    {
        setcookie('yes_error', '1', time() + 30 * 24 * 60 * 60);
        $errors = TRUE;
    }  else {
        if(empty($_POST['yess'])) $_POST['yess']='2';
        setcookie('yes_value', $_POST['yess'], time() + 30 * 24 * 60 * 60);
    }
    
  if ($errors) {
    header('Location: index.php');
    exit();
  }
  else {
    setcookie('fio_error', '', 100000);
    setcookie('email_error', '', 100000);
    setcookie('bday_error', '', 100000);
    setcookie('sex_error', '', 100000);
    setcookie('lim_error', '', 100000);
    setcookie('abil_error', '', 100000);
    setcookie('bio_error', '', 100000);
    setcookie('yes_error', '', 100000);
    setcookie('token_error', '', 100000);
  }
  
  if (!empty($_COOKIE[session_name()]) &&
      session_start() && !empty($_SESSION['login'])) {
          // Перезаписать данные в БД новыми данными,
          $user = 'u20362';
          $pass = '5800777';
          $db = new PDO('mysql:host=localhost;dbname=u20362', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
          if($_SESSION['token'] != $_POST['client-token']){
              setcookie('token_error', '1', time() + 30 * 24 * 60 * 60);  
              header('Location: index.php');
              exit();
          }
          // Подготовленный запрос. Не именованные метки.
          try {
              $_POST['bday']=strtotime($_POST['bday']);
              if($_POST['yess'] == 2) $_POST['yess'] = 0;
              $parametr=array($_POST['fio'],$_POST['email'],$_POST['bday'],$_POST['sex'],$_POST['lim'],$ability_insert['god'],$ability_insert['twalk'],$ability_insert['fly'],$_POST['bio'],$_POST['yess'],$_SESSION['uid']);
              $stmt = $db->prepare("UPDATE Autouser SET fio = ?,email = ?,bday = ?,sex = ?,lim = ?,god = ?,twalk = ?,fly = ?,bio = ?,yess = ?  WHERE id = ?");
              $stmt->execute($parametr);
          }
          catch(PDOException $e){
              print('Error : ' . $e->getMessage());
              exit();
          }
      }
      else {
          $userb = 'u20362';
          $passb = '5800777';
          $db = new PDO('mysql:host=localhost;dbname=u20362', $userb, $passb, array(PDO::ATTR_PERSISTENT => true));
          
          $pass=substr(md5(uniqid()),0,8);
          try {
              $params=array($pass);
              $stmt = $db->prepare("INSERT INTO Autouser SET password = md5(?)");
              $stmt -> execute($params);
          }
          catch(PDOException $e){
              print('Error : ' . $e->getMessage());
              exit();
          }
          $current_id=$db->lastInsertId();
          $login = 'user'.$current_id;
          // Сохраняем в Cookies.
          try {
              $params=array($login,$current_id);
              $stmt = $db->prepare("UPDATE Autouser SET login = ? WHERE id = ?");
              $stmt -> execute($params);
          }
          catch(PDOException $e){
              print('Error : ' . $e->getMessage());
              exit();
          }
          
          try {
              $_POST['bday']=strtotime($_POST['bday']);
              if($_POST['yess'] == 2) $_POST['yess'] = 0;
              $params=array($_POST['fio'],$_POST['email'],$_POST['bday'],$_POST['sex'],$_POST['lim'],$ability_insert['god'],$ability_insert['twalk'],$ability_insert['fly'],$_POST['bio'],$_POST['yess'],$current_id);
              $stmt = $db->prepare("UPDATE Autouser SET fio = ?,email = ?,bday = ?,sex = ?,lim = ?,god = ?,twalk = ?,fly = ?,bio = ?,yess = ?  WHERE id = ?");
              $stmt->execute($params);
          }
          
          catch(PDOException $e){
              print('Error : ' . $e->getMessage());
              exit();
          }
          
          setcookie('login', $login);
          setcookie('pass', $pass);       
      }
      
  
  setcookie('save', '1');
  header('Location: index.php');
}
