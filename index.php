<?

	require_once('router.php');
	require_once('database.php');
	$dbParams = require_once('dbParams.php');

	DataBase::dbSet($dbParams);
	Router::addRoute('#^\/$#', 'pages/main.php');
	
	Router::addRoute('#^\/404$#', 'pages/404.php');
	Router::addRoute('#^\/$#', 'pages/main.php');
	Router::addRoute('#^\/section\/([0-9]{1,})\/([0-9]{1,})$#', 'pages/section.php');
	Router::addRoute('#^\/section\/([0-9]{1,})\/([0-9]{1,})\/product\/([0-9]{1,})$#', 'pages/product.php');
	Router::addRoute('#^\/connect$#', 'pages/form.php');
	Router::addRoute('#^\/connect\/submit$#', 'pages/submit.php');

	Router::execute('/'.$_GET['route']);