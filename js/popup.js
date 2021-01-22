window.addEventListener('load', () => {

	const popup = document.getElementById('popup');
	const body = document.querySelector('body');
	const trigger = document.querySelector('.popup-trigger');
	const area = popup.querySelector('.popup__area');

	popup.addEventListener('click', (e) => {
		e.preventDefault();
		const target = e.target;
		let closeArr = ['popup___close', 'popup__cross', 'popup__area', 'popup__button'];
		closeArr.forEach((cls) => {
			if (target.classList.contains(cls)) {
				popup.classList.remove('popup_active');
				body.classList.remove('body_lock2');
			}
		});
	});

	trigger.addEventListener('click', (e) => {
		e.preventDefault();
		area.style.height = `${popup.scrollHeight}px`;
		popup.classList.add('popup_active');
		body.classList.add('body_lock2');
	});
});