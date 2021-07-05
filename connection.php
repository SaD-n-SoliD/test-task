<?php

$PDO_user = 'root';
$PDO_pass = 'root';
$host = 'localhost';
$dbname = 'test-task';
try {
	$pdo = new PDO("mysql:host=$host; dbname=$dbname; charset=utf8", $PDO_user, $PDO_pass);
	$pdo->query("SET NAMES utf8");
	$pdo->query("SET COLLATION_CONNECTION=utf8_general_ci");
} catch (PDOException $e) {
	echo json_encode('Ошибка! Не удалось подключиться к БД.');
	exit;
}
