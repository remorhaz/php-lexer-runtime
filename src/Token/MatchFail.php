<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\Token\TokenInterface;

/**
 * @psalm-immutable
 */
final class MatchFail implements MatchResultInterface
{

    private $offsets;

    public function __construct(int ...$offsets)
    {
        $this->offsets = $offsets;
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function shouldRepeat(): bool
    {
        return false;
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
        throw new Exception\TokenNotMatchedException($this->offsets);
    }
}
