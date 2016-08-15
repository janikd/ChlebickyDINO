<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Components;

use App\Admin\Model\CreateModelException;
use App\Admin\Model\Entities\Category;
use App\Admin\Model\Resources\CategoryManager;
use App\Admin\Model\UpdateModelException;
use Nette;
use Nette\Application\UI\Form;


/**
 * Class UpdateResourceCategoryFormFactory
 * @package App\Admin\Components
 */
class UpdateResourceCategoryFormFactory extends Nette\Object
{
	/**
	 * @var CategoryManager
	 */
	private $categoryManager;

	/**
	 * @var Category
	 */
	private $category;

	/**
	 * CreateResourceCategoryFormFactory constructor.
	 * @param CategoryManager $categoryManager
	 */
	public function __construct(CategoryManager $categoryManager)
	{
		$this->categoryManager = $categoryManager;
	}

	/**
	 * @param mixed $category
	 */
	public function setCategory(Category $category)
	{
		$this->category = $category;
	}

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form();

		$form->addText('name')
			->setDefaultValue($this->category->getName())
			->setRequired('Musíte zadat název kategorie.');

		$form->addSubmit('submit');

		$form->onSuccess[] = [$this, 'updateResourceCategoryFormSuccess'];

		return $form;
	}

	/**
	 * @param Form $form
	 * @param $values
	 */
	public function updateResourceCategoryFormSuccess(Form $form, $values)
	{
		$presenter = $form->getPresenter();
		try {
			$this->category->setName($values->name);

			$this->categoryManager->save($this->category);

			$presenter->flashMessage('Název kategorie uložen.', 'success');
			$presenter->redirect('Category:default');
		} catch (UpdateModelException $e) {
			$presenter->flashMessage($e->getMessage(), 'danger');
		}
	}
}