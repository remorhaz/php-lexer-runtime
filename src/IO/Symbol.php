<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

use function array_merge;

/**
 * @psalm-immutable
 */
final class Symbol implements SymbolInterface, LexemeInterface
{

    /**
     * @var int
     */
    private $offset;

    /**
     * @var int
     */
    private $code;

    /**
     * @var LexemeInterface
     */
    private $constituentLexeme;

    public function __construct(int $offset, int $code, LexemeInterface $constituentLexeme)
    {
        $this->offset = $offset;
        $this->code = $code;
        $this->constituentLexeme = $constituentLexeme;
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getLexeme(): LexemeInterface
    {
        return $this;
    }

    /**
     * @return SymbolInterface[]
     * @psalm-return array<int,SymbolInterface>
     * @psalm-pure
     */
    public function getSymbols(): array
    {
        return [$this];
    }

    /**
     * @return LexemeInterface
     * @spalm-pure
     */
    public function getConstituentLexeme(): LexemeInterface
    {
        return $this->constituentLexeme;
    }

    /**
     * @return int[]
     * @psalm-return array<int,int>
     * @psalm-pure
     */
    public function getStartOffsets(): array
    {
        return array_merge([$this->offset], $this->constituentLexeme->getStartOffsets());
    }

    /**
     * @return int[]
     * @psalm-return array<int,int>
     * @psalm-pure
     */
    public function getFinishOffsets(): array
    {
        return array_merge([$this->offset], $this->constituentLexeme->getFinishOffsets());
    }
}
