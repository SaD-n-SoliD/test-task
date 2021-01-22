<?php

ini_set('session.gc_maxlifetime', 7200);
session_start();

$app = json_decode($_SESSION['app'], true);

function conclusion_information($string)
{
	echo json_encode($string);
	exit();
}

if (!$app) {
	conclusion_information('Кредит ещё не рассчитан!');
}

if (json_encode($app) == $_SESSION['last_app']) {
	conclusion_information('Вы уже отправляли эту заявку!');
}

require_once 'connection.php';

// отправка письма

$input = $app['input'];
$res = $app['res'];
$table = $app['table1'];

$arr = [
	'ФИО' => $input['full-name'],
	'Номер телефона' => $input['phone'],
	'Сумма кредита' => $input['credit-sum'],
	'Срок в годах' => $input['years'],
	'Cтавка, % в год' => $input['percent'],
	'Ежемесячный платёж' => $res['monthly-payment'],
	'Сумма выплаченных процентов' => $res['overpayment'],
	'Дата последнего платежа' => $res['last-payment-date']
];

function buildStr($arr)
{
	$str = '';
	foreach ($arr as $key => $value) {
		$str .= "<p>$key: <b>$value</b></p>";
	}
	return $str;
}
function mkTable($table)
{
	$str = "
		<style>
			table td {
				border: 1px solid black;
				padding: 10px;
			}
		</style>
	";
	$str .= '<table>';
	foreach ($table as $line) {
		$str .= "<tr>";
		foreach ($line as $value) {
			$str .= "<td>$value</td>";
		}
		$str .= "</tr>";
	}
	$str .= '</table>';
	return $str;
}
$recepient = "yodas.human@yandex.ru";
$siteName = "test-task(yodas.human@yandex.ru)";
$message = buildStr($arr) . mkTable($table);
$pageTitle = "Вам пришла новая заявка с сайта \"$siteName\"";
$headers = "Content-type: text/html; charset=\"utf-8\"\r\nFrom: application";

$isSent = mail($recepient, $pageTitle, $message, $headers);

if ($isSent) {
	echo json_encode(['Ваша заявка успешно принята.']);
} else {
	conclusion_information('Ваша заявка не доставлена.');
}

// конец отправки письма

function mkQuery()
{
	global $input, $res, $table, $pdo;
	$arr = array_merge($input, $res, ['table1' => json_encode($table)]);
	$query = 'INSERT INTO applications (';
	foreach ($arr as $key => $value) {
		$query .= '`' . $key . '`, ';
	}
	$query = substr($query, 0, -2) . ') VALUES (';
	foreach ($arr as $value) {
		$с = '';
		if (gettype($value) === 'string') $c = '\'';
		$query .= $c . $value . $c . ', ';
	}
	$query = substr($query, 0, -2) . ')';
	$pdo->query($query);
	// echo json_encode($query);
}

mkQuery();

$_SESSION['last_app'] = json_encode($app);
$_SESSION['app'] = null;
