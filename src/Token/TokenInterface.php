<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\LexemeAwareInterface;

/**
 * @psalm-immutable
 */
interface TokenInterface extends LexemeAwareInterface
{

    /**
     * For convenience, zero token ID is reserved for end-of-input token.
     */
    public const ID_EOI = 0;

    /**
     * @return int
     * @psalm-pure
     */
    public function getId(): int;

    /**
     * @return int
     * @psalm-pure
     */
    public function getOffset(): int;

    /**
     * @return AttributeCollectionInterface
     * @psalm-pure
     */
    public function getAttributes(): AttributeCollectionInterface;

    /**
     * @return bool
     * @psalm-pure
     */
    public function isFinal(): bool;
}
