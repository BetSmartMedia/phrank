<?php
namespace App\Controllers;

class Home extends \Phrank\Base\Controller
{
	public function index()
	{
		$this->app->render('home/index.html');
	}
}

?>
