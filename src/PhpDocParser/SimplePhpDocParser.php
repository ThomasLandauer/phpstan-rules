<?php

declare(strict_types=1);

namespace Symplify\PHPStanRules\PhpDocParser;

use PhpParser\Comment\Doc;
use PhpParser\Node;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocNode;
use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
use PHPStan\PhpDocParser\Parser\TokenIterator;

/**
 * @see \Symplify\Astral\Tests\PhpDocParser\SimplePhpDocParser\SimplePhpDocParserTest
 */
final class SimplePhpDocParser
{
    public function __construct(
        private PhpDocParser $phpDocParser,
        private Lexer $lexer
    ) {
    }

    public function parseNode(Node $node): ?PhpDocNode
    {
        $docComment = $node->getDocComment();
        if (! $docComment instanceof Doc) {
            return null;
        }

        return $this->parseDocBlock($docComment->getText());
    }

    public function parseDocBlock(string $docBlock): PhpDocNode
    {
        $tokens = $this->lexer->tokenize($docBlock);
        $tokenIterator = new TokenIterator($tokens);

        $phpDocNode = $this->phpDocParser->parse($tokenIterator);
        return new PhpDocNode($phpDocNode->children);
    }
}
