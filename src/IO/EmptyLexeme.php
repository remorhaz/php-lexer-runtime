<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

use function array_merge;
use function array_shift;

/**
 * @psalm-immutable
 */
final class EmptyLexeme implements LexemeInterface
{

    /**
     * @var int
     */
    private $offset;

    /**
     * @var LexemeInterface
     */
    private $constituentLexeme;

    /**
     * @param int ...$offsets
     * @return LexemeInterface
     * @psalm-pure
     */
    public static function fromOffsets(int ...$offsets): LexemeInterface
    {
        return empty($offsets)
            ? new NullLexeme()
            : new self(array_shift($offsets), self::fromOffsets(...$offsets));
    }

    public function __construct(int $offset, LexemeInterface $constituentLexeme)
    {
        if (!empty($constituentLexeme->getSymbols())) {
            throw new Exception\NonEmptyLexemeException($constituentLexeme);
        }
        $this->constituentLexeme = $constituentLexeme;
        $this->offset = $offset;
    }

    /**
     * {@inheritDoc}
     *
     * @return SymbolInterface[]
     * @psalm-return array<int,SymbolInterface>
     * @psalm-pure
     */
    public function getSymbols(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     *
     * @return int[]
     * @psalm-return array<int,int>
     */
    public function getStartOffsets(): array
    {
        return array_merge([$this->offset], $this->constituentLexeme->getStartOffsets());
    }

    /**
     * {@inheritDoc}
     *
     * @return int[]
     * @psalm-return array<int,int>
     */
    public function getFinishOffsets(): array
    {
        return array_merge([$this->offset], $this->constituentLexeme->getFinishOffsets());
    }

    /**
     * {@inheritDoc}
     *
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getConstituentLexeme(): LexemeInterface
    {
        return $this->constituentLexeme;
    }
}
