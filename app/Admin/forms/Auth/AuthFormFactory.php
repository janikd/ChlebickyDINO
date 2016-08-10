<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Components;

use Nette;
use Nette\Application\UI\Form;

/**
 * Class SignInFormFactory
 * @package App\Admin
 */
class AuthFormFactory extends Nette\Object
{
	public $backlink;

	/**
	 * @param mixed $backlink
	 */
	public function setBacklink($backlink)
	{
		$this->backlink = $backlink;
	}

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form();

		$form->addText('email')
			->setRequired('Musíte zadat email.');

		$form->addPassword('password')
			->setRequired('Musíte zadat heslo.');

		$form->addSubmit('submit');

		$form->onSuccess[] = [$this, 'signInFormSuccess'];

		return $form;
	}

	/**
	 * @param Form $form
	 * @param $values
	 */
	public function signInFormSuccess(Form $form, $values)
	{
		$presenter = $form->getPresenter();
		try {
			$presenter->getUser()->login($values->email, $values->password);
			$presenter->flashMessage('Vítejte v systému pro správu webu.', 'success');
			$presenter->restoreRequest($this->backlink);
			$presenter->redirect('Dashboard:default');
		} catch (Nette\Security\AuthenticationException $e) {
			$presenter->flashMessage($e->getMessage(), 'danger');
		}
	}
}