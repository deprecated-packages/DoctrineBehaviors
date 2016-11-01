<?php

declare(strict_types=1);

namespace Zenify\DoctrineBehaviors\Tests\Blameable;

use Nette\Security\User;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Zenify\DoctrineBehaviors\Blameable\UserCallable;


final class UserCallableTest extends TestCase
{

	/**
	 * @var ObjectProphecy|User
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
