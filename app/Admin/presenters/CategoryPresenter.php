<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

use App\Admin\Components\CreateResourceCategoryFormFactory;
use App\Admin\Components\UpdateResourceCategoryFormFactory;
use App\Admin\Model\Entities\Category;
use App\Admin\Model\NotFoundException;
use App\Admin\Model\Resources\CategoryManager;
use App\Admin\Model\UpdateModelException;

/**
 * Class CategoryPresenter
 * @package App\Admin\Presenters
 */
class CategoryPresenter extends SecuredPresenter
{
	/** @var CreateResourceCategoryFormFactory @inject */
	public $createResourceCategoryFormFactory;

	/** @var UpdateResourceCategoryFormFactory @inject */
	public $updateResourceCategoryFormFactory;


	/**
	 *
	 */
	public function renderDefault()
	{
		$this->getTemplate()->categories = $this->getCategoryManager()->findAll();
	}

	/**
	 * @param $id
	 */
	public function renderEdit($id) {
		try {
			$this->getTemplate()->category = $this->getCategoryManager()->find($id, CategoryManager::THROW_EXCEPTION);
		} catch (NotFoundException $e) {
			$this->flashMessage('Tato kategorie neexistuje.');
			$this->redirect('Category:default');
		}
	}

	/**
	 * @param $categoryId
	 */
	public function handleMoveUp($categoryId)
	{
		try {
			$this->getCategoryManager()->moveUp($categoryId);
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
			$this->getCategoryManager()->moveDown($categoryId);
		} catch (NotFoundException $e) {
			$this->flashMessage('Kategorie neexistuje.', 'danger');
		} catch (UpdateModelException $e) {
			$this->flashMessage('Přesunutí na nižší pozici selhalo.', 'danger');
		}
	}

	/**
	 * @param $categoryId
	 */
	public function handleDeleteCategory($categoryId)
	{
		try {
			$category = $this->getCategoryManager()->find($categoryId, CategoryManager::THROW_EXCEPTION);
			$this->getCategoryManager()->remove($category);
			$this->flashMessage('Kategorie úspěšně smazána.', 'success');
		} catch (NotFoundException $e) {
			$this->flashMessage('Tato kategorie neexistuje.');
		} catch (UpdateModelException $e) {
			$this->flashMessage('Nelze smazat', 'danger');
		}

		$this->redirect('Category:default');
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	public function createComponentCreateResourceCategoryForm()
	{
		return $this->createResourceCategoryFormFactory->create();
	}

	public function createComponentUpdateResourceCategoryForm()
	{
		$factory = $this->updateResourceCategoryFormFactory;

		$factory->setCategory($this->getCategoryManager()->find($this->getParameter('id')));

		return $factory->create();
	}
}