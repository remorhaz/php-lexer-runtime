<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use Generator;
use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\Exception\InvalidSymbolCodeException;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\NullLexeme;
use Remorhaz\Lexer\Runtime\IO\SymbolInterface;
use Remorhaz\Lexer\Runtime\Token\TokenInput;
use Remorhaz\Lexer\Runtime\Token\TokenReaderInterface;
use Remorhaz\Lexer\Runtime\Token\Token;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\TokenInput
 */
class TokenInputTest extends TestCase
{

    public function testRead_NonIntegerCodeInTokenAttribute_ThrowsException(): void
    {
        $token = new Token(1, 2, new NullLexeme(), ['symbol.code' => 'a']);
        $reader = $this->createMock(TokenReaderInterface::class);
        $reader
            ->method('read')
            ->willReturn($token);
        $input = new TokenInput($reader);
        $this->expectException(InvalidSymbolCodeException::class);
        $input->read();
    }

    public function testRead_IntegerCodeInTokenAttribute_ReturnsSymbolWithSameCode(): void
    {
        $token = new Token(1, 2, new NullLexeme(), ['symbol.code' => 3]);
        $reader = $this->createMock(TokenReaderInterface::class);
        $reader
            ->method('read')
            ->willReturn($token);
        $input = new TokenInput($reader);
        self::assertSame(3, $input->read()->getCode());
    }

    public function testRead_TokenWithLexeme_ReturnsSymbolWithSameConstituentLexeme(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $token = new Token(1, 2, $lexeme, ['symbol.code' => 3]);
        $reader = $this->createMock(TokenReaderInterface::class);
        $reader
            ->method('read')
            ->willReturn($token);
        $input = new TokenInput($reader);
        self::assertSame($lexeme, $input->read()->getConstituentLexeme());
    }

    public function testGetOffset_ReaderReturnsOffset_ReturnsSameValue(): void
    {
        $reader = $this->createMock(TokenReaderInterface::class);
        $input = new TokenInput($reader);
        $reader
            ->method('getOffset')
            ->willReturn(1);
        self::assertSame(1, $input->getOffset());
    }

    /**
     * @param bool $isFinished
     * @param bool $expectedValue
     * @dataProvider providerIsFinished
     */
    public function testIsFinished_ReaderReturnsIsFinished_ReturnsSameValue(bool $isFinished, bool $expectedValue): void
    {
        $reader = $this->createMock(TokenReaderInterface::class);
        $input = new TokenInput($reader);
        $reader
            ->method('isFinished')
            ->willReturn($isFinished);
        self::assertSame($expectedValue, $input->isFinished());
    }

    public function providerIsFinished(): array
    {
        return [
            'Is finished' => [true, true],
            'Is not finished' => [false, false],
        ];
    }

    public function testGetEmptyLexeme_TokenReaderReturnsEmptyLexeme_ReturnsSameInstance(): void
    {
        $reader = $this->createMock(TokenReaderInterface::class);
        $input = new TokenInput($reader);
        $lexeme = $this->createMock(LexemeInterface::class);
        $reader
            ->method('getEmptyLexeme')
            ->willReturn($lexeme);
        self::assertSame($lexeme, $input->getEmptyLexeme());
    }

    /**
     * @param bool[]  $isFinished
     * @param int[]   $offsets
     * @param int[][] $tokens
     * @param array[] $expectedValue
     * @dataProvider providerGetIterator
     */
    public function testGetIterator_Constructed_ResultIteratesMatchingValues(
        array $isFinished,
        array $offsets,
        array $tokens,
        array $expectedValue
    ): void {
        $reader = $this->createMock(TokenReaderInterface::class);
        $input = new TokenInput($reader);
        $reader
            ->method('isFinished')
            ->willReturnOnConsecutiveCalls(...$isFinished);
        $reader
            ->method('getOffset')
            ->willReturnOnConsecutiveCalls(...$offsets);
        $reader
            ->method('read')
            ->willReturnOnConsecutiveCalls(...$this->importTokens(...$tokens));
        $results = [];
        /**
         * @var int             $offset
         * @var SymbolInterface $value
         */
        foreach ($input as $offset => $value) {
            $results[] = [
                'offset' => $offset,
                'symbol' => $this->exportSymbol($value),
            ];
        }
        self::assertSame($expectedValue, $results);
    }

    public function providerGetIterator(): array
    {
        return [
            'No tokens' => [
                [true],
                [],
                [],
                [],
            ],
            'Single token' => [
                [false, true],
                [1],
                [[2, 3, 4]],
                [
                    [
                        'offset' => 1,
                        'symbol' => [
                            'code' => 4,
                            'offset' => 3,
                        ],
                    ],
                ],
            ],
            'Two tokens' => [
                [false, false, true],
                [1, 2],
                [[3, 4, 5], [6, 7, 8]],
                [
                    [
                        'offset' => 1,
                        'symbol' => [
                            'code' => 5,
                            'offset' => 4,
                        ],
                    ],
                    [
                        'offset' => 2,
                        'symbol' => [
                            'code' => 8,
                            'offset' => 7,
                        ],
                    ],
                ],
            ],
        ];
    }

    private function importTokens(array ...$tokens): Generator
    {
        foreach ($tokens as $tokenArgs) {
            [$id, $offset, $code] = $tokenArgs;
            yield new Token($id, $offset, new NullLexeme(), ['symbol.code' => $code]);
        }
    }

    private function exportSymbol(SymbolInterface $symbol): array
    {
        return [
            'code' => $symbol->getCode(),
            'offset' => $symbol->getOffset(),
        ];
    }
}
