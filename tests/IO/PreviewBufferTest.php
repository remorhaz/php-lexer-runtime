<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\IO;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\ArrayInput;
use Remorhaz\Lexer\Runtime\IO\Exception\EmptyLexemeException;
use Remorhaz\Lexer\Runtime\IO\Exception\InvalidPreviewOffsetException;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\IO\PreviewBuffer;
use Remorhaz\Lexer\Runtime\IO\SymbolInterface;

use function array_map;

/**
 * @covers \Remorhaz\Lexer\Runtime\IO\PreviewBuffer
 */
class PreviewBufferTest extends TestCase
{

    public function testGetPreviewSymbol_CalledOnce_ReturnsFirstInputSymbol(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        self::assertSame(1, $buffer->getPreviewSymbol()->getCode());
    }

    public function testGetPreviewSymbol_CalledTwice_ReturnsFirstInputSymbol(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->getPreviewSymbol();
        self::assertSame(1, $buffer->getPreviewSymbol()->getCode());
    }

    public function testGetPreviewSymbol_PreviewNextCalledOnce_ReturnsSecondInputSymbol(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        self::assertSame(2, $buffer->getPreviewSymbol()->getCode());
    }

    public function testResetPreview_PreviewNextNotCalled_PreviewReturnsFirstInputSymbol(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->resetPreview();
        self::assertSame(1, $buffer->getPreviewSymbol()->getCode());
    }

    public function testResetPreview_OneSymbolFetchedPreviewNextNotCalled_PreviewReturnsSecondInputSymbol(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->acceptLexeme();
        $buffer->resetPreview();
        self::assertSame(2, $buffer->getPreviewSymbol()->getCode());
    }

    public function testResetPreview_PreviewNextCalledOnce_PreviewReturnsFirstInputSymbol(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->resetPreview();
        self::assertSame(1, $buffer->getPreviewSymbol()->getCode());
    }

    public function testResetPreview_OneSymbolFetchedPreviewNextCalledOnce_PreviewReturnsSecondInputSymbol(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->acceptLexeme();
        $buffer->previewNext();
        $buffer->resetPreview();
        self::assertSame(2, $buffer->getPreviewSymbol()->getCode());
    }

    public function testResetPreview_PreviewNextCalledTwice_PreviewReturnsMatchingInputSymbol(): void
    {
        $input = new ArrayInput(1, 2, 3);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->previewNext();
        $buffer->resetPreview();
        self::assertSame(1, $buffer->getPreviewSymbol()->getCode());
    }

    public function testPreviewPrevious_PreviewNextNotCalled_ThrowsException(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $this->expectException(InvalidPreviewOffsetException::class);
        $buffer->previewPrevious();
    }

    public function testPreviewPrevious_OneSymbolFetchedPreviewNextNotCalled_ThrowsException(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->acceptLexeme();
        $this->expectException(InvalidPreviewOffsetException::class);
        $buffer->previewPrevious();
    }

    public function testPreviewPrevious_PreviewNextCalledOnce_PreviewReturnsFirstSymbol(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->previewPrevious();
        self::assertSame(1, $buffer->getPreviewSymbol()->getCode());
    }

    public function testPreviewPrevious_PreviewNextCalledTwice_PreviewReturnsSecondSymbol(): void
    {
        $input = new ArrayInput(1, 2, 3);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->previewNext();
        $buffer->previewPrevious();
        self::assertSame(2, $buffer->getPreviewSymbol()->getCode());
    }

    public function testIsFinished_EmptyInput_ReturnsTrue(): void
    {
        $input = new ArrayInput();
        $buffer = new PreviewBuffer($input);
        self::assertTrue($buffer->isFinished());
    }

    public function testIsFinished_PreviewNextNotCalled_ReturnsFalse(): void
    {
        $input = new ArrayInput(1);
        $buffer = new PreviewBuffer($input);
        self::assertFalse($buffer->isFinished());
    }

    public function testIsFinished_PreviewedUntilFinish_ReturnsTrue(): void
    {
        $input = new ArrayInput(1);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        self::assertTrue($buffer->isFinished());
    }

    public function testIsFinished_PreviewedUntilFinishAndBack_ReturnsFalse(): void
    {
        $input = new ArrayInput(1);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->previewPrevious();
        self::assertFalse($buffer->isFinished());
    }

