<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Knp\DoctrineBehaviors\Model\Translatable\Translation;
use Knp\DoctrineBehaviors\ORM\Translatable\TranslatableSubscriber;
use Nette\Utils\AssertionException;
use Nette\Utils\Validators;
use Zenify\DoctrineBehaviors\Entities\Attributes\Translatable;


class TranslatableExtension extends BehaviorExtension
{

	/**
	 * @var array
	 */
	private $default = [
		'isRecursive' => TRUE,
		'currentLocaleCallable' => NULL,
		'translatableTrait' => Translatable::class,
		'translationTrait' => Translation::class,
		'translatableFetchMode' => 'LAZY',
		'translationFetchMode' => 'LAZY',
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$this->validateConfigTypes($config);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('listener'))
			->setClass(TranslatableSubscriber::class, [
				'@' . $this->getClassAnalyzer()->getClass(),
				$config['isRecursive'],
				$config['currentLocaleCallable'],
				$config['translatableTrait'],
				$config['translationTrait'],
				$config['translatableFetchMode'],
				$config['translationFetchMode']
			])
			->setAutowired(FALSE)
			->addTag(Kdyby\Events\DI\EventsExtension::TAG_SUBSCRIBER);
	}


	/**
	 * @throws AssertionException
	 */
	private function validateConfigTypes(array $config)
	{
		Validators::assertField($config, 'isRecursive', 'bool');
		Validators::assertField($config, 'currentLocaleCallable', NULL | 'array');
		Validators::assertField($config, 'translatableTrait', 'type');
		Validators::assertField($config, 'translationTrait', 'type');
		Validators::assertField($config, 'translatableFetchMode', 'string');
		Validators::assertField($config, 'translationFetchMode', 'string');
	}

}
