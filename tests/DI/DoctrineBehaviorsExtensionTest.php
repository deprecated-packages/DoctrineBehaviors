<?php

namespace Zenify\DoctrineBehaviors\Tests\DI;

use Doctrine\ORM\EntityManager;
use Knp\DoctrineBehaviors\ORM\Blameable\BlameableSubscriber;
use Knp\DoctrineBehaviors\ORM\Geocodable\GeocodableSubscriber;
use Knp\DoctrineBehaviors\ORM\Loggable\LoggableSubscriber;
use Knp\DoctrineBehaviors\ORM\Sluggable\SluggableSubscriber;
use Knp\DoctrineBehaviors\ORM\SoftDeletable\SoftDeletableSubscriber;
use Knp\DoctrineBehaviors\ORM\Timestampable\TimestampableSubscriber;
use Knp\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriber;
use Nette;
use Nette\DI\Container;
use PHPUnit_Framework_TestCase;
use Zenify;
use Zenify\DoctrineBehaviors\Tests\ContainerFactory;


class DoctrineBehaviorsExtensionTest extends PHPUnit_Framework_TestCase
{

	const LISTENER_COUNT = 16;

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var string[]
	 */
	private $listeners = [
		BlameableSubscriber::class,
		GeocodableSubscriber::class,
		LoggableSubscriber::class,
		SluggableSubscriber::class,
		SoftDeletableSubscriber::class,
		TimestampableSubscriber::class,
		TranslatableSubscriber::class
	];


	public function __construct()
	{
		$this->container = (new ContainerFactory)->create();
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
