<?
	$limit = 12;//Кол-во товаров на странице
	$params = Router::getCurrent()['params'];

	$section['id'] = $params[1];
	$page = $params[2];


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

	$productsQuery = 'SELECT 
			product.id AS id,
			product.name AS name,
			product.price AS price,
			picture.file_path AS default_img
		FROM
			(SELECT
				product.id AS id,
				product.name AS name,
				product.price AS price
			FROM product
			JOIN product_section ON product.id = product_section.id_product
			WHERE product_section.id_section = :section
			ORDER BY name
			LIMIT :limit OFFSET :offset) AS product
		JOIN product_picture ON product.id = product_picture.id_product
		JOIN picture ON picture.id = product_picture.id_picture
		WHERE product_picture.is_default = 1';

	$bind = [
		['offset', $limit * ($page - 1) + 1, PDO::PARAM_INT],
		['limit', $limit, PDO::PARAM_INT],
		['section', $section['id'], PDO::PARAM_STR]
	];

	$products = DataBase::dbSelect($productsQuery, $bind);
	$sections = DataBase::dbSelect($sectionsQuery);

	if(count($sections) == 0){
		header('Location: /404');
	}

	if(count($products) == 0){
		header('Location: /404');
	}

	//Поиск данных по текущему разделу
	foreach($sections as $i){
		if ($i['id'] === $section['id']){
			$section['title'] = $i['title'];
			$section['count'] = $i['count'];
		}
	}

	//Количество страниц в разделе
	$numPage = ceil($section['count'] / $limit);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=$section['title']?> - <?=$page?> стр.</title>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
	rel="stylesheet">
	<link href="/styles/notifIt.css" rel="stylesheet" type="text/css" >
	<link href="/styles/circe.css" type="text/css" rel="stylesheet">
	<link href="/styles/style.css" type="text/css" rel="stylesheet">

	<script src="/scripts/jquery.min.js" defer></script>
</head>
<body>
	<main class='main main_set'>
		<header>
			<a href='/' class='logo'>SHOP</a>
			<div class='sections-links'>
				<? foreach($sections AS $item){?>
					<a class='sections-links__item' href='/section/<?=$item['id']?>/1'>
						<?=$item['title']?>
					</a>
				<?}?>
			</div>
		</header>
		<div class='content main__content'>
			<a class='back-next-link' href='/'>
				<span class="material-icons back-next-link__icon">arrow_back</span>К выбору разделов
			</a>
			<h2 class='content__title'><?=$section['title']?></h2>
			<div class='about-section'>
				Товаров в разделе: <?=$section['count']?><br>
				Товаров на странице: <?=$limit?><br>
			</div>
			<div class='products-item-wrap'>

				<?foreach($products AS $product){?>
						
				<a class='product-item' href='/section/<?=$section['id']?>/<?=$page?>/product/<?=$product['id']?>'>
					<img class='product-item__img' src='<?=$product['default_img']?>'>
					<div class='product-item__name'><?=$product['name']?></div>
					<div class='product-item__price'><?=$product['price']?> &#x20bd;</div>	
				</a>
						
				<?}?>

			</div>
			<div class='content__number-page'>
				Страница <?=$page?> из <?=$numPage?> .
			</div>
			<div class='content__back-next'>
				<?if ($page == 1){?>

				<a class='back-next-link' href='/section/<?=$section['id']?>/<?=$page + 1?>'>
					Вперед<span class='material-icons back-next-link__icon'>arrow_forward</span>
				</a>

				<?} if ($page > 1 and $page < $numPage){?>

				<a class='back-next-link' href='/section/<?=$section['id']?>/<?=$page - 1?>'>
					<span class='material-icons back-next-link__icon'>arrow_back</span>Назад
				</a>
				<a class='back-next-link' href='/section/<?=$section['id']?>/<?=$page + 1?>'>
					Вперед<span class='material-icons back-next-link__icon'>arrow_forward</span>
				</a>

				<?}	if ($page == $numPage){?>
				<a class='back-next-link' href='/section/<?=$section['id']?>/<?=$page - 1?>'>
					<span class='material-icons back-next-link__icon'>arrow_back</span>Назад
				</a>
				<?}?>
			</div>
		</div>

	</main>
</body>
</html>