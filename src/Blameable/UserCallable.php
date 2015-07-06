<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\Blameable;

use Nette\Security\User;


class UserCallable
{

	/**
	 * @var User
	 */
	private $user;


	public function __construct(User $user)
	{
		$this->user = $user;
	}


	/**
	 * @return mixed
	 */
	public function __invoke()
	{
		if ($this->user->isLoggedIn()) {
			return $this->user->getId();
		}
		return NULL;
	}

}
