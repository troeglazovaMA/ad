<?php


function http401(){
    header('HTTP/1.1 401 Unanthorized');
    header('WWW-Authenticate: Basic realm="Project"');
    print('<h1>Повторите Авторизацию</h1>');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    
if (empty($_SERVER['PHP_AUTH_USER']) ||
    empty($_SERVER['PHP_AUTH_PW']))  {
    http401();
} else 
{
    if (preg_match('/^[a-z]+$/u',$_SERVER['PHP_AUTH_USER']) && preg_match('/^[a-zA-Z0-9]+$/u',$_SERVER['PHP_AUTH_PW'])){
    $user = 'u20397';
    $pass = '5245721';
    $db = new PDO('mysql:host=localhost;dbname=u20397', $user, $pass, array(PDO::ATTR_PERSISTENT => true));   
    try {
        $stmt = $db->prepare("SELECT * FROM atable WHERE adlog=? AND adpass=md5(?)");
        $stmt->execute(array($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']));
    }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }
    $count = $stmt->rowCount();
    
    if ($count == '0') http401();
   }
   else http401();
}

$user = 'u20397';
$pass = '5245721';
$db = new PDO('mysql:host=localhost;dbname=u20397', $user, $pass, array(PDO::ATTR_PERSISTENT => true));

try {
    $stmt = $db->prepare("SELECT * FROM Autouser");
    $stmt->execute();
}
catch(PDOException $e){
    print('Error : ' . $e->getMessage());
    exit();
}
$users_data= $stmt->fetchAll();
$values=[];
foreach ($users_data as $row){
    $fio = strip_tags($row['fio']);
    $email = strip_tags($row['email']);
    $bday = date("Y-m-d",intval($row['bday']));
    $sex= $row['sex'] == 'MAN'? 'муж.': 'жен.';
    $lim=(int)$row['lim'];
    $abilites=[];
    if(!empty($row['god'])){
        $abilites[]='Бессмертие';
    }
    if(!empty($row['twalk'])){
        $abilites[]='Прохождение сквозь стены';
    }
    if(!empty($row['fly'])){
        $abilites[]='Левитация';
    }
    $abilites=implode(',',$abilites);
    $bio=strip_tags($row['bio'],'<a>');
    $yes= $row['yess'] == '1'? 'Да' :'Нет';
    
    
    $values[$row['id']]= [
        $fio,
        $email,
        $bday,
        $sex,
        $lim,
        $abilites,
        $bio,
        $yes   
    ];
}

print('Добро пожаловать в управление системой.');
$values_lables=['Имя','Email','Дата рождения','Пол','Количество конечностей','Способности','Биография','Ознакомлен с контрактом','Удалить'];
include 'table.php';
print('<br>');

}
else {
    $user = 'u20397';
    $pass = '5245721';
    $db = new PDO('mysql:host=localhost;dbname=u20397', $user, $pass, array(PDO::ATTR_PERSISTENT => true));
    // Подготовленный запрос. Не именованные метки.
    try {
        $params=array($_POST['todelete']);
        $stmt = $db->prepare("DELETE FROM utable WHERE id = ?");
        $stmt->execute($params);
    }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    } 
    
    header('Location: admin.php');
}

// *********
// Здесь нужно прочитать отправленные ранее пользователями данные и вывести в таблицу.
// Реализовать просмотр и удаление всех данных.
// *********
