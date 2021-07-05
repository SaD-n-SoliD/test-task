window.addEventListener('load', () => {

	//------------------------FIELD RESET IF VALID----------------------------------------

	const fieldReset = false;

	//------------------------FIELD RESET IF VALID----------------------------------------

	const form = document.querySelector('.input__form');
	const htmlFields = document.querySelectorAll('.input__field');
	const resultsHtml = document.querySelectorAll('.results__field');
	const serverAnswerHtml = document.querySelector('.calc-error');
	const sendErrorHtml = document.querySelector('.send-error');
	const table = document.querySelector('.popup__table');
	const errorNoTable = document.querySelector('.error_no-table');
	const popupContent = document.querySelector('.popup__content');

	async function getServerAnswer() {
		let response = await fetch('calc.php', {
			method: 'POST',
			body: new FormData(form)
		});
		if (response.ok) {
			let ans = await response.json();
			// console.log(ans);

			if (typeof ans !== 'string') {
				popupContent.classList.remove('tac');
				errorNoTable.classList.add('hidden');
				serverAnswerHtml.classList.add('green');
				serverAnswerHtml.classList.remove('red');
				serverAnswerHtml.innerText = 'Параметры рассчитаны!';
				if (fieldReset) {
					htmlFields.forEach((el) => {
						el.value = '';
					});
				}
			}
			else {
				resultsHtml.forEach((el) => {
					el.innerHTML = '';
				});
				popupContent.classList.add('tac');
				errorNoTable.classList.remove('hidden');
				serverAnswerHtml.classList.remove('green');
				serverAnswerHtml.classList.add('red');
				serverAnswerHtml.innerText = ans;
			}
			sendErrorHtml.innerHTML = '';
			serverAnswerHtml.focus();
			serverAnswerHtml.classList.add('blink');
			setTimeout(() => {
				serverAnswerHtml.classList.remove('blink');
			}, 1000);

			for (let i in ans['res']) {
				document.querySelector(`.${i}`).innerText = ans['res'][i];
			}

			table.innerHTML = '';
			for (let i in ans['table1']) {
				let t = ans['table1'][i];
				table.innerHTML += `
					<tr>
						<td>${t['date']}</td>
						<td>${t['monthly-payment']}</td>
						<td>${t['repayment-of-interest']}</td>
						<td>${t['loan-repayment']}</td>
						<td>${t['balance-owed']}</td>
					</tr>
				`;
			}
		}
		else {
			serverAnswerHtml.innerHTML = 'Ошибка соединения с сервером: ' + response.status;
			serverAnswerHtml.classList.remove('hidden');
			serverAnswerHtml.focus();
			serverAnswerHtml.classList.add('blink');
			setTimeout(() => {
				serverAnswerHtml.classList.remove('blink');
			}, 1000);
		}

	}

	form.addEventListener('submit', (e) => {
		e.preventDefault();
		getServerAnswer();
	});
});