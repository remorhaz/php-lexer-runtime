<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\PreviewBufferInterface;

interface TokenMatcherInterface
{

    public function match(
        int $offset,
        PreviewBufferInterface $input,
        MatcherSelectorInterface $selector
    ): MatchResultInterface;

    /**
     * @param int $offset
     * @param PreviewBufferInterface $input
     * @return TokenInterface
     * @psalm-pure
     */
    public function createFinishToken(int $offset, PreviewBufferInterface $input): TokenInterface;
}
