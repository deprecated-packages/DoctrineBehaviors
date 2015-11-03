<?php

namespace Zenify\DoctrineBehaviors\Tests\DI\AbstractBehaviorExtensionSource;

use Nette\DI\ServiceDefinition;
use Zenify\DoctrineBehaviors\DI\AbstractBehaviorExtension;


final class SomeBehaviorExtension extends AbstractBehaviorExtension
{

	/**
	 * @return ServiceDefinition
	 */
	public function getClassAnalyzerPublic()
	{
		return parent::getClassAnalyzer();
	}


	/**
	 * @param string $value
	 * @return ServiceDefinition|NULL
	 */
	public function buildDefinitionFromCallablePublic($value)
	{
		return parent::buildDefinitionFromCallable($value);
	}

}
