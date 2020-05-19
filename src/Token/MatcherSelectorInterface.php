<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\Token\TokenMatcherInterface;

interface MatcherSelectorInterface
{

    public function getMatcher(): TokenMatcherInterface;

    public function setMatcher(string $class): void;

    public function restoreMatcher(): void;
}
