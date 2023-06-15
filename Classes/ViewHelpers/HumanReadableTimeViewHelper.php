<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_human_readable_time" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3HumanReadableTime\ViewHelpers;

use Ssch\T3HumanReadableTime\Contract\DateTimeFormatterInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

final class HumanReadableTimeViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    public function initializeArguments(): void
    {
        $this->registerArgument('languageKey', 'string', 'Language key ("dk" for example) or "default" to use for this translation. If this argument is empty, we use the current language');
        $this->registerArgument('from', \DateTimeInterface::class, 'Some date object', true);
        $this->registerArgument('to', \DateTimeInterface::class, 'Some date object');
    }

    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        return GeneralUtility::makeInstance(DateTimeFormatterInterface::class)->formatDiff(
            $arguments['from'],
            $arguments['to'],
            $arguments['languageKey']
        );
    }
}
