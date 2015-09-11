<?php

/**
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
	public function __get($name)
	{
		$prefix = 'get';
		if (preg_match('/^(is|has|should)/i', $name)) {
			$prefix = '';
		}

		$methodName = $prefix . ucfirst($name);

		if (property_exists($this, $name) === FALSE && method_exists($this, $methodName) === FALSE) {
			return $this->proxyCurrentLocaleTranslation($methodName);
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
