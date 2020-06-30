<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token\Exception;

use Exception;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\WrongAttributeTypeException;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\Exception\WrongAttributeTypeException
 */
class WrongAttributeTypeExceptionTest extends TestCase
{

    /**
     * @param        $value
     * @param string $expectedType
     * @param string $expectedValue
     * @dataProvider providerGetMessage
     */
    public function testGetMessage_Constructed_ReturnsMatchingValue(
        $value,
        string $expectedType,
        string $expectedValue
    ): void {
        $exception = new WrongAttributeTypeException($value, $expectedType);
        self::assertMatchesRegularExpression($expectedValue, $exception->getMessage());
    }

    public function providerGetMessage(): array
    {
        return [
            'Null' => [null, 'a', '#^Wrong attribute value type: NULL instead of a$#'],
            'Integer' => [1, 'a', '#^Wrong attribute value type: integer instead of a$#'],
            'Array' => [[1, 2], 'a', '#^Wrong attribute value type: array\(2\) instead of a$#'],
            'Object' => [(object) [], 'a', '#^Wrong attribute value type: object\(stdClass:(\d+)\) instead of a$#'],
        ];
    }

    public function testGetValue_ConstructedWithValue_ReturnsSameValue(): void
    {
        $exception = new WrongAttributeTypeException('a', 'b');
        self::assertSame('a', $exception->getValue());
    }

    public function testGetExpectedType_ConstructedWithExpectedType_ReturnsSameValue(): void
    {
        $exception = new WrongAttributeTypeException('a', 'b');
        self::assertSame('b', $exception->getExpectedType());
    }

    public function testGetCode_Always_ReturnsZero(): void
    {
        $exception = new WrongAttributeTypeException(null, 'a');
        self::assertSame(0, $exception->getCode());
    }

    public function testGetPrevious_ConstructedWithoutPrevious_ReturnsNull(): void
    {
        $exception = new WrongAttributeTypeException(null, 'a');
        self::assertNull($exception->getPrevious());
    }

    public function testGetPrevious_ConstructedWithPrevious_ReturnsSameInstance(): void
    {
        $previous = new Exception();
        $exception = new WrongAttributeTypeException(null, 'a', $previous);
        self::assertSame($previous, $exception->getPrevious());
    }
}
