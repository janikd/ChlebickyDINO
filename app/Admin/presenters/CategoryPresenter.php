<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

use App\Admin\Components\CreateResourceCategoryFormFactory;
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

	public function renderDefault()
	{
		$this->getTemplate()->categories = $this->getCategoryManager()->findAll();
	}

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
			$this->getCategoryManager()->moveDown($categoryId);
			$this->redirect('this');
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
			$this->flashMessage('Kategorie smazána', 'success');
		} catch (NotFoundException $e) {
			$this->flashMessage('Tato kategorie neexistuje.');
			$this->redirect('Material:category');
		} catch (UpdateModelException $e) {
			$this->flashMessage('Nelze smazat', 'danger');
			$this->redirect('Material:category');
		}
	}

	/**
	 * @return \Nette\Application\UI\Form
	 */
	public function createComponentCreateResourceCategoryForm()
	{
		return $this->createResourceCategoryFormFactory->create();
	}
}