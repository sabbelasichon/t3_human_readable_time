<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_human_readable_time" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Ssch\T3HumanReadableTime\Contract\DateTimeFormatterInterface;
use Ssch\T3HumanReadableTime\Contract\TranslatorInterface;
use Ssch\T3HumanReadableTime\DateTimeFormatter;
use Ssch\T3HumanReadableTime\ExtbaseLocalizationTranslator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->private()
        ->autowire()
        ->autoconfigure();

    $services->load('Ssch\\T3HumanReadableTime\\', __DIR__ . '/../Classes/');

    $services->alias(TranslatorInterface::class, ExtbaseLocalizationTranslator::class);
    $services->alias(DateTimeFormatterInterface::class, DateTimeFormatter::class)->public();
};
