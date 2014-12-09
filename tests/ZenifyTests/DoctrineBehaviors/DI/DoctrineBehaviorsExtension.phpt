<?php

namespace ZenifyTests\DoctrineBehaviors\DI;

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
use Tester\Assert;
use Tester\TestCase;
use Zenify;


$container = require_once __DIR__ . '/../../bootstrap.php';


class DoctrineBehaviorsExtensionTest extends TestCase
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


	public function __construct(Container $container)
	{
		$this->container = $container;
	}


	public function testExtensions()
	{
		/** @var EntityManager $em */
		$em = $this->container->getByType(EntityManager::class);
		Assert::type(EntityManager::class, $em);

		$count = 0;
		foreach ($em->getEventManager()->getListeners() as $listenerSet) {
			foreach ($listenerSet as $listener) {
				Assert::contains(get_class($listener), $this->listeners);
				$count++;
			}
		}

		Assert::equal(self::LISTENER_COUNT, $count);
	}

}


(new DoctrineBehaviorsExtensionTest($container))->run();
