<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\LexemeInterface;

/**
 * @psalm-immutable
 */
final class Token implements TokenInterface
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
    private $attributes;

    /**
     * Token constructor.
     *
     * @param int             $id
     * @param int             $offset
     * @param LexemeInterface $lexeme
     * @param array           $attributes
     * @psalm-param array<string,mixed> $attributes
     */
    public function __construct(int $id, int $offset, LexemeInterface $lexeme, array $attributes = [])
    {
        $this->id = $id;
        $this->offset = $offset;
        $this->lexeme = $lexeme;
        $this->attributes = $attributes;
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @return LexemeInterface
     * @psalm-pure
     */
    public function getLexeme(): LexemeInterface
    {
        return $this->lexeme;
    }

    /**
     * @param string $name
     * @return mixed
     * @psalm-pure
     */
    public function getAttribute(string $name)
    {
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        }

        throw new Exception\AttributeNotFoundException($name);
    }

    public function isFinal(): bool
    {
        return false;
    }
}
