<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\ArrayInput;
use Remorhaz\Lexer\Runtime\IO\PreviewBuffer;
use Remorhaz\Lexer\Runtime\Token\Exception\UnexpectedEndOfInputException;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\PreviewBufferInterface;
use Remorhaz\Lexer\Runtime\Token\MatcherInterface;
use Remorhaz\Lexer\Runtime\Token\MatcherSelector;
use Remorhaz\Lexer\Runtime\Token\MatcherSelectorInterface;
use Remorhaz\Lexer\Runtime\Token\MatchResultInterface;
use Remorhaz\Lexer\Runtime\Token\MatchSuccess;
use Remorhaz\Lexer\Runtime\Token\TokenBuilder;
use Remorhaz\Lexer\Runtime\Token\TokenInterface;
use Remorhaz\Lexer\Runtime\Token\TokenReader;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\TokenReader
 */
class TokenReaderTest extends TestCase
{

    public function testIsFinished_Constructed_ReturnsFalse(): void
    {
        $reader = new TokenReader(
            $this->createMock(PreviewBufferInterface::class),
            $this->createMock(MatcherSelectorInterface::class)
        );
        self::assertFalse($reader->isFinished());
    }

    public function testGetOffset_NoTokensRead_ReturnsZero(): void
    {
        $reader = new TokenReader(
            $this->createMock(PreviewBufferInterface::class),
            $this->createMock(MatcherSelectorInterface::class)
        );
        self::assertSame(0, $reader->getOffset());
    }

    public function testGetOffset_SingleTokenRead_ReturnsAmountOfTokensRead(): void
    {
        $previewBuffer = $this->createMock(PreviewBufferInterface::class);
        $reader = new TokenReader(
            $previewBuffer,
            $this->createMock(MatcherSelectorInterface::class)
        );
        $previewBuffer
            ->method('isFinished')
            ->willReturn(false);

        $reader->read();
        self::assertSame(1, $reader->getOffset());
    }

    public function testGetOffset_TwoTokensRead_ReturnsAmountOfTokensRead(): void
    {
        $previewBuffer = $this->createMock(PreviewBufferInterface::class);
        $reader = new TokenReader(
            $previewBuffer,
            $this->createMock(MatcherSelectorInterface::class)
        );
        $previewBuffer
            ->method('isFinished')
            ->willReturn(false);

        $reader->read();
        $reader->read();
        self::assertSame(2, $reader->getOffset());
    }

    public function testGetEmptyLexeme_NoTokensRead_ReturnsLexemeWithCurrentOffset(): void
    {
        $previewBuffer = $this->createMock(PreviewBufferInterface::class);
        $reader = new TokenReader(
            $previewBuffer,
            $this->createMock(MatcherSelectorInterface::class)
        );
        $previewBuffer
            ->method('isFinished')
            ->willReturn(false);

        self::assertSame(0, $reader->getEmptyLexeme()->getStartOffsets()[0] ?? null);
    }

    public function testGetEmptyLexeme_SingleTokenRead_ReturnsLexemeWithCurrentOffset(): void
    {
        $previewBuffer = $this->createMock(PreviewBufferInterface::class);
        $reader = new TokenReader(
            $previewBuffer,
            $this->createMock(MatcherSelectorInterface::class)
        );
        $previewBuffer
            ->method('isFinished')
            ->willReturn(false);

        $reader->read();
        self::assertSame(1, $reader->getEmptyLexeme()->getStartOffsets()[0] ?? null);
    }

    public function testGetEmptyLexeme_PreviewBufferProvidesEmptyLexeme_ReturnsLexemeWithSameConstituentLexeme(): void
    {
        $previewBuffer = $this->createMock(PreviewBufferInterface::class);
        $reader = new TokenReader(
            $previewBuffer,
            $this->createMock(MatcherSelectorInterface::class)
        );
        $constituentLexeme = $this->createMock(LexemeInterface::class);
        $previewBuffer
            ->method('getEmptyLexeme')
            ->willReturn($constituentLexeme);
        self::assertSame($constituentLexeme, $reader->getEmptyLexeme()->getConstituentLexeme());
    }

    public function testRead_PreviewBufferIsFinished_IsFinishedReturnsTrue(): void
    {
        $previewBuffer = $this->createMock(PreviewBufferInterface::class);
        $reader = new TokenReader(
            $previewBuffer,
            $this->createMock(MatcherSelectorInterface::class)
        );
        $previewBuffer
            ->method('isFinished')
            ->willReturn(true);
        $reader->read();
        self::assertTrue($reader->isFinished());
    }

    public function testRead_PreviewBufferIsFinished_ReturnsFinalToken(): void
    {
        $previewBuffer = $this->createMock(PreviewBufferInterface::class);
        $reader = new TokenReader(
            $previewBuffer,
            $this->createMock(MatcherSelectorInterface::class)
        );
        $previewBuffer
            ->method('isFinished')
            ->willReturn(true);
        self::assertTrue($reader->read()->isFinal());
    }

    public function testRead_PreviewBufferIsFinished_KeepsOffsetUnchanged(): void
    {
        $previewBuffer = $this->createMock(PreviewBufferInterface::class);
        $reader = new TokenReader(
            $previewBuffer,
            $this->createMock(MatcherSelectorInterface::class)
        );
        $previewBuffer
            ->method('isFinished')
            ->willReturn(true);
        self::assertSame($reader->getOffset(), $reader->read()->getOffset());
    }

    public function testRead_IsFinished_ThrowsException(): void
    {
        $previewBuffer = $this->createMock(PreviewBufferInterface::class);
        $reader = new TokenReader(
            $previewBuffer,
            $this->createMock(MatcherSelectorInterface::class)
        );
        $previewBuffer
            ->method('isFinished')
            ->willReturn(true);
        $reader->read();

        $this->expectException(UnexpectedEndOfInputException::class);
        $reader->read();
    }

    public function testGetIterator_PreviewBufferProvidesTokens_ReadsMatchingTokens(): void
    {
        $previewBuffer = new PreviewBuffer(new ArrayInput(1, 2, 3));
        $matcher = new class () implements MatcherInterface {

            public function match(
                int $offset,
                PreviewBufferInterface $input,
                MatcherSelectorInterface $selector
            ): MatchResultInterface {
                $char = $input->getPreviewSymbol();
                $input->previewNext();
                $lexeme = $input->acceptLexeme();
                $token = (new TokenBuilder($char->getCode(), $offset, $lexeme))->build();

                return new MatchSuccess($token);
            }
        };

        $reader = new TokenReader($previewBuffer, new MatcherSelector(['a' => $matcher]));

        $offsets = [];
        $tokens = [];
        foreach ($reader as $offset => $token) {
            $offsets[] = $offset;
            $tokens[] = $this->exportToken($token);
        }
        $actualValue = [
            'offsets' => $offsets,
            'tokens' => $tokens,
        ];
        $expectedValue = [
            'offsets' => [0, 1, 2, 3],
            'tokens' => [
                ['id' => 1, 'offset' => 0],
                ['id' => 2, 'offset' => 1],
                ['id' => 3, 'offset' => 2],
                ['id' => 0, 'offset' => 3],
            ],
        ];
        self::assertSame($expectedValue, $actualValue);
    }

    private function exportToken(TokenInterface $token): array
    {
        return [
            'id' => $token->getId(),
            'offset' => $token->getOffset(),
        ];
    }
}
