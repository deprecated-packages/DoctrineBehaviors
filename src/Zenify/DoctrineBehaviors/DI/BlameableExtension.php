<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Nette;
use Kdyby;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;


class BlameableExtension extends BehaviorExtension
{
	/** @var array */
	protected $default = [
		'isRecursive' => TRUE,
		'trait' => 'Knp\DoctrineBehaviors\Model\Blameable\Blameable',
		'userCallable' => 'Zenify\DoctrineBehaviors\Blameable\UserCallable',
		'userEntity' => NULL
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfigTypes($config);
		$builder = $this->getContainerBuilder();

		$userCallable = $this->buildDefinition($config['userCallable']);

		$builder->addDefinition($this->prefix('listener'))
			->setClass('Knp\DoctrineBehaviors\ORM\Blameable\BlameableListener', [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['trait'],
				'@' . $userCallable->getClass(),
				$config['userEntity']
			])
			->setAutowired(FALSE)
			->addTag(Kdyby\Events\DI\EventsExtension::TAG_SUBSCRIBER);
	}


	/**
	 * @throws AssertionException
	 */
	protected function validateConfigTypes(array $config)
	{
		Validators::assertField($config, 'isRecursive', 'bool');
		Validators::assertField($config, 'trait', 'type');
		Validators::assertField($config, 'userCallable', 'string');
		Validators::assertField($config, 'userEntity', 'null|string');
	}

}
