<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\Collector\FunctionLike;

use PhpParser\Node;
use PhpParser\Node\FunctionLike;
use PhpParser\PrettyPrinter\Standard;
use PHPStan\Analyser\Scope;
use PHPStan\Collectors\Collector;

/**
 * @implements Collector<FunctionLike, array{int, int, string}>>
 *
 * @see \Symplify\PHPStanRules\Rules\Explicit\ParamTypeDeclarationSeaLevelRule
 */
final class ParamTypeSeaLevelCollector implements Collector
{
    /**
     * @readonly
     * @var \PhpParser\PrettyPrinter\Standard
     */
    private $printerStandard;
    public function __construct(Standard $printerStandard)
    {
        $this->printerStandard = $printerStandard;
    }

    public function getNodeType(): string
    {
        return FunctionLike::class;
    }

    /**
     * @param FunctionLike $node
     * @return array{int, int, string}
     */
    public function processNode(Node $node, Scope $scope): ?array
    {
        $paramCount = count($node->getParams());

        // nothing to analyse
        if ($paramCount === 0) {
            return [0, 0, ''];
        }

        $typedParamCount = 0;
        foreach ($node->getParams() as $param) {
            if ($param->type === null) {
                continue;
            }

            ++$typedParamCount;
        }

        // missing at least 1 type
        $printedClassMethod = $paramCount !== $typedParamCount ? $this->printerStandard->prettyPrint([$node]) : '';

        return [$typedParamCount, $paramCount, $printedClassMethod];
    }
}
