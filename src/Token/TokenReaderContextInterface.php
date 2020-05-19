<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

interface TokenReaderContextInterface
{

    public function readToken(): TokenInterface;

    public function getMatcher(): TokenMatcherInterface;
}
