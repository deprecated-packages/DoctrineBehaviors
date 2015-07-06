<?php

namespace Zenify\DoctrineBehaviors\Tests\Blameable;

use Nette\Security\User;
use PHPUnit_Framework_TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zenify\DoctrineBehaviors\Blameable\UserCallable;


class UserCallableTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var ObjectProphecy
	 */
	private $userMock;

	/**
	 * @var UserCallable
	 */
	private $userCallable;


	public function __construct()
	{
		$this->userMock = $this->prophesize(User::class);
		$this->userMock->getId()->willReturn(1);
		$this->userMock->isLoggedIn()->willReturn(TRUE);
		$this->userCallable = new UserCallable($this->userMock->reveal());
	}


	public function testInvoke()
	{
		$this->assertSame(1, call_user_func($this->userCallable));

		$this->userMock->isLoggedIn()->willReturn(FALSE);
		$this->assertSame(NULL, call_user_func($this->userCallable));
	}

}
