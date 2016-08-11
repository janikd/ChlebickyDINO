<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Components;

use App\Admin\Model\CreateModelException;
use App\Admin\Model\Entities\Category;
use App\Admin\Model\Resources\CategoryManager;
use Nette;
use Nette\Application\UI\Form;
use Tracy\Debugger;


/**
 * Class CreateResourceCategoryFormFactory
 * @package App\Admin\Components
 */
class CreateResourceCategoryFormFactory extends Nette\Object
{
	/**
	 * @var CategoryManager
	 */
	private $categoryManager;

	/**
	 * CreateResourceCategoryFormFactory constructor.
	 * @param CategoryManager $categoryManager
	 */
	public function __construct(CategoryManager $categoryManager)
	{
		$this->categoryManager = $categoryManager;
	}

	/**
	 * @return Form
	 */
	public function create()
	{
		$form = new Form();

		$form->addText('name')
			->setRequired('Musíte zadat název kategorie.');

		$form->addSubmit('submit');

		$form->onSuccess[] = [$this, 'createResourceCategoryFormSuccess'];

		return $form;
	}

	/**
	 * @param Form $form
	 * @param $values
	 */
	public function createResourceCategoryFormSuccess(Form $form, $values)
	{
		$presenter = $form->getPresenter();
		try {

			Debugger::barDump($values);

			$category = new Category();
			$category->setName($values->name);

			Debugger::barDump($category);

			$this->categoryManager->create($category);

			$presenter->flashMessage('Uloženo.', 'success');
			$presenter->redirect('Material:category');
		} catch (CreateModelException $e) {
			$presenter->flashMessage($e->getMessage(), 'danger');
		}
	}
}