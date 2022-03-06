<?
require_once('./database.php');

if(!isset($_POST)){
	die(json_encode(['status' => '0', 'message' => 'Ошибка получения данных!']));
}

foreach($_POST as $key => $p){
	$_POST[$key] = strip_tags(trim($p));
	if(count($p) == 0){
		die(json_encode(['status' => '0', 'message' => 'Имеются незаполненные строки!']));
	}
}

$query = "INSERT INTO connect(name, email, gender, year, agree, topic, text) 
VALUES (:name, :email, :gender, :year, 1, :topic, :text)";


$params = [
	'name' => $_POST['name'],
	'email' => $_POST['email'],
	'gender' => $_POST['gender'],
	'year' => $_POST['year'],
	'topic' => $_POST['topic'],
	'text' => $_POST['text']

];

if (DataBase::dbInsert($query, $params)){
	setcookie('name', $_POST['name']);
	setcookie('email', $_POST['email']);
	setcookie('year', $_POST['year']);
	setcookie('gender', $_POST['gender']);
	die(json_encode(['status' => '1', 'message' => 'Данные отправлены успешно!']));
}else{
	die(json_encode(['status' => '0', 'message' => 'Ошибка отправки данных!']));
}
