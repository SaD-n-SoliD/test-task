<!DOCTYPE html>
<html lang="ru">

<head>
	<title>Калькулятор кредитов</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/main-style.css">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<script src="js/header.js"></script>
	<script src="js/form.js"></script>
	<script src="js/mask.js"></script>
	<script src="js/send.js"></script>
	<script src="js/popup.js"></script>
</head>

<body>
	<div class="wrapper">

		<header class="header header_hidden">
			<div class="header__body text_header">
				<span class="full-name">ФИО</span>
				<span class="phone">Телефон</span>
				<span class="email">Почта</span>
				<span class="header__btn">Показать контакты</span>
			</div>
		</header>

		<main class="main">
			<div class="input">
				<form class="input__form violet-border text_fields" action="#" method="POST">
					<p class="input__form-title text_lil-title">Калькулятор кредитов</p>
					<label class="input__label" for="credit-sum">Сумма кредита</label>
					<input class="input__field" id="credit-sum" name="credit-sum" type="text">

					<label class="input__label" for="years">Срок в годах</label>
					<input class="input__field" id="years" name="years" type="text">

					<label class="input__label" for="percent">Cтавка, % в год</label>
					<input class="input__field" id="percent" name="percent" type="text">

					<label class="input__label" for="full-name">ФИО</label>
					<input class="input__field" id="full-name" name="full-name" type="text">

					<label class="input__label" for="phone">Номер телефона</label>
					<input class="input__field" id="phone" name="phone" type="tel">

					<input class="input__btn btn" type="submit">
					<p class="calc-error green"></p>
				</form>
			</div>

			<div class="results">
				<div class="results__body violet-border text_fields">
					<p class="results__title text_lil-title">Результаты расчётов</p>
					<p>Ежемесячный платёж:</p>
					<p class="results__field monthly-payment"></p>
					<p>Сумма выплаченных процентов:</p>
					<p class="results__field overpayment"></p>
					<p>Дата последнего платежа:</p>
					<p class="results__field last-payment-date"></p>
					<button class="results__btn btn">Оставить заявку</button>
					<p class="send-error red"></p>
				</div>
			</div>

			<div class="show-table">
				<button class="btn show-table__btn popup-trigger">Показать график выплат</button>
			</div>

			<div id="popup" class="popup">
				<div class="popup__body">
					<a href="##" class="popup__area"></a>
					<div class="popup__content tac">
						<a href="##" class="popup___close"><span class="popup__cross"></span></a>
						<div class="popup__text">
							<p class="error_no-table red">Кредит ещё не рассчитан!</p>
							<table class="popup__table">

							</table>
						</div>
						<a href="##" class="btn popup__button text_lil-title">Закрыть</a>
					</div>
				</div>
			</div>
		</main>

		<footer class="footer">
			<div class="footer__body text_header">
				<span class="full-name">ФИО</span>
				<span class="phone">Телефон</span>
				<span class="email">Почта</span>
			</div>
		</footer>

	</div>
</body>

</html>