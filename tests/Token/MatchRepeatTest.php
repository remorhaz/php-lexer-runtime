<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test\Token;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\Token\Exception\TokenNotReadyException;
use Remorhaz\Lexer\Runtime\Token\MatchRepeat;

/**
 * @covers \Remorhaz\Lexer\Runtime\Token\MatchRepeat
 */
class MatchRepeatTest extends TestCase
{

    public function testShoulRepeat_Constructed_ReturnsTrue(): void
    {
        $result = new MatchRepeat();
        self::assertTrue($result->shouldRepeat());
    }

    public function testHasToken_Constructed_ReturnsFalse(): void
    {
        $result = new MatchRepeat();
        self::assertFalse($result->hasToken());
    }

    public function testGetToken_Constructed_ThrowsException(): void
    {
        $result = new MatchRepeat();
        $this->expectException(TokenNotReadyException::class);
        $result->getToken();
    }

    public function testHasLexeme_Constructed_ReturnsFalse(): void
    {
        $result = new MatchRepeat();
        self::assertFalse($result->hasLexeme());
    }

    public function testGetLexeme_Constructed_ThrowsException(): void
    {
        $result = new MatchRepeat();
        $this->expectException(TokenNotReadyException::class);
        $result->getLexeme();
    }
}
