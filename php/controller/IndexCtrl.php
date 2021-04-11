<?php
namespace controller;

class IndexCtrl
{

	public static function beforeRoute ()
	{
		
	}
    
	
	public static function afterRoute ()
	{
		
	}

	
	public static function indexGET ()
	{
		$view = new \View();
		echo $view->render('index.phtml');
	}
	
	
	public static function indexPOST ()
	{
		$f3 = \Base::instance();
		
		// handle parameters
		$host = empty($f3->get("POST.host")) ? "localhost" : $f3->get("POST.host");
		$port = empty($f3->get("POST.port")) ? "3306" : $f3->get("POST.port");
		if(empty($f3->get("POST.login"))) {
			die("empty login");
		}
		$login = $f3->get("POST.login");
		if(empty($f3->get("POST.password"))) {
			die("empty password");
		}
		$password = $f3->get("POST.password");
		
		// try conenct DB
		$options = [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_PERSISTENT => TRUE,
			\PDO::MYSQL_ATTR_COMPRESS => TRUE,
		];
		try {
			$db = new \DB\SQL("mysql:host=$host;port=$port;dbname=", $login, $password, $options );
		}
		catch (\Exception $ex) {
			die("db connect error");
			//TODO handle error
		} 
		// TODO if ok, store infos in session for later navigation
		// and redirect to a databases page ...
		
		
		// get databases list
		$sql = "show databases;";
		$databases = $db->exec($sql);
		$f3->set("databases", $databases);
		die;
		
		
		$view = new \View();
		echo $view->render('index.phtml');
	}
	
	
}
