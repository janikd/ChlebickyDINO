<?php

namespace App\Admin\Model\Resources;

use App\Admin\Model\AbstractManager;
use App\Admin\Model\CreateModelException;
use App\Admin\Model\Entities\Category;
use App\Admin\Model\ORMModelException;

/**
 * Class CategoryManager
 * @package App\Admin\Model\Resources
 */
class CategoryManager extends AbstractManager
{
	/**
	 *
	 */
	public function initManager()
	{
		$this->setRepository(Category::class);
	}

	/**
	 * @return array
	 */
	public function findAll()
	{
		return parent::findBy([], ['position' => 'ASC']);
	}

	/**
	 * @param Category $newCategory
	 * @throws CreateModelException
	 */
	public function create(Category $newCategory)
	{
		try {
			$this->save($newCategory);
		} catch (ORMModelException $e) {
			throw new CreateModelException('Nelze vytvořit kategorii.');
		}
	}

	/**
	 * @param $id
	 */
	public function moveUp($id)
	{
		/** @var Category $category */
		$category = $this->find($id, self::THROW_EXCEPTION);
		$category->moveUp();

		$this->save($category);
	}

	/**
	 * @param $id
	 */
	public function moveDown($id)
	{
		/** @var Category $category */
		$category = $this->find($id, self::THROW_EXCEPTION);
		$category->moveDown();

		$this->save($category);
	}

	/**
	 * @param Category $category
	 */
	public function updatePosition(Category &$category)
	{
		$atPosition = $this->findOneBy(['position' => $category->getPosition()]);
		if ($atPosition instanceof Category) {
			$category->moveBefore($atPosition);
			$this->save($category);
		}
	}
}