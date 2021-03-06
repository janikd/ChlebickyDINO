<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

use App\Admin\Model\Resources\CategoryManager;
use Nette\Application\UI\Presenter;

/**
 * Class BasePresenter
 * @package App\Admin\Presenters
 */
class BasePresenter extends Presenter
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
	 * @return CategoryManager
	 */
	public function getCategoryManager()
	{
		return $this->categoryManager;
	}
}