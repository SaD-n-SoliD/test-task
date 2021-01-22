window.addEventListener('load', () => {
	document.querySelector('.header__btn').addEventListener('click', function () {
		const header = this.closest('.header');
		header.classList.toggle('header_hidden');
		if (header.classList.contains('header_hidden')) {
			this.innerText = 'Показать контакты';
		} else {
			this.innerText = 'Скрыть контакты';
		}
	});

});