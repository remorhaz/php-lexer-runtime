<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token\Exception;

use OutOfRangeException;
use Throwable;

final class AttributeNotFoundException extends OutOfRangeException implements ExceptionInterface
{

    /**
     * @var string
     */
    private $name;

    public function __construct(string $name, Throwable $previous = null)
    {
        $this->name = $name;
        parent::__construct("Token attribute not found: {$name}", 0, $previous);
    }

    /**
     * @return string
     * @psalm-pure
     */
    public function getName(): string
    {
        return $this->name;
    }
}
