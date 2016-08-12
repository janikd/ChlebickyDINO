<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

use App\Admin\Model\Resources\CategoryManager;
use Nette\Application\UI\Presenter;

/**
 * Class SecuredPresenter
 * @package App\Admin\Presenters
 */
class SecuredPresenter extends Presenter
{
	/**
	 * @var CategoryManager
	 */
	private $categoryManager;

	/**
	 * SecuredPresenter constructor.
	 * @param CategoryManager $categoryManager
	 */
	public function __construct(CategoryManager $categoryManager)
	{
		parent::__construct();
		$this->categoryManager = $categoryManager;
	}

	/**
	 * Put materialCategories into template variables before render
	 */
	public function beforeRender()
	{
		parent::beforeRender();
		$this->getTemplate()->materialCategories = $this->categoryManager->findAll();
	}

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

	/**
	 * @return CategoryManager
	 */
	public function getCategoryManager()
	{
		return $this->categoryManager;
	}
}