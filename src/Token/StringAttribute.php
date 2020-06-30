<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\Unicode\StringInterface;

/**
 * @psalm-immutable
 */
final class StringAttribute implements AttributeInterface
{

    /**
     * @var StringInterface
     */
    private $string;

    /**
     * @param StringInterface $string
     */
    public function __construct(StringInterface $string)
    {
        $this->string = $string;
    }

    /**
     * @return StringInterface
     * @psalm-pure
     */
    public function asString(): StringInterface
    {
        return $this->string;
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function asBoolean(): bool
    {
        throw new Exception\WrongAttributeTypeException($this->string, 'boolean');
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function asInteger(): int
    {
        throw new Exception\WrongAttributeTypeException($this->string, 'integer');
    }
}
