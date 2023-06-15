<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_human_readable_time" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3HumanReadableTime\Formatter;

use DateTimeInterface;
use Ssch\T3HumanReadableTime\Contract\DateTimeFormatterInterface;
use Ssch\T3HumanReadableTime\Contract\TranslatorInterface;
use TYPO3\CMS\Extbase\Reflection\ObjectAccess;

final class DateTimeFormatter implements DateTimeFormatterInterface
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function formatDiff(DateTimeInterface $from, DateTimeInterface $to = null, string $locale = null): string
    {
        if ($to === null) {
            $to = new \DateTimeImmutable('now');
        }

        static $units = [
            'y' => 'year',
            'm' => 'month',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];

        $diff = $to->diff($from);

        foreach ($units as $attribute => $unit) {
            if (! ObjectAccess::isPropertyGettable($diff, $attribute)) {
                continue;
            }

            $count = ObjectAccess::getProperty($diff, $attribute);
            if (is_int($count) && $count !== 0) {
                return $this->doGetDiffMessage($count, (bool) $diff->invert, $unit, $locale);
            }
        }

        return $this->getEmptyDiffMessage();
    }

    public function transformToDateTimeObject($dateTime = null): DateTimeInterface
    {
        if ($dateTime instanceof DateTimeInterface) {
            return $dateTime;
        }

        if (is_string($dateTime)) {
            $dateTime = date('Y-m-d H:i:s', (int) strtotime($dateTime));
        }

        if (is_int($dateTime)) {
            $dateTime = date('Y-m-d H:i:s', $dateTime);
        }

        if ($dateTime === null) {
            $dateTime = 'now';
        }

        return new \DateTimeImmutable($dateTime);
    }

    private function doGetDiffMessage(int $count, bool $invert, string $unit, string $locale = null): string
    {
        $id = sprintf('diff.%s.%s.%s', $invert ? 'ago' : 'in', $unit, $count === 1 ? 'single' : 'plural');

        return $this->translator->translate($id, [
            '%count%' => $count,
        ], $locale);
    }

    private function getEmptyDiffMessage(): string
    {
        return $this->translator->translate('diff.empty', []);
    }
}
