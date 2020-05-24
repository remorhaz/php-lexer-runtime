<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token\Exception;

use LogicException;
use Throwable;

final class TokenNotReadyException extends LogicException implements ExceptionInterface
{

    public function __construct(Throwable $previous = null)
    {
        parent::__construct("Token is not ready yet", 0, $previous);
    }
}
