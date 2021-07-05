window.addEventListener('load', () => {

	const button = document.querySelector('.results__btn');
	const serverAnswerHtml = document.querySelector('.send-error');
	const calcErrorHtml = document.querySelector('.calc-error');

	async function send() {
		let response = await fetch('send.php', {
			method: 'POST',
			body: {}
		});
		if (response.ok) {
			let ans = await response.json();
			// console.log(ans);
			if (typeof ans !== 'string') {
				ans = ans[0];
				serverAnswerHtml.classList.add('green');
				serverAnswerHtml.classList.remove('red');
				calcErrorHtml.innerHTML = '';
			} else {
				serverAnswerHtml.classList.remove('green');
				serverAnswerHtml.classList.add('red');
			}
			serverAnswerHtml.innerHTML = ans;
		}
		else {
			serverAnswerHtml.innerHTML = 'Ошибка соединения с сервером: ' + response.status;
		}

		serverAnswerHtml.classList.remove('hidden');
		serverAnswerHtml.focus();
		serverAnswerHtml.classList.add('blink');
		setTimeout(() => {
			serverAnswerHtml.classList.remove('blink');
		}, 1000);

		// htmlFields.forEach((el) => {
		// 	el.value = '';
		// });

	}

	button.addEventListener('click', () => {
		send();
	});
});