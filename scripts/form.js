let inputName = document.querySelector('#name')
let inputEmail = document.querySelector('#email')
let inputYear = document.querySelector('#year')
let inputGender = document.querySelector('#gender')
let inputTopic = document.querySelector('#topic')
let text = document.querySelector('#text')
let agreeCheckbox = document.querySelector('#agree-checkbox')
let submitButton = document.querySelector('#submit-button')
let formMsg = document.querySelector('.form-msg')
let msgBlock = document.querySelector('#name-wrong-msg')

const form = document.querySelector('#form')

document.querySelector('#agree-checkbox-link').addEventListener('click', () => {
	agreeCheckbox.checked = !agreeCheckbox.checked
	let msgBlock = document.querySelector('#agree-checkbox-wrong-msg')
	if(agreeCheckbox.checked){
		msgBlock.classList.remove('wrong-msg__show')
	}
})

agreeCheckbox.addEventListener('change', () => {
	let msgBlock = document.querySelector('#agree-checkbox-wrong-msg')
	if(agreeCheckbox.checked){
		msgBlock.classList.remove('wrong-msg__show')
	}
})

inputName.addEventListener('change', () => {
	let msgBlock = document.querySelector('#name-wrong-msg')
	if (inputName.value.match('^[А-Яа-я]{1,}$') === null){
		msgBlock.innerText = 'Имя должно содержать только символы А-я. Например: "Иван".'
		msgBlock.classList.add('wrong-msg__show')
	}else{
		msgBlock.classList.remove('wrong-msg__show')
	}
})

inputEmail.addEventListener('change', () => {
	let msgBlock = document.querySelector('#email-wrong-msg')
	if (inputEmail.value.match('^[0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1}.@[0-9A-Za-z]{1,}\.[A-Za-z]{2,}$') === null){
		msgBlock.innerText = 'Введите E-mail в формате "username@mail.ru".'
		msgBlock.classList.add('wrong-msg__show')
	}else{
		msgBlock.classList.remove('wrong-msg__show')
	}
})

inputYear.addEventListener('change', () => {
	let msgBlock = document.querySelector('#year-wrong-msg')
	if (inputYear.value.match('^[12][09][0-9]{2}$') === null || inputYear.value > 2022){
		msgBlock.innerText = 'Введите год рождения в формате "2020". Диапазон ввода 1900 - 2022.'
		msgBlock.classList.add('wrong-msg__show')
	}else{
		msgBlock.classList.remove('wrong-msg__show')
	}
})

inputTopic.addEventListener('change', () => {
	let msgBlock = document.querySelector('#topic-wrong-msg')
	if (inputTopic.value.length == 0){
		msgBlock.innerText = 'Поле не может быть пустым.'
		msgBlock.classList.add('wrong-msg__show')
	}else{
		msgBlock.classList.remove('wrong-msg__show')
	}
})

text.addEventListener('change', () => {
	let msgBlock = document.querySelector('#text-wrong-msg')
	if (text.value.length < 50){
		msgBlock.innerText = 'Опишите суть обращения. Введите не менее 50 символов.'
		msgBlock.classList.add('wrong-msg__show')
	}else{
		msgBlock.classList.remove('wrong-msg__show')
	}
})

document.querySelector('.form-msg__try-link').addEventListener('click', () => {
	formMsg.classList.remove('form-msg_show')
	document.querySelector('.form-msg__back-link').classList.remove('form-msg_show')
	document.querySelector('.form-msg__try-link').classList.remove('form-msg_show')
	form.classList.remove('shop-form__disable')
})

const checkForm = () => {
	check = true
	if(inputName.value.length == 0){
		let msgBlock = document.querySelector('#name-wrong-msg')
		msgBlock.innerText = 'Поле не может быть пустым.'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}
	if (inputName.value.match('^[А-Яа-я]{1,}$') === null){
		let msgBlock = document.querySelector('#name-wrong-msg')
		msgBlock.innerText = 'Имя должно содержать только символы А-я. Например: "Иван".'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}
	if(inputEmail.value.length == 0){
		let msgBlock = document.querySelector('#email-wrong-msg')
		msgBlock.innerText = 'Поле не может быть пустым.'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}

	if (inputEmail.value.match('^[0-9A-Za-z]{1}[-0-9A-z\.]{1,}[0-9A-Za-z]{1}.@[0-9A-Za-z]{1,}\.[A-Za-z]{2,}$') === null){
		let msgBlock = document.querySelector('#email-wrong-msg')
		msgBlock.innerText = 'Введите E-mail в формате "username@mail.ru".'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}

	if(inputYear.value.length == 0 || inputYear.value > 2022){
		let msgBlock = document.querySelector('#year-wrong-msg')
		msgBlock.innerText = 'Поле не может быть пустым.'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}


	if (inputYear.value.match('^[12][09][0-9]{2}$') === null){
		let msgBlock = document.querySelector('#year-wrong-msg')
		msgBlock.innerText = 'Введите год рождения в формате "2020". Диапазон ввода 1900 - 2022.'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}

	if(inputTopic.value.length == 0){
		let msgBlock = document.querySelector('#topic-wrong-msg')
		msgBlock.innerText = 'Поле не может быть пустым.'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}

	if (inputTopic.value.length == 0){
		let msgBlock = document.querySelector('#topic-wrong-msg')
		msgBlock.innerText = 'Поле не может быть пустым.'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}

	if(text.value.length == 0){
		let msgBlock = document.querySelector('#text-wrong-msg')
		msgBlock.innerText = 'Поле не может быть пустым.'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}

	if (text.value.length < 50){
		let msgBlock = document.querySelector('#text-wrong-msg')
		msgBlock.innerText = 'Опишите суть обращения. Введите не менее 50 символов.'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}

	if(!agreeCheckbox.checked){
		let msgBlock = document.querySelector('#agree-checkbox-wrong-msg')
		msgBlock.innerText = 'Вы не согласились с правилами.'
		msgBlock.classList.add('wrong-msg__show')
		check = false
	}
	return check
}

submitButton.addEventListener('click', async () => {
	if(checkForm()){
		let params = new FormData(form)

		let response = await fetch('/connect/submit', {
			method: 'POST',
			body: new FormData(form)
		});
		let result = await response.json()
		if (result.status == 1){
			form.classList.add('shop-form__disable')
			formMsg.classList.add('form-msg_show')
			formMsg.querySelector('.form-msg__back-link').classList.add('form-msg_show')
			formMsg.querySelector('.form-msg__text').innerText = result.message
		}
		if (result.status == 0){
			form.classList.add('shop-form__disable')
			formMsg.classList.add('form-msg_show')
			formMsg.querySelector('.form-msg__try-link').classList.add('form-msg_show')
			formMsg.querySelector('.form-msg__text').innerText = result.message
			
		}
	}
	
})


