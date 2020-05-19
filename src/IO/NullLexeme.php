<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

/**
 * @psalm-immutable
 */
final class NullLexeme implements LexemeInterface
{

    /**
     * @return SymbolInterface[]
     * @psalm-return array<int,SymbolInterface>
     * @psalm-pure
     */
    public function getSymbols(): array
    {
        return [];
    }

    /**
     * @return int[]
     * @psalm-return array<int,int>
     * @psalm-pure
     */
    public function getStartOffsets(): array
    {
        return [];
    }

    /**
     * @return int[]
     * @psalm-return array<int,int>
     * @psalm-pure
     */
    public function getFinishOffsets(): array
    {
        return [];
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getConstituentLexeme(): LexemeInterface
    {
        return $this;
    }
}
