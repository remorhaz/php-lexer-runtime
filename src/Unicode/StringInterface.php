<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Unicode;

/**
 * @psalm-immutable
 */
interface StringInterface
{

    /**
     * @return int[]
     * @psalm-return array<int, int>
     * @psalm-pure
     */
    public function asCharacters(): array;

    /**
     * @return string
     * @psalm-pure
     */
    public function asAscii(): string;

    /**
     * @return string
     * @psalm-pure
     */
    public function asUtf8(): string;
}
