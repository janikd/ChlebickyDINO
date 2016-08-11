<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

use App\Admin\Components\CreateResourceCategoryFormFactory;
use App\Admin\Model\ModelException;
use App\Admin\Model\NotFoundException;
use App\Admin\Model\Resources\CategoryManager;
use App\Admin\Model\UpdateModelException;

/**
 * Class MaterialPresenter
 * @package App\Admin\Presenters
 */
class MaterialPresenter extends SecuredPresenter
{
	/**
	 * @var CategoryManager
	 */
	private $categoryManager;

	/** @var CreateResourceCategoryFormFactory @inject */
	public $createResourceCategoryFormFactory;

	/**
	 * @var
	 */
	private $categories;

	/**
	 * MaterialPresenter constructor.
	 * @param CategoryManager $categoryManager
	 */
	public function __construct(CategoryManager $categoryManager)
	{
		parent::__construct();
		$this->categoryManager = $categoryManager;
	}

	/**
	 * @param $categoryId
	 */
	public function handleMoveUp($categoryId)
	{
		try {
			$this->categoryManager->moveUp($categoryId);
			$this->redirect('this');
		} catch (NotFoundException $e) {
			$this->flashMessage('Kategorie neexistuje.', 'danger');
		} catch (UpdateModelException $e) {
			$this->flashMessage('Přesunutí na vyšší pozici selhalo.', 'danger');
		}
	}

	/**
	 * @param $categoryId
	 */
	public function handleMoveDown($categoryId)
	{
		try {
			$this->categoryManager->moveDown($categoryId);
			$this->redirect('this');
		} catch (NotFoundException $e) {
			$this->flashMessage('Kategorie neexistuje.', 'danger');
		} catch (UpdateModelException $e) {
			$this->flashMessage('Přesunutí na nižší pozici selhalo.', 'danger');
		}
	}

	/**
	 *
	 */
	public function actionCategory()
	{
		$this->getTemplate()->categories = $this->categories = $this->categoryManager->findAll();
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	public function createComponentCreateResourceCategoryForm()
	{
		$factory = $this->createResourceCategoryFormFactory;

		return $factory->create();
	}
}