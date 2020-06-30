<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

/**
 * @psalm-immutable
 */
interface AttributeCollectionInterface
{

    /**
     * @param string $name
     * @return AttributeInterface
     * @psalm-pure
     */
    public function get(string $name): AttributeInterface;

    /**
     * @param string $name
     * @return bool
     * @psalm-pure
     */
    public function has(string $name): bool;
}
