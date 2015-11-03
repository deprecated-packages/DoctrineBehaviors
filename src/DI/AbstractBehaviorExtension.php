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
	 * @param string $callable
	 * @return ServiceDefinition|NULL
	 */
	protected function buildDefinitionFromCallable($callable)
	{
		if ($callable === NULL) {
			return NULL;
		}

		$builder = $this->getContainerBuilder();
		$definition = $builder->addDefinition($this->prefix(md5($callable)));

		list($definition->factory) = Compiler::filterArguments([
			is_string($callable) ? new Statement($callable) : $callable
		]);

		list($resolverClass) = (array) $builder->normalizeEntity($definition->getFactory()->getEntity());
		if (class_exists($resolverClass)) {
			$definition->setClass($resolverClass);
		}

		return $definition;
	}

}
