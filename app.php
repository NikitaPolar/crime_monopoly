<?php

/*

1) Текущая позиция
2) Деньги



1) Купить, отправить на аукцион
2) Сдаться
3) Запросить ход
4) обновления игры (соперник кинул кубы, показать их, показать предложения о покупке)


Карточки - массив
	владелец
	уровень прокачки
	бизнес тип 
*/

require  './vendor/autoload.php';
require  'nonvisdata.php';
use Krugozor\Database\Mysql\Mysql as Mysql;

$db = Mysql::create($host, $malogin, $mysqlpass)
	->setDatabaseName("monopoly")
	->setCharset("utf8");

if (isset($_GET['action']) and isset($_GET['pos']) and isset($_GET['game_id']) and isset($_GET['player_id'])) {
	$action = $_GET['action'];
	$position = $_GET['pos'];
	$game_id = $_GET['game_id'];
	$player_id = $_GET['player_id'];
} else {
	echo 'params err';
	die();
}

if ($action == 'step') {
	$result = $db->query("SELECT * FROM `steps` WHERE `game_id` = '?i' AND `player_id` = ?i ORDER BY id DESC LIMIT 1", $game_id, $player_id);
	$data = $result->fetch_assoc();
	$position = $data['endpos'];
	print_r($data);
	
	
	
	$cube[0] = mt_rand(1, 6);
	$cube[1] = mt_rand(1, 6);
	$position += $cube[0] + $cube[1];

	// 39 - максимальная позиция на поле, дальше с нуля
	if ($position > 39) {
		$position -= 39;
		$data['money'] += 2000;
	}
	
	/*
	
	Здесь мы разбираем каждую карту и считаем что происходит
	
	*/
	
	$result = $db->query("INSERT INTO `steps` (`id`, `player_id`, `game_id`, `cube_1`, `cube_2`, `money`, `endpos`) VALUES (NULL, '?i', '?i', '?i', '?i', '?i', '?i')", 
	$data['player_id'],
	$data['game_id'],
	$cube[0],
	$cube[1],
	$data['money'],
	$position);
	
	$server_output['cube'][0] = $cube[0];
	$server_output['cube'][1] = $cube[1];
	$server_output['endpos'] = $position;
	echo json_encode($server_output);
	
} elseif ($action == 'buy') {
	
} elseif ($action == 'auction') {
	
} elseif ($action == 'giveup') {
	
}




?>