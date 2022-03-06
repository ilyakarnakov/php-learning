<?
	$limit = 12;//Кол-во товаров на странице
	$params = Router::getCurrent()['params'];

	$section['id'] = $params[1];
	$page = $params[2];
	$product['id'] = $params[3];

	$productQuery = 'SELECT
			product.id AS id,
			product.name AS name,
			product.description AS description,
			product.price AS price,
			product.price_original AS price_original,
			product.price_promo AS price_promo
		FROM product
		WHERE product.id = :product';

	$bind = [
		['product', $product['id'], PDO::PARAM_STR]
	];

	$product = DataBase::dbSelect($productQuery, $bind);
	if(!$product){
		header('location: /404');
		exit();
	}
	$product = $product[0];


	$sectionsQuery = 'SELECT
			section.id AS id,
			section.title AS title,
			count(section.id) AS count
		FROM section
		JOIN product_section ON section.id = product_section.id_section
		GROUP BY section.id HAVING count > 0
		ORDER BY count DESC';

	//Получение данных из БД
	$sections = DataBase::dbSelect($sectionsQuery);

	//Поиск данных по текущему разделу
	foreach($sections as $i){
		if ($i['id'] === $section['id']){
			$section['title'] = $i['title'];
			$section['count'] = $i['count'];
		}
	}

	if(!$section['title']){
		header('location: /404');
		exit();
	}

	if($page < 1 or $page > ceil($section['count'] / $limit)){
		header('location: /404');
		exit();
	}

	$sectionsProductQuery = 'SELECT
				section.id AS id,
				section.title AS title,
				product_section.is_default as is_default
			FROM product_section
			JOIN section ON
				product_section.id_section = section.id
			WHERE product_section.id_product = :product';

	$picturesProductQuery = 'SELECT
				picture.file_path AS file_path,
				picture.alt AS alt,
				product_picture.is_default as is_default
			FROM product_picture
			JOIN picture ON
				product_picture.id_picture = picture.id
			WHERE product_picture.id_product = :product';

	$sectionsProduct = DataBase::dbSelect($sectionsProductQuery, $bind);
	$pictures = DataBase::dbSelect($picturesProductQuery, $bind);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?=htmlspecialchars($product['name'])?></title>

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
	rel="stylesheet">
	
	<link href="/styles/circe.css" type="text/css" rel="stylesheet">
	<link href="/styles/style.css" type="text/css" rel="stylesheet">
	<link href="/styles/notifIt.css" rel="stylesheet" type="text/css" >

	<script src="/scripts/jquery.min.js" defer></script>
	<script src="/scripts/notifIt.js" defer></script>
	<script src="/scripts/script.js" defer></script>


</head>
<body>
	<main class="main main_set">
		<header>
			<a href='/' class='logo'>SHOP</a>
			<div class='sections-links'>
				<? foreach($sections AS $sec){?>
					<a class='sections-links__item' href='/section/<?=htmlspecialchars($sec['id'])?>/1'>
						<?=htmlspecialchars($sec['title'])?>
					</a>
				<?}?>
			</div>
		</header>
		<div class='content main__content'>
			<a class='back-next-link' href='/section/<?=htmlspecialchars($section['id'])?>/<?=$page?>'>
				<span class="material-icons back-next-link__icon">arrow_back</span>К разделу
			</a>
			<div class='product-card content__product-card'>
				<div class='images-wrap product-card__images-wrap'>
					<div class='small-images-wrap images-wrap__small-images-wrap'>
						<div>
							<?$defaultImg = '';
							foreach($pictures AS $picture){?>

								<img class="small-image" src="<?=htmlspecialchars($picture['file_path'])?>">
					
								<?if($picture['is_default'] == 1){
								$defaultImg = $picture['file_path'];
								}
							}?>
						</div>
					</div>
					<div class='main-image-wrap images-wrap__main-image-wrap'>
						<img class="main-image" src="<?=htmlspecialchars($defaultImg)?>">
					</div>
				</div>
				<div class='info-product product-card__info-product'>
					<h1><?=htmlspecialchars($product['name'])?></h1>

					<div class="links-wrap">
						<?foreach($sectionsProduct AS $section){
							?>
								<a class="links-wrap__link" href="/section/<?=htmlspecialchars($section['id'])?>/1"><?=htmlspecialchars($section['title'])?></a>
							<?
						}
						?>
					</div>

					<div class="prices-wrap info-product__prices-wrap">
						<span class="price_original">
							<?=htmlspecialchars($product['price_original'])?>
						</span>
						<span class="price">
							<?=htmlspecialchars($product['price'])?> &#x20bd;
						</span>
						<span class="price_promo">
							<?=htmlspecialchars($product['price_promo'])?> &#x20bd;
						</span>
						<span class="product-card__price_note">
							- с промокодом
						</span>
					</div>

					<div class="delivery-wrap info-product__delivery-wrap">
						<div class="delivery-shop">В наличии в магазине <a href="#">Lamoda</a></div>
						<div class="free-delivery">Бесплатная доставка</div>
					</div>


					<div class="counter info-product__counter">
						<button class="counter__button counter__button_disable" id="counter-remove">
							<span class="material-icons">remove</span>
						</button>
						<input type="number" class="counter__input" id="counter" value="1" readonly>
						<button class="counter__button" id="counter-add">
							<span class="material-icons">add</span>
						</button>
					</div>



					<div class="buttons-wrap info-product__buttons-wrap">
						<button class="button buttons-wrap__button" id="button-buy">
							Купить
						</button>
						<button class="button button_white">
							В избранное
						</button>
					</div>

					<div class="info-product__description">
						<?=htmlspecialchars($product['description'])?>
					</div>

					<div class="share-wrap info-product__share-wrap">
						<h3 class='share-wrap__title'>Поделиться:</h3>
						<a class="share-wrap__link" href="#">
							<img class='share-wrap__img  share-wrap__img_vk' src="/images/vk.png">
						</a>
						<a class="share-wrap__link" href="#">
							<img class='share-wrap__img share-wrap__img_google' src="/images/google.png">
						</a>
						<a class="share-wrap__link" href="#">
							<img class='share-wrap__img share-wrap__img_facebook' src="/images/facebook.png">
						</a>
						<a class="share-wrap__link" href="#">
							<img class='share-wrap__img share-wrap__img_twitter' src="/images/twitter.png">
						</a>
						<div class="share-count">123</div>
					</div>
				</div>
			</div>

		</div>
	</main>
</body>
</html>