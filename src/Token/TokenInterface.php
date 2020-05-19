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
     * @param string $name
     * @return mixed
     * @psalm-pure
     */
    public function getAttribute(string $name);

    /**
     * @return bool
     * @psalm-pure
     */
    public function isFinal(): bool;
}
