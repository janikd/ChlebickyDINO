<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;


class RouterFactory
{
	use Nette\StaticClass;

	/**
	 * @return Nette\Application\IRouter
	 */
	public static function createRouter()
	{
		/**
		 * Admin
		 */
		$adminRouter = new RouteList('Admin');
		$adminRouter[] = new Route('administrace/<presenter>/<action>[/<id>]', 'Dashboard:default');

		/**
		 * Public
		 */
		$frontRouter = new RouteList('Front');

		$frontRouter[] = new Route('[/]', 'Homepage:default');
		$frontRouter[] = new Route('nase-nabidka', 'Menu:default');
		$frontRouter[] = new Route('kontakt', 'Contact:default');
		$frontRouter[] = new Route('kosik', 'Cart:default');
		$frontRouter[] = new Route('kosik/zaplatit', 'Cart:checkout');
		$frontRouter[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

		$router = new RouteList;
		$router[] = $adminRouter;
		$router[] = $frontRouter;

		return $router;
	}

}
