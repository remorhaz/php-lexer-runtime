<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO\Exception;

use LogicException;
use Throwable;

final class EmptyLexemeException extends LogicException implements ExceptionInterface
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct("Lexeme contains no symbols", 0, $previous);
    }
}
