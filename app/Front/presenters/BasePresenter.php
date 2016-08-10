<?php

namespace App\Front\Presenters;

use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{
	public function beforeRender()
	{
		$this->getTemplate()->lorem = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur, aut commodi culpa dicta hic inventore laborum, laudantium numquam quo reprehenderit sapiente sed unde voluptate? Ducimus expedita ipsa nemo possimus voluptatibus.";
		$this->getTemplate()->loremMedium = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur, aut commodi culpa dicta hic inventore laborum.";
		$this->getTemplate()->loremShort = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
	}
}