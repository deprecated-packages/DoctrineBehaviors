<?php

/**
 * @testCase
 */

namespace ZenifyTests\DoctrineBehaviors;

use Nette;
use Tester\Assert;
use Tester\TestCase;
use Zenify;


$container = require_once __DIR__ . '/../bootstrap.php';


class ExtensionTest extends TestCase
{

	/**
	 * @var Nette\DI\Container
	 */
	private $container;

	/**
	 * @var array
	 */
	private $listeners = [
		'Knp\DoctrineBehaviors\ORM\Blameable\BlameableSubscriber',
		'Knp\DoctrineBehaviors\ORM\Geocodable\GeocodableSubscriber',
		'Knp\DoctrineBehaviors\ORM\Loggable\LoggableSubscriber',
		'Knp\DoctrineBehaviors\ORM\Sluggable\SluggableSubscriber',
		'Knp\DoctrineBehaviors\ORM\SoftDeletable\SoftDeletableSubscriber',
		'Knp\DoctrineBehaviors\ORM\Timestampable\TimestampableSubscriber',
		'Knp\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriber'
	];


	public function __construct(Nette\DI\Container $container)
	{
		$this->container = $container;
	}


	public function testExtensions()
	{
		/** @var \Doctrine\ORM\EntityManager $em */
		$em = $this->container->getByType('Doctrine\ORM\EntityManager');
		Assert::type('Doctrine\ORM\EntityManager', $em);

		$count = 0;
		foreach ($em->getEventManager()->getListeners() as $listenerSet) {
			foreach ($listenerSet as $listener) {
				Assert::contains(get_class($listener), $this->listeners);
				$count++;
			}
		}

		Assert::equal(16, $count);
	}

}


(new ExtensionTest($container))->run();
