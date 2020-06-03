<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\LexemeInterface;

/**
 * @psalm-immutable
 */
final class MatchSuccess implements MatchResultInterface
{

    /**
     * @var TokenInterface
     */
    private $token;

    public function __construct(TokenInterface $token)
    {
        $this->token = $token;
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
        return true;
    }

    /**
     * @return TokenInterface
     * @psalm-pure
     */
    public function getToken(): TokenInterface
    {
        return $this->token;
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
        return $this->token->getLexeme();
    }
}
