<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\IO\Exception;

use DomainException;
use Remorhaz\Lexer\Runtime\Token\AttributeInterface;
use Throwable;

final class InvalidSymbolCodeException extends DomainException implements ExceptionInterface
{

    /**
     * @var AttributeInterface
     */
    private $attribute;

    /**
     * @param AttributeInterface $attribute
     * @param Throwable|null     $previous
     */
    public function __construct(AttributeInterface $attribute, Throwable $previous = null)
    {
        $this->attribute = $attribute;
        parent::__construct("Invalid symbol code", 0, $previous);
    }

    /**
     * @return AttributeInterface
     * @psalm-pure
     */
    public function getAttribute(): AttributeInterface
    {
        return $this->attribute;
    }
}
