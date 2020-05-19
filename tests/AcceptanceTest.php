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

    public function testLexerMatchesTokensCorrecty(): void
    {
        $matcherA = $this->createMatcherA();
        $matcherB = $this->createMatcherB();
        $lexer = new Lexer(['a' => $matcherA, 'b' => $matcherB]);
        $input = new StringInput('aab');
        $tokenReader = $lexer->createTokenReader($input);
        $tokens = [];
        while (!$tokenReader->isFinished()) {
            $tokens[] = $tokenReader->read();
        }

        $expectedValue = [
            ['id' => self::TOKEN_A, 'offset' => 0],
            ['id' => self::TOKEN_B, 'offset' => 1],
            ['id' => self::TOKEN_EOI, 'offset' => 2],
        ];
        self::assertSame($expectedValue, $this->exportTokens(...$tokens));
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
                $symbol = $input->getPreviewSymbol();
                if (ord('a') == $symbol->getCode()) {
                    goto state1;
                }
                if (ord('b') == $symbol->getCode()) {
                    $selector->setMatcher('b');

                    return new MatchRepeat();
                }
                goto error;

                state1:
                $input->previewNext();
                if ($input->isFinished()) {
                    goto state2;
                }
                $symbol = $input->getPreviewSymbol();
                if (ord('a') == $symbol->getCode()) {
                    goto state1;
                }
                if (ord('b') == $symbol->getCode()) {
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
                $symbol = $input->getPreviewSymbol();
                if (ord('b') == $symbol->getCode()) {
                    goto state1;
                }
                $selector->restoreMatcher();

                return new MatchRepeat();

                state1:
                $input->previewNext();
                if ($input->isFinished()) {
                    goto state2;
                }
                if (ord('b') == $symbol->getCode()) {
                    goto state1;
                }
                $input->previewPrevious();

                state2:
                $selector->restoreMatcher();

                return new MatchSuccess(
                    new Token(AcceptanceTest::TOKEN_B, $offset, $input->acceptLexeme())
                );
            }

            public function createFinishToken(int $offset, PreviewBufferInterface $input): TokenInterface
            {
                throw new \RuntimeException("");
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
