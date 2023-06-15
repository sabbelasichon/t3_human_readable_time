<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_human_readable_time" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3HumanReadableTime\Tests\Unit;

use DateTime;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Ssch\T3HumanReadableTime\DateTimeFormatter;
use Ssch\T3HumanReadableTime\TestTranslator;

final class DateTimeFormatterTest extends TestCase
{
    private DateTimeFormatter $subject;

    protected function setUp(): void
    {
        $this->subject = new DateTimeFormatter($this->createTranslator());
    }

    /**
     * @dataProvider provideFormatDiffs
     */
    public function testFormatDiff(string $fromString, ?string $toString, string $expected): void
    {
        $from = new DateTimeImmutable(date('Y-m-d H:i:s', (int) strtotime($fromString)));
        $to = $toString !== null ? new DateTime(date('Y-m-d H:i:s', (int) strtotime($toString))) : null;

        self::assertSame($expected, $this->subject->formatDiff($from, $to));
    }

    /**
     * @return \Generator<array<int, string|null>>
     */
    public static function provideFormatDiffs(): \Generator
    {
        yield ['- 5 years', 'now', 'diff.ago.year'];
        yield ['- 10 months', 'now', 'diff.ago.month'];
        yield ['- 15 days', 'now', 'diff.ago.day'];
        yield ['- 20 hours', 'now', 'diff.ago.hour'];
        yield ['- 25 minutes', 'now', 'diff.ago.minute'];
        yield ['- 30 seconds', 'now', 'diff.ago.second'];
        yield ['now', 'now', 'diff.empty'];
        yield ['+ 30 seconds', 'now', 'diff.in.second'];
        yield ['+ 25 minutes', 'now', 'diff.in.minute'];
        yield ['+ 20 hours', 'now', 'diff.in.hour'];
        yield ['+ 15 days', 'now', 'diff.in.day'];
        yield ['+ 10 months', 'now', 'diff.in.month'];
        yield ['+ 5 years', 'now', 'diff.in.year'];
        yield ['+ 5 years', null, 'diff.in.year'];
        yield ['now', null, 'diff.empty'];
    }

    private function createTranslator(): TestTranslator
    {
        return new TestTranslator();
    }
}
