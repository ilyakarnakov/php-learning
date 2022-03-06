<?
class DataBase{
	private static $pdo;

	static function dbSet($db_set){

		try{
			$dsn = 'mysql:host='.$db_set['host'].';dbname='.$db_set['dbname'].';charset='.$db_set['charset'];
			self::$pdo = new PDO($dsn, $db_set['username'], $db_set['password']);
		}
		catch(PDOException $e){
			echo('Ошибка подключение к БД!');
			exit(); 
		}
	}

	static function dbSelect($query, $params = false){
		$result = null;
		try{
			if ($params){
				$query = self::$pdo->prepare($query);
				foreach ($params as $param) {
					$query->bindValue($param[0], $param[1], $param[2]);
				}

				$query->execute();
			}else{
				$query = self::$pdo->query($query);
			}
			
			if ($query){
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
			}else{
				return false;
			}
		}catch(PDOException $e){
			die('Ошибка БД!');
		}

		return $result;
	}


	static function dbInsert($query, $params){
		$result = null;
		try{
			$query = self::$pdo->prepare($query);
			$result = $query->execute($params);
		}catch(PDOException $e){
			die('Ошибка БД!');
		}
		return $result;
		
	}


}