<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Presenters;

use App\Admin\Model\Resources\CategoryManager;

/**
 * Class MaterialPresenter
 * @package App\Admin\Presenters
 */
class MaterialPresenter extends SecuredPresenter
{

	/**
	 * @param $id
	 */
	public function renderDefault($id)
	{
		$this->getTemplate()->category = $this->getCategoryManager()->find($id, CategoryManager::THROW_EXCEPTION);
	}
}