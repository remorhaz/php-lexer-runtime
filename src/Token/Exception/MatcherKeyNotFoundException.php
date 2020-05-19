<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token\Exception;

use OutOfRangeException;
use Throwable;

final class MatcherKeyNotFoundException extends OutOfRangeException implements ExceptionInterface
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct("Matcher key not found", 0, $previous);
    }
}
