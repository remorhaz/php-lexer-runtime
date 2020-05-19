<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token;

use Remorhaz\Lexer\Runtime\IO\ReaderInterface;
use Remorhaz\Lexer\Runtime\Token\TokenInterface;

interface TokenReaderInterface extends ReaderInterface
{

    public function read(): TokenInterface;
}
