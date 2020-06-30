<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\Unicode\StringInterface;

/**
 * @psalm-immutable
 */
final class IntegerAttribute implements AttributeInterface
{

    /**
     * @var int
     */
    private $value;

    /**
     * @param int $value
     */
    public function __construct(int $value)
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
        throw new Exception\WrongAttributeTypeException($this->value, 'boolean');
    }

    /**
     * @return int
     * @psalm-pure
     */
    public function asInteger(): int
    {
        return $this->value;
    }
}
