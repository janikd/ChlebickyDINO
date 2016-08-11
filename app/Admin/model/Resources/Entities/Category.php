<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Model\Entities;

use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\MagicAccessors;

use Librette\Doctrine\Sortable\ISortable;
use Librette\Doctrine\Sortable\TSortable;

/**
 * @ORM\Entity
 * @ORM\Table(name="resource_category")
 */
class Category implements ISortable
{
	use MagicAccessors;
	use TSortable;

	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue
	 */
	protected $id;

	/**
	 * @ORM\Column(type="string")
	 */
	protected $name;

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getPosition()
	{
		return $this->position;
	}

	/**
	 * @param mixed $position
	 */
	public function setPosition($position)
	{
		$this->position = $position;
	}
}