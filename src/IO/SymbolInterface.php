<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

/**
 * @psalm-immutable
 */
interface SymbolInterface extends LexemeAwareInterface
{

    /**
     * @return int
     * @psalm-pure
     */
    public function getOffset(): int;

    /**
     * @return int
     * @psalm-pure
     */
    public function getCode(): int;
}
