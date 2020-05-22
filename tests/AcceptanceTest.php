<?php

declare(strict_types=1);

namespace Remorhaz\Lexer\Runtime\Test;

use PHPUnit\Framework\TestCase;
use Remorhaz\Lexer\Runtime\IO\PreviewBufferInterface;
use Remorhaz\Lexer\Runtime\IO\StringInput;
use Remorhaz\Lexer\Runtime\Lexer;
use Remorhaz\Lexer\Runtime\Token\MatcherSelectorInterface;
use Remorhaz\Lexer\Runtime\Token\MatchFail;
use Remorhaz\Lexer\Runtime\Token\MatchRepeat;
use Remorhaz\Lexer\Runtime\Token\MatchResultInterface;
use Remorhaz\Lexer\Runtime\Token\MatchSuccess;
use Remorhaz\Lexer\Runtime\Token\Token;
use Remorhaz\Lexer\Runtime\Token\TokenInterface;
use Remorhaz\Lexer\Runtime\Token\TokenMatcherInterface;

use function ord;

/**
 * @coversNothing
 */
class AcceptanceTest extends TestCase
{

    public const TOKEN_A = 0x01;
    public const TOKEN_B = 0x02;
    public const TOKEN_EOI = 0xFF;

    /**
     * @param string $inputText
     * @param array  $expectedValue
     * @dataProvider providerLexerMatchesTokens
     */
    public function testLexerMatchesTokensCorrectly(string $inputText, array $expectedValue): void
    {
        $matcherA = $this->createMatcherA();
        $matcherB = $this->createMatcherB();
        $lexer = new Lexer(['a' => $matcherA, 'b' => $matcherB]);
        $input = new StringInput($inputText);
        $tokenReader = $lexer->createTokenReader($input);
        $tokens = [];
        while (!$tokenReader->isFinished()) {
            $tokens[] = $tokenReader->read();
        }

        self::assertSame($expectedValue, $this->exportTokens(...$tokens));
    }

    public function providerLexerMatchesTokens(): array
    {
        return [
            'A' => [
                'a',
                [
                    ['id' => self::TOKEN_A, 'offset' => 0],
                    ['id' => self::TOKEN_EOI, 'offset' => 1],
                ],
            ],
            'B' => [
                'b',
                [
                    ['id' => self::TOKEN_B, 'offset' => 0],
                    ['id' => self::TOKEN_EOI, 'offset' => 1],
                ],
            ],
            'AB' => [
                'aab',
                [
                    ['id' => self::TOKEN_A, 'offset' => 0],
                    ['id' => self::TOKEN_B, 'offset' => 1],
                    ['id' => self::TOKEN_EOI, 'offset' => 2],
                ],
            ],
            'BA' => [
                'baa',
                [
                    ['id' => self::TOKEN_B, 'offset' => 0],
                    ['id' => self::TOKEN_A, 'offset' => 1],
                    ['id' => self::TOKEN_EOI, 'offset' => 2],
                ],
            ],
        ];
    }

    private function createMatcherA(): TokenMatcherInterface
    {
        return new class implements TokenMatcherInterface {

            public function match(
                int $offset,
                PreviewBufferInterface $input,
                MatcherSelectorInterface $selector
            ): MatchResultInterface {
                if ($input->isFinished()) {
                    goto error;
                }
                $code = $input->getPreviewSymbol()->getCode();
                if (ord('a') == $code) {
                    goto state1;
                }
                if (ord('b') == $code) {
                    $selector->setMatcher('b');

                    return new MatchRepeat();
                }
                goto error;

                state1:
                $input->previewNext();
                if ($input->isFinished()) {
                    goto state2;
                }
                $code = $input->getPreviewSymbol()->getCode();
                if (ord('a') == $code) {
                    goto state1;
                }
                if (ord('b') == $code) {
                    $selector->setMatcher('b');
                    goto state2;
                }
                goto error;

                state2:

                return new MatchSuccess(
                    new Token(AcceptanceTest::TOKEN_A, $offset, $input->acceptLexeme())
                );

                error:

                return new MatchFail($offset, ...$input->getEmptyLexeme()->getStartOffsets());
            }

            public function createFinishToken(int $offset, PreviewBufferInterface $input): TokenInterface
            {
                return new Token(AcceptanceTest::TOKEN_EOI, $offset, $input->getEmptyLexeme());
            }
        };
    }

    private function createMatcherB(): TokenMatcherInterface
    {
        return new class implements TokenMatcherInterface {

            public function match(
                int $offset,
                PreviewBufferInterface $input,
                MatcherSelectorInterface $selector
            ): MatchResultInterface {
                if ($input->isFinished()) {
                    $selector->restoreMatcher();

                    return new MatchRepeat();
                }
                $code = $input->getPreviewSymbol()->getCode();
                if (ord('b') == $code) {
                    goto state1;
                }
                $selector->restoreMatcher();

                return new MatchRepeat();

                state1:
                $input->previewNext();
                if ($input->isFinished()) {
                    goto state2;
                }
                $code = $input->getPreviewSymbol()->getCode();
                if (ord('b') == $code) {
                    goto state1;
                }

                state2:
                $selector->restoreMatcher();

                return new MatchSuccess(
                    new Token(AcceptanceTest::TOKEN_B, $offset, $input->acceptLexeme())
                );
            }

            public function createFinishToken(int $offset, PreviewBufferInterface $input): TokenInterface
            {
                throw new \RuntimeException("This matcher cannot create finish tokens");
            }
        };
    }

    private function exportToken(TokenInterface $token): array
    {
        return [
            'id' => $token->getId(),
            'offset' => $token->getOffset(),
        ];
    }

    private function exportTokens(TokenInterface ...$tokens): array
    {
        return \array_map([$this, 'exportToken'], $tokens);
    }
}
