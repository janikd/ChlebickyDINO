<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

use App\Admin\Model\Resources\CategoryManager;
use Nette\Application\UI\Presenter;

class SecuredPresenter extends Presenter
{
	protected $materialCategories;

	private $categoryManager;

	public function __construct(CategoryManager $categoryManager)
	{
		parent::__construct();
		$this->categoryManager = $categoryManager;
	}

	public function beforeRender()
	{
		parent::beforeRender();
		$this->materialCategories = $this->categoryManager->findAll();
	}

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
		$this->flashMessage('Váš účet byl odhlášen.', "success");
		$this->redirect('Auth:signIn');
	}
}