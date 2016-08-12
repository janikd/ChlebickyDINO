<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

/**
 * Class SecuredPresenter
 * @package App\Admin\Presenters
 */
class SecuredPresenter extends BasePresenter
{

	/**
	 * Presenter startup lifehook
	 */
	public function startup()
	{
		parent::startup();
		if (!$this->getUser()->isLoggedIn()) {
			$this->flashMessage('Pro vstup na tuto stránku se musíte přihlásit.', 'warning');
			$this->redirect('Auth:signIn', ['backlink' => $this->storeRequest()]);
		}
	}

	/**
	 * Handle logout action
	 */
	public function handleLogOut()
	{
		$this->getUser()->logout(TRUE);
		$this->flashMessage('Váš účet byl odhlášen.', "success");
		$this->redirect('Auth:signIn');
	}
}