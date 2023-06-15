<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_human_readable_time" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3HumanReadableTime\Tests\Unit;

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
        $to = $toString !== null ? new DateTimeImmutable(date('Y-m-d H:i:s', (int) strtotime($toString))) : null;

        self::assertSame($expected, $this->subject->formatDiff($from, $to));
    }

    /**
     * @return \Generator<array<int, string|null>>
     */
    public static function provideFormatDiffs(): \Generator
    {
        yield ['- 5 years', 'now', 'diff.ago.year.plural'];
        yield ['- 1 year', 'now', 'diff.ago.year.single'];
        yield ['- 10 months', 'now', 'diff.ago.month.plural'];
        yield ['- 15 days', 'now', 'diff.ago.day.plural'];
        yield ['- 20 hours', 'now', 'diff.ago.hour.plural'];
        yield ['- 25 minutes', 'now', 'diff.ago.minute.plural'];
        yield ['- 30 seconds', 'now', 'diff.ago.second.plural'];
        yield ['now', 'now', 'diff.empty'];
        yield ['+ 30 seconds', 'now', 'diff.in.second.plural'];
        yield ['+ 25 minutes', 'now', 'diff.in.minute.plural'];
        yield ['+ 20 hours', 'now', 'diff.in.hour.plural'];
        yield ['+ 15 days', 'now', 'diff.in.day.plural'];
        yield ['+ 10 months', 'now', 'diff.in.month.plural'];
        yield ['+ 5 years', 'now', 'diff.in.year.plural'];
        yield ['+ 5 years', null, 'diff.in.year.plural'];
        yield ['now', null, 'diff.empty'];
    }

    private function createTranslator(): TestTranslator
    {
        return new TestTranslator();
    }
}