    public function testAcceptLexeme_PreviewNextNotCalled_ThrowsException(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $this->expectException(EmptyLexemeException::class);
        $buffer->acceptLexeme();
    }

    public function testAcceptLexeme_PreviewNextCalledOnce_ReturnsLexemeWithFirstSymbol(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $lexeme = $buffer->acceptLexeme();
        self::assertSame([1], $this->exportLexemeSymbolCodes($lexeme));
    }

    public function testAcceptLexeme_PreviewNextCalledTwice_ReturnsLexemeWithFirstTwoSymbols(): void
    {
        $input = new ArrayInput(1, 2, 3);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->previewNext();
        $lexeme = $buffer->acceptLexeme();
        self::assertSame([1, 2], $this->exportLexemeSymbolCodes($lexeme));
    }

    public function testAcceptLexeme_OneSymbolFetchedPreviewNextCalledOnce_ReturnsLexemeWithSecondSymbol(): void
    {
        $input = new ArrayInput(1, 2, 3);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->acceptLexeme();
        $buffer->previewNext();
        $lexeme = $buffer->acceptLexeme();
        self::assertSame([2], $this->exportLexemeSymbolCodes($lexeme));
    }

    public function testAcceptLexeme_OneSymbolFetchedPreviewNextTwiceBackOnce_ReturnsLexemeWithSecondSymbol(): void
    {
        $input = new ArrayInput(1, 2, 3);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->acceptLexeme();
        $buffer->previewNext();
        $buffer->previewNext();
        $buffer->previewPrevious();
        $lexeme = $buffer->acceptLexeme();
        self::assertSame([2], $this->exportLexemeSymbolCodes($lexeme));
    }

    public function testGetEmptyLexeme_EmptyInput_ReturnsLexemeWithZeroStartOffsets(): void
    {
        $input = new ArrayInput();
        $buffer = new PreviewBuffer($input);
        self::assertSame([0], $buffer->getEmptyLexeme()->getStartOffsets());
    }

    public function testGetEmptyLexeme_EmptyInput_ReturnsLexemeWithZeroFinishOffsets(): void
    {
        $input = new ArrayInput();
        $buffer = new PreviewBuffer($input);
        self::assertSame([0], $buffer->getEmptyLexeme()->getFinishOffsets());
    }

    public function testGetEmptyLexeme_NonEmptyInput_ReturnsLexemeWithZeroStartOffsets(): void
    {
        $input = new ArrayInput(1);
        $buffer = new PreviewBuffer($input);
        self::assertSame([0], $buffer->getEmptyLexeme()->getStartOffsets());
    }

    public function testGetEmptyLexeme_NonEmptyInput_ReturnsLexemeWithZeroFinishOffsets(): void
    {
        $input = new ArrayInput(1);
        $buffer = new PreviewBuffer($input);
        self::assertSame([0], $buffer->getEmptyLexeme()->getFinishOffsets());
    }

    public function testGetEmptyLexeme_OneSymbolFetched_ReturnsLexemeWithOneStartOffsets(): void
    {
        $input = new ArrayInput(1);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        self::assertSame([1], $buffer->getEmptyLexeme()->getStartOffsets());
    }

    public function testGetEmptyLexeme_OneSymbolFetched_ReturnsLexemeWithOneFinishOffsets(): void
    {
        $input = new ArrayInput(1);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        self::assertSame([1], $buffer->getEmptyLexeme()->getFinishOffsets());
    }

    public function testGetEmptyLexeme_TwoSymbolsFetchedAndOneStepBack_ReturnsLexemeWithOneStartOffsets(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->previewNext();
        $buffer->previewPrevious();
        self::assertSame([1], $buffer->getEmptyLexeme()->getStartOffsets());
    }

    public function testGetEmptyLexeme_TwoSymbolsFetchedAndOneStepBack_ReturnsLexemeWithOneFinishOffsets(): void
    {
        $input = new ArrayInput(1, 2);
        $buffer = new PreviewBuffer($input);
        $buffer->previewNext();
        $buffer->previewNext();
        $buffer->previewPrevious();
        self::assertSame([1], $buffer->getEmptyLexeme()->getFinishOffsets());
    }

    private function exportLexemeSymbolCodes(LexemeInterface $lexeme): array
    {
        return array_map(
            function (SymbolInterface $symbol): int {
                return $symbol->getCode();
            },
            $lexeme->getSymbols()
        );
    }
}
