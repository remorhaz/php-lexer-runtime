<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\LexemeInterface;
use Remorhaz\Lexer\Runtime\Token\MatchSuccess;
use Remorhaz\Lexer\Runtime\Token\TokenInterface;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\MatchSuccess
 */
class MatchSuccessTest extends TestCase
{

    public function testShouldRepeat_Constructed_ReturnsFalse(): void
    {
        $result = new MatchSuccess($this->createMock(TokenInterface::class));
        self::assertFalse($result->shouldRepeat());
    }

    public function testHasToken_Constructed_ReturnsTrue(): void
    {
        $result = new MatchSuccess($this->createMock(TokenInterface::class));
        self::assertTrue($result->hasToken());
    }

    public function testGetToken_ConstructedWithToken_ReturnsSameInstance(): void
    {
        $token = $this->createMock(TokenInterface::class);
        $result = new MatchSuccess($token);
        self::assertSame($token, $result->getToken());
    }

    public function testHasLexeme_Constructed_ReturnsTrue(): void
    {
        $result = new MatchSuccess($this->createMock(TokenInterface::class));
        self::assertTrue($result->hasLexeme());
    }

    public function testGetLexeme_TokenWithLexeme_ReturnsSameLexemeInstance(): void
    {
        $lexeme = $this->createMock(LexemeInterface::class);
        $token = $this->createMock(TokenInterface::class);
        $token
            ->method('getLexeme')
            ->willReturn($lexeme);
        $result = new MatchSuccess($token);
        self::assertSame($lexeme, $result->getLexeme());
    }
}
