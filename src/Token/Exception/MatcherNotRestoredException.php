<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token\Exception;

use LogicException;
use Throwable;

final class MatcherNotRestoredException extends LogicException implements ExceptionInterface
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct("Matcher not restored", 0, $previous);
    }
}
