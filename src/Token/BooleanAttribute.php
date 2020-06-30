<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\Unicode\StringInterface;

/**
 * @psalm-immutable
 */
final class BooleanAttribute implements AttributeInterface
{

    /**
     * @var bool
     */
    private $value;

    /**
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return StringInterface
     * @psalm-pure
     */
    public function asString(): StringInterface
    {
        throw new Exception\WrongAttributeTypeException($this->value, 'Unicode string');
    }

    /**
     * @return bool
     * @psalm-pure
     */
    public function asBoolean(): bool
    {
        return $this->value;
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function asInteger(): int
    {
        throw new Exception\WrongAttributeTypeException($this->value, 'integer');
    }
}
