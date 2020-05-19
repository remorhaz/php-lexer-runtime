<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\ArrayInput;
use Remorhaz\Lexer\Runtime\IO\Exception\UnexpectedEndOfInputException;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\ArrayInput
 */
class ArrayInputTest extends TestCase
{

    public function testRead_ConstructedWithoutCharacters_ThrowsException(): void
    {
        $input = new ArrayInput();
        $this->expectException(UnexpectedEndOfInputException::class);
        $input->read();
    }

    public function testRead_HasSymbolToReadCalledOnce_ReturnsSymbolWithFirstCharCode(): void
    {
        $input = new ArrayInput(1);
        self::assertSame(1, $input->read()->getCode());
    }

    public function testRead_HasOneSymbolToReadCalledOnce_ReturnsSymbolWithOffsetZero(): void
    {
        $input = new ArrayInput(1);
        self::assertSame(0, $input->read()->getOffset());
    }

    public function testRead_HasOneSymbolToReadCalledTwice_ThrowsException(): void
    {
        $input = new ArrayInput(1);
        $input->read();
        $this->expectException(UnexpectedEndOfInputException::class);
        $input->read();
    }

    public function testRead_HasSymbolsToReadAndCalledTwice_ReturnsSymbolWithSecondCharCode(): void
    {
        $input = new ArrayInput(1, 2);
        $input->read();
        self::assertSame(2, $input->read()->getCode());
    }

    public function testRead_HasSymbolsToReadAndCalledTwice_ReturnsSymbolWithOffsetOne(): void
    {
        $input = new ArrayInput(2, 3);
        $input->read();
        self::assertSame(1, $input->read()->getOffset());
    }

    public function testRead_HasSymbolToRead_ReturnsSymbolWithEmptyConstituentText(): void
    {
        $input = new ArrayInput(1);
        self::assertEmpty($input->read()->getConstituentLexeme()->getSymbols());
    }

    public function testIsFinished_ConstructedWithEmptyString_ReturnsTrue(): void
    {
        $input = new ArrayInput();
        self::assertTrue($input->isFinished());
    }

    public function testIsFinished_ConstructedWithNonEmptyString_ReturnsFalse(): void
    {
        $input = new ArrayInput(1);
        self::assertFalse($input->isFinished());
    }

    public function testIsFinished_AllCharsRead_ReturnsTrue(): void
    {
        $input = new ArrayInput(1);
        $input->read();
        self::assertTrue($input->isFinished());
    }

    public function testGetOffset_Constructed_ReturnsZero(): void
    {
        $input = new ArrayInput();
        self::assertSame(0, $input->getOffset());
    }

    public function testGetOffset_OneCharRead_ReturnsOne(): void
    {
        $input = new ArrayInput(2);
        $input->read();
        self::assertSame(1, $input->getOffset());
    }

    public function testGetOffset_TwoCharsRead_ReturnsTwo(): void
    {
        $input = new ArrayInput(1, 3);
        $input->read();
        $input->read();
        self::assertSame(2, $input->getOffset());
    }
}
