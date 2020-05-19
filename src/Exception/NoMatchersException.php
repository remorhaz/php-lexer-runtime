<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Exception;

use LogicException;
use Throwable;

final class NoMatchersException extends LogicException implements ExceptionInterface
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct("No matchers defined", 0, $previous);
    }
}
