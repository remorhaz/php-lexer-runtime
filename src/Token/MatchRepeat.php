<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\LexemeInterface;

/**
 * @psalm-immutable
 */
final class MatchRepeat implements MatchResultInterface
{

    /**
     * @return bool
     * @psalm-pure
     */
    public function shouldRepeat(): bool
    {
        return true;
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function hasToken(): bool
    {
        return false;
    }

    /**
     * @return TokenInterface
     * @psalm-pure
     */
    public function getToken(): TokenInterface
    {
        throw new Exception\TokenNotReadyException();
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function hasLexeme(): bool
    {
        return false;
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getLexeme(): LexemeInterface
    {
        throw new Exception\TokenNotReadyException();
    }
}
