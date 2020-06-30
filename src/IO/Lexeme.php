<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

use function array_key_last;
use function array_reduce;

/**
 * @psalm-immutable
 */
final class Lexeme implements LexemeInterface
{

    /**
     * @var SymbolInterface[]
     * @psalm-var array<int, SymbolInterface>
     */
    private $symbols;

    public function __construct(SymbolInterface ...$symbols)
    {
        if (empty($symbols)) {
            throw new Exception\EmptyLexemeException();
        }
        $this->symbols = $symbols;
    }

    /**
     * @return SymbolInterface[]
     * @psalm-return array<int, SymbolInterface>
     * @psalm-pure
     */
    public function getSymbols(): array
    {
        return $this->symbols;
    }

    /**
     * @return int[]
     * @psalm-return array<int, int>
     * @psalm-pure
     */
    public function getStartOffsets(): array
    {
        return $this
            ->symbols[0]
            ->getLexeme()
            ->getStartOffsets();
    }

    /**
     * @return int[]
     * @psalm-return array<int,int>
     * @psalm-pure
     */
    public function getFinishOffsets(): array
    {
        /** @var int $index */
        $index = array_key_last($this->symbols);

        return $this
            ->symbols[$index]
            ->getLexeme()
            ->getFinishOffsets();
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getConstituentLexeme(): LexemeInterface
    {
        return new Lexeme(...array_reduce($this->symbols, [$this, 'appendConstituentSymbols'], []));
    }

    /**
     * @param SymbolInterface[] $buffer
     * @psalm-param  array<int,SymbolInterface> $buffer
     * @param SymbolInterface   $symbol
     * @return SymbolInterface[]
     * @psalm-return array<int,SymbolInterface>
     */
    private function appendConstituentSymbols(array $buffer, SymbolInterface $symbol): array
    {
        return array_merge($buffer, $symbol->getLexeme()->getConstituentLexeme()->getSymbols());
    }
}
