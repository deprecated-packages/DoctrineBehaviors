<?php

namespace Zenify\DoctrineBehaviors\Tests\DI;

use Doctrine\ORM\EntityManager;
use Knp\DoctrineBehaviors\ORM\Blameable\BlameableListener;
use Knp\DoctrineBehaviors\ORM\Geocodable\GeocodableListener;
use Knp\DoctrineBehaviors\ORM\Loggable\LoggableListener;
use Knp\DoctrineBehaviors\ORM\Sluggable\SluggableListener;
use Knp\DoctrineBehaviors\ORM\SoftDeletable\SoftDeletableListener;
use Knp\DoctrineBehaviors\ORM\Timestampable\TimestampableListener;
use Knp\DoctrineBehaviors\ORM\Translatable\TranslatableListener;
use Nette;
use Nette\DI\Container;
use PHPUnit_Framework_TestCase;
use Zenify;


class DoctrineBehaviorsExtensionTest extends PHPUnit_Framework_TestCase
{

	const LISTENER_COUNT = 15;

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var string[]
	 */
	private $listeners = [
		BlameableListener::class,
		GeocodableListener::class,
		LoggableListener::class,
		SluggableListener::class,
		SoftDeletableListener::class,
		TimestampableListener::class,
		TranslatableListener::class
	];


	public function __construct()
	{
		$this->container = (new Zenify\DoctrineBehaviors\Tests\ContainerFactory)->create();
	}


	public function testExtensions()
	{
		/** @var EntityManager $entityManager */
		$entityManager = $this->container->getByType(EntityManager::class);
		$this->assertInstanceOf(EntityManager::class, $entityManager);

		$count = 0;
		foreach ($entityManager->getEventManager()->getListeners() as $listenerSet) {
			foreach ($listenerSet as $listener) {
				$this->assertContains(get_class($listener), $this->listeners);
				$count++;
			}
		}

		$this->assertEquals(self::LISTENER_COUNT, $count);
	}

}
