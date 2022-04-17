<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Trait_;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Symplify\PHPStanRules\Tests\Rules\NoTraitRule\NoTraitRuleTest
 */
final class NoTraitRule implements Rule, DocumentedRuleInterface
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'Do not use trait, extract to a service and dependency injection instead';

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Trait_::class;
    }

    /**
     * @param Trait_ $node
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        return [self::ERROR_MESSAGE];
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(self::ERROR_MESSAGE, [
            new CodeSample(
                <<<'CODE_SAMPLE'
trait SomeTrait
{
    public function run()
    {
    }
}
CODE_SAMPLE
                ,
                <<<'CODE_SAMPLE'
class SomeService
{
    public function run(...)
    {
    }
}
CODE_SAMPLE
            ),
        ]);
    }
}
