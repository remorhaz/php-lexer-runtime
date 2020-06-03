<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\EmptyLexeme;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;

/**
 * @psalm-immutable
 */
final class MatchFail implements MatchResultInterface
{

    /**
     * @var int[]
     * @psalm-var array<int,int>
     */
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

    /**
     * @return bool
     * @psalm-pure
     */
    public function hasLexeme(): bool
    {
        return true;
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getLexeme(): LexemeInterface
    {
        return EmptyLexeme::fromOffsets(...$this->offsets);
    }
}
