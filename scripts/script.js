document.addEventListener('DOMContentLoaded', () => {
	
	//Путь главной большой картинки
	const mImgPath = document.querySelector('.main-image').getAttribute('src')

	document.querySelectorAll('.small-image').forEach(item => {
		//При наведении на миниатюру меняем изображение большой картинки
		item.addEventListener('click', () => {
			let imgPath = item.getAttribute('src')
			document.querySelector('.main-image').setAttribute('src', imgPath)
		})
		//Возвращаем стандартную картинку после того, как пользователь уберет курсор с миниатюры
		// item.addEventListener('mouseleave', () => {
		// 	document.querySelector('.product-card__product-main-image').setAttribute('src', mImgPath)
		// })
	})

	const counterAdd = document.querySelector('#counter-add')
	const counterRemove = document.querySelector('#counter-remove')
	const inputCounter = document.querySelector('#counter')

	const minValue = 1
	const maxValue = 99


	//Функция стилизации кнопок
	const setStyleCounter = () => {
			counterAdd.classList.remove('counter__button_disable')
			counterRemove.classList.remove('counter__button_disable')

			let valueCounter = Number(inputCounter.getAttribute('value'))

			if (valueCounter === minValue){
				counterRemove.classList.add('counter__button_disable')
				counterAdd.classList.remove('counter__button_disable')
			}

			if (valueCounter === maxValue){
				counterAdd.classList.add('counter__button_disable')
				counterRemove.classList.remove('counter__button_disable')
			}
	}
	
	//Установка стилей для счетчика товаров при первой загрузки
	setStyleCounter()

	//Если при первой загрузке значение выходит за предел ставим 1
	let valueCounter = Number(inputCounter.getAttribute('value'))
	if (!valueCounter || valueCounter > maxValue || valueCounter < minValue || !Number.isInteger(valueCounter)){
			inputCounter.setAttribute('value', 1)
			setStyleCounter()
		}

	//По нажатию кнопки +1 к значению
	counterAdd.addEventListener('click', () => {
		let valueCounter = Number(inputCounter.getAttribute('value'))
		if (valueCounter && Number.isInteger(valueCounter)){
		
			if (valueCounter < maxValue)
				inputCounter.setAttribute('value', valueCounter + 1)

			
			}else{
				inputCounter.setAttribute('value', 1)
			}
		setStyleCounter()
	})

	//По нажатию кнопки -1 к значению
	counterRemove.addEventListener('click', () => {

		let valueCounter = Number(inputCounter.getAttribute('value'))
		if (valueCounter && Number.isInteger(valueCounter)){

			if (valueCounter > minValue)
				inputCounter.setAttribute('value', valueCounter - 1)

		}else{
			inputCounter.setAttribute('value', 1)
		}
		setStyleCounter()
	})

	//Вывод сообщения через jQuery NotifIt Plugin
	document.querySelector('#button-buy').addEventListener('click', () => {
		let valueCounter = Number(inputCounter.getAttribute('value'))
		let msg = "В корзину добавлено " + valueCounter + " товаров!"

		if (valueCounter % 10 === 1 && valueCounter != 11){
			msg = "В корзину добавлен " + valueCounter + " товар!"
		}
		else if ([2,3,4].includes(valueCounter % 10) && ![12,13,14].includes(valueCounter)){
			msg = "В корзину добавлено " + valueCounter + " товара!"
		}

		notif({
			type: "success",
			msg: msg,
			position: "center",
			fade: true
		})
	})


})
