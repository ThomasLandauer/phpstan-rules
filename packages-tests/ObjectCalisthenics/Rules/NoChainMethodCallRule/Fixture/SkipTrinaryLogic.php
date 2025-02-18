<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\Tests\ObjectCalisthenics\Rules\NoChainMethodCallRule\Fixture;

use PHPStan\Type\StringType;

class SkipTrinaryLogic
{
    public function run(\PHPStan\Type\Type $type)
    {
        return $type->isSuperTypeOf(new StringType())->yes();
    }
}
