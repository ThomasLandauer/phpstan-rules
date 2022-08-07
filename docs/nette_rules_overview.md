# 7 Rules Overview

## DibiMaskMatchesVariableTypeRule

Modifier "%s" is not matching passed variable type "%s". The "%s" type is expected - see https://dibiphp.com/en/documentation#toc-modifiers-for-arrays

- class: [`Symplify\PHPStanRules\Nette\Rules\DibiMaskMatchesVariableTypeRule`](../packages/Nette/Rules/DibiMaskMatchesVariableTypeRule.php)

```php
$database->query('INSERT INTO table %v', 'string');
```

:x:

<br>

```php
$database->query('INSERT INTO table %v', ['name' => 'Matthias']);
```

:+1:

<br>

## ForbiddenNetteInjectOverrideRule

Assign to already injected property is not allowed

- class: [`Symplify\PHPStanRules\Nette\Rules\ForbiddenNetteInjectOverrideRule`](../packages/Nette/Rules/ForbiddenNetteInjectOverrideRule.php)

```php
use Nette\DI\Attributes\Inject;

abstract class AbstractParent
{
    /**
     * @var SomeType
     */
    #[Inject]
    protected $someType;
}

final class SomeChild extends AbstractParent
{
    public function __construct(AnotherType $anotherType)
    {
        $this->someType = $anotherType;
    }
}
```

:x:

<br>

```php
use Nette\DI\Attributes\Inject;

abstract class AbstractParent
{
    /**
     * @var SomeType
     */
    #[Inject]
    protected $someType;
}

final class SomeChild extends AbstractParent
{
}
```

:+1:

<br>

## NoInjectOnFinalRule

Use constructor on final classes, instead of property injection

- class: [`Symplify\PHPStanRules\Nette\Rules\NoInjectOnFinalRule`](../packages/Nette/Rules/NoInjectOnFinalRule.php)

```php
use Nette\DI\Attributes\Inject;

final class SomePresenter
{
     #[Inject]
    public $property;
}
```

:x:

<br>

```php
use Nette\DI\Attributes\Inject;

abstract class SomePresenter
{
    #[Inject]
    public $property;
}
```

:+1:

<br>

## NoNetteArrayAccessInControlRule

Avoid using magical unclear array access and use explicit `"$this->getComponent()"` instead

- class: [`Symplify\PHPStanRules\Nette\Rules\NoNetteArrayAccessInControlRule`](../packages/Nette/Rules/NoNetteArrayAccessInControlRule.php)

```php
use Nette\Application\UI\Presenter;

class SomeClass extends Presenter
{
    public function render()
    {
        return $this['someControl'];
    }
}
```

:x:

<br>

```php
use Nette\Application\UI\Presenter;

class SomeClass extends Presenter
{
    public function render()
    {
        return $this->getComponent('someControl');
    }
}
```

:+1:

<br>

## NoNetteDoubleTemplateAssignRule

Avoid double template variable override of "%s"

- class: [`Symplify\PHPStanRules\Nette\Rules\NoNetteDoubleTemplateAssignRule`](../packages/Nette/Rules/NoNetteDoubleTemplateAssignRule.php)

```php
use Nette\Application\UI\Presenter;

class SomeClass extends Presenter
{
    public function render()
    {
        $this->template->key = '1';
        $this->template->key = '2';
    }
}
```

:x:

<br>

```php
use Nette\Application\UI\Presenter;

class SomeClass extends Presenter
{
    public function render()
    {
        $this->template->key = '2';
    }
}
```

:+1:

<br>

## NoNetteInjectAndConstructorRule

Use either `__construct()` or @inject, not both together

- class: [`Symplify\PHPStanRules\Nette\Rules\NoNetteInjectAndConstructorRule`](../packages/Nette/Rules/NoNetteInjectAndConstructorRule.php)

```php
class SomeClass
{
    private $someType;

    public function __construct()
    {
        // ...
    }

    public function injectSomeType($someType)
    {
        $this->someType = $someType;
    }
}
```

:x:

<br>

```php
class SomeClass
{
    private $someType;

    public function __construct($someType)
    {
        $this->someType = $someType;
    }
}
```

:+1:

<br>

## ValidNetteInjectRule

Property with `@inject` annotation or #[Nette\DI\Attributes\Inject] attribute must be public

- class: [`Symplify\PHPStanRules\Nette\Rules\ValidNetteInjectRule`](../packages/Nette/Rules/ValidNetteInjectRule.php)

```php
use Nette\DI\Attributes\Inject;

class SomeClass
{
    #[Inject]
    private $someDependency;
}
```

:x:

<br>

```php
use Nette\DI\Attributes\Inject;

class SomeClass
{
    #[Inject]
    public $someDependency;
}
```

:+1:

<br>
