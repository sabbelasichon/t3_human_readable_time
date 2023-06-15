<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_human_readable_time" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3HumanReadableTime;

use Ssch\T3HumanReadableTime\Contract\TranslatorInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

final class ExtbaseLocalizationTranslator implements TranslatorInterface
{
    public function translate(string $key, array $arguments): string
    {
        $translation = LocalizationUtility::translate($key, 'T3HumanReadableTime', $arguments);

        if ($translation === null) {
            throw new \UnexpectedValueException(sprintf('No translation found for key "%s"', $key));
        }

        return $translation;
    }
}
