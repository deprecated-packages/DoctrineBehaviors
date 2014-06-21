<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Kdyby;
use Nette\DI\CompilerExtension;
use Nette\DI\Statement;


class TranslatableExtension extends CompilerExtension
{
	use TClassAnalyzer;

	/** @var [] */
	protected $default = [
		'isRecursive' => TRUE,
		'currentLocaleCallable' => NULL,
		'translatableTrait' => 'Knp\DoctrineBehaviors\Model\Translatable\Translatable',
		'translationTrait' => 'Knp\DoctrineBehaviors\Model\Translatable\Translation',
		'translatableFetchMode' => 'LAZY',
		'translationFetchMode' => 'LAZY',
	];


	public function loadConfiguration()
	{
		$config = $this->getConfig($this->default);
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('listener'))
			->setClass('Knp\DoctrineBehaviors\ORM\Translatable\TranslatableListener', [
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

}
