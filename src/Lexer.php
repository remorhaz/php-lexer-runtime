<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime;

use Remorhaz\Lexer\Runtime\IO\PreviewBuffer;
use Remorhaz\Lexer\Runtime\IO\SymbolReaderInterface;
use Remorhaz\Lexer\Runtime\Token\MatcherSelectorInterface;
use Remorhaz\Lexer\Runtime\Token\TokenReader;
use Remorhaz\Lexer\Runtime\Token\TokenReaderInterface;

final class Lexer implements LexerInterface
{

    /**
     * @var MatcherSelectorInterface
     */
    private $matcherSelector;

    /**
     * @param MatcherSelectorInterface $matcherSelector
     */
    public function __construct(MatcherSelectorInterface $matcherSelector)
    {
        $this->matcherSelector = $matcherSelector;
    }

    /**
     * @param SymbolReaderInterface $input
     * @return TokenReaderInterface
     */
    public function createTokenReader(SymbolReaderInterface $input): TokenReaderInterface
    {
        return new TokenReader(new PreviewBuffer($input), clone $this->matcherSelector);
    }
}
