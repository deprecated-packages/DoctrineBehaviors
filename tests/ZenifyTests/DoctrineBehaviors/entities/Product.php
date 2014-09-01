<?php

namespace ZenifyTests\DoctrineBehaviors\Entities;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Nette;


/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 *
 * @method  int     getId()
 * @method  string  getName()
 * @method  Product setName()
 */
class Product extends Nette\Object
{
	use Timestampable;

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	public $id;

	/**
	 * @ORM\Column(type="string", nullable=TRUE)
	 * @var string
	 */
	protected $name;

}
