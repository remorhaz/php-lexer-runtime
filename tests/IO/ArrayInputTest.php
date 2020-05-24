<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\ArrayInput;
use Remorhaz\Lexer\Runtime\IO\Exception\UnexpectedEndOfInputException;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\SymbolInterface;

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

    public function testGetEmptyLexeme_Constructed_ReturnsLexemeWithZeroStartOffset(): void
    {
        $input = new ArrayInput();
        self::assertSame([0], $input->getEmptyLexeme()->getStartOffsets());
    }

    public function testGetEmptyLexeme_Constructed_ReturnsLexemeWithZeroFinishOffset(): void
    {
        $input = new ArrayInput();
        self::assertSame([0], $input->getEmptyLexeme()->getFinishOffsets());
    }

    public function testGetEmptyLexeme_SingleCharRead_ReturnsLexemeWithOneStartOffset(): void
    {
        $input = new ArrayInput(2);
        $input->read();
        self::assertSame([1], $input->getEmptyLexeme()->getStartOffsets());
    }

    public function testGetEmptyLexeme_SingleCharRead_ReturnsLexemeWithOneFinishOffset(): void
    {
        $input = new ArrayInput(2);
        $input->read();
        self::assertSame([1], $input->getEmptyLexeme()->getFinishOffsets());
    }

    /**
     * @param array $data
     * @param array $expectedValue
     * @dataProvider providerGetIterator
     */
    public function testGetIterator_Constructed_IteratesMatchingArray(array $data, array $expectedValue): void
    {
        $input = new ArrayInput(...$data);
        self::assertSame($expectedValue, $this->exportSymbolIterator($input));
    }

    public function providerGetIterator(): array
    {
        return [
            'No data' => [[], []],
            'Single value' => [
                [1],
                [
                    [
                        'offset' => 0,
                        'symbol' => [
                            'code' => 1,
                            'offset' => 0,
                            'lexeme' => [
                                'codes' => [1],
                                'starts' => [0],
                                'finishes' => [0],
                            ],
                        ],
                    ],
                ],
            ],
            'Two values' => [
                [3, 4],
                [
                    [
                        'offset' => 0,
                        'symbol' => [
                            'code' => 3,
                            'offset' => 0,
                            'lexeme' => [
                                'codes' => [3],
                                'starts' => [0],
                                'finishes' => [0],
                            ],
                        ],
                    ],
                    [
                        'offset' => 1,
                        'symbol' => [
                            'code' => 4,
                            'offset' => 1,
                            'lexeme' => [
                                'codes' => [4],
                                'starts' => [1],
                                'finishes' => [1],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    private function exportSymbolIterator(iterable $input): array
    {
        $result = [];
        foreach ($input as $offset => $symbol) {
            $result[] = [
                'offset' => $offset,
                'symbol' => $this->exportSymbol($symbol),
            ];
        }

        return $result;
    }

    private function exportSymbol(SymbolInterface $symbol): array
    {
        return [
            'code' => $symbol->getCode(),
            'offset' => $symbol->getOffset(),
            'lexeme' => $this->exportLexeme($symbol->getLexeme()),
        ];
    }

    private function exportLexeme(LexemeInterface $lexeme): array
    {
        $codes = [];
        foreach ($lexeme->getSymbols() as $symbol) {
            $codes[] = $symbol->getCode();
        }

        return [
            'codes' => $codes,
            'starts' => $lexeme->getStartOffsets(),
            'finishes' => $lexeme->getFinishOffsets(),
        ];
    }
}
