<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\ReaderInterface;

interface TokenReaderInterface extends ReaderInterface
{

    public function read(): TokenInterface;
}
