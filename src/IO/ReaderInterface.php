<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO;

interface ReaderInterface
{

    /**
     * @return mixed
     */
    public function read();

    /**
     * @return bool
     * @psalm-pure
     */
    public function isFinished(): bool;

    /**
     * @return int
     * @psalm-pure
     */
    public function getOffset(): int;

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getEmptyLexeme(): LexemeInterface;
}
