<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_human_readable_time" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3HumanReadableTime\Contract;

interface TranslatorInterface
{
    /**
     * @param array<mixed> $arguments
     */
    public function translate(string $key, array $arguments, string $locale = null): string;
}
