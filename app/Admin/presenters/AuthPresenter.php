<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

use App\Admin\Components\AuthFormFactory;
use Nette\Application\UI\Presenter;

/**
 * Class AuthPresenter
 * @package App\Admin\Presenters
 */
class AuthPresenter extends Presenter
{
	/** @persistent */
	public $backlink = '';

	/** @var AuthFormFactory @inject */
	public $authFormFactory;

	/**
	 * Startup lifecycle hook
	 */
	public function startup()
	{
		parent::startup();
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect('Dashboard:default');
		}
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	protected function createComponentAuthForm()
	{
		$factory = $this->authFormFactory;
		$factory->setBacklink($this->backlink);

		return $factory->create();
	}
}