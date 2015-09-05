<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineBehaviors\Entities\Attributes;

use Nette\Object;


/**
 * @method Translatable proxyCurrentLocaleTranslation($method, $args = [])
 */
trait Translatable
{

	/**
	 * @param string
	 * @return mixed
	 */
	public function &__get($name)
	{
		if (property_exists($this, $name) === FALSE && method_exists($this, 'get' . ucfirst($name)) === FALSE) {
			$prefix = 'get';
			if (preg_match('/^(is|has|should)/i', $name)) {
				$prefix = '';
			}
			return $this->proxyCurrentLocaleTranslation($prefix . ucfirst($name));

		} elseif ($this instanceof Object) {
			return parent::__get($name);
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
		if ($this instanceof Object) {
			if (strpos($method, 'get') === 0) {
				$name = lcfirst(substr($method, 3));

				if (property_exists($this, $name)) {
					return parent::__call($method, $arguments);
				}
			}
		}

		return $this->proxyCurrentLocaleTranslation($method, $arguments);
	}

}
