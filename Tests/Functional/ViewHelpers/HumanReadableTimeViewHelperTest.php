<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_human_readable_time" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3HumanReadableTime\Tests\Functional\ViewHelpers;

use Ssch\T3HumanReadableTime\Contract\DateTimeFormatterInterface;
use TYPO3\CMS\Core\Localization\LanguageServiceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\TestingFramework\Core\Functional\FunctionalTestCase;

final class HumanReadableTimeViewHelperTest extends FunctionalTestCase
{
    private DateTimeFormatterInterface $datetimeFormatter;

    protected function setUp(): void
    {
        $this->testExtensionsToLoad = ['typo3conf/ext/t3_human_readable_time'];
        parent::setUp();
        $this->datetimeFormatter = $this->get(DateTimeFormatterInterface::class);
        $GLOBALS['LANG'] = GeneralUtility::makeInstance(LanguageServiceFactory::class)->create('default');
    }

    /**
     * @dataProvider provideFormatDiffs
     */
    public function testFormatDiff(string $fromString, ?string $toString, string $expected): void
    {
        // Arrange
        $from = $this->datetimeFormatter->transformToDateTimeObject($fromString);
        $to = $this->datetimeFormatter->transformToDateTimeObject($toString);

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->assignMultiple([
            'from' => $from,
            'to' => $to,
        ]);
        $view->setTemplateSource(
            '{namespace time=Ssch\T3HumanReadableTime\ViewHelpers}' . LF .
            '<time:humanReadableTime from="{from}" to="{to}" />'
        );

        // Assert
        self::assertSame(trim($expected), trim($view->render()));
    }

    public function testFormatDiffWithExplicitLocale(): void
    {
        // Arrange
        $from = $this->datetimeFormatter->transformToDateTimeObject('- 5 years');
        $to = $this->datetimeFormatter->transformToDateTimeObject('now');

        $view = GeneralUtility::makeInstance(StandaloneView::class);
        $view->assignMultiple([
            'from' => $from,
            'to' => $to,
        ]);
        $view->setTemplateSource(
            '{namespace time=Ssch\T3HumanReadableTime\ViewHelpers}' . LF .
            '<time:humanReadableTime from="{from}" to="{to}" languageKey="de" />'
        );

        // Assert
        self::assertSame(trim('vor 5 Jahren'), trim($view->render()));
    }

    /**
     * @return \Generator<array<int, string|null>>
     */
    public static function provideFormatDiffs(): \Generator
    {
        yield ['- 5 years', 'now', '5 years ago'];
        yield ['- 1 year', 'now', '1 year ago'];
        yield ['- 10 months', 'now', '10 months ago'];
        yield ['- 15 days', 'now', '15 days ago'];
        yield ['- 20 hours', 'now', '20 hours ago'];
        yield ['- 25 minutes', 'now', '25 minutes ago'];
        yield ['- 30 seconds', 'now', '30 seconds ago'];
        yield ['now', 'now', 'now'];
        yield ['+ 30 seconds', 'now', 'in 30 seconds'];
        yield ['+ 25 minutes', 'now', 'in 25 minutes'];
        yield ['+ 20 hours', 'now', 'in 20 hours'];
        yield ['+ 15 days', 'now', 'in 15 days'];
        yield ['+ 10 months', 'now', 'in 10 months'];
        yield ['+ 5 years', 'now', 'in 5 years'];
        yield ['+ 5 years', null, 'in 4 years'];
        yield ['now', null, 'now'];
    }
}
