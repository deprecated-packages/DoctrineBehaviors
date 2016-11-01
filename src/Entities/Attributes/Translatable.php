<?php

declare(strict_types=1);

/*
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\Entities\Attributes;


/**
 * @method Translatable proxyCurrentLocaleTranslation($method, $args = [])
 */
trait Translatable
{

	/**
	 * @param string
	 * @return mixed
	 */
	public function &__get($name) // "&" intentionally due to compatibility with Nette\Object
	{
		$prefix = 'get';
		if (preg_match('/^(is|has|should)/i', $name)) {
			$prefix = '';
		}

		$methodName = $prefix . ucfirst($name);

		if (property_exists($this, $name) === FALSE && method_exists($this, $methodName) === FALSE) {
			$value = $this->proxyCurrentLocaleTranslation($methodName);
			// variable $value intentionally, due to & compatibility
			return $value;
		}

		if (method_exists($this, $methodName)) {
			$value = $this->$methodName();
			return $value;
		}

		return $this->$name;
	}


	/**
	 * @param string
	 * @param array
	 * @return mixed
	 */
	public function __call($method, $arguments)
	{
		return $this->proxyCurrentLocaleTranslation($method, $arguments);
	}

}
