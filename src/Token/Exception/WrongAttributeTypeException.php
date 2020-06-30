<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Token\Exception;

use LogicException;
use Throwable;

use function count;
use function get_class;
use function gettype;
use function is_array;
use function is_object;
use function spl_object_id;

final class WrongAttributeTypeException extends LogicException implements ExceptionInterface
{

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string
     */
    private $expectedType;

    /**
     * @param mixed          $value
     * @param string         $expectedType
     * @param Throwable|null $previous
     */
    public function __construct($value, string $expectedType, Throwable $previous = null)
    {
        $this->value = $value;
        $this->expectedType = $expectedType;
        parent::__construct($this->buildMessage(), 0, $previous);
    }

    /**
     * @return string
     */
    private function buildMessage(): string
    {
        return "Wrong attribute value type: {$this->exportActualType()} instead of {$this->expectedType}";
    }

    /**
     * @return string
     */
    private function exportActualType(): string
    {
        if (is_object($this->value)) {
            $class = get_class($this->value);
            $id = spl_object_id($this->value);

            return "object({$class}:{$id})";
        }

        if (is_array($this->value)) {
            $count = count($this->value);

            return "array({$count})";
        }

        return gettype($this->value);
    }

    /**
     * @return mixed
     * @psalm-pure
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     * @psalm-pure
     */
    public function getExpectedType(): string
    {
        return $this->expectedType;
    }
}
