<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

interface LexemeAwareInterface
{

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getLexeme(): LexemeInterface;
}
