<?php
/**
 * @author Jan Kotrba <jan.kotrbaa@gmail.com>
 */

namespace App\Admin\Model;

use App\Admin\Model\Entities\User;
use Kdyby\Doctrine\EntityManager;
use Nette;
use Nette\Security as NS;

/**
 * Class Authenticator
 * @package App\Admin\Model
 */
class Authenticator extends Nette\Object implements NS\IAuthenticator
{
	/**
	 * @var EntityManager
	 */
	public $entityManager;

	/**
	 * Authenticator constructor.
	 * @param EntityManager $entityManager
	 */
	function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	/**
	 * @param array $credentials
	 * @return NS\Identity
	 * @throws NS\AuthenticationException
	 */
	function authenticate(array $credentials)
	{
		list($email, $password) = $credentials;

		/*
		$user = new User();
		$user->setEmail('kotrba@kotyslab.cz');
		$user->setPassword('password');

		$this->entityManager->persist($user);
		$this->entityManager->flush();
		*/

		/** @var User $user */
		$user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

		if (!$user OR !NS\Passwords::verify($password, $user->getPassword())) {
			throw new NS\AuthenticationException('Neplatné údaje.');
		}

		return new NS\Identity($user->getId(), 'administrator');
	}
}
