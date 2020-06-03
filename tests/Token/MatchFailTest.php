<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\TokenNotMatchedException;
use Remorhaz\Lexer\Runtime\Token\MatchFail;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\MatchFail
 */
class MatchFailTest extends TestCase
{

    public function testShouldRepeat_Constructed_ReturnsFalse(): void
    {
        $result = new MatchFail();
        self::assertFalse($result->shouldRepeat());
    }

    public function testHasToken_Constructed_ReturnsFalse(): void
    {
        $result = new MatchFail();
        self::assertFalse($result->hasToken());
    }

    public function testGetToken_Constructed_ThrowsException(): void
    {
        $result = new MatchFail();
        $this->expectException(TokenNotMatchedException::class);
        $result->getToken();
    }

    public function testHasLexeme_Constructed_ReturnsTrue(): void
    {
        $result = new MatchFail();
        self::assertTrue($result->hasLexeme());
    }

    /**
     * @param int[] $resultOffsets
     * @param int[] $expectedValue
     * @dataProvider providerOffsets
     */
    public function testGetLexeme_ConstructedWithOffsets_ReturnsLexemeWithSameStartOffsets(
        array $resultOffsets,
        array $expectedValue
    ): void {
        $result = new MatchFail(...$resultOffsets);
        self::assertSame($expectedValue, $result->getLexeme()->getStartOffsets());
    }

    public function providerOffsets(): array
    {
        return [
            'No offsets' => [[], []],
            'Single offset' => [[1], [1]],
            'Two offsets' => [[1, 2], [1, 2]],
        ];
    }

    /**
     * @param int[] $resultOffsets
     * @param int[] $expectedValue
     * @dataProvider providerOffsets
     */
    public function testGetLexeme_ConstructedWithoutOffsets_ReturnsLexemeWithoutFinishOffsets(
        array $resultOffsets,
        array $expectedValue
    ): void {
        $result = new MatchFail(...$resultOffsets);
        self::assertSame($expectedValue, $result->getLexeme()->getFinishOffsets());
    }
}
