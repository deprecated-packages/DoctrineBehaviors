<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\DI;

use Knp\DoctrineBehaviors\Reflection\ClassAnalyzer;
use Nette\DI\Compiler;
use Nette\DI\CompilerExtension;
use Nette\DI\ServiceDefinition;
use Nette\DI\Statement;


abstract class AbstractBehaviorExtension extends CompilerExtension
{

	/**
	 * @return ServiceDefinition
	 */
	protected function getClassAnalyzer()
	{
		$builder = $this->getContainerBuilder();

		if ($builder->hasDefinition('knp.classAnalyzer')) {
			return $builder->getDefinition('knp.classAnalyzer');
		}

		return $builder->addDefinition('knp.classAnalyzer')
			->setClass(ClassAnalyzer::class);
	}


	/**
	 * @param string $value
	 * @return ServiceDefinition|NULL
	 */
	protected function buildDefinition($value)
	{
		if ($value === NULL) {
			return NULL;
		}

		$builder = $this->getContainerBuilder();
		$definition = $builder->addDefinition($this->prefix(md5($value)));

		list($definition->factory) = Compiler::filterArguments([
			is_string($value) ? new Statement($value) : $value
		]);

		list($resolverClass) = (array) $builder->normalizeEntity($definition->getFactory()->getEntity());
		if (class_exists($resolverClass)) {
			$definition->setClass($resolverClass);
		}

		return $definition;
	}

}
