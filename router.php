<?
class Router{
	private static $routes = [];
	private static $current = [];

	static function addRoute($pattern, $filePath){
		self::$routes[$pattern] = $filePath;
	}

	static function execute($url){
		foreach(self::$routes AS $pattern => $filePath){
			if(preg_match($pattern, $url, $matches)){
				self::$current['pattern'] = $pattern;
				self::$current['filePath'] = $filePath;
				self::$current['url'] = $url;
				self::$current['params'] = $matches;
				require($filePath);
				return;				
			}
		}

		require('pages/404.php');
	}

	static function getCurrent(){
		return self::$current;
	}
}