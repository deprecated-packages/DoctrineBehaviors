# Zenify/DoctrineBehaviors

Port of [KnpLabs/DoctrineBehaviors](https://github.com/KnpLabs/DoctrineBehaviors) to Nette


## Requirements

See section `require` in [composer.json](composer.json).


## Installation

The best way to install is using [Composer](http://getcomposer.org/).

```sh
$ composer require zenify/doctrine-behaviors:@dev
```

Register extensions you need in `config.neon`:

```yaml
extensions:
	translatable: Zenify\DoctrineBehaviors\DI\TranslatableExtension
	- Zenify\DoctrineBehaviors\DI\TimestampableExtension
```


## Translatable

Setup your translator locale callback in `config.neon`:

```yaml
translatable:
	currentLocaleCallable: [@Translator, getLocale]
```

Place trait to your entity: 

```php
class Article 
{
	use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
	// returns translated property for $article->getTitle() or $article->title
	use Zenify\DoctrineBehaviors\Entities\Attributes\Translatable; 	

}
```

And it's translation entity:

```php
class ArticleTranslation
{
	use Knp\DoctrineBehaviors\Model\Translatable\Translation;
	
	/** 
	 * @ORM\Column(type="string")
	 * @var string 
	 */
	public $title;

}
```

For deeper knowledge see test for:

- [TranslatableEntity](https://github.com/KnpLabs/DoctrineBehaviors/blob/master/tests/fixtures/BehaviorFixtures/ORM/TranslatableEntity.php)
- [TranslatableEntityTranslation](https://github.com/KnpLabs/DoctrineBehaviors/blob/master/tests/fixtures/BehaviorFixtures/ORM/TranslatableEntityTranslation.php)
- [theirs use](https://github.com/KnpLabs/DoctrineBehaviors/blob/master/tests/Knp/DoctrineBehaviors/ORM/TranslatableTest.php)


## Timestampable

Place trait to your entity to ad `$createdAt` and `$updatedAt` properties:

```php
class Article 
{
	use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;

}
```


## Others? Send PR!

Other traits were not tested yet. Do you use them? If so, send us PR based on current extensions.
