<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\LexemeInterface;

/**
 * @psalm-external-mutation-free
 */
final class TokenBuilder
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $offset;

    /**
     * @var LexemeInterface
     */
    private $lexeme;

    /**
     * @var array
     * @psalm-var array<string,mixed>
     */
    private $attributes = [];

    public function __construct(int $id, int $offset, LexemeInterface $lexeme)
    {
        $this->id = $id;
        $this->offset = $offset;
        $this->lexeme = $lexeme;
    }

    /**
     * @param string $name
     * @param mixed  $value
     * @return $this
     */
    public function setAttribute(string $name, $value): self
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @return TokenInterface
     * @psalm-pure
     */
    public function build(): TokenInterface
    {
        return new Token($this->id, $this->offset, $this->lexeme, $this->attributes);
    }
}
