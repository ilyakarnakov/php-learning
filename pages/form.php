<?
	
$sectionsQuery = '
	SELECT
		section.id AS id,
		section.title AS title,
		count(section.id) AS count
	FROM section
	JOIN product_section ON section.id = product_section.id_section
	GROUP BY section.id HAVING count > 0
	ORDER BY count DESC
';

$sections = DataBase::dbSelect($sectionsQuery);





?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Обратная связь</title>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
	rel="stylesheet">
	<link href="/styles/notifIt.css" rel="stylesheet" type="text/css" >
	<link href="/styles/circe.css" type="text/css" rel="stylesheet">
	<link href="/styles/style.css" type="text/css" rel="stylesheet">

	<script src="/scripts/jquery.min.js" defer></script>
	<script src="/scripts/notifIt.js" defer></script>
	<script src="/scripts/form.js" defer></script>


</head>
<body>
	<main class='main main_set'>
		<header>
			<a href='/' class='logo'>SHOP</a>
			<div class='sections-links'>
				<? foreach($sections AS $sec){?>
					<a class='sections-links__item' href='/section/<?=$sec['id']?>/1'>
						<?=$sec['title']?>
					</a>
				<?}?>
			</div>
		</header>
		<div class='content main__content'>
			<a class='back-next-link' href='/'>
				<span class="material-icons back-next-link__icon">arrow_back</span>На главную
			</a>
			<h2 class='content__title'>Обратная связь</h2>
			<form id='form' class='shop-form content__shop-form' action=''>
				<div class='form-item shop-form__form-item'>
					<div class='form-item__title'>Имя</div>
					<input id='name' name='name' class='form-item__input-text' type='text' value="<?
					if(isset($_COOKIE['name'])){
						echo(htmlspecialchars($_COOKIE['name']));
					}
					?>">
					<div id='name-wrong-msg' class='wrong-msg form-item__wrong-msg'></div>
				</div>
				<div class='form-item shop-form__form-item'>
					<div class='form-item__title'>E-mail</div>
					<input id='email' name='email' class='form-item__input-text' type='text' value="<?
					if(isset($_COOKIE['email'])){
						echo(htmlspecialchars($_COOKIE['email']));
					}
					?>">
					<div id='email-wrong-msg' class='wrong-msg form-item__wrong-msg'></div>
				</div>
				<div class='form-item shop-form__form-item'>
					<div class='form-item__title'>Год рождения</div>
					<input id='year' name='year' class='form-item__input-year' value='<?
					if(isset($_COOKIE['year'])){
						echo(htmlspecialchars($_COOKIE['year']));
					} else echo('2022');
					?>'>
					<div id='year-wrong-msg' class='wrong-msg form-item__wrong-msg'></div>
				</div>
				<div class='form-item shop-form__form-item'>
					<div class='form-item__title'>Пол</div>
					<input id='gender' name='gender' class='form-item__radio' name='gender' value='0' type='radio' <?
					if(isset($_COOKIE['gender'])){
						if ($_COOKIE['gender'] == 0){
							echo('checked');
						}
					} else echo('checked');
					?>>
					<span class='form-item__radio-title'>М</span>
					<input id='gender' name='gender' class='form-item__radio' name='gender' value='1' type='radio' <?
					if(isset($_COOKIE['gender'])){
						if ($_COOKIE['gender'] == 1){
							echo('checked');
						}
					}
					?>>
					<span class='form-item__radio-title'>Ж</span>
				</div>
				<div class='form-item shop-form__form-item'>
					<div class='form-item__title'>Тема обращения</div>
					<input id='topic' name='topic' class='form-item__input-text' type='text'>
					<div id='topic-wrong-msg' class='wrong-msg form-item__wrong-msg'></div>
				</div>
				<div class='form-item shop-form__form-item'>
					<div class='form-item__title'>Обращение</div>
					<textarea id='text' name='text' class='form-item__text-area'></textarea>
					<div id='text-wrong-msg' class='wrong-msg form-item__wrong-msg'></div>
				</div>

				<div class='form-item shop-form__form-item'>
					<input id='agree-checkbox' name='agree-checkbox' class='form-item__checkbox' type='checkbox'>
					<div id='agree-checkbox-link' class="form-item__checkbox-title">
						С правилами ознакомлен
					</div>
					<div id='agree-checkbox-wrong-msg' class='wrong-msg form-item__wrong-msg'></div>
				</div>
				<div class='form-item shop-form__form-item'>
					<button type='button' id='submit-button' class='button'>Отправить</button>
				</div>

			</form>
			<div class='form-msg'>
				<div class='form-msg__text'></div>
				<a class='back-next-link form-msg__back-link' href='/'>
					<span class="material-icons back-next-link__icon">arrow_back</span>На главную
				</a>
				<a class='back-next-link form-msg__try-link'>
					Попробывать еще раз
				</a>
			</div>


		</div>

	</main>
</body>
</html>