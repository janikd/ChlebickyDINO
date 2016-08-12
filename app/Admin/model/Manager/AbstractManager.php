<?php

namespace App\Admin\Model;

use Doctrine\ORM\ORMException;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;
use Nette;
use Tracy\Debugger;
use Tracy\ILogger;

/**
 * Class AbstractManager
 * @package App\Admin\Model
 */
abstract class AbstractManager extends Nette\Object implements IManager
{

	/**
	 *
	 */
	const THROW_EXCEPTION = true;

	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * @var EntityRepository
	 */
	protected $repository;

	/**
	 * @var array
	 */
	protected $resultCache = [];

	/**
	 * AbstractManager constructor.
	 * @param EntityManager $entityManager
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;

		$this->initManager();
	}

	/**
	 * @param $repositoryName
	 */
	protected function setRepository($repositoryName)
	{
		$this->repository = $this->entityManager->getRepository($repositoryName);
	}

	/**
	 * @return EntityManager
	 */
	protected function getEntityManager()
	{
		return $this->entityManager;
	}

	/**
	 * @param null $entity
	 * @return EntityManager
	 * @throws ORMModelException
	 */
	protected function flush($entity = null)
	{
		try {
			return $this->entityManager->flush($entity);
		} catch (ORMException $e) {
			Debugger::log($e, ILogger::EXCEPTION);
			throw new ORMModelException();
		}
	}

	/**
	 * @param $entity
	 * @return EntityManager
	 * @throws ORMModelException
	 */
	protected function persist($entity)
	{
		try {
			return $this->entityManager->persist($entity);
		} catch (ORMException $e) {
			Debugger::log($e, ILogger::EXCEPTION);
			throw new ORMModelException();
		}
	}

	/**
	 * Entity save shortcut
	 * @param $entity
	 */
	protected function save($entity)
	{
		$this->persist($entity);
		$this->flush();
	}

	/**
	 * @param $entity
	 * @return EntityManager
	 * @throws ORMModelException
	 */
	protected function remove($entity)
	{
		try {
			return $this->entityManager->remove($entity);
		} catch (ORMException $e) {
			Debugger::log($e, ILogger::EXCEPTION);
			throw new ORMModelException();
		}
	}


	/**
	 * @param $id
	 * @param bool $throwException
	 * @return mixed
	 * @throws NotFoundException
	 */
	public function find($id, $throwException = false)
	{
		$key = md5($id);

		if ($this->hasCache($key)) {
			return $this->readCache($key);
		}

		$result = $this->repository->find($id);

		if(!$result AND $throwException) {
			throw new NotFoundException();
		}

		return $this->writeCache($key, $result);
	}

	/**
	 * @return array
	 */
	public function findAll()
	{
		if ($this->hasCache('all')) {
			return $this->readCache('all');
		}

		$result = $this->repository->findAll();

		return $this->writeCache('all', $result);
	}

	/**
	 * @param array $criteria
	 * @param array|null $orderBy
	 * @param null $limit
	 * @param null $offset
	 * @return array
	 */
	public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
	{
		$key = md5(json_encode($criteria) . json_encode($orderBy) . json_encode($limit) . json_encode($offset));

		if ($this->hasCache($key)) {
			return $this->readCache($key);
		}

		$result = $this->repository->findBy($criteria, $orderBy, $limit, $offset);

		return $this->writeCache($key, $result);
	}

	/**
	 * @param array $criteria
	 * @param array|null $orderBy
	 * @return mixed|null|object
	 */
	public function findOneBy(array $criteria, array $orderBy = null)
	{
		$key = md5(json_encode($criteria) . json_encode($orderBy));

		if ($this->hasCache($key)) {
			return $this->readCache($key);
		}

		$result = $this->repository->findOneBy($criteria, $orderBy);

		return $this->writeCache($key, $result);
	}

	/**
	 * Result caching
	 */

	/**
	 * @param $key
	 * @return bool
	 */
	private function hasCache($key)
	{
		return isset($this->resultCache[$key]);
	}

	/**
	 * @param $key
	 * @return mixed
	 */
	private function readCache($key)
	{
		return $this->resultCache[$key];
	}

	/**
	 * @param $key
	 * @param $value
	 * @return mixed
	 */
	private function writeCache($key, $value)
	{
		return $this->resultCache[$key] = $value;
	}

	/**
	 * @return array
	 */
	public function flushCache()
	{
		return $this->resultCache = [];
	}
}

/**
 * Class ModelException
 * @package App\Admin\Model
 */
class ModelException extends \Exception
{
}

/**
 * Class SaveModelException
 * @package App\Admin\Model
 */
class ORMModelException extends \Exception
{
}

/**
 * Class CreateModelException
 * @package App\Admin\Model
 */
class CreateModelException extends ModelException
{
}

/**
 * Class UpdateMModelException
 * @package App\Admin\Model
 */
class UpdateModelException extends ModelException
{
}

/**
 * Class DeleteRMModelException
 * @package App\Admin\Model
 */
class DeleteRModelException extends ModelException
{
}

/**
 * Class NotFoundException
 * @package App\Admin\Model
 */
class NotFoundException extends ModelException
{
}