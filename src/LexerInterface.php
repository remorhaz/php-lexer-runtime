<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime;

use Remorhaz\Lexer\Runtime\IO\SymbolReaderInterface;
use Remorhaz\Lexer\Runtime\Token\TokenReaderInterface;

interface LexerInterface
{

    /**
     * @param SymbolReaderInterface $input
     * @return TokenReaderInterface
     */
    public function createTokenReader(SymbolReaderInterface $input): TokenReaderInterface;
}
