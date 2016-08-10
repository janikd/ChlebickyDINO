<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

use Nette\Application\UI\Presenter;

class SecuredPresenter extends Presenter
{
	public function startup()
	{
		parent::startup();
		if (!$this->getUser()->isLoggedIn()) {
			$this->flashMessage('Pro vstup na tuto stránku se musíte přihlásit.', 'warning');
			$this->redirect('Auth:signIn', ['backlink' => $this->storeRequest()]);
		}
	}

	public function handleLogOut()
	{
		$this->getUser()->logout(TRUE);
		$this->redirect('Auth:signIn');
	}
}