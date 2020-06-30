<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\PreviewBufferInterface;

interface MatcherInterface
{

    public function match(
        int $offset,
        PreviewBufferInterface $input,
        MatcherSelectorInterface $selector
    ): MatchResultInterface;
}
