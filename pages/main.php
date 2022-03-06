<?
	$sectionsQuery = 'SELECT
			section.id AS id,
			section.title AS title,
			count(section.id) AS count
		FROM section
		JOIN product_section ON section.id = product_section.id_section
		GROUP BY section.id HAVING count > 0
		ORDER BY count DESC';

	$sections = DataBase::dbSelect($sectionsQuery);

	if(count($sections) == 0){
		//header('Location: /404');
		die('В БД нет данных!');
	}

	$numSections = count($sections);

	$numProductsQuery = 'SELECT count(*) AS number FROM product';
	$numProducts = DataBase::dbSelect($numProductsQuery)[0]['number'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SHOP</title>

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
		</header>
		<div class='content main__content'>
			<a class='back-next-link' href='/connect'>Обратная связь</a>
			<h2 class='content__title'>Разделы</h2>
			<div>
				Всего разделов: <?=$numSections?><br>
				Всего товаров: <?=$numProducts?>
			</div>
			<div class='sections-item-wrap content__sections-item-wrap'>
				<?foreach($sections as $item){

				$bind = [
					['section',$item['id'], PDO::PARAM_STR]
				];
				$query = '
					SELECT picture.file_path FROM product_section
					JOIN product_picture ON product_section.id_product = product_picture.id_product
					JOIN picture ON product_picture.id_picture = picture.id
					WHERE product_section.id_section = :section LIMIT 1';

				$picture = DataBase::dbSelect($query, $bind);?>
				
				<a class='section-item' href="/section/<?=htmlspecialchars($item['id'])?>/1">
					<img class='section-item__img' src='<?=htmlspecialchars($picture[0]['file_path'])?>'>
					<div class='section-item__title'>
						<?=htmlspecialchars($item['title'])?> (<?=htmlspecialchars($item['count'])?>)
					</div>
				</a>

				<?}?>
			</div>
		</div>
	</main>
	</body>
</html>