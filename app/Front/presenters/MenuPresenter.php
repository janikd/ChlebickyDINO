<?php

namespace App\Front\Presenters;

class MenuPresenter extends BasePresenter
{
	public function actionDefault()
	{
		$this->getTemplate()->images = [];
		foreach (scandir('resources/front/assets/media/sandwich') as $dir) {
			if ($dir != "." AND $dir != "..") {
				$this->getTemplate()->images[] = $dir;
			}
		}
	}
}
