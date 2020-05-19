<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\Token\TokenInterface;

/**
 * @psalm-immutable
 */
interface MatchResultInterface
{

    /**
     * @return bool
     * @psalm-pure
     */
    public function shouldRepeat(): bool;

    /**
     * @return bool
     * @psalm-pure
     */
    public function hasToken(): bool;

    /**
     * @return TokenInterface
     * @psalm-pure
     */
    public function getToken(): TokenInterface;
}
