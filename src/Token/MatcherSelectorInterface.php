<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

interface MatcherSelectorInterface
{

    /**
     * Returns active token matcher.
     *
     * @return MatcherInterface
     */
    public function getMatcher(): MatcherInterface;

    /**
     * Sets active token matcher by given key.
     *
     * @param string $matcherKey
     */
    public function setMatcher(string $matcherKey): void;

    /**
     * Restores previous active token matcher.
     */
    public function restoreMatcher(): void;
}
