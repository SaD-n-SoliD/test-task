<?php
ini_set('session.gc_maxlifetime', 7200);
session_start();
//------------------VALIDATION---------------------------------------

$validation = true;

//------------------VALIDATION---------------------------------------
mb_internal_encoding("utf-8");
function conclusion_information($string)
{
	$_SESSION['app'] = null;
	echo json_encode($string);
	exit();
}
function post_filter($field)
{
	return filter_var(trim($_POST[$field]), FILTER_SANITIZE_STRING);
}
function check_name($name)
{
	$match = array();
	$reg = "/^([a-zа-яё]+\s+){2}[a-zа-яё]+\s*$/iu";
	if (mb_strlen($name) === 0) conclusion_information("Введите ФИО");
	else if (mb_strlen($name) < 5) conclusion_information("ФИО слишком короткое");
	else if (mb_strlen($name) > 60) conclusion_information("ФИО слишком длинное");
	else if (!preg_match($reg, $name, $match)) conclusion_information("Некорректное ФИО");
}

function check_phone($phone)
{
	$match = array();
	$reg = "/^\+7 \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$/i";
	if (mb_strlen($phone) === 0) conclusion_information("Введите номер телефона");
	else if (mb_strlen($phone) < 18) conclusion_information("Номер слишком короткий");
	else if (mb_strlen($phone) > 18) conclusion_information("Номер слишком длинный");
	else if (!preg_match($reg, $phone, $match)) conclusion_information("Некорректный номер телефона");
}
function check_num(&$num, $errMsg)
{
	global $validation;
	$num = preg_replace('/\s/', '', $num);
	preg_match("/\d+(\.|,)?\d*/", $num, $m);
	if ($validation) {
		if (count($m) === 0) conclusion_information($errMsg);
	}
	$num = (float) preg_replace('/,/', '.', $m[0]);
}
$credit_sum = post_filter('credit-sum');
$years = post_filter('years');
$percent = post_filter('percent');
$name = post_filter('full-name');
$phone = post_filter('phone');
// $credit_sum = '100 000';
// $years = '1';
// $percent = '20';
// $name = 'Николаев Николай Николаевич';
// $phone = '+7 (444) 444-44-44';

check_num($credit_sum, 'Введите сумму кредита');
check_num($years, 'Введите кол-во лет');
check_num($percent, 'Введите процентную ставку');

if ($validation) {
	check_name($name);
	check_phone($phone);
}

$i = $percent / 100 / 12;
$n = floor($years * 12);
$p = $credit_sum * ($i + $i / (($i + 1) ** ($n) - 1));
$overpayment = $p * $n - $credit_sum;
$last_date = date('d.m.Y', mktime(0, 0, 0, date("m") + $n - 1, date("d"),   date("Y")));

$table = [];
array_push($table, [
	'date' => 'Дата',
	'monthly-payment' => 'Ежемесячный платёж, руб.',
	'repayment-of-interest' => 'Погашение процентов, руб.',
	'loan-repayment' => 'Погашение кредита, руб.',
	'balance-owed' => 'Остаток долга, руб.'
]);
$sn = $credit_sum;
for ($j = 0; $j < $n; $j++) {
	$tmp = [
		'date' => date('d.m.Y', mktime(0, 0, 0, date("m") + $j, date("d"),   date("Y"))),
		'monthly-payment' => round($p, 2),
		'repayment-of-interest' => round($mem = $sn * $i, 2),
		'loan-repayment' => round($mem = $p - $mem, 2),
		'balance-owed' => round($mem = $sn - $mem, 2)
	];
	$sn = $mem;
	array_push($table, $tmp);
}

$ans = json_encode([
	'input' => [
		'credit-sum' => $credit_sum,
		'years' => $years,
		'percent' => $percent,
		'full-name' => $name,
		'phone' => $phone
	],
	'res' => [
		'monthly-payment' => round($p, 2),
		'overpayment' => round($overpayment, 2),
		'last-payment-date' => $last_date
	],
	'table1' => $table
]);

$_SESSION['app'] = $ans;

echo $ans;
