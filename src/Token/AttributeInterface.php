<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\Unicode\StringInterface;

/**
 * @psalm-immutable
 */
interface AttributeInterface
{

    /**
     * @return StringInterface
     * @psalm-pure
     */
    public function asString(): StringInterface;

    /**
     * @return int
     * @psalm-pure
     */
    public function asInteger(): int;

    /**
     * @return bool
     * @psalm-pure
     */
    public function asBoolean(): bool;
}
