<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Stmt\Expression;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use Symplify\Astral\ValueObject\AttributeKey;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Symplify\PHPStanRules\Tests\Rules\NoMagicClosureRule\NoMagicClosureRuleTest
 */
final class NoMagicClosureRule implements Rule, DocumentedRuleInterface
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE = 'There should be no empty class';

    /**
     * @return class-string<Node>
     */
    public function getNodeType(): string
    {
        return Closure::class;
    }

    /**
     * @param Closure $node
     * @return string[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        $parent = $node->getAttribute(AttributeKey::PARENT);
        if (! $parent instanceof Expression) {
            return [];
        }

        return [self::ERROR_MESSAGE];
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'No magic closure function call is allowed, use explicit class with method instead ',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
(static function () {
    // ...
})
CODE_SAMPLE
    ,
                    <<<'CODE_SAMPLE'
final class HelpfulName
{
    public function clearName()
    {
        // ...
    }
}
CODE_SAMPLE
                ),

            ]
        );
    }
}
