<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\Unicode\AsciiString;
use Remorhaz\Lexer\Runtime\Unicode\UnicodeString;

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
     * @var AttributeInterface[]
     * @psalm-var array<string, AttributeInterface>
     */
    private $attributes = [];

    /**
     * @param int             $id
     * @param int             $offset
     * @param LexemeInterface $lexeme
     */
    public function __construct(int $id, int $offset, LexemeInterface $lexeme)
    {
        $this->id = $id;
        $this->offset = $offset;
        $this->lexeme = $lexeme;
    }

    /**
     * @param string             $name
     * @param AttributeInterface $attribute
     * @return $this
     */
    private function setAttribute(string $name, AttributeInterface $attribute): self
    {
        $this->attributes[$name] = $attribute;

        return $this;
    }

    /**
     * @param string $name
     * @param bool   $value
     * @return $this
     */
    public function setBooleanAttribute(string $name, bool $value): self
    {
        return $this->setAttribute($name, new BooleanAttribute($value));
    }

    /**
     * @param string $name
     * @param int    $value
     * @return $this
     */
    public function setIntegerAttribute(string $name, int $value): self
    {
        return $this->setAttribute($name, new IntegerAttribute($value));
    }

    /**
     * @param string $name
     * @param string $value
     * @return $this
     */
    public function setAsciiAttribute(string $name, string $value): self
    {
        $string = new AsciiString($value);

        return $this->setAttribute($name, new StringAttribute($string));
    }

    /**
     * @param string $name
     * @param int    ...$characters
     * @return $this
     */
    public function setUnicodeAttribute(string $name, int ...$characters): self
    {
        $string = new UnicodeString(...$characters);

        return $this->setAttribute($name, new StringAttribute($string));
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setSymbolCode(int $code): self
    {
        return $this->setIntegerAttribute(TokenInput::ATTRIBUTE_SYMBOL_CODE, $code);
    }

    /**
     * @return TokenInterface
     * @psalm-pure
     */
    public function build(): TokenInterface
    {
        return new Token($this->id, $this->offset, $this->lexeme, new AttributeCollection($this->attributes));
    }
}
