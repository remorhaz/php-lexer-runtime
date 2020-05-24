<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\Exception\UnexpectedEndOfInputException;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\StringInput;
use Remorhaz\Lexer\Runtime\IO\SymbolInterface;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\StringInput
 */
class StringInputTest extends TestCase
{

    public function testRead_ConstructedWithEmptyString_ThrowsException(): void
    {
        $input = new StringInput('');
        $this->expectException(UnexpectedEndOfInputException::class);
        $input->read();
    }

    public function testRead_HasSymbolToReadCalledOnce_ReturnsSymbolWithFirstCharCode(): void
    {
        $input = new StringInput('a');
        self::assertSame(0x61, $input->read()->getCode());
    }

    public function testRead_HasOneSymbolToReadCalledOnce_ReturnsSymbolWithOffsetZero(): void
    {
        $input = new StringInput('a');
        self::assertSame(0, $input->read()->getOffset());
    }

    public function testRead_HasOneSymbolToReadCalledTwice_ThrowsException(): void
    {
        $input = new StringInput('a');
        $input->read();
        $this->expectException(UnexpectedEndOfInputException::class);
        $input->read();
    }

    public function testRead_HasSymbolsToReadAndCalledTwice_ReturnsSymbolWithSecondCharCode(): void
    {
        $input = new StringInput('ab');
        $input->read();
        self::assertSame(0x62, $input->read()->getCode());
    }

    public function testRead_HasSymbolsToReadAndCalledTwice_ReturnsSymbolWithOffsetOne(): void
    {
        $input = new StringInput('ab');
        $input->read();
        self::assertSame(1, $input->read()->getOffset());
    }

    public function testRead_HasSymbolToRead_ReturnsSymbolWithEmptyConstituentText(): void
    {
        $input = new StringInput('a');
        self::assertEmpty($input->read()->getConstituentLexeme()->getSymbols());
    }

    public function testIsFinished_ConstructedWithEmptyString_ReturnsTrue(): void
    {
        $input = new StringInput('');
        self::assertTrue($input->isFinished());
    }

    public function testIsFinished_ConstructedWithNonEmptyString_ReturnsFalse(): void
    {
        $input = new StringInput('a');
        self::assertFalse($input->isFinished());
    }

    public function testIsFinished_AllCharsRead_ReturnsTrue(): void
    {
        $input = new StringInput('a');
        $input->read();
        self::assertTrue($input->isFinished());
    }

    public function testGetOffset_Constructed_ReturnsZero(): void
    {
        $input = new StringInput('');
        self::assertSame(0, $input->getOffset());
    }

    public function testGetOffset_OneCharRead_ReturnsOne(): void
    {
        $input = new StringInput('a');
        $input->read();
        self::assertSame(1, $input->getOffset());
    }

    public function testGetOffset_TwoCharsRead_ReturnsTwo(): void
    {
        $input = new StringInput('ab');
        $input->read();
        $input->read();
        self::assertSame(2, $input->getOffset());
    }

    public function testGetEmptyLexeme_Constructed_ReturnsLexemeWithZeroStartOffset(): void
    {
        $input = new StringInput('');
        self::assertSame([0], $input->getEmptyLexeme()->getStartOffsets());
    }

    public function testGetEmptyLexeme_Constructed_ReturnsLexemeWithZeroFinishOffset(): void
    {
        $input = new StringInput('');
        self::assertSame([0], $input->getEmptyLexeme()->getFinishOffsets());
    }

    public function testGetEmptyLexeme_SingleCharRead_ReturnsLexemeWithOneStartOffset(): void
    {
        $input = new StringInput('a');
        $input->read();
        self::assertSame([1], $input->getEmptyLexeme()->getStartOffsets());
    }

    public function testGetEmptyLexeme_SingleCharRead_ReturnsLexemeWithOneFinishOffset(): void
    {
        $input = new StringInput('a');
        $input->read();
        self::assertSame([1], $input->getEmptyLexeme()->getFinishOffsets());
    }

    /**
     * @param string $data
     * @param array $expectedValue
     * @dataProvider providerGetIterator
     */
    public function testGetIterator_Constructed_IteratesMatchingArray(string $data, array $expectedValue): void
    {
        $input = new StringInput($data);
        self::assertSame($expectedValue, $this->exportSymbolIterator($input));
    }

    public function providerGetIterator(): array
    {
        return [
            'No data' => ['', []],
            'Single value' => [
                'a',
                [
                    [
                        'offset' => 0,
                        'symbol' => [
                            'code' => 0x61,
                            'offset' => 0,
                            'lexeme' => [
                                'codes' => [0x61],
                                'starts' => [0],
                                'finishes' => [0],
                            ],
                        ],
                    ],
                ],
            ],
            'Two values' => [
                'ab',
                [
                    [
                        'offset' => 0,
                        'symbol' => [
                            'code' => 0x61,
                            'offset' => 0,
                            'lexeme' => [
                                'codes' => [0x61],
                                'starts' => [0],
                                'finishes' => [0],
                            ],
                        ],
                    ],
                    [
                        'offset' => 1,
                        'symbol' => [
                            'code' => 0x62,
                            'offset' => 1,
                            'lexeme' => [
                                'codes' => [0x62],
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
